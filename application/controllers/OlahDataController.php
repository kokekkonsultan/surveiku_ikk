<?php
defined('BASEPATH') or exit('No direct script access allowed');

class OlahDataController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('ion_auth');

        if (!$this->ion_auth->logged_in()) {
            $this->session->set_flashdata('message_warning', 'You must be logged in to access this page');
            redirect('auth', 'refresh');
        }

        $this->load->library('form_validation');
        $this->load->model('OlahData_model', 'models');
        $this->load->model('OlahData_model');
    }

    public function index($id1, $id2)
    {
        $this->data = [];
        $this->data['title'] = 'Olah Data';
        $this->data['profiles'] = $this->_get_data_profile($id1, $id2);

        $slug = $this->uri->segment(2);

        $get_identity = $this->db->get_where('manage_survey', ['slug' => "$slug"])->row();
        $table_identity = $get_identity->table_identity;

        $this->data['jumlah_kuesioner_terisi'] = $this->db->query("SELECT COUNT(id) AS total_kuesioner
        FROM survey_$table_identity WHERE is_submit = 1")->row()->total_kuesioner;

        if ($this->data['jumlah_kuesioner_terisi'] == 0) {
            $this->data['pesan'] = 'Survei belum dimulai atau belum ada responden !';
            return view('not_questions/index', $this->data);
        }

        $this->data['unsur']  = $this->db->query("SELECT *, SUBSTR(kode_unsur, 2) AS kode_alasan FROM unsur_$table_identity");

        $this->data['total_nilai_unsur'] = $this->db->query("SELECT *, (SELECT SUM(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity 
        JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey = survey_$table_identity.id
        WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && is_submit = 1) AS total_nilai_unsur
        FROM pertanyaan_unsur_$table_identity");

        $this->data['rata_rata_per_unsur'] = $this->db->query("SELECT *, (SELECT AVG(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity 
        JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey = survey_$table_identity.id
        WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && is_submit = 1) AS rata_per_unsur
        FROM pertanyaan_unsur_$table_identity");


        $this->data['rata_rata_per_dimensi'] = $this->db->query("SELECT *, (SELECT SUM(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity
        JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey = survey_$table_identity.id
        JOIN pertanyaan_unsur_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id
        JOIN unsur_$table_identity ON pertanyaan_unsur_$table_identity.id_unsur = unsur_$table_identity.id
        WHERE id_dimensi = dimensi_$table_identity.id && is_submit = 1) AS jumlah_per_dimensi,

        (SELECT COUNT(id) FROM unsur_$table_identity WHERE id_dimensi = dimensi_$table_identity.id) AS jumlah_unsur,

        ( ((SELECT SUM(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity
        JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey = survey_$table_identity.id
        JOIN pertanyaan_unsur_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id
        JOIN unsur_$table_identity ON pertanyaan_unsur_$table_identity.id_unsur = unsur_$table_identity.id
        WHERE id_dimensi = dimensi_$table_identity.id && is_submit = 1) / (SELECT COUNT(id) FROM survey_$table_identity WHERE is_submit = 1)) / (SELECT COUNT(id) FROM unsur_$table_identity WHERE id_dimensi = dimensi_$table_identity.id)) AS rata_per_dimensi

        FROM dimensi_$table_identity");


        $this->data['rata_rata_per_unsur_x_bobot'] = $this->db->query("SELECT kode_unsur, persentase_unsur, (SELECT AVG(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity
        JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey = survey_$table_identity.id
        WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && is_submit = 1) AS rata_per_unsur,
        
        (SELECT unsur_$table_identity.persentase_unsur / 100) AS persentase_unsur_dibagi_100,
        
        ((SELECT AVG(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity
        JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey = survey_$table_identity.id
        WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && is_submit = 1) * (unsur_$table_identity.persentase_unsur / 100)) AS persen_per_unsur
        
        FROM pertanyaan_unsur_$table_identity
        JOIN unsur_$table_identity ON pertanyaan_unsur_$table_identity.id_unsur = unsur_$table_identity.id");

        foreach ($this->data['rata_rata_per_unsur_x_bobot']->result() as $rows) {
            $total[] = $rows->persen_per_unsur;
            $this->data['ikk'] = array_sum($total);
        }

        // var_dump($total_biaya);

        return view('olah_data/index', $this->data);
    }

    public function ajax_list()
    {
        $slug = $this->uri->segment(2);

        $get_identity = $this->db->get_where('manage_survey', ['slug' => "$slug"])->row();
        $id_manage_survey = $get_identity->id;

        $jawaban_unsur = $this->db->get("jawaban_pertanyaan_unsur_cst$id_manage_survey");

        $list = $this->models->get_datatables($id_manage_survey);
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $value) {

            if ($value->is_submit == 1) {
                $status = '<span class="badge badge-primary">Valid</span>';
            } else {
                $status = '<span class="badge badge-danger">Tidak Valid</span>';
            }

            $no++;
            $row = array();
            $row[] = $no;
            // $row[] = $status;
            // $row[] = '<b>' . $value->kode_surveyor . '</b>--' . $value->first_name . ' ' . $value->last_name;
            $row[] = $value->nama_lengkap;

            foreach ($jawaban_unsur->result() as $get_unsur) {
                if ($get_unsur->id_survey == $value->id_survey) {
                    $row[] = $get_unsur->skor_jawaban;
                }
            }

            foreach ($jawaban_unsur->result() as $get_unsur) {
                if ($get_unsur->id_survey == $value->id_survey) {
                    $row[] = $get_unsur->alasan_pilih_jawaban;
                }
            }

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->models->count_all($id_manage_survey),
            "recordsFiltered" => $this->models->count_filtered($id_manage_survey),
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function _get_data_profile($id1, $id2)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->join('users_groups', 'users.id = users_groups.user_id');
        $this->db->where('users.username', $this->session->userdata('username'));
        $data_user = $this->db->get()->row();
        $user_identity = 'drs' . $data_user->is_parent;

        $this->db->select('users.username, manage_survey.survey_name, manage_survey.slug, manage_survey.description, manage_survey.is_privacy, manage_survey.table_identity, manage_survey.atribut_pertanyaan_survey');
        if ($data_user->group_id == 2) {
            $this->db->from('users');
            $this->db->join('manage_survey', 'manage_survey.id_user = users.id');
        } else {
            $this->db->from('manage_survey');
            $this->db->join("supervisor_$user_identity", "manage_survey.id_berlangganan = supervisor_$user_identity.id_berlangganan");
            $this->db->join("users", "supervisor_$user_identity.id_user = users.id");
        }
        $this->db->where('users.username', $id1);
        $this->db->where('manage_survey.slug', $id2);
        $profiles = $this->db->get();

        if ($profiles->num_rows() == 0) {
            // echo 'Survey tidak ditemukan atau sudah dihapus !';
            // exit();
            show_404();
        }
        return $profiles->row();
    }
}