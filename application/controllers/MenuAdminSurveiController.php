<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DataPerolehanOnlineController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		if (!$this->ion_auth->logged_in()) {
			$this->session->set_flashdata('message_warning', 'You must be an admin to view this page');
			redirect('auth', 'refresh');
		}
		$this->load->model('DataPerolehanOnline_model', 'models');
	}

	public function index($id1, $id2)
	{
		$this->data = [];
		$this->data['title'] = 'Data Perolehan Online';
        $this->data['profiles'] = $this->_get_data_profile($id1, $id2);


        $manage_survey = $this->db->get_where('manage_survey', ['slug' => $this->uri->segment(2)])->row();
		$this->data['profil'] = $this->db->query("SELECT * FROM profil_responden_$manage_survey->table_identity ORDER BY IF(urutan != '',urutan,id) ASC")->result();

		return view('data_perolehan_online/index', $this->data);
	}

	public function ajax_list()
	{
		$slug = $this->uri->segment(2);
		$get_identity = $this->db->get_where('manage_survey', ['slug' => "$slug"])->row();
		$table_identity = $get_identity->table_identity;

		//PANGGIL PROFIL RESPONDEN
		$profil_responden = $this->db->query("SELECT * FROM profil_responden_$table_identity ORDER BY IF(urutan != '',urutan,id) ASC")->result();

		$list = $this->models->get_datatables($table_identity, $profil_responden);
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $value) {

			if ($value->is_submit == 1) {
				$status = '<span class="badge badge-primary">Valid</span>';
			} else {
				$status = '<span class="badge badge-danger">Tidak Valid</span><br>
				<small class="text-dark-50 font-italic">' . $value->is_end . '</small>';
			}

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $status;
			$row[] = anchor($this->uri->segment(2) . '/hasil-survei/' . $value->uuid_responden, '<i class="fas fa-file-pdf text-danger"></i>', ['target' => '_blank']);


			foreach ($profil_responden as $get) {
				$profil = $get->nama_alias;
				$row[] = str_word_count($value->$profil) > 5 ? substr($value->$profil, 0, 50) . ' [...]' : $value->$profil;
			}

			$row[] = date("d-m-Y", strtotime($value->waktu_isi));

			$row[] = anchor('/survei/' . $slug . '/data-responden/'  . $value->uuid_responden . '/edit', '<i class="fa fa-edit"></i> Edit', ['class' => 'btn btn-light-primary btn-sm font-weight-bold shadow', 'target' => '_blank']);

			$row[] = '<a class="btn btn-light-primary btn-sm font-weight-bold shadow" href="javascript:void(0)" title="Hapus ' . $value->nama_lengkap . '" onclick="delete_data(' . "'" . $value->id_responden . "'" . ')"><i class="fa fa-trash"></i> Delete</a>';

			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->models->count_all($table_identity, $profil_responden),
			"recordsFiltered" => $this->models->count_filtered($table_identity, $profil_responden),
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