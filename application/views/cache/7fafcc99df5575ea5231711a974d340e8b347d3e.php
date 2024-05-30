

<?php
$ci = get_instance();
?>

<?php $__env->startSection('style'); ?>
<link href="<?php echo e(TEMPLATE_BACKEND_PATH); ?>plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
<script src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
<script src="<?php echo e(base_url()); ?>assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.accessibility.js">
</script>
<script src="<?php echo e(base_url()); ?>assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.candy.js"></script>
<script src="<?php echo e(base_url()); ?>assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.carbon.js"></script>
<script src="<?php echo e(base_url()); ?>assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.fint.js"></script>
<script src="<?php echo e(base_url()); ?>assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.fusion.js"></script>
<script src="<?php echo e(base_url()); ?>assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.gammel.js"></script>
<script src="<?php echo e(base_url()); ?>assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.ocean.js"></script>
<script src="<?php echo e(base_url()); ?>assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.umber.js"></script>
<script src="<?php echo e(base_url()); ?>assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.zune.js"></script>

<style type="text/css">
    [pointer-events="bounding-box"] {
        display: none
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <?php echo $__env->make("include_backend/partials_no_aside/_inc_menu_repository", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="row">
        <div class="col-md-3">
            <?php echo $__env->make('manage_survey/menu_data_survey', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-md-9">
            <div class="card card-custom bgi-no-repeat gutter-b" style="height: 150px; background-color: #1c2840; background-position: calc(100% + 0.5rem) 100%; background-size: 100% auto; background-image: url(/assets/img/banner/rhone-2.svg)" data-aos="fade-down">
                <div class="card-body d-flex align-items-center">
                    <div>
                        <h3 class="text-white font-weight-bolder line-height-lg mb-5">
                            <?php echo e(strtoupper($title)); ?>

                        </h3>
                    </div>
                </div>
            </div>

            <div id="chart"></div>

            <br>

            <div class="card card-custom card-sticky" data-aos="fade-down" data-aos-delay="300">

                <div class="card-body">

                    <div class="table-responsive">
                        <table id="table" class="table table-hover table-striped" cellspacing="0" width="100%">
                            <thead>
                                <th>No.</th>
                                <th>Nama Wilayah</th>
                                <th>Akumulasi (Persentase)</th>
                                <th>Total Target</th>
                                <th>Total Perolehan</th>
                                <th>Total Kekurangan</th>
                                <th></th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- ======================================= Detail Hasil Analisa ========================================== -->
<div class="modal fade bd-example-modal-xl" id="modal_detail" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" id="bodyModalDetail">
            <div align="center" id="loading_registration">
                <img src="<?php echo e(base_url()); ?>assets/site/img/ajax-loader.gif" alt="">
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script src="<?php echo e(TEMPLATE_BACKEND_PATH); ?>plugins/custom/datatables/datatables.bundle.js"></script>
<script>
    $(document).ready(function() {
        table = $('#table').DataTable({

            "processing": true,
            "serverSide": true,
            "order": [],
            "language": {
                "processing": '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
            },
            // "lengthMenu": [
            //     [5, 10, 25, 50, 100],
            //     [5, 10, 25, 50, 100]
            // ],
            // "pageLength": 5,
            "ajax": {
                "url": "<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/rekap-per-wilayah/ajax-list' ?>",
                "type": "POST",
                "data": function(data) {}
            },

            "columnDefs": [{
                "targets": [-1],
                "orderable": false,
            }, ],

        });
    });

    $('#btn-filter').click(function() {
        table.ajax.reload();
    });
    $('#btn-reset').click(function() {
        $('#form-filter')[0].reset();
        table.ajax.reload();
    });
</script>


<script>
    function showedit(id) {
        $('#bodyModalDetail').html(
            "<div class='text-center'><img src='<?php echo e(base_url()); ?>assets/img/ajax/ajax-loader-big.gif'></div>");

        $.ajax({
            type: "post",
            url: "<?php echo base_url() . $ci->session->userdata('username') . '/' .  $ci->uri->segment(2) . '/rekap-per-wilayah/detail/' ?>" +
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('include_backend/template_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp-7.3.33\htdocs\surveiku_ikk\application\views/rekap_per_wilayah/index.blade.php ENDPATH**/ ?>