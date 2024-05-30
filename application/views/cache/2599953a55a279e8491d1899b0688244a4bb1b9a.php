

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
                <div class="card-header bg-secondary font-weight-bold">
                    <?php echo e($title); ?>

                </div>
                <div class="card-body">

                    <?php echo form_open($form_action); ?>


                    <span class="text-danger mb-3"><?php echo validation_errors(); ?></span>

                    <div class="form-group row">
                        <label class="col-sm-2 font-weight-bold col-form-label">Dimensi <span style="color: red;">*</span></label>
                        <div class="col-sm-10">
                            <?php echo form_dropdown($id_dimensi); ?>


                            <div class="row mt-3">
                                <div class="col-sm-5">
                                    <div class="font-weight-bold text-danger" id="bobot_tersimpan"></div>
                                </div>

                                <div class="col-sm-5">
                                    <div class="font-weight-bold text-danger" id="target_bobot"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input name="kode_unsur" value="U<?php echo e($kode_unsur); ?>" hidden>
                    <div class="form-group row">
                        <label class="col-sm-2 font-weight-bold col-form-label">Unsur <span class="text-danger">*</span></label>
                        <div class="col-sm-10">

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">U<?php echo e($kode_unsur); ?></span>
                                </div>
                                <?php echo form_textarea($nama_unsur); ?>

                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 font-weight-bold col-form-label">Pertanyaan <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <?php echo form_textarea($pertanyaan_unsur); ?>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 font-weight-bold col-form-label">Bobot Unsur <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <?php echo form_input($bobot_pertanyaan_unsur); ?>

                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">%</span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label font-weight-bold">Tampilkan Alasan Jawaban di Form Survei ? <span style="color:red;">*</span></label>
                        <div class="col-10 col-form-label">
                            <div class="radio-inline">
                                <label class="radio radio-md">
                                    <input type="radio" name="is_active_alasan" value="1" class="is_alasan" required>
                                    <span></span>
                                    Ya
                                </label>
                            </div>
                            <div class="mt-3 mb-5" id="inputan" style="display:none;">
                                <input class="form-control" name="label_alasan" placeholder="Silahkan isi label jika ditampilkan alasan ..." value="">
                                <small class="text-dark-50">Jika kosong maka label akan di isi default (Masukkan alasan jawaban pada bidang ini ...)</small>



                                <div class="form-group row mt-5">
                                    <label class="col-sm-3 col-form-label font-weight-bold">Munculkan Alasan pada ?
                                        <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <div class="checkbox-list">
                                            <label class="checkbox">
                                                <input type="checkbox" name="atribute_alasan[]" value="1" checked>
                                                <span></span> Pilihan Jawaban 1
                                            </label>
                                            <label class="checkbox">
                                                <input type="checkbox" name="atribute_alasan[]" value="2" checked>
                                                <span></span> Pilihan Jawaban 2
                                            </label>
                                            <label class="checkbox">
                                                <input type="checkbox" name="atribute_alasan[]" value="3">
                                                <span></span> Pilihan Jawaban 3
                                            </label>
                                            <label class="checkbox">
                                                <input type="checkbox" name="atribute_alasan[]" value="4">
                                                <span></span> Pilihan Jawaban 4
                                            </label>
                                            <label class="checkbox">
                                                <input type="checkbox" name="atribute_alasan[]" value="5">
                                                <span></span> Pilihan Jawaban 5
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr>
                            <div class="radio-inline">
                                <label class="radio radio-md">
                                    <input type="radio" name="is_active_alasan" value="2" class="is_alasan">
                                    <span></span>
                                    Tidak
                                </label>
                            </div>
                            <!-- <span class="form-text text-muted">Pilih jika profil bertipe pilihan.</span> -->
                        </div>
                    </div>







                    <br>
                    <h5 class="text-primary">Pilihan Jawaban</h5>
                    <hr>

                    <datalist id="data_pilihan_jawaban">
                        <?php foreach ($pilihan->result() as $d) {
                            echo "<option value='$d->id'>$d->pilihan_1</option>";
                        }
                        ?>
                    </datalist>

                    <div class="form-group row">
                        <label class="col-sm-3 font-weight-bold col-form-label">Pilihan Jawaban 1 <span style="color: red;">*</span></label>
                        <div class="col-sm-9">
                            <input type="hidden" value="1" name="nilai_jawaban[]">
                            <input class="form-control pilihan" list="data_pilihan_jawaban" type="text" name="pilihan_jawaban[]" id="id" placeholder="Masukkan pilihan jawaban anda .." onchange="return autofill();" autofocus autocomplete='off' required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 font-weight-bold col-form-label">Pilihan Jawaban 2 <span style="color: red;">*</span></label>
                        <div class="col-sm-9">
                            <input type="hidden" value="2" name="nilai_jawaban[]">
                            <input type="text" class="form-control pilihan" name="pilihan_jawaban[]" id="pilihan_2" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 font-weight-bold col-form-label">Pilihan Jawaban 3 <span style="color: red;">*</span></label>
                        <div class="col-sm-9">
                            <input type="hidden" value="3" name="nilai_jawaban[]">
                            <input type="text" class="form-control pilihan" name="pilihan_jawaban[]" id="pilihan_3" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 font-weight-bold col-form-label">Pilihan Jawaban 4 <span style="color: red;">*</span></label>
                        <div class="col-sm-9">
                            <input type="hidden" value="4" name="nilai_jawaban[]">
                            <input type="text" class="form-control pilihan" name="pilihan_jawaban[]" id="pilihan_4" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 font-weight-bold col-form-label">Pilihan Jawaban 5 <span style="color: red;">*</span></label>
                        <div class="col-sm-9">
                            <input type="hidden" value="5" name="nilai_jawaban[]">
                            <input type="text" class="form-control pilihan" name="pilihan_jawaban[]" id="pilihan_5" required>
                        </div>
                    </div>

                    <div class="text-right">
                        <?php
                        echo
                        anchor(base_url().$ci->session->userdata('username').'/'.$ci->uri->segment(2).'/pertanyaan-unsur',
                        'Batal', ['class' => 'btn btn-light-primary font-weight-bold'])
                        ?>

                        <button class="btn btn-primary font-weight-bold tombolSimpan" type="submit">Simpan</button>
                    </div>
                    <?php echo form_close(); ?>

                </div>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script src="<?php echo e(base_url()); ?>assets/themes/metronic/assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js"></script>
