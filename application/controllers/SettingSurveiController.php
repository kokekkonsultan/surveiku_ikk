<?php
defined('BASEPATH') or exit('No direct script access allowed');

require 'application/core/Klien_Controller.php';
use application\core\Klien_Controller;

class SettingSurveiController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->library('ion_auth');

		if (!$this->ion_auth->logged_in()) {
			$this->session->set_flashdata('message_warning', 'You must be logged in to access this page');
			redirect('auth', 'refresh');
		}
		$this->load->library('form_validation');
	}

	public function index($id1, $id2)
	{
		$this->data = [];
		$this->data['title'] = "Pengaturan Survei";

		$profiles = new Klien_Controller();
		$this->data['profiles'] = $profiles->_get_data_profile($id1, $id2);
		$table_identity = $this->data['profiles']->table_identity;

		$this->db->select("*");
		$this->db->from('manage_survey');
		$this->db->where('manage_survey.slug', $this->uri->segment(2));
		$this->data['manage_survey'] = $this->db->get()->row();

		$this->data['survey_start'] = [
			'name'         => 'survey_start',
			'id'        => 'survey_start',
			'type'        => 'date',
			'value'        =>    $this->form_validation->set_value('survey_start', $this->data['manage_survey']->survey_start),
			'class'        => 'form-control',
		];

		$this->data['survey_end'] = [
			'name'         => 'survey_end',
			'id'        => 'survey_end',
			'type'        => 'date',
			'value'        =>    $this->form_validation->set_value('survey_start', $this->data['manage_survey']->survey_end),
			'class'        => 'form-control',
		];

		$this->data['deskripsi_tunda'] = [
			'name'         => 'deskripsi_tunda',
			'id'        => 'deskripsi_tunda',
			'type'        => 'text',
			'value'        =>    $this->form_validation->set_value('deskripsi_tunda', $this->data['manage_survey']->deskripsi_tunda),
			'class'        => 'form-control',
			'rows' => '3'
		];

		return view('setting_survei/index', $this->data);
	}

	public function form_opening()
	{
		$this->data = [];
		$this->data['title'] = "Pengaturan Survei";

		$this->db->select("*");
		$this->db->from('manage_survey');
		$this->db->where('manage_survey.slug', $this->uri->segment(2));
		$this->data['manage_survey'] = $this->db->get()->row();

		$object = [
			'deskripsi_opening_survey' => $this->input->post('deskripsi')
		];

		$this->db->where('slug', $this->uri->segment(2));
		$this->db->update('manage_survey', $object);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('message_success', 'Berhasil mengubah header form survei');
			redirect(base_url() . $this->session->userdata('username') . '/' . $this->uri->segment(2) . '/setting-survei', 'refresh');
		} else {
			$this->data['message_data_danger'] = "Gagal mengubah header form survei";
			return view('setting_survei/index', $this->data);
		}
	}

	public function delete_survey()
	{
		$slug = $this->uri->segment(2);

		// CARI DATA UNTUK MENGHAPUS TABEL
		$this->db->select('*');
		$this->db->from('manage_survey');
		$this->db->where("slug = '$slug'");
		$current = $this->db->get()->row();

		// HAPUS TABEL
		$this->load->dbforge();
		$this->dbforge->drop_table('barang_jasa_' . $current->table_identity, TRUE);
		$this->dbforge->drop_table('kota_kab_indonesia_' . $current->table_identity, TRUE);
		$this->dbforge->drop_table('provinsi_indonesia_' . $current->table_identity, TRUE);
		$this->dbforge->drop_table('pekerjaan_utama_' . $current->table_identity, TRUE);
		$this->dbforge->drop_table('jenis_kelamin_' . $current->table_identity, TRUE);
		$this->dbforge->drop_table('umur_' . $current->table_identity, TRUE);
		$this->dbforge->drop_table('pendapatan_per_bulan_' . $current->table_identity, TRUE);
		$this->dbforge->drop_table('pendidikan_akhir_' . $current->table_identity, TRUE);
		$this->dbforge->drop_table('target_per_provinsi_' . $current->table_identity, TRUE);
		$this->dbforge->drop_table('jawaban_pertanyaan_unsur_' . $current->table_identity, TRUE);
		$this->dbforge->drop_table('nilai_unsur_pelayanan_' . $current->table_identity, TRUE);
		$this->dbforge->drop_table('pertanyaan_unsur_' . $current->table_identity, TRUE);
		$this->dbforge->drop_table('survey_' . $current->table_identity, TRUE);
		$this->dbforge->drop_table('responden_' . $current->table_identity, TRUE);

		// HAPUS DATA TABEL SURVEY
		$this->db->where('id', $current->id);
		$this->db->delete('manage_survey');

		echo json_encode(array("status" => TRUE));
	}

	public function setting_general($id1, $id2)
	{
		$this->data = [];
		$this->data['title'] = "Settings";

		$profiles = new Klien_Controller();
		$this->data['profiles'] = $profiles->_get_data_profile($id1, $id2);
		$table_identity = $this->data['profiles']->table_identity;

		$slug = $id2;

		$this->db->select('*');
		$this->db->from('manage_survey');
		$this->db->where("slug = '$slug'");
		$current = $this->db->get()->row();

		$this->data['id_manage_survey'] = $current->id;
		$this->data['atribut_pertanyaan_survey'] = unserialize($current->atribut_pertanyaan_survey);

		return view('setting_survei/form_settings', $this->data);
	}

	public function periode()
	{
		$slug = $this->uri->segment(2);

		if ($this->input->post('hapus_periode') == 1) {
			$this->db->set('survey_start', NULL);
			$this->db->set('survey_end', NULL);
			$this->db->where('slug', "$slug");
			$this->db->update('manage_survey');
		} else {
			$object = [
				'survey_start' => $this->input->post('survey_start'),
				'survey_end' => $this->input->post('survey_end'),
			];
			$this->db->where('slug', "$slug");
			$this->db->update('manage_survey', $object);
		}

		$pesan = 'Data berhasil disimpan';
		$msg = ['sukses' => $pesan];
		echo json_encode($msg);
	}

	public function tunda()
	{
		$slug = $this->uri->segment(2);
		$object = [
			'is_privacy' => $this->input->post('is_privacy'),
			'deskripsi_tunda' => $this->input->post('deskripsi_tunda')
		];
		$this->db->where('slug', "$slug");
		$this->db->update('manage_survey', $object);

		$pesan = 'Data berhasil disimpan';
		$msg = ['sukses' => $pesan];
		echo json_encode($msg);
	}
}
