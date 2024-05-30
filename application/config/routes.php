<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['login'] = 'authentication/login';
$route['kuesioner'] = 'survey/kuesioner';
$route['entry_data'] = 'survey/entry_data';
$route['insert_responden/(:any)'] = 'survey/insert_responden/$1';

$route['survei/(:any)'] = 'survey/broadcast/$1';

// DASHBOARD
$route['dashboard'] = 'DashboardController/index';
$route['dashboard/jumlah-survei'] = 'DashboardController/jumlah_survei';
$route['prosedur-penggunaan-aplikasi'] = 'DashboardController/prosedur_aplikasi';
$route['(:any)/dashboard/chart-survei'] = 'DashboardController/get_chart_survei/$1';
$route['(:any)/dashboard/tabel-survei'] = 'DashboardController/get_tabel_survei/$1';
$route['(:any)/dashboard/ajax-list-tabel-survei'] = 'DashboardController/ajax_list_tabel_survei/$1';
$route['(:any)/dashboard/detail-hasil-analisa/(:num)'] = 'DashboardController/get_detail_hasil_analisa/$1/$2';

// DASHBOARD INDUK
$route['dashboard/chart-survei-induk'] = 'DashboardIndukController/get_chart_survei';
$route['dashboard/tabel-survei-induk'] = 'DashboardIndukController/get_tabel_survei';
$route['dashboard/ajax-list-tabel-survei-induk'] = 'DashboardIndukController/ajax_list_tabel_survei_induk';

$route['home'] = 'HomeController/index';
$route['about'] = 'HomeController/about';
$route['team'] = 'HomeController/team';
$route['contact'] = 'ContactController/index';
$route['contact/validate-message'] = 'ContactController/validate_message';
$route['contact/refresh-captcha'] = 'ContactController/refresh_captcha';
$route['privacy'] = 'HomeController/privacy';
$route['legal'] = 'HomeController/legal';
$route['survei-saat-ini'] = 'HomeController/survei_saat_ini';

// INBOX
$route['inbox'] = 'InboxController/index';
$route['inbox/data-inbox'] = 'InboxController/get_data_inbox';
$route['inbox/reply/(:num)'] = 'InboxController/reply/$1';
$route['inbox/validate-message'] = 'InboxController/validate_message';
$route['inbox/delete-reply/(:num)'] = 'InboxController/delete_reply/$1';

//MASTER
$route['kriteria-responden'] = 'KriteriaRespondenController/index';
$route['klasifikasi-survei'] = 'KlasifikasiSurveiController/index';
$route['tahapan-pembelian'] = 'TahapanPembelianController/index';
$route['dimensi'] = 'DimensiController/index';
$route['unsur'] = 'UnsurController/index';
$route['pertanyaan'] = 'PertanyaanController/index';
$route['pertanyaan/ajax-list'] = 'PertanyaanController/ajax_list';
$route['pertanyaan/edit/(:num)'] = 'PertanyaanController/edit/$1';
$route['kelompok-skala'] = 'KelompokSkalaController/index';

$route['lokasi-survei'] = 'LokasiSurveiController/index';
$route['lokasi-survei/ajax-list'] = 'LokasiSurveiController/ajax_list';
$route['lokasi-survei/kota-kab/(:num)'] = 'LokasiSurveiController/kota_kab/$1';
$route['lokasi-survei/ajax-list-kota-kab'] = 'LokasiSurveiController/ajax_list_kota_kab';
$route['survey/(:any)/unopened'] = 'SurveiController/unopened/$1/';
$route['survey/(:any)/survey-end'] = 'SurveiController/survey_end/$1/';
$route['survey/(:any)/survey-hold'] = 'SurveiController/survey_hold/$1/';
$route['survey/(:any)/survey-not-question'] = 'SurveiController/survey_not_question/$1/';

$route['lokasi-survei/create-kota-kabupaten/(:num)'] = 'LokasiSurveiController/create_kota_kabupaten/$1';
$route['lokasi-survei/insert-kota-kabupaten'] = 'LokasiSurveiController/insert_kota_kabupaten';
$route['lokasi-survei/edit-kota-kabupaten/(:num)'] = 'LokasiSurveiController/edit_kota_kabupaten/$1';
$route['lokasi-survei/delete-kota-kabupaten/(:num)'] = 'LokasiSurveiController/delete_kota_kabupaten/$1';

$route['lokasi-survei/create-provinsi'] = 'LokasiSurveiController/create_provinsi';
$route['lokasi-survei/insert-provinsi'] = 'LokasiSurveiController/insert_provinsi';
$route['lokasi-survei/edit-provinsi/(:num)'] = 'LokasiSurveiController/edit_provinsi/$1';
$route['lokasi-survei/delete-provinsi/(:num)'] = 'LokasiSurveiController/delete_provinsi/$1';

$route['unsur/edit-pertanyaan/(:num)'] = 'UnsurController/edit_pertanyaan/$1';
// $route['manage-survey'] = 'ManageSurveyController/index';

