<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KlasifikasiSurveiController extends CI_Controller
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

	public function index()
	{
		$this->data = [];
		$this->data['title'] = 'Klasifikasi Survei';

		$this->load->library('table');

		$template = array(
			'table_open'            => '<table class="table table-bordered table-hover">',
			'table_close'           => '</table>'
		);

		$this->table->set_template($template);

		$this->data['table_klasifikasi'] = $this->_table_klasifikasi();

		return view('klasifikasi_survei/index', $this->data);
	}

	public function _table_klasifikasi()
	{
		$this->table->set_heading('No.', 'Klasifikasi Survei');

        $data_klasifikasi = $this->db->get('klasifikasi_survey');


		$no = 1;
		foreach ($data_klasifikasi->result() as $value) {
			$this->table->add_row(
				$no++,
				$value->nama_klasifikasi_survey
			);
		}

		return $this->table->generate();
	}
}