<?php
defined('BASEPATH') or exit('No direct script access allowed');

require 'application/core/Klien_Controller.php';
use application\core\Klien_Controller;

class NilaiIndexBagianController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('ion_auth');

        if (!$this->ion_auth->logged_in()) {
            $this->session->set_flashdata('message_warning', 'You must be an admin to view this page');
            redirect('auth', 'refresh');
        }
        $this->load->library('form_validation');
        $this->load->model('DataPerolehanPerBagian_model', 'models');
    }

    public function index()
    {
        $this->data = [];
		$this->data['title'] = 'Nilai Indeks Bagian';

		return view('nilai_index_bagian/index', $this->data);
    }

    public function ajax_list()
	{
		$klien_induk = $this->db->get_where("pengguna_klien_induk", array('id_user' => $this->session->userdata('user_id')))->row();
		$parent = implode(", ", unserialize($klien_induk->cakupan_induk));

		$list = $this->models->get_datatables($parent);
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $value) {

            $klien_user = $this->db->get_where("users", array('id' => $value->id_user))->row();

			if ($value->is_privacy == 1) {
				$status = '<span class="badge badge-info" width="40%">Public</span>';
			} else {
				$status = '<span class="badge badge-danger" width="40%">Private</span>';
			};

			$no++;
			$row = array();
            $div = 'q' . $no;
            //
            $row[] = '
			<a href="' . base_url() . 'nilai-index-bagian/' . $klien_user->username . '" title="">
			<div class="card mb-5 shadow" style="background-color: SeaShell;">
				<div class="card-body">
					<div class="row">
						<div class="col sm-12">
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
			/*$row[] = '
			<a title="" onclick="outputhide('.$no.');" style="cursor: pointer; ">
			<div class="card mb-5 shadow" style="background-color: SeaShell;">
				<div class="card-body">
					<div class="row">
						<div class="col sm-12">
							<strong style="font-size: 17px;">' . $value->first_name . ' ' . $value->last_name . '</strong><br>
							<!--<span class="text-dark">Nama Survei : <b>' . $value->survey_name . '</b></span><br>-->
						</div>
						<!--<div class="col sm-2 text-right">' . $status . '
							<div class="mt-3 text-dark font-weight-bold" style="font-size: 11px;">
								Periode Survei : ' . date('d-m-Y', strtotime($value->survey_start)) . ' s/d ' . date('d-m-Y', strtotime($value->survey_end)) . '
							</div>

						</div>-->
                    </div>
                    <div class="row mt-5" id="' . $div . '" style="display: none;">
                        <div class="col sm-12">
							
                            <div class="table-responsive">
                                <table id="detail'.$no.'" class="table" cellspacing="0" width="100%">
                                    <thead class="bg-secondary">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Sektor</th>
                                            <th>Nilai IKK</th>
                                            <th>Mutu Pelayanan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

						</div>
					</div>
					<!--small class="text-secondary">' . $value->description . '</small><br-->
					
				</div>
			</div>
		</a>';*/

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

    public function ajax_list_sektor()
	{
		$this->load->model('Sektor_model');

		$list = $this->Sektor_model->get_datatables();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $value) {

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $value->nama_sektor;
			$row[] = '0';
			$row[] = 'Sadar';
            $row[] = anchor(base_url().'nilai-index-bagian/'.$this->uri->segment(2).'/'.$value->id, 'Detail', ['class' => 'btn btn-secondary btn-sm font-weight-bold']);

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Sektor_model->count_all(),
			"recordsFiltered" => $this->Sektor_model->count_filtered(),
			"data" => $data,
		);

		echo json_encode($output);
	}

    public function detail($id1)
    {
        $this->data = [];
        $this->data['title'] = 'Nilai Indeks Bagian';

        /*$profiles = new Klien_Controller();
        $this->data['profiles'] = $profiles->_get_data_profile($id1, $id2);
        $this->data['table_identity'] = $this->data['profiles']->table_identity;
        $this->data['sektor'] = $this->db->get("sektor_" . $this->data['table_identity']);*/

        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('users.username', $id1);
        $data_user = $this->db->get()->row();
        $this->data['profile'] = $data_user->first_name.' '.$data_user->last_name;
        $this->data['id_user'] = $data_user->id;

        $klien_induk = $this->db->get_where("pengguna_klien_induk", array('id_user' => $this->session->userdata('user_id')))->row();
		$parent = implode(", ", unserialize($klien_induk->cakupan_induk));

        $this->data['sektor'] = $this->db->get("sektor");

        return view('nilai_index_bagian/detail', $this->data);
    }

    public function detail_modal()
    {
        $this->data = [];
        $id_sektor = $this->uri->segment(3);

        $klien_induk = $this->db->get_where("pengguna_klien_induk", array('id_user' => $this->session->userdata('user_id')))->row();
		$parent = implode(", ", unserialize($klien_induk->cakupan_induk));

        $this->db->select( '*, manage_survey.slug AS slug_manage_survey, (SELECT first_name FROM users WHERE users.id = manage_survey.id_user) AS first_name, (SELECT last_name FROM users WHERE users.id = manage_survey.id_user) AS last_name');
        $this->db->from('manage_survey');
        $this->db->where("id IN ($parent)");

		$manage_survey = $this->db->get();

        if ($manage_survey->num_rows() > 0) {
            $query_jumlah_kuesioner_terisi = "SELECT SUM(total_kuesioner) AS total_kuesioner FROM (";
            $query_total_nilai_unsur = "SELECT id_unsur, SUM(total_nilai_unsur) AS total_nilai_unsur FROM (";
            $query_rata_rata_per_unsur = "SELECT id_unsur, SUM(rata_per_unsur) AS rata_per_unsur FROM (";
            $query_rata_rata_per_dimensi = "SELECT jumlah_unsur, SUM(rata_per_dimensi) AS rata_per_dimensi FROM (";
            $query_rata_rata_per_unsur_x_bobot = "SELECT id_unsur, kode_unsur, SUM(persentase_unsur) AS persentase_unsur, SUM(rata_per_unsur) AS rata_per_unsur, SUM(persentase_unsur_dibagi_100) AS persentase_unsur_dibagi_100, SUM(persen_per_unsur) AS persen_per_unsur FROM (";
            $query_unsur = "SELECT * FROM (";
            $q = 0;
            foreach ($manage_survey->result() as $value) {
                $q++;
                $table_identity = $value->table_identity;
                if($q!='1'){
                    $query_jumlah_kuesioner_terisi .= "
                    UNION ALL
                    ";
                    $query_total_nilai_unsur .= "
                    UNION ALL
                    ";
                    $query_rata_rata_per_unsur .= "
                    UNION ALL
                    ";
                    $query_rata_rata_per_dimensi .= "
                    UNION ALL
                    ";
                    $query_rata_rata_per_unsur_x_bobot .= "
                    UNION ALL
                    ";
                    $query_unsur .= "
                    UNION ALL
                    ";

                }
                $query_jumlah_kuesioner_terisi .= "SELECT COUNT(id_responden) AS total_kuesioner
                FROM survey_$table_identity
                JOIN responden_$table_identity ON survey_$table_identity.id_responden = responden_$table_identity.id WHERE is_submit = 1 && sektor = $id_sektor";

                $query_total_nilai_unsur .= "SELECT id_unsur, (SELECT SUM(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity 
                JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey = survey_$table_identity.id
                JOIN responden_$table_identity ON survey_$table_identity.id_responden = responden_$table_identity.id
                WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && is_submit = 1 && sektor = $id_sektor) AS total_nilai_unsur
                FROM pertanyaan_unsur_$table_identity";

                $query_rata_rata_per_unsur .= "SELECT id_unsur, (SELECT AVG(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity 
                JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey = survey_$table_identity.id
                JOIN responden_$table_identity ON survey_$table_identity.id_responden = responden_$table_identity.id
                WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && is_submit = 1 && sektor = $id_sektor) AS rata_per_unsur
                FROM pertanyaan_unsur_$table_identity";

                $query_rata_rata_per_dimensi .= "SELECT 
                (SELECT SUM(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity
                JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey = survey_$table_identity.id
                JOIN responden_$table_identity ON survey_$table_identity.id_responden = responden_$table_identity.id
                JOIN pertanyaan_unsur_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id
                JOIN unsur_$table_identity ON pertanyaan_unsur_$table_identity.id_unsur = unsur_$table_identity.id
                WHERE id_dimensi = dimensi_$table_identity.id && is_submit = 1 && sektor = $id_sektor) AS jumlah_per_dimensi,
                
                (SELECT COUNT(id) FROM unsur_$table_identity WHERE id_dimensi = dimensi_$table_identity.id) AS jumlah_unsur,

                (SELECT DISTINCT(id_dimensi) FROM unsur_$table_identity WHERE id_dimensi = dimensi_$table_identity.id) AS id_dimensi,
                
                (((SELECT SUM(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity
                JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey = survey_$table_identity.id
                JOIN responden_$table_identity ON survey_$table_identity.id_responden = responden_$table_identity.id
                JOIN pertanyaan_unsur_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id
                JOIN unsur_$table_identity ON pertanyaan_unsur_$table_identity.id_unsur = unsur_$table_identity.id
                WHERE id_dimensi = dimensi_$table_identity.id && is_submit = 1 && sektor = $id_sektor) / (SELECT COUNT(id_responden) FROM survey_$table_identity JOIN responden_$table_identity ON survey_$table_identity.id_responden = responden_$table_identity.id WHERE is_submit = 1 && sektor = $id_sektor)) / (SELECT COUNT(id) FROM unsur_$table_identity WHERE id_dimensi = dimensi_$table_identity.id)) AS rata_per_dimensi
                
                FROM dimensi_$table_identity";

                $query_rata_rata_per_unsur_x_bobot .= "SELECT id_unsur, kode_unsur, persentase_unsur, (SELECT AVG(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity
                JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey = survey_$table_identity.id
                JOIN responden_$table_identity ON survey_$table_identity.id_responden = responden_$table_identity.id
                WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && is_submit = 1 && sektor = $id_sektor) AS rata_per_unsur,
                
                (SELECT unsur_$table_identity.persentase_unsur / 100) AS persentase_unsur_dibagi_100,
                
                ((SELECT AVG(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity
                JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey = survey_$table_identity.id
                JOIN responden_$table_identity ON survey_$table_identity.id_responden = responden_$table_identity.id
                WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && is_submit = 1 && sektor = $id_sektor) * (unsur_$table_identity.persentase_unsur / 100)) AS persen_per_unsur
                
                FROM pertanyaan_unsur_$table_identity
                JOIN unsur_$table_identity ON pertanyaan_unsur_$table_identity.id_unsur = unsur_$table_identity.id";

                $query_unsur .= "SELECT kode_unsur FROM unsur_$table_identity";
            }
            $query_jumlah_kuesioner_terisi .= ') jumlah_kuesioner_terisi';
            $query_total_nilai_unsur .= ') total_nilai_unsur GROUP BY id_unsur';
            $query_rata_rata_per_unsur .= ') rata_rata_per_unsur GROUP BY id_unsur';
            $query_rata_rata_per_dimensi .= ') rata_rata_per_dimensi GROUP BY id_dimensi';
            $query_rata_rata_per_unsur_x_bobot .= ') rata_rata_per_unsur_x_bobot GROUP BY kode_unsur ORDER BY id_unsur';
            $query_unsur .= ') unsur GROUP BY kode_unsur';
        }

        /*$this->data['manage_survey'] = $this->db->get_where('manage_survey', ['slug' => $this->uri->segment(2)])->row();
        $table_identity = $this->data['manage_survey']->table_identity;*/

        //$this->data['sektor'] = $this->db->get_where("sektor_$table_identity", array('id' => $id_sektor))->row();
        $this->data['sektor']  = $this->db->query("SELECT * FROM sektor")->row();

        /*$this->data['jumlah_kuesioner_terisi'] = $this->db->query("SELECT COUNT(id_responden) AS total_kuesioner
        FROM survey_$table_identity
        JOIN responden_$table_identity ON survey_$table_identity.id_responden = responden_$table_identity.id WHERE is_submit = 1 && sektor = $id_sektor")->row()->total_kuesioner;*/
        $this->data['jumlah_kuesioner_terisi']  = $this->db->query($query_jumlah_kuesioner_terisi)->row()->total_kuesioner;

        //$this->data['unsur']  = $this->db->query("SELECT *, SUBSTR(kode_unsur, 2) AS kode_alasan FROM unsur_$table_identity");
        //$this->data['unsur']  = $this->db->query($query_unsur);
        $this->data['unsur']  = $this->db->query("SELECT DISTINCT(kode_unsur) FROM unsur");

        /*$this->data['total_nilai_unsur'] = $this->db->query("SELECT *, (SELECT SUM(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity 
        JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey = survey_$table_identity.id
        JOIN responden_$table_identity ON survey_$table_identity.id_responden = responden_$table_identity.id
        WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && is_submit = 1 && sektor = $id_sektor) AS total_nilai_unsur
        FROM pertanyaan_unsur_$table_identity");*/
        $this->data['total_nilai_unsur']  = $this->db->query($query_total_nilai_unsur);

        /*$this->data['rata_rata_per_unsur'] = $this->db->query("SELECT *, (SELECT AVG(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity 
        JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey = survey_$table_identity.id
        JOIN responden_$table_identity ON survey_$table_identity.id_responden = responden_$table_identity.id
        WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && is_submit = 1 && sektor = $id_sektor) AS rata_per_unsur
        FROM pertanyaan_unsur_$table_identity");*/
        $this->data['rata_rata_per_unsur']  = $this->db->query($query_rata_rata_per_unsur);


        /*$this->data['rata_rata_per_dimensi'] = $this->db->query("SELECT 
        (SELECT SUM(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity
        JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey = survey_$table_identity.id
        JOIN responden_$table_identity ON survey_$table_identity.id_responden = responden_$table_identity.id
        JOIN pertanyaan_unsur_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id
        JOIN unsur_$table_identity ON pertanyaan_unsur_$table_identity.id_unsur = unsur_$table_identity.id
        WHERE id_dimensi = dimensi_$table_identity.id && is_submit = 1 && sektor = $id_sektor) AS jumlah_per_dimensi,
        
        (SELECT COUNT(id) FROM unsur_$table_identity WHERE id_dimensi = dimensi_$table_identity.id) AS jumlah_unsur,
        
        (((SELECT SUM(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity
        JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey = survey_$table_identity.id
        JOIN responden_$table_identity ON survey_$table_identity.id_responden = responden_$table_identity.id
        JOIN pertanyaan_unsur_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id
        JOIN unsur_$table_identity ON pertanyaan_unsur_$table_identity.id_unsur = unsur_$table_identity.id
        WHERE id_dimensi = dimensi_$table_identity.id && is_submit = 1 && sektor = $id_sektor) / (SELECT COUNT(id_responden) FROM survey_$table_identity JOIN responden_$table_identity ON survey_$table_identity.id_responden = responden_$table_identity.id WHERE is_submit = 1 && sektor = $id_sektor)) / (SELECT COUNT(id) FROM unsur_$table_identity WHERE id_dimensi = dimensi_$table_identity.id)) AS rata_per_dimensi
        
        FROM dimensi_$table_identity");*/
        $this->data['rata_rata_per_dimensi']  = $this->db->query($query_rata_rata_per_dimensi);


        /*$this->data['rata_rata_per_unsur_x_bobot'] = $this->db->query("SELECT kode_unsur, persentase_unsur, (SELECT AVG(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity
        JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey = survey_$table_identity.id
        JOIN responden_$table_identity ON survey_$table_identity.id_responden = responden_$table_identity.id
        WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && is_submit = 1 && sektor = $id_sektor) AS rata_per_unsur,
        
        (SELECT unsur_$table_identity.persentase_unsur / 100) AS persentase_unsur_dibagi_100,
        
        ((SELECT AVG(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity
        JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey = survey_$table_identity.id
        JOIN responden_$table_identity ON survey_$table_identity.id_responden = responden_$table_identity.id
        WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && is_submit = 1 && sektor = $id_sektor) * (unsur_$table_identity.persentase_unsur / 100)) AS persen_per_unsur
        
        FROM pertanyaan_unsur_$table_identity
        JOIN unsur_$table_identity ON pertanyaan_unsur_$table_identity.id_unsur = unsur_$table_identity.id");*/
        $this->data['rata_rata_per_unsur_x_bobot']  = $this->db->query($query_rata_rata_per_unsur_x_bobot);


        foreach ($this->data['rata_rata_per_unsur_x_bobot']->result() as $rows) {
            $total[] = $rows->persen_per_unsur;
            $this->data['ikk'] = array_sum($total);
        }


        return view('nilai_index_bagian/detail_modal', $this->data);
    }
    
}

/* End of file NilaiIndexBagianController.php */
/* Location: ./application/controllers/NilaiIndexBagianController.php */