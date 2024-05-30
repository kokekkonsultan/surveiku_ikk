<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ChartVisualisasiController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            $this->session->set_flashdata('message_warning', 'You must be an admin to view this page');
            redirect('auth', 'refresh');
        }
    }

    public function index($id1 = NULL, $id2 = NULL)
    {
        $this->data = [];
        $this->data['title'] = "Visualisasi Data";

        $this->data['profiles'] = $this->_get_data_profile($id1, $id2);

        $this->db->select('table_identity');
        $this->db->from('manage_survey');
        $this->db->where('slug', $this->uri->segment(2));
        $manage_survey = $this->db->get()->row();
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

        return view('chart_visualisasi/index', $this->data);
    }

    public function _get_data_profile($id1, $id2)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->join('users_groups', 'users.id = users_groups.user_id');
        $this->db->where('users.username', $this->session->userdata('username'));
        $data_user = $this->db->get()->row();
        $user_identity = 'drs' . $data_user->is_parent;

        $this->db->select('users.username, manage_survey.survey_name, is_question, manage_survey.slug, manage_survey.description, manage_survey.is_privacy, manage_survey.table_identity, manage_survey.atribut_pertanyaan_survey');
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

/* End of file VisualisasiController.php */
/* Location: ./application/controllers/VisualisasiController.php */