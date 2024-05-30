<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DraftKuesionerController extends CI_Controller
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

    public function index()
    {
        $this->data = [];
        $this->data['title'] = 'Draf Kuesioner';
    }
    public function cetak()
    {
        $this->data = [];
        $this->data['title'] = 'Draf Kuesioner';

        $this->db->select("*, DATE_FORMAT(survey_end, '%d %M %Y') AS survey_selesai, IF(CURDATE() > survey_end,1,NULL) AS survey_berakhir, IF(CURDATE() < survey_start ,1,NULL) AS survey_belum_mulai");
        $this->db->from('manage_survey');
        $this->db->where('manage_survey.slug', $this->uri->segment(2));
        $this->data['manage_survey'] = $this->db->get()->row();
        $manage_survey = $this->data['manage_survey'];
        $this->data['manage_survey'] = $manage_survey;
        $table_identity = $manage_survey->table_identity;

        $this->data['data_user'] = $this->db->get_where('users', array('id' => $manage_survey->id_user))->row();

        $this->data['profil_responden'] = $this->db->query("SELECT * FROM profil_responden_$table_identity ORDER BY IF(urutan != '',urutan,id) ASC")->result();

        $this->data['tahapan_pembelian'] = $this->db->query("SELECT * FROM tahapan_pembelian_$table_identity");

        $this->data['dimensi'] = $this->db->query("SELECT * FROM dimensi_$table_identity");

        $this->data['pertanyaan'] = $this->db->query("SELECT id_unsur, id_dimensi, kode_unsur, pertanyaan_unsur_$table_identity.id AS id_pertanyaan_unsur, isi_pertanyaan, (SELECT nama_jawaban FROM nilai_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && nilai_jawaban = 1) AS jawaban_1,
        (SELECT nama_jawaban FROM nilai_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && nilai_jawaban = 2) AS jawaban_2,
        (SELECT nama_jawaban FROM nilai_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && nilai_jawaban = 3) AS jawaban_3,
        (SELECT nama_jawaban FROM nilai_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && nilai_jawaban = 4) AS jawaban_4,
        (SELECT nama_jawaban FROM nilai_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && nilai_jawaban = 5) AS jawaban_5
        FROM pertanyaan_unsur_$table_identity
        JOIN unsur_$table_identity ON pertanyaan_unsur_$table_identity.id_unsur = unsur_$table_identity.id");

        $this->data['pertanyaan_terbuka'] = $this->db->query("SELECT * FROM pertanyaan_terbuka_$table_identity");

        $this->load->library('pdfgenerator');
        $this->data['title_pdf'] = 'draft-kuesioner-' . $this->uri->segment(2);
        $file_pdf = 'draft-kuesioner-' . $this->uri->segment(2);
        $paper = 'A4';
        $orientation = "potrait";

        $html = $this->load->view('draft_kuesioner/cetak', $this->data, true);

        $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    }

    public function _get_data_profile($id1, $id2)
    {
        $this->db->select('users.username, manage_survey.survey_name, manage_survey.slug, manage_survey.description, manage_survey.is_privacy');
        $this->db->from('users');
        $this->db->join('manage_survey', 'manage_survey.id_user = users.id');
        $this->db->where('users.username', $id1);
        $this->db->where('manage_survey.slug', $id2);
        $profiles = $this->db->get();

        if ($profiles->num_rows() == 0) {
            echo 'Survey tidak ditemukan atau sudah dihapus !';
            exit();
        }

        return $profiles->row();
    }
}