<?php
defined('BASEPATH') or exit('No direct script access allowed');

require 'application/core/Klien_Controller.php';

use application\core\Klien_Controller;

class TargetSurveyorController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('ion_auth');

        if (!$this->ion_auth->logged_in()) {
            $this->session->set_flashdata('message_warning', 'You must be logged in to access this page');
            redirect('auth', 'refresh');
        }
        // $this->load->model('TargetProvinsi_model', 'models');
    }

    public function index($id1, $id2)
    {
        $this->data = [];
        $this->data['title'] = "Target Surveyor";

        $user = $this->ion_auth->user()->row();
        $surveyor = $this->db->get_where('surveyor', array('id_user' => $user->id))->row();
        $manage_survey = $this->db->get_where('manage_survey', array('id' => $surveyor->id_manage_survey))->row();
        $table_identity = $manage_survey->table_identity;

        $this->data['target_surveyor'] = $this->db->query("SELECT *,
        ROUND((SELECT target_offline FROM target_$table_identity WHERE id_wilayah_survei = $surveyor->id_wilayah_survei && id_sektor = sektor_$table_identity.id) / (SELECT COUNT(id) FROM surveyor WHERE id_manage_survey = $manage_survey->id && id_wilayah_survei = $surveyor->id_wilayah_survei)) AS target,
        
        (SELECT COUNT(id_responden) FROM survey_$table_identity JOIN responden_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden WHERE is_submit = 1 && id_surveyor = $surveyor->id && responden_$table_identity.sektor = sektor_$table_identity.id && responden_$table_identity.wilayah_survei = $surveyor->id_wilayah_survei) AS perolehan
        FROM sektor_$table_identity");

        return view('target_surveyor/index', $this->data);
    }
}