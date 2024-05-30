<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DataPerolehanSurveyor_model extends CI_Model
{

    var $table          = '';
    var $column_order   = array(null);
    var $column_search  = array("nama_lengkap");
    var $order          = array('id_responden' => 'desc');

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query($profil_responden, $table_identity, $id_surveyor)
    {
        $data_profil = [];
        foreach ($profil_responden as $get) {
            if ($get->id != 1 || $get->id != 2) {
                if ($get->jenis_isian == 1) {

                    $data_profil[] = "(SELECT nama_kategori_profil_responden FROM kategori_profil_responden_$table_identity WHERE responden_$table_identity.$get->nama_alias = kategori_profil_responden_$table_identity.id) AS $get->nama_alias";
                } else {
                    $data_profil[] = $get->nama_alias;
                }
            }
        }
        $query_profil = implode(",", $data_profil);

        $this->db->select("*, survey_$table_identity.id AS id_survey, responden_$table_identity.uuid AS uuid_responden, $query_profil, (SELECT nama_sektor FROM sektor_$table_identity WHERE responden_$table_identity.sektor = sektor_$table_identity.id) AS sektor, (SELECT nama_wilayah FROM wilayah_survei_$table_identity WHERE responden_$table_identity.wilayah_survei = wilayah_survei_$table_identity.id) AS wilayah_survei");
        $this->db->from("responden_$table_identity");
        $this->db->join("survey_$table_identity", "responden_$table_identity.id = survey_$table_identity.id_responden");
        $this->db->join("surveyor", "survey_$table_identity.id_surveyor = surveyor.id");
        $this->db->where("surveyor.id_user", $id_surveyor);

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

    function get_datatables($profil_responden, $table_identity, $id_surveyor)
    {
        $this->_get_datatables_query($profil_responden, $table_identity, $id_surveyor);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($profil_responden, $table_identity, $id_surveyor)
    {
        $this->_get_datatables_query($profil_responden, $table_identity, $id_surveyor);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($profil_responden, $table_identity, $id_surveyor)
    {
        $this->db->from("responden_$table_identity");
        $this->db->join("survey_$table_identity", "responden_$table_identity.id = survey_$table_identity.id_responden");
        $this->db->join("surveyor", "survey_$table_identity.id_surveyor = surveyor.id");
        $this->db->where("surveyor.id_user", $id_surveyor);
        return $this->db->count_all_results();
    }
}