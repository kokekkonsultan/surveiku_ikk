<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Saran</title>
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
    <div style="text-align:justify; width:75%; font-family:Arial, Helvetica, sans-serif;">

        <?php if ($user->foto_profile == NULL) : ?>
        <img src="<?php echo base_url(); ?>assets/klien/foto_profile/200px.jpg" width="70" height="70" alt=""
            style="float:left; margin:0px 8px 8px 10px;">
        <?php else : ?>
        <img src="<?php echo base_url(); ?>assets/klien/foto_profile/<?php echo $user->foto_profile ?>" width="70"
            height="70" alt="" style="float:left; margin:0px 8px 8px 10px;">
        <?php endif; ?>

        <div style="margin: auto; padding: 9px;">

            <div style="font-size: 13px; font-weight:bold;">SURVEI INDEKS KEBERDAYAAN KONSUMEN</div>
            <div style="font-size: 10px;"><?php echo $manage_survey->title_header_survey ?></div>
        </div>

    </div>
    <hr>
    <br>
    <div
        style="font-weight: bold; font-size:16px; width:100%; text-align:center; font-family:Arial, Helvetica, sans-serif">
        <ins>REKAP SARAN RESPONDEN</ins>
    </div>

    <br><br>

    <table style="width: 100%;">
        <tr style="text-align:center; font-size: 12px; background-color: #E4E6EF; font-weight:bold;">
            <td width="5%">No</td>
            <td>Nama Responden</td>
            <td>Barang Jasa</td>
            <td>Saran</td>
        </tr>

        <?php  
        $no = $first_number;
        foreach ($arr as $value) {

            $value = (integer) $value;

        ?>

        <tr style="font-size: 12px;">
            <td width="5%" style="text-align:center;"><?php echo $no ?></td>
            <td><?php echo $collection[$value]['nama_lengkap'] ?></td>
            <td><?php echo $collection[$value]['alias_barang_jasa'] ?></td>
            <td><?php echo $collection[$value]['saran'] ?></td>
            </td>
        </tr>
            
        <?php
            $no++;
        }
        ?>



    </table>

</body>

</html>