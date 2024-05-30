<?php
defined('BASEPATH') or exit('No direct script access allowed');


class DataSurveiSPVController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            $this->session->set_flashdata('message_warning', 'You must be an admin to view this page');
            redirect('auth', 'refresh');
        }
        $this->load->model('DataPerolehanSurvei_model', 'models');
    }


    public function dashboard_chart()
    {
        $this->data = [];
        $this->data['title'] = 'Dashboard Chart';

        $manage_survey = $this->db->get_where("manage_survey", array('id_user' => $this->session->userdata('user_id')));
        $data_user = $this->db->get_where("users", array('id' => $this->session->userdata('user_id')))->row();

        $this->db->select('*, manage_survey.slug AS slug_manage_survey');
        $this->db->from('manage_survey');
        $this->db->join("supervisor_drs$data_user->is_parent", "manage_survey.id_berlangganan = supervisor_drs$data_user->is_parent.id_berlangganan");
        $this->db->where("supervisor_drs$data_user->is_parent.id_user", $this->session->userdata('user_id'));
        $manage_survey = $this->db->get();

        if ($manage_survey->num_rows() > 0) {

            $data_chart = [];
            $no = 1;
            foreach ($manage_survey->result() as $value) {

                if ($this->db->get_where("survey_$value->table_identity", array('is_submit' => 1))->num_rows() > 0) {

                    $nilai_per_unsur[$no] = $this->db->query("SELECT kode_unsur, persentase_unsur, (SELECT AVG(skor_jawaban) FROM jawaban_pertanyaan_unsur_$value->table_identity
					JOIN survey_$value->table_identity ON jawaban_pertanyaan_unsur_$value->table_identity.id_survey = survey_$value->table_identity.id
					WHERE id_pertanyaan_unsur = pertanyaan_unsur_$value->table_identity.id && is_submit = 1 && id_surveyor = 0) AS rata_per_unsur,
					
					(SELECT unsur_$value->table_identity.persentase_unsur / 100) AS persentase_unsur_dibagi_100,
					
					((SELECT AVG(skor_jawaban) FROM jawaban_pertanyaan_unsur_$value->table_identity
					JOIN survey_$value->table_identity ON jawaban_pertanyaan_unsur_$value->table_identity.id_survey = survey_$value->table_identity.id
					WHERE id_pertanyaan_unsur = pertanyaan_unsur_$value->table_identity.id && is_submit = 1 && id_surveyor = 0) * (unsur_$value->table_identity.persentase_unsur / 100)) AS persen_per_unsur
					
					FROM pertanyaan_unsur_$value->table_identity
					JOIN unsur_$value->table_identity ON pertanyaan_unsur_$value->table_identity.id_unsur = unsur_$value->table_identity.id");

                    $nilai_bobot[$no] = [];
                    foreach ($nilai_per_unsur[$no]->result() as $get) {
                        $nilai_bobot[$no][] = $get->persen_per_unsur;
                        $nilai_tertimbang[$no] = array_sum($nilai_bobot[$no]);
                    }
                    $data_chart[] = '{"label": "' . $value->survey_name . '",
						"value": "' . ROUND($nilai_tertimbang[$no] * 20, 2) . '"}';
                } else {
                    $data_chart[] = '{"label": "' . $value->survey_name . '", "value": "0"}';
                };
                $no++;
            }
            $this->data['get_data_chart'] = implode(", ", $data_chart);
        } else {
            $this->data['get_data_chart'] = '{"label": "", "value": "0"}';
        }
        return view("dashboard/chart_survei", $this->data);
    }


    //============================= Data Perolehan ====================================
    public function perolehan($id1, $id2)
    {
        $this->data = [];
        $this->data['title'] = 'Data Perolehan Online';
        $this->data['profiles'] = $this->_get_data_profile($id1, $id2);


        $manage_survey = $this->db->get_where('manage_survey', ['slug' => $this->uri->segment(2)])->row();
        $this->data['profil'] = $this->db->query("SELECT * FROM profil_responden_$manage_survey->table_identity ORDER BY IF(urutan != '',urutan,id) ASC")->result();

        return view('data_survei_spv/perolehan', $this->data);
    }




    //============================= OLAH DATA ====================================
    public function olah_data($id1, $id2)
    {
        $this->data = [];
        $this->data['title'] = 'Olah Data Online';
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
        WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && is_submit = 1 && id_surveyor = 0) AS total_nilai_unsur
        FROM pertanyaan_unsur_$table_identity");

        $this->data['rata_rata_per_unsur'] = $this->db->query("SELECT *, (SELECT AVG(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity 
        JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey = survey_$table_identity.id
        WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && is_submit = 1 && id_surveyor = 0) AS rata_per_unsur
        FROM pertanyaan_unsur_$table_identity");


        $this->data['rata_rata_per_dimensi'] = $this->db->query("SELECT *, (SELECT SUM(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity
        JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey = survey_$table_identity.id
        JOIN pertanyaan_unsur_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id
        JOIN unsur_$table_identity ON pertanyaan_unsur_$table_identity.id_unsur = unsur_$table_identity.id
        WHERE id_dimensi = dimensi_$table_identity.id && is_submit = 1 && id_surveyor = 0) AS jumlah_per_dimensi,

        (SELECT COUNT(id) FROM unsur_$table_identity WHERE id_dimensi = dimensi_$table_identity.id) AS jumlah_unsur,

        ( ((SELECT SUM(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity
        JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey = survey_$table_identity.id
        JOIN pertanyaan_unsur_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id
        JOIN unsur_$table_identity ON pertanyaan_unsur_$table_identity.id_unsur = unsur_$table_identity.id
        WHERE id_dimensi = dimensi_$table_identity.id && is_submit = 1 && id_surveyor = 0) / (SELECT COUNT(id) FROM survey_$table_identity WHERE is_submit = 1)) / (SELECT COUNT(id) FROM unsur_$table_identity WHERE id_dimensi = dimensi_$table_identity.id)) AS rata_per_dimensi

        FROM dimensi_$table_identity");


        $this->data['rata_rata_per_unsur_x_bobot'] = $this->db->query("SELECT kode_unsur, persentase_unsur, (SELECT AVG(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity
        JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey = survey_$table_identity.id
        WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && is_submit = 1 && id_surveyor = 0) AS rata_per_unsur,
        
        (SELECT unsur_$table_identity.persentase_unsur / 100) AS persentase_unsur_dibagi_100,
        
        ((SELECT AVG(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity
        JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey = survey_$table_identity.id
        WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && is_submit = 1 && id_surveyor = 0) * (unsur_$table_identity.persentase_unsur / 100)) AS persen_per_unsur
        
        FROM pertanyaan_unsur_$table_identity
        JOIN unsur_$table_identity ON pertanyaan_unsur_$table_identity.id_unsur = unsur_$table_identity.id");

        foreach ($this->data['rata_rata_per_unsur_x_bobot']->result() as $rows) {
            $total[] = $rows->persen_per_unsur;
            $this->data['ikk'] = array_sum($total);
        }

        return view('data_survei_spv/olah_data', $this->data);
    }


    //============================= Nilai Indeks Per Sektor ====================================
    public function nilai_per_sektor($id1, $id2)
    {
        $this->data = [];
        $this->data['title'] = 'Nilai Index Sektor';
        $this->data['profiles'] = $this->_get_data_profile($id1, $id2);
        $this->data['table_identity'] = $this->data['profiles']->table_identity;
        $this->data['sektor'] = $this->db->get("sektor_" . $this->data['table_identity']);


        return view('data_survei_spv/nilai_per_sektor', $this->data);
    }


    //============================= Rekap Responden ====================================
    public function rekap_responden($id1, $id2)
    {
        $this->data = [];
        $this->data['title'] = "Profil Responden";
        $this->data['profiles'] = $this->_get_data_profile($id1, $id2);

        $manage_survey = $this->db->get_where('manage_survey', array('slug' => $this->uri->segment(2)))->row();
        $table_identity = $manage_survey->table_identity;


        $profil_responden = $this->db->query("SELECT *, (SELECT COUNT(id) FROM kategori_profil_responden_$table_identity WHERE id_profil_responden = profil_responden_$table_identity.id) AS jumlah_pilihan
		FROM profil_responden_$table_identity
		WHERE jenis_isian = 1 && id NOT IN (1,2) ORDER BY IF(urutan != '',urutan,id) ASC");


        if ($profil_responden->num_rows() == 0) {
            $this->data['pesan'] = 'Profil responden survei anda tidak memiliki data yang bisa di olah.';
            return view('not_questions/index', $this->data);
        }
        $this->data['profil_responden'] = $profil_responden->result();


        if ($this->db->get_where('survey_' . $table_identity, array('is_submit' => 1))->num_rows() == 0) {
            $this->data['pesan'] = 'Survei belum dimulai atau belum ada responden !';
            return view('not_questions/index', $this->data);
        }

        return view('data_survei_spv/rekap_responden', $this->data);
    }



    //============================= Chart Visualisasi ====================================
    public function chart_visualisasi($id1 = NULL, $id2 = NULL)
    {
        $this->data = [];
        $this->data['title'] = "Visualisasi Data";
        $this->data['profiles'] = $this->_get_data_profile($id1, $id2);

        $manage_survey = $this->db->get_where('manage_survey', array('slug' => $this->uri->segment(2)))->row();
        $this->data['table_identity'] = $manage_survey->table_identity;

        $this->db->select("*, pertanyaan_unsur_$manage_survey->table_identity.id AS id_pertanyaan_unsur");
        $this->db->from("unsur_$manage_survey->table_identity");
        $this->db->join("pertanyaan_unsur_$manage_survey->table_identity", "unsur_$manage_survey->table_identity.id = pertanyaan_unsur_$manage_survey->table_identity.id_unsur");
        $this->data['unsur'] = $this->db->get();
        // var_dump($this->data['unsur']->result());

        if ($this->db->get_where('survey_' . $manage_survey->table_identity, array('is_submit' => 1))->num_rows() == 0) {
            $this->data['pesan'] = 'Survei belum dimulai atau belum ada responden !';
            return view('not_questions/index', $this->data);
        }

        return view('data_survei_spv/chart_visualisasi', $this->data);
    }



    //============================= Rekap Per Wilayah ====================================
    public function rekap_per_wilayah($id1, $id2)
    {
        $this->data = [];
        $this->data['title'] = "Rekap Per Wilayah";

        $this->data['profiles'] = $this->_get_data_profile($id1, $id2);
        $table_identity = $this->data['profiles']->table_identity;

        $this->data['wilayah_survei'] = $this->db->query("SELECT *,
		(SELECT SUM(target_online) FROM target_$table_identity WHERE id_wilayah_survei = wilayah_survei_$table_identity.id) AS target,
		
		(SELECT COUNT(id_responden)
		FROM responden_$table_identity
		JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden
		WHERE is_submit = 1 && id_surveyor = 0 && responden_$table_identity.wilayah_survei = wilayah_survei_$table_identity.id)
		AS perolehan
		
		FROM wilayah_survei_$table_identity");

        if ($this->data['profiles']->is_question == 1) {
            $this->data['pesan'] = 'survei belum dimulai atau belum ada responden !';
            return view('not_questions/index', $this->data);
        } else {
            return view('data_survei_spv/rekap_per_wilayah', $this->data);
        }
    }



    //============================= Rekap Per Sektor ====================================
    public function rekap_per_sektor($id1, $id2)
    {
        $this->data = [];
        $this->data['title'] = "Rekap Per Sektor";

        $this->data['profiles'] = $this->_get_data_profile($id1, $id2);
        $table_identity = $this->data['profiles']->table_identity;

        $this->data['sektor'] = $this->db->query("SELECT *,
        (SELECT SUM(target_online) FROM target_$table_identity WHERE id_sektor = sektor_$table_identity.id) AS target_online,    
        (SELECT COUNT(id_responden) FROM responden_$table_identity JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden WHERE responden_$table_identity.sektor = sektor_$table_identity.id && is_submit = 1 && survey_$table_identity.id_surveyor = 0) AS perolehan_online
        
        FROM sektor_$table_identity");



        if ($this->data['profiles']->is_question == 1) {
            $this->data['pesan'] = 'survei belum dimulai atau belum ada responden !';
            return view('not_questions/index', $this->data);
        } else {
            return view('data_survei_spv/rekap_per_sektor', $this->data);
        }
    }



    //============================= Rekap Alasan ====================================
    public function rekap_alasan($id1, $id2)
    {
        $this->data = [];
        $this->data['title'] = "Rekap Alasan";
        $this->data['profiles'] = $this->_get_data_profile($id1, $id2);
        $this->data['table_identity'] = $this->data['profiles']->table_identity;

        $this->data['pertanyaan'] = $this->db->get("pertanyaan_unsur_" . $this->data['table_identity']);


        return view('data_survei_spv/rekap_alasan', $this->data);
    }



    //============================= Rekap Saran ====================================
    public function rekap_saran($id1, $id2)
    {
        $this->data = [];
        $this->data['title'] = "Rekap Saran";

        $this->data['profiles'] = $this->_get_data_profile($id1, $id2);

        return view('data_survei_spv/rekap_saran', $this->data);
    }




    public function _get_data_profile($id1, $id2)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->join('users_groups', 'users.id = users_groups.user_id');
        $this->db->where('users.username', $this->session->userdata('username'));
        $data_user = $this->db->get()->row();
        $user_identity = 'drs' . $data_user->is_parent;

        $this->db->select('*, (SELECT group_id FROM users_groups WHERE user_id = users.id) AS group_id');
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

/* End of file DataPerolehanSurveiController.php */
/* Location: ./application/controllers/DataPerolehanSurveiController.php */
