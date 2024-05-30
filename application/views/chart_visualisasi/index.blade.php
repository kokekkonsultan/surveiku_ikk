@extends('include_backend/template_backend')

@php
$ci = get_instance();
@endphp

@section('style')
<script src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
<script src="{{ base_url() }}assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.accessibility.js">
</script>
<script src="{{ base_url() }}assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.candy.js"></script>
<script src="{{ base_url() }}assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.carbon.js"></script>
<script src="{{ base_url() }}assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.fint.js"></script>
<script src="{{ base_url() }}assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.fusion.js"></script>
<script src="{{ base_url() }}assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.gammel.js"></script>
<script src="{{ base_url() }}assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.ocean.js"></script>
<script src="{{ base_url() }}assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.umber.js"></script>
<script src="{{ base_url() }}assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.zune.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">



<style type="text/css">
[pointer-events="bounding-box"] {
    display: none
}

.dataTables_filter {
    display: none
}

.dataTables_length {
    display: none
}
</style>

@endsection

@section('content')

<div class="container-fluid">
    @include("include_backend/partials_no_aside/_inc_menu_repository")

    <div class="row mt-5">
        <div class="col-md-3">
            @include('manage_survey/menu_data_survey')
        </div>
        <div class="col-md-9">


            @foreach ($unsur->result() as $row)
            <div class="card mb-5" data-aos="fade-down">
                <div class="card-body">

                    <div id="pie_<?php echo $row->id_pertanyaan_unsur ?>" class="d-flex justify-content-center"></div>

                    <!-- <span><?php echo strip_tags($row->isi_pertanyaan) ?></span> -->

                    <table class="table table-bordered example mt-5" style="width:100%">
                        <thead class="bg-light">
                            <tr>
                                <th>No.</th>
                                <th>Kelompok</th>
                                <th>Jumlah</th>
                                <th>Persentase</th>
                            </tr>
                        </thead>
                        <tbody>

                            @php
                            $nilai_unsur_pelayanan = $ci->db->query("SELECT *, (SELECT
                            COUNT(jawaban_pertanyaan_unsur_$table_identity.id) FROM
                            jawaban_pertanyaan_unsur_$table_identity
                            JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey =
                            survey_$table_identity.id WHERE skor_jawaban =
                            nilai_unsur_pelayanan_$table_identity.nilai_jawaban &&
                            jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur =
                            $row->id_pertanyaan_unsur && is_submit = 1) AS perolehan,

                            (((SELECT COUNT(jawaban_pertanyaan_unsur_$table_identity.id) FROM
                            jawaban_pertanyaan_unsur_$table_identity JOIN survey_$table_identity ON
                            jawaban_pertanyaan_unsur_$table_identity.id_survey = survey_$table_identity.id WHERE
                            skor_jawaban = nilai_unsur_pelayanan_$table_identity.nilai_jawaban &&
                            jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur =
                            $row->id_pertanyaan_unsur && is_submit = 1) / (SELECT COUNT(*)
                            FROM survey_$table_identity WHERE is_submit = 1)) * 100) AS persentase
                            FROM nilai_unsur_pelayanan_$table_identity");

                            $jumlah = [];
                            $nama_kelompok = [];
                            $no = 1;
                            @endphp

                            @foreach ($nilai_unsur_pelayanan->result() as $value)
                            @if ($value->id_pertanyaan_unsur == $row->id_pertanyaan_unsur)

                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $value->nama_jawaban ?></td>
                                <td><?php echo $value->perolehan ?></th>
                                <td><?php echo ROUND($value->persentase, 2) ?> %</td>
                            </tr>

                            @endif
                            @endforeach
                        </tbody>

                    </table>


                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>


@endsection

@section('javascript')
<script src="{{ base_url() }}assets/themes/metronic/assets/js/pages/features/charts/apexcharts.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
$(document).ready(function() {
    $('.example').DataTable();
});
</script>

@foreach ($unsur->result() as $row)

@php
$nilai_unsur_pelayanan = $ci->db->query("SELECT *, (SELECT
COUNT(jawaban_pertanyaan_unsur_$table_identity.id) FROM jawaban_pertanyaan_unsur_$table_identity
JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey =
survey_$table_identity.id WHERE skor_jawaban =
nilai_unsur_pelayanan_$table_identity.nilai_jawaban &&
jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur =
$row->id_pertanyaan_unsur && is_submit = 1) AS perolehan,

(((SELECT COUNT(jawaban_pertanyaan_unsur_$table_identity.id) FROM
jawaban_pertanyaan_unsur_$table_identity JOIN survey_$table_identity ON
jawaban_pertanyaan_unsur_$table_identity.id_survey = survey_$table_identity.id WHERE
skor_jawaban = nilai_unsur_pelayanan_$table_identity.nilai_jawaban &&
jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur =
$row->id_pertanyaan_unsur && is_submit = 1) / (SELECT COUNT(*)
FROM survey_$table_identity WHERE is_submit = 1)) * 100) AS persentase
FROM nilai_unsur_pelayanan_$table_identity");
@endphp


<script>
FusionCharts.ready(function() {
    var myChart = new FusionCharts({
        "type": "pie3d",
        "renderAt": "pie_<?php echo $row->id_pertanyaan_unsur ?>",
        "width": "100%",
        "height": "350",
        "dataFormat": "json",
        dataSource: {
            "chart": {
                caption: "<?php echo $row->kode_unsur . '. ' . $row->nama_unsur ?>",
                // subcaption: "",
                "enableSmartLabels": "1",
                "startingAngle": "0",
                "showPercentValues": "1",
                "decimals": "1",
                "useDataPlotColorForLabels": "1",
                "theme": "umber",
                "bgColor": "#ffffff",
            },
            "data": [

                <?php foreach ($nilai_unsur_pelayanan->result() as $value) {
                        if ($value->id_pertanyaan_unsur == $row->id_pertanyaan_unsur) { ?> {
                    "label": "<?php echo $value->nama_jawaban ?>",
                    "value": "<?php echo $value->perolehan ?>"
                },
                <?php }
                    } ?>
            ]
        }

    });
    myChart.render();
});
</script>
@endforeach


@endsection