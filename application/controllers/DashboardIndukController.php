<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DashboardIndukController extends CI_Controller
{

	var $column_order 		= array(null, null);
	var $column_search 		= array('manage_survey.survey_name');
	var $order 				= array('manage_survey.id' => 'asc');

	public function __construct()
	{
		parent::__construct();

		$this->load->library('ion_auth');

		if (!$this->ion_auth->logged_in()) {
			$this->session->set_flashdata('message_warning', 'You must be logged in to access this page');
			redirect('auth', 'refresh');
		}
		$this->load->model('ManageSurvey_model', 'models');
	}
	
	public function get_chart_survei()
	{
		$this->data = [];
		$this->data['title'] = 'Dashboard Chart';

        $klien_induk = $this->db->get_where("pengguna_klien_induk", array('id_user' => $this->session->userdata('user_id')))->row();
		$parent = implode(", ", unserialize($klien_induk->cakupan_induk));

        $this->db->select( '*, manage_survey.slug AS slug_manage_survey, (SELECT first_name FROM users WHERE users.id = manage_survey.id_user) AS first_name, (SELECT last_name FROM users WHERE users.id = manage_survey.id_user) AS last_name');
        $this->db->from('manage_survey');
        $this->db->where("id IN ($parent)");

		$manage_survey = $this->db->get();

		if ($manage_survey->num_rows() > 0) {

			$nama_survei = [];
			$skor_akhir = [];
			$no = 1;
			foreach ($manage_survey->result() as $value) {

				if ($this->db->get("jawaban_pertanyaan_unsur_$value->table_identity")->num_rows() > 0) {

					$nilai_per_unsur[$no] = $this->db->query("SELECT kode_unsur, persentase_unsur, (SELECT AVG(skor_jawaban) FROM jawaban_pertanyaan_unsur_$value->table_identity
					JOIN survey_$value->table_identity ON jawaban_pertanyaan_unsur_$value->table_identity.id_survey = survey_$value->table_identity.id
					WHERE id_pertanyaan_unsur = pertanyaan_unsur_$value->table_identity.id && is_submit = 1) AS rata_per_unsur,
					
					(SELECT unsur_$value->table_identity.persentase_unsur / 100) AS persentase_unsur_dibagi_100,
					
					((SELECT AVG(skor_jawaban) FROM jawaban_pertanyaan_unsur_$value->table_identity
					JOIN survey_$value->table_identity ON jawaban_pertanyaan_unsur_$value->table_identity.id_survey = survey_$value->table_identity.id
					WHERE id_pertanyaan_unsur = pertanyaan_unsur_$value->table_identity.id && is_submit = 1) * (unsur_$value->table_identity.persentase_unsur / 100)) AS persen_per_unsur
					
					FROM pertanyaan_unsur_$value->table_identity
					JOIN unsur_$value->table_identity ON pertanyaan_unsur_$value->table_identity.id_unsur = unsur_$value->table_identity.id");

					$nilai_bobot[$no] = [];
					foreach ($nilai_per_unsur[$no]->result() as $get) {
						$nilai_bobot[$no][] = $get->persen_per_unsur;
						$nilai_tertimbang[$no] = array_sum($nilai_bobot[$no]);
					}
					$data_chart[] = '{"label": "' . $value->survey_name . '",
						"value": "' . ROUND($nilai_tertimbang[$no] * 20, 2) . '"}';
				} else {
					$data_chart[] = '{"label": "' . $value->survey_name . '", "value": "0"}';
				};
				$no++;
			}
			$this->data['get_data_chart'] = implode(", ", $data_chart);
		} else {
			$this->data['get_data_chart'] = '{"label": "", "value": "0"}';
		}
		return view("dashboard/chart_survei_induk", $this->data);
	}

    public function get_tabel_survei()
	{
		$this->data = [];
		$this->data['title'] = 'Dashboard Tabel';

		return view("dashboard/tabel_survei_induk", $this->data);
	}

	public function ajax_list_tabel_survei_induk()
	{
		$klien_induk = $this->db->get_where("pengguna_klien_induk", array('id_user' => $this->session->userdata('user_id')))->row();
		$parent = implode(", ", unserialize($klien_induk->cakupan_induk));

        $this->db->select( '*, manage_survey.slug AS slug_manage_survey, (SELECT first_name FROM users WHERE users.id = manage_survey.id_user) AS first_name, (SELECT last_name FROM users WHERE users.id = manage_survey.id_user) AS last_name');
        $this->db->from('manage_survey');
        $this->db->where("id IN ($parent)");

		$i = 0;

		foreach ($this->column_search as $item) {
			if ($_POST['search']['value']) {

				if ($i === 0) {
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($this->column_search) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if (isset($_POST['order'])) {
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}

		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);

		$manage_survey = $this->db->get();

		$data = array();
		$no = $_POST['start'];
		foreach ($manage_survey->result() as $value) {

			$no++;
			$row = array();

			if ($this->db->get("jawaban_pertanyaan_unsur_$value->table_identity")->num_rows() > 0) {

				$nilai_per_unsur[$no] = $this->db->query("SELECT kode_unsur, persentase_unsur, (SELECT AVG(skor_jawaban) FROM jawaban_pertanyaan_unsur_$value->table_identity
				JOIN survey_$value->table_identity ON jawaban_pertanyaan_unsur_$value->table_identity.id_survey = survey_$value->table_identity.id
				WHERE id_pertanyaan_unsur = pertanyaan_unsur_$value->table_identity.id && is_submit = 1) AS rata_per_unsur,
				
				(SELECT unsur_$value->table_identity.persentase_unsur / 100) AS persentase_unsur_dibagi_100,
				
				((SELECT AVG(skor_jawaban) FROM jawaban_pertanyaan_unsur_$value->table_identity
				JOIN survey_$value->table_identity ON jawaban_pertanyaan_unsur_$value->table_identity.id_survey = survey_$value->table_identity.id
				WHERE id_pertanyaan_unsur = pertanyaan_unsur_$value->table_identity.id && is_submit = 1) * (unsur_$value->table_identity.persentase_unsur / 100)) AS persen_per_unsur
				
				FROM pertanyaan_unsur_$value->table_identity
				JOIN unsur_$value->table_identity ON pertanyaan_unsur_$value->table_identity.id_unsur = unsur_$value->table_identity.id");

				$nilai_bobot[$no] = [];
				foreach ($nilai_per_unsur[$no]->result() as $get) {
					$nilai_bobot[$no][] = $get->persen_per_unsur;
					$nilai_tertimbang[$no] = array_sum($nilai_bobot[$no]);
				}
				$skor_akhir[$no] = ROUND($nilai_tertimbang[$no] * 20, 2);
			} else {
				$skor_akhir[$no] = 0;
			};
			
			if ($skor_akhir[$no] <= 20) {
				$mutu_pelayanan[$no] = 'Sadar';
			} elseif ($skor_akhir[$no] > 20 && $skor_akhir[$no] <= 40) {
				$mutu_pelayanan[$no] = 'Paham';
			} elseif ($skor_akhir[$no] > 40 && $skor_akhir[$no] <= 60) {
				$mutu_pelayanan[$no] = 'Mampu';
			} elseif ($skor_akhir[$no] > 60 && $skor_akhir[$no] <= 80) {
				$mutu_pelayanan[$no] = 'Kritis';
			} elseif ($skor_akhir[$no] > 80) {
				$mutu_pelayanan[$no] = 'Berdaya';
			} else {
				NULL;
			}

			$row[] = $no;
			$row[] = $value->survey_name;
			$row[] = $skor_akhir[$no];
			$row[] = $mutu_pelayanan[$no];

			$data[] = $row;
		}

		$this->db->select( '*, manage_survey.slug AS slug_manage_survey, (SELECT first_name FROM users WHERE users.id = manage_survey.id_user) AS first_name, (SELECT last_name FROM users WHERE users.id = manage_survey.id_user) AS last_name');
        $this->db->from('manage_survey');
        $this->db->where("id IN ($parent)");
		$count_all = $this->db->count_all_results();
		//$count_filtered = $manage_survey->num_rows();

		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $count_all,
			"recordsFiltered" 	=> $count_all,
			"data" 				=> $data,
		);

		echo json_encode($output);
	}

}

/* End of file DashboardIndukController.php */
/* Location: ./application/controllers/DashboardIndukController.php */