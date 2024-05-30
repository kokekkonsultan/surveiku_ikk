<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DataPerolehanSurveiController extends CI_Controller
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

	public function index($id1, $id2)
	{
		$url = $this->uri->uri_string();
		$this->session->set_userdata('urlback', $url);

		$this->data = [];
		$this->data['title'] = 'Data Perolehan Survei';
		$this->data['profiles'] = $this->_get_data_profile($id1, $id2);

		$this->db->select('manage_survey.id AS id_manage_survey, manage_survey.table_identity AS table_identity');
		$this->db->from('manage_survey');
		$this->db->where('manage_survey.slug', $this->uri->segment(2));
		$manage_survey = $this->db->get()->row();

		//PANGGIL PROFIL RESPONDEN
		$this->data['profil'] = $this->db->query("SELECT * FROM profil_responden_$manage_survey->table_identity ORDER BY IF(urutan != '',urutan,id) ASC")->result();

		//PANGGIL PROFIL RESPONDEN UNTUK FILTER
		$this->data['profil_responden_filter'] = $this->db->query("SELECT *,  REPLACE(LOWER(nama_profil_responden), ' ', '_') AS nama_alias FROM profil_responden_$manage_survey->table_identity WHERE jenis_isian = 1");

		//LOAD KATEGORI PROFIL RESPONDEN JIKA PILIHAN GANDA
		$this->data['kategori_profil_responden'] = $this->db->get('kategori_profil_responden_' . $manage_survey->table_identity);

		return view('data_perolehan_survei/index', $this->data);
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
			
			$row[] = '<b>' . $value->kode_surveyor . '</b>--' . $value->first_name . ' ' . $value->last_name;


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


	public function delete()
	{
		$this->db->select('*');
		$this->db->from('manage_survey');
		$this->db->where('manage_survey.slug', $this->uri->segment(2));
		$manage_survey = $this->db->get()->row();

		$id_survey = $this->db->get_where("survey_$manage_survey->table_identity", array('id_responden' => $this->uri->segment(5)))->row()->id;

		$this->db->delete('jawaban_pertanyaan_unsur_' . $manage_survey->table_identity, array('id_survey' => $id_survey));
		$this->db->delete('survey_' . $manage_survey->table_identity, array('id_responden' => $this->uri->segment(5)));
		$this->db->delete('responden_' . $manage_survey->table_identity, array('id' => $this->uri->segment(5)));

		echo json_encode(array("status" => TRUE));
	}




	public function export()
	{
		$this->data = [];
		$this->data['title'] = "Perolehan Survei";

		$slug = $this->uri->segment(2);

		$manage_survey = $this->db->get_where('manage_survey', ['slug' => "$slug"])->row();
		$table_identity = $manage_survey->table_identity;
		$this->data['is_saran'] = $manage_survey->is_saran;

		$this->data['unsur'] = $this->db->query("SELECT *, SUBSTR(kode_unsur,2) AS kode_alasan
		FROM unsur_$table_identity
		JOIN pertanyaan_unsur_$table_identity ON unsur_$table_identity.id = pertanyaan_unsur_$table_identity.id_unsur
		");

		//PANGGIL PROFIL RESPONDEN
		$this->data['profil'] = $this->db->query("SELECT * FROM profil_responden_$table_identity ORDER BY IF(urutan != '',urutan,id) ASC");

		$data_profil = [];
		foreach ($this->data['profil']->result() as $get) {
			if ($get->id != 1 || $get->id != 2) {
				if ($get->jenis_isian == 1) {

					$data_profil[] = "(SELECT nama_kategori_profil_responden FROM kategori_profil_responden_$table_identity WHERE responden_$table_identity.$get->nama_alias = kategori_profil_responden_$table_identity.id) AS $get->nama_alias";
				} else {
					$data_profil[] = $get->nama_alias;
				}
			}
		}
		$query_profil = implode(",", $data_profil);

		$this->db->select("*, responden_$table_identity.uuid AS uuid_responden, (SELECT first_name FROM users WHERE users.id = surveyor.id_user) AS first_name, (SELECT last_name FROM users WHERE users.id = surveyor.id_user) AS last_name, survey_$table_identity.id AS id_survey, $query_profil, (SELECT nama_sektor FROM sektor_$table_identity WHERE responden_$table_identity.sektor = sektor_$table_identity.id) AS sektor, (SELECT nama_wilayah FROM wilayah_survei_$table_identity WHERE responden_$table_identity.sektor = wilayah_survei_$table_identity.id) AS wilayah_survei");
		$this->db->from("responden_$table_identity");
		$this->db->join("survey_$table_identity", "responden_$table_identity.id = survey_$table_identity.id_responden");
		$this->db->join("surveyor", "survey_$table_identity.id_surveyor = surveyor.id", "left");
		$this->db->where('is_submit', 1);
		$this->data['survey'] = $this->db->get();
		// var_dump($this->data['survey']->result());

		$this->data['colspan'] = $this->data['profil']->num_rows() + ($this->data['unsur']->num_rows() * 2) + 5;

		$this->data['jawaban_unsur'] = $this->db->get("jawaban_pertanyaan_unsur_$table_identity");

		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=$slug.xls");

		$this->load->view('data_perolehan_survei/cetak', $this->data);
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