// Auth
$route['auth'] = 'Auth/index';
$route['auth/index'] = 'Auth/index';
$route['auth/login'] = 'Auth/login';
$route['auth/_redirection'] = 'Auth/_redirection';
$route['auth/logout'] = 'Auth/logout';
$route['user-logout'] = 'Auth/user_logout';
$route['auth/change_password'] = 'Auth/change_password';
$route['auth/forgot_password'] = 'Auth/forgot_password';
$route['auth/reset_password/(:num)'] = 'Auth/reset_password/$1';
$route['auth/activate/(:num)/(:num)'] = 'Auth/activate/$1/$2';
$route['auth/deactivate/(:num)'] = 'Auth/deactivate/$1';
$route['auth/create_user'] = 'Auth/create_user';
$route['auth/redirectUser'] = 'Auth/redirectUser';
$route['auth/edit_user/(:num)'] = 'Auth/edit_user/$1';
$route['auth/create_group'] = 'Auth/create_group';
$route['auth/edit_group/(:num)'] = 'Auth/edit_group/$1';
$route['auth/_get_csrf_nonce'] = 'Auth/_get_csrf_nonce';
$route['auth/_valid_csrf_nonce'] = 'Auth/_valid_csrf_nonce';
$route['auth/_render_page/(:num)/(:num)/(:num)'] = 'Auth/_render_page/$1/$2/$3';
$route['auth/delete_user'] = 'Auth/delete_user';
$route['auth/generate-password'] = 'Auth/generate_password';
$route['auth/generate-password-form'] = 'Auth/generate_password_form';
$route['auth/delete_user'] = 'Auth/delete_user';
$route['auth/update-aside/(:num)'] = 'Auth/update_aside/$1';

//PENGGUNA ADMINISTRATOR
$route['pengguna-administrator'] = 'Auth/index';
$route['pengguna-administrator/ajax-list-administrator'] = 'Auth/ajax_list_administrator';
$route['pengguna-administrator/create-administrator'] = 'Auth/create_administrator';
$route['pengguna-administrator/edit_administrator/(:num)'] = 'Auth/edit_administrator/$1';
$route['auth/delete_user'] = 'Auth/delete_user';

//PENGGUNA KLIEN INDUK
$route['pengguna-klien-induk'] = 'Auth/pengguna_klien_induk';
$route['pengguna-klien-induk/create'] = 'Auth/create_klien_induk';
$route['pengguna-klien-induk/edit/(:num)'] = 'Auth/edit_klien_induk/$1';
$route['pengguna-klien-induk/delete/(:num)'] = 'Auth/delete_klien_induk/$1';


//PENGGUNA KLIEN
$route['pengguna-klien'] = 'Auth/pengguna_klien';
$route['pengguna-klien/detail'] = 'Auth/get_detail';
$route['pengguna-klien/ajax-list-klien'] = 'Auth/ajax_list_klien';
$route['pengguna-klien/create-klien'] = 'Auth/create_klien';
$route['pengguna-klien/get-send-email'] = 'Auth/get_send_email';
$route['pengguna-administrator/edit_klien/(:num)'] = 'Auth/edit_klien/$1';
$route['pengguna-administrator/delete_klien'] = 'Auth/delete_klien';

//PENGGUNA SURVEYOR
$route['pengguna-surveyor'] = 'Auth/pengguna_surveyor';
$route['pengguna-surveyor/ajax-list-surveyor'] = 'Auth/ajax_list_surveyor';
$route['data-surveyor/edit-surveyor/(:num)'] = 'DataSurveyorController/edit_surveyor/$1';
$route['pengguna-surveyor/delete-user/(:num)'] = 'Auth/delete_surveyor/$1';

// PAKET
$route['paket'] = 'PaketController/index';
$route['paket/ajax-list'] = 'PaketController/ajax_list';
$route['paket/ajax-add'] = 'PaketController/ajax_add';
$route['paket/ajax-edit/(:num)'] = 'PaketController/ajax_edit/$1';
$route['paket/ajax-update'] = 'PaketController/ajax_update';
$route['paket/ajax-delete/(:num)'] = 'PaketController/ajax_delete/$1';
$route['paket/get-detail'] = 'PaketController/get_detail';
$route['paket/update-status-aktif'] = 'PaketController/update_status_aktif';
$route['paket/update-status-aktif-value'] = 'PaketController/update_status_aktif_value';

$route['paket/trial-ajax-list'] = 'PaketController/trial_ajax_list';
$route['paket/ajax-add-trial'] = 'PaketController/ajax_add_trial';

$route['paket/add'] = 'PaketController/add';
$route['paket/edit/(:num)'] = 'PaketController/edit/$1';
$route['paket/delete/(:num)'] = 'PaketController/delete/$1';

// BERLANGGANAN
$route['berlangganan'] = 'BerlanggananController/index';
$route['berlangganan/data-langganan/(:any)'] = 'BerlanggananController/data_berlangganan/$1';
$route['berlangganan/data-langganan/perpanjangan/(:any)'] = 'BerlanggananController/perpanjangan/$1';
$route['berlangganan/data-langganan/edit-perpanjangan/(:any)'] = 'BerlanggananController/edit_perpanjangan/$1';
$route['berlangganan/data-langganan/delete-perpanjangan/(:any)'] = 'BerlanggananController/delete_perpanjangan/$1';
$route['berlangganan/detail'] = 'BerlanggananController/get_detail';
$route['berlangganan/get-send-email'] = 'BerlanggananController/get_send_email';
$route['berlangganan/get-detail-ajax'] = 'BerlanggananController/get_detail_ajax';

// KRITERIA RESPONDEN
$route['kriteria-responden'] = 'KriteriaRespondenController/index';

// PENGGUNA RESELLER
$route['pengguna-reseller/detail'] = 'PenggunaResellerController/get_detail';

