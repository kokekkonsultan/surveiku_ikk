

<?php
$ci = get_instance();
?>

<?php $__env->startSection('style'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <?php echo $__env->make("include_backend/partials_no_aside/_inc_menu_repository", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('include_backend/partials_backend/_message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="row mt-5">
        <div class="col-md-3">
            <?php echo $__env->make('manage_survey/menu_data_survey', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-md-9">
            <div class="row justify-content-md-center">
                <div class="col col-lg-12" data-aos="fade-down">
                    <?php echo $__env->make('setting_survei/menu_settings', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <div class="card border-primary mt-5">
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                        aria-controls="home" aria-selected="true">ATUR PERIODE</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                                        aria-controls="profile" aria-selected="false">TUNDA PERIODE</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tampilan-tab" data-toggle="tab" href="#tampilan" role="tab"
                                        aria-controls="tampilan" aria-selected="false">LIHAT TAMPILAN</a>
                                </li>
                            </ul>

                            <br>

                            <!-- TANGGAL SURVEY -->
                            <div class=" tab-content" id="myTabContent">

                                <div class="tab-pane fade show active" id="home" role="tabpanel"
                                    aria-labelledby="home-tab">

                                    <form
                                        action="<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/setting-survei/periode' ?>"
                                        class="form_periode">

                                        <div class="alert alert-custom alert-notice alert-light-primary fade show"
                                            role="alert">
                                            <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                            <div class="alert-text">Atur periode digunakan untuk mengatur tanggal survey
                                                dibuka dan tanggal survey ditutup. Jika tanggal survey dikosongkan, maka
                                                survey akan ditutup.</div>
                                            <div class="alert-close">
                                                <button type="button" class="close" data-dismiss="alert"
                                                    aria-label="Close">
                                                    <span aria-hidden="true"><i class="ki ki-close"></i></span>
                                                </button>
                                            </div>
                                        </div>

                                        </br>

                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label font-weight-bold">Tanggal Survey
                                                Dibuka</label>
                                            <div class="col-sm-8">
                                                <?php
                                                echo form_input($survey_start);
                                                ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label font-weight-bold">Tanggal Survey
                                                Ditutup</label>
                                            <div class="col-sm-8">
                                                <?php
                                                echo form_input($survey_end);
                                                ?>
                                            </div>
                                        </div>

                                        <div class="form-check">
                                            <label><input class="form-check-input" type="checkbox" value="1"
                                                    name="hapus_periode">
                                                <div class="form-check-label font-weight-bold" style="color: red;">
                                                    Hapus Periode
                                                </div>
                                            </label>
                                        </div>
                                        <span class="font-italic">(Jika di centang maka periode akan di
                                            kosongkan)</span>

                                        <br>

                                        <div class="text-right">
                                            <button type="submit"
                                                class="btn btn-primary font-weight-bold tombolSimpanPeriode">Update
                                                Periode</button>
                                        </div>
                                    </form>

                                </div>

                                <!-- TUNDA SURVEY -->
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                                    <form
                                        action="<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/setting-survei/tunda' ?>"
                                        class="form_tunda">

                                        <div class="alert alert-custom alert-notice alert-light-primary fade show"
                                            role="alert">
                                            <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                            <div class="alert-text">Tunda Survey digunakan jika anda ingin menunda
                                                survey
                                                sementara waktu. Menunda survey juga akan menghapus semua data responden
                                                yang sudah ada.</div>
                                            <div class="alert-close">
                                                <button type="button" class="close" data-dismiss="alert"
                                                    aria-label="Close">
                                                    <span aria-hidden="true"><i class="ki ki-close"></i></span>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label font-weight-bold">Tunda
                                                Periode</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" id="is_privacy" name="is_privacy"
                                                    value="<?php echo set_value('is_privacy'); ?>">
                                                    <option value="1" <?php if ($manage_survey->is_privacy == "1") {
                                                                            echo "selected";
                                                                        } ?>>Tidak</option>
                                                    <option value="2" <?php if ($manage_survey->is_privacy == "2") {
                                                                            echo "selected";
                                                                        } ?>>Ya</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="font-weight-bold">Deskripsi Penundaan</label>
                                            <?php
                                            echo form_textarea($deskripsi_tunda);
                                            ?>

                                        </div>

                                        <div class="font-italic font-weight-bold">
                                            <span style="color: red;">**</span> Bila anda menunda periode, anda bisa
                                            memberikan informasi terkait penundaan survey, jika bidang ini dikosongkan
                                            maka
                                            tidak akan ditampilkan
                                        </div>

                                        </br>

                                        <div class="text-right">
                                            <button type="submit"
                                                class="btn btn-primary font-weight-bold tombolSimpanTunda">Update
                                                Periode</button>
                                        </div>

                                    </form>
                                </div>




                                <!-- TAMPILAN -->
                                <div class="tab-pane fade" id="tampilan" role="tabpanel" aria-labelledby="tampilan-tab">

                                    <div class="text-left">

                                        <?php
                                        echo anchor(base_url() . 'survey/' . $ci->uri->segment(2) . '/survey-hold', '<i class="fas fa-solid fa-eye"></i> Lihat Tampilan Survey di Tunda', ['class' => 'btn btn-light-primary font-weight-bold', 'target' => '_blank']);
                                        ?>

                                        <br> <br>

                                        <?php
                                        echo anchor(base_url() . 'survey/' . $ci->uri->segment(2) . '/unopened', '<i class="fas fa-solid fa-eye"></i> Lihat Tampilan Survey Belum Dibuka', ['class' => 'btn btn-light-primary font-weight-bold', 'target' => '_blank']);
                                        ?>

                                        <br> <br>

                                        <?php
                                        echo anchor(base_url() . 'survey/' . $ci->uri->segment(2) . '/survey-end', '<i class="fas fa-solid fa-eye"></i> Lihat Tampilan Survey Sudah Berakhir', ['class' => 'btn btn-light-primary font-weight-bold', 'target' => '_blank']);
                                        ?>

                                        <br> <br>

                                        <?php
                                        echo anchor(base_url() . 'survey/' . $ci->uri->segment(2) . '/survey-not-question', '<i class="fas fa-solid fa-eye"></i> Lihat Tampilan Pertanyaan Belum Lengkap', ['class' => 'btn btn-light-primary font-weight-bold', 'target' => '_blank']);
                                        ?>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    
    

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script src="<?php echo e(base_url()); ?>assets/themes/metronic/assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js"></script>
<script src="<?php echo e(base_url()); ?>assets/themes/metronic/assets/js/pages/crud/forms/editors/ckeditor-classic.js"></script>

<script>
    var KTTinymce = function() {
        // Private functions
        var demos = function() {
            tinymce.init({
                selector: '#tinymce-survei',
                menubar: false,
                statusbar: false,
                branding: false,
                toolbar: [
                    'undo redo | cut copy paste | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent | code'
                ],
                plugins: 'advlist autolink link image lists charmap print preview code'
            });
        }

        return {
            // public functions
            init: function() {
                demos();
            }
        };
    }();

    // Initialization
    jQuery(document).ready(function() {
        KTTinymce.init();
    });
</script>

<script>
$('.form_periode').submit(function(e) {

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        dataType: 'json',
        data: $(this).serialize(),
        cache: false,
        beforeSend: function() {
            $('.tombolSimpanPeriode').attr('disabled', 'disabled');
            $('.tombolSimpanPeriode').html('<i class="fa fa-spin fa-spinner"></i> Sedang diproses');

            KTApp.block('#content_1', {
                overlayColor: '#000000',
                state: 'primary',
                message: 'Processing...'
            });

            setTimeout(function() {
                KTApp.unblock('#content_1');
            }, 1000);

        },
        complete: function() {
            $('.tombolSimpanPeriode').removeAttr('disabled');
            $('.tombolSimpanPeriode').html('Update Periode');
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
                toastr["success"]('Data berhasil disimpan');
                window.setTimeout(function() {
                    location.reload()
                }, 2500);
            }
        }
    })
    return false;
});

$('.form_tunda').submit(function(e) {

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        dataType: 'json',
        data: $(this).serialize(),
        cache: false,
        beforeSend: function() {
            $('.tombolSimpanTunda').attr('disabled', 'disabled');
            $('.tombolSimpanTunda').html('<i class="fa fa-spin fa-spinner"></i> Sedang diproses');

            KTApp.block('#content_1', {
                overlayColor: '#000000',
                state: 'primary',
                message: 'Processing...'
            });

            setTimeout(function() {
                KTApp.unblock('#content_1');
            }, 1000);

        },
        complete: function() {
            $('.tombolSimpanTunda').removeAttr('disabled');
            $('.tombolSimpanTunda').html('Update Periode');
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
                toastr["success"]('Data berhasil disimpan');
                window.setTimeout(function() {
                    location.reload()
                }, 2500);
            }
        }
    })
    return false;

});

    function delete_data(id) {
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Anda akan menghapus survey ini beserta semua datanya!",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Batal',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya'
        }).then((result) => {
            if (result.value) {

                $.ajax({
                    url: "<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/settings/delete' ?>",
                    type: "POST",
                    dataType: "JSON",
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Memproses data',
                            html: 'Mohon tunggu sebentar. Sistem sedang melakukan request anda.',
                            allowOutsideClick: false,
                            onOpen: () => {
                                swal.showLoading()
                            }
                        });
                    },
                    success: function(data) {
                        if (data.status) {

                            window.location.href = "<?php echo e(base_url().$ci->session->userdata('username').'/kelola-survei'); ?>";

                        } else {

                        }


                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error deleting data');
                    }
                });

            }
        });

    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('include_backend/template_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp-7.3.33\htdocs\surveiku_ikk\application\views/setting_survei/index.blade.php ENDPATH**/ ?>