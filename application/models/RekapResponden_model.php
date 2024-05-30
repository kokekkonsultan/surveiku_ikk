<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RekapResponden_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function _profile_responden($id_klasifikasi_survey)
    {
        $query = $this->db->query("SELECT *, (SELECT profil_responden_kuesioner.id_master_profil_responden_kuesioner FROM profil_responden_kuesioner WHERE profil_responden_kuesioner.id_master_profil_responden_kuesioner = 1 && profil_responden_kuesioner.id_klasifikasi_survey = klasifikasi_survey.id && is_active = 1) AS profil_1, 
		(SELECT profil_responden_kuesioner.id_master_profil_responden_kuesioner FROM profil_responden_kuesioner WHERE profil_responden_kuesioner.id_master_profil_responden_kuesioner = 2 && profil_responden_kuesioner.id_klasifikasi_survey = klasifikasi_survey.id && is_active = 1) AS profil_2,
		(SELECT profil_responden_kuesioner.id_master_profil_responden_kuesioner FROM profil_responden_kuesioner WHERE profil_responden_kuesioner.id_master_profil_responden_kuesioner = 3 && profil_responden_kuesioner.id_klasifikasi_survey = klasifikasi_survey.id && is_active = 1) AS profil_3,		
		(SELECT profil_responden_kuesioner.id_master_profil_responden_kuesioner FROM profil_responden_kuesioner WHERE profil_responden_kuesioner.id_master_profil_responden_kuesioner = 4 && profil_responden_kuesioner.id_klasifikasi_survey = klasifikasi_survey.id && is_active = 1) AS profil_4,		
		(SELECT profil_responden_kuesioner.id_master_profil_responden_kuesioner FROM profil_responden_kuesioner WHERE profil_responden_kuesioner.id_master_profil_responden_kuesioner = 5 && profil_responden_kuesioner.id_klasifikasi_survey = klasifikasi_survey.id && is_active = 1) AS profil_5		
		FROM klasifikasi_survey
		WHERE klasifikasi_survey.id = $id_klasifikasi_survey");
        return $query;
    }

    public function _jenis_kelamin($table_identity)
    {
        $data_jenis_kelamin = $this->db->query("SELECT 'Jenis Kelamin' AS karakteristik, jenis_kelamin_responden AS kelompok,
        (SELECT COUNT(*) FROM responden_$table_identity JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden WHERE is_submit = 1 && id_jenis_kelamin = jenis_kelamin.id) AS jumlah,
        (ROUND((SELECT COUNT(*) FROM responden_$table_identity JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden WHERE is_submit = 1 && id_jenis_kelamin = jenis_kelamin.id) / ( SELECT COUNT(*) FROM responden_$table_identity JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden  WHERE is_submit = 1 ) * 100, 2)) AS persentase,
        (SELECT COUNT(*) FROM responden_$table_identity JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden WHERE is_submit = 1) AS total,
        '' AS total_pesentase
        FROM jenis_kelamin ");
        return $data_jenis_kelamin;
    }

    public function _umur($table_identity)
    {
        $data_jenis_umur = $this->db->query("SELECT 'Umur' AS karakteristik, umur_responden AS kelompok,
        (SELECT COUNT(*) FROM responden_$table_identity JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden WHERE is_submit = 1 && id_umur = umur.id ) AS jumlah,
        ( ROUND((SELECT COUNT(*) FROM responden_$table_identity JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden WHERE is_submit = 1 && id_umur = umur.id) / ( SELECT COUNT(*) FROM responden_$table_identity JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden WHERE is_submit = 1) * 100, 2) ) AS persentase,
        ( SELECT COUNT(*) FROM responden_$table_identity JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden WHERE is_submit = 1) AS total,
        '' AS total_pesentase FROM umur");
        return $data_jenis_umur;
    }

    public function _pendidikan_akhir($table_identity)
    {
        $data_pendidikan_akhir = $this->db->query("SELECT 'Pendidikan Akhir' AS karakteristik, pendidikan_akhir_responden AS kelompok, ( SELECT COUNT(*) FROM responden_$table_identity JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden WHERE is_submit = 1 && id_pendidikan_akhir = pendidikan_akhir.id ) AS jumlah, ( ROUND((SELECT COUNT(*) FROM responden_$table_identity JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden WHERE is_submit = 1 && id_pendidikan_akhir = pendidikan_akhir.id) / ( SELECT COUNT(*) FROM responden_$table_identity JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden WHERE is_submit = 1) * 100, 2) ) AS persentase, ( SELECT COUNT(*) FROM responden_$table_identity JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden WHERE is_submit = 1) AS total,
        '' AS total_pesentase FROM pendidikan_akhir");
        return $data_pendidikan_akhir;
    }

    public function _pekerjaan_utama($table_identity)
    {
        $data_pekerjaan_utama = $this->db->query("SELECT 'Pekerjaan Utama' AS karakteristik, pekerjaan_utama_responden AS kelompok,
		( SELECT COUNT(*) FROM responden_$table_identity JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden WHERE is_submit = 1 && id_pekerjaan_utama = pekerjaan_utama.id ) AS jumlah, ( ROUND((SELECT COUNT(*) FROM responden_$table_identity JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden WHERE is_submit = 1 && id_pekerjaan_utama = pekerjaan_utama.id) / ( SELECT COUNT(*) FROM responden_$table_identity JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden WHERE is_submit = 1) * 100, 2) ) AS persentase, ( SELECT COUNT(*) FROM responden_$table_identity JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden WHERE is_submit = 1) AS total,
		'' AS total_pesentase FROM pekerjaan_utama");
        return $data_pekerjaan_utama;
    }

    public function _pendapatan_per_bulan($table_identity)
    {
        $data_pendapatan_per_bulan = $this->db->query("SELECT 'Pendapatan Per Bulan' AS karakteristik, pendapatan_per_bulan_responden AS kelompok, ( SELECT COUNT(*) FROM responden_$table_identity JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden WHERE is_submit = 1 && id_pendapatan_per_bulan = pendapatan_per_bulan.id ) AS jumlah, ( ROUND((SELECT COUNT(*) FROM responden_$table_identity JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden WHERE is_submit = 1 && id_pendapatan_per_bulan = pendapatan_per_bulan.id) / ( SELECT COUNT(*) FROM responden_$table_identity JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden WHERE is_submit = 1) * 100, 2) ) AS persentase, ( SELECT COUNT(*) FROM responden_$table_identity JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden WHERE is_submit = 1) AS total, '' AS total_pesentase FROM pendapatan_per_bulan");
        return $data_pendapatan_per_bulan;
    }
}