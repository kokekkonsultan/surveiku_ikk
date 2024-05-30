

<?php
$ci = get_instance();
?>

<?php $__env->startSection('style'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-light-primary font-weight-bold">
            Prosedur Penggunaan Aplikasi
        </div>
        <div class="card-body">
            <p>
                <i class="fas fa-info-circle"></i> Anda dapat mempelajari aplikasi ini melalui prosedur
                penggunaan aplikasi dibawah ini.
            </p>
            <object type="application/pdf" data="<?php echo e(base_url()); ?>assets/files/prosedur/modul-eikk-2022.pdf" width="100%" height="700">
            </object>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('include_backend/template_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp-7.3.33\htdocs\surveiku_ikk\application\views/dashboard/prosedur_aplikasi.blade.php ENDPATH**/ ?>