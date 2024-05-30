<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KriteriaRespondenController extends CI_Controller
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
		$this->data['title'] = 'Nilai SKM';

		$this->data['table_jenis_kelamin'] = $this->_jenis_kelamin();
		$this->data['table_umur'] = $this->_umur();
		$this->data['table_pendidikan_akhir'] = $this->_pendidikan_akhir();
		$this->data['table_pekerjaan_utama'] = $this->_pekerjaan_utama();
		$this->data['table_barang_jasa'] = $this->_barang_jasa();
		$this->data['table_pendapatan'] = $this->_pendapatan();


		return view('kriteria_responden/index', $this->data);
	}

	public function _barang_jasa()
	{
		$this->load->library('table');

		$template = array(
			'table_open'            => '<table class="table table-bordered table-hover">',
			'table_close'           => '</table>'
		);

		$this->table->set_template($template);

		$this->table->set_heading('NO', 'BARANG / JASA');

		$get_data = $this->db->get('barang_jasa');

		$no = 1;
		foreach ($get_data->result() as $value) {
			$this->table->add_row(
				$no++,
				$value->nama_barang_jasa
			);
		}

		return $this->table->generate();
	}

	public function _jenis_kelamin()
	{
		$this->load->library('table');

		$template = array(
			'table_open'            => '<table class="table table-bordered table-hover">',
			'table_close'           => '</table>'
		);

		$this->table->set_template($template);

		$this->table->set_heading('NO', 'JENIS KELAMIN');

		$get_data = $this->db->get('jenis_kelamin');

		$no = 1;
		foreach ($get_data->result() as $value) {
			$this->table->add_row(
				$no++,
				$value->jenis_kelamin_responden
			);
		}

		return $this->table->generate();
	}

	public function _umur()
	{
		$this->load->library('table');

		$template = array(
			'table_open'            => '<table class="table table-bordered table-hover">',
			'table_close'           => '</table>'
		);

		$this->table->set_template($template);

		$this->table->set_heading('NO', 'UMUR RESPONDEN');

		$get_data = $this->db->get('umur');

		$no = 1;
		foreach ($get_data->result() as $value) {
			$this->table->add_row(
				$no++,
				$value->umur_responden
			);
		}

		return $this->table->generate();
	}

	public function _pendidikan_akhir()
	{
		$this->load->library('table');

		$template = array(
			'table_open'            => '<table class="table table-bordered table-hover">',
			'table_close'           => '</table>'
		);

		$this->table->set_template($template);

		$this->table->set_heading('NO', 'PENDIDIKAN TERAKHIR');

		$get_data = $this->db->get('pendidikan_akhir');

		$no = 1;
		foreach ($get_data->result() as $value) {
			$this->table->add_row(
				$no++,
				$value->pendidikan_akhir_responden
			);
		}

		return $this->table->generate();
	}

	public function _pekerjaan_utama()
	{
		$this->load->library('table');

		$template = array(
			'table_open'            => '<table class="table table-bordered table-hover">',
			'table_close'           => '</table>'
		);

		$this->table->set_template($template);

		$this->table->set_heading('NO', 'PEKERJAAN UTAMA');

		$get_data = $this->db->get('pekerjaan_utama');

		$no = 1;
		foreach ($get_data->result() as $value) {
			$this->table->add_row(
				$no++,
				$value->pekerjaan_utama_responden
			);
		}

		return $this->table->generate();
	}

	public function _pendapatan()
	{
		$this->load->library('table');

		$template = array(
			'table_open'            => '<table class="table table-bordered table-hover">',
			'table_close'           => '</table>'
		);

		$this->table->set_template($template);

		$this->table->set_heading('NO', 'PENDAPATAN PER BULAN');

		$get_data = $this->db->get('pendapatan_per_bulan');

		$no = 1;
		foreach ($get_data->result() as $value) {
			$this->table->add_row(
				$no++,
				$value->pendapatan_per_bulan_responden
			);
		}

		return $this->table->generate();
	}
}

/* End of file kriteriaRespondenController.php */
/* Location: ./application/controllers/kriteriaRespondenController.php */