$route['pengguna-reseller'] = 'PenggunaResellerController/index';
$route['pengguna-reseller/ajax-list'] = 'PenggunaResellerController/ajax_list';
$route['pengguna-reseller/add'] = 'PenggunaResellerController/add';
$route['pengguna-reseller/edit/(:num)'] = 'PenggunaResellerController/edit/$1';
$route['pengguna-reseller/delete/(:num)'] = 'PenggunaResellerController/delete/$1';

// PROFILE
$route['profile']             = 'ProfileController/index';
$route['profile/update-profile']     = 'ProfileController/update_profile';
$route['profile/update-foto']             = 'ProfileController/update_foto';

// MANAGE USERS MANAGEMENT
$route['(:any)/users-management'] = 'UsersManagementController/index/$1';
$route['(:any)/users-management/ajax-list'] =  'UsersManagementController/ajax_list/$1';
$route['(:any)/users-management/list-users/(:any)'] = 'UsersManagementController/list_users/$1/$2';
$route['(:any)/users-management/ajax-list-users/(:any)'] = 'UsersManagementController/ajax_list_users/$1/$2';
$route['(:any)/users-management/list-users/(:any)/add'] = 'UsersManagementController/add_list_users/$1/$2';
$route['(:any)/users-management/list-users/(:any)/edit/(:num)'] = 'UsersManagementController/edit_list_users/$1/$2';
$route['(:any)/users-management/list-users/(:any)/delete/(:num)'] = 'UsersManagementController/delete_list_users/$1/$2';

$route['(:any)/ajax-list-division/(:any)'] =  'UsersManagementController/ajax_list_division/$1/$2';
$route['(:any)/add-division'] =  'UsersManagementController/add_division/$1';
$route['(:any)/edit-division'] =  'UsersManagementController/edit_division/$1';
$route['(:any)/delete-division/(:num)'] =  'UsersManagementController/delete_division/$1';

//MANAGE SURVEY
// $route['(:any)'] = 'ManageSurveyController/index';
$route['(:any)/kelola-survei'] = 'ManageSurveyController/index';
$route['(:any)/kelola-survei/ajax-list'] = 'ManageSurveyController/ajax_list';
$route['(:any)/info-berlangganan'] = 'ManageSurveyController/info_berlangganan';
$route['(:any)/info-berlangganan/data-berlangganan'] = 'ManageSurveyController/data_berlangganan';
$route['(:any)/info-berlangganan/data-terakhir-berlangganan'] = 'ManageSurveyController/data_terakhir_berlangganan';
$route['(:any)/info-berlangganan/get-invoice'] = 'ManageSurveyController/get_invoice';
$route['(:any)/manage-survey/create-survey/(:any)'] = 'ManageSurveyController/add/$1';
$route['(:any)/manage-survey/save-survey/(:any)'] = 'ManageSurveyController/create/$1';

$route['(:any)/overview'] = 'ManageSurveyController/profile/$1';
$route['(:any)/overview/list-survey'] = 'ManageSurveyController/get_data_survey/$1';
$route['(:any)/overview/list-activity'] = 'ManageSurveyController/get_data_activity/$1';
$route['(:any)/overview/list-campaign'] = 'ManageSurveyController/get_data_paket/$1';
$route['(:any)/overview/detail-packet'] = 'ManageSurveyController/get_detail_packet/$1';
$route['(:any)/overview/detail-survey'] = 'ManageSurveyController/get_detail_survey/$1';
$route['manage-survey/delete/(:any)'] = 'ManageSurveyController/delete_survey/$1';

//DESKRIPSI
$route['(:any)/(:any)/do'] = 'ManageSurveyController/repository/$1/$2';
$route['(:any)/(:any)/update-repository'] = 'ManageSurveyController/update_repository/$1/$2';
// $route['(:any)/(:any)/do'] = 'ManageSurveyController/deskripsi/$1';

//TAHAPAN PEMBELIAN SURVEI
$route['(:any)/(:any)/tahapan-pembelian'] = 'TahapanPembelianSurveiController/index/$1/$2';
$route['(:any)/(:any)/tahapan-pembelian/ajax-list'] = 'TahapanPembelianSurveiController/ajax_list/$1/$2';
$route['(:any)/(:any)/tahapan-pembelian/edit/(:num)'] = 'TahapanPembelianSurveiController/edit/$1/$2/$3';

//Dimensi SURVEI
$route['(:any)/(:any)/dimensi'] = 'DimensiSurveiController/index/$1/$2';
$route['(:any)/(:any)/dimensi/ajax-list'] = 'DimensiSurveiController/ajax_list/$1/$2';
$route['(:any)/(:any)/dimensi/add'] = 'DimensiSurveiController/add/$1/$2';
$route['(:any)/(:any)/dimensi/detail-edit/(:num)'] = 'DimensiSurveiController/detail_edit/$1/$2/$3';
$route['(:any)/(:any)/dimensi/edit/(:num)'] = 'DimensiSurveiController/edit/$1/$2/$3';
$route['(:any)/(:any)/dimensi/delete/(:num)'] = 'DimensiSurveiController/delete/$1/$2/$3';
$route['(:any)/(:any)/dimensi/konfirmasi'] = 'DimensiSurveiController/konfirmasi/$1/$2';


