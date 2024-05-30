<?php
$ci = get_instance();
?>

<!--<div class="card card-custom mb-8 mb-lg-0" style="background-color: #ffffff;">
    <div class="card-body">
        <div class="text-center">
            <div id="chart"></div>
        </div>
    </div>
</div>-->

<div id="chart"></div>

    <br>



<script>
FusionCharts.ready(function() {
    var myChart = new FusionCharts({
        type: "bar3d",
        renderAt: "chart",
        "width": "100%",
        "height": "100%",
        //width: "100%",
        //"height": "100%",
        dataFormat: "json",
        dataSource: {
            chart: {
                caption: "<b>Nilai Indeks Keberdayaan Konsumen</b>",
                //subcaption: " ",
                // yaxisname: "Deforested Area{br}(in Hectares)",
                //decimals: "2",
                showvalues: "1",
                "decimals": "2",
                theme: "fusion",
                "bgColor": "#ffffff"
            },
            data: [<?php echo $get_data_chart ?>]
        }
    });
    myChart.render();
});
</script><?php /**PATH C:\xampp-7.3.33\htdocs\surveiku_ikk\application\views/dashboard/chart_survei_induk.blade.php ENDPATH**/ ?>