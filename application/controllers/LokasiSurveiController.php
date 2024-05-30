<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LokasiSurveiController extends CI_Controller {

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
		$this->data['title'] = 'Lokasi Survei';

		return view('lokasi_survei/list_provinsi', $this->data);
	}

	public function ajax_list()
	{
		$this->load->model('Provinsi_model');

		$list = $this->Provinsi_model->get_datatables();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $value) {

			$no++;
			$row = array();
			$row[] = $no;
			//$row[] = '<a href="'.base_url().'lokasi-survei/kota-kab/'.$value->id.'"><div class="card card-body shadow bg-secondary text-dark font-weight-bold">'.$no.'. '.$value->nama_provinsi.'</div></a>';
			$row[] = '<a href="'.base_url().'lokasi-survei/kota-kab/'.$value->id.'">'.$value->nama_provinsi.'</a>';
			$row[] = anchor(base_url().'lokasi-survei/kota-kab/'.$value->id, 'List Kota/Kabupaten', ['class' => 'btn btn-secondary btn-sm font-weight-bold']);
			$row[] = anchor(base_url().'lokasi-survei/edit-provinsi/'.$value->id, 'Edit', ['class' => 'btn btn-secondary btn-sm font-weight-bold']);
			$row[] = anchor(base_url().'lokasi-survei/delete-provinsi/'.$value->id, 'Delete', ['class' => 'btn btn-secondary btn-sm font-weight-bold', 'onclick' => "return confirm('Anda yakin ingin menghapus provinsi ?')"]);

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Provinsi_model->count_all(),
			"recordsFiltered" => $this->Provinsi_model->count_filtered(),
			"data" => $data,
		);

		echo json_encode($output);
	}

	public function kota_kab($id)
	{
		$nama_prov = $this->db->get_where('wilayah_provinsi', ['id' => $id])->row()->nama_provinsi;
		$this->data = [];
		$this->data['title'] = 'Kota Kabupaten Dari Provinsi '.$nama_prov;
		$this->data['id_propinsi'] = $id;

		return view('lokasi_survei/list_kota_kab', $this->data);
	}

	public function ajax_list_kota_kab()
	{
		$this->load->model('KotaKabupaten_model');

		$list = $this->KotaKabupaten_model->get_datatables();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $value) {

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $value->nama_kota_kabupaten;
			$row[] = anchor(base_url().'lokasi-survei/edit-kota-kabupaten/'.$value->id, 'Edit', ['class' => 'btn btn-secondary btn-sm font-weight-bold']);
			$row[] = anchor(base_url().'lokasi-survei/delete-kota-kabupaten/'.$value->id, 'Delete', ['class' => 'btn btn-secondary btn-sm font-weight-bold', 'onclick' => "return confirm('Anda yakin ingin menghapus kota/kabupaten ?')"]);

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->KotaKabupaten_model->count_all(),
			"recordsFiltered" => $this->KotaKabupaten_model->count_filtered(),
			"data" => $data,
		);

		echo json_encode($output);
	}

	// CRUD PROVINSI
	public function create_provinsi()
	{
		$this->data = [];
		$this->data['title'] = "Create Provinsi";
		return view("lokasi_survei/create_provinsi", $this->data);
	}

	public function insert_provinsi()
	{
		$this->data = [];
		$this->data['title'] = "Create Provinsi";
		$nama_provinsi = trim($this->input->post('nama_provinsi'));
		$check_id_provinsi = $this->db->query("SELECT * FROM wilayah_provinsi ORDER BY id DESC")->row();
		$id_provinsi = $check_id_provinsi->id+1;

		$this->form_validation->set_rules('nama_provinsi', 'Nama Provinsi', 'required');

		if ($this->form_validation->run() == false) {
            return view('lokasi_survei/create_provinsi', $this->data);
        } else {
			$this->db->insert('wilayah_provinsi', ['id' => $id_provinsi, 'nama_provinsi' => $nama_provinsi]);
			//$this->session->set_flashdata('message', 'Provinsi berhasil disimpan');
			redirect(base_url().'lokasi-survei','refresh');
		}
	}

	public function edit_provinsi($id)
	{
		$this->data = [];
		$this->data['title'] = 'Edit Provinsi';
		$this->data['data_provinsi'] = $this->db->get_where('wilayah_provinsi', ['id' => $id])->row();

		$this->form_validation->set_rules('nama_provinsi', 'Nama Provinsi', 'required');

		if ($this->form_validation->run() == false) {
            return view('lokasi_survei/edit_provinsi', $this->data);
        } else {
			$input = $this->input->post(null, true);
            $nama_provinsi = trim($input['nama_provinsi']);
			$data = array(
				'nama_provinsi'  => $nama_provinsi
			);
			$this->db->where('id', $id);
			$query = $this->db->update('wilayah_provinsi', $data);
            if ($query == true) {
				//$this->session->set_flashdata('message', 'Provinsi berhasil disimpan');
                redirect(base_url().'lokasi-survei','refresh');
            } else {
                return view('lokasi_survei/edit_provinsi', $this->data);
            }
        }
	}

	public function delete_provinsi($id)
	{
		$this->db->where('id', $id);
        $this->db->delete('wilayah_provinsi');
		//$this->session->set_flashdata('message', 'Provinsi berhasil dihapus');
		redirect(base_url().'lokasi-survei', 'refresh');
	}

	// CRUD KOTA/KABUPATEN
	public function create_kota_kabupaten($id)
	{
		$this->data = [];
		$this->data['title'] = "Create Kota/Kabupaten";
		$this->data['provinsi_id'] = $id;
		return view("lokasi_survei/create_kota_kabupaten", $this->data);
	}

	public function insert_kota_kabupaten()
	{
		$this->data = [];
		$this->data['title'] = "Create Kota/Kabupaten";
		$this->data['provinsi_id'] = trim($this->input->post('provinsi_id'));
		$nama_kota_kabupaten = trim($this->input->post('nama_kota_kabupaten'));
		$provinsi_id = trim($this->input->post('provinsi_id'));
		$check_id_kota = $this->db->query("SELECT * FROM wilayah_kota_kabupaten ORDER BY id DESC")->row();
		$id_kota = $check_id_kota->id+1;

		$this->form_validation->set_rules('nama_kota_kabupaten', 'Nama Kota/Kabupaten', 'required');

		if ($this->form_validation->run() == false) {
            return view('lokasi_survei/create_kota_kabupaten', $this->data);
        } else {
			$this->db->insert('wilayah_kota_kabupaten', ['id' => $id_kota, 'provinsi_id' => $provinsi_id, 'nama_kota_kabupaten' => $nama_kota_kabupaten]);
			redirect(base_url().'lokasi-survei/kota-kab/'.$provinsi_id,'refresh');
		}
	}
	
	public function edit_kota_kabupaten($id)
	{
		$this->data = [];
		$this->data['title'] = 'Edit Kota/Kabupaten';
		$this->data['data_kota_kabupaten'] = $this->db->get_where('wilayah_kota_kabupaten', ['id' => $id])->row();
		$this->data['provinsi_id'] = $this->data['data_kota_kabupaten']->provinsi_id;

		$this->form_validation->set_rules('nama_kota_kabupaten', 'Nama Kota/Kabupaten', 'required');

		if ($this->form_validation->run() == false) {
            return view('lokasi_survei/edit_kota_kabupaten', $this->data);
        } else {
			$input = $this->input->post(null, true);
            $nama_kota_kabupaten = trim($input['nama_kota_kabupaten']);
			$data = array(
				'nama_kota_kabupaten'  => $nama_kota_kabupaten
			);
			$this->db->where('id', $id);
			$query = $this->db->update('wilayah_kota_kabupaten', $data);
            if ($query == true) {
                redirect(base_url().'lokasi-survei/kota-kab/'.$this->data['provinsi_id'],'refresh');
            } else {
                return view('lokasi_survei/edit_kota_kabupaten', $this->data);
            }
        }
	}

	public function delete_kota_kabupaten($id)
	{
		$this->data = [];
		$this->data['data_kota_kabupaten'] = $this->db->get_where('wilayah_kota_kabupaten', ['id' => $id])->row();
		$this->data['provinsi_id'] = $this->data['data_kota_kabupaten']->provinsi_id;

		$this->db->where('id', $id);
        $this->db->delete('wilayah_kota_kabupaten');
		
		redirect(base_url().'lokasi-survei/kota-kab/'.$this->data['provinsi_id'], 'refresh');
	}

}

/* End of file LokasiSurveiController.php */
/* Location: ./application/controllers/LokasiSurveiController.php */