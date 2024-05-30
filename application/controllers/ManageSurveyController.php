<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Carbon\Carbon;

class ManageSurveyController extends Client_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->library('ion_auth');

		if (!$this->ion_auth->logged_in()) {
			$this->session->set_flashdata('message_warning', 'You must be logged in to access this page');
			redirect('auth', 'refresh');
		}
		$this->load->model('ManageSurvey_model');
		$this->load->library('form_validation');
		$this->load->helper('security');

		$this->load->library('image_lib');
		$this->load->helper('file');
	}

	public function index()
	{
		$this->data = [];
		$this->data['title'] = "Kelola Survey";
		$user = $this->ion_auth->user()->row();
		$this->data['group'] = $this->db->query("SELECT * FROM users_groups WHERE user_id = $user->id")->row();

		if($this->data['group']->group_id == 2){

			$this->data['manage_survey'] = $this->db->get_where('manage_survey', array('id_user' => $user->id));
	
			$this->db->select('*, berlangganan.uuid AS uuid_berlangganan');
			$this->db->from('users');
			$this->db->join('berlangganan', 'berlangganan.id_user = users.id');
			$this->db->join('paket', 'paket.id = berlangganan.id_paket');
			$this->db->join('status_berlangganan', 'status_berlangganan.id = berlangganan.id_status_berlangganan');
			$this->db->where('users.username', $user->username);
			$this->db->order_by('berlangganan.id', 'asc');
			$this->data['client_packet'] = $this->db->get();
			$last_packet = $this->data['client_packet']->last_row();
	
			$uuid_berlangganan = $last_packet->uuid_berlangganan;
			$username = $last_packet->username;
	
			if (Client_Controller::check_jumlah_kuesioner($username, $uuid_berlangganan) == TRUE) {
				$this->data['status'] = 'href="' . base_url() . $this->uri->segment(1) . '/manage-survey/create-survey/' . $uuid_berlangganan . '"';
			} else {
				$this->data['status'] = 'onclick="cek()"';
			}
		}

		return view('manage_survey/index', $this->data);
	}

	public function ajax_list()
	{
		$data_user = $this->_cek_user()->row();

		$list = $this->ManageSurvey_model->get_datatables($data_user);
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $value) {

			if ($value->is_privacy == 1) {
				$status = '<span class="badge badge-info" width="40%">Public</span>';
			} else {
				$status = '<span class="badge badge-danger" width="40%">Private</span>';
			};

			$no++;
			$row = array();
			$row[] = '
			<a href="' . base_url() . $this->session->userdata('username') . '/' . $value->slug . '/do" title="">
			<div class="card mb-5 shadow" style="background-color: SeaShell;">
				<div class="card-body">
					<div class="row">
						<div class="col sm-10">
							<strong style="font-size: 17px;">' . $value->survey_name . '</strong><br>
							<span class="text-dark">Organisasi yang disurvei : <b>' . $value->organisasi . '</b></span><br>
						</div>
						<div class="col sm-2 text-right">' . $status . '
							<div class="mt-3 text-dark font-weight-bold" style="font-size: 11px;">
								Periode Survei : ' . date('d-m-Y', strtotime($value->survey_start)) . ' s/d ' . date('d-m-Y', strtotime($value->survey_end)) . '
							</div>

						</div>
					</div>
					<!--small class="text-secondary">' . $value->description . '</small><br-->
					
				</div>
			</div>
		</a>';

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->ManageSurvey_model->count_all($data_user),
			"recordsFiltered" => $this->ManageSurvey_model->count_filtered($data_user),
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function info_berlangganan()
	{
		$this->data = [];
		$this->data['title'] = "Info Berlangganan";

		// $data_user = $this->ion_auth->user()->row();
		$data_user = $this->db->get_where('users', array('username' => $this->uri->segment(1)))->row();

		$this->data['data_user'] = $data_user;

		return view('manage_survey/form_info_berlangganan', $this->data);
	}

	public function add()
	{
		$this->load->library('form_validation');
		$this->load->helper('security');
		$this->load->library('uuid');
		$this->load->helper('slug');

		$this->data = [];
		$this->data['title'] = "Create New Survey";
		$this->data['form_action'] = base_url() . $this->session->userdata('username') . "/manage-survey/save-survey/" . $this->uri->segment(4);
		$this->data['data_user'] = $this->ion_auth->user()->row();

		$this->data['klasifikasi_survey'] = $this->db->get('klasifikasi_survey');

		$this->form_validation->set_rules('survey_name', 'Nama Survey', 'trim|required|xss_clean');
		$this->form_validation->set_rules('survey_start', 'Survey Dimulai', 'trim|required|xss_clean');
		$this->form_validation->set_rules('survey_end', 'Survey Selesai', 'trim|required|xss_clean');
		$this->form_validation->set_rules('description', 'Deskripsi', 'trim|xss_clean');
		$this->form_validation->set_rules('jumlah_populasi', 'Jumlah Populasi', 'trim|xss_clean');

		$this->data['survey_name'] = [
			'name' 		=> 'survey_name',
			'id'		=> 'survey_name',
			'type'		=> 'text',
			'value'		=> $this->form_validation->set_value('survey_name'),
			'class'		=> 'form-control',
			'required'	=> 'required',
			'placeholder' => 'IKK Dinas XXX Kota XXX Tahun 2022, IKK Dinas XXX Periode Februari 2022 Sampai April 2022',
		];

		$this->data['organisasi'] = [
			'name' 		=> 'organisasi',
			'id'		=> 'organisasi',
			'type'		=> 'text',
			'value'		=> $this->form_validation->set_value('organisasi'),
			'class'		=> 'form-control',
			'required'	=> 'required',
			'placeholder' => 'Dinas XXX',
			'required' => 'required'
		];

		$this->data['description'] = [
			'name' 		=> 'description',
			'id'		=> 'description',
			'type'		=> 'text',
			'value'		=> $this->form_validation->set_value('description'),
			'class'		=> 'form-control',
			'rows' 		=> '3',
			'placeholder' => 'Survei Keberdayaan Konsumen Dinas XXX Kota XXX'
		];

		$this->data['id_sampling'] = [
			'name' 		=> 'id_sampling',
			'id' 		=> 'id_sampling',
			'options' 	=> $this->ManageSurvey_model->dropdown_sampling(),
			'selected' 	=> $this->form_validation->set_value('id_sampling'),
			'class' 	=> "form-control",
			'required' => 'required'
		];


		$this->data['wilayah_provinsi'] = [
			'name' 		=> 'id_wilayah',
			'id' 		=> 'id_wilayah',
			'options' 	=> $this->ManageSurvey_model->dropdown_wilayah_provinsi(),
			'selected' 	=> $this->form_validation->set_value('id_wilayah'),
			'class' 	=> "form-control",
			'required' => 'required'
		];

		$this->data['wilayah_kota_kabupaten'] = [
			'name' 		=> 'id_wilayah',
			'id' 		=> 'id_wilayah',
			'options' 	=> $this->ManageSurvey_model->dropdown_wilayah_kota_kabupaten(),
			'selected' 	=> $this->form_validation->set_value('id_wilayah'),
			'class' 	=> "form-control",
			'required' => 'required'
		];

		$this->data['wilayah_kecamatan'] = [
			'name' 		=> 'id_wilayah',
			'id' 		=> 'id_wilayah',
			'options' 	=> $this->ManageSurvey_model->dropdown_wilayah_kecamatan(),
			'selected' 	=> $this->form_validation->set_value('id_wilayah'),
			'class' 	=> "form-control",
			'required' => 'required'
		];

		$this->data['wilayah_desa'] = [
			'name' 		=> 'id_wilayah',
			'id' 		=> 'id_wilayah',
			'options' 	=> $this->ManageSurvey_model->dropdown_wilayah_desa(),
			'selected' 	=> $this->form_validation->set_value('id_wilayah'),
			'class' 	=> "form-control",
			'required' => 'required'
		];

		// $this->data['wilayah_nasional'] = [
		// 	'name' 		=> 'id_wilayah',
		// 	'type'		=> 'text',
		// 	'value'		=> 1,
		// 	'class'		=> 'form-control'
		// ];


		$this->data['is_privacy'] = $this->form_validation->set_value('is_privacy');

		return view('manage_survey/form_add', $this->data);
	}


	public function create()
	{
		$this->load->helper('slug');
		$this->load->library('uuid');

		$user = $this->ion_auth->user()->row();
		$berlangganan = $this->db->get_where('berlangganan', array('uuid' => $this->uri->segment(4)))->row();

		if ($this->input->post('custom') == "Custom") {
			$slug = slug($this->input->post('link'));
		} else {
			$slug = slug($this->input->post('survey_name'));
		};

		$jumlah_sampling = $this->input->post('jumlah_populasi');
		if ($this->input->post('id_sampling') == 1) {
			$jumlah_sampling = $this->input->post('populasi_krejcie');
			$sampling = $this->input->post('total_krejcie');
		} else if ($this->input->post('id_sampling') == 2) {
			$jumlah_sampling = $this->input->post('populasi_slovin');
			$sampling = $this->input->post('total_slovin');
		} else {
			$jumlah_sampling = NULL;
			$sampling = NULL;
		};


		if ($this->input->post('template') == 1) {
			$id_klasifikasi_survey = $this->input->post('id_klasifikasi_survey');
			$is_dimensi =  1;
		} else {
			$id_klasifikasi_survey = NULL;
			$is_dimensi =  2;
		};

		// split tanggal
		$split = explode("/", str_replace(" ", "", $this->input->post('tanggal_survei')));
		$survey_start = $split[0];
		$survey_end = $split[1];

		if ($user->id_kelompok_skala == 1) {
			$id_wilayah = 1;
		} else {
			$id_wilayah = $this->input->post('id_wilayah');
		};


		$object = [
			'uuid' => $this->uuid->v4(),
			'survey_name' => $this->input->post('survey_name'),
			'organisasi' => $this->input->post('organisasi'),
			'id_template' => $this->input->post('template'),
			'id_user' => $this->session->userdata('user_id'),
			'survey_start' => $survey_start,
			'survey_end' => $survey_end,
			'survey_year' => date('Y'),
			'description' => $this->input->post('description'),
			'is_privacy' => 1, //$this->input->post('is_privacy'),
			'slug' => 1,
			'deskripsi_tunda' => 'Survey akan dilanjutkan kembali pada',
			'id_klasifikasi_survey' => $id_klasifikasi_survey,
			'title_header_survey' => serialize(array("SURVEI INDEKS KEBERDAYAAN KONSUMEN", $this->input->post('organisasi'))),

			'deskripsi_opening_survey' => '<p>Bapak/Ibu yang terhormat,<br><br>Dalam rangka mengukur Indeks Keberdayaan Konsumen, Bapak/Ibu dipercaya menjadi responden untuk menilai tingkat keberdayaan konsumen Indonesia, mohon untuk memberikan pendapat dalam pembelian antara lain:</p><ol><li>Obat dan Makanan.</li><li>Jasa Keuangan: Perbankan, Asuransi (Kesehatan, Jiwa, Hari Tua, Kendaraan, dll), Lembaga Pembiayaan (Koperasi, Pegadaian, Leasing, Kredit Tanpa Agunan).</li><li>Jasa Transportasi (Darat, Laut, Udara).</li><li>Listrik dan Gas Rumah Tangga.</li><li>Jasa Telekomunikasi: Telepon Dasar, Akses Internet.</li><li>Jasa Layanan Kesehatan: Jasa Rumah Sakit, Puskesmas, Klinik Kesehatan, dll.</li><li>Perumahan: Pembeli Rumah/ Apartemen</li><li>Barang Elektronik, Telematika (Laptop, Handphone, Komputer, dll) dan Kendaraan Bermotor</li><li>Jasa Pariwisata (Restoran/Rumah Makan; Hotel/Vila; Taman Rekreasi/Kelab Malam/Diskotik/Karaoke/Gelanggang Olahraga/Arena Permainan; MICE; Spa)</li></ol><p>Bapak/Ibu diperbolehkan mengisi beberapa maupun semua terkait barang dan jasa yang disebutkan diatas.</p><p>Atas kesediaan Saudara kami sampaikan terima kasih dan penghargaan sedalam-dalamnya.<br>Jika ada yang perlu dikonfirmasikan terkait survei ini dapat menghubungi WhatsApp +62 895-3362-29033</p><p><br>&nbsp;</p><p>Hormat kami,</p><p><strong>Tim Survei Indeks Keberdayaan Konsumen</strong></p>',

			'id_sampling' => $this->input->post('id_sampling'),
			'jumlah_populasi' => $jumlah_sampling,
			'jumlah_sampling' => $sampling,
			'id_berlangganan' => $berlangganan->id,
			'is_saran' => 1,
			'is_question' => 1,
			'is_input_alasan' => 1,
			'is_dimensi' => $is_dimensi,
			'id_kelompok_skala' => $user->id_kelompok_skala,
			'id_wilayah' => $id_wilayah,
			'is_active_target' => $this->input->post('is_active_target'),
			'is_lampiran' => 2

		];
		$this->db->insert('manage_survey', $object);


		// LAKUKAN UPDATE KOLOM table_identity
		$insert_id = $this->db->insert_id();

		$cek = $this->db->query("SELECT * FROM manage_survey WHERE slug = '$slug'");
		if ($cek->num_rows() == 0) {
			$value_slug = $slug;
		} else {
			$value_slug = $slug . '-' . $insert_id;
		};

		$last_object = [
			'slug' => $value_slug,
			'table_identity' => "cst" . $insert_id
		];
		$this->db->where('id', $insert_id);
		$this->db->update('manage_survey', $last_object);

		$fk = 'survey_cst' . $insert_id . '_ibfk_1';
		$fk1 = 'jawaban_pertanyaan_unsur_cst' . $insert_id . '_ibfk_2';
		$fk2 = 'nilai_unsur_pelayanan_cst' . $insert_id . '_ibfk_1';
		$fk3 = 'kategori_profil_responden_cst' . $insert_id . '_ibfk_3';
		$fk4 = 'dimensi_cst' . $insert_id . '_ibfk_1';
		$fk5 = 'unsur_cst' . $insert_id . '_ibfk_1';
		$fk6 = 'pertanyaan_unsur_cst' . $insert_id . '_ibfk_4';

		$tb_survey = 'survey_cst' . $insert_id;
		$tb_responden = 'responden_cst' . $insert_id;
		$tb_jawaban_pertanyaan_unsur = 'jawaban_pertanyaan_unsur_cst' . $insert_id;
		$tb_tahapan_pembelian = 'tahapan_pembelian_cst' . $insert_id;
		$tb_dimensi = 'dimensi_cst' . $insert_id;
		$tb_unsur = 'unsur_cst' . $insert_id;
		$tb_pertanyaan_unsur = 'pertanyaan_unsur_cst' . $insert_id;
		$tb_nilai_unsur_pelayanan = 'nilai_unsur_pelayanan_cst' . $insert_id;
		$tb_target = 'target_cst' . $insert_id;
		$tb_profil_responden = 'profil_responden_cst' . $insert_id;
		$tb_kategori_profil_responden = 'kategori_profil_responden_cst' . $insert_id;
		$tb_log_survey = 'log_survey_cst' . $insert_id;
		$tb_wilayah_survei = 'wilayah_survei_cst' . $insert_id;
		$tb_sektor = 'sektor_cst' . $insert_id;
		$tb_pertanyaan_terbuka = 'pertanyaan_terbuka_cst' . $insert_id;
		$tb_kategori_pertanyaan_terbuka = 'kategori_pertanyaan_terbuka_cst' . $insert_id;
		$tb_jawaban_pertanyaan_terbuka = 'jawaban_pertanyaan_terbuka_cst' . $insert_id;


		//BUAT TABEL PROFIL RESPONDEN
		$this->db->query("CREATE TABLE $tb_profil_responden LIKE profil_responden");
		$this->db->query("INSERT INTO $tb_profil_responden SELECT * FROM profil_responden WHERE id IN (1,2,3)");
		$this->db->query("CREATE TABLE $tb_kategori_profil_responden LIKE kategori_profil_responden");



		//BUAT TABEL PERTANYAAN UNSUR DLL
		$this->db->query("CREATE TABLE $tb_tahapan_pembelian LIKE tahapan_pembelian;");
		$this->db->query("CREATE TABLE $tb_dimensi LIKE dimensi;");
		$this->db->query("CREATE TABLE $tb_unsur LIKE unsur;");
		$this->db->query("CREATE TABLE $tb_pertanyaan_unsur LIKE pertanyaan_unsur;");
		$this->db->query("CREATE TABLE $tb_nilai_unsur_pelayanan LIKE nilai_unsur_pelayanan;");

		$this->db->query("ALTER TABLE $tb_dimensi ADD CONSTRAINT $fk4 FOREIGN KEY (`id_tahapan_pembelian`) REFERENCES $tb_tahapan_pembelian(`id`) ON DELETE CASCADE ON UPDATE CASCADE");
		$this->db->query("ALTER TABLE $tb_unsur  ADD CONSTRAINT $fk5 FOREIGN KEY (`id_dimensi`) REFERENCES $tb_dimensi(`id`) ON DELETE CASCADE ON UPDATE CASCADE");
		$this->db->query("ALTER TABLE $tb_pertanyaan_unsur  ADD CONSTRAINT $fk6 FOREIGN KEY (`id_unsur`) REFERENCES $tb_unsur(`id`) ON DELETE CASCADE ON UPDATE CASCADE");
		$this->db->query("ALTER TABLE $tb_nilai_unsur_pelayanan ADD CONSTRAINT $fk2 FOREIGN KEY (`id_pertanyaan_unsur`) REFERENCES $tb_pertanyaan_unsur(`id`) ON DELETE CASCADE ON UPDATE CASCADE");


		#PERTANYAAN TERBUKA
		$this->db->query("CREATE TABLE $tb_pertanyaan_terbuka LIKE pertanyaan_terbuka;");
		$this->db->query("CREATE TABLE $tb_kategori_pertanyaan_terbuka LIKE pertanyaan_terbuka;");
		$this->db->query("CREATE TABLE $tb_jawaban_pertanyaan_terbuka LIKE jawaban_pertanyaan_terbuka;");


		//INSERT DATA KE TABEL DIMENSI DLL
		$this->db->query("INSERT INTO $tb_tahapan_pembelian SELECT * FROM tahapan_pembelian WHERE id_klasifikasi_survey = 1;");
		$this->db->query("INSERT INTO $tb_dimensi SELECT dimensi.id, id_tahapan_pembelian, kode_dimensi, nama_dimensi, persentase_dimensi FROM dimensi JOIN tahapan_pembelian ON dimensi.id_tahapan_pembelian = tahapan_pembelian.id WHERE tahapan_pembelian.id_klasifikasi_survey = 1;");



		//BUAT TABEL RESPONDEN, SURVEI, DAN JAWABAN
		$this->db->query("CREATE TABLE $tb_responden LIKE responden");
		$this->db->query("CREATE TABLE $tb_survey LIKE survey");
		$this->db->query("CREATE TABLE $tb_jawaban_pertanyaan_unsur LIKE jawaban_pertanyaan_unsur");
		$this->db->query("CREATE TABLE $tb_log_survey LIKE log_survey");
		$this->db->query("ALTER TABLE $tb_survey ADD CONSTRAINT $fk FOREIGN KEY (`id_responden`) REFERENCES $tb_responden(`id`) ON DELETE CASCADE ON UPDATE CASCADE");
		$this->db->query("ALTER TABLE $tb_jawaban_pertanyaan_unsur  ADD CONSTRAINT $fk1 FOREIGN KEY (`id_survey`) REFERENCES $tb_survey(`id`) ON DELETE CASCADE ON UPDATE CASCADE");
		$this->db->query("ALTER TABLE $tb_jawaban_pertanyaan_terbuka  ADD CONSTRAINT $fk1 FOREIGN KEY (`id_survey`) REFERENCES $tb_survey(`id`) ON DELETE CASCADE ON UPDATE CASCADE");



		//BUAT TABEL WILAYAH DAN SEKTOR
		if ($user->id_kelompok_skala == 1) {
			$query_kategori = "INSERT INTO $tb_wilayah_survei (nama_wilayah) SELECT nama_provinsi FROM wilayah_provinsi";
		} elseif ($user->id_kelompok_skala == 2) {
			$query_kategori = "INSERT INTO $tb_wilayah_survei (nama_wilayah) SELECT nama_kota_kabupaten FROM wilayah_kota_kabupaten WHERE provinsi_id = $id_wilayah";
		} elseif ($user->id_kelompok_skala == 3) {
			$query_kategori = "INSERT INTO $tb_wilayah_survei (nama_wilayah) SELECT nama_kecamatan FROM wilayah_kecamatan WHERE kabupaten_id = $id_wilayah";
		} elseif ($user->id_kelompok_skala == 4) {
			$query_kategori = "INSERT INTO $tb_wilayah_survei (nama_wilayah) SELECT nama_desa FROM wilayah_desa WHERE kecamatan_id = $id_wilayah";
		} else {
			$query_kategori = "";
		};

		$this->db->query("CREATE TABLE $tb_wilayah_survei LIKE wilayah_survei");
		$this->db->query($query_kategori);
		$this->db->query("CREATE TABLE $tb_sektor LIKE sektor");
		$this->db->query("CREATE TABLE $tb_target LIKE target");


		//BUAT TABEL TRASH
		$this->db->query("CREATE TABLE trash_responden_cst$insert_id LIKE responden");
		$this->db->query("CREATE TABLE trash_survey_cst$insert_id LIKE survey");
		$this->db->query("CREATE TABLE trash_jawaban_pertanyaan_unsur_cst$insert_id LIKE jawaban_pertanyaan_unsur");
		$this->db->query("CREATE TABLE trash_jawaban_pertanyaan_terbuka_cst$insert_id LIKE jawaban_pertanyaan_terbuka");


		if ($this->input->post('template') == 1) {
			$this->db->query(
				"INSERT INTO $tb_unsur
				SELECT unsur.id, id_dimensi, kode_unsur, nama_unsur, persentase_unsur
				FROM unsur
				JOIN dimensi ON dimensi.id = unsur.id_dimensi
				JOIN tahapan_pembelian ON dimensi.id_tahapan_pembelian = tahapan_pembelian.id
				WHERE tahapan_pembelian.id_klasifikasi_survey = $id_klasifikasi_survey;"
			);

			$this->db->query(
				"INSERT INTO $tb_pertanyaan_unsur
				SELECT pertanyaan_unsur.id, pertanyaan_unsur.id_unsur, pertanyaan_unsur.isi_pertanyaan, pertanyaan_unsur.is_active_alasan, pertanyaan_unsur.label_alasan
				FROM pertanyaan_unsur
				JOIN unsur ON pertanyaan_unsur.id_unsur = unsur.id
				JOIN dimensi ON dimensi.id = unsur.id_dimensi
				JOIN tahapan_pembelian ON dimensi.id_tahapan_pembelian = tahapan_pembelian.id
				WHERE tahapan_pembelian.id_klasifikasi_survey = $id_klasifikasi_survey;"
			);

			$this->db->query(
				"INSERT INTO $tb_nilai_unsur_pelayanan
					SELECT nilai_unsur_pelayanan.id, nilai_unsur_pelayanan.id_pertanyaan_unsur, nilai_unsur_pelayanan.nilai_jawaban, nilai_unsur_pelayanan.nama_jawaban
					FROM nilai_unsur_pelayanan
					JOIN pertanyaan_unsur ON nilai_unsur_pelayanan.id_pertanyaan_unsur = pertanyaan_unsur.id
					JOIN unsur ON pertanyaan_unsur.id_unsur = unsur.id
					JOIN dimensi ON dimensi.id = unsur.id_dimensi
					JOIN tahapan_pembelian ON dimensi.id_tahapan_pembelian = tahapan_pembelian.id
					WHERE tahapan_pembelian.id_klasifikasi_survey = $id_klasifikasi_survey;"
			);

			if ($id_klasifikasi_survey == 1) {
				$this->db->query(
					"INSERT INTO $tb_sektor SELECT * FROM sektor;"
				);
				$this->db->query("UPDATE manage_survey SET is_target = 1 WHERE id=$insert_id");
			}
		}

		// $this->db->query("CREATE TABLE statistik_survei_cst$insert_id LIKE statistik_survei");

		$this->db->query("
		CREATE TRIGGER log_app_cst$insert_id AFTER INSERT ON responden_cst$insert_id
		FOR EACH ROW BEGIN 
		INSERT INTO log_survey_cst$insert_id(log_value, log_time) VALUES(CONCAT(NEW.nama_lengkap, ', sudah mengisi survei'), DATE_ADD(NOW(), INTERVAL 13 HOUR));
		END");

		$pesan = 'Data berhasil disimpan';
		$msg = ['sukses' => $pesan];
		echo json_encode($msg);
	}


	public function data_berlangganan()
	{
		$this->data = [];

		// $data_user = $this->ion_auth->user()->row();
		$data_user = $this->db->get_where('users', array('username' => $this->uri->segment(1)))->row();
		$this->data['data_user'] = $data_user;

		$this->load->library('table');

		$template = array(
			'table_open'            => '<table class="table table-bordered table-hover">',
			'table_close'           => '</table>'
		);

		$this->table->set_template($template);

		$this->table->set_heading('NO', 'Nama Pelanggan', 'Nama Paket', 'Panjang Hari', 'Harga Paket (Rp.)', 'Tanggal Aktif', 'Tanggal Kedaluarsa', 'Status', '');

		$this->db->select('*, berlangganan.id AS id_berlangganan');
		$this->db->from('berlangganan');
		$this->db->join('users', 'users.id = berlangganan.id_user');
		$this->db->join('paket', 'paket.id = berlangganan.id_paket');
		$this->db->join('status_berlangganan', 'status_berlangganan.id = berlangganan.id_status_berlangganan');
		$this->db->join('metode_pembayaran', 'metode_pembayaran.id = berlangganan.id_metode_pembayaran');
		$this->db->where('berlangganan.id_user', $data_user->id);
		$this->db->order_by('berlangganan.id', 'asc');
		$get_data = $this->db->get();

		// $jumlah = $get_data->num_rows();

		$no = 1;
		$now = Carbon::now();
		foreach ($get_data->result() as $value) {

			if ($now->between(Carbon::parse($value->tanggal_mulai), Carbon::parse($value->tanggal_selesai))) {
				$status = '<span class="badge badge-success">Aktif</span';
			} else {
				$status = '<span class="badge badge-secondary">Tidak Aktif</span';
			}

			// if ($no == $jumlah) {
			// 	$status = '<span class="badge badge-success">Aktif</span';
			// } else {
			// 	$status = '<span class="badge badge-secondary">Tidak Aktif</span';
			// }

			$this->table->add_row(
				$no++,
				$value->first_name . ' ' . $value->last_name,
				$value->nama_paket,
				$value->panjang_hari,
				number_format($value->harga_paket, 2, ',', '.'),
				date('d-m-Y', strtotime($value->tanggal_mulai)),
				date('d-m-Y', strtotime($value->tanggal_selesai)),
				$status,
				'<a href="javascript:void(0)" class="text-primary" title="Get Invoice" onclick="showDetail(' . $value->id_berlangganan . ')">Get Invoice</a>'
			);
		}

		$this->data['table'] = $this->table->generate();

		return view('manage_survey/info_berlangganan/list_data_berlangganan', $this->data);
	}

	public function data_terakhir_berlangganan()
	{
		$this->data = [];

		$this->db->select('*, berlangganan.id AS id_berlangganan');
		$this->db->from('berlangganan');
		$this->db->join('users', 'users.id = berlangganan.id_user');
		$this->db->join('paket', 'paket.id = berlangganan.id_paket');
		$this->db->join('status_berlangganan', 'status_berlangganan.id = berlangganan.id_status_berlangganan');
		$this->db->join('metode_pembayaran', 'metode_pembayaran.id = berlangganan.id_metode_pembayaran');
		$this->db->where('users.username', $this->uri->segment(1));
		$this->db->order_by('berlangganan.id', 'asc');
		$get_data = $this->db->get();

		$last_payment = $get_data->last_row();
		$this->data['last_payment'] = $last_payment;

		$tanggal_mulai = $last_payment->tanggal_mulai;
		$tanggal_selesai = $last_payment->tanggal_selesai;

		$this->data['tanggal_sekarang'] = $tanggal_mulai;
		$this->data['tanggal_expired'] = $tanggal_selesai;

		$tanggal_mulai = $last_payment->tanggal_mulai;
		$tanggal_selesai = $last_payment->tanggal_selesai;

		$now = Carbon::now();
		$start_date = Carbon::parse($tanggal_mulai);
		$end_date = Carbon::parse($tanggal_selesai);
		$due_date = $now->diffInDays($end_date); // Tanggal jatuh tempo

		if ($now->between($start_date, $end_date)) {
			$this->data['status_jatuh_tempo'] = 'Paket berakhir dalam ' . $due_date . ' hari lagi';
			$this->data['status_paket'] = '<span class="badge badge-success">Aktif</span>';
		} else {
			$this->data['status_jatuh_tempo'] = 'Packet is Expired';
			$this->data['status_paket'] = '<span class="badge badge-danger">Expired</span>';
		}

		return view('manage_survey/info_berlangganan/list_data_terakhir_berlangganan', $this->data);
	}

	public function get_invoice()
	{
		$id_berlangganan = $this->input->post('id');

		echo '<div class="text-center" style="background-color:Tomato; color:white;">Features in progress..</div>';
	}

	public function profile($id = NULL)
	{
		$this->data = [];
		$this->data['title'] = "Profile";
		$this->data['form_action'] = base_url() . $this->session->userdata('username');

		$this->data['data_user'] = $this->ion_auth->user()->row();
		$current = $this->data['data_user'];

		return view('manage_survey/form_profile', $this->data);
	}

	public function _cek_user()
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->join('users_groups', 'users.id = users_groups.user_id');
		$this->db->where('users.username', $this->session->userdata('username'));
		return $this->db->get();
	}

	function _data_survey()
	{
		$data_user = $this->_cek_user()->row();

		if ($data_user->group_id == 2) {
			// Jika grup klien
			$this->db->select('users.username, manage_survey.survey_name, manage_survey.slug, manage_survey.description, manage_survey.is_privacy, klasifikasi_survey.nama_klasifikasi_survey, table_identity');
			$this->db->from('users');
			$this->db->join('manage_survey', 'manage_survey.id_user = users.id');
			$this->db->join('klasifikasi_survey', 'klasifikasi_survey.id = users.id_klasifikasi_survey');
			$this->db->where('users.username', $this->session->userdata('username'));
		} else {
			// Jika grup selain klien
			$this->db->select('users.username, manage_survey.survey_name, manage_survey.slug, manage_survey.description, manage_survey.is_privacy, klasifikasi_survey.nama_klasifikasi_survey, table_identity');
			$this->db->from('manage_survey');
			$this->db->join("supervisor_drs$data_user->is_parent", "manage_survey.id_berlangganan = supervisor_drs$data_user->is_parent.id_berlangganan");
			$this->db->join("users", "supervisor_drs$data_user->is_parent.id_user = users.id");
			$this->db->join('klasifikasi_survey', 'users.id_klasifikasi_survey = klasifikasi_survey.id');
			$this->db->where('users.username', $this->session->userdata('username'));
		}
		return $this->db->get();
	}

	public function get_data_survey()
	{
		$this->data['data_survey'] = $this->_data_survey();

		return view("manage_survey/overview/list_survey", $this->data);
	}

	public function get_data_activity()
	{
		$this->data['data_survey'] = $this->_data_survey();

		$this->data['paket'] = $this->db->get('paket');

		$data = array();
		foreach ($this->data['data_survey']->result() as $key => $value) {
			$data[$key] = 'UNION ALL SELECT * from log_survey_' . $value->table_identity;
		}
		$tabel_union = implode(" ", $data);

		$this->data['log_survey'] = $this->db->query('SELECT * from log_survey ' . $tabel_union . ' ORDER BY log_time DESC
		LIMIT 10')->result();
		// var_dump($this->data['log_survey']);

		return view("manage_survey/overview/list_activity", $this->data);
	}

	public function get_data_paket()
	{
		$this->data['data_survey'] = $this->_data_survey();

		$this->db->select('*');
		$this->db->from('paket');
		$this->db->where('is_active', '1');
		$this->db->where('is_trial', '0');
		$this->data['paket'] = $this->db->get();

		return view("manage_survey/overview/list_campaign", $this->data);
	}

	

	public function repository($id1, $id2)
	{
		$this->data = [];

		$this->data['profiles'] = $this->_get_data_profile($id1, $id2);
		$this->data['title'] = 'Deskripsi Survei';
		$jumlah_sampling = $this->data['profiles']->jumlah_sampling;

		$this->data['form_action'] = base_url() . $id1 . '/' . $id2 . '/' . $this->data['profiles']->id_manage_survey . "/update_info";
		$this->data['form_action_update_logo'] = base_url() . $id1 . '/' . $id2 . '/' . $this->data['profiles']->id_manage_survey . "/update_logo";

		$this->db->select('*, manage_survey.id AS id_manage_survey, (SELECT nama_kelompok_skala FROM kelompok_skala WHERE id_kelompok_skala = kelompok_skala.id) AS nama_kelompok_skala');
		$this->db->from('manage_survey');
		$this->db->where('manage_survey.slug', $this->uri->segment(2));
		$manage_survey = $this->db->get()->row();
		$this->data['manage_survey'] = $manage_survey;


		if ($manage_survey->id_kelompok_skala == 2) {
			$this->data['wilayah_survei'] = $this->db->get_where("wilayah_provinsi", array('id' => $manage_survey->id_wilayah))->row()->nama_provinsi;
		} elseif ($manage_survey->id_kelompok_skala == 3) {
			$this->data['wilayah_survei'] = $this->db->get_where("wilayah_kota_kabupaten", array('id' => $manage_survey->id_wilayah))->row()->nama_kota_kabupaten;
		} elseif ($manage_survey->id_kelompok_skala == 4) {
			$this->data['wilayah_survei'] = $this->db->get_where("wilayah_kecamatan", array('id' => $manage_survey->id_wilayah))->row()->nama_kecamatan;
		} else {
			$this->data['wilayah_survei'] = 'Indonesia';
		}

		//JUMLAH KUISIONER
		$this->db->select('COUNT(id) AS id');
		$this->db->from('survey_' . $manage_survey->table_identity);
		$this->db->where("is_submit = 1");
		$this->data['jumlah_kuisioner'] = $this->db->get()->row()->id;
		$jumlah_kuisioner = $this->data['jumlah_kuisioner'];

		$this->data['sampling_belum'] = $this->db->query("SELECT ($jumlah_sampling - $jumlah_kuisioner) AS sample_kurang")->row()->sample_kurang;

		$this->data['id_sampling'] = [
			'name' 		=> 'id_sampling',
			'id' 		=> 'id_sampling',
			'options' 	=> $this->ManageSurvey_model->dropdown_sampling(),
			'selected' 	=> $this->form_validation->set_value('id_sampling', $manage_survey->id_sampling),
			'class' 	=> "form-control",
		];



		// #UPDATE STATISTIK SURVEI===============================
		// $this->db->query("DELETE FROM statistik_survei_$manage_survey->table_identity WHERE expired <= '" . date('Y-m-d H:i:s') . "'");
		// #END UPDATE STATISTIK SURVEI===========================

		return view('manage_survey/form_repository', $this->data);
	}

	public function update_repository()
	{
		$slug = $this->uri->segment(2);

		// $jumlah_sampling = $this->input->post('jumlah_populasi');
		if ($this->input->post('id_sampling') == 1) {
			$jumlah_populasi = $this->input->post('populasi_krejcie');
			$sampling = $this->input->post('total_krejcie');
		} else if ($this->input->post('id_sampling') == 2) {
			$jumlah_populasi = $this->input->post('populasi_slovin');
			$sampling = $this->input->post('total_slovin');
		} else {
			$jumlah_populasi = NULL;
			$sampling = NULL;
		};

		$object = [
			'survey_name' => $this->input->post('nama_survei'),
			'organisasi' => $this->input->post('organisasi'),
			'description' => $this->input->post('deskripsi'),
			'alamat' => $this->input->post('alamat'),
			'email' => $this->input->post('email'),
			'no_tlpn' => $this->input->post('nomor'),
			// 'atribut_pertanyaan_survey' => serialize($this->input->post('atribut_pertanyaan')),
			'id_sampling' => $this->input->post('id_sampling'),
			'jumlah_populasi' => $jumlah_populasi,
			'jumlah_sampling' => $sampling,
			'is_input_alasan' => 1
		];
		$this->db->where('slug', "$slug");
		$this->db->update('manage_survey', $object);

		$pesan = 'Data berhasil disimpan';
		$msg = ['sukses' => $pesan];
		echo json_encode($msg);
	}

	public function delete_survey($id)
	{
		// CARI DATA UNTUK MENGHAPUS TABEL
		$this->db->select('id, table_identity');
		$this->db->from('manage_survey');
		$this->db->where('id', $id);
		$current = $this->db->get()->row();

		// HAPUS TABEL
		$this->load->dbforge();
		// $this->db->query('use kjsnneu7_e_skm');
		$this->dbforge->drop_table('jawaban_pertanyaan_unsur_' . $current->table_identity, TRUE);
		$this->dbforge->drop_table('survey_' . $current->table_identity, TRUE);
		$this->dbforge->drop_table('responden_' . $current->table_identity, TRUE);
		$this->dbforge->drop_table('nilai_unsur_pelayanan_' . $current->table_identity, TRUE);
		$this->dbforge->drop_table('pertanyaan_unsur_' . $current->table_identity, TRUE);
		$this->dbforge->drop_table('unsur_' . $current->table_identity, TRUE);
		$this->dbforge->drop_table('dimensi_' . $current->table_identity, TRUE);
		$this->dbforge->drop_table('tahapan_pembelian_' . $current->table_identity, TRUE);
		$this->dbforge->drop_table('kategori_profil_responden_' . $current->table_identity, TRUE);
		$this->dbforge->drop_table('profil_responden_' . $current->table_identity, TRUE);
		$this->dbforge->drop_table('log_survey_' . $current->table_identity, TRUE);
		$this->dbforge->drop_table('analisa_' . $current->table_identity, TRUE);
		$this->dbforge->drop_table('target_' . $current->table_identity, TRUE);
		$this->dbforge->drop_table('wilayah_survei_' . $current->table_identity, TRUE);
		$this->dbforge->drop_table('sektor_' . $current->table_identity, TRUE);

		$this->dbforge->drop_table('supervisor_drs' . $current->id, TRUE);
		$this->dbforge->drop_table('division_drs' . $current->id, TRUE);

		$this->dbforge->drop_table('trash_jawaban_pertanyaan_unsur_' . $current->table_identity, TRUE);
		$this->dbforge->drop_table('trash_survey_' . $current->table_identity, TRUE);
		$this->dbforge->drop_table('trash_responden_' . $current->table_identity, TRUE);

		// $surveyor = $this->db->get("surveyor_$current->table_identity");
		// if ($surveyor->num_rows() != 0) {
		// 	foreach ($surveyor->result() as $row) {
		// 		$id_users[] = $row->id_user;
		// 	}
		// 	$data = implode(", ", $id_users);

		// 	$this->db->where_in('user_id', $data);
		// 	$this->db->delete('users_groups');

		// 	$this->db->where_in('id', $data);
		// 	$this->db->delete('users');
		// }
		// $this->dbforge->drop_table('surveyor_' . $current->table_identity, TRUE);

		// HAPUS DATA TABEL SURVEY
		$this->db->where('id', $id);
		$this->db->delete('manage_survey');

		echo json_encode(array("status" => TRUE));
	}


	public function _get_data_profile($id1, $id2)
	{
		$data_user = $this->_cek_user()->row();
		$user_identity = 'drs' . $data_user->is_parent;

		$this->db->select('*, manage_survey.id AS id_manage_survey,
		(SELECT group_id FROM users_groups WHERE user_id = users.id) AS group_id');

		if ($data_user->group_id == 2) {
			$this->db->from('users');
			$this->db->join('manage_survey', 'manage_survey.id_user = users.id');
			$this->db->join('klasifikasi_survey', 'klasifikasi_survey.id = users.id_klasifikasi_survey', 'left');
			$this->db->join('sampling', 'sampling.id = manage_survey.id_sampling');
			$this->db->where('users.username', $id1);
			$this->db->where('manage_survey.slug', $id2);
		} else {
			$this->db->from('manage_survey');
			$this->db->join("supervisor_$user_identity", "manage_survey.id_berlangganan = supervisor_$user_identity.id_berlangganan");
			$this->db->join("users", "supervisor_$user_identity.id_user = users.id");
			// $this->db->join('jenis_pelayanan', 'manage_survey.id_jenis_pelayanan = jenis_pelayanan.id', 'left');
			$this->db->join('klasifikasi_survey', "klasifikasi_survey.id = users.id_klasifikasi_survey");
			$this->db->join('sampling', 'sampling.id = manage_survey.id_sampling');
			$this->db->where('users.username', $id1);
			$this->db->where('manage_survey.slug', $id2);
		}
		$profiles = $this->db->get();
		// var_dump($profiles->row());

		if ($profiles->num_rows() == 0) {
			// echo 'Survey tidak ditemukan atau sudah dihapus !';
			// exit();
			show_404();
		}
		return $profiles->row();
	}
}

/* End of file ManageSurveyController.php */
/* Location: ./application/controllers/ManageSurveyController.php */
