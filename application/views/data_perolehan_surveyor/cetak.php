<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak</title>
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
            padding: 10px;
            font-size: 12px;
            font-family: 'Times New Roman', Times, serif;
        }
    </style>
</head>

<body>

    <div style="overflow-x:auto;">
        <table class="table table-bordered table-hover" cellspacing="0" width="100%">
            <thead>
                <tr style="background-color: yellow; text-align:center; ">
                    <td colspan="53" style="font-size: 20px; font-weight:bold;">
                        DATA PEROLEHAN SURVEY
                    </td>
                </tr>
                <tr style="background-color: #f2f2f2;">
                    <th>N0.</th>
                    <th>STATUS PENGISIAN</th>
                    <th>KODE SURVEYOR</th>
                    <th>NAMA SURVEYOR</th>
                    <th>PROVINSI</th>
                    <th>KOTA/KABUPATEN</th>
                    <th>BARANG/ JASA</th>
                    <th>NAMA</th>
                    <th>NO. HP</th>
                    <th>JENIS KELAMIN</th>
                    <th>UMUR</th>
                    <th>PENDIDIKAN TERAKHIR</th>
                    <th>PEKERJAAN UTAMA</th>
                    <th>PENDAPATAN PER BULAN</th>
                    <th>U1</th>
                    <th>U2</th>
                    <th>U3</th>
                    <th>U4</th>
                    <th>U5</th>
                    <th>U6</th>
                    <th>U7</th>
                    <th>U8</th>
                    <th>U9</th>
                    <th>U10</th>
                    <th>U11</th>
                    <th>U12</th>
                    <th>U13</th>
                    <th>U14</th>
                    <th>U15</th>
                    <th>U16</th>
                    <th>U17</th>
                    <th>U18</th>
                    <th>U19</th>
                    <th>A1</th>
                    <th>A2</th>
                    <th>A3</th>
                    <th>A4</th>
                    <th>A5</th>
                    <th>A6</th>
                    <th>A7</th>
                    <th>A8</th>
                    <th>A9</th>
                    <th>A10</th>
                    <th>A11</th>
                    <th>A12</th>
                    <th>A13</th>
                    <th>A14</th>
                    <th>A15</th>
                    <th>A16</th>
                    <th>A17</th>
                    <th>A18</th>
                    <th>A19</th>
                    <th>SARAN</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $no = 1;
                foreach ($survey->result() as $row) {
                ?>

                    <tr>
                        <td><?php echo $no++ ?></td>

                        <?php if ($row->is_submit == 1) { ?>
                            <td style="color: blue;">VALID</td>
                        <?php } else { ?>
                            <td style="color: red;">TIDAK VALID</td>
                        <?php } ?>

                        <td><?php echo $row->kode_surveyor ?></td>
                        <td><?php echo $row->first_name ?></td>
                        <td><?php echo $row->nama_provinsi_indonesia ?></td>
                        <td><?php echo $row->nama_kota_kab_indonesia ?></td>
                        <td><?php echo $row->nama_barang_jasa ?></td>
                        <td><?php echo $row->nama_lengkap ?></td>
                        <td><?php echo $row->handphone ?></td>
                        <td><?php echo $row->jenis_kelamin_responden ?></td>
                        <td><?php echo $row->umur_responden ?></td>
                        <td><?php echo $row->pendidikan_akhir_responden ?></td>
                        <td><?php echo $row->pekerjaan_utama_responden ?></td>
                        <td><?php echo $row->pendapatan_per_bulan_responden ?></td>
                        <td><?php echo $row->U1 ?></td>
                        <td><?php echo $row->U2 ?></td>
                        <td><?php echo $row->U3 ?></td>
                        <td><?php echo $row->U4 ?></td>
                        <td><?php echo $row->U5 ?></td>
                        <td><?php echo $row->U6 ?></td>
                        <td><?php echo $row->U7 ?></td>
                        <td><?php echo $row->U8 ?></td>
                        <td><?php echo $row->U9 ?></td>
                        <td><?php echo $row->U10 ?></td>
                        <td><?php echo $row->U11 ?></td>
                        <td><?php echo $row->U12 ?></td>
                        <td><?php echo $row->U13 ?></td>
                        <td><?php echo $row->U14 ?></td>
                        <td><?php echo $row->U15 ?></td>
                        <td><?php echo $row->U16 ?></td>
                        <td><?php echo $row->U17 ?></td>
                        <td><?php echo $row->U18 ?></td>
                        <td><?php echo $row->U19 ?></td>
                        <td><?php echo $row->A1 ?></td>
                        <td><?php echo $row->A2 ?></td>
                        <td><?php echo $row->A3 ?></td>
                        <td><?php echo $row->A4 ?></td>
                        <td><?php echo $row->A5 ?></td>
                        <td><?php echo $row->A6 ?></td>
                        <td><?php echo $row->A7 ?></td>
                        <td><?php echo $row->A8 ?></td>
                        <td><?php echo $row->A9 ?></td>
                        <td><?php echo $row->A10 ?></td>
                        <td><?php echo $row->A11 ?></td>
                        <td><?php echo $row->A12 ?></td>
                        <td><?php echo $row->A13 ?></td>
                        <td><?php echo $row->A14 ?></td>
                        <td><?php echo $row->A15 ?></td>
                        <td><?php echo $row->A16 ?></td>
                        <td><?php echo $row->A17 ?></td>
                        <td><?php echo $row->A18 ?></td>
                        <td><?php echo $row->A19 ?></td>
                        <td><?php echo $row->saran ?></td>

                    </tr>
                <?php
                } ?>
            </tbody>
        </table>
    </div>
</body>

</html>