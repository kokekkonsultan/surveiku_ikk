<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TargetKeseluruhanController extends CI_Controller
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
        $this->data['title'] = "Target Keseluruhan";

        $klien_induk = $this->db->get_where("pengguna_klien_induk", array('id_user' => $this->session->userdata('user_id')))->row();
		$parent = implode(", ", unserialize($klien_induk->cakupan_induk));


        $data_target = [];
        foreach ($this->db->query("SELECT * FROM manage_survey WHERE id IN ($parent)")->result() as $value) {

            $table_identity = $value->table_identity;
            $data_target[] = "
            UNION ALL
            SELECT *,
            (SELECT SUM(target_online) FROM target_$table_identity WHERE id_sektor = sektor_$table_identity.id) AS target_online,
            (SELECT SUM(target_offline) FROM target_$table_identity WHERE id_sektor = sektor_$table_identity.id) AS target_offline,
            
            (SELECT COUNT(id_responden) FROM responden_$table_identity JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden WHERE is_submit = 1 && responden_$table_identity.sektor = sektor_$table_identity.id && id_surveyor = 0) AS perolehan_online,
            
            (SELECT COUNT(id_responden) FROM responden_$table_identity JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden WHERE is_submit = 1 && responden_$table_identity.sektor = sektor_$table_identity.id && id_surveyor != 0) AS perolehan_offline
            
            FROM sektor_$table_identity";
        }
        $union_target = implode(" ", $data_target);


        
        $this->data['sektor'] = $this->db->query("

        SELECT id, nama_sektor,
        SUM(target_online) as total_target_online,
        SUM(target_offline) as total_target_offline,
        SUM(perolehan_online) as total_perolehan_online,
        SUM(perolehan_offline) as total_perolehan_offline

        FROM (

        SELECT *,
        (SELECT SUM(target_online) FROM target WHERE id_sektor = sektor.id) AS target_online,
        (SELECT SUM(target_offline) FROM target WHERE id_sektor = sektor.id) AS target_offline,

        (SELECT COUNT(id_responden) FROM responden JOIN survey ON responden.id = survey.id_responden WHERE is_submit = 1 && responden.sektor = sektor.id && id_surveyor = 0) AS perolehan_online,

        (SELECT COUNT(id_responden) FROM responden JOIN survey ON responden.id = survey.id_responden WHERE is_submit = 1 && responden.sektor = sektor.id && id_surveyor != 0) AS perolehan_offline

        FROM sektor

        $union_target
        ) sktr
        GROUP BY id
        ");


        return view('target_keseluruhan/index', $this->data);
    }

}

/* End of file TargetKeseluruhanController.php */
/* Location: ./application/controllers/TargetKeseluruhanController.php */
