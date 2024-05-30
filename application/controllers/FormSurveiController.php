<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FormSurveiController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		if (!$this->ion_auth->logged_in()) {
			$this->session->set_flashdata('message_warning', 'You must be an admin to view this page');
			redirect('auth', 'refresh');
		}

		$this->load->library('form_validation');
		// $this->load->model('PertanyaanUnsurSurvei_model');
		$this->load->library('uuid');
	}

	public function index($id1, $id2)
	{

		$url = $this->uri->uri_string();
		$this->session->set_userdata('urlback', $url);

		$this->data = [];
		$this->data['title'] = 'Form Survei';
		$this->data['profiles'] = $this->_get_data_profile($id1, $id2);

		$this->data['data_user'] = $this->ion_auth->user()->row();

		$slug = $this->uri->segment('2');

		$this->db->select('*');
		$this->db->from('manage_survey');
		$this->db->where("slug = '$slug'");
		$this->data['manage_survey'] = $this->db->get()->row();

		$this->data['id_manage_survey'] = $this->data['manage_survey']->id;
		$this->data['is_input_alasan'] = $this->data['manage_survey']->is_input_alasan;


		return view('form_survei/index', $this->data);
	}

	public function update_header()
	{
		$slug = $this->uri->segment(2);
		$object = [
			'title_header_survey' => serialize($this->input->post('title')),
		];
		$this->db->where('slug', "$slug");
		$this->db->update('manage_survey', $object);

		$pesan = 'Data berhasil disimpan';
		$msg = ['sukses' => $pesan];
		echo json_encode($msg);
	}

	public function update_display()
	{
		$slug = $this->uri->segment(2);
		$this->db->select('*');
		$this->db->from('manage_survey');
		$this->db->where("slug = '$slug'");
		$manage_survey = $this->db->get()->row();

		$output = array('error' => false);
		if ($_FILES['userfile']['name'] != "") {

			$nama_file             = strtolower($manage_survey->table_identity);
			$config['upload_path'] = 'assets/klien/files/lampiran/';
			$config['allowed_types'] = 'pdf';
			// $config['max_size']  = 10000;
			$config['remove_space'] = TRUE;
			$config['overwrite'] = true;
			$config['detect_mime']        = TRUE;
			$config['file_name']         = $nama_file;

			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			if ($this->upload->do_upload('userfile')) {
				$uploadData = $this->upload->data();
				$object = [
					'deskripsi_opening_survey' => $this->input->post('deskripsi'),
					'is_lampiran' => $this->input->post('is_lampiran'),
					'label_lampiran' => $this->input->post('label_lampiran'),
					'file_lampiran' => $uploadData['file_name']
				];
				$this->db->where('slug', "$slug");
				$this->db->update('manage_survey', $object);
			} else {
				$this->session->set_flashdata('message_danger', 'Silahkan pilih hanya file pdf!');
				redirect(base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/form-survei', 'refresh');
			}
		} else {
			$object = [
				// 'file_lampiran' => '',
				'deskripsi_opening_survey' => $this->input->post('deskripsi'),
				'is_lampiran' => $this->input->post('is_lampiran'),
				'label_lampiran' => $this->input->post('label_lampiran')
			];
			$this->db->where('slug', "$slug");
			$this->db->update('manage_survey', $object);
		}
		$this->session->set_flashdata('message_success', 'Berhasil mengubah lampiran.');
		redirect(base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/form-survei', 'refresh');

		// echo json_encode($output);
	}


	public function update_saran()
	{
		$slug = $this->uri->segment(2);
		$object = [
			'is_saran' => $this->input->post('is_saran'),
			'judul_form_saran' => $this->input->post('judul_form_saran'),
			// 'is_input_alasan' => $this->input->post('is_input_alasan')
		];
		$this->db->where('slug', "$slug");
		$this->db->update('manage_survey', $object);

		$pesan = 'Data berhasil disimpan';
		$msg = ['sukses' => $pesan];
		echo json_encode($msg);
	}

	public function update_form_target()
	{
		$slug = $this->uri->segment(2);
		$manage_survey = $this->db->get_where('manage_survey', ['slug' => "$slug"])->row();

		$this->db->truncate("target_$manage_survey->table_identity");
		$this->db->empty_table('jawaban_pertanyaan_unsur_' . $manage_survey->table_identity);
		$this->db->empty_table('survey_' . $manage_survey->table_identity);
		$this->db->empty_table('responden_' . $manage_survey->table_identity);

		$object = [
			'is_active_target' => $this->input->post('is_active_target'),
			'is_target' => $this->input->post('2'),
			'is_question' => 1
		];
		$this->db->where('slug', "$slug");
		$this->db->update('manage_survey', $object);

		$pesan = 'Data berhasil disimpan';
		$msg = ['sukses' => $pesan];
		echo json_encode($msg);
	}

	public function do_uploud()
	{
		$slug = $this->uri->segment(2);

		$this->db->select('*');
		$this->db->from('manage_survey');
		$this->db->where("slug = '$slug'");
		$this->data['manage_survey'] = $this->db->get()->row();

		$output = array('error' => false);

		$images_logo = $_FILES['file']['name'];

		if ($images_logo != "") {

			$nama_file             = strtolower("benner_");
			$config['upload_path'] = 'assets/klien/benner_survei/';
			$config['allowed_types'] = 'png|jpg|jpeg';
			// $config['max_size']  = 10000;
			$config['remove_space'] = TRUE;
			$config['overwrite'] = true;
			$config['detect_mime']        = TRUE;
			$config['file_name']         = $nama_file . $this->data['manage_survey']->table_identity;

			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			if ($this->upload->do_upload('file')) {
				$uploadData = $this->upload->data();
				$filename = $uploadData['file_name'];

				$file['img_benner'] = $filename;

				$this->db->where("slug = '$slug'");
				$this->db->update('manage_survey', $file);
			} else {
				$output['error'] = true;
				$output['message'] = 'Silahkan pilih hanya logo png/jpg/jpeg!';
			}
		} else {
			$output['error'] = true;
			$output['message'] = 'Silahkan pilih logo yang akan diunggah!';
		}

		echo json_encode($output);
	}


	public function form_opening()
	{
		$this->data = [];
		$this->data['title'] = 'SURVEI KEPUASAN MASYARAKAT';

		$data_uri = $this->uri->segment('2');

		$this->db->select("*, DATE_FORMAT(survey_end, '%d %M %Y') AS survey_selesai, IF(CURDATE() > survey_end,1,NULL) AS survey_berakhir, IF(CURDATE() < survey_start ,1,NULL) AS survey_belum_mulai");
		$this->db->from('manage_survey');
		$this->db->join('users', 'manage_survey.id_user = users.id');
		$this->db->where("slug = '$data_uri'");
		$this->data['manage_survey'] = $this->db->get()->row();
		$this->data['judul'] = $this->data['manage_survey'];
		$this->data['status_saran'] = $this->data['manage_survey']->is_saran;

		return view('form_survei/preview/form_opening', $this->data);
	}

	public function data_responden($id1, $id2)
	{
		$this->data = [];
		$this->data['title'] = 'Data Responden';
		$this->data['profiles'] = $this->_get_data_profile($id1, $id2);

		$this->db->select("*");
		$this->db->from('manage_survey');
		$this->db->where('manage_survey.slug', $this->uri->segment(2));
		$manage_survey = $this->db->get()->row();
		$this->data['manage_survey'] = $manage_survey;

		$table_identity = $manage_survey->table_identity;
		$this->data['status_saran'] = $manage_survey->is_saran;


		//LOAD PROFIL RESPONDEN
		$this->data['profil_responden'] = $this->db->query("SELECT * FROM profil_responden_$table_identity ORDER BY IF(urutan != '',urutan,id) ASC");

		//LOAD KATEGORI PROFIL RESPONDEN JIKA PILIHAN GANDA
		$this->data['kategori_profil_responden'] = $this->db->get('kategori_profil_responden_' . $table_identity);

		return view('form_survei/preview/form_data_responden', $this->data);
	}


	public function data_pertanyaan($id1, $id2)
	{
		$this->data = [];
		$this->data['title'] = 'Pertanyaan Survei';
		$this->data['profiles'] = $this->_get_data_profile($id1, $id2);

		$this->db->select("*, DATE_FORMAT(survey_end, '%d %M %Y') AS survey_selesai, IF(CURDATE() > survey_end,1,NULL) AS survey_berakhir, IF(CURDATE() < survey_start ,1,NULL) AS survey_belum_mulai");
		$this->db->from('manage_survey');
		$this->db->where('manage_survey.slug', $this->uri->segment(2));
		$manage_survey = $this->db->get()->row();
		$table_identity = $manage_survey->table_identity;
		$this->data['manage_survey'] = $manage_survey;
		$this->data['status_saran'] = $manage_survey->is_saran;

		// $this->data['atribut_form_alasan'] = "$(this).val() == " . implode(" || $(this).val() == ", unserialize($manage_survey->atribut_form_alasan));

		if ($manage_survey->is_input_alasan == 2) {
			$this->data['atribut_form_alasan'] = "$(this).val() == 1 || $(this).val() == 2 || $(this).val() == 3";
		} else {
			$this->data['atribut_form_alasan'] = "$(this).val() == 1 || $(this).val() == 2";
		}

		$this->data['pertanyaan'] = $this->db->query("SELECT *, pertanyaan_unsur_$table_identity.id AS id_pertanyaan_unsur, isi_pertanyaan, (SELECT nama_jawaban FROM nilai_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && nilai_jawaban = 1) AS jawaban_1,
        (SELECT nama_jawaban FROM nilai_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && nilai_jawaban = 2) AS jawaban_2,
        (SELECT nama_jawaban FROM nilai_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && nilai_jawaban = 3) AS jawaban_3,
        (SELECT nama_jawaban FROM nilai_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && nilai_jawaban = 4) AS jawaban_4,
        (SELECT nama_jawaban FROM nilai_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && nilai_jawaban = 5) AS jawaban_5, (SELECT kode_unsur FROM unsur_$table_identity WHERE unsur_$table_identity.id = pertanyaan_unsur_$table_identity.id_unsur) AS kode_unsur
        FROM pertanyaan_unsur_$table_identity");

		if ($manage_survey->is_saran == 1) {
			$this->data['url_next'] = base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/form-survei/saran';
		} else {
			$this->data['url_next'] = base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/form-survei/selesai';
		}

		return view('form_survei/preview/form_pertanyaan', $this->data);
	}


	public function saran($id1, $id2)
	{
		$this->data = [];
		$this->data['title'] = 'Saran';
		$this->data['profiles'] = $this->_get_data_profile($id1, $id2);

		$this->db->select('');
		$this->db->from('manage_survey');
		$this->db->where('manage_survey.slug', $this->uri->segment(2));
		$this->data['manage_survey'] = $this->db->get()->row();

		$this->data['saran'] = [
			'name' 		=> 'saran',
			'id'		=> 'saran',
			'type'		=> 'text',
			'value'		=>	$this->form_validation->set_value('saran'),
			'class'		=> 'form-control',
			'placeholder' => 'Masukkan saran atau opini anda terhadap survei ini ..',
		];

		$this->data['url_back'] = base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/form-survei/pertanyaan';
		$this->data['url_next'] = base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/form-survei/selesai';


		return view('form_survei/preview/form_saran', $this->data);
	}


	// public function form_konfirmasi($id1, $id2)
	// {
	// 	$this->data = [];
	// 	$this->data['title'] = 'Form Konfirmasi';
	// 	$this->data['profiles'] = $this->_get_data_profile($id1, $id2);

	// 	$this->db->select('');
	// 	$this->db->from('manage_survey');
	// 	$this->db->where('manage_survey.slug', $this->uri->segment(2));
	// 	$this->data['manage_survey'] = $this->db->get()->row();
	// 	$this->data['status_saran'] = $this->data['manage_survey']->is_saran;

	// 	if ($this->data['manage_survey']->is_saran == 1) {
	// 		$this->data['url_back'] = base_url() . $this->session->userdata('username') . '/' . $this->uri->segment(2) . '/form-survei/saran';
	// 	} else {
	// 		$this->data['url_back'] = base_url() . $this->session->userdata('username') . '/' . $this->uri->segment(2)
	// 			. '/form-survei/pertanyaan';
	// 	}

	// 	return view('form_survei/preview/form_konfirmasi', $this->data);
	// }

	public function form_closing()
	{
		$this->data = [];
		$this->data['title'] = 'Sukses';

		$this->db->select('*');
		$this->db->from('manage_survey');
		$this->db->where('manage_survey.slug', $this->uri->segment(2));
		$this->data['manage_survey'] = $this->db->get()->row();
		$this->data['status_saran'] = $this->data['manage_survey']->is_saran;


		return view('form_survei/preview/form_closing', $this->data);
	}



	//==========================================================================================================
	//==========================================================================================================
	//==========================================================================================================
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

/* End of file PertanyaanKualitatifController.php */
/* Location: ./application/controllers/PertanyaanKualitatifController.php */
