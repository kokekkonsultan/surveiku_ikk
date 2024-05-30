<?php
defined('BASEPATH') or exit('No direct script access allowed');

require 'application/core/Klien_Controller.php';

use application\core\Klien_Controller;

class LinkSurveiController extends CI_Controller
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
        $this->data['title'] = "Link Survey";

        $profiles =  $this->_get_data_profile($id1, $id2);
        $this->data['profiles'] = $profiles;
        $this->data['form_action'] = base_url() . $id1 . '/' . $id2 . '/confirm-question';

        $this->data['sektor'] = $this->db->get('sektor_' . $profiles->table_identity)->num_rows();
        $this->data['wilayah_survei'] = $this->db->get('wilayah_survei_' . $profiles->table_identity)->num_rows();
        $this->data['target'] = $this->db->get('target_' . $profiles->table_identity)->num_rows();

        if ($this->data['profiles']->is_active_target == 1) {
            $this->data['target_survei'] = $this->db->get('target_' . $profiles->table_identity)->num_rows() > 0;
        } else {
            $this->data['target_survei'] = $this->db->get('target_' . $profiles->table_identity)->num_rows() == 0;
        }

        $this->data['target_online'] = $this->db->get_where('target_' . $profiles->table_identity, array('target_online' => NULL))->num_rows();

        $this->data['target_offline'] = $this->db->get_where('target_' . $profiles->table_identity, array('target_offline' => NULL))->num_rows();


        // var_dump($this->data['target_offline']);



        $this->data['pertanyaan_unsur'] = $this->db->query("SELECT SUM(persentase_unsur) AS total_persentase FROM unsur_$profiles->table_identity")->row()->total_persentase;

        return view('link_survei/index', $this->data);
    }


    public function confirm_question($id1, $id2)
    {
        $slug = $this->uri->segment('2');

        $this->db->select('*');
        $this->db->from('manage_survey');
        $this->db->where("slug = '$slug'");
        $current = $this->db->get()->row();

        $target = [
            'is_question' => $this->input->post('is_question'),
            'is_dimensi' => 1
        ];

        $this->db->empty_table('jawaban_pertanyaan_unsur_' . $current->table_identity);
        $this->db->empty_table('survey_' . $current->table_identity);
        $this->db->empty_table('responden_' . $current->table_identity);
        $this->db->where('id', $current->id);
        $this->db->update('manage_survey', $target);

        $pesan = 'Request berhasil dilakukan';
        $msg = ['sukses' => $pesan];
        echo json_encode($msg);
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
