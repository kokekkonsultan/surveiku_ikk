<?php
defined('BASEPATH') or exit('No direct script access allowed');

class OlahDataKeseluruhanController extends CI_Controller
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

    public function index()
    {
        $this->data = [];
        $this->data['title'] = 'Olah Data';


        $klien_induk = $this->db->get_where("pengguna_klien_induk", array('id_user' => $this->session->userdata('user_id')))->row();
        $parent = implode(", ", unserialize($klien_induk->cakupan_induk));


        $data_skor = [];
        $data_survei = [];
        foreach ($this->db->query("SELECT * FROM manage_survey WHERE id IN ($parent)")->result() as $key => $value) {

            $data_skor[$key] = "UNION ALL
                            SELECT *
                            FROM (SELECT *, (SELECT is_submit FROM survey_$value->table_identity WHERE survey_$value->table_identity.id = jawaban_pertanyaan_unsur_$value->table_identity.id_survey) AS is_submit FROM jawaban_pertanyaan_unsur_$value->table_identity) jpu_$value->table_identity
                            WHERE is_submit = 1";

            $data_survei[$key] = "UNION ALL
                            SELECT * FROM survey_$value->table_identity WHERE is_submit = 1";
        }
        $union_skor = implode(" ", $data_skor);
        $union_survei = implode(" ", $data_survei);

        //PER PERTANYAAN
        $this->data['total_nilai_unsur'] = $this->db->query("SELECT
        id_pertanyaan_unsur,
        SUM(skor_jawaban) AS total_nilai,
        AVG(skor_jawaban) AS rata_nilai,
        ((SELECT persentase_unsur FROM pertanyaan_unsur JOIN unsur ON pertanyaan_unsur.id_unsur = unsur.id WHERE pertanyaan_unsur.id = prt.id_pertanyaan_unsur) / 100) AS persentase_unsur_dibagi_100,
        (AVG(skor_jawaban) * ((SELECT persentase_unsur FROM pertanyaan_unsur JOIN unsur ON pertanyaan_unsur.id_unsur = unsur.id WHERE pertanyaan_unsur.id = prt.id_pertanyaan_unsur) / 100)) AS persen_per_unsur

        FROM (SELECT *, null AS is_submit
            FROM jawaban_pertanyaan_unsur
            $union_skor) prt
            GROUP BY id_pertanyaan_unsur");
        // var_dump($this->data['total_nilai_unsur']->result());


        //PER DIMENSI
        $this->data['total_nilai_dimensi'] = $this->db->query("SELECT
        id_dimensi,
        SUM(skor_jawaban) AS total_nilai,
        AVG(skor_jawaban) AS rata_nilai,
        COUNT(prt.id) AS total_dimensi_per_pertanyaan,
        (SELECT COUNT(uuid)
        FROM (SELECT * FROM survey WHERE is_submit = 1 $union_survei) srv) AS jumlah_survei,
        (COUNT(prt.id) / (SELECT COUNT(uuid)
        FROM (SELECT * FROM survey WHERE is_submit = 1 $union_survei) srv)) AS jumlah_dimensi_per_pertanyaan

        FROM (SELECT *, null AS is_submit
            FROM jawaban_pertanyaan_unsur
            $union_skor) prt

            JOIN pertanyaan_unsur ON prt.id_pertanyaan_unsur = pertanyaan_unsur.id
            JOIN unsur ON pertanyaan_unsur.id_unsur = unsur.id
            GROUP BY id_dimensi");
        // var_dump($this->data['total_nilai_dimensi']->result());

        $this->data['cek_survey'] = $this->db->query("SELECT *
        FROM (SELECT * FROM survey WHERE is_submit = 1 $union_survei) srv");

        // var_dump($cek_survey->num_rows());


        return view('olah_data_keseluruhan/index', $this->data);
    }
}
