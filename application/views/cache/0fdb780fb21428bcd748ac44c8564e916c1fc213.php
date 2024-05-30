

<?php
$ci = get_instance();
?>

<?php $__env->startSection('style'); ?>
<!-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> -->

<style>
    .form-radio {
        font-size: 16px;
        text-transform: capitalize;
        font-family: Arial, Helvetica, sans-serif;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


<div class="container mt-5 mb-5" style="font-family:Arial, Helvetica, sans-serif;">
    <div class="text-center" data-aos="fade-up">
        <div id="progressbar" class="mb-5">
            <li class="active" id="account"><strong>Data Responden</strong></li>
            <li class="active" id="personal"><strong>Pertanyaan Survei</strong></li>
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
            <div class="card shadow" data-aos="fade-up" id="kt_blockui_content" style="font-size: 16px; font-family:Arial, Helvetica, sans-serif;">
                <?php if($manage_survey->img_benner == ''): ?>
                <img class="card-img-top" src="<?php echo e(base_url()); ?>assets/img/site/page/banner-survey.jpg" alt="new image" />
                <?php else: ?>
                <img class="card-img-top shadow" src="<?php echo e(base_url()); ?>assets/klien/benner_survei/<?php echo e($manage_survey->img_benner); ?>" alt="new image">
                <?php endif; ?>

                <div class="card-header text-center">
                    <div class="mt-5 mb-5" style="background-color: #FCF7B6; padding: 5px; font-size: 16px;
                        font-family:Arial,Helvetica,sans-serif; font-weight: bold; text-transform: uppercase;">
                        BERIKAN PENILAIAN SAUDARA TERHADAP UNSUR-UNSUR KEBERDAYAAN KONSUMEN <br>
                        <span class="text-danger"><?php echo $__env->make('include_backend/partials_backend/_tanggal_survei', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></span>
                    </div>
                </div>

                <form action="<?php echo e(base_url() . 'survei/' . $ci->uri->segment(2) . '/add-pertanyaan/' . $ci->uri->segment(4)); ?>" class="form_survei" method="POST">

                    <div class="card-body ml-5 mr-5">
                        <br>

                        <!-- PERTANYAAN UNSUR -->
                        <?php $__currentLoopData = $pertanyaan_unsur->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $get): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <input type="hidden" name="id_pertanyaan_unsur[<?php echo e($get->id_pertanyaan_unsur); ?>]" value="<?php echo e($get->id_pertanyaan_unsur); ?>">
                        <table width="100%" border="0" class="mt-5 mb-5">
                            <tr>
                                <td width="5%" valign="top">
                                    <p><span style="font-size:16px;"><?php echo e($get->kode_unsur); ?>. </span></p>
                                </td>
                                <td width="95%"><?php echo $get->isi_pertanyaan; ?></td>
                            </tr>

                            <tr>
                                <td></td>
                                <td>
                                    <div class="form-group radio-list">

                                        <label class="radio radio-lg radio-outline radio-outline-3x radio-primary" style=" font-size: 16px; font-weight:bold;">
                                            <input type="radio" name="jawaban_pertanyaan_unsur[<?php echo e($get->id_pertanyaan_unsur); ?>]" value="1" class="<?php echo e($get->id_pertanyaan_unsur); ?>" required <?= $get->skor_jawaban == 1 ? 'checked' : '' ?>>
                                            <span></span>
                                            <?php echo e($get->jawaban_1); ?>

                                        </label>

                                        <label class="radio radio-lg radio-outline radio-outline-3x radio-primary" style=" font-size: 16px; font-weight:bold;">
                                            <input type="radio" name="jawaban_pertanyaan_unsur[<?php echo e($get->id_pertanyaan_unsur); ?>]" value="2" class="<?php echo e($get->id_pertanyaan_unsur); ?>" required <?= $get->skor_jawaban == 2 ? 'checked' : '' ?>>
                                            <span></span>
                                            <?php echo e($get->jawaban_2); ?>

                                        </label>

                                        <label class="radio radio-lg radio-outline radio-outline-3x radio-primary" style=" font-size: 16px; font-weight:bold;">
                                            <input type="radio" name="jawaban_pertanyaan_unsur[<?php echo e($get->id_pertanyaan_unsur); ?>]" value="3" class="<?php echo e($get->id_pertanyaan_unsur); ?>" required <?= $get->skor_jawaban == 3 ? 'checked' : '' ?>>
                                            <span></span>
                                            <?php echo e($get->jawaban_3); ?>

                                        </label>

                                        <label class="radio radio-lg radio-outline radio-outline-3x radio-primary" style=" font-size: 16px; font-weight:bold;">
                                            <input type="radio" name="jawaban_pertanyaan_unsur[<?php echo e($get->id_pertanyaan_unsur); ?>]" value="4" class="<?php echo e($get->id_pertanyaan_unsur); ?>" required <?= $get->skor_jawaban == 4 ? 'checked' : '' ?>>
                                            <span></span>
                                            <?php echo e($get->jawaban_4); ?>

                                        </label>

                                        <label class="radio radio-lg radio-outline radio-outline-3x radio-primary" style=" font-size: 16px; font-weight:bold;">
                                            <input type="radio" name="jawaban_pertanyaan_unsur[<?php echo e($get->id_pertanyaan_unsur); ?>]" value="5" class="<?php echo e($get->id_pertanyaan_unsur); ?>" required <?= $get->skor_jawaban == 5 ? 'checked' : '' ?>>
                                            <span></span>
                                            <?php echo e($get->jawaban_5); ?>

                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <?php
                                    $atribute_alasan = unserialize($get->atribute_alasan);
                                    ?>
                                    <textarea class="form-control" id="<?php echo e($get->id_pertanyaan_unsur); ?>" name="alasan[<?php echo e($get->id_pertanyaan_unsur); ?>]" value="" placeholder="<?php echo e($get->label_alasan); ?>" <?= in_array($get->skor_jawaban, $atribute_alasan) ? 'required' : 'style="display:none"' ?> rows="3"><?php echo e($get->alasan_pilih_jawaban); ?></textarea>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <br>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>




                        <!-- PERTANYAAN TERBUKA -->
                        <?php $__currentLoopData = $pertanyaan_terbuka->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <input name="id_pertanyaan_terbuka[<?php echo e($row->id); ?>]" value="<?php echo e($row->id); ?>" hidden>
                        <table width="100%" border="0" class="mt-5 mb-5">
                            <tr>
                                <td width="5%" valign="top">
                                    <p><span style="font-size:16px;"><?php echo e($row->nomor_pertanyaan_terbuka); ?>. </span></p>
                                </td>
                                <td width="95%"><?php echo $row->isi_pertanyaan_terbuka; ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <div class="form-group radio-list">

                                        <?php $__currentLoopData = $ci->db->get_where("kategori_pertanyaan_terbuka_$manage_survey->table_identity", ['id_pertanyaan_terbuka' => $row->id])->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <label class="radio radio-lg radio-outline radio-outline-3x radio-primary" style=" font-size: 16px; font-weight:bold;">
                                            <input type="radio" name="jawaban_pertanyaan_terbuka[<?php echo e($row->id); ?>]" value="<?php echo e($val->nama_kategori_pertanyaan_terbuka); ?>" required <?= $val->nama_kategori_pertanyaan_terbuka == $row->jawaban ? 'checked' : '' ?>>
                                            <span></span>
                                            <?php echo e($val->nama_kategori_pertanyaan_terbuka); ?>

                                        </label>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <br>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                    </div>
                    <div class="card-footer">
                        <table class="table table-borderless">
                            <tr>
                                <td class="text-left">
                                    <?php if($ci->uri->segment(5) == 'edit'): ?>
                                    <a class="btn btn-secondary btn-lg shadow" href="<?php echo e(base_url() . 'survei/' . $ci->uri->segment(2) . '/data-responden/' . $ci->uri->segment(4) . '/edit'); ?>"><i class="fa fa-arrow-left"></i> Kembali</a>
                                    <?php endif; ?>
                                </td>
                                <td class="text-right">
                                    <button type="submit" class="btn btn-warning btn-lg font-weight-bold shadow-lg tombolSave">Selanjutnya
                                        <i class="fa fa-arrow-right"></i></button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>

<?php $__currentLoopData = $ci->db->get_where("pertanyaan_unsur_$manage_survey->table_identity", array('is_active_alasan' =>
1))->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
$atribute_alasan = unserialize($pr->atribute_alasan);

$data = [];
foreach($atribute_alasan as $value){
$data[] = '$(this).val() ==' . $value;
}
$pilihan = implode(" || ", $data);
?>
<script type="text/javascript">
    $(function() {
        $(":radio.<?php echo e($pr->id); ?>").click(function() {
            $("#<?php echo e($pr->id); ?>").hide()
            if (<?= $pilihan ?>) {
                $("#<?php echo e($pr->id); ?>").show().prop('required', true);
            } else {
                $("#<?php echo e($pr->id); ?>").removeAttr('required').hidden();
            }
        });
    });
</script>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<script>
    $('.form_survei').submit(function(e) {

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            cache: false,
            beforeSend: function() {
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
                if (data.full) {
                    // Swal.fire({
                    //     icon: 'info',
                    //     title: 'Oops...',
                    //     text: data.full
                    // })

                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        html: data.full,
                        showConfirmButton: false,
                        allowOutsideClick: false

                    });

                }
                if (data.sukses) {
                    // toastr["success"]('Data berhasil disimpan');

                    setTimeout(function() {
                        window.location.href = "<?php echo e($url_next); ?>";
                    }, 500);
                }
            }
        })
        return false;
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('include_backend/_template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp-7.3.33\htdocs\surveiku_ikk\application\views/survei/form_pertanyaan.blade.php ENDPATH**/ ?>