<script src="<?php echo e(base_url()); ?>assets/themes/metronic/assets/js/pages/crud/forms/editors/ckeditor-classic.js"></script>

<script type="text/javascript">
    $(function() {
        $(":radio.is_alasan").click(function() {
            $("#inputan").hide()
            if ($(this).val() == "1") {
                $("#inputan").show();

                // $("#id_klasifikasi_survey").prop('required', true);
                // $("#id_klasifikasi_survey").removeAttr('required');


            } else {
                $("#inputan").hidden();
            }
        });
    });
</script>

<script>
    function autofill() {
        var id = document.getElementById('id').value;
        $.ajax({
            url: "<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/pertanyaan-unsur/cari' ?>",
            data: '&id=' + id,
            success: function(data) {
                var hasil = JSON.parse(data);

                $.each(hasil, function(key, val) {

                    document.getElementById('id').value = val.pilihan_1;
                    document.getElementById('pilihan_2').value = val.pilihan_2;
                    document.getElementById('pilihan_3').value = val.pilihan_3;
                    document.getElementById('pilihan_4').value = val.pilihan_4;
                    document.getElementById('pilihan_5').value = val.pilihan_5;
                });
            }
        });
    }
</script>


<script>
    function autofill_dimensi() {
        var id = $("#id_dimensi").val();
        $.ajax({
            method: "POST",
            url: "<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/pertanyaan-unsur/autofill-dimensi/' ?>" +
                id,
            dataType: 'json',
            async: true,
            success: function(data) {

                document.getElementById("bobot_tersimpan").innerHTML = 'Total Bobot Tersimpan = ' + data
                    .bobot_tersimpan + '%';
                document.getElementById("target_bobot").innerHTML = 'Target Bobot Dimensi = ' + data.target +
                    '%';


                $("#bobot_pertanyaan_unsur").keyup(function() {
                    var bobot_tersimpan = data.bobot_tersimpan;
                    var persentase_unsur = $("#bobot_pertanyaan_unsur").val();
                    var total_dimensi = data.target;

                    if ((parseInt(bobot_tersimpan) + parseInt(persentase_unsur)) > total_dimensi) {

                        $('.tombolSimpan').attr('disabled', 'disabled');
                        $('.tombolSimpan').html('Bobot Sudah Melebihi Target Dimensi');
                        alert(
                            'Bobot Unsur yang anda masukkan sudah melebihi Target Dimensi yang dipilih!'
                        );

                    } else {
                        $('.tombolSimpan').removeAttr('disabled');
                        $('.tombolSimpan').html('Simpan');
                    }
                    // var total_bobot = (parseInt(bobot_tersimpan) + parseInt(persentase_unsur));
                    // $("#total_bobot").val(Math.ceil(total_bobot) + ' %');
                });
            }
        });
        return false;
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('include_backend/template_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp-7.3.33\htdocs\surveiku_ikk\application\views/pertanyaan_unsur_survei/form_add.blade.php ENDPATH**/ ?>