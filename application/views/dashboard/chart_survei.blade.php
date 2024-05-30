@php
$ci = get_instance();
@endphp

<div class="card card-custom mb-8 mb-lg-0" style="background-color: #ffffff;">
    <div class="card-body">
        <div class="text-center">
            <div id="chart"></div>
        </div>
    </div>
</div>





<script>
FusionCharts.ready(function() {
    var myChart = new FusionCharts({
        type: "column3d",
        renderAt: "chart",
        width: "100%",
        "height": "350",
        dataFormat: "json",
        dataSource: {
            chart: {
                caption: "<b>Nilai Indeks Keberdayaan Konsumen</b>",
                subcaption: " ",
                decimals: "3",
                showvalues: "1",
                decimals: "2",
                theme: "umber",
                "bgColor": "#ffffff"
            },
            data: [<?php echo $get_data_chart ?>]
        }
    });
    myChart.render();
});
</script>