//PERTANYAAN UNSUR SURVEI
$route['(:any)/(:any)/pertanyaan-unsur'] = 'PertanyaanUnsurSurveiController/index/$1/$2';
$route['(:any)/(:any)/pertanyaan-unsur/ajax-list'] = 'PertanyaanUnsurSurveiController/ajax_list/$1/$2';
$route['(:any)/(:any)/pertanyaan-unsur/add'] = 'PertanyaanUnsurSurveiController/add/$1/$2';
$route['(:any)/(:any)/pertanyaan-unsur/autofill-dimensi/(:num)'] = 'PertanyaanUnsurSurveiController/autofill_dimensi/$1/$2/$3';
$route['(:any)/(:any)/pertanyaan-unsur/edit/(:num)'] = 'PertanyaanUnsurSurveiController/edit/$1/$2/$3';
$route['(:any)/(:any)/pertanyaan-unsur/cari'] = 'PertanyaanUnsurSurveiController/cari/$1/$2';
$route['(:any)/(:any)/pertanyaan-unsur/delete/(:num)'] = 'PertanyaanUnsurSurveiController/delete/$1/$2/$3';

//DATA SURVEYOR SURVEY
$route['(:any)/(:any)/data-surveyor-survei'] = 'DataSurveyorSurveiController/index/$1/$2';
$route['(:any)/(:any)/data-surveyor-survei/ajax-list'] = 'DataSurveyorSurveiController/ajax_list/$1/$2';
$route['(:any)/(:any)/data-surveyor-survei/add'] = 'DataSurveyorSurveiController/add/$1/$2';
$route['(:any)/(:any)/data-surveyor-survei/edit/(:any)'] = 'DataSurveyorSurveiController/edit/$1/$2/$3';
$route['(:any)/(:any)/data-surveyor-survei/delete/(:any)'] = 'DataSurveyorSurveiController/delete/$1/$2/$3';
$route['(:any)/(:any)/data-surveyor-survei/get-kota-kab'] = 'DataSurveyorSurveiController/get_kota_kab/$1/$2';

//PEROLEHAN SURVEYOR
$route['(:any)/(:any)/perolehan-surveyor'] = 'PerolehanSurveyorController/index/$1/$2';
$route['(:any)/(:any)/perolehan-surveyor/ajax-list'] = 'PerolehanSurveyorController/ajax_list/$1/$2';
$route['(:any)/(:any)/perolehan-surveyor/(:any)'] = 'PerolehanSurveyorController/detail/$1/$2/$3';
$route['perolehan-surveyor/get-email'] = 'PerolehanSurveyorController/get_email';
$route['(:any)/(:any)/perolehan-surveyor/delete/(:num)'] = 'PerolehanSurveyorController/delete/$1/$2';
$route['(:any)/(:any)/perolehan-surveyor/ajax-list-detail/(:any)'] = 'PerolehanSurveyorController/ajax_list_detail/$1/$2';

//LINK SURVEY
$route['(:any)/(:any)/link-survei'] = 'LinkSurveiController/index/$1/$2';
$route['(:any)/(:any)/confirm-question'] = 'LinkSurveiController/confirm_question/$1/$2';

//SURVEI
$route['survei/(:any)/link-survei/get-kota-kab'] = 'SurveiController/get_kota_kab/$1/$2';
$route['survei/(:any)'] = 'SurveiController/form_opening/$1';
$route['survei/(:any)/data-responden'] = 'SurveiController/data_responden/$1';
$route['survei/(:any)/add-data-responden'] = 'SurveiController/add_data_responden/$1';
$route['survei/(:any)/pertanyaan/(:any)'] = 'SurveiController/data_pertanyaan/$1/$2';
$route['survei/(:any)/add-pertanyaan/(:any)'] = 'SurveiController/add_pertanyaan/$1/$2';
$route['survei/(:any)/saran/(:any)'] = 'SurveiController/saran/$1/$2';
$route['survei/(:any)/add-saran/(:any)'] = 'SurveiController/add_saran/$1/$2';
$route['survei/(:any)/konfirmasi/(:any)'] = 'SurveiController/konfirmasi/$1/$2';
$route['survei/(:any)/add-konfirmasi/(:any)'] = 'SurveiController/add_konfirmasi/$1/$2';
$route['survei/(:any)/selesai/(:any)'] = 'SurveiController/form_selesai/$1/$2';

$route['survei/(:any)/session-location'] = 'SurveiController/session_location/$1';
$route['survei/(:any)/session-location/(:any)'] = 'SurveiController/session_location/$1/$2';

//EDIT SURVEI
$route['survei/(:any)/data-responden/(:any)/edit'] = 'SurveiController/edit_data_responden/$1/$2';
$route['survei/(:any)/data-responden/(:any)/update'] = 'SurveiController/update_data_responden/$1/$2';
$route['survei/(:any)/pertanyaan/(:any)/edit'] = 'SurveiController/data_pertanyaan/$1/$2';
$route['survei/(:any)/saran/(:any)/edit'] = 'SurveiController/saran/$1/$2';

//PEROLEHAN PER PROVINSI
$route['(:any)/(:any)/rekap-per-wilayah'] = 'RekapPerWilayahController/index/$1/$2';
$route['(:any)/(:any)/rekap-per-wilayah/ajax-list'] = 'RekapPerWilayahController/ajax_list/$1/$2';
$route['(:any)/(:any)/rekap-per-wilayah/detail/(:num)'] = 'RekapPerWilayahController/get_detail/$1/$2/$3';

