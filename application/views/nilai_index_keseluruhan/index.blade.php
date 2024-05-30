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

<div class="container-fluid">

    <div class="card card-custom bgi-no-repeat gutter-b" style="height: 150px; background-color: #1c2840; background-position: calc(100% + 0.5rem) 100%; background-size: 100% auto; background-image: url(/assets/img/banner/rhone-2.svg)" data-aos="fade-down">
        <div class="card-body d-flex align-items-center">
            <div>
                <h3 class="text-white font-weight-bolder line-height-lg mb-5">
                    {{strtoupper($title)}}
                </h3>

            </div>
        </div>
    </div>

    <!-- <div class="card card-custom card-body card-sticky" data-aos="fade-down">
        <div id="chart"></div>
    </div> -->

    <div id="chart"></div>

    <div class="card card-custom card-sticky mt-5" data-aos="fade-down">

        <div class="card-body">


            <div class="table-responsive">
                <table class="table example" cellspacing="0" width="100%" style="font-size: 12px;">
                    <thead class="bg-secondary">
                        <tr style="display: none;">
                            <th>No</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no = 1;
                        $chart_array = [];
                        @endphp
                        @foreach($sektor->result() as $row)

                        @php
                        $data_skor = [];
                        $data_survei = [];
                        foreach ($ci->db->query("SELECT * FROM manage_survey WHERE id IN ($parent)")->result() as $key
                        => $value) {

                        $data_skor[$key] = "UNION
                        SELECT *
                        FROM (SELECT *, (SELECT is_submit FROM survey_$value->table_identity WHERE
                        survey_$value->table_identity.id = jawaban_pertanyaan_unsur_$value->table_identity.id_survey) AS
                        is_submit,
                        (SELECT sektor
                        FROM survey_$value->table_identity
                        JOIN responden_$value->table_identity ON survey_$value->table_identity.id_responden =
                        responden_$value->table_identity.id
                        WHERE survey_$value->table_identity.id =
                        jawaban_pertanyaan_unsur_$value->table_identity.id_survey) AS sektor


                        FROM jawaban_pertanyaan_unsur_$value->table_identity) jpu_$value->table_identity
                        WHERE is_submit = 1 && sektor = $row->id";
                        }
                        $union_skor = implode(" ", $data_skor);

                        //PER PERTANYAAN
                        $total_nilai_unsur = $ci->db->query("SELECT
                        id_pertanyaan_unsur,
                        SUM(skor_jawaban) AS total_nilai,
                        AVG(skor_jawaban) AS rata_nilai,
                        ((SELECT persentase_unsur FROM pertanyaan_unsur JOIN unsur ON pertanyaan_unsur.id_unsur =
                        unsur.id WHERE pertanyaan_unsur.id = prt.id_pertanyaan_unsur) / 100) AS
                        persentase_unsur_dibagi_100,
                        (AVG(skor_jawaban) * ((SELECT persentase_unsur FROM pertanyaan_unsur JOIN unsur ON
                        pertanyaan_unsur.id_unsur = unsur.id WHERE pertanyaan_unsur.id = prt.id_pertanyaan_unsur) /
                        100)) AS persen_per_unsur,
                        sektor

                        FROM (SELECT *, null AS is_submit, null AS sektor
                        FROM jawaban_pertanyaan_unsur
                        $union_skor) prt
                        GROUP BY id_pertanyaan_unsur");


                        $total = [];
                        $ikk = 0;
                        foreach ($total_nilai_unsur->result() as $rows){
                        $total[] = $rows->persen_per_unsur;
                        $ikk = array_sum($total) * 20;
                        }


                        // if(str_word_count($row->nama_sektor) > 2){
                            // $chart_array[] = '{label: "' . substr($row->nama_sektor, 0, 7) . ' [...]", value: "' . $ikk . '"}';
                            // } else {
                                //  $chart_array[] = '{label: "' . $row->nama_sektor . '", value: "' . $ikk . '"}';
                                //  }

                        $chart_array[] = '{label: "' . $row->nama_sektor . '", value: "' . $ikk . '"}';
                        @endphp
                        <tr>
                            <td>{{$no++}}</td>
                            <td>
                                <a title="{{$row->nama_sektor}}" href="{{base_url() . 'nilai-index-keseluruhan/' . $row->id}}">
                                    <div class="card mb-3 shadow" style="background-color: #eef8ff;">
                                        <div class="card-body">
                                            <strong style="font-size: 15px;" class="text-primary"><b>{{$row->nama_sektor}}</b></strong>

                                            <div class=" row mt-3">
                                                <div class="col sm-6">
                                                    <span class="text-dark-50">Nilai IKK : <b>{{$ikk}}</b></span>
                                                </div>
                                                <div class="col sm-6">
                                                    <span class="text-dark-50">Mutu Pelayanan : <b class="text-dark-50">
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
                                                            } ?>
                                                        </b></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="modal fade bd-example-modal-xl" id="modal_detail" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
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
<script src="{{ base_url() }}assets/themes/metronic/assets/plugins/custom/datatables/datatables.bundle.js"></script>
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
            url: "<?php echo base_url() . $ci->session->userdata('username') . '/' .  $ci->uri->segment(2) . '/nilai-index-sektor/' ?>" +
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
$data_chart = implode(", ", $chart_array);
@endphp
<script>
    FusionCharts.ready(function() {
        var myChart = new FusionCharts({
            type: "bar3d",
            renderAt: "chart",
            "width": "100%",
            "height": "70%",
            dataFormat: "json",
            dataSource: {
                chart: {
                    caption: "Nilai Indeks Keseluruhan",
                    // subcaption: "For the year 2017",
                    // yaxisname: "Annual Income",
                    showvalues: "1",
                    "decimals": "2",
                    theme: "fusion",
                    // theme: "umber",
                    "bgColor": "#ffffff",
                },
                data: [<?php echo $data_chart ?>]
            }
        });
        myChart.render();
    });
</script>
@endsection