<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SertifikatIndukKeseluruhanController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            $this->session->set_flashdata('message_warning', 'You must be an admin to view this page');
            redirect('auth', 'refresh');
        }
        $this->load->library('form_validation');
        $this->load->model('DataPerolehanPerBagian_model', 'models');
    }

    public function index()
    {
        $this->data = [];
		$this->data['title'] = 'E-Sertifikat Keseluruhan';

        $klien_induk = $this->db->get_where("pengguna_klien_induk", array('id_user' => $this->session->userdata('user_id')))->row();
		$parent = implode(", ", unserialize($klien_induk->cakupan_induk));

        $this->db->select( '*, manage_survey.slug AS slug_manage_survey, (SELECT first_name FROM users WHERE users.id = manage_survey.id_user) AS first_name, (SELECT last_name FROM users WHERE users.id = manage_survey.id_user) AS last_name');
        $this->db->from('manage_survey');
        $this->db->where("id IN ($parent)");

		$manage_survey = $this->db->get();

        if ($manage_survey->num_rows() > 0) {
            foreach ($manage_survey->result() as $value) {
                $table_identity = $value->table_identity;

                $this->data['profil_responden'] = $this->db->query("SELECT * FROM profil_responden_$table_identity WHERE jenis_isian = 1 && id NOT IN (1,2)");
            }
        }

		return view('sertifikat_keseluruhan/index', $this->data);
    }

    public function cetak()
    {
        $this->data = [];
        $this->data['title'] = "E-Sertifikat Keseluruhan";

        $klien_induk = $this->db->get_where("pengguna_klien_induk", array('id_user' => $this->session->userdata('user_id')))->row();
		$parent = implode(", ", unserialize($klien_induk->cakupan_induk));

        $input     = $this->input->post(NULL, TRUE);
        $profil_responden = $input['profil_responden'];
        $data_profil = implode(",", $profil_responden);

        $data_skor = [];
        $query_jumlah_kuisioner = "SELECT id FROM (";
        $query_profil = "SELECT * FROM (";
        $q = 0;
        foreach ($this->db->query("SELECT * FROM manage_survey WHERE id IN ($parent)")->result() as $key => $value) {
            $q++;
            $data_skor[$key] = "UNION
                            SELECT *
                            FROM (SELECT *, (SELECT is_submit FROM survey_$value->table_identity WHERE survey_$value->table_identity.id = jawaban_pertanyaan_unsur_$value->table_identity.id_survey) AS is_submit FROM jawaban_pertanyaan_unsur_$value->table_identity) jpu_$value->table_identity
                            WHERE is_submit = 1";

            if($q!='1'){
                $query_jumlah_kuisioner .= "
                UNION ALL
                ";
                $query_profil .= "
                UNION ALL
                ";
            }
            $query_jumlah_kuisioner .= "SELECT id FROM survey_$value->table_identity WHERE is_submit = 1";
            $query_profil .= "SELECT * FROM profil_responden_$value->table_identity WHERE id IN ($data_profil)";
        }
        $query_jumlah_kuisioner .= ') jumlah_kuisioner';
        $query_profil .= ') profil GROUP BY nama_alias';

        $this->data['jumlah_kuisioner'] = $this->db->query($query_jumlah_kuisioner)->num_rows();
        $this->data['profil'] = $this->db->query($query_profil);

        if ($this->data['jumlah_kuisioner'] == 0) {
            $this->data['pesan'] = 'survei belum dimulai atau belum ada responden !';
            return view('not_questions/index', $this->data);
        }

        $union_skor = implode(" ", $data_skor);

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
        
        foreach ($this->data['total_nilai_unsur']->result() as $rows) {
            $total[] = $rows->persen_per_unsur;
            $this->data['ikk'] = array_sum($total);
        }

        /*$this->db->select("*, manage_survey.id AS id_manage_survey, manage_survey.survey_name, manage_survey.table_identity AS table_identity,  DATE_FORMAT(survey_start, '%M') AS survey_mulai, DATE_FORMAT(survey_end, '%M %Y') AS survey_selesai");
        $this->db->from('manage_survey');
        $this->db->where("id IN ($parent)");
        $manage_survey = $this->db->get();

        if ($manage_survey->num_rows() > 0) {
            foreach ($manage_survey->result() as $value) {
                $table_identity = $value->table_identity;
        
                $this->data['jumlah_kuisioner'] = $this->db->get_where("survey_$table_identity", array('is_submit' => 1))->num_rows();

                if ($this->data['jumlah_kuisioner'] == 0) {
                    $this->data['pesan'] = 'survei belum dimulai atau belum ada responden !';
                    return view('not_questions/index', $this->data);
                }


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
            }
        }*/

        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'trim|required');
        $this->form_validation->set_rules('model_sertifikat', 'Model sertifikat', 'trim|required');
        $this->form_validation->set_rules('periode', 'Periode Survei', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            return view('sertifikat_keseluruhan/index', $this->data);
        } else {
            //if ($manage_survey->nomor_sertifikat == NULL) {

                $array_bulan = array(1 => "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
                $bulan = $array_bulan[date('n')];

                $object = [
                    //'nomor_sertifikat'     => '000' . $manage_survey->id .  '/IKK/' .  $manage_survey->id_user . '/' . $bulan . '/' . date('Y'),
                    'nomor_sertifikat'     => '0001/IKK/' . $bulan . '/' . date('Y'),
                    // 'qr_code' 	=> $table_identity . '.png'
                ];
                //$this->db->where('slug', $this->uri->segment(3));
                //$this->db->update('manage_survey', $object);
            //};


            
            $this->data['nama'] = $input['nama'];
            $this->data['jabatan'] = $input['jabatan'];
            $this->data['model_sertifikat'] = $input['model_sertifikat'];
            $this->data['periode'] = $input['periode'];
            //$this->data['table_identity'] = $table_identity;
            $profil_responden = $input['profil_responden'];
            $data_profil = implode(",", $profil_responden);



            $this->data['user'] = $this->db->get_where("users", array('id' => $this->session->userdata('user_id')))->row();

            //TAMPILKAN PROFIL YANG DIPILIH
            //$this->data['profil'] = $this->db->query("SELECT *,  REPLACE(LOWER(nama_profil_responden), ' ', '_') AS nama_alias FROM profil_responden_$table_identity WHERE id IN ($data_profil)");

            //$this->data['qr_code'] = 'https://image-charts.com/chart?chl=' . base_url() . 'validasi-sertifikat/' . $manage_survey->uuid . '&choe=UTF-8&chs=300x300&cht=qr';


            //------------------------------CETAK-------------------------//
            $this->load->library('pdfgenerator');
            $this->data['title_pdf'] = 'SERTIFIKAT E-IKK';
            $file_pdf = 'SERTIFIKAT E-IKK';
            $paper = 'A4';
            $orientation = "potrait";

            $html = $this->load->view('sertifikat_keseluruhan/cetak', $this->data, true);

            $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
        }
    }
    
}

/* End of file SertifikatIndukKeseluruhanController.php */
/* Location: ./application/controllers/SertifikatIndukKeseluruhanController.php */