//SURVEi SURVEYOR
$route['survei/(:any)/(:any)'] = 'SurveiController/form_opening/$1/$2';
$route['survei/(:any)/data-responden/(:any)'] = 'SurveiController/data_responden/$1/$2';
$route['survei/(:any)/add-data-responden/(:any)'] = 'SurveiController/add_data_responden/$1/$';


//SURVEYOR
$route['(:any)/link-survei-surveyor'] = 'LinkSurveiSurveyorController/index/$1';
$route['(:any)/data-perolehan-surveyor'] = 'DataPerolehanSurveyorController/index/$1';
$route['(:any)/data-perolehan-surveyor/ajax-list'] = 'DataPerolehanSurveyorController/ajax_list/$1';
$route['(:any)/data-perolehan-surveyor/export'] = 'DataPerolehanSurveyorController/export/$1';

//HASIL PEROLEHAN SURVEI
$route['(:any)/hasil-survei/(:any)'] = 'HasilSurveiController/hasil/$1/$2';

//PEROLEHAN SURVEI
$route['(:any)/(:any)/data-perolehan-survei'] = 'DataPerolehanSurveiController/index/$1/$2';
$route['(:any)/(:any)/data-perolehan-survei/ajax-list'] = 'DataPerolehanSurveiController/ajax_list/$1/$2';
$route['(:any)/(:any)/data-perolehan-survei/delete/(:num)'] = 'DataPerolehanSurveiController/delete/$1/$2';
$route['(:any)/(:any)/data-perolehan-survei/export'] = 'DataPerolehanSurveiController/export/$1/$2';
$route['(:any)/(:any)/data-perolehan-survei/export-all-pdf'] = 'DataPerolehanSurveiController/export_all_pdf/$1/$2';

// $route['(:any)/(:any)/perolehan-survei'] = 'PerolehanSurveiController/index/$1/$2';
// $route['(:any)/(:any)/perolehan-survei/ajax-list'] = 'PerolehanSurveiController/ajax_list/$1/$2';
// $route['(:any)/(:any)/perolehan-survei/export'] = 'PerolehanSurveiController/export/$1/$2';
// $route['(:any)/(:any)/perolehan-survei/export-all-pdf'] = 'PerolehanSurveiController/export_all_pdf/$1/$2';
// $route['(:any)/(:any)/perolehan-survei/export-filter-pdf'] = 'PerolehanSurveiController/export_filter_pdf/$1/$2';
// $route['(:any)/(:any)/perolehan-survei/delete/(:any)'] = 'PerolehanSurveiController/delete/$1/$2/$3';
// $route['(:any)/(:any)/perolehan-survei/batch-pdf'] = 'PerolehanSurveiController/batch_pdf/$1/$2';
// $route['(:any)/(:any)/perolehan-survei/create-pdf'] = 'PerolehanSurveiController/create_pdf/$1/$2';


//DRAFT KUESIONER
$route['(:any)/(:any)/draft-kuesioner'] = 'DraftKuesionerController/cetak/$1/$2';

//EDIT PROFILE
$route['(:any)/profile']             = 'ProfileController/index/$1';
$route['(:any)/profile/update-profile']     = 'ProfileController/update_profile/$1';
$route['(:any)/profile/update-foto']             = 'ProfileController/update_foto/$1';

//SETTINGS SURVEI
// $route['(:any)/(:any)/setting-survei']             = 'SettingSurveiController/index/$1';
// $route['(:any)/(:any)/setting-survei/form-opening']             = 'SettingSurveiController/form_opening/$1';
$route['(:any)/(:any)/settings/delete'] = 'SettingSurveiController/delete_survey/$1/$2';

// SETTINGS
$route['(:any)/(:any)/settings-question'] = 'SettingSurveiController/settings_question/$1/$2';
$route['(:any)/(:any)/settings'] = 'SettingSurveiController/setting_general/$1/$2';
$route['(:any)/(:any)/setting-pertanyaan'] = 'SettingSurveiController/setting_pertanyaan/$1/$2';
$route['(:any)/(:any)/setting-survei/update-saran'] = 'SettingSurveiController/update_saran/$1/$2';
$route['(:any)/(:any)/setting-survei/update-display'] = 'SettingSurveiController/update_display/$1/$2';
$route['(:any)/(:any)/setting-survei/update-header'] = 'SettingSurveiController/update_header/$1/$2';
$route['(:any)/(:any)/settings/display'] = 'SettingSurveiController/display/$1/$2';
$route['(:any)/(:any)/settings/survey'] = 'SettingSurveiController/index/$1/$2';
$route['(:any)/(:any)/setting-survei/periode'] = 'SettingSurveiController/periode/$1/$2';
$route['(:any)/(:any)/setting-survei/tunda'] = 'SettingSurveiController/tunda/$1/$2';


//OLAH DATA
$route['(:any)/(:any)/olah-data'] = 'OlahDataController/index/$1/$2';
$route['(:any)/(:any)/olah-data/ajax-list'] = 'OlahDataController/ajax_list/$1/$2';

$route['olah-data-per-bagian'] = 'OlahDataPerBagianController/index';
$route['olah-data-per-bagian/ajax-list'] = 'OlahDataPerBagianController/ajax_list';
$route['olah-data-per-bagian/(:any)/(:any)'] = 'OlahDataPerBagianController/detail/$1/$2';
//$route['olah-data/(:any)/(:any)/ajax-detail'] = 'OlahDataPerBagianController/ajax_detail/$1/$2';

