<?php
defined('BASEPATH') or exit('No direct script access allowed');

require 'application/core/Klien_Controller.php';

use application\core\Klien_Controller;

class TargetPerWilayahController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('ion_auth');

        if (!$this->ion_auth->logged_in()) {
            $this->session->set_flashdata('message_warning', 'You must be logged in to access this page');
            redirect('auth', 'refresh');
        }
        $this->load->model('TargetPerWilayah_model', 'models');
    }

    public function index($id1, $id2)
    {
        $this->data = [];
        $this->data['title'] = "Target Per Wilayah";


        $profiles = new Klien_Controller();
        $this->data['profiles'] = $profiles->_get_data_profile($id1, $id2);
        $table_identity = $this->data['profiles']->table_identity;

        $this->data['manage_survey'] = $this->db->get_where('manage_survey', ['slug' => $id2])->row();

        $sektor = $this->db->get('sektor_' . $table_identity);
        $this->data['sektor'] = $sektor->num_rows();

        $wilayah_survei = $this->db->get('wilayah_survei_' . $table_identity);
        $this->data['wilayah_survei'] = $wilayah_survei->num_rows();



        if ($this->data['manage_survey']->is_target == 1 && $this->db->get("target_$table_identity")->num_rows() == 0) {
            foreach ($wilayah_survei->result() as $row) {
                foreach ($sektor->result() as $value) {
                    $this->db->query("INSERT INTO target_$table_identity (id_wilayah_survei, id_sektor) VALUES ($row->id, $value->id)");
                }
            }
        }

        return view('target_per_wilayah/index', $this->data);
    }

    public function ajax_list($id1, $id2)
    {
        $profile = new Klien_Controller();
        $profile = $profile->_get_data_profile($id1, $id2);
        $table_identity = $profile->table_identity;

        $list = $this->models->get_datatables($table_identity);
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $value) {

            $get_online = $value->target_wilayah_online == NULL ? 0 : $value->target_wilayah_online;
            $get_offline = $value->target_wilayah_offline == NULL ? 0 : $value->target_wilayah_offline;

            $text = $value->target_wilayah_online == NULL || $value->target_wilayah_offline == NULL ? 'Lengkapi Target' : 'Lihat Target';

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $value->nama_wilayah;
            $row[] = '<span class="badge badge-info">' . $get_online . '</span>';
            $row[] = '<span class="badge badge-success">' . $get_offline . '</span>';
            $row[] = '<span class="badge badge-warning">' . ($get_online + $get_offline) . '</span>';
            $row[] = '<a class="btn btn-light-primary btn-sm" data-toggle="modal"
			onclick="showedit(' . $value->id . ')" href="#modal_detail"><i class="fa fa-info-circle"></i> ' . $text . '</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->models->count_all($table_identity),
            "recordsFiltered" => $this->models->count_filtered($table_identity),
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function get_detail()
    {
        $this->data = [];
        $id_wilayah_survei = $this->uri->segment(5);

        $this->data['manage_survey'] = $this->db->get_where('manage_survey', ['slug' => $this->uri->segment(2)])->row();
        $table_identity = $this->data['manage_survey']->table_identity;

        $this->data['target'] = $this->db->query("SELECT *, (SELECT nama_sektor FROM sektor_$table_identity WHERE id_sektor = sektor_$table_identity.id) AS nama_sektor, (target_online + target_offline) AS total_target
        FROM target_$table_identity
        WHERE id_wilayah_survei = $id_wilayah_survei");

        $this->data['wilayah_survei'] = $this->db->query("SELECT *, (SELECT SUM(target_online) FROM target_$table_identity WHERE id_wilayah_survei = wilayah_survei_$table_identity.id) AS target_wilayah_online, (SELECT SUM(target_offline) FROM target_$table_identity WHERE id_wilayah_survei = wilayah_survei_$table_identity.id) AS target_wilayah_offline, ((SELECT SUM(target_online) FROM target_$table_identity WHERE id_wilayah_survei = wilayah_survei_$table_identity.id) + (SELECT SUM(target_offline) FROM target_$table_identity WHERE id_wilayah_survei = wilayah_survei_$table_identity.id)) AS total_target_wilayah
        FROM wilayah_survei_$table_identity
        WHERE id = $id_wilayah_survei")->row();

        return view('target_per_wilayah/detail', $this->data);
    }


    public function update_target()
    {
        $id_wilayah_survei = $this->uri->segment(5);

        $this->data['manage_survey'] = $this->db->get_where('manage_survey', ['slug' => $this->uri->segment(2)])->row();
        $table_identity = $this->data['manage_survey']->table_identity;


        $id = $this->input->post('id');
        for ($i = 0; $i < sizeof($id); $i++) {
            $obj = array(
                'target_online' => $this->input->post('target_online')[$i],
                'target_offline' => $this->input->post('target_offline')[$i]
            );

            if (isset($_POST['is_all'])) {
                $this->db->where('id_sektor', $id[$i]);
                $this->db->update('target_' . $table_identity, $obj);
            } else {
                $this->db->where('id_wilayah_survei', $id_wilayah_survei);
                $this->db->where('id_sektor', $id[$i]);
                $this->db->update('target_' . $table_identity, $obj);
            }
        }

        $pesan = 'Data berhasil disimpan';
        $msg = ['sukses' => $pesan];
        echo json_encode($msg);
    }

    public function delete_target()
    {
        $this->data['manage_survey'] = $this->db->get_where('manage_survey', ['slug' => $this->uri->segment(2)])->row();
        $table_identity = $this->data['manage_survey']->table_identity;

        $obj = array(
            'target_online' => NULL,
            'target_offline' => NULL
        );
        // $this->db->where('id_wilayah_survei', $id_wilayah_survei);
        $this->db->update('target_' . $table_identity, $obj);

        $this->session->set_flashdata('message_success', 'Berhasil mengosongkan Target.');
        redirect(base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/target-per-wilayah/', 'refresh');
    }
}

/* End of file TargetProvinsiController.php */
/* Location: ./application/controllers/TargetProvinsiController.php */
