

<?php
$ci = get_instance();
?>

<?php $__env->startSection('style'); ?>
<link href="<?php echo e(TEMPLATE_BACKEND_PATH); ?>plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class=" container-fluid">

    <div class="card card-custom bgi-no-repeat gutter-b aos-init aos-animate" style="height: 150px; background-color: #1c2840; background-position: calc(100% + 0.5rem) 100%; background-size: 100% auto; background-image: url(/assets/img/banner/rhone-2.svg)" data-aos="fade-down">
        <div class="card-body d-flex align-items-center">
            <div>
                <h3 class="text-white font-weight-bolder line-height-lg mb-5">
                    TABULASI & OLAH DATA
                    <br>
                    KESELURUHAN
                </h3>
            </div>
        </div>
    </div>



    <div class="card shadow aos-init aos-animate" data-aos="fade-up">
        <div class="card-body">

            <?php if($cek_survey->num_rows() > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%">
                    <thead>
                        <tr>
                            <td></td>
                            <?php $__currentLoopData = $total_nilai_unsur->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th class="bg-secondary">U<?php echo e($value->id_pertanyaan_unsur); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <th class="bg-dark text-white" width="40%">Total</th>
                            <?php $__currentLoopData = $total_nilai_unsur->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <td><?php echo e(ROUND($row->total_nilai)); ?></td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>

                        <tr>
                            <th class="bg-dark text-white">Rata-Rata</th>
                            <?php $__currentLoopData = $total_nilai_unsur->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <td><?php echo e(ROUND($row->rata_nilai,2)); ?></td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tr>

                        <tr>
                            <th class="bg-dark text-white">Nilai Per Unsur</th>
                            <?php $__currentLoopData = $total_nilai_unsur->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <td><?php echo e(ROUND($row->rata_nilai * 20,2)); ?></td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tr>

                        <tr>
                            <th class="bg-dark text-white">Nilai Per Dimensi</th>
                            <?php $__currentLoopData = $total_nilai_dimensi->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <td class="text-center" colspan="<?php echo e($value->jumlah_dimensi_per_pertanyaan); ?>">
                                <?php echo e(ROUND($value->rata_nilai * 20,3)); ?>

                            </td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>

                        <tr>
                            <th class="bg-dark text-white">Rata-Rata x Bobot</th>
                            <?php $__currentLoopData = $total_nilai_unsur->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                            $total[] = $row->persen_per_unsur * 20;
                            $ikk = array_sum($total);
                            ?>
                            <td><?php echo e(ROUND($row->persen_per_unsur * 20, 3)); ?></td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>

                        <tr>
                            <th class="bg-dark text-white">IKK</th>
                            <td colspan="19" class="font-weight-bold text-info">
                                <?php echo e(ROUND($ikk, 3)); ?>

                            </td>
                        </tr>
                        <tr>
                            <th class="bg-dark text-white">MUTU</th>

                            <td class="text-info" colspan=19 style="font-weight: bold;">
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
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php else: ?>

            <div class="text-danger text-center"><i>Belum ada data responden yang sesuai.</i></div>

            <?php endif; ?>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('include_backend/template_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp-7.3.33\htdocs\surveiku_ikk\application\views/olah_data_keseluruhan/index.blade.php ENDPATH**/ ?>