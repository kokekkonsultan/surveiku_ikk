<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PertanyaanUnsurSurveiController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('ion_auth');

        if (!$this->ion_auth->logged_in()) {
            $this->session->set_flashdata('message_warning', 'You must be logged in to access this page');
            redirect('auth', 'refresh');
        }

        // $manage_survei = $this->db->get_where("manage_survey", array('slug' => $this->uri->segment(2)))->row();
        // if ($manage_survei->is_dimensi == 2) {
        //     $this->session->set_flashdata('message_danger', 'Silahkan Konfirmasi Pengisian Dimensi terlebih dahulu di menu dimensi paling bawah !');
        //     redirect(base_url() . $this->session->userdata('username') . '/' . $this->uri->segment(2) . '/dimensi', 'refresh');
        // }

        $this->load->library('form_validation');
        $this->load->model('PertanyaanUnsurSurvei_model', 'models');
    }

    public function index($id1, $id2)
    {
        $this->data = [];
        $this->data['title'] = 'Pertanyaan Unsur';
        $this->data['profiles'] = $this->_get_data_profile($id1, $id2);

        $this->data['slug'] = $this->uri->segment(2);

        $this->data['manage_survey'] = $this->db->get_where('manage_survey', array('slug' => $this->data['slug']))->row();
        $table_identity = $this->data['manage_survey']->table_identity;
        $this->data['is_question'] = $this->data['manage_survey']->is_question;

        $this->data['total_persentase_unsur'] = $this->db->query("SELECT SUM(persentase_unsur) AS total_persentase FROM unsur_$table_identity")->row()->total_persentase;

        if ($this->data['total_persentase_unsur'] < 100) {
            $this->data['btn_add'] = '<a class="btn btn-primary btn-sm font-weight-bold"
            href="' . base_url() . $this->session->userdata('username') . '/' . $this->uri->segment(2) . '/pertanyaan-unsur/add"><i class="fa fa-plus"></i> Tambah Pertanyaan Unsur</a>';
        } else {
            $this->data['btn_add'] = '<a type="button" class="btn btn-primary btn-sm font-weight-bold" onclick="cek()"><i class="fa fa-plus"></i> Tambah Pertanyaan Unsur</a>';
        }


        return view('pertanyaan_unsur_survei/index', $this->data);
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

            $pilihan_jawaban = '<label><input type="radio">&ensp;' . $value->pilihan_1 . '&emsp;</label><label><input type="radio">&ensp;' . $value->pilihan_2 . '&emsp;</label><label><input type="radio">&ensp;' . $value->pilihan_3 . '&emsp;</label><label><input type="radio">&ensp;' . $value->pilihan_4 . '&emsp;</label><label><input type="radio">&ensp;' . $value->pilihan_5 . '&emsp;</label>';

            if ($get_identity->is_question == 1) {
                $btn = anchor($this->session->userdata('username') . '/' . $this->uri->segment(2) . '/pertanyaan-unsur/edit/' . $value->id, '<i class="fa fa-edit"></i> Edit', ['class' => 'btn btn-light-primary btn-sm font-weight-bold shadow']) . '<br><hr>' . '<a class="btn btn-light-primary btn-sm font-weight-bold shadow" href="javascript:void(0)" title="Hapus ' . $value->id_unsur . '" onclick="delete_data(' . "'" . $value->id_unsur . "'" . ')"><i class="fa fa-trash"></i> Delete</a>';
            } else {
                $btn = anchor($this->session->userdata('username') . '/' . $this->uri->segment(2) . '/pertanyaan-unsur/edit/' . $value->id_unsur, '<i class="fa fa-edit"></i> Edit', ['class' => 'btn btn-light-primary btn-sm font-weight-bold shadow']);
            }

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<b>' . $value->kode_dimensi . '. ' . $value->nama_dimensi . '</b>';
            $row[] = '<b>' . $value->kode_unsur . '. ' . $value->nama_unsur . '</b><br><hr>' . $value->isi_pertanyaan;
            $row[] = $pilihan_jawaban;
            $row[] = $value->persentase_unsur . '%';
            $row[] = $btn;

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

    public function add($username, $slug_survei)
    {
        $this->load->model('PertanyaanUnsurSurvei_model');

        $this->data = array();
        $this->data['title']        = 'Tambah Pertanyaan Unsur';
        $this->data['form_action']  = base_url() . "$username/$slug_survei/pertanyaan-unsur/add";

        // Get Identity
        $get_identity = $this->db->get_where('manage_survey', ['slug' => "$slug_survei"])->row();
        $table_identity = $get_identity->table_identity;


        $this->form_validation->set_rules('id_dimensi', 'Id Dimensi', 'trim|required');
        $this->form_validation->set_rules('nama_unsur', 'Nama Unsur', 'trim|required');
        $this->form_validation->set_rules('pertanyaan_unsur', 'Pertanyaan Unsur', 'trim|required');
        $this->form_validation->set_rules('bobot_pertanyaan_unsur', 'Bobot Pertanyaan Unsur', 'trim|required');

        if ($this->form_validation->run() == FALSE) {

            $this->data['id_dimensi'] = [
                'name'      => 'id_dimensi',
                'id'        => 'id_dimensi',
                'options'   => $this->PertanyaanUnsurSurvei_model->dropdown_dimensi($table_identity),
                'selected'  => $this->form_validation->set_value('id_dimensi'),
                'class'     => "form-control id_dimensi",
                'autofocus' => 'autofocus',
                'required' => 'required',
                'onchange' => 'return autofill_dimensi();'
            ];

            $this->data['kode_unsur'] = $this->db->get("unsur_$table_identity")->num_rows() + 1;
            $this->data['nama_unsur'] = [
                'name' => 'nama_unsur',
                'value' => $this->form_validation->set_value('nama_unsurr'),
                'class' => 'form-control',
                'required' => 'required',
                'rows' => '2'
            ];

            $this->data['pertanyaan_unsur'] = [
                'name' => 'pertanyaan_unsur',
                'id' => 'kt-ckeditor-1',
                'value' => $this->form_validation->set_value('pertanyaan_unsur'),
                'class' => 'form-control',
                // 'required' => 'required',
            ];

            $this->data['bobot_pertanyaan_unsur'] = [
                'type' => 'number',
                'name' => 'bobot_pertanyaan_unsur',
                'id' => 'bobot_pertanyaan_unsur',
                'value' => $this->form_validation->set_value('bobot_pertanyaan_unsur'),
                'class' => 'form-control',
                'required' => 'required',
                'step' => 'any',
                'min' => 0
            ];


            $this->data['nilai_unsur_pelayanan'] = $this->db->get('nilai_unsur_pelayanan_' . $table_identity)->result();

            $this->db->select('*');
            $this->db->from('pilihan_jawaban_pertanyaan_unsur');
            $this->data['pilihan'] = $this->db->get();

            return view('pertanyaan_unsur_survei/form_add', $this->data);
        } else {

            $id_dimensi = $this->input->post('id_dimensi');
            $bobot_dimensi = $this->db->get_where("dimensi_$table_identity", array("id" => $id_dimensi))->row()->persentase_dimensi;
            $persentase_unsur = $this->db->query("SELECT SUM(persentase_unsur) AS total_persentase FROM unsur_$table_identity WHERE id_dimensi = $id_dimensi")->row()->total_persentase;

            if (($persentase_unsur + $this->input->post('bobot_pertanyaan_unsur')) > $bobot_dimensi) {
                $this->session->set_flashdata('message_danger', 'Bobot Unsur sudah melebihi target !');
                redirect(base_url() . $username . '/' . $this->uri->segment(2) . '/pertanyaan-unsur', 'refresh');
            }

            $obj = [
                'id_dimensi'     => $id_dimensi,
                'kode_unsur' => $this->input->post('kode_unsur'),
                'nama_unsur' => $this->input->post('nama_unsur'),
                'persentase_unsur' => $this->input->post('bobot_pertanyaan_unsur'),
            ];
            $this->db->insert('unsur_' . $table_identity, $obj);

            if (isset($_POST['label_alasan'])) {
                $label_alasan = $this->input->post('label_alasan');
            } else {
                $label_alasan = 'Masukkan alasan jawaban pada bidang ini ...';
            }

            if($this->input->post('label_alasan') != ''){
                $label_alasan = $this->input->post('label_alasan');
            } else{
                $label_alasan = 'Masukkan alasan jawaban pada bidang ini ...';
            }
              
            if(serialize($this->input->post('atribute_alasan')) != 'N;'){
                $atribute_alasan = serialize($this->input->post('atribute_alasan'));
            } else {
                $atribute_alasan = 'a:1:{i:0;s:0:"";}';
            }


            $id_unsur = $this->db->insert_id();
            $object = [
                'id_unsur'     => $id_unsur,
                'isi_pertanyaan' => $this->input->post('pertanyaan_unsur'),
                'is_active_alasan' => $this->input->post('is_active_alasan'),
                'label_alasan' => $label_alasan,
                'atribute_alasan' => $atribute_alasan
            ];
            // var_dump($object);
            $this->db->insert('pertanyaan_unsur_' . $table_identity, $object);


            $id_pertanyaan_unsur = $this->db->insert_id();
            $pilihan_jawaban = $this->input->post('pilihan_jawaban[]');
            $nilai_jawaban = $this->input->post('nilai_jawaban[]');
            $result = array();
            foreach ($pilihan_jawaban as $key => $val) {
                $result[] = array(
                    'id_pertanyaan_unsur' => $id_pertanyaan_unsur,
                    'nilai_jawaban' => $nilai_jawaban[$key],
                    'nama_jawaban' => $pilihan_jawaban[$key]
                );
            }
            $this->db->insert_batch("nilai_unsur_pelayanan_$table_identity", $result);

            $this->session->set_flashdata('message_success', 'Pertanyaan unsur berhasil ditambahkan');
            redirect(base_url() . $username . '/' . $this->uri->segment(2) . '/pertanyaan-unsur', 'refresh');
        }
    }



    public function edit($username)
    {
        $this->data = [];
        $this->data['title'] = 'Edit Pertanyaan Unsur';
        $this->data['form_action']     = $username . '/' . $this->uri->segment(2) . '/pertanyaan-unsur/edit/' . $this->uri->segment(5);

        // Get Identity
        $slug = $this->uri->segment(2);
        $get_identity = $this->db->get_where('manage_survey', ['slug' => "$slug"])->row();
        $table_identity = $get_identity->table_identity;


        $current = $this->db->query("SELECT *, (SELECT id FROM pertanyaan_unsur_$table_identity WHERE id_unsur = unsur_$table_identity.id) AS id_pertanyaan_unsur,  (SELECT isi_pertanyaan FROM pertanyaan_unsur_$table_identity WHERE id_unsur = unsur_$table_identity.id) AS isi_pertanyaan, (SELECT kode_dimensi FROM dimensi_$table_identity WHERE id_dimensi = dimensi_$table_identity.id) AS kode_dimensi, (SELECT nama_dimensi FROM dimensi_$table_identity WHERE id_dimensi = dimensi_$table_identity.id) AS nama_dimensi, 
        (SELECT is_active_alasan FROM pertanyaan_unsur_$table_identity WHERE id_unsur = unsur_$table_identity.id) AS is_active_alasan,
        (SELECT label_alasan FROM pertanyaan_unsur_$table_identity WHERE id_unsur = unsur_$table_identity.id) AS label_alasan,
        (SELECT atribute_alasan FROM pertanyaan_unsur_$table_identity WHERE id_unsur = unsur_$table_identity.id) AS atribute_alasan
        FROM unsur_$table_identity WHERE unsur_$table_identity.id = " . $this->uri->segment(5))->row();
        $this->data['pertanyaan'] = $current;
        

        $this->data['dimensi'] = $current->kode_dimensi . '. ' . $current->nama_dimensi;
        $this->data['kode_unsur'] = $current->kode_unsur;
        $this->data['nama_unsur'] = [
            'name' => 'nama_unsur',
            'value' => $this->form_validation->set_value('nama_unsur', $current->nama_unsur),
            'class' => 'form-control',
            'required' => 'required',
            'rows' => '2'
        ];

        $this->data['pertanyaan_unsur'] = [
            'name' => 'pertanyaan_unsur',
            'id' => 'kt-ckeditor-1',
            'value' => $this->form_validation->set_value('pertanyaan_unsur', $current->isi_pertanyaan),
            'class' => 'form-control',
            // 'required' => 'required',
            // 'autofocus' => 'autofocus'
        ];

        // $this->data['persentase_unsur'] = [
        //     'name' => 'persentase_unsur',
        //     'id' => 'persentase_unsur',
        //     'value' => $this->form_validation->set_value('persentase_unsur', $current->persentase_unsur),
        //     'class' => 'form-control',
        //     'required' => 'required',
        // ];

        $this->data['nilai_unsur_pelayanan'] = $this->db->get_where('nilai_unsur_pelayanan_' . $table_identity, array('id_pertanyaan_unsur' => $current->id_pertanyaan_unsur))->result();


        $this->form_validation->set_rules('nama_unsur', 'Nama Unsur', 'trim|required');
        $this->form_validation->set_rules('pertanyaan_unsur', 'Pertanyaan Unsur', 'trim|required');

        if ($this->form_validation->run() == FALSE) {

            return view('pertanyaan_unsur_survei/form_edit', $this->data);
        } else {

            $input     = $this->input->post(NULL, TRUE);
            $obj = [
                'nama_unsur' => $input['nama_unsur']
            ];
            $this->db->where('id', $this->uri->segment(5));
            $this->db->update('unsur_' . $table_identity, $obj);

            if($this->input->post('label_alasan') != ''){
                $label_alasan = $this->input->post('label_alasan');
            } else{
                $label_alasan = 'Masukkan alasan jawaban pada bidang ini ...';
            };
              
            if(serialize($this->input->post('atribute_alasan')) != 'N;'){
                $atribute_alasan = serialize($this->input->post('atribute_alasan'));
            } else {
                $atribute_alasan = 'a:1:{i:0;s:0:"";}';
            };


            $object = [
                'isi_pertanyaan'     => $input['pertanyaan_unsur'],
                'is_active_alasan' => $this->input->post('is_active_alasan'),
                'label_alasan' => $label_alasan,
                'atribute_alasan' => $atribute_alasan
            ];
            $this->db->where('id_unsur', $this->uri->segment(5));
            $this->db->update('pertanyaan_unsur_' . $table_identity, $object);

            $id = $input['id'];
            $nama_jawaban = $input['nama_jawaban'];
            for ($i = 0; $i < sizeof($id); $i++) {
                $kategori = array(
                    'id' => $id[$i],
                    'nama_jawaban' => $nama_jawaban[$i]
                );
                $this->db->where('id', $id[$i]);
                $this->db->update('nilai_unsur_pelayanan_' . $table_identity, $kategori);
            }

            $this->session->set_flashdata('message_success', 'Berhasil mengubah pertanyaan unsur');
            redirect(base_url() . $username . '/' . $this->uri->segment(2) . '/pertanyaan-unsur', 'refresh');
        }
    }



    public function delete()
    {
        $slug = $this->uri->segment(2);
        $get_identity = $this->db->get_where('manage_survey', ['slug' => "$slug"])->row();
        $table_identity = $get_identity->table_identity;

        $id_pertanyaan_unsur = $this->db->get_where("pertanyaan_unsur_$table_identity", array('id_unsur' => $this->uri->segment(5)))->row()->id;

        $this->db->where('id_pertanyaan_unsur', $id_pertanyaan_unsur);
        $this->db->delete("nilai_unsur_pelayanan_$table_identity");

        $this->db->where('id_unsur', $this->uri->segment(5));
        $this->db->delete("pertanyaan_unsur_$table_identity");

        $this->db->where('id', $this->uri->segment(5));
        $this->db->delete("unsur_$table_identity");

        echo json_encode(array("status" => TRUE));
    }


    public function cari()
    {
        $id = $_GET['id'];

        $this->db->select('*');
        $this->db->from('pilihan_jawaban_pertanyaan_unsur');
        $this->db->where('id', $id);
        $cari = $this->db->get()->result();

        echo json_encode($cari);
    }

    public function autofill_dimensi()
    {
        $id = $this->uri->segment(5);

        $slug = $this->uri->segment(2);
        $get_identity = $this->db->get_where('manage_survey', ['slug' => "$slug"])->row();
        $table_identity = $get_identity->table_identity;

        $dimensi = $this->db->get_where("dimensi_$table_identity", array("id" => $id))->row();

        $persentase_unsur = $this->db->query("SELECT SUM(persentase_unsur) AS total_persentase FROM unsur_$table_identity WHERE id_dimensi = $id")->row()->total_persentase;

        if ($persentase_unsur != NULL) {
            $total_persentase_unsur =  $persentase_unsur;
        } else {
            $total_persentase_unsur =  0;
        }

        // $pesan = 'Data berhasil disimpan';
        $data = ['target' => $dimensi->persentase_dimensi, 'bobot_tersimpan' => $total_persentase_unsur];
        echo json_encode($data);
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