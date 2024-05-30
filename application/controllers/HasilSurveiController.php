<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HasilSurveiController extends CI_Controller
{
    public function index($id1, $id2)
    {
        $this->data = [];
        $this->data['title'] = 'Detail Pertanyaan Unsur';
    }


    public function hasil($id1, $id2)
    {
        $this->data = [];
        $this->data['title'] = 'Detail Pertanyaan Unsur';
        // $this->data['profiles'] = $this->_get_data_profile($id1, $id2);

        $this->db->select("*, DATE_FORMAT(survey_end, '%d %M %Y') AS survey_selesai, IF(CURDATE() > survey_end,1,NULL) AS survey_berakhir, IF(CURDATE() < survey_start ,1,NULL) AS survey_belum_mulai");
        $this->db->from('manage_survey');
        $this->db->where('manage_survey.slug', $this->uri->segment(1));
        $manage_survey = $this->db->get()->row();
        $this->data['manage_survey'] = $manage_survey;
        $table_identity = $manage_survey->table_identity;

        $this->data['data_user'] = $this->db->get_where('users', array('id' => $manage_survey->id_user))->row();

        $uuid_responden = $this->uri->segment(3);

        $this->_data_responden($table_identity, $uuid_responden); //LOAD DATA RESPONDEN
        $id_survey = $this->data['responden']->id_survey;

        $this->data['tahapan_pembelian'] = $this->db->query("SELECT * FROM tahapan_pembelian_$table_identity");

        $this->data['dimensi'] = $this->db->query("SELECT * FROM dimensi_$table_identity");

        $this->data['pertanyaan_unsur'] = $this->db->query("SELECT id_unsur, id_dimensi, kode_unsur, pertanyaan_unsur_$table_identity.id AS id_pertanyaan_unsur, isi_pertanyaan, (SELECT nama_jawaban FROM nilai_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && nilai_jawaban = 1) AS jawaban_1,
        (SELECT nama_jawaban FROM nilai_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && nilai_jawaban = 2) AS jawaban_2,
        (SELECT nama_jawaban FROM nilai_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && nilai_jawaban = 3) AS jawaban_3,
        (SELECT nama_jawaban FROM nilai_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && nilai_jawaban = 4) AS jawaban_4,
        (SELECT nama_jawaban FROM nilai_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && nilai_jawaban = 5) AS jawaban_5, skor_jawaban, alasan_pilih_jawaban
        FROM pertanyaan_unsur_$table_identity
        JOIN unsur ON pertanyaan_unsur_$table_identity.id_unsur = unsur.id
        JOIN jawaban_pertanyaan_unsur_$table_identity ON pertanyaan_unsur_$table_identity.id = jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur
        WHERE id_survey = $id_survey");


        $this->data['pertanyaan_terbuka'] = $this->db->query("SELECT *,
        (SELECT jawaban FROM jawaban_pertanyaan_terbuka_$table_identity WHERE id_pertanyaan_terbuka = pertanyaan_terbuka_$table_identity.id && id_survey = $id_survey) AS jawaban
        FROM pertanyaan_terbuka_$table_identity");




        $this->load->library('pdfgenerator');
        $this->data['title_pdf'] = $this->data['responden']->uuid_responden;
        $file_pdf = $this->data['responden']->uuid_responden;
        $paper = 'A4';
        $orientation = "potrait";

        $html = $this->load->view('hasil_survei/cetak', $this->data, true);

        $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);

        $this->load->view('hasil_survei/cetak', $this->data);
    }


    public function _data_responden($table_identity, $uuid_responden)
    {
        $this->data['profil_responden'] = $this->db->query("SELECT * FROM profil_responden_$table_identity ORDER BY IF(urutan != '',urutan,id) ASC")->result();

        $data_profil = [];
        foreach ($this->data['profil_responden'] as $get) {
            if ($get->id != 1 || $get->id != 2) {
                if ($get->jenis_isian == 1) {

                    $data_profil[] = "(SELECT nama_kategori_profil_responden FROM kategori_profil_responden_$table_identity WHERE responden_$table_identity.$get->nama_alias = kategori_profil_responden_$table_identity.id) AS $get->nama_alias";
                } else {
                    $data_profil[] = $get->nama_alias;
                }
            }
        }
        $query_profil = implode(",", $data_profil);

        $this->db->select("survey_$table_identity.id AS id_survey, $query_profil, responden_$table_identity.uuid AS uuid_responden, (SELECT nama_sektor FROM sektor_$table_identity WHERE responden_$table_identity.sektor = sektor_$table_identity.id) AS sektor, (SELECT nama_wilayah FROM wilayah_survei_$table_identity WHERE responden_$table_identity.sektor = wilayah_survei_$table_identity.id) AS wilayah_survei, waktu_isi, saran");
        $this->db->from("responden_$table_identity");
        $this->db->join("survey_$table_identity", "responden_$table_identity.id = survey_$table_identity.id_responden");
        $this->db->where("responden_$table_identity.uuid = '$uuid_responden'");
        $this->data['responden'] = $this->db->get()->row();
    }
}