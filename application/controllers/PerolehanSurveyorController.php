<?php
defined('BASEPATH') or exit('No direct script access allowed');

require 'application/core/Klien_Controller.php';
use application\core\Klien_Controller;

class PerolehanSurveyorController extends CI_Controller
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

    $profiles = new Klien_Controller();
    $this->data['profiles'] = $profiles->_get_data_profile($id1, $id2);
    $table_identity = $this->data['profiles']->table_identity;


    $this->data['total_perolehan'] = $this->db->query("SELECT COUNT(survey_$table_identity.id) AS total FROM survey_$table_identity WHERE is_submit = 1 && id_surveyor != 0")->row()->total;

    return view('perolehan_surveyor/index', $this->data);
  }

  public function ajax_list()
  {
    $slug = $this->uri->segment(2);
    $manage_survey = $this->db->get_where('manage_survey', ['slug' => "$slug"])->row();

    $list = $this->models->get_datatables($manage_survey->id);
    $data = array();
    $no = $_POST['start'];

    foreach ($list as $value) {

      $no++;
      $row = array();
      $row[] = $no;
      $row[] =  '<b>' . $value->kode_surveyor . '</b> -- ' . $value->first_name . ' ' . $value->last_name;
      $row[] = '<span class="badge badge-info">' . $value->total_survey . '</span>';
      $row[] = anchor($this->session->userdata('username') . '/' . $this->uri->segment(2) . '/perolehan-surveyor/' . $value->uuid_surveyor, 'Detail Perolehan <i class="fa fa-arrow-right"></i>', ['class' => 'btn btn-light-primary btn-sm font-weight-bold shadow']);


      $data[] = $row;
    }

    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->models->count_all($manage_survey->id),
      "recordsFiltered" => $this->models->count_filtered($manage_survey->id),
      "data" => $data,
    );
    echo json_encode($output);
  }


  public function detail($id1, $id2, $id3)
  {
    $this->data = [];
    $this->data['title'] = 'Perolehan Surveyor';

    $this->data['profiles'] = $this->_get_data_profile($id1, $id2);

    $this->db->select('*');
    $this->db->from('manage_survey');
    $this->db->where('manage_survey.slug', $this->uri->segment(2));
    $manage_survey = $this->db->get()->row();
    $table_identity = $manage_survey->table_identity;

    $this->db->select("*, surveyor.uuid AS uuid_surveyor, surveyor.id AS id_surveyor");
    $this->db->from("surveyor");
    $this->db->join('users', "surveyor.id_user = users.id");
    $this->db->where("surveyor.uuid", $id3);
    $this->data['data_surveyor'] = $this->db->get()->row();
    $id_wilayah_survei =  $this->data['data_surveyor']->id_wilayah_survei;

    $this->data['profil'] = $this->db->query("SELECT * FROM profil_responden_$table_identity ORDER BY IF(urutan != '',urutan,id) ASC")->result();

    $this->data['sektor'] = $this->db->query("SELECT *, ROUND((SELECT target_offline FROM target_$table_identity WHERE id_sektor = sektor_$table_identity.id && id_wilayah_survei = $id_wilayah_survei) / (SELECT COUNT(id) FROM surveyor WHERE id_manage_survey = $manage_survey->id && id_wilayah_survei = $id_wilayah_survei)) AS target,

    (SELECT COUNT(id_responden) FROM responden_$table_identity
    JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden
    WHERE is_submit = 1 && responden_$table_identity.sektor = sektor_$table_identity.id && wilayah_survei = $id_wilayah_survei && survey_$table_identity.id_surveyor != 0) AS perolehan
    FROM sektor_$table_identity");


    return view('perolehan_surveyor/form_detail', $this->data);
  }


  public function ajax_list_detail()
  {
    $this->load->model('DataPerolehanSurveyor_model');
    $slug = $this->uri->segment(2);

    $surveyor = $this->db->get_where("surveyor", array('uuid' => $this->uri->segment(5)))->row();
    $manage_survey = $this->db->get_where('manage_survey', ['slug' => "$slug"])->row();
    $table_identity = $manage_survey->table_identity;

    //PANGGIL PROFIL RESPONDEN
    $profil_responden = $this->db->query("SELECT * FROM profil_responden_$table_identity ORDER BY IF(urutan != '',urutan,id) ASC")->result();

    $list = $this->DataPerolehanSurveyor_model->get_datatables($profil_responden, $table_identity, $surveyor->id_user);
    $data = array();
    $no = $_POST['start'];

    foreach ($list as $value) {

      if ($value->is_submit == 1) {
        $status = '<span class="badge badge-primary">Valid</span>';
      } else {
        $status = '<span class="badge badge-danger">Tidak Valid</span>';
      }

      $no++;
      $row = array();
      $row[] = $no;
      $row[] = $status;
      $row[] = anchor($manage_survey->slug . '/hasil-survei/' . $value->uuid_responden, '<i class="fas fa-file-pdf text-danger"></i>', ['target' => '_blank']);

      foreach ($profil_responden as $get) {
        $profil = $get->nama_alias;
        $row[] =  str_word_count($value->$profil) > 5 ? substr($value->$profil, 0, 50) . ' [...]' : $value->$profil;
      }

      $row[] = date("d-m-Y", strtotime($value->waktu_isi));

      $row[] = '<a class="btn btn-light-primary btn-sm font-weight-bold shadow" href="javascript:void(0)" title="Hapus ' . $value->nama_lengkap . '" onclick="delete_data(' . "'" . $value->id_responden . "'" . ')"><i class="fa fa-trash"></i> Delete</a>';

      $data[] = $row;
    }

    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->DataPerolehanSurveyor_model->count_all($profil_responden, $table_identity, $surveyor->id_user),
      "recordsFiltered" => $this->DataPerolehanSurveyor_model->count_filtered($profil_responden, $table_identity, $surveyor->id_user),
      "data" => $data,
    );

    echo json_encode($output);
  }


  public function delete($id = NULL)
  {
    $slug = $this->uri->segment(2);
    $get_identity = $this->db->get_where('manage_survey', ['slug' => "$slug"])->row();

    $this->db->select("*, survey_$get_identity->table_identity.id AS id_survey");
    $this->db->from("responden_$get_identity->table_identity");
    $this->db->join("survey_$get_identity->table_identity", "responden_$get_identity->table_identity.id = survey_$get_identity->table_identity.id_responden");
    $this->db->where("responden_$get_identity->table_identity.uuid =", $this->uri->segment(5));
    $get_data = $this->db->get();

    if ($get_data->num_rows() == 0) {

      echo json_encode(array("status" => FALSE));
    }
    $current = $get_data->row();

    $this->db->delete('jawaban_pertanyaan_unsur_' . $get_identity->table_identity, array('id' => $current->id_survey));
    $this->db->delete('survey_' . $get_identity->table_identity, array('id' => $current->id_survey));
    $this->db->delete('responden_' . $get_identity->table_identity, array('id' => $current->id_responden));

    echo json_encode(array("status" => TRUE));
  }

  public function get_email()
  {
    $id_surveyor  = $this->input->post('id_surveyor');

    $surveyor = $this->db->query("SELECT *
		FROM users
		JOIN surveyor ON users.id = surveyor.id_user
		JOIN manage_survey ON surveyor.id_manage_survey = manage_survey.id
		WHERE users.id = $id_surveyor")->row();

    $settings = $this->db->query("
							SELECT
							( SELECT setting_value FROM web_settings WHERE alias = 'akun_email') AS email_akun,
							( SELECT setting_value FROM web_settings WHERE alias = 'email_pengirim') AS email_pengirim,
							( SELECT setting_value FROM web_settings WHERE alias = 'email_username') AS email_username,
							( SELECT setting_value FROM web_settings WHERE alias = 'email_password') AS email_password,
							( SELECT setting_value FROM web_settings WHERE alias = 'email_host') AS email_host,
							( SELECT setting_value FROM web_settings WHERE alias = 'email_port') AS email_port,
							( SELECT setting_value FROM web_settings WHERE alias = 'email_cc') AS email_cc,
							( SELECT setting_value FROM web_settings WHERE alias = 'email_bcc') AS email_bcc
							FROM
							web_settings LIMIT 1
						")->row();

    $this->load->library('email');

    $ci = get_instance();
    $config['protocol']     = "smtp";
    $config['smtp_host']    = $settings->email_host;
    $config['smtp_port']    = $settings->email_port;
    $config['smtp_user']    = $settings->email_username;
    $config['smtp_pass']    = $settings->email_password;
    $config['charset']      = "utf-8";
    $config['mailtype']     = "html";
    $config['newline']      = "\r\n";

    $html = '';
    $html .= '

		<table width="100%" border="0" cellpadding="4" cellspacing="0">
  <tr>
    <td bgcolor="#1e1e2d" style="font-size: 20px; color: #FFFFFF;">
      <div align="center"><strong>SISTEM INFORMASI E-IKK</strong></div>
    </td>
  </tr>
  <tr>
    <td style="font-size: 16px;">
      <br><br>
      <p>Kepada Bapak / Ibu ' . $surveyor->first_name . ' ' . $surveyor->last_name . '<br />
        Di Tempat</p>
      <p>Anda telah didaftarkan sebagai surveyor ' . $surveyor->survey_name . ':</p>
      <table border="1" style="border-collapse: collapse; border-color: #d3d3d3;" cellpadding="4" cellspacing="0">
        <tr>
          <th>Link Login</th>
          <td>' . base_url() . 'auth/login</td>
        </tr>
        <tr>
          <th>Username</th>
          <td>' . $surveyor->username . '</td>
        </tr>
        <tr>
          <th>Password</th>
          <td>' . $surveyor->re_password . '</td>
        </tr>
      </table>
      <br>
      <table border="1" style="border-collapse: collapse; border-color: #d3d3d3;" cellpadding="4" cellspacing="0">
      </table>
      <p>Agar akun anda lebih aman, segera ubah password anda melalui link berikut ini <a href="' . base_url() . 'auth/forgot_password">' . base_url() . 'auth/forgot_password</a></p>
      <p>Terima Kasih.</p>
      <p><strong><u>Admin E-IKK</u></strong></p>
      <br><br>

    </td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC" style="font-size: 12px;">
      <div align="center">View as a Web Page<br />
        Sistem Informasi E-IKK<br/>' .
      base_url() . '
      </div>
    </td>
  </tr>
</table>
					';

    $ci->email->initialize($config);
    $ci->email->from($settings->email_pengirim, 'Auto Reply Sistem Informasi E-IKK');
    $ci->email->to($surveyor->email);

    $ci->email->subject('Akun Surveyor ' . $surveyor->survey_name);
    $ci->email->message($html);
    $this->email->send();

    $pesan = 'Email berhasil dikirim';
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