//TARGET PROVINSI
$route['(:any)/(:any)/target-per-wilayah'] = 'TargetPerWilayahController/index/$1/$2';
$route['(:any)/(:any)/target-per-wilayah/ajax-list'] = 'TargetPerWilayahController/ajax_list/$1/$2';
$route['(:any)/(:any)/target-per-wilayah/detail/(:num)'] = 'TargetPerWilayahController/get_detail/$1/$2/$3';
$route['(:any)/(:any)/target-per-wilayah/update/(:num)'] = 'TargetPerWilayahController/update_target/$1/$2/$3';
$route['(:any)/(:any)/target-per-wilayah/delete'] = 'TargetPerWilayahController/delete_target/$1/$2';

//TARGET  NASIONAL
$route['(:any)/(:any)/rekap-per-sektor'] = 'RekapPerSektorController/index/$1/$2';

//REKAP RESPONDEN
$route['(:any)/(:any)/rekap-responden'] = 'RekapRespondenController/index/$1/$2';

//CHART
$route['(:any)/(:any)/chart-visualisasi'] = 'ChartVisualisasiController/index/$1/$2';

//REKAP SARAN
$route['(:any)/(:any)/rekap-saran'] = 'RekapSaranController/index/$1/$2';
$route['(:any)/(:any)/rekap-saran/ajax-list'] = 'RekapSaranController/ajax_list/$1/$2';
$route['(:any)/(:any)/rekap-saran/cetak-pdf'] = 'RekapSaranController/cetak_pdf/$1/$2';
$route['(:any)/(:any)/rekap-saran/batch-pdf'] = 'RekapSaranController/batch_pdf/$1/$2';
$route['(:any)/(:any)/rekap-saran/create-pdf'] = 'RekapSaranController/create_pdf/$1/$2';

//TARGET SURVEYOR
$route['(:any)/target-surveyor'] = 'TargetSurveyorController/index/$1/$2';

//REKAP ALASAN
$route['(:any)/(:any)/rekap-alasan'] = 'RekapAlasanController/index/$1/$2';
$route['(:any)/(:any)/rekap-alasan/ajax-list'] = 'RekapAlasanController/ajax_list/$1/$2';
$route['(:any)/(:any)/rekap-alasan/detail/(:num)'] = 'RekapAlasanController/detail/$1/$2';
$route['(:any)/(:any)/rekap-alasan/ajax-list-detail/(:num)'] = 'RekapAlasanController/ajax_list_detail/$1/$2';
$route['(:any)/(:any)/rekap-alasan/cetak'] = 'RekapAlasanController/cetak_pdf/$1/$2';

// SCAN BARCODE
$route['(:any)/(:any)/scan-barcode'] = 'ScanBarcodeController/index/$1/$2';
$route['(:any)/(:any)/scan-barcode/do'] = 'ScanBarcodeController/process/$1/$2';
$route['(:any)/(:any)/scan-barcode/get'] = 'ScanBarcodeController/create_qrcode/$1/$2';
$route['(:any)/(:any)/scan-barcode/download'] = 'ScanBarcodeController/download/$1/$2';
$route['(:any)/(:any)/scan-barcode/clear-data'] = 'ScanBarcodeController/clear_data/$1/$2';

//FORM SURVEI
$route['(:any)/(:any)/form-survei'] = 'FormSurveiController/index/$1/$2';
$route['(:any)/(:any)/form-survei/update-form-target'] = 'FormSurveiController/update_form_target/$1/$2';
$route['(:any)/(:any)/form-survei/update-saran'] = 'FormSurveiController/update_saran/$1/$2';
$route['(:any)/(:any)/form-survei/update-display'] = 'FormSurveiController/update_display/$1/$2';
$route['(:any)/(:any)/form-survei/update-header'] = 'FormSurveiController/update_header/$1/$2';
$route['(:any)/(:any)/form-survei/do-uploud'] = 'FormSurveiController/do_uploud/$1/$2';

$route['(:any)/(:any)/form-survei/opening'] = 'FormSurveiController/form_opening/$1';
$route['(:any)/(:any)/form-survei/data-responden'] = 'FormSurveiController/data_responden/$1/$2';
$route['(:any)/(:any)/form-survei/add-custom-data-responden'] = 'FormSurveiController/add_custom_data_responden/$1/$2';
$route['(:any)/(:any)/form-survei/edit-data-responden/(:num)'] = 'FormSurveiController/edit_data_responden/$1/$2';

$route['(:any)/(:any)/form-survei/pertanyaan'] = 'FormSurveiController/data_pertanyaan/$1/$2';
$route['(:any)/(:any)/form-survei/add-pertanyaan-unsur'] = 'FormSurveiController/add_pertanyaan_unsur/$1/$2';
$route['(:any)/(:any)/form-survei/add-pertanyaan-sub-unsur'] = 'FormSurveiController/add_pertanyaan_sub_unsur/$1/$2';
$route['(:any)/(:any)/form-survei/detail-edit-pertanyaan-unsur/(:num)'] = 'FormSurveiController/get_detail_edit_pertanyaan_unsur/$1/$2';
$route['(:any)/(:any)/form-survei/edit-pertanyaan-unsur/(:num)'] = 'FormSurveiController/edit_pertanyaan_unsur/$1/$2';

