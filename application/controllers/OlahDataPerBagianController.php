<?php
defined('BASEPATH') or exit('No direct script access allowed');

class OlahDataPerBagianController extends CI_Controller
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
        $this->load->model('OlahData_model', 'models');
        $this->load->model('OlahData_model');
    }

    public function index()
    {
        $this->data = [];
        $this->data['title'] = 'Olah Data';

        $klien_induk = $this->db->get_where("pengguna_klien_induk", array('id_user' => $this->session->userdata('user_id')))->row();
        $parent = implode(", ", unserialize($klien_induk->cakupan_induk));

        $this->db->select('*, manage_survey.slug AS slug_manage_survey, (SELECT first_name FROM users WHERE users.id = manage_survey.id_user) AS first_name, (SELECT last_name FROM users WHERE users.id = manage_survey.id_user) AS last_name');
        $this->db->from('manage_survey');
        $this->db->where("id IN ($parent)");

        $manage_survey = $this->db->get();

        if ($manage_survey->num_rows() > 0) {
            $nama_survei = [];
            $skor_akhir = [];
            $no = 1;
            foreach ($manage_survey->result() as $value) {

                $this->db->select('*');
                $this->db->from('users');
                $this->db->join('users_groups', 'users.id = users_groups.user_id');
                $this->db->where('users.id', $value->id_user);
                $data_user = $this->db->get()->row();

                /*$table_identity = $value->table_identity;
                $this->data['wilayah_survei'] = $this->db->query("SELECT *, (SELECT COUNT(id_responden) FROM responden_$table_identity JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden WHERE is_submit = 1 && responden_$table_identity.wilayah_survei = wilayah_survei_$table_identity.id) AS perolehan
                FROM wilayah_survei_$table_identity");*/

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
                    $data_chart[] = '{"label": "' . $data_user->first_name . ' ' . $data_user->last_name . '",
						"value": "' . ROUND($nilai_tertimbang[$no] * 20, 2) . '"}';
                } else {
                    $data_chart[] = '{"label": "' . $data_user->first_name . ' ' . $data_user->last_name . '", "value": "0"}';
                };
                $no++;
            }
            $this->data['get_data_chart'] = implode(", ", $data_chart);
        } else {
            $this->data['get_data_chart'] = '{"label": "", "value": "0"}';
        }

        return view('olah_data_per_bagian/index', $this->data);
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
                $nilai_ikk = ROUND($nilai_tertimbang[$no] * 20, 2);
            } else {
                $nilai_ikk = 0;
            };

            if (($nilai_ikk) <= 20) {
                $mutu_pelayanan = 'Sadar';
            } elseif (($nilai_ikk) > 20 && ($nilai_ikk) <= 40) {
                $mutu_pelayanan = 'Paham';
            } elseif (($nilai_ikk) > 40 && ($nilai_ikk) <= 60) {
                $mutu_pelayanan = 'Mampu';
            } elseif (($nilai_ikk) > 60 && ($nilai_ikk) <= 80) {
                $mutu_pelayanan = 'Kritis';
            } elseif (($nilai_ikk) > 80) {
                $mutu_pelayanan = 'Berdaya';
            } else {
                NULL;
            }

            $no++;
            $row = array();
            $row[] = '
			<a href="' . base_url() . 'olah-data-per-bagian/' . $klien_user->username . '/' . $value->slug . '" title="">
			<div class="card mb-5 shadow" style="background-color: SeaShell;">
				<div class="card-body">
					<div class="row">
						<div class="col sm-10">
							<strong style="font-size: 17px;">' . $value->first_name . ' ' . $value->last_name . '</strong><br>
							<span class="text-dark">Nama Survei : <b>' . $value->survey_name . '</b></span><br>
                            <span class="text-dark">Nilai IKK : <b>' . $nilai_ikk . '</b></span><br>
                            <span class="text-dark">Mutu Pelayanan : <b>' . $mutu_pelayanan . '</b></span><br>
						</div>
						<div class="col sm-2 text-right"><span class="badge badge-info" width="40%">Detail</span>
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

    public function detail($id1, $id2)
    {
        $this->data = [];
        $this->data['title'] = 'Olah Data';
        $this->data['profiles'] = $this->_get_data_profile($id1, $id2);

        $slug = $this->uri->segment(3);

        $get_identity = $this->db->get_where('manage_survey', ['slug' => "$slug"])->row();
        $table_identity = $get_identity->table_identity;
        $this->data['nama_survey'] = $get_identity->survey_name;

        $this->data['jumlah_kuesioner_terisi'] = $this->db->query("SELECT COUNT(id) AS total_kuesioner
        FROM survey_$table_identity WHERE is_submit = 1")->row()->total_kuesioner;

        // if ($this->data['jumlah_kuesioner_terisi'] == 0) {
        //     $this->data['pesan'] = 'Survei belum dimulai atau belum ada responden !';
        //     return view('not_questions/index', $this->data);
        // }

        $this->data['unsur']  = $this->db->query("SELECT *, SUBSTR(kode_unsur, 2) AS kode_alasan FROM unsur_$table_identity");

        $this->data['total_nilai_unsur'] = $this->db->query("SELECT *, (SELECT SUM(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity 
        JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey = survey_$table_identity.id
        WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && is_submit = 1) AS total_nilai_unsur
        FROM pertanyaan_unsur_$table_identity");

        $this->data['rata_rata_per_unsur'] = $this->db->query("SELECT *, (SELECT AVG(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity 
        JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey = survey_$table_identity.id
        WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && is_submit = 1) AS rata_per_unsur
        FROM pertanyaan_unsur_$table_identity");


        $this->data['rata_rata_per_dimensi'] = $this->db->query("SELECT *, (SELECT SUM(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity
        JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey = survey_$table_identity.id
        JOIN pertanyaan_unsur_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id
        JOIN unsur_$table_identity ON pertanyaan_unsur_$table_identity.id_unsur = unsur_$table_identity.id
        WHERE id_dimensi = dimensi_$table_identity.id && is_submit = 1) AS jumlah_per_dimensi,

        (SELECT COUNT(id) FROM unsur_$table_identity WHERE id_dimensi = dimensi_$table_identity.id) AS jumlah_unsur,

        ( ((SELECT SUM(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity
        JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey = survey_$table_identity.id
        JOIN pertanyaan_unsur_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id
        JOIN unsur_$table_identity ON pertanyaan_unsur_$table_identity.id_unsur = unsur_$table_identity.id
        WHERE id_dimensi = dimensi_$table_identity.id && is_submit = 1) / (SELECT COUNT(id) FROM survey_$table_identity WHERE is_submit = 1)) / (SELECT COUNT(id) FROM unsur_$table_identity WHERE id_dimensi = dimensi_$table_identity.id)) AS rata_per_dimensi

        FROM dimensi_$table_identity");


        $this->data['rata_rata_per_unsur_x_bobot'] = $this->db->query("SELECT kode_unsur, persentase_unsur, (SELECT AVG(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity
        JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey = survey_$table_identity.id
        WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && is_submit = 1) AS rata_per_unsur,
        
        (SELECT unsur_$table_identity.persentase_unsur / 100) AS persentase_unsur_dibagi_100,
        
        ((SELECT AVG(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity
        JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey = survey_$table_identity.id
        WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && is_submit = 1) * (unsur_$table_identity.persentase_unsur / 100)) AS persen_per_unsur
        
        FROM pertanyaan_unsur_$table_identity
        JOIN unsur_$table_identity ON pertanyaan_unsur_$table_identity.id_unsur = unsur_$table_identity.id");

        foreach ($this->data['rata_rata_per_unsur_x_bobot']->result() as $rows) {
            $total[] = $rows->persen_per_unsur;
            $this->data['ikk'] = array_sum($total);
        }

        // var_dump($total_biaya);

        return view('olah_data_per_bagian/detail', $this->data);
    }

    public function _get_data_profile($id1, $id2)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->join('users_groups', 'users.id = users_groups.user_id');
        $this->db->where('users.username', $id1);
        $data_user = $this->db->get()->row();
        $user_identity = 'drs' . $data_user->is_parent;

        $this->db->select('users.username, manage_survey.survey_name, manage_survey.slug, manage_survey.description, manage_survey.is_privacy, manage_survey.table_identity, manage_survey.atribut_pertanyaan_survey');
        if ($data_user->group_id == 2) {
            $this->db->from('users');
            $this->db->join('manage_survey', 'manage_survey.id_user = users.id');
        } else {
            $this->db->from('manage_survey');
            $this->db->join("supervisor_$user_identity", "manage_survey.id_berlangganan = supervisor_$user_identity.id_berlangganan");
            $this->db->join("users", "supervisor_$user_identity.id_user = users.id");
        }
        $this->db->where('users.username', $id1);
        $this->db->where('manage_survey.slug', $id2);
        $profiles = $this->db->get();

        if ($profiles->num_rows() == 0) {
            // echo 'Survey tidak ditemukan atau sudah dihapus !';
            // exit();
            show_404();
        }
        return $profiles->row();
    }

    public function ajax_detail()
    {
        $slug = $this->uri->segment(3);

        $get_identity = $this->db->get_where('manage_survey', ['slug' => "$slug"])->row();
        $id_manage_survey = $get_identity->id;
        $table_identity = $get_identity->table_identity;

        $jawaban_unsur = $this->db->get("jawaban_pertanyaan_unsur_cst$id_manage_survey");

        $list = $this->models->get_datatables($id_manage_survey);
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $value) {

            if ($value->is_submit == 1) {
                $status = '<span class="badge badge-primary">Valid</span>';
            } else {
                $status = '<span class="badge badge-danger">Tidak Valid</span>';
            }

            $no++;
            $row = array();
            $row[] = $no;
            // $row[] = $status;
            // $row[] = '<b>' . $value->kode_surveyor . '</b>--' . $value->first_name . ' ' . $value->last_name;
            $row[] = $value->nama_lengkap;

            foreach ($jawaban_unsur->result() as $get_unsur) {
                if ($get_unsur->id_survey == $value->id_survey) {
                    $row[] = $get_unsur->skor_jawaban;
                }
            }

            foreach ($jawaban_unsur->result() as $get_unsur) {
                if ($get_unsur->id_survey == $value->id_survey) {
                    $row[] = $get_unsur->alasan_pilih_jawaban;
                }
            }

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->models->count_all($id_manage_survey),
            "recordsFiltered" => $this->models->count_filtered($id_manage_survey),
            "data" => $data,
        );

        echo json_encode($output);
    }
}

/* End of file OlahDataPerBagianController.php */
/* Location: ./application/controllers/OlahDataPerBagianController.php */
