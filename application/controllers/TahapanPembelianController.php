<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TahapanPembelianController extends CI_Controller
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
		$this->data['title'] = 'Tahapan Pembelian';

		$this->load->library('table');

		$template = array(
			'table_open'            => '<table class="table table-bordered table-hover">',
			'table_close'           => '</table>'
		);

		$this->table->set_template($template);

		$this->data['table_tahapan_pembelian'] = $this->_table_tahapan_pembelian();

		return view('tahapan_pembelian/index', $this->data);
	}

	public function _table_tahapan_pembelian()
	{
		$this->table->set_heading('No.', 'Kode', 'Nama tahapan');

		$data_tahapan_pembelian = $this->db->get('tahapan_pembelian');

		$no = 1;
		foreach ($data_tahapan_pembelian->result() as $value) {
			$this->table->add_row(
				$no++,
				$value->kode_tahapan_pembelian,
				$value->nama_tahapan_pembelian
			);
		}

		return $this->table->generate();
	}
}

/* End of file TahapanPembelianController.php */
/* Location: ./application/controllers/TahapanPembelianController.php */