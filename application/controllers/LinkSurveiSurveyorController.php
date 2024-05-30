<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LinkSurveiSurveyorController extends CI_Controller
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
    public function index()
    {
        $this->data = [];
        $this->data['title'] = "Link Survei Surveyor";

        $user = $this->ion_auth->user()->row();

        $this->data['manage_survey'] = $this->db->query("SELECT *, surveyor.uuid AS uuid_surveyor
        FROM surveyor
        JOIN manage_survey ON surveyor.id_manage_survey = manage_survey.id
        WHERE surveyor.id_user = $user->id")->row();

        return view('link_survei_surveyor/index', $this->data);
    }
}