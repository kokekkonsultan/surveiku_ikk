<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PertanyaanController extends CI_Controller
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
		$this->load->model('Pertanyaan_model', 'models');
	}

	public function index()
	{
		$this->data = [];
		$this->data['title'] = 'Pertanyaan';

		return view('pertanyaan/index', $this->data);
	}

	public function ajax_list()
	{
		$list = $this->models->get_datatables();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $value) {

			$pilihan_jawaban = '<label><input type="radio">&ensp;' . $value->pilihan_1 . '&emsp;</label><br><label><input type="radio">&ensp;' . $value->pilihan_2 . '&emsp;</label><br><label><input type="radio">&ensp;' . $value->pilihan_3 . '&emsp;</label><br><label><input type="radio">&ensp;' . $value->pilihan_4 . '&emsp;</label><br><label><input type="radio">&ensp;' . $value->pilihan_5 . '&emsp;</label>';
			
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = '<b class="text-primary">' . $value->kode_dimensi . '. ' . $value->nama_dimensi . '</b><hr>' . $value->kode_unsur . '. ' . $value->nama_unsur . '<hr><b>Bobot Unsur : ' . $value->persentase_unsur . ' %</b>';
			$row[] = $value->isi_pertanyaan;
			$row[] = $pilihan_jawaban;
			$row[] = anchor('/pertanyaan/edit/' . $value->id, '<i class="fa fa-edit"></i> Edit', ['class' => 'btn btn-light-primary btn-sm font-weight-bold shadow']);
			// $row[] = '<a class="btn btn-light-primary btn-sm font-weight-bold shadow" href="javascript:void(0)" title="Hapus ' . $value->id . '" onclick="delete_data(' . "'" . $value->id . "'" . ')">Delete</a>';

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->models->count_all(),
			"recordsFiltered" => $this->models->count_filtered(),
			"data" => $data,
		);

		echo json_encode($output);
	}

	public function edit($username)
	{
		$this->data = [];
		$this->data['title'] = 'Edit Pertanyaan';
		$this->data['form_action']     = "pertanyaan/edit/$username";


		$this->form_validation->set_rules('pertanyaan_unsur', 'Pertanyaan Unsur', 'trim|required');

		$current = $this->db->get_where('pertanyaan_unsur', ['id' => $this->uri->segment(3)])->row();;

		$this->data['pertanyaan_unsur'] = [
			'name' => 'pertanyaan_unsur',
			'id' => 'kt-ckeditor-1',
			'value' => $this->form_validation->set_value('pertanyaan_unsur', $current->isi_pertanyaan),
			'class' => 'form-control',
			'required' => 'required',
			'autofocus' => 'autofocus'
		];

		$this->data['pertanyaan'] = $current;

		$this->data['nilai_unsur_pelayanan'] = $this->db->get_where('nilai_unsur_pelayanan', array('id_pertanyaan_unsur' => $this->uri->segment(3)))->result();

		if ($this->form_validation->run() == FALSE) {

			return view('pertanyaan/edit', $this->data);

		} else {

			$input     = $this->input->post(NULL, TRUE);
			if($this->input->post('label_alasan') != ''){
                $label_alasan = $this->input->post('label_alasan');
            } else{
                $label_alasan = 'Masukkan alasan jawaban pada bidang ini ...';
            };
              
            if(serialize($this->input->post('atribute_alasan')) != 'N;'){
                $atribute_alasan = serialize($this->input->post('atribute_alasan'));
            } else {
                $atribute_alasan = 'a:2:{i:0;s:1:"1";i:1;s:1:"2";}';
            };

			$object = [
				'isi_pertanyaan'     => $input['pertanyaan_unsur'],
				'is_active_alasan' => $this->input->post('is_active_alasan'),
				'label_alasan' => $label_alasan,
				'atribute_alasan' => $atribute_alasan
			];
			// var_dump($object);

			$this->db->where('id', $username);
			$this->db->update('pertanyaan_unsur', $object);

			$id = $input['id'];
			$nama_jawaban = $input['nama_jawaban'];


			for ($i = 0; $i < sizeof($id); $i++) {
				$kategori = array(
					'id' => $id[$i],
					'nama_jawaban' => $nama_jawaban[$i]
				);
				$this->db->where('id', $id[$i]);
				$this->db->update('nilai_unsur_pelayanan', $kategori);
			}

			$this->session->set_flashdata('message_success', 'Berhasil mengubah pertanyaan unsur');
			redirect(base_url() . 'pertanyaan', 'refresh');

			// if ($this->db->affected_rows() > 0) {
			//     $this->session->set_flashdata('message_success', 'Berhasil mengubah pertanyaan unsur');
			//     redirect(base_url() . $username . '/' . $this->uri->segment(2) . '/pertanyaan-unsur', 'refresh');
			// } else {
			//     $this->data['message_data_danger'] = "Gagal mengubah pertanyaan unsur";
			//     return view('pertanyaan_unsur_survei/edit', $this->data);
			// }
		}
	}
}