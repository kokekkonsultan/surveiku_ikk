<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DimensiSurvei_model extends CI_Model
{

    var $table          = '';
    var $column_order   = array(null, null, null, null, null);
    var $column_search  = array('nama_dimensi');
    var $order          = array('id' => 'asc');

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query($table_identity)
    {

        $this->db->select("*, (SELECT kode_tahapan_pembelian FROM tahapan_pembelian_$table_identity WHERE id_tahapan_pembelian = tahapan_pembelian_$table_identity.id) AS kode_tahapan_pembelian, (SELECT nama_tahapan_pembelian FROM tahapan_pembelian_$table_identity WHERE id_tahapan_pembelian = tahapan_pembelian_$table_identity.id) AS nama_tahapan_pembelian");
        $this->db->from("dimensi_$table_identity");

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
        $this->db->from('dimensi_' . $table_identity);
        return $this->db->count_all_results();
    }


    public function dropdown_tahapan_pembelian($table_identity)
    {
        $query = $this->db->get("tahapan_pembelian_$table_identity");

        if ($query->num_rows() > 0) {

            $dd[''] = 'Please Select';
            foreach ($query->result_array() as $row) {
                $dd[$row['id']] = $row['kode_tahapan_pembelian'] . '. ' . $row['nama_tahapan_pembelian'];
            }
            return $dd;
        }
    }
}

/* End of file PertanyaanUnsurSurvei_model.php */
/* Location: ./application/models/PertanyaanUnsurSurvei_model.php */