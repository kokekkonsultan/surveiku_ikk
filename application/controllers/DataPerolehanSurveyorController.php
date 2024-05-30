<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DataPerolehanSurveyorController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('ion_auth');

        if (!$this->ion_auth->logged_in()) {
            $this->session->set_flashdata('message_warning', 'You must be logged in to access this page');
            redirect('auth', 'refresh');
        }
        $this->load->model('DataPerolehanSurveyor_model', 'models');
    }
    public function index()
    {
        $this->data = [];
        $this->data['title'] = "Data Perolehan Surveyor";

        $user = $this->ion_auth->user()->row()->id;

        $manage_survey = $this->db->query("SELECT *, surveyor.uuid AS uuid_surveyor
        FROM surveyor
        JOIN manage_survey ON surveyor.id_manage_survey = manage_survey.id
        WHERE surveyor.id_user = $user")->row();
        $table_identity = $manage_survey->table_identity;

        //PANGGIL PROFIL RESPONDEN
        $this->data['profil'] = $this->db->query("SELECT *,  REPLACE(LOWER(nama_profil_responden), ' ', '_') AS nama_alias FROM profil_responden_$table_identity")->result();

        //PANGGIL UNSUR
        $this->data['unsur']  = $this->db->query("SELECT *, SUBSTR(kode_unsur, 2) AS kode_alasan FROM unsur_$table_identity");

        return view('data_perolehan_surveyor/index', $this->data);
    }

    public function ajax_list()
    {
        $user = $this->ion_auth->user()->row()->id;

        $manage_survey = $this->db->query("SELECT *, surveyor.uuid AS uuid_surveyor
        FROM surveyor
        JOIN manage_survey ON surveyor.id_manage_survey = manage_survey.id
        WHERE surveyor.id_user = $user")->row();
        $table_identity = $manage_survey->table_identity;

        //PANGGIL PROFIL RESPONDEN
        $profil_responden = $this->db->query("SELECT * FROM profil_responden_$table_identity ORDER BY IF(urutan != '',urutan,id) ASC")->result();


        $list = $this->models->get_datatables($profil_responden, $table_identity, $user);
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $value) {

            $jawaban_unsur = $this->db->get("jawaban_pertanyaan_unsur_$table_identity");

            if ($value->is_submit == 1) {
                $status = '<span class="badge badge-primary">Valid</span>';
            } else {
                $status = '<span class="badge badge-danger">Tidak Valid</span>';
            }

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $status;
            $row[] = anchor($manage_survey->slug . '/hasil-survei/' . $value->uuid_responden, '<i class="fas fa-file-pdf text-danger"></i>', ['target' => '_blank']);
            // $row[] = '<b>' . $value->kode_surveyor . '</b>--' . $value->first_name . ' ' . $value->last_name;
            // $row[] = $value->nama_lengkap;
            // $row[] = $value->nama_provinsi_indonesia . '<br><b>' . $value->nama_kota_kab_indonesia . '</b>';

            foreach ($profil_responden as $get) {
                $profil = $get->nama_alias;
                $row[] =  str_word_count($value->$profil) > 5 ? substr($value->$profil, 0, 50) . ' [...]' : $value->$profil;
            }

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

            $row[] = $value->saran;
            $row[] = date("d-m-Y", strtotime($value->waktu_isi));

            $row[] = anchor('/survei/' . $manage_survey->slug . '/data-responden/'  . $value->uuid_responden . '/edit', '<i class="fa fa-edit"></i> Edit', ['class' => 'btn btn-light-primary btn-sm font-weight-bold shadow', 'target' => '_blank']);


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->models->count_all($profil_responden, $table_identity, $user),
            "recordsFiltered" => $this->models->count_filtered($profil_responden, $table_identity, $user),
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function export()
    {
        $this->data = [];
        $this->data['title'] = "Perolehan Survei";

        $user = $this->ion_auth->user()->row()->id;

        $get_identity = $this->db->query("SELECT *, surveyor.uuid AS uuid_surveyor
        FROM surveyor
        JOIN manage_survey ON surveyor.id_manage_survey = manage_survey.id
        WHERE surveyor.id_user = $user")->row();
        $id_manage_survey = $get_identity->table_identity;

        $this->db->select("*, (SELECT skor_jawaban FROM jawaban_pertanyaan_unsur_$id_manage_survey WHERE survey_$id_manage_survey.id = id_survey && id_pertanyaan_unsur = 1 ) AS U1,
        (SELECT skor_jawaban FROM jawaban_pertanyaan_unsur_$id_manage_survey WHERE survey_$id_manage_survey.id = id_survey && id_pertanyaan_unsur = 2 ) AS U2,
        (SELECT skor_jawaban FROM jawaban_pertanyaan_unsur_$id_manage_survey WHERE survey_$id_manage_survey.id = id_survey && id_pertanyaan_unsur = 3 ) AS U3,
        (SELECT skor_jawaban FROM jawaban_pertanyaan_unsur_$id_manage_survey WHERE survey_$id_manage_survey.id = id_survey && id_pertanyaan_unsur = 4 ) AS U4,
        (SELECT skor_jawaban FROM jawaban_pertanyaan_unsur_$id_manage_survey WHERE survey_$id_manage_survey.id = id_survey && id_pertanyaan_unsur = 5 ) AS U5,
        (SELECT skor_jawaban FROM jawaban_pertanyaan_unsur_$id_manage_survey WHERE survey_$id_manage_survey.id = id_survey && id_pertanyaan_unsur = 6 ) AS U6,
        (SELECT skor_jawaban FROM jawaban_pertanyaan_unsur_$id_manage_survey WHERE survey_$id_manage_survey.id = id_survey && id_pertanyaan_unsur = 7 ) AS U7,
        (SELECT skor_jawaban FROM jawaban_pertanyaan_unsur_$id_manage_survey WHERE survey_$id_manage_survey.id = id_survey && id_pertanyaan_unsur = 8 ) AS U8,
        (SELECT skor_jawaban FROM jawaban_pertanyaan_unsur_$id_manage_survey WHERE survey_$id_manage_survey.id = id_survey && id_pertanyaan_unsur = 9 ) AS U9,
        (SELECT skor_jawaban FROM jawaban_pertanyaan_unsur_$id_manage_survey WHERE survey_$id_manage_survey.id = id_survey && id_pertanyaan_unsur = 10 ) AS U10,
        (SELECT skor_jawaban FROM jawaban_pertanyaan_unsur_$id_manage_survey WHERE survey_$id_manage_survey.id = id_survey && id_pertanyaan_unsur = 11 ) AS U11,
        (SELECT skor_jawaban FROM jawaban_pertanyaan_unsur_$id_manage_survey WHERE survey_$id_manage_survey.id = id_survey && id_pertanyaan_unsur = 12 ) AS U12,
        (SELECT skor_jawaban FROM jawaban_pertanyaan_unsur_$id_manage_survey WHERE survey_$id_manage_survey.id = id_survey && id_pertanyaan_unsur = 13 ) AS U13,
        (SELECT skor_jawaban FROM jawaban_pertanyaan_unsur_$id_manage_survey WHERE survey_$id_manage_survey.id = id_survey && id_pertanyaan_unsur = 14 ) AS U14,
        (SELECT skor_jawaban FROM jawaban_pertanyaan_unsur_$id_manage_survey WHERE survey_$id_manage_survey.id = id_survey && id_pertanyaan_unsur = 15 ) AS U15,
        (SELECT skor_jawaban FROM jawaban_pertanyaan_unsur_$id_manage_survey WHERE survey_$id_manage_survey.id = id_survey && id_pertanyaan_unsur = 16 ) AS U16,
        (SELECT skor_jawaban FROM jawaban_pertanyaan_unsur_$id_manage_survey WHERE survey_$id_manage_survey.id = id_survey && id_pertanyaan_unsur = 17 ) AS U17,
        (SELECT skor_jawaban FROM jawaban_pertanyaan_unsur_$id_manage_survey WHERE survey_$id_manage_survey.id = id_survey && id_pertanyaan_unsur = 18 ) AS U18,
        (SELECT skor_jawaban FROM jawaban_pertanyaan_unsur_$id_manage_survey WHERE survey_$id_manage_survey.id = id_survey && id_pertanyaan_unsur = 19 ) AS U19,
        (SELECT alasan_pilih_jawaban FROM jawaban_pertanyaan_unsur_$id_manage_survey WHERE survey_$id_manage_survey.id = id_survey && id_pertanyaan_unsur = 1 ) AS A1,
        (SELECT alasan_pilih_jawaban FROM jawaban_pertanyaan_unsur_$id_manage_survey WHERE survey_$id_manage_survey.id = id_survey && id_pertanyaan_unsur = 2 ) AS A2,
        (SELECT alasan_pilih_jawaban FROM jawaban_pertanyaan_unsur_$id_manage_survey WHERE survey_$id_manage_survey.id = id_survey && id_pertanyaan_unsur = 3 ) AS A3,
        (SELECT alasan_pilih_jawaban FROM jawaban_pertanyaan_unsur_$id_manage_survey WHERE survey_$id_manage_survey.id = id_survey && id_pertanyaan_unsur = 4 ) AS A4,
        (SELECT alasan_pilih_jawaban FROM jawaban_pertanyaan_unsur_$id_manage_survey WHERE survey_$id_manage_survey.id = id_survey && id_pertanyaan_unsur = 5 ) AS A5,
        (SELECT alasan_pilih_jawaban FROM jawaban_pertanyaan_unsur_$id_manage_survey WHERE survey_$id_manage_survey.id = id_survey && id_pertanyaan_unsur = 6 ) AS A6,
        (SELECT alasan_pilih_jawaban FROM jawaban_pertanyaan_unsur_$id_manage_survey WHERE survey_$id_manage_survey.id = id_survey && id_pertanyaan_unsur = 7 ) AS A7,
        (SELECT alasan_pilih_jawaban FROM jawaban_pertanyaan_unsur_$id_manage_survey WHERE survey_$id_manage_survey.id = id_survey && id_pertanyaan_unsur = 8 ) AS A8,
        (SELECT alasan_pilih_jawaban FROM jawaban_pertanyaan_unsur_$id_manage_survey WHERE survey_$id_manage_survey.id = id_survey && id_pertanyaan_unsur = 9 ) AS A9,
        (SELECT alasan_pilih_jawaban FROM jawaban_pertanyaan_unsur_$id_manage_survey WHERE survey_$id_manage_survey.id = id_survey && id_pertanyaan_unsur = 10 ) AS A10,
        (SELECT alasan_pilih_jawaban FROM jawaban_pertanyaan_unsur_$id_manage_survey WHERE survey_$id_manage_survey.id = id_survey && id_pertanyaan_unsur = 11 ) AS A11,
        (SELECT alasan_pilih_jawaban FROM jawaban_pertanyaan_unsur_$id_manage_survey WHERE survey_$id_manage_survey.id = id_survey && id_pertanyaan_unsur = 12 ) AS A12,
        (SELECT alasan_pilih_jawaban FROM jawaban_pertanyaan_unsur_$id_manage_survey WHERE survey_$id_manage_survey.id = id_survey && id_pertanyaan_unsur = 13 ) AS A13,
        (SELECT alasan_pilih_jawaban FROM jawaban_pertanyaan_unsur_$id_manage_survey WHERE survey_$id_manage_survey.id = id_survey && id_pertanyaan_unsur = 14 ) AS A14,
        (SELECT alasan_pilih_jawaban FROM jawaban_pertanyaan_unsur_$id_manage_survey WHERE survey_$id_manage_survey.id = id_survey && id_pertanyaan_unsur = 15 ) AS A15,
        (SELECT alasan_pilih_jawaban FROM jawaban_pertanyaan_unsur_$id_manage_survey WHERE survey_$id_manage_survey.id = id_survey && id_pertanyaan_unsur = 16 ) AS A16,
        (SELECT alasan_pilih_jawaban FROM jawaban_pertanyaan_unsur_$id_manage_survey WHERE survey_$id_manage_survey.id = id_survey && id_pertanyaan_unsur = 17 ) AS A17,
        (SELECT alasan_pilih_jawaban FROM jawaban_pertanyaan_unsur_$id_manage_survey WHERE survey_$id_manage_survey.id = id_survey && id_pertanyaan_unsur = 18 ) AS A18,
        (SELECT alasan_pilih_jawaban FROM jawaban_pertanyaan_unsur_$id_manage_survey WHERE survey_$id_manage_survey.id = id_survey && id_pertanyaan_unsur = 19 ) AS A19
        ");
        $this->db->from("responden_$id_manage_survey");
        $this->db->join("survey_$id_manage_survey", "responden_$id_manage_survey.id = survey_$id_manage_survey.id_responden");
        $this->db->join("barang_jasa", "responden_$id_manage_survey.id_barang_jasa = barang_jasa.id");
        $this->db->join("jenis_kelamin", "responden_$id_manage_survey.id_jenis_kelamin = jenis_kelamin.id");
        $this->db->join("umur", "responden_$id_manage_survey.id_umur = umur.id");
        $this->db->join("pendidikan_akhir", "responden_$id_manage_survey.id_pendidikan_akhir = pendidikan_akhir.id");
        $this->db->join("pekerjaan_utama", "responden_$id_manage_survey.id_pekerjaan_utama = pekerjaan_utama.id");
        $this->db->join("pendapatan_per_bulan", "responden_$id_manage_survey.id_pendapatan_per_bulan = pendapatan_per_bulan.id");
        $this->db->join("kota_kab_indonesia", "responden_$id_manage_survey.id_kota_kab_indonesia = kota_kab_indonesia.id");
        $this->db->join("provinsi_indonesia", "kota_kab_indonesia.id_provinsi_indonesia = provinsi_indonesia.id");
        $this->db->join("surveyor", "survey_$id_manage_survey.id_surveyor = surveyor.id");
        $this->db->join("users", "surveyor.id_user = users.id");
        $this->db->where("id_user = $user");
        $this->data['survey'] = $this->db->get();

        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Perolehan-Surveyor-$get_identity->kode_surveyor.xls");

        $this->load->view('data_perolehan_surveyor/cetak', $this->data);
    }
}