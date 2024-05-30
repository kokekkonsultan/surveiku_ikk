<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TargetPerBagianController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		if (!$this->ion_auth->logged_in()) {
			$this->session->set_flashdata('message_warning', 'You must be an admin to view this page');
			redirect('auth', 'refresh');
		}
		$this->load->model('DataPerolehanPerBagian_model', 'models');
	}

	public function index()
	{
		$this->data = [];
		$this->data['title'] = 'Target dan Perolehan Per Bagian';


		return view('target_per_bagian/index', $this->data);
	}

	public function ajax_list()
	{
		$klien_induk = $this->db->get_where("pengguna_klien_induk", array('id_user' => $this->session->userdata('user_id')))->row();
		$parent = implode(", ", unserialize($klien_induk->cakupan_induk));

		$list = $this->models->get_datatables($parent);
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $value) {

			if ($value->is_privacy == 1) {
				$status = '<span class="badge badge-info" width="40%">Public</span>';
			} else {
				$status = '<span class="badge badge-danger" width="40%">Private</span>';
			};

			$no++;
			$row = array();
			$row[] = '
			<a href="' . base_url() . 'target-per-bagian/' . $value->slug . '" title="">
			<div class="card mb-5 shadow" style="background-color: SeaShell;">
				<div class="card-body">
					<div class="row">
						<div class="col sm-10">
							<strong style="font-size: 17px;">' . $value->first_name . ' ' . $value->last_name . '</strong><br>
							<span class="text-dark">Nama Survei : <b>' . $value->survey_name . '</b></span><br>
						</div>
						<div class="col sm-2 text-right">' . $status . '
							<div class="mt-3 text-dark font-weight-bold" style="font-size: 11px;">
								Periode Survei : ' . date('d-m-Y', strtotime($value->survey_start)) . ' s/d ' . date('d-m-Y', strtotime($value->survey_end)) . '
							</div>

						</div>
					</div>
					<!--small class="text-secondary">' . $value->description . '</small><br-->
					
				</div>
			</div>
		</a>';

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->models->count_all($parent),
			"recordsFiltered" => $this->models->count_filtered($parent),
			"data" => $data,
		);
		echo json_encode($output);
	}



	public function detail()
	{
		$this->data = [];
		$this->data['title'] = 'Detail Target dan Perolehan';

		// $this->data['users'] = $this->ion_auth->user()->row();
		$this->data['slug'] = $this->uri->segment(2);
		$this->data['manage_survey'] = $this->db->get_where("manage_survey", array('slug' => $this->uri->segment(2)))->row();
		$table_identity = $this->data['manage_survey']->table_identity;
		$this->data['users'] =  $this->db->get_where("users", array('id' => $this->data['manage_survey']->id_user))->row();

		// $this->data['target'] = $this->db->get("target_$table_identity");


		$this->data['sektor'] = $this->db->query("SELECT *, 
        (SELECT SUM(target_online) FROM target_$table_identity WHERE sektor_$table_identity.id = target_$table_identity.id_sektor) AS target_online,

        (SELECT SUM(target_offline) FROM target_$table_identity WHERE sektor_$table_identity.id = target_$table_identity.id_sektor) AS target_offline,

        (SELECT COUNT(id_responden)
        FROM responden_$table_identity
        JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden
        WHERE is_submit = 1 && responden_$table_identity.sektor = sektor_$table_identity.id && id_surveyor = 0) AS perolehan_online,

        (SELECT COUNT(id_responden)
        FROM responden_$table_identity
        JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden
        WHERE is_submit = 1 && responden_$table_identity.sektor = sektor_$table_identity.id && id_surveyor != 0) AS perolehan_offline,

        ((SELECT SUM(target_online) FROM target_$table_identity WHERE sektor_$table_identity.id = target_$table_identity.id_sektor) - (SELECT COUNT(id_responden)
        FROM responden_$table_identity
        JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden
        WHERE is_submit = 1 && responden_$table_identity.sektor = sektor_$table_identity.id && id_surveyor = 0)) AS kekurangan_online,

        ((SELECT SUM(target_offline) FROM target_$table_identity WHERE sektor_$table_identity.id = target_$table_identity.id_sektor) - (SELECT COUNT(id_responden)
        FROM responden_$table_identity
        JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden
        WHERE is_submit = 1 && responden_$table_identity.sektor = sektor_$table_identity.id && id_surveyor != 0)) AS kekurangan_offline,

        (((SELECT COUNT(id_responden)
        FROM responden_$table_identity
        JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden
        WHERE is_submit = 1 && responden_$table_identity.sektor = sektor_$table_identity.id) / (SELECT SUM(target_online + target_offline) FROM target_$table_identity WHERE sektor_$table_identity.id = target_$table_identity.id_sektor)) * 100) AS akumulasi_persen


        FROM sektor_$table_identity");
		// var_dump($this->data['sektor']->result());


		return view('target_per_bagian/form_detail', $this->data);
	}
}

/* End of file DataPerolehanSurveiController.php */
/* Location: ./application/controllers/DataPerolehanSurveiController.php */
