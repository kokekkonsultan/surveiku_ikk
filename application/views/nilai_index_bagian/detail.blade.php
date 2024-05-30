@extends('include_backend/template_backend')

@php
$ci = get_instance();
@endphp

@section('style')
<link href="{{ TEMPLATE_BACKEND_PATH }}plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />

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

<style type="text/css">
[pointer-events="bounding-box"] {
    display: none
}
</style>
@endsection

@section('content')
<div class=" container-fluid">

    <div class="card card-custom bgi-no-repeat gutter-b aos-init aos-animate" style="height: 150px; background-color: #1c2840; background-position: calc(100% + 0.5rem) 100%; background-size: 100% auto; background-image: url(/assets/img/banner/rhone-2.svg)" data-aos="fade-down">
        <div class="card-body d-flex align-items-center">
            <div>
                <h3 class="text-white font-weight-bolder line-height-lg mb-5">
                NILAI INDEKS BAGIAN {{ strtoupper($profile) }}
                </h3>
            </div>
        </div>
    </div>

    <div id="chart"></div>

    <br>

    <div class="card shadow aos-init aos-animate" data-aos="fade-up">
        <div class="card-body">
            <style>
                /*thead {
                    display: none;
                }*/
            </style>
            <div class="table-responsive">
                <table class="table table-bordered table-hover example" cellspacing="0" width="100%"
                    style="font-size: 12px;">
                    <thead class="bg-secondary">
                        <tr>
                            <th width="5%">No</th>
                            <th>Sektor</th>
                            <th>Nilai IKK</th>
                            <th>Mutu Pelayanan</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no = 1;
                        $get_data_chart = [];
                        @endphp
                        @foreach($sektor->result() as $row)


                        <?php

                            /*$klien_induk = $ci->db->get_where("pengguna_klien_induk", array('id_user' => $ci->session->userdata('user_id')))->row();
                            $parent = implode(", ", unserialize($klien_induk->cakupan_induk));*/

                            $ci->db->select( '*, manage_survey.slug AS slug_manage_survey, (SELECT first_name FROM users WHERE users.id = manage_survey.id_user) AS first_name, (SELECT last_name FROM users WHERE users.id = manage_survey.id_user) AS last_name');
                            $ci->db->from('manage_survey');
                            $ci->db->where('id_user', $id_user);
                            //$ci->db->where("id IN ($parent)");

                            $manage_survey = $ci->db->get();

                            if ($manage_survey->num_rows() > 0) {
                                $query = "SELECT kode_unsur, SUM(persentase_unsur) AS persentase_unsur, SUM(rata_per_unsur) AS rata_per_unsur, SUM(persen_per_unsur) AS persen_per_unsur FROM (";
                                $q = 0;
                                foreach ($manage_survey->result() as $value) {
                                    $q++;
                                    $table_identity = $value->table_identity;
                                    if($q!='1'){
                                        $query .= "
                                        UNION ALL
                                        ";
                                    }
                                    $query .= "SELECT kode_unsur, (SELECT
                                    unsur_$table_identity.persentase_unsur /
                                    100) AS persentase_unsur,
            
                                    (SELECT AVG(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity
                                    JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey =
                                    survey_$table_identity.id
                                    JOIN responden_$table_identity ON survey_$table_identity.id_responden =
                                    responden_$table_identity.id
                                    WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && is_submit = 1 &&
                                    sektor = $row->id) AS
                                    rata_per_unsur,
            
                                    ((SELECT AVG(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity
                                    JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey =
                                    survey_$table_identity.id
                                    JOIN responden_$table_identity ON survey_$table_identity.id_responden =
                                    responden_$table_identity.id
                                    WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && is_submit = 1 &&
                                    sektor = $row->id) *
                                    (unsur_$table_identity.persentase_unsur / 100)) AS persen_per_unsur
            
                                    FROM pertanyaan_unsur_$table_identity
                                    JOIN unsur_$table_identity ON pertanyaan_unsur_$table_identity.id_unsur =
                                    unsur_$table_identity.id";

                                }
                                $query .= ') sektor_bagian GROUP BY kode_unsur';
                                $olah_data = $ci->db->query($query);
                            }


                        ?>
                        @php
                        $olah_data2 = $ci->db->query("SELECT kode_unsur, (SELECT
                        unsur_$table_identity.persentase_unsur /
                        100) AS persentase_unsur,

                        (SELECT AVG(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity
                        JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey =
                        survey_$table_identity.id
                        JOIN responden_$table_identity ON survey_$table_identity.id_responden =
                        responden_$table_identity.id
                        WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && is_submit = 1 &&
                        sektor = $row->id) AS
                        rata_per_unsur,

                        ((SELECT AVG(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity
                        JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey =
                        survey_$table_identity.id
                        JOIN responden_$table_identity ON survey_$table_identity.id_responden =
                        responden_$table_identity.id
                        WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && is_submit = 1 &&
                        sektor = $row->id) *
                        (unsur_$table_identity.persentase_unsur / 100)) AS persen_per_unsur

                        FROM pertanyaan_unsur_$table_identity
                        JOIN unsur_$table_identity ON pertanyaan_unsur_$table_identity.id_unsur =
                        unsur_$table_identity.id");

                        $total = [];
                        $ikk = 0;
                        foreach ($olah_data->result() as $value) {
                            $total[] = $value->persen_per_unsur;
                            $ikk = array_sum($total) * 20;
                        }

                        $get_data_chart[] = '{label: "' . $row->nama_sektor . '", value: "' . $ikk . '"}';

                        @endphp
                        <tr>
                            <td>{{$no++}}</td>
                            <td>{{$row->nama_sektor}}</td>
                            <td class="text-primary"><b>{{$ikk == null ? 0 : ROUND($ikk,3)}}</b></td>
                            <td class="text-dark-50"><b>
                                    <?php if ($ikk <= 20) {
                                        echo 'Sadar';
                                    } elseif ($ikk > 20 && $ikk <= 40) {
                                        echo 'Paham';
                                    } elseif ($ikk > 40 && $ikk <= 60) {
                                        echo 'Mampu';
                                    } elseif ($ikk > 60 && $ikk <= 80) {
                                        echo 'Kritis';
                                    } elseif ($ikk > 80) {
                                        echo 'Berdaya';
                                    } else {
                                        NULL;
                                    } ?></b>
                            </td>
                            <td>
                                <a class="btn btn-light-info btn-sm shadow font-weight-bold" data-toggle="modal"
                                    onclick="showedit({{$row->id}})" href="#modal_detail"><i
                                        class="fa fa-info-circle"></i> Detail</a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-xl" id="modal_detail" tabindex="-1" role="dialog"
    aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" id="bodyModalDetail">
            <div align="center" id="loading_registration">
                <img src="{{ base_url() }}assets/site/img/ajax-loader.gif" alt="">
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script src="{{ TEMPLATE_BACKEND_PATH }}plugins/custom/datatables/datatables.bundle.js"></script>
<script>
$(document).ready(function() {
    $('.example').DataTable();
});
</script>

<script>
function showedit(id) {
    $('#bodyModalDetail').html(
        "<div class='text-center'><img src='{{ base_url() }}assets/img/ajax/ajax-loader-big.gif'></div>");

    $.ajax({
        type: "post",
        url: "<?php echo base_url() . 'nilai-index-bagian/'. $ci->uri->segment(2) .'/' ?>" +
            id,
        // data: "id=" + id,
        dataType: "text",
        success: function(response) {
            // $('.modal-title').text('Edit Pertanyaan Unsur');
            $('#bodyModalDetail').empty();
            $('#bodyModalDetail').append(response);
        }
    });
}
</script>
@php
$get_data_chart = implode(", ", $get_data_chart);
@endphp
<script>
FusionCharts.ready(function() {
    var myChart = new FusionCharts({
        type: "bar3d",
        renderAt: "chart",
        "width": "100%",
        //"height": "100%",
        dataFormat: "json",
        dataSource: {
            chart: {
                caption: "Nilai Indeks <?php echo $profile ?>",
                // yaxisname: "Annual Income",
                showvalues: "1",
                "decimals": "2",
                theme: "gammel",
                "bgColor": "#ffffff",
            },
            data: [<?php echo $get_data_chart ?>]
        }
    });
    myChart.render();
});
</script>
@endsection