

<?php
$ci = get_instance();
?>

<?php $__env->startSection('style'); ?>
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container mt-5 mb-5" style="font-family:Arial, Helvetica, sans-serif;">
    <div class="text-center" data-aos="fade-up">
        <div id="progressbar" class="mb-5">
            <li id="account"><strong>Data Responden</strong></li>
            <li id="personal"><strong>Pertanyaan Survei</strong></li>
            <?php if($status_saran == 1): ?>
            <li id="payment"><strong>Saran</strong></li>
            <?php endif; ?>
            <li id="completed"><strong>Completed</strong></li>
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow" data-aos="fade-up">
                <?php if($judul->img_benner == ''): ?>
                <img class="card-img-top" src="<?php echo e(base_url()); ?>assets/img/site/page/banner-survey.jpg" alt="new image" />
                <?php else: ?>
                <img class="card-img-top shadow" src="<?php echo e(base_url()); ?>assets/klien/benner_survei/<?php echo e($manage_survey->img_benner); ?>" alt="new image">
                <?php endif; ?>
                <div class="card-body">
                    <div>
                        <?php echo $manage_survey->deskripsi_opening_survey; ?>

                    </div>
         
                    <br>
                    <br>
                    <a class="btn btn-warning btn-block font-weight-bold shadow" onclick="getLocation()">IKUT SURVEI</a>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script src="<?php echo e(TEMPLATE_BACKEND_PATH); ?>plugins/custom/datatables/datatables.bundle.js"></script>
<script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"></script>

<script>
function getLocation() {

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        Swal.fire({ 
            icon: 'error',
            title: 'Error',
            html: 'Geolocation tidak didukung oleh browser ini, silahkan gunakan browser lain.',
            confirmButtonColor: '#8950FC',
            confirmButtonText: 'Baik, Terimakasih',
        });
    }
}

function showError(error) {
    console.log(error);
    Swal.fire({ 
        icon: 'info',
        title: 'Informasi',
        html: 'Silakan aktifkan izin lokasi di perangkat anda untuk bisa melanjutkan ke pengisian survei.',
        confirmButtonColor: '#8950FC',
        confirmButtonText: 'Baik, Terimakasih',
    }).then((result) => {
        if (result.value) {
            location.reload();
        }
    });
}

function showPosition(position) {
    var lat = position.coords.latitude;
    var lng = position.coords.longitude;
    
    console.log(position.coords);
    location.href = "<?php echo e($url_next); ?>?lat=" + lat + '&lng=' + lng;
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('include_backend/_template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp-7.3.33\htdocs\surveiku_ikk\application\views/survei/form_opening.blade.php ENDPATH**/ ?>