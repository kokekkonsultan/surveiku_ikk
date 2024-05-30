<?php
defined('BASEPATH') or exit('No direct script access allowed');

require 'application/core/Klien_Controller.php';

use application\core\Klien_Controller;

class RekapPerSektorController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('ion_auth');

        if (!$this->ion_auth->logged_in()) {
            $this->session->set_flashdata('message_warning', 'You must be logged in to access this page');
            redirect('auth', 'refresh');
        }
    }

    public function index($id1, $id2)
    {
        $this->data = [];
        $this->data['title'] = "Rekap Per Sektor";

        $profiles = new Klien_Controller();
        $this->data['profiles'] = $profiles->_get_data_profile($id1, $id2);
        $table_identity = $this->data['profiles']->table_identity;

        $this->data['sektor'] = $this->db->query("SELECT *,
        (SELECT SUM(target_online) FROM target_$table_identity WHERE id_sektor = sektor_$table_identity.id) AS target_online,
        (SELECT SUM(target_offline) FROM target_$table_identity WHERE id_sektor = sektor_$table_identity.id) AS target_offline,     
        (SELECT COUNT(id_responden) FROM responden_$table_identity JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden WHERE responden_$table_identity.sektor = sektor_$table_identity.id && is_submit = 1 && survey_$table_identity.id_surveyor = 0) AS perolehan_online,     
        (SELECT COUNT(id_responden) FROM responden_$table_identity JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden WHERE responden_$table_identity.sektor = sektor_$table_identity.id && is_submit = 1 && survey_$table_identity.id_surveyor != 0) AS perolehan_offline
        
        FROM sektor_$table_identity");



        if ($this->data['profiles']->is_question == 1) {
            $this->data['pesan'] = 'survei belum dimulai atau belum ada responden !';
            return view('not_questions/index', $this->data);
        } else {
            return view('rekap_per_sektor/index', $this->data);
        }
    }
}

/* End of file TargetProvinsiController.php */
/* Location: ./application/controllers/TargetProvinsiController.php */