$route['(:any)/(:any)/form-survei/pertanyaan-harapan'] = 'FormSurveiController/data_pertanyaan_harapan/$1/$2';
$route['(:any)/(:any)/form-survei/pertanyaan-kualitatif'] = 'FormSurveiController/pertanyaan_kualitatif/$1/$2';
$route['(:any)/(:any)/form-survei/saran'] = 'FormSurveiController/saran/$1/$2';
$route['(:any)/(:any)/form-survei/konfirmasi'] = 'FormSurveiController/form_konfirmasi/$1/$2';
$route['(:any)/(:any)/form-survei/selesai'] = 'FormSurveiController/form_closing/$1//$2';

//PROFIL RESPONDEN SURVEI
$route['(:any)/(:any)/profil-responden-survei'] = 'ProfilRespondenSurveiController/index/$1/$2';
$route['(:any)/(:any)/profil-responden-survei/ajax-list'] = 'ProfilRespondenSurveiController/ajax_list/$1/$2';
$route['(:any)/(:any)/profil-responden-survei/add-default'] = 'ProfilRespondenSurveiController/add_default/$1/$2';
$route['(:any)/(:any)/profil-responden-survei/add-custom'] = 'ProfilRespondenSurveiController/add_custom/$1/$2';
$route['(:any)/(:any)/profil-responden-survei/edit/(:num)'] = 'ProfilRespondenSurveiController/edit/$1/$2';
$route['(:any)/(:any)/profil-responden-survei/delete/(:num)'] = 'ProfilRespondenSurveiController/delete/$1/$2';
$route['(:any)/(:any)/profil-responden-survei/update-urutan'] = 'ProfilRespondenSurveiController/update_urutan/$1/$2';
$route['(:any)/(:any)/profil-responden-survei/konfirmasi'] = 'ProfilRespondenSurveiController/konfirmasi/$1/$2';

//ANALISA-SURVEI SURVEI
$route['(:any)/(:any)/analisa-survei'] = 'AnalisaSurveiController/index/$1/$2';
$route['(:any)/(:any)/analisa-survei/ajax-list'] = 'AnalisaSurveiController/ajax_list/$1/$2';
$route['(:any)/(:any)/analisa-survei/add'] = 'AnalisaSurveiController/add/$1/$2';
$route['(:any)/(:any)/analisa-survei/edit/(:num)'] = 'AnalisaSurveiController/edit/$1/$2';
$route['(:any)/(:any)/analisa-survei/delete/(:num)'] = 'AnalisaSurveiController/delete/$1/$2';
$route['(:any)/(:any)/update-executive-summary'] = 'AnalisaSurveiController/update_executive_summary/$1/$2';


//SERTIFIKAT
$route['(:any)/(:any)/e-sertifikat'] = 'SertifikatController/index/$1/$2';
$route['(:any)/(:any)/e-sertifikat/proses'] = 'SertifikatController/proses/$1/$2';

//SERTIFIKAT INDUK
$route['e-sertifikat-per-bagian'] = 'SertifikatIndukPerBagianController/index';
$route['e-sertifikat-per-bagian/ajax-list'] = 'SertifikatIndukPerBagianController/ajax_list';
$route['e-sertifikat-per-bagian/(:any)/(:any)'] = 'SertifikatIndukPerBagianController/detail/$1/$2';

$route['e-sertifikat-keseluruhan'] = 'SertifikatIndukKeseluruhanController/index';
$route['e-sertifikat-keseluruhan/cetak'] = 'SertifikatIndukKeseluruhanController/cetak';


//PEROLEHAN PER BAGIAN
$route['data-perolehan-per-bagian'] = 'DataPerolehanPerBagianController/index';
$route['data-perolehan-per-bagian/ajax-list'] = 'DataPerolehanPerBagianController/ajax_list';
$route['data-perolehan-per-bagian/(:any)'] = 'DataPerolehanPerBagianController/detail/$1';

//PEROLEHAN KESELURUHAN
$route['data-perolehan-keseluruhan'] = 'DataPerolehanKeseluruhanController/index';
$route['data-perolehan-keseluruhan/ajax-list'] = 'DataPerolehanKeseluruhanController/ajax_list';
$route['data-perolehan-keseluruhan/(:any)/(:num)'] = 'DataPerolehanKeseluruhanController/detail/$1/$2';

// OLAH DATA KESELURUHAN
$route['olah-data-keseluruhan'] = 'OlahDataKeseluruhanController/index';

// //PEROLEHAN PER WILAYAH
// $route['(:any)/(:any)/perolehan-per-wilayah'] = 'PerolehanPerWilayahController/index/$1/$2';
// $route[ '(:any)/(:any)/perolehan-per-wilayah/ajax-list'] = 'PerolehanPerWilayahController/ajax_list/$1/$2';
// $route[ '(:any)/(:any)/perolehan-per-wilayah/detail/(:num)'] = 'PerolehanPerWilayahController/get_detail/$1/$2/$3';

// //PEROLEHAN PER SEKTOR
// $route['(:any)/(:any)/perolehan-per-sektor'] = 'PerolehanPerSektorController/index/$1/$2';

