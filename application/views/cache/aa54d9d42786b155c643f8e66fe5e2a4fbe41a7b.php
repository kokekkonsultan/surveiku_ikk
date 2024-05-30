

<?php
$ci = get_instance();
?>

<?php $__env->startSection('style'); ?>
<style>
.border-menu {
    border-color: #304EC0 !important;
    background-color: #f3f3f3;
}
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <?php echo $__env->make("include_backend/partials_no_aside/_inc_menu_repository", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="row mt-5">
        <div class="col-md-3">
            <?php echo $__env->make('manage_survey/menu_data_survey', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-md-9">

            <div class="card card-custom bgi-no-repeat gutter-b"
                style="height: 150px; background-color: #1c2840; background-position: calc(100% + 0.5rem) 100%; background-size: 100% auto; background-image: url(/assets/img/banner/rhone-2.svg)"
                data-aos="fade-down">
                <div class="card-body d-flex align-items-center">
                    <div>
                        <h3 class="text-white font-weight-bolder line-height-lg mb-5">
                            <?php echo e(strtoupper($title)); ?>

                        </h3>
                    </div>
                </div>
            </div>

            <div class="card card-custom card-sticky" data-aos="fade-down">
                <div class="card-body">
                    <?php echo $ci->session->set_flashdata('message_success') ?>

                    <div class="mb-5">
                        <p>Dengan scan barcode dapat mempermudah responden untuk menuju ke link survei. Anda bisa
                            memberika informasi scan barcode melalui cetak tulisan yang bisa ditempelkan, agar bisa
                            menjangkau responden yang berada di tempat umum. Tersedia pilihan yang bisa anda gunakan
                            untuk mencetak scan barcode.</p>
                        Pilih desain yang anda inginkan:
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo e(base_url()); ?><?php echo e($ci->session->userdata('username')); ?>/<?php echo e($ci->uri->segment(2)); ?>/scan-barcode/do?bg=light"
                                target="_blank" title="Pilih desain dengan latar belakang terang">
                                <div class="text-center shadow card-menu"
                                    style="border: 1px solid #333333; padding: 10px; border-radius: 10px;">
                                    <h5 class="text-dark">Latar Belakang Terang</h5>
                                    <img src="<?php echo e(base_url()); ?>assets/img/bg-scan/small-background-light.jpg" alt=""
                                        width="200px;" style="border: 1px solid #f3f3f3;">
                                </div>
                            </a>
                        </div>

                        <div class="col-md-6">
                            <a href="<?php echo e(base_url()); ?><?php echo e($ci->session->userdata('username')); ?>/<?php echo e($ci->uri->segment(2)); ?>/scan-barcode/do?bg=dark"
                                target="_blank" title="Pilih desain dengan latar belakang gelap">
                                <div class="text-center shadow card-menu"
                                    style="border: 1px solid #333333; padding: 10px; border-radius: 10px;">
                                    <h5 class="text-dark">Latar Belakang Gelap</h5>
                                    <img src="<?php echo e(base_url()); ?>assets/img/bg-scan/small-background-dark.jpg" alt=""
                                        width="200px;" style="border: 1px solid #f3f3f3;">
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-5" data-aos="fade-down">
                <div class="card-header font-weight-bold">
                    Custom
                </div>
                <div class="card-body">
                    <p>
                        Anda juga bisa membuat desain scan barcode sendiri. Dibawah ini disediakan Qrcode yang bisa anda
                        letakkan di desain anda.
                    </p>

                    <form
                        action="<?php echo e(base_url()); ?><?php echo e($ci->session->userdata('username')); ?>/<?php echo e($ci->uri->segment(2)); ?>/scan-barcode/get"
                        method="POST">
                        <div class="mb-3">
                            <label for="lbl_1" class="form-label">Link Survei Anda</label>
                            <?php echo form_error('link'); ?>

                            <span class="text-danger"><?php echo e(base_url()); ?>survei/<?php echo e($ci->uri->segment(2)); ?></span>
                            <input type="hidden" name="link" class="form-control" id="lbl_1" aria-describedby="help_1"
                                value="<?php echo e(base_url()); ?>survei/<?php echo e($ci->uri->segment(2)); ?>">
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="with_logo" class="form-check-input" id="lbl_2">
                            <label class="form-check-label" for="lbl_2">Sertakan Logo pada QrCode</label>
                        </div>
                        <button type="submit" class="btn btn-primary fw-bold">Request QrCode</button>
                    </form>

                </div>
            </div>

            <?php if($ci->session->userdata('qr_result')): ?>
            <div class="card mt-5 mb-5" data-aos="fade-down">
                <div class="card-body text-center">
                    <img src="<?php echo e($ci->session->userdata('qr_result')); ?>" style="width: 200px;" />
                    <br><br>
                    <p>Link : <?php echo e($ci->session->userdata('qr_link')); ?></p>
                    <br><br>
                    <?php echo anchor(base_url().$ci->session->userdata('username').'/'.$ci->uri->segment(2).'/scan-barcode/download',
                    'Download QR Code', ['class' => 'btn btn-primary']); ?> <?php echo anchor(base_url().$ci->session->userdata('username').'/'.$ci->uri->segment(2).'/scan-barcode/clear-data',
                    'Delete', ['class' => 'btn btn-danger']); ?>

                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script>
$('.card-menu').hover(
    function() {
        $(this).addClass('border-menu shadow')
    },
    function() {
        $(this).removeClass('border-menu shadow')
    }
)
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('include_backend/template_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp-7.3.33\htdocs\surveiku_ikk\application\views/scan_barcode/index.blade.php ENDPATH**/ ?>