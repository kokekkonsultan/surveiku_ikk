<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DimensiController extends CI_Controller
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

	public function index()
	{
		$this->data = [];
		$this->data['title'] = 'Dimensi';

		$this->load->library('table');

		$template = array(
			'table_open'            => '<table class="table table-bordered table-hover">',
			'table_close'           => '</table>'
		);

		$this->table->set_template($template);

		$this->data['table_dimensi'] = $this->_table_dimensi();

		return view('dimensi/index', $this->data);
	}

	public function _table_dimensi()
	{
		$this->table->set_heading('No.', 'Kode', 'Tahapan Pembelian', 'Kode', 'Dimensi', 'Bobot');

		$this->db->select('*');
		$this->db->from('tahapan_pembelian');
		$this->db->join('dimensi', 'dimensi.id_tahapan_pembelian = tahapan_pembelian.id');
		$data_dimensi = $this->db->get();

		$no = 1;
		foreach ($data_dimensi->result() as $value) {
			$this->table->add_row(
				$no++,
				$value->kode_tahapan_pembelian,
				$value->nama_tahapan_pembelian,
				$value->kode_dimensi,
				$value->nama_dimensi,
				$value->persentase_dimensi
			);
		}

		return $this->table->generate();
	}
}

/* End of file DimensiController.php */
/* Location: ./application/controllers/DimensiController.php */