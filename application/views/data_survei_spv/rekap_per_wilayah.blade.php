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
    @include("include_backend/partials_no_aside/_inc_menu_repository")
    <div class="row">
        <div class="col-md-3">
            @include('manage_survey/menu_data_survey')
        </div>
        <div class="col-md-9">
            <div class="card card-custom bgi-no-repeat gutter-b" style="height: 150px; background-color: #1c2840; background-position: calc(100% + 0.5rem) 100%; background-size: 100% auto; background-image: url(/assets/img/banner/rhone-2.svg)" data-aos="fade-down">
                <div class="card-body d-flex align-items-center">
                    <div>
                        <h3 class="text-white font-weight-bolder line-height-lg mb-5">
                            {{strtoupper($title)}}
                        </h3>
                    </div>
                </div>
            </div>

            <div id="chart"></div>

            <br>

            <div class="card card-custom card-sticky" data-aos="fade-down" data-aos-delay="300">

                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover example" cellspacing="0" width="100%">
                            <thead class="bg-secondary">
                                <th class="text-center">No.</th>
                                <th class="text-center">Nama Wilayah</th>
                                <th class="text-center">Akumulasi (Persentase)</th>
                                <th class="text-center">Target</th>
                                <th class="text-center">Perolehan</th>
                                <th class="text-center">Kekurangan</th>
                            </thead>

                            <tbody>
                                @php
                                $no =1 ;
                                @endphp
                                @foreach($wilayah_survei->result() as $value)
                                
                                @php
                                $target_online[] = $value->target;
                                $perolehan_online[] = $value->perolehan;

                                $total_target_online = array_sum($target_online);
                                $total_perolehan_online = array_sum($perolehan_online);
                                @endphp

                                <tr>
                                    <td class="text-center">{{$no++}}</td>
                                    <td>{{$value->nama_wilayah}}</td>
                                    <td class="text-center">{{ ROUND(($value->perolehan / $value->target) * 100, 2) }} %</td>
                                    <td class="text-center">{{$value->target}}</td>
                                    <td class="text-center">{{$value->perolehan}}</td>
                                    <td class="text-center">{{ $value->target - $value->perolehan }}</td>
                                    </tr>
                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="2" align="center"><b>TOTAL</b></td>
                                    <td class="text-center">
                                        <span class="badge badge-dark">
                                        {{ ROUND(($total_perolehan_online/$total_target_online) * 100,3) }}
                                            %
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-dark">
                                            {{$total_target_online}}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-dark">
                                            {{$total_perolehan_online}}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-dark">
                                            {{$total_target_online - $total_perolehan_online}}
                                        </span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('javascript')
<script src="{{ base_url() }}assets/themes/metronic/assets/plugins/custom/datatables/datatables.bundle.js"></script>
<script>
$(document).ready(function() {
    $('.example').DataTable({
        "processing": true,
        "lengthMenu": [
            [50, 100, 150],
            [50, 100, 150]
        ],
        "pageLength": 50,
        "language": {
            "processing": '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
        }
    });
});
</script>



<script>
    FusionCharts.ready(function() {
        var myChart = new FusionCharts({
            type: "bar3d",
            renderAt: "chart",
            "width": "100%",
            "height": "100%",
            dataFormat: "json",
            dataSource: {
                chart: {
                    caption: "Grafik Total Perolehan Per Wilayah Survei",
                    // yaxisname: "Annual Income",
                    showvalues: "1",
                    "decimals": "2",
                    theme: "umber",
                    "bgColor": "#ffffff",
                },
                data: [
                    <?php foreach ($wilayah_survei->result() as $row) { ?> {
                            label: "<?php echo $row->nama_wilayah ?>",
                            value: "<?php echo $row->perolehan ?>"
                        },
                    <?php } ?>
                ]
            }
        });
        myChart.render();
    });
</script>
@endsection