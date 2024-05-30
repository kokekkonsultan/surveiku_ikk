<?php
defined('BASEPATH') or exit('No direct script access allowed');


class NilaiIndexKeseluruhanController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('ion_auth');

        if (!$this->ion_auth->logged_in()) {
            $this->session->set_flashdata('message_warning', 'You must be logged in to access this page');
            redirect('auth', 'refresh');
        }

        $this->load->model('DataPerolehanPerBagian_model', 'models');
    }


    public function index()
    {
        $this->data = [];
        $this->data['title'] = 'Nilai Index Keseluruhan';

        $klien_induk = $this->db->get_where("pengguna_klien_induk", array('id_user' => $this->session->userdata('user_id')))->row();
        $parent = implode(", ", unserialize($klien_induk->cakupan_induk));
        $manage_survey = $this->db->query("SELECT * FROM manage_survey WHERE id IN ($parent)")->last_row();
        $this->data['parent'] = $parent;

        $this->data['sektor'] = $this->db->get("sektor_$manage_survey->table_identity");


        return view('nilai_index_keseluruhan/index', $this->data);
    }



    public function detail()
    {
        $this->data = [];
        $this->data['title'] = 'Nilai Index Keseluruhan';

        $klien_induk = $this->db->get_where("pengguna_klien_induk", array('id_user' => $this->session->userdata('user_id')))->row();
        $parent = implode(", ", unserialize($klien_induk->cakupan_induk));
        $manage_survey = $this->db->query("SELECT * FROM manage_survey WHERE id IN ($parent)")->last_row();


        $this->data['sektor'] = $this->db->get_where("sektor_$manage_survey->table_identity", array('id' => $this->uri->segment(2)))->row();


        return view('nilai_index_keseluruhan/detail', $this->data);
    }

    public function ajax_list()
    {
        $id_sektor = $this->uri->segment(3);
        $klien_induk = $this->db->get_where("pengguna_klien_induk", array('id_user' => $this->session->userdata('user_id')))->row();
        $parent = implode(", ", unserialize($klien_induk->cakupan_induk));


        $list = $this->models->get_datatables($parent);
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $value) {

            $olah_data = $this->db->query("
            SELECT kode_unsur, 
            (SELECT unsur_$value->table_identity.persentase_unsur / 100) AS persentase_unsur,

            (SELECT AVG(skor_jawaban) FROM jawaban_pertanyaan_unsur_$value->table_identity 
            JOIN survey_$value->table_identity ON jawaban_pertanyaan_unsur_$value->table_identity.id_survey = survey_$value->table_identity.id
            JOIN responden_$value->table_identity ON survey_$value->table_identity.id_responden = responden_$value->table_identity.id
            WHERE id_pertanyaan_unsur = pertanyaan_unsur_$value->table_identity.id && is_submit = 1 && sektor = $id_sektor) AS rata_per_unsur,
            
            ((SELECT AVG(skor_jawaban) FROM jawaban_pertanyaan_unsur_$value->table_identity
            JOIN survey_$value->table_identity ON jawaban_pertanyaan_unsur_$value->table_identity.id_survey = survey_$value->table_identity.id
            JOIN responden_$value->table_identity ON survey_$value->table_identity.id_responden = responden_$value->table_identity.id
            WHERE id_pertanyaan_unsur = pertanyaan_unsur_$value->table_identity.id && is_submit = 1 && sektor = $id_sektor) * (unsur_$value->table_identity.persentase_unsur / 100)) AS persen_per_unsur
            
            FROM pertanyaan_unsur_$value->table_identity
            JOIN unsur_$value->table_identity ON pertanyaan_unsur_$value->table_identity.id_unsur = unsur_$value->table_identity.id");

            $total = [];
            $ikk = 0;
            foreach ($olah_data->result() as $get) {
                $total[] = $get->persen_per_unsur;
                $ikk = array_sum($total) * 20;
            }

            if ($ikk <= 20) {
                $mutu = 'Sadar';
            } elseif ($ikk > 20 && $ikk <= 40) {
                $mutu = 'Paham';
            } elseif ($ikk > 40 && $ikk <= 60) {
                $mutu = 'Mampu';
            } elseif ($ikk > 60 && $ikk <= 80) {
                $mutu = 'Kritis';
            } elseif ($ikk > 80) {
                $mutu = 'Berdaya';
            } else {
                $mutu = NULL;
            }


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<span class="text-primary font-weight-bold">' . $value->first_name . ' ' . $value->last_name . '</span> (' . $value->survey_name . ')';
            $row[] = ROUND($ikk, 3);
            $row[] = $mutu;
            $row[] = '<a class="btn btn-light-info btn-sm shadow font-weight-bold" data-toggle="modal"
            onclick="showedit(' . $value->id . ')" href="#modal_detail"><i
                class="fa fa-info-circle"></i> Detail</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->models->count_all($parent),
            "recordsFiltered" => $this->models->count_filtered($parent),
            "data" => $data,
        );
        echo json_encode($output);
    }



    public function tabulasi()
    {
        $this->data = [];
        $id_sektor = $this->uri->segment(2);


        $this->db->select('*, manage_survey.slug AS slug_manage_survey, (SELECT first_name FROM users WHERE users.id = manage_survey.id_user) AS first_name, (SELECT last_name FROM users WHERE users.id = manage_survey.id_user) AS last_name');
        $this->db->from('manage_survey');
        $this->db->where("id", $this->uri->segment(3));
        $this->data['manage_survey'] = $this->db->get()->row();
        $table_identity = $this->data['manage_survey']->table_identity;


        // $this->data['sektor'] = $this->db->get_where("sektor_$table_identity", array('id' => $id_sektor))->row();

        $this->data['jumlah_kuesioner_terisi'] = $this->db->query("SELECT COUNT(id_responden) AS total_kuesioner
        FROM survey_$table_identity
        JOIN responden_$table_identity ON survey_$table_identity.id_responden = responden_$table_identity.id WHERE is_submit = 1 && sektor = $id_sektor")->row()->total_kuesioner;


        $this->data['unsur']  = $this->db->query("SELECT *, SUBSTR(kode_unsur, 2) AS kode_alasan FROM unsur_$table_identity");

        $this->data['total_nilai_unsur'] = $this->db->query("SELECT *, (SELECT SUM(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity 
        JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey = survey_$table_identity.id
        JOIN responden_$table_identity ON survey_$table_identity.id_responden = responden_$table_identity.id
        WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && is_submit = 1 && sektor = $id_sektor) AS total_nilai_unsur
        FROM pertanyaan_unsur_$table_identity");

        $this->data['rata_rata_per_unsur'] = $this->db->query("SELECT *, (SELECT AVG(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity 
        JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey = survey_$table_identity.id
        JOIN responden_$table_identity ON survey_$table_identity.id_responden = responden_$table_identity.id
        WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && is_submit = 1 && sektor = $id_sektor) AS rata_per_unsur
        FROM pertanyaan_unsur_$table_identity");


        $this->data['rata_rata_per_dimensi'] = $this->db->query("SELECT 
        (SELECT SUM(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity
        JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey = survey_$table_identity.id
        JOIN responden_$table_identity ON survey_$table_identity.id_responden = responden_$table_identity.id
        JOIN pertanyaan_unsur_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id
        JOIN unsur_$table_identity ON pertanyaan_unsur_$table_identity.id_unsur = unsur_$table_identity.id
        WHERE id_dimensi = dimensi_$table_identity.id && is_submit = 1 && sektor = $id_sektor) AS jumlah_per_dimensi,
        
        (SELECT COUNT(id) FROM unsur_$table_identity WHERE id_dimensi = dimensi_$table_identity.id) AS jumlah_unsur,
        
        (((SELECT SUM(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity
        JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey = survey_$table_identity.id
        JOIN responden_$table_identity ON survey_$table_identity.id_responden = responden_$table_identity.id
        JOIN pertanyaan_unsur_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id
        JOIN unsur_$table_identity ON pertanyaan_unsur_$table_identity.id_unsur = unsur_$table_identity.id
        WHERE id_dimensi = dimensi_$table_identity.id && is_submit = 1 && sektor = $id_sektor) / (SELECT COUNT(id_responden) FROM survey_$table_identity JOIN responden_$table_identity ON survey_$table_identity.id_responden = responden_$table_identity.id WHERE is_submit = 1 && sektor = $id_sektor)) / (SELECT COUNT(id) FROM unsur_$table_identity WHERE id_dimensi = dimensi_$table_identity.id)) AS rata_per_dimensi
        
        FROM dimensi_$table_identity");


        $this->data['rata_rata_per_unsur_x_bobot'] = $this->db->query("SELECT kode_unsur, persentase_unsur, (SELECT AVG(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity
        JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey = survey_$table_identity.id
        JOIN responden_$table_identity ON survey_$table_identity.id_responden = responden_$table_identity.id
        WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && is_submit = 1 && sektor = $id_sektor) AS rata_per_unsur,
        
        (SELECT unsur_$table_identity.persentase_unsur / 100) AS persentase_unsur_dibagi_100,
        
        ((SELECT AVG(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity
        JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey = survey_$table_identity.id
        JOIN responden_$table_identity ON survey_$table_identity.id_responden = responden_$table_identity.id
        WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && is_submit = 1 && sektor = $id_sektor) * (unsur_$table_identity.persentase_unsur / 100)) AS persen_per_unsur
        
        FROM pertanyaan_unsur_$table_identity
        JOIN unsur_$table_identity ON pertanyaan_unsur_$table_identity.id_unsur = unsur_$table_identity.id");


        foreach ($this->data['rata_rata_per_unsur_x_bobot']->result() as $rows) {
            $total[] = $rows->persen_per_unsur;
            $this->data['ikk'] = array_sum($total) * 20;
        }


        return view('nilai_index_keseluruhan/form_modal_tabulasi', $this->data);
    }
}
