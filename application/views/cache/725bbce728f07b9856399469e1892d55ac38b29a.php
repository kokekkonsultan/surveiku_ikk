

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


            <div class="card" data-aos="fade-down" data-aos-delay="300">
                <div class="card-body">
                    <div id="chart"></div>

                    <hr>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <td rowspan="2" class="text-center" style="vertical-align: middle;">No</td>
                                    <td rowspan="2" class="text-center" style="vertical-align: middle;">Barang / Jasa
                                    </td>
                                    <td rowspan="2" class="text-center" style="vertical-align: middle;">Akumulasi
                                        (Persentase)</td>
                                    <td colspan="3" class="text-center">Online</td>
                                    <td colspan="3" class="text-center">Offline</td>
                                </tr>
                                <tr>
                                    <th class="text-center">Target</th>
                                    <th class="text-center">Perolehan</th>
                                    <th class="text-center">Kekurangan</th>
                                    <th class="text-center">Target</th>
                                    <th class="text-center">Perolehan</th>
                                    <th class="text-center">Kekurangan</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $no = 1;
                                ?>
                                <?php $__currentLoopData = $sektor->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <?php
                                $target_online[] = $row->target_online;
                                $target_offline[] = $row->target_offline;
                                $perolehan_online[] = $row->perolehan_online;
                                $perolehan_offline[] = $row->perolehan_offline;

                                $total_target_online = array_sum($target_online);
                                $total_perolehan_online = array_sum($perolehan_online);
                                $total_target_offline = array_sum($target_offline);
                                $total_perolehan_offline = array_sum($perolehan_offline);
                                ?>

                                <tr>
                                    <td class="text-center"><?php echo e($no++); ?></td>
                                    <td><?php echo e($row->nama_sektor); ?></td>
                                    <td class="text-center">
                                        <span class="badge badge-info">
                                            <?php echo e(ROUND(($row->perolehan_online + $row->perolehan_offline)/($row->target_online + $row->target_offline)* 100, 2)); ?>

                                            %
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-secondary"><?php echo e($row->target_online); ?></span>
                                    </td>
                                    <td class="text-center"><span class="badge badge-success"><?php echo e($row->perolehan_online); ?></span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-danger">
                                            <?php echo e($row->target_online - $row->perolehan_online); ?>

                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-secondary"><?php echo e($row->target_offline); ?></span>
                                    </td>
                                    <td class="text-center"><span class="badge badge-success"><?php echo e($row->perolehan_offline); ?></span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-danger">
                                            <?php echo e($row->target_offline - $row->perolehan_offline); ?>

                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <tr>
                                    <td colspan="2" align="center"><b>TOTAL</b></td>
                                    <td class="text-center">
                                        <span class="badge badge-dark">
                                            <?php echo e(ROUND(($total_perolehan_online + $total_perolehan_offline)/($total_target_online + $total_target_offline) * 100, 2)); ?>

                                            %
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-dark">
                                            <?php echo e($total_target_online); ?>

                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-dark">
                                            <?php echo e($total_perolehan_online); ?>

                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-dark">
                                            <?php echo e($total_target_online - $total_perolehan_online); ?>

                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-dark">
                                            <?php echo e($total_target_offline); ?>

                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-dark">
                                            <?php echo e($total_perolehan_offline); ?>

                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-dark">
                                            <?php echo e($total_target_offline - $total_perolehan_offline); ?>

                                        </span>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>

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
                    caption: "Grafik Total Perolehan Per Sektor",
                    // yaxisname: "Annual Income",
                    showvalues: "1",
                    "decimals": "2",
                    theme: "fusion",
                    "bgColor": "#ffffff",
                },
                data: [
                    <?php foreach ($sektor->result() as $row) { ?> {
                            label: "<?php echo $row->nama_sektor ?>",
                            value: "<?php echo ($row->perolehan_online + $row->perolehan_offline) ?>"
                        },
                    <?php } ?>
                ]
            }
        });
        myChart.render();
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('include_backend/template_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp-7.3.33\htdocs\surveiku_ikk\application\views/rekap_per_sektor/index.blade.php ENDPATH**/ ?>