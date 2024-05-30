

<?php
$ci = get_instance();
?>

<?php $__env->startSection('style'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">

            <?php echo $__env->make('manage_survey/menu_data_survey', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        </div>
        <div class="col-md-9">
            <div class="card shadow" data-aos="fade-down" data-aos-delay="300">
                <div class="card-header font-weight-bold bg-secondary">
                    <b> <?php echo e($title); ?></b>
                </div>
                <div class="card-body font-size-h6 font-weight-normal" id="kt_blockui_content">

                    <?php echo form_open($form_action); ?>

                    <span class="text-danger mb-3"><?php echo validation_errors(); ?></span>


                    <div class="form-group row">
                        <label class="col-sm-2 font-weight-bold col-form-label">Dimensi <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input value="<?php echo $dimensi; ?>" class="form-control" disabled>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-2 font-weight-bold col-form-label">Unsur <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><?php echo $kode_unsur; ?></span>
                                </div>
                                <?php echo form_textarea($nama_unsur); ?>

                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 font-weight-bold col-form-label">Pertanyaan Unsur <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <?php echo form_textarea($pertanyaan_unsur); ?>

                        </div>
                    </div>

                    <!-- <div class="form-group row">
                        <label class="col-sm-2 font-weight-bold col-form-label">Persentase Bobot <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <?php echo form_input($persentase_unsur); ?>

                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">%</span>
                                </div>
                            </div>
                        </div>
                    </div> -->


                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label font-weight-bold">Tampilkan Alasan Jawaban di Form Survei ? <span style="color:red;">*</span></label>
                        <div class="col-10 col-form-label">
                            <div class="radio-inline">
                                <label class="radio radio-md">
                                    <input type="radio" name="is_active_alasan" value="1" class="is_alasan" required <?php echo $pertanyaan->is_active_alasan == 1 ? 'checked' : '' ?>>
                                    <span></span>
                                    Ya
                                </label>
                            </div>
                            <div class="mt-3 mb-5" id="inputan" <?php echo $pertanyaan->is_active_alasan == 1 ? "" : "style='display: none;'" ?>>
                                <input class="form-control" name="label_alasan" id="label_alasan" placeholder="Silahkan isi label jika ditampilkan alasan ..." value="<?php echo e($pertanyaan->label_alasan); ?>">
                                <small class="text-dark-50">Jika kosong maka label akan di isi default (Masukkan alasan jawaban pada bidang ini ...)</small>

                                <?php
                                $atribute_alasan = unserialize($pertanyaan->atribute_alasan);
                                ?>
                                <div class="form-group row mt-5">
                                    <label class="col-sm-3 col-form-label font-weight-bold">Munculkan Alasan pada ?
                                        <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <div class="checkbox-list">
                                            <label class="checkbox">
                                                <input type="checkbox" name="atribute_alasan[]" value="1" <?php echo e(in_array(1, $atribute_alasan) ? 'checked' : ''); ?>>
                                                <span></span> Pilihan Jawaban 1
                                            </label>
                                            <label class="checkbox">
                                                <input type="checkbox" name="atribute_alasan[]" value="2" <?php echo e(in_array(2, $atribute_alasan) ? 'checked' : ''); ?>>
                                                <span></span> Pilihan Jawaban 2
                                            </label>
                                            <label class="checkbox">
                                                <input type="checkbox" name="atribute_alasan[]" value="3" <?php echo e(in_array(3, $atribute_alasan) ? 'checked' : ''); ?>>
                                                <span></span> Pilihan Jawaban 3
                                            </label>
                                            <label class="checkbox">
                                                <input type="checkbox" name="atribute_alasan[]" value="4" <?php echo e(in_array(4, $atribute_alasan) ? 'checked' : ''); ?>>
                                                <span></span> Pilihan Jawaban 4
                                            </label>
                                            <label class="checkbox">
                                                <input type="checkbox" name="atribute_alasan[]" value="5" <?php echo e(in_array(5, $atribute_alasan) ? 'checked' : ''); ?>>
                                                <span></span> Pilihan Jawaban 5
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="radio-inline">
                                <label class="radio radio-md">
                                    <input type="radio" name="is_active_alasan" value="2" class="is_alasan" <?php echo $pertanyaan->is_active_alasan == 2 ? 'checked' : '' ?>>
                                    <span></span>
                                    Tidak
                                </label>

                            </div>
                        </div>
                    </div>



                    <br>
                    <h5 class="tex t -primar y">Pilihan Jawaban</h5>
                    <hr>

                    <?php
                    $no = 1;
                    foreach ($nilai_unsur_pelayanan as $row) {
                        ?>
                        <input type="tex t" name="id[ ]" value=" < ?php echo $row->id; ?>" hidden>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Pilihan Jawaban
                                <?php echo $no++; ?> <span style="color: red;">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="nama_jawaban[]" value="<?php echo $row->nama_jawaban; ?>" required>
                            </div>
                        </div>
                    <?php
                }
                ?>

                    <div class="text-right">
                        <?php echo anchor(base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) .  '/pertanyaan-unsur', 'Kembali', ['class' => 'btn btn-secondary font-weight-bold shadow']); ?>
                        <input type="submit" class="btn btn-primary font-weight-bold shadow" value="Simpan">
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script src="<?php echo e(base_url()); ?>assets/themes/metronic/assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js"></script>
<script src="<?php echo e(base_url()); ?>assets/themes/metronic/assets/js/pages/crud/forms/editors/ckeditor-classic.js"></script>

<script type="text/javascript">
    $(function() {
        $(":radio.is_alasan").click(function() {
            $("#inputan").hide()
            if ($(this).val() == "1") {
                $("#inputan").show();
            } else {
                $("#inputan").hidden();
            }
        });
    });
</script>

<!-- <script type="text/javascript">
$(document).ready(function() {
    $("#persentase_unsur").keyup(function() {
        var total_bobot_edit = <?php echo $total_persentase ?>;
        var persentase_edit = $("#persentase_unsur").val();

        if ((parseInt(total_bobot_edit) + parseInt(persentase_edit)) > 100) {
            $('.tombolEdit').attr('disabled', 'disabled');
            $('.tombolEdit').html('Bobot Sudah Melebihi 100%');
            alert('Bobot anda sudah melebihi 100%');

        } else {
            $('.tombolEdit').removeAttr('disabled');
            $('.tombolEdit').html('Simpan');
        }
    });
});
</script> -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('include_backend/template_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp-7.3.33\htdocs\surveiku_ikk\application\views/pertanyaan_unsur_survei/form_edit.blade.php ENDPATH**/ ?>