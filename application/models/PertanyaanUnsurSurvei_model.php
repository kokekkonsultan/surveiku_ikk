<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PertanyaanUnsurSurvei_model extends CI_Model
{

    var $table          = '';
    var $column_order   = array(null, null, null, null, null);
    var $column_search  = array('nama_unsur', 'isi_pertanyaan');
    var $order          = array('id_unsur' => 'asc');

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query($table_identity)
    {
        $this->db->select("*, pertanyaan_unsur_$table_identity.id AS id_pertanyaan_unsur,
        (SELECT nama_jawaban FROM nilai_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && nilai_jawaban = 1) AS pilihan_1,
        (SELECT nama_jawaban FROM nilai_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && nilai_jawaban = 2) AS pilihan_2,
        (SELECT nama_jawaban FROM nilai_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && nilai_jawaban = 3) AS pilihan_3,
        (SELECT nama_jawaban FROM nilai_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && nilai_jawaban = 4) AS pilihan_4,
        (SELECT nama_jawaban FROM nilai_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && nilai_jawaban = 5) AS pilihan_5, (SELECT kode_dimensi FROM dimensi_$table_identity WHERE id_dimensi = dimensi_$table_identity.id) AS kode_dimensi,
        (SELECT nama_dimensi FROM dimensi_$table_identity WHERE id_dimensi = dimensi_$table_identity.id) AS nama_dimensi");

        $this->db->from("pertanyaan_unsur_$table_identity");
        $this->db->join("unsur_$table_identity", "pertanyaan_unsur_$table_identity.id_unsur = unsur_$table_identity.id");

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
        $this->db->from("pertanyaan_unsur_$table_identity");
        $this->db->join("unsur_$table_identity", "pertanyaan_unsur_$table_identity.id_unsur = unsur_$table_identity.id");
        return $this->db->count_all_results();
    }


    public function dropdown_dimensi($table_identity)
    {
        $query = $this->db->query("SELECT *, (SELECT IF(SUM(persentase_unsur) != '',SUM(persentase_unsur), 0) FROM unsur_$table_identity WHERE id_dimensi = dimensi_$table_identity.id) AS persentase_unsur
        FROM dimensi_$table_identity
        WHERE persentase_dimensi != (SELECT IF(SUM(persentase_unsur) != '',SUM(persentase_unsur), 0) FROM unsur_$table_identity WHERE id_dimensi = dimensi_$table_identity.id)");

        if ($query->num_rows() > 0) {

            $dd[''] = 'Please Select';
            foreach ($query->result_array() as $row) {
                $dd[$row['id']] = $row['kode_dimensi'] . '. ' . $row['nama_dimensi'] . ' (' . $row['persentase_dimensi'] . '%)';
            }

            return $dd;
        }
    }
}

/* End of file PertanyaanUnsurSurvei_model.php */
/* Location: ./application/models/PertanyaanUnsurSurvei_model.php */