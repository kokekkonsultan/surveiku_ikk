

<?php
$ci = get_instance();
?>

<?php $__env->startSection('style'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container">

    <div class="row justify-content-md-center">
        <div class="col col-lg-9 mt-5">
            <?php echo form_open("pengguna-klien/create-klien"); ?>


            <div class="card card-body mb-5">

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label font-weight-bold">Dari Reseller ? <span
                            class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <div class="radio-list mb-5">
                            <label class="radio"><input type="radio" name="res" id="2" value="2"
                                    class="tamplate"><span></span>&nbsp Tidak</label>
                            <label class="radio"><input type="radio" name="res" id="1" value="1"
                                    class="tamplate"><span></span>&nbsp Ya</label>
                        </div>
                        <?php echo form_dropdown($is_reseller); ?>

                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header font-weight-bold">
                    Data PIC Klien
                </div>
                <div class="card-body">
                    <div id="infoMessage text-danger"><?php echo $message; ?></div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Depan <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <?php echo form_input($first_name); ?>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Belakang <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <?php echo form_input($last_name); ?>

                        </div>
                    </div>

                    <?php if($identity_column !== 'email'): ?>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Username <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <?php echo form_error('identity'); ?>

                            <?php echo form_input($identity); ?>

                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Organisasi <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <?php echo form_input($company); ?>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Email <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <?php echo form_input($email); ?>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">HP <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <?php echo form_input($phone); ?>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Password <span class="text-danger">*</span></label>
                        <div class="col-sm-9">

                            <div class="input-group">
                                <?php echo form_input($password); ?>

                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-eye"></i></span>
                                </div>
                            </div>

                            <a class="text-primary font-weight-bold mt-3 mb-5" data-toggle="modal"
                                title="Generate Password" onclick="showuserdetail(1)" href="#exampleModal"><i
                                    class="fas fa-key text-primary"></i> Generate Password</a>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Ulangi Password <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <?php echo form_input($password_confirm); ?>

                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-5">
                <div class="card-header font-weight-bold">
                    Survei
                </div>
                <div class="card-body">
                    <!-- <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Klasifikasi Survei <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <span class="font-weight-bold">IKK</span>
                            
                        </div>
                    </div> -->

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Kelompok Skala <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <div class="radio-list mb-5">
                                <?php $__currentLoopData = $kelompok_skala->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <label class="radio"><input type="radio" name="id_kelompok_skala" value="<?php echo e($row->id); ?>"
                                        class="tamplate"><span></span>&nbsp <?php echo e($row->nama_kelompok_skala); ?></label>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-5">
                <div class="card-header font-weight-bold">
                    Berlangganan
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Jadikan Sebagai Pengguna Trial <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <span class="switch switch-sm">
                                <label>
                                    <input value="1" type="checkbox" name="is_trial" id="toggle-event-subscrpbe"
                                        class="toggle_dash" checked />
                                    <span></span>
                                </label>
                            </span>
                        </div>
                    </div>

                    <section id="section-trial">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Paket Trial <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <?php echo form_dropdown($id_paket_trial); ?>

                            </div>
                        </div>
                    </section>

                    <style>
                    #section-subscrpbe {
                        display: none;
                    }
                    </style>

                    <section id="section-subscrpbe">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Paket Langganan <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <?php echo form_dropdown($id_paket); ?>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Metode Pembayaran <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <?php echo form_dropdown($id_metode_pembayaran); ?>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Tanggal Mulai Berlangganan <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"
                                                aria-hidden="true"></i></span>
                                    </div>
                                    <?php echo form_input($tanggal_mulai); ?>

                                </div>

                            </div>
                        </div>

                    </section>
                </div>
            </div>

            <div class="text-right mt-5 mb-5">
                <?php echo anchor(base_url().'pengguna-klien', 'Cancel', ['class' => 'btn btn-light-primary font-weight-bold
                shadow-lg']); ?>

                <?php echo form_submit('submit', 'Create Klien', ['class' => 'btn btn-primary font-weight-bold shadow-lg']); ?>

            </div>

            <?php echo form_close(); ?>

        </div>
    </div>


</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body" id="bodyModalDetail">
                <div align="center" id="loading_registration">
                    <img src="<?php echo e(base_url()); ?>assets/img/ajax/ajax-loader-big.gif" alt="">
                </div>

            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script>
$('#toggle-event-subscrpbe').change(function() {
    if ($('#toggle-event-subscrpbe').is(":checked")) {

        $("#section-trial").slideDown();
        $("#id_paket_trial").prop('required', true);

        $("#section-subscrpbe").slideUp();
        $('#id_paket').removeAttr('required');
        $('#id_metode_pembayaran').removeAttr('required');
        $('#tanggal_mulai').removeAttr('required');
    } else {

        $("#section-trial").slideUp();
        $('#id_paket_trial').removeAttr('required');

        $("#section-subscrpbe").slideDown();
        $("#id_paket").prop('required', true);
        $("#id_metode_pembayaran").prop('required', true);
        $("#tanggal_mulai").prop('required', true);
    }
});

$(function() {
    // $( "#datepicker" ).datepicker({
    //     dateFormat: 'yy-mm-dd',
    // });
});
</script>
<script>
var btn = document.getElementById("open_modal");

btn.onclick = function() {
    $('#exampleModal').modal('show');
}

function showuserdetail(id) {
    $('#bodyModalDetail').html(
        "<div class='text-center'><img src='<?php echo e(base_url()); ?>assets/img/ajax/ajax-loader-big.gif'></div>");

    $.ajax({
        type: "post",
        url: "<?php echo e(base_url()); ?>auth/generate-password",
        data: "id=" + id,
        dataType: "text",
        success: function(response) {

            $('.modal-title').text('Generate Password');
            $('#bodyModalDetail').empty();
            $('#bodyModalDetail').append(response);
        }
    });
}
</script>
<script>
! function($) {
    //eyeOpenClass: 'fa-eye',
    //eyeCloseClass: 'fa-eye-slash',
    'use strict';

    $(function() {
        $('[data-toggle="password"]').each(function() {
            var input = $(this);
            var eye_btn = $(this).parent().find('.input-group-text');
            eye_btn.css('cursor', 'pointer').addClass('input-password-hide');
            eye_btn.on('click', function() {
                if (eye_btn.hasClass('input-password-hide')) {
                    eye_btn.removeClass('input-password-hide').addClass('input-password-show');
                    eye_btn.find('.fa').removeClass('fa-eye').addClass('fa-eye-slash')
                    input.attr('type', 'text');
                } else {
                    eye_btn.removeClass('input-password-show').addClass('input-password-hide');
                    eye_btn.find('.fa').removeClass('fa-eye-slash').addClass('fa-eye')
                    input.attr('type', 'password');
                }
            });
        });
    });

}(window.jQuery);
</script>

<!-- <script>
var KTSelect2 = function() {
    var demos = function() {
        $('#is_reseller').select2({
            placeholder: 'Please Select'
        });
    }

    return {
        init: function() {
            demos();
        }
    };
}();

jQuery(document).ready(function() {
    KTSelect2.init();
});
</script> -->

<script type="text/javascript">
$(function() {
    $(":radio.tamplate").click(function() {
        $("#is_reseller").hide()
        if ($(this).val() == "1") {
            $("#is_reseller").show().prop('required', true);
        } else {
            $("#is_reseller").removeAttr('required').hidden();
        }
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('include_backend/template_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp-7.3.33\htdocs\surveiku_ikk\application\views/auth/form_create_klien.blade.php ENDPATH**/ ?>