// REKAP HASIL
$route['rekap-hasil-per-bagian'] = 'RekapHasilPerBagianController/index';
$route['rekap-hasil-per-bagian/ajax-list'] = 'RekapHasilPerBagianController/ajax_list';
$route['rekap-hasil-per-bagian/rekap-alasan/(:any)'] = 'RekapHasilPerBagianController/rekap_alasan/$1';
$route['rekap-hasil-per-bagian/ajax-list-rekap-alasan/(:any)'] = 'RekapHasilPerBagianController/ajax_list_rekap_alasan/$1';
$route['rekap-hasil-per-bagian/rekap-alasan/(:any)/(:num)'] = 'RekapHasilPerBagianController/detail_rekap_alasan/$1/$2';
$route['rekap-hasil-per-bagian/rekap-saran/(:any)'] = 'RekapHasilPerBagianController/rekap_saran/$1';


// REKAP HASIL
$route['rekap-hasil-keseluruhan'] = 'RekapHasilKeseluruhanController/index';
$route['rekap-hasil-keseluruhan/ajax-list/(:any)'] = 'RekapHasilKeseluruhanController/ajax_list/$1';
$route['rekap-hasil-keseluruhan/rekap-alasan/(:num)'] = 'RekapHasilKeseluruhanController/detail_rekap_alasan/$1';
$route['rekap-hasil-keseluruhan/ajax-list-rekap-alasan/(:num)'] = 'RekapHasilKeseluruhanController/ajax_list_rekap_alasan/$1';
$route['rekap-hasil-keseluruhan/ajax-list-rekap-saran'] = 'RekapHasilKeseluruhanController/ajax_list_rekap_saran';
$route['rekap-hasil-keseluruhan/cetak-alasan'] = 'RekapHasilKeseluruhanController/cetak_alasan';
$route['rekap-hasil-keseluruhan/cetak-saran'] = 'RekapHasilKeseluruhanController/cetak_saran';


//TARGET KESELURUHAN
$route['target-keseluruhan'] = 'TargetKeseluruhanController/index';


//TARGET PER BAGIAN
$route['target-per-bagian'] = 'TargetPerBagianController/index';
$route['target-per-bagian/ajax-list'] = 'TargetPerBagianController/ajax_list';
$route['target-per-bagian/(:any)'] = 'TargetPerBagianController/detail/$1';


//NILAI INDEK SEKTOR
$route['(:any)/(:any)/nilai-index-sektor'] = 'NilaiIndexSektorController/index/$1/$2';
$route['(:any)/(:any)/nilai-index-sektor/(:num)'] = 'NilaiIndexSektorController/detail/$1/$2';

//NILAI INDEK KESELURUHAN
$route['nilai-index-keseluruhan'] = 'NilaiIndexKeseluruhanController/index';
$route['nilai-index-keseluruhan/(:num)'] = 'NilaiIndexKeseluruhanController/detail/$1';
$route['nilai-index-keseluruhan/ajax-list/(:num)'] = 'NilaiIndexKeseluruhanController/ajax_list/$1/$2';
$route['nilai-index-keseluruhan/(:num)/(:num)'] = 'NilaiIndexKeseluruhanController/tabulasi/$1/$2';



//NILAI INDEK PER BAGIAN
$route['nilai-index-bagian'] = 'NilaiIndexBagianController/index';
$route['nilai-index-bagian/ajax-list'] = 'NilaiIndexBagianController/ajax_list';
//$route['nilai-index-bagian/ajax-list-sektor'] = 'NilaiIndexBagianController/ajax_list_sektor';
//$route['nilai-index-bagian/(:any)/(:any)'] = 'NilaiIndexBagianController/detail/$1/$2';
$route['nilai-index-bagian/(:any)/(:num)'] = 'NilaiIndexBagianController/detail_modal/$1';
$route['nilai-index-bagian/(:any)'] = 'NilaiIndexBagianController/detail/$1';

$route['inject-pertanyaan'] = 'InjectPertanyaanController/index';
$route['inject-pertanyaan/get'] = 'InjectPertanyaanController/get';


//MENU UNTUK SUPERVISOR
$route['(:any)/dashboard-chart-online'] = 'DataSurveiSPVController/dashboard_chart/$1';

$route['(:any)/(:any)/data-perolehan-online'] = 'DataSurveiSPVController/perolehan/$1/$2';
$route['(:any)/(:any)/data-perolehan-online/ajax-list'] = 'DataPerolehanSurveiController/ajax_list/$1/$2';

$route['(:any)/(:any)/olah-data-online'] = 'DataSurveiSPVController/olah_data/$1/$2';
$route['(:any)/(:any)/olah-data-online/ajax-list'] = 'OlahDataController/ajax_list/$1/$2';

$route['(:any)/(:any)/nilai-per-sektor-online'] = 'DataSurveiSPVController/nilai_per_sektor/$1/$2';
$route['(:any)/(:any)/rekap-responden-online'] = 'DataSurveiSPVController/rekap_responden/$1/$2';
$route['(:any)/(:any)/chart-visualisasi-online'] = 'DataSurveiSPVController/chart_visualisasi/$1/$2';

$route['(:any)/(:any)/rekap-per-wilayah-online'] = 'DataSurveiSPVController/rekap_per_wilayah/$1/$2';
$route['(:any)/(:any)/rekap-per-sektor-online'] = 'DataSurveiSPVController/rekap_per_sektor/$1/$2';

$route['(:any)/(:any)/rekap-alasan-online'] = 'DataSurveiSPVController/rekap_alasan/$1/$2';
$route['(:any)/(:any)/rekap-saran-online'] = 'DataSurveiSPVController/rekap_saran/$1/$2';
$route['(:any)/(:any)/rekap-saran-online/ajax-list'] = 'RekapSaranController/ajax_list/$1/$2';

