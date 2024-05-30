

<?php
$ci = get_instance();
?>

<?php $__env->startSection('style'); ?>
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container mt-5 mb-5" style="font-family: nunito;">
    <div class="text-center" data-aos="fade-up">
        <div id="progressbar" class="mb-5">
            <li class="active" id="account"><strong>Data Responden</strong></li>
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
            <div class="card shadow" data-aos="fade-up" id="kt_blockui_content"
                style="font-size: 16px; font-family:Arial, Helvetica, sans-serif;">
                <?php if($manage_survey->img_benner == ''): ?>
                <img class="card-img-top" src="<?php echo e(base_url()); ?>assets/img/site/page/banner-survey.jpg"
                    alt="new image" />
                <?php else: ?>
                <img class="card-img-top shadow"
                    src="<?php echo e(base_url()); ?>assets/klien/benner_survei/<?php echo e($manage_survey->img_benner); ?>" alt="new image">
                <?php endif; ?>
                <div class="card-header text-center">
                    <h4><b>DATA RESPONDEN</b> - <?php echo $__env->make('include_backend/partials_backend/_tanggal_survei', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></h4>
                </div>


                <form
                    action="<?php echo base_url() . 'survei/' . $ci->uri->segment(2) . '/data-responden/' . $ci->uri->segment(4) . '/update' ?>"
                    class="form_responden" method="POST">


                    <div class="card-body">
                        <span style="color: red; font-style: italic;"><?php echo validation_errors(); ?></span>
                        <div class="form-group">
                            <label class="font-weight-bold">Nama Lengkap <span class="text-danger">*</span></label>
                            <?php echo form_input($nama_lengkap); ?>

                        </div>

                        </br>

                        <?php $__currentLoopData = $profil_responden->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <?php
                        $nama_alias = $row->nama_alias;
                        ?>

                        <div class="form-group">
                            <label class="font-weight-bold"><?php echo $row->nama_profil_responden ?> <span
                                    class="text-danger">*</span></label>

                            <?php if($row->jenis_isian == 2): ?>
                            <input class="form-control" type="<?php echo $row->type_data ?>"
                                name="<?php echo $row->nama_alias ?>" placeholder="Masukkan data anda ..."
                                value="<?php echo $responden->$nama_alias ?>" required>
                            <?php else: ?>
                            <select class="form-control" name="<?php echo $row->nama_alias ?>" required>
                                <option value="">Please Select</option>

                                <?php $__currentLoopData = $kategori_profil_responden->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($value->id_profil_responden == $row->id): ?>
                                <option value="<?php echo $value->id ?>"
                                    <?php echo $responden->$nama_alias == $value->id ? 'selected' : '' ?>>
                                    <?php echo $value->nama_kategori_profil_responden ?></option>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </select>
                            <?php endif; ?>

                        </div>
                        </br>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="card-footer">
                        <table class="table table-borderless">
                            <tr>
                                <td class="text-left">

                                </td>
                                <td class="text-right">
                                    <button type="submit"
                                        class="btn btn-warning btn-lg font-weight-bold shadow tombolSave">Selanjutnya <i
                                            class="fa fa-arrow-right"></i></button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
            </div>

            <br><br>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>

<script>
$('.form_responden').submit(function(e) {

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        dataType: 'json',
        data: $(this).serialize(),
        cache: false,
        beforeSend: function() {
            $('.tombolCancel').attr('disabled', 'disabled');
            $('.tombolSave').attr('disabled', 'disabled');
            $('.tombolSave').html('<i class="fa fa-spin fa-spinner"></i> Sedang diproses');

            KTApp.block('#kt_blockui_content', {
                overlayColor: '#FFA800',
                state: 'primary',
                message: 'Processing...'
            });

            setTimeout(function() {
                KTApp.unblock('#kt_blockui_content');
            }, 1000);

        },
        complete: function() {
            $('.tombolCancel').removeAttr('disabled');
            $('.tombolSave').removeAttr('disabled');
            $('.tombolSave').html('Selanjutnya <i class="fa fa-arrow-right"></i>');
        },

        error: function(e) {
            Swal.fire(
                'Error !',
                e,
                'error'
            )
        },

        success: function(data) {
            if (data.validasi) {
                $('.pesan').fadeIn();
                $('.pesan').html(data.validasi);
            }
            if (data.sukses) {
                // toastr["success"]('Data berhasil disimpan');

                setTimeout(function() {
                    window.location.href =
                        "<?php echo base_url() . 'survei/' . $ci->uri->segment(2) . '/pertanyaan/' . $ci->uri->segment(4) . '/edit' ?>";
                }, 500);
            }
        }
    })
    return false;
});
</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('include_backend/_template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp-7.3.33\htdocs\surveiku_ikk\application\views/survei/edit_data_responden.blade.php ENDPATH**/ ?>