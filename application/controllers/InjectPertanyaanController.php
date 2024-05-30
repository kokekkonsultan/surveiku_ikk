<?php
defined('BASEPATH') or exit('No direct script access allowed');

class InjectPertanyaanController extends CI_Controller
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
		$this->data['title'] = 'Inject Pertanyaan Ke Survei';

		// $this->form_validation->set_rules('id_klasifikasi_survey', 'Klasifikasi Survey', 'trim|required');
		// $this->form_validation->set_rules('id_survey[]', 'Survey', 'trim|required');

		return view('inject_pertanyaan/index', $this->data);
	}

	public function get()
	{
		$id_klasifikasi_survey = $this->input->post('id_klasifikasi_survey');
		$id_survey = implode(", ", $this->input->post('id_survey'));


		foreach ($this->db->query("SELECT * FROM manage_survey WHERE id IN ($id_survey)")->result() as $row) {

			$this->db->empty_table("trash_jawaban_pertanyaan_unsur_$row->table_identity");
			$this->db->empty_table("trash_survey_$row->table_identity");
			$this->db->empty_table("trash_responden_$row->table_identity");
			$this->db->empty_table("jawaban_pertanyaan_unsur_$row->table_identity");
			$this->db->empty_table("survey_$row->table_identity");
			$this->db->empty_table("responden_$row->table_identity");
			$this->db->empty_table("nilai_unsur_pelayanan_$row->table_identity");
			$this->db->empty_table("pertanyaan_unsur_$row->table_identity");
			$this->db->empty_table("unsur_$row->table_identity");


			$this->db->query(
				"INSERT INTO unsur_$row->table_identity
				SELECT unsur.id, id_dimensi, kode_unsur, nama_unsur, persentase_unsur
				FROM unsur
				JOIN dimensi ON dimensi.id = unsur.id_dimensi
				JOIN tahapan_pembelian ON dimensi.id_tahapan_pembelian = tahapan_pembelian.id
				WHERE tahapan_pembelian.id_klasifikasi_survey = $id_klasifikasi_survey;"
			);

			$this->db->query(
				"INSERT INTO pertanyaan_unsur_$row->table_identity
				SELECT pertanyaan_unsur.id, pertanyaan_unsur.id_unsur, pertanyaan_unsur.isi_pertanyaan, pertanyaan_unsur.is_active_alasan, pertanyaan_unsur.label_alasan, pertanyaan_unsur.atribute_alasan
				FROM pertanyaan_unsur
				JOIN unsur ON pertanyaan_unsur.id_unsur = unsur.id
				JOIN dimensi ON dimensi.id = unsur.id_dimensi
				JOIN tahapan_pembelian ON dimensi.id_tahapan_pembelian = tahapan_pembelian.id
				WHERE tahapan_pembelian.id_klasifikasi_survey = $id_klasifikasi_survey;"
			);

			$this->db->query(
				"INSERT INTO nilai_unsur_pelayanan_$row->table_identity
					SELECT nilai_unsur_pelayanan.id, nilai_unsur_pelayanan.id_pertanyaan_unsur, nilai_unsur_pelayanan.nilai_jawaban, nilai_unsur_pelayanan.nama_jawaban
					FROM nilai_unsur_pelayanan
					JOIN pertanyaan_unsur ON nilai_unsur_pelayanan.id_pertanyaan_unsur = pertanyaan_unsur.id
					JOIN unsur ON pertanyaan_unsur.id_unsur = unsur.id
					JOIN dimensi ON dimensi.id = unsur.id_dimensi
					JOIN tahapan_pembelian ON dimensi.id_tahapan_pembelian = tahapan_pembelian.id
					WHERE tahapan_pembelian.id_klasifikasi_survey = $id_klasifikasi_survey;"
			);
		}

		$pesan = 'Data berhasil disimpan';
		$msg = ['sukses' => $pesan];
		echo json_encode($msg);
	}
}
