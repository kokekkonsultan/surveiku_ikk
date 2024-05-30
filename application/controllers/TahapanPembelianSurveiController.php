<?php
defined('BASEPATH') or exit('No direct script access allowed');

require 'application/core/Klien_Controller.php';
use application\core\Klien_Controller;

class TahapanPembelianSurveiController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('ion_auth');

        if (!$this->ion_auth->logged_in()) {
            $this->session->set_flashdata('message_warning', 'You must be logged in to access this page');
            redirect('auth', 'refresh');
        }

        $this->load->library('form_validation');
        $this->load->model('TahapanPembelianSurvei_model', 'models');
    }

    public function index($id1, $id2)
    {
        $this->data = [];
        $this->data['title'] = "Tahapan Pembelian";

        $profiles = new Klien_Controller();
        $this->data['profiles'] = $profiles->_get_data_profile($id1, $id2);
        $table_identity = $this->data['profiles']->table_identity;

        $this->data['tahapan_pembelian'] = $this->db->get("tahapan_pembelian_$table_identity");

        return view('tahapan_pembelian_survei/index', $this->data);
    }

    public function ajax_list($id1, $id2)
    {
        $slug = $this->uri->segment(2);

        // Get Identity
        $get_identity = $this->db->get_where('manage_survey', ['slug' => "$slug"])->row();
        $table_identity = $get_identity->table_identity;

        $list = $this->models->get_datatables($table_identity);
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $value) {

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $value->kode_tahapan_pembelian;
            $row[] = $value->nama_tahapan_pembelian;

            $row[] = '<button type="button" class="btn btn-light-primary btn-sm font-weight-bold shadow" data-toggle="modal" data-target="#edit_' . $value->id . '">
            <i class="fa fa-edit"></i> Edit</button>';

            // if ($get_identity->is_question == 1) {
            //     $row[] = '<a class="btn btn-light-primary btn-sm font-weight-bold shadow" href="javascript:void(0)" title="Hapus ' . $value->id . '" onclick="delete_data(' . "'" . $value->id . "'" . ')"><i class="fa fa-trash"></i> Delete</a>';
            // }

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


    public function edit()
    {
        $slug = $this->uri->segment(2);
        $manage_survey = $this->db->get_where('manage_survey', array('slug' => "$slug"))->row();
        $table_identity = $manage_survey->table_identity;

        $object = [
            'nama_tahapan_pembelian'     => $this->input->post('nama_tahapan_pembelian')
        ];
        $this->db->where('id', $this->uri->segment(5));
        $this->db->update('tahapan_pembelian_' . $table_identity, $object);

        $pesan = 'Data berhasil disimpan';
        $msg = ['sukses' => $pesan];
        echo json_encode($msg);
    }



    public function delete($username, $slug, $id_pertanyaan_unsur)
    {
        // Get Identity
        $slug = $this->uri->segment(2);
        $get_identity = $this->db->get_where('manage_survey', ['slug' => "$slug"])->row();
        $table_identity = $get_identity->table_identity;

        $this->db->where('id', $id_pertanyaan_unsur);
        $this->db->delete("pertanyaan_unsur_$table_identity");

        echo json_encode(array("status" => TRUE));
    }
}
