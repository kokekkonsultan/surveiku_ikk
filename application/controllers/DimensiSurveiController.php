<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DimensiSurveiController extends CI_Controller
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
        $this->load->model('DimensiSurvei_model', 'models');
    }

    public function index($id1, $id2)
    {
        $this->data = [];
        $this->data['title'] = 'Dimensi';
        $this->data['profiles'] = $this->_get_data_profile($id1, $id2);

        $this->data['slug'] = $this->uri->segment(2);
        $manage_survey = $this->db->get_where('manage_survey', array('slug' => $this->data['slug']))->row();
        $table_identity = $manage_survey->table_identity;
        $this->data['is_question'] = $manage_survey->is_question;
        $this->data['is_dimensi'] = $manage_survey->is_dimensi;


        $jumlah_dimensi = $this->db->query("SELECT COUNT(id) AS jumlah_dimensi, SUM(persentase_dimensi) AS total_persentase FROM dimensi_$table_identity")->row();

        $this->data['total_persentase'] = ROUND($jumlah_dimensi->total_persentase);
        $this->data['kode_dimensi'] = $this->db->query("SELECT toRoman($jumlah_dimensi->jumlah_dimensi + 1) AS kode")->row()->kode;

        //TOMBOL ADD
        if ($this->data['total_persentase'] < 100) {
            $this->data['btn_add'] = '<button type="button" class="btn btn-primary btn-sm font-weight-bold" data-toggle="modal" data-target="#add"><i class="fa fa-plus"></i> Tambah Dimensi</button>';
        } else {
            $this->data['btn_add'] = '<a type="button" class="btn btn-primary btn-sm font-weight-bold" onclick="cek()"><i class="fa fa-plus"></i> Tambah Dimensi</a>';

            if ($manage_survey->is_dimensi == 2) {
                $this->data['color'] = 'bg-light-success';
                $this->data['text'] = 'Dengan menekan tombol konfirmasi dibawah ini berarti anda sudah melengkapi
                dimensi dengan benar dan siap melanjutkan ke tahap pengisian Unsur dan Pertanyaan Unsur.';
                $this->data['value'] = 1;
                $this->data['text_color'] = 'text-success';
            } else {
                $this->data['color'] = 'bg-light-danger';
                $this->data['text'] = 'Dengan menekan tombol konfirmasi dibawah ini berarti anda akan merubah susunan
                dimensi dan data pada unsur akan dikosongkan. Jangan khawatir, anda masih bisa mengelolanya setelah ini.';
                $this->data['value'] = 2;
                $this->data['text_color'] = 'text-danger';
            }
        }

        $this->data['id_tahapan_pembelian'] = [
            'name'      => 'id_tahapan_pembelian',
            'id'        => 'id_tahapan_pembelian',
            'options'   => $this->models->dropdown_tahapan_pembelian($table_identity),
            'selected'  => $this->form_validation->set_value('id_tahapan_pembelian'),
            'class'     => "form-control",
            'required' => 'required',
        ];

        $this->data['nama_dimensi'] = [
            'name' => 'nama_dimensi',
            'value' => $this->form_validation->set_value('nama_dimensi'),
            'class' => 'form-control',
            'required' => 'required',
            'rows' => '2'
        ];


        return view('dimensi_survei/index', $this->data);
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
            $row[] = '<b>' . $value->kode_tahapan_pembelian . '. ' . $value->nama_tahapan_pembelian . '</b><br> ' . $value->kode_dimensi . '. ' . $value->nama_dimensi;
            $row[] = $value->persentase_dimensi . '%';


            if ($get_identity->is_dimensi == 2) {
                $row[] = '<a class="btn btn-light-primary btn-sm font-weight-bold shadow" data-toggle="modal" onclick="showedit(' . $value->id . ')" href="#modal_edit"><i class="fa fa-edit"></i> Edit</a>';

                // if ($get_identity->is_question == 1) {
                $row[] = '<a class="btn btn-light-primary btn-sm font-weight-bold shadow" href="javascript:void(0)" title="Hapus ' . $value->id . '" onclick="delete_data(' . "'" . $value->id . "'" . ')"><i class="fa fa-trash"></i> Delete</a>';
                // }
            }
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


    public function add()
    {
        $slug = $this->uri->segment(2);
        $manage_survey = $this->db->get_where('manage_survey', array('slug' => "$slug"))->row();
        $table_identity = $manage_survey->table_identity;

        $object = [
            'id_tahapan_pembelian'     => $this->input->post('id_tahapan_pembelian'),
            'kode_dimensi'     => $this->input->post('kode_dimensi'),
            'nama_dimensi'     => $this->input->post('nama_dimensi'),
            'persentase_dimensi'     => $this->input->post('persentase_dimensi'),

        ];
        $this->db->insert('dimensi_' . $table_identity, $object);

        $pesan = 'Data berhasil disimpan';
        $msg = ['sukses' => $pesan];
        echo json_encode($msg);
    }

    public function detail_edit()
    {
        $this->data = [];
        $id_dimensi = $this->uri->segment(5);

        $slug = $this->uri->segment(2);
        $manage_survey = $this->db->get_where('manage_survey', array('slug' => "$slug"))->row();
        $table_identity = $manage_survey->table_identity;

        $current = $this->db->get_where("dimensi_$table_identity", array('id' => $id_dimensi))->row();

        $tahapan_pembelian = $this->db->get_where("tahapan_pembelian_$table_identity", array('id' => $current->id_tahapan_pembelian))->row();

        $this->data['id_tahapan_pembelian'] = [
            'name'      => 'id_tahapan_pembelian',
            'value'  => $this->form_validation->set_value('id_tahapan_pembelian', $tahapan_pembelian->kode_tahapan_pembelian . ', ' . $tahapan_pembelian->nama_tahapan_pembelian),
            'class'     => "form-control",
            'disabled' => 'disabled'
        ];


        $this->data['kode_dimensi'] = $current->kode_dimensi;
        $this->data['nama_dimensi'] = [
            'name' => 'nama_dimensi',
            'value' => $this->form_validation->set_value('nama_dimensi', $current->nama_dimensi),
            'class' => 'form-control',
            'required' => 'required',
            'rows' => '2'
        ];

        $this->data['persentase_dimensi'] = $current->persentase_dimensi;

        $jumlah_dimensi = $this->db->query("SELECT COUNT(id) AS jumlah_dimensi, SUM(persentase_dimensi) AS total_persentase FROM dimensi_$table_identity")->row();
        $this->data['total_persentase'] = $jumlah_dimensi->total_persentase - $current->persentase_dimensi;

        return view('dimensi_survei/modal_edit', $this->data);
    }


    public function edit()
    {
        $slug = $this->uri->segment(2);
        $manage_survey = $this->db->get_where('manage_survey', array('slug' => "$slug"))->row();
        $table_identity = $manage_survey->table_identity;

        $object = [
            // 'id_tahapan_pembelian'     => $this->input->post('id_tahapan_pembelian'),
            'nama_dimensi'     => $this->input->post('nama_dimensi'),
            'persentase_dimensi'     => $this->input->post('persentase_dimensi'),

        ];
        $this->db->where('id', $this->uri->segment(5));
        $this->db->update('dimensi_' . $table_identity, $object);

        $pesan = 'Data berhasil disimpan';
        $msg = ['sukses' => $pesan];
        echo json_encode($msg);
    }



    public function delete()
    {
        // Get Identity
        $slug = $this->uri->segment(2);
        $get_identity = $this->db->get_where('manage_survey', ['slug' => "$slug"])->row();
        $table_identity = $get_identity->table_identity;

        $pertanyaan_unsur = $this->db->query("SELECT GROUP_CONCAT(id) AS id_unsur, (SELECT GROUP_CONCAT(id) FROM pertanyaan_unsur_cst44 WHERE id_unsur = unsur_cst44.id) AS id_pertanyaan_unsur FROM unsur_cst44 WHERE id_dimensi = " . $this->uri->segment(5))->row();

        if ($pertanyaan_unsur->id_pertanyaan_unsur != NULL) {
            $this->db->where_in('id_pertanyaan_unsur', array($pertanyaan_unsur->id_pertanyaan_unsur));
            $this->db->delete("nilai_unsur_pelayanan_$table_identity");

            $this->db->where_in('id', array($pertanyaan_unsur->id_pertanyaan_unsur));
            $this->db->delete("pertanyaan_unsur_$table_identity");
        };

        if ($pertanyaan_unsur->id_unsur != NULL) {
            $this->db->where_in('id_dimensi', $this->uri->segment(5));
            $this->db->delete("unsur_$table_identity");
        }

        $this->db->where('id', $this->uri->segment(5));
        $this->db->delete("dimensi_$table_identity");

        echo json_encode(array("status" => TRUE));
    }


    public function konfirmasi()
    {
        $slug = $this->uri->segment(2);
        $this->db->select('*');
        $this->db->from('manage_survey');
        $this->db->where("slug = '$slug'");
        $current = $this->db->get()->row();


        if ($this->input->post('is_dimensi') == 2) {
            $this->db->empty_table('nilai_unsur_pelayanan_' . $current->table_identity);
            $this->db->empty_table('pertanyaan_unsur_' . $current->table_identity);
            $this->db->empty_table('unsur_' . $current->table_identity);
            $this->db->empty_table('jawaban_pertanyaan_unsur_' . $current->table_identity);
            $this->db->empty_table('survey_' . $current->table_identity);
            $this->db->empty_table('responden_' . $current->table_identity);
        }

        $object = [
            'is_dimensi'     => $this->input->post('is_dimensi'),
        ];
        $this->db->where('slug', "$slug");
        $this->db->update('manage_survey', $object);

        $pesan = 'Data berhasil disimpan';
        $msg = ['sukses' => $pesan];
        echo json_encode($msg);
    }


    public function _get_data_profile($id1, $id2)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->join('users_groups', 'users.id = users_groups.user_id');
        $this->db->where('users.username', $this->session->userdata('username'));
        $data_user = $this->db->get()->row();
        $user_identity = 'drs' . $data_user->is_parent;

        $this->db->select('users.username, manage_survey.survey_name, manage_survey.slug, manage_survey.description, manage_survey.is_privacy, manage_survey.table_identity, manage_survey.atribut_pertanyaan_survey');
        if ($data_user->group_id == 2) {
            $this->db->from('users');
            $this->db->join('manage_survey', 'manage_survey.id_user = users.id');
        } else {
            $this->db->from('manage_survey');
            $this->db->join("supervisor_$user_identity", "manage_survey.id_berlangganan = supervisor_$user_identity.id_berlangganan");
            $this->db->join("users", "supervisor_$user_identity.id_user = users.id");
        }
        $this->db->where('users.username', $id1);
        $this->db->where('manage_survey.slug', $id2);
        $profiles = $this->db->get();

        if ($profiles->num_rows() == 0) {
            // echo 'Survey tidak ditemukan atau sudah dihapus !';
            // exit();
            show_404();
        }
        return $profiles->row();
    }
}