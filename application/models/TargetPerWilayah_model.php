<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TargetPerWilayah_model extends CI_Model
{

    var $table          = '';
    var $column_order   = array(null, null, null, null, null, null);
    var $column_search  = array('nama_wilayah');
    var $order          = array('id' => 'asc');

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query($table_identity)
    {
        $this->db->select("*,
        (SELECT SUM(target_online) FROM target_$table_identity WHERE id_wilayah_survei = wilayah_survei_$table_identity.id) AS target_wilayah_online, 

        (SELECT SUM(target_offline) FROM target_$table_identity WHERE id_wilayah_survei = wilayah_survei_$table_identity.id) AS target_wilayah_offline,

        (SELECT COUNT(id_responden) FROM responden_$table_identity JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden WHERE is_submit = 1 && responden_$table_identity.wilayah_survei = wilayah_survei_$table_identity.id && id_surveyor = 0) AS perolehan_online,
        
        (SELECT COUNT(id_responden) FROM responden_$table_identity JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden WHERE is_submit = 1 && responden_$table_identity.wilayah_survei = wilayah_survei_$table_identity.id && id_surveyor != 0) AS perolehan_offline,

        (SELECT SUM(target_online + target_offline) FROM target_$table_identity WHERE id_wilayah_survei = wilayah_survei_$table_identity.id) AS total_target,
        
        (SELECT COUNT(id_responden) FROM responden_$table_identity JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden WHERE is_submit = 1 && responden_$table_identity.wilayah_survei = wilayah_survei_$table_identity.id) AS total_perolehan,

        ((SELECT SUM(target_online + target_offline) FROM target_$table_identity WHERE id_wilayah_survei = wilayah_survei_$table_identity.id) - (SELECT COUNT(id_responden) FROM responden_$table_identity JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden WHERE is_submit = 1 && responden_$table_identity.wilayah_survei = wilayah_survei_$table_identity.id)) AS total_kekurangan,
        
        (((SELECT COUNT(id_responden) FROM responden_$table_identity JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden WHERE is_submit = 1 && responden_$table_identity.wilayah_survei = wilayah_survei_$table_identity.id) / (SELECT SUM(target_online + target_offline) FROM target_$table_identity WHERE id_wilayah_survei = wilayah_survei_$table_identity.id)) * 100) AS akumulasi_persen
        ");

        $this->db->from("wilayah_survei_$table_identity");

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
    }

    function get_datatables($table_identity)
    {
        $this->_get_datatables_query($table_identity);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($table_identity)
    {
        $this->_get_datatables_query($table_identity);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($table_identity)
    {
        $this->db->from("wilayah_survei_$table_identity");
        return $this->db->count_all_results();
    }
}

/* End of file DataProspekSurvey_model.php */
/* Location: ./application/models/DataProspekSurvey_model.php */