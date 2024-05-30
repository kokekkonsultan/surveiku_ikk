<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SurveiController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Survei_model');
        $this->load->helper('cookie');
    }

    public function index()
    {
    }



    public function form_opening()
    {
        $this->data = [];
        $this->data['title'] = 'SURVEI INDEKS KEBERDAYAAN KONSUMEN';

        $slug = $this->uri->segment('2');
        $manage_survey = $this->db->get_where('manage_survey', ['slug' => $slug])->row();
        $this->data['judul'] = $manage_survey;
        $this->data['manage_survey'] = $manage_survey;
        $this->data['status_saran'] = $manage_survey->is_saran;

        if ($this->uri->segment(3) == NULL) {
            $this->data['url_next'] = base_url() . 'survei/' . $this->uri->segment(2) . '/session-location';
        } else {
            $this->data['url_next'] = base_url() . 'survei/' . $this->uri->segment(2) . '/session-location/' . $this->uri->segment(3);
        }


        // STATUS SURVEY DI TUNDA< BLUM DIMULAI< ATAU SURVEY SUDAH SELESAI
        if ($manage_survey->is_privacy == 2) {
            return view('survei/form_setting_survey/survey_hold', $this->data);
        } elseif (date("Y-m-d") < $manage_survey->survey_start) {
            return view('survei/form_setting_survey/unopened', $this->data);
        } elseif (date("Y-m-d") >= $manage_survey->survey_end) {
            return view('survei/form_setting_survey/survey_end', $this->data);
        } elseif ($manage_survey->is_question == 1) {
            return view('survei/form_setting_survey/survey_not_question', $this->data);
        } else {


            #Proses jika survei dari broadcast
            if ($this->uri->segment(3) == NULL) {
                $check_visitor = $this->input->cookie($slug, FALSE);
                $ip = $this->input->ip_address();
                if ($check_visitor == false) {
                    $cookie = [
                        "name" => "$slug",
                        "value" => "$ip",
                        "expire" => 120, // 2 Menit
                        "secure" => false
                    ];
                    $this->input->set_cookie($cookie);

                    // tambahkan 1
                    $this->db->where('slug', urldecode($slug));
                    $this->db->set('view_visitor', ($manage_survey->view_visitor + 1));
                    $this->db->update('manage_survey');
                }
            }

            return view('survei/form_opening', $this->data);
        }
    }


    public function session_location()
    {
        unset($_SESSION['lat']);
        unset($_SESSION['lng']);

        $this->session->set_userdata('lat', $this->input->get('lat'));
        $this->session->set_userdata('lng', $this->input->get('lng'));

        if ($this->uri->segment(4) == NULL) {
            redirect(base_url() . 'survei/' . $this->uri->segment(2) . '/data-responden');
        } else {
            redirect(base_url() . 'survei/' . $this->uri->segment(2) . '/data-responden/' . $this->uri->segment(4));
        }
    }


    public function data_responden($id1)
    {
        $this->data = [];
        $this->data['title'] = 'Data Responden';
        $this->data['profiles'] = $this->_get_data_profile($id1);
        $this->data['provinsi'] = $this->db->query('SELECT * FROM provinsi_indonesia');


        $slug = $this->uri->segment(2);
        $manage_survey = $this->db->get_where('manage_survey', ['slug' => $slug])->row();
        $table_identity = $manage_survey->table_identity;
        $this->data['status_saran'] = $manage_survey->is_saran;
        $this->data['manage_survey'] = $manage_survey;



        if ($this->uri->segment(4) == NULL) {
            $this->data['form_action'] = base_url() . 'survei/' . $this->uri->segment(2) . '/add-data-responden/';
            $this->data['surveyor_id'] = 0;
        } else {
            $this->data['form_action'] = base_url() . 'survei/' . $this->uri->segment(2) . '/add-data-responden/' . $this->uri->segment(4);

            $uuid_surveyor = $this->uri->segment(4);
            $this->data['surveyor'] = $this->db->query("SELECT *, surveyor.id AS id_surveyor
            FROM surveyor
            JOIN wilayah_survei_$table_identity ON surveyor.id_wilayah_survei = wilayah_survei_$table_identity.id
            WHERE surveyor.uuid = '$uuid_surveyor'")->row();

            $this->data['surveyor_id'] = $this->data['surveyor']->id_surveyor;
            // $this->data['kota_kab_indonesia'] = $this->db->get_where('kota_kab_indonesia', array('id_provinsi_indonesia' => $this->data['surveyor']->id_provinsi_indonesia));
        }

        #LOAD PROFIL RESPONDEN
        $this->data['profil_responden'] = $this->db->query("SELECT * FROM profil_responden_$table_identity ORDER BY IF(urutan != '',urutan,id) ASC");


        #LOAD KATEGORI PROFIL RESPONDEN JIKA PILIHAN GANDA
        $this->data['kategori_profil_responden'] = $this->db->query("SELECT * FROM kategori_profil_responden_$table_identity
        UNION ALL
        SELECT id, 1, nama_sektor FROM sektor_$table_identity
        UNION ALL
        SELECT id, 2, nama_wilayah FROM wilayah_survei_$table_identity");


        //STATUS SURVEY DI TUNDA< BLUM DIMULAI< ATAU SURVEY SUDAH SELESAI
        if ($manage_survey->is_privacy == 2) {
            return view('survei/form_setting_survey/survey_hold', $this->data);
        } elseif (date("Y-m-d") < $manage_survey->survey_start) {
            return view('survei/form_setting_survey/unopened', $this->data);
        } elseif (date("Y-m-d") >= $manage_survey->survey_end) {
            return view('survei/form_setting_survey/survey_end', $this->data);
        } elseif ($manage_survey->is_question == 1) {
            return view('survei/form_setting_survey/survey_not_question', $this->data);
        } else {
            // $this->create_session($slug);
            return view('survei/form_data_responden', $this->data);
        }
    }



    public function add_data_responden($id1)
    {
        $slug = $this->uri->segment(2);
        $manage_survey = $this->db->get_where('manage_survey', ['slug' => $slug])->row();
        $table_identity = $manage_survey->table_identity;

        // LOAD PROFIL RESPONDEN
        $this->data['profil_responden'] = $this->db->query("SELECT * FROM profil_responden_$table_identity");

        $this->load->library('uuid');
        $input   = $this->input->post(NULL, TRUE);

        $id_sektor = $this->input->post('sektor');
        $id_wilayah_survei = $this->input->post('wilayah_survei');
        $id_surveyor = $this->input->post('id_surveyor');


        #DELETE COOKIE===============================
        delete_cookie($slug);
        #END DELETE COOKIE===========================


        if ($manage_survey->is_active_target == 1) {

            //CEK TARGET
            $target_survei = $this->db->query("SELECT *
            FROM target_$table_identity
            WHERE id_sektor = $id_sektor && id_wilayah_survei = $id_wilayah_survei")->row();
            $target_online = $target_survei->target_online;
            $target_offline = $target_survei->target_offline;

            //CEK PEROLEHAN
            $total_perolehan = $this->db->query("SELECT COUNT(id_responden) AS total
            FROM responden_$table_identity
            JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden
            WHERE is_submit = 1 && sektor = $id_sektor && wilayah_survei = $id_wilayah_survei && id_surveyor = $id_surveyor")->row()->total;

            $target = $id_surveyor == 0 ? ($target_online - $total_perolehan) : $target_offline - $total_perolehan;

            //CEK KUOTA TARGET TERPENIHI ATAU BELUM
            if ($target <= 0) {

                $pesan_full = 'Kuota responden untuk Sektor yang anda pilih sudah terpenuhi.';
                $msg_full = ['full' => $pesan_full];
                echo json_encode($msg_full);
            } else {

                // INSERT DATA RSEPONDEN
                $object['uuid'] = $this->uuid->v4();
                foreach ($this->data['profil_responden']->result() as $row) {
                    $object[$row->nama_alias] = $this->input->post($row->nama_alias);
                }
                $this->db->insert("responden_$table_identity", $object);


                //INSERT SURVEY
                $id_responden = $this->db->insert_id();
                $value = [
                    'uuid' => $this->uuid->v4(),
                    'id_responden'     => $id_responden,
                    'id_surveyor'     => $id_surveyor,
                    'is_submit'     => '2',
                    'waktu_isi' => date("Y/m/d H:i:s"),
                    'is_end' => '* Berakhir di Data Responden',

                    'lat' => $_POST['lat'],
                    'lng' => $_POST['lng'],
                    'loc' => $_POST['loc']
                ];
                $this->db->insert("survey_$table_identity", $value);
                $id_survey = $this->db->insert_id();


                $result1 = [];
                foreach ($this->db->get("pertanyaan_unsur_$table_identity")->result() as $value) {
                    $result1[] = array(
                        'id_survey'                 => $id_survey,
                        'id_pertanyaan_unsur'         => $value->id
                    );
                }
                $this->db->insert_batch('jawaban_pertanyaan_unsur_' . $table_identity, $result1);


                $result2 = [];
                foreach ($this->db->get("pertanyaan_terbuka_$table_identity")->result() as $value) {
                    $result2[] = array(
                        'id_survey'                 => $id_survey,
                        'id_pertanyaan_terbuka'         => $value->id
                    );
                }
                $this->db->insert_batch('jawaban_pertanyaan_terbuka_' . $table_identity, $result2);


                $get_uuid_responden = $this->db->query("SELECT uuid FROM responden_$table_identity WHERE id = $id_responden")->row()->uuid;

                $pesan = 'Data berhasil disimpan';
                $msg = ['sukses' => $pesan, 'uuid' => $get_uuid_responden];
                echo json_encode($msg);
            }
        } else {

            // INSERT DATA RSEPONDEN
            $object['uuid'] = $this->uuid->v4();
            foreach ($this->data['profil_responden']->result() as $row) {
                $object[$row->nama_alias] = $this->input->post($row->nama_alias);
            }
            $this->db->insert("responden_$table_identity", $object);


            //INSERT SURVEY
            $id_responden = $this->db->insert_id();
            $value = [
                'uuid' => $this->uuid->v4(),
                'id_responden'     => $id_responden,
                'id_surveyor'     => $id_surveyor,
                'is_submit'     => '2',
                'waktu_isi' => date("Y/m/d H:i:s"),
                'is_end' => '* Berakhir di Data Responden'
            ];
            $this->db->insert("survey_$table_identity", $value);
            $id_survey = $this->db->insert_id();


            $result1 = [];
            foreach ($this->db->get("pertanyaan_unsur_$table_identity")->result() as $value) {
                $result1[] = array(
                    'id_survey'                 => $id_survey,
                    'id_pertanyaan_unsur'         => $value->id
                );
            }
            $this->db->insert_batch('jawaban_pertanyaan_unsur_' . $table_identity, $result1);


            $result2 = [];
            foreach ($this->db->get("pertanyaan_terbuka_$table_identity")->result() as $value) {
                $result2[] = array(
                    'id_survey'                 => $id_survey,
                    'id_pertanyaan_terbuka'         => $value->id
                );
            }
            $this->db->insert_batch('jawaban_pertanyaan_terbuka_' . $table_identity, $result2);


            $get_uuid_responden = $this->db->query("SELECT uuid FROM responden_$table_identity WHERE id = $id_responden")->row()->uuid;

            $pesan = 'Data berhasil disimpan';
            $msg = ['sukses' => $pesan, 'uuid' => $get_uuid_responden];
            echo json_encode($msg);
        }
    }


    public function data_pertanyaan($id1, $id2)
    {
        $this->data = [];
        $this->data['title'] = 'Pertanyaan Unsur';
        $uuid_responden = $this->uri->segment(4);
        $slug = $this->uri->segment(2);


        $manage_survey = $this->db->get_where('manage_survey', ['slug' => $slug])->row();
        $table_identity = $manage_survey->table_identity;
        $this->data['manage_survey'] = $manage_survey;
        $this->data['status_saran'] = $manage_survey->is_saran;

        // $this->data['atribut_form_alasan'] = "$(this).val() == " . implode(" || $(this).val() == ", unserialize($manage_survey->atribut_form_alasan));

        if ($manage_survey->is_input_alasan == 2) {
            $this->data['atribut_form_alasan'] = "$(this).val() == 1 || $(this).val() == 2 || $(this).val() == 3";
        } else {
            $this->data['atribut_form_alasan'] = "$(this).val() == 1 || $(this).val() == 2";
        }


        $survey =  $this->db->query("SELECT *, survey_$table_identity.id AS id_survey
        FROM survey_$table_identity
        JOIN responden_$table_identity ON survey_$table_identity.id_responden = responden_$table_identity.id
        WHERE responden_$table_identity.uuid = '$uuid_responden'")->row();
        // var_dump($this->data['survey']);


        $this->data['pertanyaan_unsur'] = $this->db->query("SELECT *, pertanyaan_unsur_$table_identity.id AS id_pertanyaan_unsur, isi_pertanyaan, (SELECT nama_jawaban FROM nilai_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && nilai_jawaban = 1) AS jawaban_1,
        (SELECT nama_jawaban FROM nilai_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && nilai_jawaban = 2) AS jawaban_2,
        (SELECT nama_jawaban FROM nilai_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && nilai_jawaban = 3) AS jawaban_3,
        (SELECT nama_jawaban FROM nilai_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && nilai_jawaban = 4) AS jawaban_4,
        (SELECT nama_jawaban FROM nilai_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && nilai_jawaban = 5) AS jawaban_5, skor_jawaban, alasan_pilih_jawaban, (SELECT kode_unsur FROM unsur_$table_identity WHERE unsur_$table_identity.id = pertanyaan_unsur_$table_identity.id_unsur) AS kode_unsur
        FROM pertanyaan_unsur_$table_identity
        JOIN jawaban_pertanyaan_unsur_$table_identity ON pertanyaan_unsur_$table_identity.id = jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur
        WHERE id_survey = $survey->id_survey");


        $this->data['pertanyaan_terbuka'] = $this->db->query("SELECT *,
        (SELECT jawaban FROM jawaban_pertanyaan_terbuka_$table_identity WHERE id_pertanyaan_terbuka = pertanyaan_terbuka_$table_identity.id && id_survey = $survey->id_survey) AS jawaban
        FROM pertanyaan_terbuka_$table_identity");



        //CEK APAKAH SURVEY SUDAH DI SUBMIT APA BELUM
        $this->db->select("is_submit");
        $this->db->from('survey_' . $table_identity);
        $this->db->join("responden_$table_identity", "survey_$table_identity.id_responden = responden_$table_identity.id");
        $this->db->where("responden_$table_identity.uuid = '$uuid_responden'");
        $is_selesai_survey = $this->db->get()->row();


        if ($manage_survey->is_saran == 1) {
            if ($this->uri->segment(5) == 'edit') {
                $this->data['url_next'] = base_url() . 'survei/' . $this->uri->segment(2) . '/saran/' . $uuid_responden . '/edit';
            } else {
                $this->data['url_next'] = base_url() . 'survei/' . $this->uri->segment(2) . '/saran/' . $uuid_responden;
            }
        } else {
            if ($this->uri->segment(5) == 'edit') {
                $this->data['url_next'] = base_url() . 'survei/' . $this->uri->segment(2) . '/selesai/' . $uuid_responden;
            } else {
                $this->data['url_next'] = base_url() . 'survei/' . $this->uri->segment(2) . '/konfirmasi/' . $uuid_responden;
            }
        }


        if ($this->uri->segment(5) == 'edit') {
            return view('survei/form_pertanyaan', $this->data);
        }

        if ($is_selesai_survey->is_submit == 2) {

            // $this->create_session($slug);
            return view('survei/form_pertanyaan', $this->data);
        } else {
            redirect(base_url() . 'survei/' . $this->uri->segment(2) . '/selesai/' . $uuid_responden, 'refresh');
        }
    }


    public function add_pertanyaan($id1, $id2)
    {
        $this->data = [];
        $this->data['title'] = 'Pertanyaan Unsur';

        $manage_survey = $this->db->get_where('manage_survey', ['slug' => $this->uri->segment(2)])->row();
        $table_identity = $manage_survey->table_identity;


        $this->db->select("*, survey_$table_identity.id AS id_survey");
        $this->db->from('responden_' . $table_identity);
        $this->db->join("survey_$table_identity", "responden_$table_identity.id = survey_$table_identity.id_responden");
        $this->db->where("responden_$table_identity.uuid", $this->uri->segment(4));
        $survey = $this->db->get()->row();
        $id_survey = $survey->id_survey;
        $id_sektor = $survey->sektor;
        $id_wilayah_survei = $survey->wilayah_survei;


        $target_survei = $this->db->query("SELECT *
        FROM target_$table_identity
        WHERE id_sektor = $id_sektor && id_wilayah_survei = $id_wilayah_survei")->row();
        $target_online = $target_survei->target_online;
        $target_offline = $target_survei->target_offline;

        //CEK PEROLEHAN
        $total_perolehan = $this->db->query("SELECT COUNT(id_responden) AS total
        FROM responden_$table_identity
        JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden
        WHERE is_submit = 1 && sektor = $id_sektor && wilayah_survei = $id_wilayah_survei && id_surveyor = $survey->id_surveyor")->row()->total;


        $target = $survey->id_surveyor == 0 || $survey->id_surveyor == '' ? ($target_online - $total_perolehan) : ($target_offline - $total_perolehan);

        if ($target <= 0) {

            $pesan_full = '<div>Kuota responden untuk Sektor yang anda pilih sudah terpenuhi. <br><a style="text-decoration:none; color: blue;" href="' . base_url() . 'survei/' . $manage_survey->slug . '/data-responden' . '"><b>Kembali ke Dimensi</b></a></div>
            .';
            $msg_full = ['full' => $pesan_full];
            echo json_encode($msg_full);
        } else {

            #Insert Pertanyaan Unsur
            foreach ($this->db->get("pertanyaan_unsur_$table_identity")->result() as $val) {
                $atribute_alasan = unserialize($val->atribute_alasan);
                if (in_array($_POST['jawaban_pertanyaan_unsur'][$val->id], $atribute_alasan)) {
                    $alasan[$val->id] = $_POST['alasan'][$val->id];
                } else {
                    $alasan[$val->id] = '';
                }

                $id_pertanyaan_unsur = $_POST['id_pertanyaan_unsur'][$val->id];
                $object1 = [
                    'skor_jawaban'     => $_POST['jawaban_pertanyaan_unsur'][$val->id],
                    'alasan_pilih_jawaban' => $alasan[$val->id]
                ];

                $this->db->where('id_survey', $id_survey);
                $this->db->where('id_pertanyaan_unsur', $id_pertanyaan_unsur);
                $this->db->update('jawaban_pertanyaan_unsur_' . $table_identity, $object1);
            }


            #Insert Pertanyaan Terbuka
            foreach ($this->db->get("pertanyaan_terbuka_$table_identity")->result() as $val) {
               
                $object2 = [
                    'jawaban'     => $_POST['jawaban_pertanyaan_terbuka'][$val->id]
                ];

                $this->db->where('id_survey', $id_survey);
                $this->db->where('id_pertanyaan_terbuka', $_POST['id_pertanyaan_terbuka'][$val->id]);
                $this->db->update('jawaban_pertanyaan_terbuka_' . $table_identity, $object2);
            }

            $obj_value = [
                'is_end' => '* Berakhir di Pertanyaan Unsur'
            ];
            $this->db->where('id', $id_survey);
            $this->db->update("survey_$table_identity", $obj_value);


            $pesan = 'Data berhasil disimpan';
            $msg = ['sukses' => $pesan];
            echo json_encode($msg);
        }
    }


    public function saran($id1)
    {
        $this->data = [];
        $this->data['title'] = 'Saran';
        $this->data['profiles'] = $this->_get_data_profile($id1);

        $slug = $this->uri->segment(2);
        $uuid_responden = $this->uri->segment(4);


        $this->data['manage_survey'] = $this->db->get_where('manage_survey', ['slug' => $slug])->row();
        $table_identity = $this->data['manage_survey']->table_identity;

        $this->db->select("*, responden_$table_identity.id AS id_res");
        $this->db->from('responden_' . $table_identity);
        $this->db->join("survey_$table_identity", "responden_$table_identity.id = survey_$table_identity.id_responden");
        $this->db->where("responden_$table_identity.uuid = '$uuid_responden'");
        $data = $this->db->get()->row();

        $this->data['saran'] = [
            'name'         => 'saran',
            'id'        => 'saran',
            'type'        => 'text',
            'value'        =>    $this->form_validation->set_value('saran', $data->saran),
            'class'        => 'form-control',
            'autofocus' => 'autofocus',
            'placeholder' => 'Masukkan saran atau opini anda terhadap survei ini ..',
        ];

        //CEK APAKAH SURVEY SUDAH DI SUBMIT APA BELUM
        $this->db->select("*");
        $this->db->from('survey_' . $table_identity);
        $this->db->join("responden_$table_identity", "survey_$table_identity.id_responden = responden_$table_identity.id");
        $this->db->where("responden_$table_identity.uuid = '$uuid_responden'");
        $is_selesai_survey = $this->db->get()->row();

        if ($this->uri->segment(5) == 'edit') {
            return view('survei/form_saran', $this->data);
        }

        if ($is_selesai_survey->is_submit == 2) {
            // $this->create_session($slug);
            return view('survei/form_saran', $this->data);
        } else {
            redirect(base_url() . 'survei/' . $this->uri->segment(2) . '/selesai/' . $uuid_responden, 'refresh');
        }
    }

    public function add_saran()
    {
        $uuid_responden = $this->uri->segment(4);
        $manage_survey = $this->db->get_where('manage_survey', ['slug' => $this->uri->segment(2)])->row();
        $table_identity = $manage_survey->table_identity;

        $id_res = $this->db->get_where("responden_$table_identity", array('uuid' => "$uuid_responden"))->row()->id;

        $input     = $this->input->post(NULL, TRUE);
        $object = [
            'saran'     => $input['saran'],
            'is_active'     => '1',
            'is_end' => '* Berakhir di Pengisian Saran'
        ];
        $this->db->where('id_responden', $id_res);
        $this->db->update('survey_' . $table_identity, $object);

        $url_next = base_url() . 'survei/' . $this->uri->segment(2) . '/add-konfirmasi/' . $uuid_responden;

        $pesan = 'Data berhasil disimpan';
        $msg = ['sukses' => $pesan, 'url_next' => $url_next];
        echo json_encode($msg);
    }


    public function konfirmasi($id1)
    {
        $this->data = [];
        $this->data['title'] = 'Form Konfirmasi';
        $this->data['profiles'] = $this->_get_data_profile($id1);
        $uuid_responden = $this->uri->segment(4);

        $this->db->select('');
        $this->db->from('manage_survey');
        $this->db->where('manage_survey.slug', $this->uri->segment(2));
        $manage_survey = $this->db->get()->row();
        $table_identity = $manage_survey->table_identity;
        $this->data['status_saran'] = $manage_survey->is_saran;
        $this->data['manage_survey'] = $manage_survey;

        if ($manage_survey->is_saran == 1) {
            $this->data['link_back'] =  anchor(base_url() . 'survei/' . $this->uri->segment(2) . '/saran/' . $this->uri->segment(4), '<i class="fa fa-arrow-left"></i> Lengkapi Kembali', ['class' => 'btn btn-secondary btn-lg font-weight-bold shadow']);
        } else {
            $this->data['link_back'] =  anchor(base_url() . 'survei/' . $this->uri->segment(2) . '/pertanyaan/' . $this->uri->segment(4), '<i class="fa fa-arrow-left"></i> Lengkapi Kembali', ['class' => 'btn btn-secondary btn-lg font-weight-bold shadow']);
        }

        //CEK APAKAH SURVEY SUDAH DI SUBMIT APA BELUM
        $this->db->select("survey_$table_identity.is_active, is_submit");
        $this->db->from('survey_' . $table_identity);
        $this->db->join("responden_$table_identity", "survey_$table_identity.id_responden = responden_$table_identity.id");
        $this->db->where("responden_$table_identity.uuid = '$uuid_responden'");
        $is_selesai_survey = $this->db->get()->row();

        if ($is_selesai_survey->is_submit == 2) {
            return view('survei/form_konfirmasi', $this->data);
        } else {
            redirect(base_url() . 'survei/' . $this->uri->segment(2) . '/selesai/' . $uuid_responden, 'refresh');
        }
    }

    public function add_konfirmasi()
    {
        $uuid_responden = $this->uri->segment(4);
        $manage_survey = $this->db->get_where('manage_survey', ['slug' => $this->uri->segment(2)])->row();
        $table_identity = $manage_survey->table_identity;

        $id_res = $this->db->get_where("responden_$table_identity", array('uuid' => "$uuid_responden"))->row()->id;
        $input     = $this->input->post(NULL, TRUE);
        $object = [
            'is_submit' => 1,
            'is_end' => '* Finish'
        ];
        $this->db->where('id_responden', $id_res);
        $this->db->update('survey_' . $table_identity, $object);

        redirect(base_url() . 'survei/' . $this->uri->segment(2) . '/selesai/' . $this->uri->segment(4), 'refresh');

        // $pesan = 'Data berhasil disimpan';
        // $msg = ['sukses' => $pesan];
        // echo json_encode($msg);
    }


    public function form_selesai()
    {
        $this->data = [];
        $this->data['title'] = 'Sukses';
        $uuid_responden = $this->uri->segment(4);


        $this->data['manage_survey'] = $this->db->get_where('manage_survey', ['slug' => $this->uri->segment(2)])->row();
        $table_identity = $this->data['manage_survey']->table_identity;
        $this->data['status_saran'] = $this->data['manage_survey']->is_saran;


        $this->data['responden'] = $this->db->query("SELECT *
        FROM responden_$table_identity
        JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden
        WHERE responden_$table_identity.uuid = '$uuid_responden'")->row();

        if ($this->data['responden']->id_surveyor != 0) {
            $this->data['surveyor'] = $this->db->get_where('surveyor', array('id' => $this->data['responden']->id_surveyor))->row();
        }

        return view('survei/form_selesai', $this->data);
    }


    public function edit_data_responden()
    {

        $this->data = [];
        $this->data['title'] = 'Edit Data Responden';

        $this->db->select("*, DATE_FORMAT(survey_end, '%d %M %Y') AS survey_selesai, IF(CURDATE() > survey_end,1,NULL) AS survey_berakhir, IF(CURDATE() < survey_start ,1,NULL) AS survey_belum_mulai");
        $this->db->from('manage_survey');
        $this->db->where('manage_survey.slug', $this->uri->segment(2));
        $manage_survey = $this->db->get()->row();
        $table_identity = $manage_survey->table_identity;
        $this->data['status_saran'] = $manage_survey->is_saran;
        $this->data['manage_survey'] = $manage_survey;


        //LOAD PROFIL RESPONDEN
        $this->data['profil_responden'] = $this->db->query("SELECT * FROM profil_responden_$table_identity ORDER BY IF(urutan != '',urutan,id) ASC");

        //LOAD KATEGORI PROFIL RESPONDEN JIKA PILIHAN GANDA
        $this->data['kategori_profil_responden'] = $this->db->get('kategori_profil_responden_' . $table_identity);


        $uuid_responden = $this->uri->segment(4);
        $this->data['responden'] = $this->db->get_where("responden_$table_identity", array("uuid" => $uuid_responden))->row();
        // var_dump($this->data['responden']);

        $this->data['nama_lengkap'] = [
            'name'         => 'nama_lengkap',
            'id'        => 'nama_lengkap',
            'type'        => 'text',
            'value'        =>  $this->form_validation->set_value('nama_lengkap', $this->data['responden']->nama_lengkap),
            'class'        => 'form-control',
            'autofocus' => 'autofocus',
            'required' => 'required',
            'placeholder' => 'Masukkan data anda ...',
        ];

        return view('survei/edit_data_responden', $this->data);
    }


    function update_data_responden()
    {
        $this->db->select("*, DATE_FORMAT(survey_end, '%d %M %Y') AS survey_selesai, IF(CURDATE() > survey_end,1,NULL) AS survey_berakhir, IF(CURDATE() < survey_start ,1,NULL) AS survey_belum_mulai");
        $this->db->from('manage_survey');
        $this->db->where('manage_survey.slug', $this->uri->segment(2));
        $manage_survey = $this->db->get()->row();
        $table_identity = $manage_survey->table_identity;

        //LOAD PROFIL RESPONDEN
        $this->data['profil_responden'] = $this->db->query("SELECT * FROM profil_responden_$table_identity ORDER BY IF(urutan != '',urutan,id) ASC");


        //INSERT DATA RSEPONDEN
        $uuid_responden = $this->uri->segment(4);
        foreach ($this->data['profil_responden']->result() as $row) {
            $object[$row->nama_alias] = $this->input->post($row->nama_alias);
        }

        $this->db->where('uuid', $uuid_responden);
        $this->db->update("responden_$table_identity", $object);

        $pesan = 'Data berhasil disimpan';
        $msg = ['sukses' => $pesan];
        echo json_encode($msg);
    }


    public function _get_tamplate()
    {
        // $user = $this->ion_auth->user()->row()->id;
        $data_uri = $this->uri->segment('2');

        $this->db->select("*, DATE_FORMAT(survey_end, '%d %M %Y') AS survey_selesai, IF(CURDATE() > survey_end,1,NULL) AS survey_berakhir, IF(CURDATE() < survey_start ,1,NULL) AS survey_belum_mulai");
        $this->db->from('manage_survey');
        $this->db->join('users', 'manage_survey.id_user = users.id');
        $this->db->where("slug = '$data_uri'");
        $manage_survey = $this->db->get()->row();
        $this->data['judul'] = $manage_survey;
    }

    public function _get_data_profile($id1)
    {
        $this->data['get_template'] = $this->_get_tamplate();

        $this->db->select('*');
        $this->db->from('users');
        $this->db->join('manage_survey', 'manage_survey.id_user = users.id');
        $this->db->where('manage_survey.slug', $id1);
        $profiles = $this->db->get();

        if ($profiles->num_rows() == 0) {
            // echo 'Survey tidak ditemukan atau sudah dihapus !';
            // exit();
            show_404();
        }

        return $profiles->row();
    }

    public function unopened()
    {
        $this->data = [];
        $this->data['title'] = 'Link Survei';

        $this->db->select('*');
        $this->db->from('manage_survey');
        $this->db->where('manage_survey.slug', $this->uri->segment(2));
        $manage_survey = $this->db->get()->row();
        $this->data['judul'] = $manage_survey;


        return view('survei/form_setting_survey/unopened', $this->data);
    }

    public function survey_end()
    {
        $this->data = [];
        $this->data['title'] = 'Link Survei';

        $this->db->select('*');
        $this->db->from('manage_survey');
        $this->db->where('manage_survey.slug', $this->uri->segment(2));
        $manage_survey = $this->db->get()->row();
        $this->data['judul'] = $manage_survey;


        return view('survei/form_setting_survey/survey_end', $this->data);
    }

    public function survey_hold()
    {
        $this->data = [];
        $this->data['title'] = 'Link Survei';

        $this->db->select('*');
        $this->db->from('manage_survey');
        $this->db->where('manage_survey.slug', $this->uri->segment(2));
        $manage_survey = $this->db->get()->row();
        $this->data['judul'] = $manage_survey;

        return view('survei/form_setting_survey/survey_hold', $this->data);
    }

    public function survey_not_question()
    {
        $this->data = [];
        $this->data['title'] = 'Link Survei';

        $this->db->select('*');
        $this->db->from('manage_survey');
        $this->db->where('manage_survey.slug', $this->uri->segment(2));
        $manage_survey = $this->db->get()->row();
        $this->data['judul'] = $manage_survey;


        return view('survei/form_setting_survey/survey_not_question', $this->data);
    }
}

/* End of file HomeController.php */
/* Location: ./application/controllers/HomeController.php */
