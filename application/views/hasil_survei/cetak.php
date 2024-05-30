<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <title>Hasil Survei -- <?php echo $responden->nama_lengkap ?></title> -->
    <style>
    table {
        border-collapse: collapse;
        font-family: sans-serif;
        font-size: .8rem;
    }

    table,
    th,
    td {
        border: 1px solid black;
    }

    th,
    td {
        padding: 3px;
    }

    header {
        position: fixed;
    }

    td {
        font-size: 11px;
    }
    </style>
</head>

<body>
    <table style="width: 100%;">
        <tr>

            <td width="50%" style="border: 10px; padding-left: 8px;">
                <table style="width: 100%; border: 10px;">
                    <tr style="border: 10px;">
                        <td width="10%" style="border: 10px; padding-left: 8px;">
                            <?php if ($data_user->foto_profile == '') { ?>
                            <img src="<?php echo base_url() ?>assets/klien/foto_profile/200px.jpg" height="60" alt="">
                            <?php } else { ?>
                            <img src="<?php echo base_url(); ?>assets/klien/foto_profile/<?php echo $data_user->foto_profile ?>"
                                height="60" alt="">
                            <?php } ?>
                        </td>
                        <td class="text-right" style="border: 10px;">

                            <div style="font-size:13px; font-weight:bold; padding-left: 8px;">
                                <?php
                                $title_header = unserialize($manage_survey->title_header_survey);
                                $title_1 = strtoupper($title_header[0]);
                                $title_2 = strtoupper($title_header[1]);
                                ?>
                                <?php echo $title_1 ?><br><?php echo $title_2 ?>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
            <!-- <td width="50%">
                <div style="font-weight:bold; margin: auto; padding: 10px;  font-size:15px; text-align: center;"> SURVEI
                    INDEKS KEBERDAYAAN KONSUMEN</div>
            </td> -->
        </tr>
    </table>


    <table style="width: 100%;">
        <tr>
            <td style="text-align:center; font-size: 11px; font-family:Arial, Helvetica, sans-serif;">Dalam rangka
                meningkatkan pemberdayaan konsumen, Saudara dipercaya
                menjadi responden pada kegiatan
                survei ini.<br>
                Atas kesediaan Saudara kami sampaikan terima kasih dan penghargaan sedalam-dalamnya.</td>
        </tr>
    </table>

    <table style="width: 100%;">
        <tr>
            <td colspan="2"
                style="text-align:left; font-size: 11px; background-color: black; color:white; height:15px;">
                DATA RESPONDEN
            </td>
        </tr>

        <!-- MEMANGGIL DATA PROFIL RESPONDEN YANG DIBUAT -->
        <?php foreach ($profil_responden as $value) {
            $isi_profil = $value->nama_alias;
            ?>
        <tr style="font-size: 11px;">
            <td width=" 30%" style="height:15px;"><?php echo $value->nama_profil_responden ?></td>
            <td width="70%" style="height:15px;"><?php echo $responden->$isi_profil ?></td>
        </tr>
        <?php } ?>

        <tr style="font-size: 11px;">
            <td width=" 30%" style="height:15px;">Waktu Isi Survei</td>
            <td width="70%"> <?php echo date("d-m-Y", strtotime($responden->waktu_isi)) ?></td>
        </tr>
    </table>

    <table style="width: 100%;">
        <tr>
            <td colspan="2" style="text-align:left; font-size: 11px; background-color: black; color:white;">
                PENILAIAN TERHADAP UNSUR-UNSUR KEBERDAYAAN KONSUMEN (isi kolom dengan tanda "X" sesuai jawaban Saudara)
            </td>
        </tr>
    </table>

    <table width="100%" style="font-size: 11px; text-align:center; background-color:#C7C6C1">
        <tr>
            <td rowspan="2" width="4%">No</td>
            <td rowspan="2" width="32%">PERTANYAAN</td>
            <td colspan="5" width="40%">PILIHAN JAWABAN</td>
            <td rowspan="2" width="24%">Berikan alasan jika pilihan jawaban: 1 atau 2
            </td>
        </tr>
        <tr>
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td>4</td>
            <td>5</td>
        </tr>
    </table>


    
    <!-- PERTANYAAN UNSUR -->
    <table style="width: 100%;">
        <?php foreach ($tahapan_pembelian->result() as $row) { ?>
        <tr>
            <td colspan="8" style="text-align:left; font-size: 11px; background-color: black; color:white;">
                <?php echo $row->kode_tahapan_pembelian ?>. <?php echo $row->nama_tahapan_pembelian ?>
            </td>
        </tr>

        <?php foreach ($dimensi->result() as $value) { ?>
        <?php if ($value->id_tahapan_pembelian == $row->id) : ?>
        <tr>
            <td width="4%" style="text-align:center; font-size: 11px;">
                <b><?php echo $value->kode_dimensi ?></b>
            </td>
            <td colspan="7" style="text-align:left; font-size: 11px;">
                <b><?php echo $value->nama_dimensi ?></b>
            </td>
        </tr>

        <?php foreach ($pertanyaan_unsur->result() as $get) { ?>
        <?php if ($get->id_dimensi == $value->id) : ?>
        <tr>
            <td rowspan="2" width="4%" style="text-align:center; font-size: 11px;">
                <?php echo $get->kode_unsur ?>
            </td>
            <td width="32%" rowspan="2" style="text-align:left; font-size: 11px;">
                <?php echo str_replace("16px", "11px", $get->isi_pertanyaan) ?>
            </td>

            <td width="8%" style="background-color:#C7C6C1; text-align:center; font-size: 11px;">
                <?php echo $get->jawaban_1 ?>
            </td>
            <td width="8%" style="background-color:#C7C6C1; text-align:center; font-size: 11px;">
                <?php echo $get->jawaban_2 ?>
            </td>
            <td width="8%" style="background-color:#C7C6C1; text-align:center; font-size: 11px;">
                <?php echo $get->jawaban_3 ?>
            </td>
            <td width="8%" style="background-color:#C7C6C1; text-align:center; font-size: 11px;">
                <?php echo $get->jawaban_4 ?>
            </td>
            <td width="8%" style="background-color:#C7C6C1; text-align:center; font-size: 11px;">
                <?php echo $get->jawaban_5 ?>
            </td>
            <td width="24%" rowspan="2" style="text-align:left; font-size: 11px;">
                <?php echo $get->alasan_pilih_jawaban ?></td>
        </tr>

        <?php if ($get->skor_jawaban == 1) { ?>
        <tr>
            <th>X</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <?php } else if ($get->skor_jawaban == 2) { ?>
        <tr>
            <th></th>
            <th>X</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <?php } else if ($get->skor_jawaban == 3) { ?>
        <tr>
            <th></th>
            <th></th>
            <th>X</th>
            <th></th>
            <th></th>
        </tr>
        <?php } else if ($get->skor_jawaban == 4) { ?>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th>X</th>
            <th></th>
        </tr>
        <?php } else if ($get->skor_jawaban == 5) { ?>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>X</th>
        </tr>
        <?php } else { ?>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <?php }  ?>
        <?php endif; ?>
        <?php } ?>
        <?php endif; ?>
        <?php } ?>
        <?php } ?>
    </table>

    


    <!-- PERTANYAAN TERBUKA -->
    <?php if($pertanyaan_terbuka->num_rows() > 0) { ?>
    <table width="100%" style="font-size: 11px; text-align:center; background-color:#C7C6C1">
        <tr>
            <td colspan="8" style="text-align:left; font-size: 11px; background-color: black; color:white;">PERTANYAAN TEBUKA</td>
        </tr>
    </table>
    

    <?php foreach($pertanyaan_terbuka->result() as $i => $val){
        $kategori_terbuka[$i] = $this->db->get_where("kategori_pertanyaan_terbuka_$manage_survey->table_identity", ['id_pertanyaan_terbuka' => $val->id]);
    ?>

    <table style="width: 100%;">
        <tr>
            <td rowspan="<?= $kategori_terbuka[$i]->num_rows() + 1 ?>" width="4%" align="center"><?= $val->nomor_pertanyaan_terbuka ?></td>
            <td rowspan="<?= $kategori_terbuka[$i]->num_rows() + 1 ?>" width="32%"><?= $val->isi_pertanyaan_terbuka ?></td>
            <td width="64%" colspan="2"></td>
        </tr>
        
        <?php foreach($kategori_terbuka[$i]->result() as $get) {
            $jawaban_t[$i] = $get->nama_kategori_pertanyaan_terbuka == $val->jawaban ? 'X' : '';
        ?>
        <tr>
            <th width="5%"><?= $jawaban_t[$i] ?></th>
            <td width="60%" style="background-color:#C7C6C1;"><?= $get->nama_kategori_pertanyaan_terbuka ?></td>
        </tr>
        <?php } ?>

    </table>

    <?php } ?>
    <?php } ?>




    <table width="100%" style="font-size: 11px; text-align:center;">
        <tr>
            <td colspan="7" style="text-align:left;">
                <b>SARAN :</b> <br /><br />
                <?php echo $responden->saran ?>
                <br><br>
            </td>
        </tr>
        <tr>
            <td colspan="7" style="text-align:center;">
                Terima kasih atas kesediaan Saudara mengisi kuesioner tersebut di atas.<br>
                Saran dan penilaian Saudara memberikan konstribusi yang sangat berarti bagi peningkatan keberdayaan
                konsumen.
            </td>
        </tr>
    </table>
</body>

</html>