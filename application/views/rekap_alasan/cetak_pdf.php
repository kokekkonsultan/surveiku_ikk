<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Alasan - <?php echo $manage_survey->survey_name ?></title>
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
    </style>
</head>

<body>
    <table style="width: 100%; border: 0px;">
        <tr style="border: 10px;">
            <td width="10%" style="border: 10px; padding-left: 8px;">
                <?php if ($user->foto_profile == NULL) : ?>
                <img src="<?php echo base_url() ?>assets/klien/foto_profile/200px.jpg" height="60" alt="">
                <?php else : ?>
                <img src="<?php echo base_url(); ?>assets/klien/foto_profile/<?php echo $user->foto_profile ?>"
                    height="60" alt="">
                <?php endif; ?>
            </td>
            <td class="text-right" style="border: 10px;">

                <div style="font-size:13px; font-weight:bold; padding-left: 8px;">
                    <?php
                    $title_header = unserialize($manage_survey->title_header_survey);
                    $title_1 = $title_header[0];
                    $title_2 = $title_header[1];
                    ?>
                    <?php echo $title_1 ?><br><?php echo $title_2 ?>
                </div>
            </td>
        </tr>
    </table>
    <hr>
    <br>
    <div
        style="font-weight: bold; font-size:16px; width:100%; text-align:center; font-family:Arial, Helvetica, sans-serif">
        <ins>REKAP ALASAN JAWABAN</ins>
    </div>


    <ol style="font-size: 13px;">
        <?php foreach ($pertanyaan->result() as $row) { ?>

        <li> <?php echo str_replace("16px", "12px", $row->isi_pertanyaan) ?>
            <p>
            <table width="100%" style="font-family: Times New Roman; font-size: 12px;">
                <tr style="text-align:center; background-color:#E4E6EF;">
                    <td width="4%">No</td>
                    <td>Nama Responden</td>
                    <td width="20%">Pilihan Jawaban</td>
                    <td>Alasan Jawaban</td>
                </tr>

                <?php
                            $no = 1;
                            foreach ($alasan as $value) { ?>

                <?php if ($value->id_pertanyaan_unsur == $row->id) { ?>
                <tr>
                    <td style="text-align:center;"><?php echo $no++ ?></td>
                    <td><?php echo $value->nama_lengkap ?></td>
                    <td><?php echo $value->bobot ?></td>
                    <td><?php echo $value->alasan_pilih_jawaban ?></td>
                </tr>
                <?php } ?>

                <?php } ?>
            </table>
            </p>
        </li>
        <br>
        <br>

        <?php } ?>
    </ol>

</body>

</html>