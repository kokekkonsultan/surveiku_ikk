<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Survei_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function dropdown_kota_kab()
    {
        $query = $this->db->get('kota_kab_indonesia');

        if ($query->num_rows() > 0) {

            $dd[''] = 'Pilih Kota / Kabupaten Sesuai Domisili Anda Saat Ini';
            foreach ($query->result_array() as $row) {
                $dd[$row['id']] = $row['nama_kota_kab_indonesia'];
            }

            return $dd;
        }
    }


    // public function dropdown_umur()
    // {
    //     $query = $this->db->get('umur');

    //     if ($query->num_rows() > 0) {

    //         $dd[''] = 'Pilih umur anda';
    //         foreach ($query->result_array() as $row) {
    //             $dd[$row['id']] = $row['umur_responden'];
    //         }

    //         return $dd;
    //     }
    // }

    // public function dropdown_jenis_kelamin()
    // {
    //     $query = $this->db->get('jenis_kelamin');

    //     if ($query->num_rows() > 0) {

    //         $dd[''] = 'Pilih Jenis Kelamin';
    //         foreach ($query->result_array() as $row) {
    //             $dd[$row['id']] = $row['jenis_kelamin_responden'];
    //         }

    //         return $dd;
    //     }
    // }

    // public function dropdown_pendidikan_akhir()
    // {
    //     $query = $this->db->get('pendidikan_akhir');

    //     if ($query->num_rows() > 0) {

    //         $dd[''] = 'Pilih pendidikan terakhir anda';
    //         foreach ($query->result_array() as $row) {
    //             $dd[$row['id']] = $row['pendidikan_akhir_responden'];
    //         }

    //         return $dd;
    //     }
    // }

    // public function get_all_pekerjaan_utama()
    // {
    //     $query = $this->db->query("SELECT *
    //                                 FROM `pekerjaan_utama`");
    //     return $query->result();
    // }

    // public function dropdown_pendapatan_per_bulan()
    // {
    //     $query = $this->db->get('pendapatan_per_bulan');

    //     if ($query->num_rows() > 0) {

    //         $dd[''] = 'Pilih Pendapatan Per Bulan Pekerjaan Anda';
    //         foreach ($query->result_array() as $row) {
    //             $dd[$row['id']] = $row['pendapatan_per_bulan_responden'];
    //         }

    //         return $dd;
    //     }
    // }

    // public function dropdown_barang_jasa()
    // {
    //     $query = $this->db->get('barang_jasa');

    //     if ($query->num_rows() > 0) {

    //         $dd[''] = 'Pilih Barang atau Jasa Yang Anda Gunakan';
    //         foreach ($query->result_array() as $row) {
    //             $dd[$row['id']] = $row['alias_barang_jasa'];
    //         }

    //         return $dd;
    //     }
    // }

    // public function dropdown_kota_kab($id_provinsi_indonesia)
    // {
    //     $query = $this->db->get_where('kota_kab_indonesia', array('id_provinsi_indonesia' => $id_provinsi_indonesia));

    //     if ($query->num_rows() > 0) {

    //         $dd[''] = 'Pilih Kota Kabupaten Anda';
    //         foreach ($query->result_array() as $row) {
    //             $dd[$row['id']] = $row['nama_kota_kab_indonesia'];
    //         }

    //         return $dd;
    //     }
    // }

    // public function dropdown_lokasi_tinggal()
    // {
    //     $query = $this->db->get('lokasi');

    //     if ($query->num_rows() > 0) {

    //         $dd[''] = 'Please Select';
    //         foreach ($query->result_array() as $row) {
    //             $dd[$row['id']] = $row['nama_lokasi'];
    //         }

    //         return $dd;
    //     }
    // }

    // public function get_manage_survei($data)
    // {
    //     $query = $this->db->query("SELECT *
    //                                 FROM `manage_survey`
    //                                 WHERE slug = '$data'");
    //     return $query->result();
    // }

    // public function pertanyaan($id_jenis_pelayanan)
    // {
    //     $query = $this->db->query("SELECT pertanyaan_unsur_pelayanan.id AS id_pertanyaan_unsur, unsur_pelayanan.id AS id_unsur_pelayanan,
    //                                 IF(unsur_pelayanan.is_sub_unsur_pelayanan = 2, SUBSTRING(nama_unsur_pelayanan, 1, 2), SUBSTRING(nama_unsur_pelayanan, 1, 4)) AS Nomor,

    //                                 pertanyaan_unsur_pelayanan.isi_pertanyaan_unsur, unsur_pelayanan.jumlah_pilihan_jawaban,

    //                                 ( SELECT kategori_unsur_pelayanan.nama_kategori_unsur_pelayanan FROM kategori_unsur_pelayanan WHERE kategori_unsur_pelayanan.nomor_kategori_unsur_pelayanan = 1 AND kategori_unsur_pelayanan.id_pertanyaan_unsur = pertanyaan_unsur_pelayanan.id ) AS pilihan_1,

    //                                 ( SELECT kategori_unsur_pelayanan.nama_kategori_unsur_pelayanan FROM kategori_unsur_pelayanan WHERE kategori_unsur_pelayanan.nomor_kategori_unsur_pelayanan = 2 AND kategori_unsur_pelayanan.id_pertanyaan_unsur = pertanyaan_unsur_pelayanan.id ) AS pilihan_2,

    //                                 ( SELECT kategori_unsur_pelayanan.nama_kategori_unsur_pelayanan FROM kategori_unsur_pelayanan WHERE kategori_unsur_pelayanan.nomor_kategori_unsur_pelayanan = 3 AND kategori_unsur_pelayanan.id_pertanyaan_unsur = pertanyaan_unsur_pelayanan.id ) AS pilihan_3,

    //                                 ( SELECT kategori_unsur_pelayanan.nama_kategori_unsur_pelayanan FROM kategori_unsur_pelayanan WHERE kategori_unsur_pelayanan.nomor_kategori_unsur_pelayanan = 4 AND kategori_unsur_pelayanan.id_pertanyaan_unsur = pertanyaan_unsur_pelayanan.id ) AS pilihan_4

    //                             FROM pertanyaan_unsur_pelayanan
    //                             JOIN unsur_pelayanan ON unsur_pelayanan.id = pertanyaan_unsur_pelayanan.id_unsur_pelayanan
    //                             JOIN jenis_pelayanan ON jenis_pelayanan.id = unsur_pelayanan.id_jenis_pelayanan
    //                             WHERE jenis_pelayanan.id = $id_jenis_pelayanan
    //                             ORDER BY pertanyaan_unsur_pelayanan.id ASC");
    //     return $query->result();
    // }

    // public function get_data_responden_edit($id_manage_survey, $uuid_responden)
    // {
    //     $this->db->select("*, responden_$id_manage_survey.uuid AS uuid_responden");
    //     $this->db->from("responden_$id_manage_survey");
    //     $this->db->join("survey_$id_manage_survey", "responden_$id_manage_survey.id = survey_$id_manage_survey.id_responden");
    //     $this->db->join("barang_jasa", "responden_$id_manage_survey.id_barang_jasa = barang_jasa.id");
    //     $this->db->join("jenis_kelamin", "responden_$id_manage_survey.id_jenis_kelamin = jenis_kelamin.id");
    //     $this->db->join("umur", "responden_$id_manage_survey.id_umur = umur.id");
    //     $this->db->join("pendidikan_akhir", "responden_$id_manage_survey.id_pendidikan_akhir = pendidikan_akhir.id");
    //     $this->db->join("pekerjaan_utama", "responden_$id_manage_survey.id_pekerjaan_utama = pekerjaan_utama.id");
    //     $this->db->join("pendapatan_per_bulan", "responden_$id_manage_survey.id_pendapatan_per_bulan = pendapatan_per_bulan.id");
    //     $this->db->join("kota_kab_indonesia", "responden_$id_manage_survey.id_kota_kab_indonesia = kota_kab_indonesia.id");
    //     $this->db->join("provinsi_indonesia", "kota_kab_indonesia.id_provinsi_indonesia = provinsi_indonesia.id");
    //     $this->db->where("responden_$id_manage_survey.uuid = '$uuid_responden'");
    //     $query = $this->db->get();
    //     return $query;
    // }
}
