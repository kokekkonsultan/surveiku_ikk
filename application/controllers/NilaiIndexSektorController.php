<?php
defined('BASEPATH') or exit('No direct script access allowed');

require 'application/core/Klien_Controller.php';
use application\core\Klien_Controller;

class NilaiIndexSektorController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('ion_auth');

        if (!$this->ion_auth->logged_in()) {
            $this->session->set_flashdata('message_warning', 'You must be logged in to access this page');
            redirect('auth', 'refresh');
        }
    }


    public function index($id1, $id2)
    {
        $this->data = [];
        $this->data['title'] = 'Nilai Index Sektor';
        $profiles = new Klien_Controller();
        $this->data['profiles'] = $profiles->_get_data_profile($id1, $id2);
        $this->data['table_identity'] = $this->data['profiles']->table_identity;


        $this->data['sektor'] = $this->db->get("sektor_" . $this->data['table_identity']);


        return view('nilai_index_sektor/index', $this->data);
    }


    public function detail()
    {
        $this->data = [];
        $id_sektor = $this->uri->segment(4);

        $this->data['manage_survey'] = $this->db->get_where('manage_survey', ['slug' => $this->uri->segment(2)])->row();
        $table_identity = $this->data['manage_survey']->table_identity;

        $this->data['sektor'] = $this->db->get_where("sektor_$table_identity", array('id' => $id_sektor))->row();

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
            $this->data['ikk'] = array_sum($total);
        }


        return view('nilai_index_sektor/detail', $this->data);
    }
}