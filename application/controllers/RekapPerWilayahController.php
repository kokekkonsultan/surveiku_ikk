<?php
defined('BASEPATH') or exit('No direct script access allowed');

require 'application/core/Klien_Controller.php';

use application\core\Klien_Controller;

class RekapPerWilayahController extends CI_Controller
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
        $this->data['title'] = "Rekap Per Wilayah";

        $profiles = new Klien_Controller();
        $this->data['profiles'] = $profiles->_get_data_profile($id1, $id2);
        $table_identity = $this->data['profiles']->table_identity;

        $this->data['wilayah_survei'] = $this->db->query("SELECT *, (SELECT COUNT(id_responden) FROM responden_$table_identity JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden WHERE is_submit = 1 && responden_$table_identity.wilayah_survei = wilayah_survei_$table_identity.id) AS perolehan
        FROM wilayah_survei_$table_identity");

        if ($this->data['profiles']->is_question == 1) {
            $this->data['pesan'] = 'survei belum dimulai atau belum ada responden !';
            return view('not_questions/index', $this->data);
        } else {
            return view('rekap_per_wilayah/index', $this->data);
        }
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

            $target_online = $value->target_wilayah_online == NULL ? 0 : $value->target_wilayah_online;
            $target_offline = $value->target_wilayah_offline == NULL ? 0 : $value->target_wilayah_offline;
            $total_target = $target_online + $target_offline;

            $perolehan_online = $value->perolehan_online == NULL ? 0 : $value->perolehan_online;
            $perolehan_offline = $value->perolehan_offline == NULL ? 0 : $value->perolehan_offline;
            $total_perolehan = $perolehan_online + $perolehan_offline;


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $value->nama_wilayah;
            $row[] = '<span class="badge badge-info">' . ROUND(($total_perolehan / $total_target) * 100, 2) . ' %</span>';
            $row[] = '<span class="badge badge-primary">' . $total_target . '</span>';
            $row[] = '<span class="badge badge-success">' . $total_perolehan . '</span>';
            $row[] = '<span class="badge badge-danger">' . ($total_target - $total_perolehan) . '</span>';
            $row[] = '<a class="btn btn-light-info btn-sm shadow font-weight-bold" data-toggle="modal"
            onclick="showedit(' . $value->id . ')" href="#modal_detail"><i class="fa fa-info-circle"></i> Detail Perolehan</a>';

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


        // var_dump($table_identity);

        $this->data['sektor'] = $this->db->query("SELECT *,
        (SELECT target_online FROM target_$table_identity WHERE id_sektor = sektor_$table_identity.id && id_wilayah_survei = $id_wilayah_survei) AS target_online,
        
        (SELECT target_offline FROM target_$table_identity WHERE id_sektor = sektor_$table_identity.id && id_wilayah_survei = $id_wilayah_survei) AS target_offline,
        
        (SELECT COUNT(id_responden) FROM responden_$table_identity JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden WHERE is_submit = 1 && responden_$table_identity.sektor = sektor_$table_identity.id && responden_$table_identity.wilayah_survei = $id_wilayah_survei && id_surveyor = 0) AS perolehan_online,
         
        (SELECT COUNT(id_responden) FROM responden_$table_identity JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden WHERE is_submit = 1 && responden_$table_identity.sektor = sektor_$table_identity.id && responden_$table_identity.wilayah_survei = $id_wilayah_survei && id_surveyor != 0) AS perolehan_offline
        
        FROM sektor_$table_identity");

        $this->data['wilayah_survei'] = $this->db->query("SELECT *
        FROM wilayah_survei_$table_identity
        WHERE id = $id_wilayah_survei")->row();

        return view('rekap_per_wilayah/detail', $this->data);
    }
}

/* End of file TargetProvinsiController.php */
/* Location: ./application/controllers/TargetProvinsiController.php */
