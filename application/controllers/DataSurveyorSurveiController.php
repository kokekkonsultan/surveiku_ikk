<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DataSurveyorSurveiController extends CI_Controller
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
        $this->load->model('DataSurveyorSurvei_model', 'models');
    }

    public function index($id1, $id2)
    {
        $this->data = [];
        $this->data['title'] = "Data Surveyor Survei";
        $this->data['profiles'] = $this->_get_data_profile($id1, $id2);

        $slug = $this->uri->segment(2);
        $manage_survey = $this->db->get_where('manage_survey', ['slug' => "$slug"])->row();
        $table_identity = $manage_survey->table_identity;
        $this->data['id_manage_survey'] = $manage_survey->id;

        $this->data['wilayah_survei'] = $this->db->query("SELECT *, (SELECT COUNT(id) FROM surveyor WHERE id_wilayah_survei = wilayah_survei_$table_identity.id && id_manage_survey = $manage_survey->id) AS total_surveyor_per_wilayah
        FROM wilayah_survei_$table_identity");

        $this->data['surveyor_per_wilayah'] = $this->db->query("SELECT *
        FROM surveyor
        JOIN users ON surveyor.id_user = users.id");


        $this->data['surveyor'] = $this->db->query("SELECT *, surveyor.uuid AS uuid_surveyor, (SELECT nama_wilayah FROM wilayah_survei_$table_identity WHERE wilayah_survei_$table_identity.id = id_wilayah_survei) AS nama_wilayah_survei
        FROM surveyor
        JOIN users ON surveyor.id_user = users.id
        WHERE id_manage_survey = $manage_survey->id");


        $this->data['slug'] = $this->uri->segment(2);
        return view('data_surveyor_survei/index', $this->data);
    }

    public function ajax_list()
    {
        $slug = $this->uri->segment(2);

        $get_identity = $this->db->get_where('manage_survey', ['slug' => "$slug"])->row();
        $id_manage_survey = $get_identity->id;

        $list = $this->models->get_datatables($id_manage_survey);
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $value) {

            if ($value->is_active == 1) {
                $is_active = '<span class="badge badge-primary">Aktif</span>';
            } else {
                $is_active = '<span class="badge badge-danger">Tidak Aktif</span>';
            }

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<a class="btn btn-light-info btn-sm font-weight-bold shadow" data-toggle="modal" data-target="#detail' . $value->id_user . ' "><i class="fa fa-info-circle"></i>Detail</a>';
            $row[] = $value->first_name . ' ' . $value->last_name;
            $row[] = $value->kode_surveyor;

            $row[] =  $is_active;

            $row[] = anchor($this->session->userdata('username') . '/' . $this->uri->segment(2) . '/data-surveyor-survei/edit/' . $value->id_user, '<i class="fa fa-edit"></i> Edit', ['class' => 'btn btn-light-primary btn-sm font-weight-bold shadow']);
            $row[] = '<a class="btn btn-light-primary btn-sm font-weight-bold shadow" href="javascript:void(0)" title="Hapus ' . $value->first_name . ' ' . $value->last_name . '" onclick="delete_data(' . "'" . $value->id_user . "'" . ')"><i class="fa fa-trash"></i> Delete</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->models->count_all($id_manage_survey),
            "recordsFiltered" => $this->models->count_filtered($id_manage_survey),
            "data" => $data,
        );

        echo json_encode($output);
    }


    public function add($id1, $id2)
    {
        $this->data = [];
        $this->data['title'] = "Tambah Data Surveyor";
        $this->data['profiles'] = $this->_get_data_profile($id1, $id2);

        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;

        // get manage_survey
        $this->db->select('*');
        $this->db->from('manage_survey');
        $this->db->where('manage_survey.slug', $this->uri->segment(2));
        $manage_survey = $this->db->get()->row();
        $table_identity = $manage_survey->table_identity;


        // validate form input
        $this->form_validation->set_rules('first_name', 'Nama Depan', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Nama Belakang', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim');
        $this->form_validation->set_rules('company', 'Company', 'trim');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', 'Password', 'required');


        if ($identity_column !== 'email') {
            $this->form_validation->set_rules('identity', 'Username', 'trim|required|is_unique[' . $tables['users'] . '.' . $identity_column . ']');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        } else {
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[' . $tables['users'] . '.email]');
        }


        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        $this->data['first_name'] = [
            'name' => 'first_name',
            'id' => 'first_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('first_name'),
            'class' => 'form-control',
            'autofocus' => 'autofocus'
        ];
        $this->data['last_name'] = [
            'name' => 'last_name',
            'id' => 'last_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('last_name'),
            'class' => 'form-control',
        ];
        $this->data['identity'] = [
            'name' => 'identity',
            'id' => 'identity',
            'type' => 'text',
            'value' => $this->form_validation->set_value('identity'),
            'class' => 'form-control',
        ];
        $this->data['email'] = [
            'name' => 'email',
            'id' => 'email',
            'type' => 'text',
            'value' => $this->form_validation->set_value('email'),
            'class' => 'form-control',
        ];
        $this->data['company'] = [
            'name' => 'company',
            'id' => 'company',
            'type' => 'text',
            'value' => $this->form_validation->set_value('company'),
            'class' => 'form-control',
        ];
        $this->data['phone'] = [
            'name' => 'phone',
            'id' => 'phone',
            'type' => 'number',
            'value' => $this->form_validation->set_value('phone'),
            'class' => 'form-control',
        ];
        $this->data['password'] = [
            'name' => 'password',
            'id' => 'password',
            'type' => 'password',
            'value' => $this->form_validation->set_value('password'),
            'class' => 'form-control',
        ];
        $this->data['password_confirm'] = [
            'name' => 'password_confirm',
            'id' => 'password_confirm',
            'type' => 'password',
            'value' => $this->form_validation->set_value('password_confirm'),
            'class' => 'form-control',

        ];
        $this->data['kode_surveyor'] = [
            'name' => 'kode_surveyor',
            'id' => 'kode_surveyor',
            'type' => 'text',
            'value' => $this->form_validation->set_value('kode_surveyor'),
            'class' => 'form-control font-weight-bold'
        ];
        $this->data['wilayah_survei'] = [
            'name'      => 'wilayah_survei',
            'id'        => 'wilayah_survei',
            'options'   => $this->models->dropdown_wilayah_survei($table_identity),
            'selected'  => $this->form_validation->set_value('wilayah_survei'),
            'class'     => "form-control",
            'required' => 'required',
        ];

        if ($this->form_validation->run() == FALSE) {

            return view("data_surveyor_survei/form_add", $this->data);
        } else {
            $email = strtolower($this->input->post('email'));
            $identity = ($identity_column === 'email') ? $email : $this->input->post('identity');
            $password = $this->input->post('password');

            $additional_data = [
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'company' => $this->input->post('company'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'is_surveyor' => 1,
                'is_trial' => ''
            ];

            $group = array('3');
        }
        if ($this->form_validation->run() === TRUE && $this->ion_auth->register($identity, $password, $email, $additional_data, $group)) {

            // get id user
            $this->db->select('users.id');
            $this->db->from('users');
            $this->db->where('username', $this->input->post('identity'));
            $id_user = $this->db->get()->row()->id;

            $this->load->library('uuid');
            $object = [
                'uuid' => $this->uuid->v4(),
                'id_user' => $id_user,
                'id_manage_survey' => $manage_survey->id,
                'kode_surveyor' => $this->input->post('kode_surveyor'),
                'id_wilayah_survei' => $this->input->post('wilayah_survei'),
                'is_active' => 1
            ];
            $this->db->insert("surveyor", $object);

            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('message_success', 'Berhasil menambah data surveyor');
                redirect(base_url() . $this->session->userdata('username') . '/' . $this->uri->segment(2) . '/data-surveyor-survei', 'refresh');
            } else {
                $this->data['message_data_danger'] = "Gagal menambah data surveyor";
                return view("data_surveyor_survei/form_add", $this->data);
            }
        }
    }


    public function edit($id1, $id2)
    {
        $this->data = [];
        $this->data['title'] = "Edit Data Surveyor";
        $this->data['profiles'] = $this->_get_data_profile($id1, $id2);
        $this->data['form_action'] = base_url() . $this->session->userdata('username') . '/' . $this->uri->segment(2) . '/data-surveyor-survei/edit/' . $this->uri->segment(5);

        $slug = $this->uri->segment(2);
        $manage_survey = $this->db->get_where('manage_survey', ['slug' => "$slug"])->row();
        $table_identity = $manage_survey->table_identity;


        $current = $this->db->query("SELECT *
        FROM surveyor
        JOIN users ON surveyor.id_user = users.id
        WHERE id_user = " . $this->uri->segment(5))->row();
        $this->data['is_active'] = $current->is_active;


        $this->form_validation->set_rules('first_name', 'Nama Depan', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Nama Belakang', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim');
        $this->form_validation->set_rules('company', 'Company', 'trim');


        if (isset($_POST) && !empty($_POST)) {

            // update the password if it was posted
            if ($this->input->post('password')) {
                $this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[password_confirm]');
                $this->form_validation->set_rules('password_confirm', 'Password', 'required');
            }


            if ($this->form_validation->run() === TRUE) {
                $data = [
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'email' => $this->input->post('email'),
                    'company' => $this->input->post('company'),
                    'phone' => $this->input->post('phone'),
                ];

                $surveyor = [
                    'kode_surveyor' => $this->input->post('kode_surveyor'),
                    'id_wilayah_survei' => $this->input->post('wilayah_survei'),
                    'is_active' => $this->input->post('is_active')
                ];

                if ($this->input->post('password')) {
                    $data['password'] = $this->input->post('password');
                }

                $this->db->where('id', $this->uri->segment(5));
                $this->db->update('users', $data);

                $this->db->where('id_user', $this->uri->segment(5));
                $this->db->update("surveyor", $surveyor);

                $this->session->set_flashdata('message_success', 'Berhasil mengubah data surveyor.');
                redirect(base_url() . $this->session->userdata('username') . '/' . $this->uri->segment(2) . '/data-surveyor-survei', 'refresh');
            }
        }

        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        $this->data['first_name'] = [
            'name'  => 'first_name',
            'id'    => 'first_name',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('first_name', $current->first_name),
            'class' => 'form-control',
        ];
        $this->data['last_name'] = [
            'name'  => 'last_name',
            'id'    => 'last_name',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('last_name', $current->last_name),
            'class' => 'form-control',
        ];
        $this->data['company'] = [
            'name'  => 'company',
            'id'    => 'company',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('company', $current->company),
            'class' => 'form-control',
        ];
        $this->data['email'] = [
            'name'  => 'email',
            'id'    => 'email',
            'type'  => 'email',
            'value' => $this->form_validation->set_value('email', $current->email),
            'class' => 'form-control',
        ];
        $this->data['phone'] = [
            'name'  => 'phone',
            'id'    => 'phone',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('phone', $current->phone),
            'class' => 'form-control',
        ];
        $this->data['password'] = [
            'name' => 'password',
            'id'   => 'password',
            'type' => 'password',
            'class' => 'form-control',
        ];
        $this->data['password_confirm'] = [
            'name' => 'password_confirm',
            'id'   => 'password_confirm',
            'type' => 'password',
            'class' => 'form-control',
        ];

        $this->data['kode_surveyor'] = [
            'name' => 'kode_surveyor',
            'id'   => 'kode_surveyor',
            'type' => 'text',
            'value' => $this->form_validation->set_value('kode_surveyor', $current->kode_surveyor),
            'class' => 'form-control'
        ];

        $this->data['wilayah_survei'] = [
            'name'      => 'wilayah_survei',
            'id'        => 'wilayah_survei',
            'options'   => $this->models->dropdown_wilayah_survei($table_identity),
            'selected'  => $this->form_validation->set_value('wilayah_survei', $current->id_wilayah_survei),
            'class'     => "form-control",
            'required' => 'required',
        ];

        return view('data_surveyor_survei/form_edit', $this->data);
    }


    public function delete($id = NULL)
    {
        $slug = $this->uri->segment(2);
        $manage_survey = $this->db->get_where('manage_survey', ['slug' => "$slug"])->row();
        $table_identity = $manage_survey->table_identity;

        $this->db->delete('users', array('id' => $this->uri->segment(5)));
        $this->db->delete("surveyor", array('id_user' => $this->uri->segment(5)));
        $this->db->delete('users_groups', array('user_id' => $this->uri->segment(5)));

        echo json_encode(array("status" => TRUE));
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
