<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KelompokSkalaController extends CI_Controller
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
		$this->data['title'] = 'Kelompok Skala';

		$this->load->library('table');

		$template = array(
			'table_open'            => '<table class="table table-bordered table-hover">',
			'table_close'           => '</table>'
		);

		$this->table->set_template($template);

		$this->data['table_kelompok_skala'] = $this->_table_kelompok_skala();

		return view('kelompok_skala/index', $this->data);
	}

	public function _table_kelompok_skala()
	{
		$this->table->set_heading('No.', 'Kelompok Skala');

        $data_kelompok_skala = $this->db->get('kelompok_skala');


		$no = 1;
		foreach ($data_kelompok_skala->result() as $value) {
			$this->table->add_row(
				$no++,
				$value->nama_kelompok_skala
			);
		}

		return $this->table->generate();
	}
}