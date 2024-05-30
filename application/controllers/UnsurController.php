<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UnsurController extends CI_Controller
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
		$this->data['title'] = 'Unsur';

		$this->load->library('table');

		$template = array(
			'table_open'            => '<table class="table table-bordered table-hover">',
			'table_close'           => '</table>'
		);

		$this->table->set_template($template);

		$this->data['table_unsur'] = $this->_table_unsur();

		return view('unsur/index', $this->data);
	}

	public function _table_unsur()
	{
		$this->table->set_heading('No.', 'Tahapan Pembelian', 'Dimensi',  'Bobot Dimensi', 'Kode', 'Nama tahapan', 'Bobot Unsur');

		$this->db->select('*, unsur.id AS id_unsur');
		$this->db->from('tahapan_pembelian');
		$this->db->join('dimensi', 'dimensi.id_tahapan_pembelian = tahapan_pembelian.id');
		$this->db->join('unsur', 'unsur.id_dimensi = dimensi.id');
		$data_unsur = $this->db->get();

		$no = 1;
		foreach ($data_unsur->result() as $value) {
			$this->table->add_row(
				$no++,
				$value->kode_tahapan_pembelian . '. ' . $value->nama_tahapan_pembelian,
				$value->kode_dimensi . '. ' . $value->nama_dimensi,
				$value->persentase_dimensi,
				$value->kode_unsur,
				$value->nama_unsur,
				//$value->pertanyaan_unsur . '<br>' . anchor('unsur/edit-pertanyaan/' . $value->id_unsur, '<i class="fas fa-edit"></i> Edit', ['class' => 'btn btn-light-primary btn-sm font-weight-bold shadow']),
				$value->persentase_unsur
			);
		}

		return $this->table->generate();
	}

	public function edit_pertanyaan($id = NULL)
	{
		$this->data = [];
		$this->data['title'] = 'Edit Pertanyaan';
		$this->data['form_action'] 	= 'unsur/edit-pertanyaan/' . $id;

		$this->form_validation->set_rules('pertanyaan_unsur', 'Pertanyaan Unsur', 'trim|required');

		if ($this->form_validation->run() == FALSE) {

			$search_data = $this->db->get_where('unsur', ['id' => $id]);

			if ($search_data->num_rows() == 0) {

				$this->session->set_flashdata('message_warning', 'Data Tidak ditemukan');
				redirect(base_url() . 'unsur', 'refresh');
			}

			$current = $search_data->row();

			$this->data['pertanyaan_unsur'] = [
				'name' => 'pertanyaan_unsur',
				'id' => 'kt-ckeditor-1',
				'value' => $this->form_validation->set_value('pertanyaan_unsur', $current->pertanyaan_unsur),
				'class' => 'form-control',
				'required' => 'required',
			];

			return view('unsur/edit_pertanyaan', $this->data);
		} else {

			$input 	= $this->input->post(null, TRUE);
			$object = [
				'pertanyaan_unsur'		=> $input['pertanyaan_unsur'],
			];

			$this->db->where(['id' => $id]);
			$query = $this->db->update('unsur', $object);

			if ($query) {
				$this->session->set_flashdata('message_success', 'Berhasil mengupdate data');
				redirect(base_url() . 'unsur', 'refresh');
			} else {

				$this->data['pesan_error'] = 'Gagal mengupdate data';
				return view('unsur/edit_pertanyaan', $this->data);
			}
		}
	}
}

/* End of file UnsurController.php */
/* Location: ./application/controllers/UnsurController.php */