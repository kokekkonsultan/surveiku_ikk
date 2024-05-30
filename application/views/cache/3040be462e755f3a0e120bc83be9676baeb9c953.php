

<?php
$ci = get_instance();
?>

<?php $__env->startSection('style'); ?>
<link href="<?php echo e(TEMPLATE_BACKEND_PATH); ?>plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
<style>
    .outer-box {
        font-family: arial;
        font-size: 24px;
        width: 580px;
        height: 114px;
        padding: 2px;
    }

    .box-edge-logo {
        font-family: arial;
        font-size: 14px;
        width: 110px;
        height: 110px;
        padding: 8px;
        float: left;
        text-align: center;
    }

    .box-edge-text {
        font-family: arial;
        font-size: 14px;
        width: 466px;
        height: 110px;
        padding: 8px;
        float: left;
    }

    .box-title {
        font-size: 18px;
        font-weight: bold;
    }

    .box-desc {
        font-size: 12px;
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

            <div class="card card-custom bgi-no-repeat gutter-b" style="height: 150px; background-color: #1c2840; background-position: calc(100% + 0.5rem) 100%; background-size: 100% auto; background-image: url(/assets/img/banner/rhone-2.svg)" data-aos="fade-down">
                <div class="card-body d-flex align-items-center">
                    <div>
                        <h3 class="text-white font-weight-bolder line-height-lg mb-5">
                            <?php echo e(strtoupper($title)); ?>

                        </h3>

                        <a class="btn btn-secondary font-weight-bold btn-sm shadow" target="_blank" href="<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/form-survei/opening' ?>"><i class="fas fa-solid fa-eye"></i> Lihat Tampilan Form Survei
                        </a>
                    </div>
                </div>
            </div>



            <div class="card card-custom card-sticky" data-aos="fade-down">

                <div class="card-body">

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">TAMPILAN LOGO SURVEI</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="saran-tab" data-toggle="tab" href="#saran" role="tab" aria-controls="saran" aria-selected="false">TAMPILAN BENNER FORM SURVEI</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">FORM SURVEI</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#target" role="tab" aria-controls="profile" aria-selected="false">TARGET SURVEI</a>
                        </li>
                    </ul>
                    <br>

                    <!-- LOGO -->
                    <div class=" tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                            <div class="text-right mb-5">
                                <button class=" btn btn-light-primary btn-sm" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                    <i class="fa fa-edit"></i> Edit Deskripsi Logo Survei
                                </button>
                            </div>

                            <div class="collapse" id="collapseExample">
                                <div class="card shadow card-body mb-5">

                                    <?php
                                    $title_header = unserialize($manage_survey->title_header_survey);
                                    $title_1 = $title_header[0];
                                    $title_2 = $title_header[1];
                                    ?>

                                    <form action="<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/form-survei/update-header' ?>" class="form_header">

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label font-weight-bold">Judul <span style="color: red;">*</span></label>
                                            <div class="col-sm-10">
                                                <textarea name="title[]" value="" class="form-control" required><?php echo $title_1 ?></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label font-weight-bold">Sub Judul <span style="color: red;">*</span></label>
                                            <div class="col-sm-10">
                                                <textarea name="title[]" value="" class="form-control" required><?php echo $title_2 ?></textarea>
                                            </div>
                                        </div>

                                        <div class="text-right">
                                            <button class="btn btn-secondary btn-sm" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                                Close
                                            </button>
                                            <button type="submit" class="btn btn-light-primary btn-sm font-weight-bold tombolSimpanHeader">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <nav class="navbar navbar-light bg-white shadow">
                                <div class="outer-box">
                                    <div class="box-edge-logo">
                                        <?php if ($data_user->foto_profile == NULL) { ?>
                                            <img src="<?php echo base_url(); ?>assets/klien/foto_profile/200px.jpg" width="100%" class="" alt="">
                                        <?php } else { ?>
                                            <img src="<?php echo base_url(); ?>assets/klien/foto_profile/<?php echo $data_user->foto_profile ?>" width="100%" class="" alt="">
                                        <?php  } ?>

                                    </div>
                                    <div class="box-edge-text">
                                        <div class="box-title">
                                            <?php echo $title_1 ?>
                                        </div>
                                        <div class="box-desc">
                                            <?php echo $title_2 ?>
                                        </div>
                                    </div>
                                </div>
                            </nav>

                        </div>


                        <!-- HEADER SURVEI -->
                        <div class="tab-pane fade" id="saran" role="tabpanel" aria-labelledby="saran-tab">

                            <div class="text-right mb-5">
                                <button class=" btn btn-light-primary btn-sm" type="button" data-toggle="collapse" data-target="#collapseHeader" aria-expanded="false" aria-controls="collapseExample">
                                    <i class="fa fa-edit"></i> Edit Benner Form Survei
                                </button>
                            </div>

                            <div class="collapse" id="collapseHeader">
                                <div class="card card-body shadow mb-5">
                                    <form class="uploadForm" action="<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/form-survei/do-uploud' ?>" method="POST">

                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="upload" id="profil">
                                            <label class="custom-file-label" for="validatedCustomFile">Choose
                                                file...</label>
                                        </div>
                                        <br>
                                        <small class="text-danger">* Format file harus jpg/png.<br>* Ukuran max
                                            file
                                            adalah 10MB.</small>

                                        <div class="text-right mt-3">
                                            <button class="btn btn-secondary btn-sm" type="button" data-toggle="collapse" data-target="#collapseHeader" aria-expanded="false" aria-controls="collapseExample">
                                                Close
                                            </button>
                                            <button type="submit" class="btn btn-primary btn-sm font-weight-bold tombolUploud">Uploud</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <?php if($manage_survey->img_benner == ''): ?>
                            <img class="card-img-top" src="<?php echo e(base_url()); ?>assets/img/site/page/banner-survey.jpg" alt="new image" />
                            <?php else: ?>
                            <img class="card-img-top shadow" src="<?php echo e(base_url()); ?>assets/klien/benner_survei/<?php echo e($manage_survey->img_benner); ?>" alt="new image">
                            <?php endif; ?>
                        </div>


                        <!-- FORM SARAN -->
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">


                            <form action="<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/form-survei/update-saran' ?>">


                                <div class="card card-body shadow">
                                    <h5 class="text-primary">Form Saran</h5>
                                    <hr>

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label font-weight-bold">Aktifkan Form
                                            Saran</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="is_saran" id="is_saran" value="<?php echo set_value('is_saran'); ?>">
                                                <option value="1" <?php echo $manage_survey->is_saran == 1 ? 'selected' : ''; ?>>Ya
                                                </option>
                                                <option value="2" <?php echo $manage_survey->is_saran == 2 ? 'selected' : ''; ?>>Tidak
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row" id="judul_saran" <?php echo $manage_survey->is_saran == 1 ? '' : 'style="display: none;"'; ?>>

                                        <label class=" col-sm-3 col-form-label font-weight-bold">Judul Form
                                            Saran</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" name="judul_form_saran" id="judul_form_saran" value="" rows="3"><?php echo $manage_survey->judul_form_saran ?></textarea>
                                        </div>
                                    </div>
                                </div>


                                <!-- <div class="card card-body mt-5 shadow">
                                    <h5 class="text-primary">Form Alasan</h5>
                                    <hr>

                                    <div class="form-group row mt-5">
                                        <label class="col-sm-3 col-form-label font-weight-bold">Tampilkan
                                            Form Alasan Pada <span style="color:red;">*</span></label>

                                        <div class="col-sm-9">

                                            <div class="radio-inline">
                                                <label class="radio">
                                                    <input type="radio" name="is_input_alasan" value="1"
                                                        <?php echo $is_input_alasan == 1 ? 'selected' : '' ?>>
                                                    <span></span> Opsi 1 s/d Opsi 2
                                                </label>
                                            </div>
                                            <span class="form-text text-muted">Pada pengisian survei maka akan
                                                diwajibkan mengisi alasan jika memilih pilihan ke 1 dan 2.</span>

                                            <hr>

                                            <div class="radio-inline">
                                                <label class="radio">
                                                    <input type="radio" name="is_input_alasan" value="2"
                                                        <?php echo $is_input_alasan == 2 ? 'selected' : '' ?>>
                                                    <span></span> Opsi 1 s/d Opsi 3
                                                </label>
                                            </div>
                                            <span class="form-text text-muted">Pada pengisian survei maka akan
                                                diwajibkan mengisi alasan jika memilih pilihan ke 1, 2, dan 3.</span>

                                        </div>
                                    </div>
                                </div> -->

                                <div class="text-right mt-7">
                                    <button type="submit" class="btn btn-primary font-weight-bold shadow tombolSimpanForm">Update Form
                                        Survei</button>
                                </div>
                            </form>
                        </div>




                        <!-- FORM TARGET -->
                        <div class="tab-pane fade" id="target" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="alert alert-custom alert-notice alert-light-primary fade show mb-10" role="alert">
                                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                <div class="alert-text"> <span>Halaman ini digunakan untuk mengatur penggunaan target
                                        pada survei.</span>
                                </div>
                                <div class="alert-close">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true"><i class="ki ki-close"></i></span>
                                    </button>
                                </div>
                            </div>

                            <form action="<?php echo e(base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/form-survei/update-form-target'); ?>" class="form_header" method="POST">

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label font-weight-bold">Gunakan
                                        Target pada Survei <span style="color:red;">*</span></label>

                                    <div class="col-sm-9">

                                        <div class="radio-inline">
                                            <label class="radio">
                                                <input type="radio" name="is_active_target" value="1" <?php echo $manage_survey->is_active_target == 1 ? 'checked' : '' ?>>
                                                <span></span> Ya
                                            </label>
                                        </div>
                                        <span class="form-text text-muted">Jika <b>Ya</b> maka survei harus menggunakan
                                            target pengisian.</span>

                                        <hr>

                                        <div class="radio-inline">
                                            <label class="radio">
                                                <input type="radio" name="is_active_target" value="2" <?php echo $manage_survey->is_active_target == 2 ? 'checked' : '' ?>>
                                                <span></span> Tidak
                                            </label>
                                        </div>
                                        <span class="form-text text-muted">Jika <b>Tidak</b> maka survei tidak
                                            menggunakan target pengisian.</span>

                                    </div>
                                </div>

                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary font-weight-bold tombolSimpanTarget">Update
                                        Target</button>
                                </div>
                            </form>
                        </div>


                    </div>
                </div>

            </div>


            <!-- ====================================  Deskripsi Pembuka Survei ========================================== -->
            <div class="card card-custom card-sticky mt-5" data-aos="fade-down">
                <div class="card-header">
                    <div class="card-title">
                        Deskripsi Pembuka Survei
                    </div>
                </div>
                <div class="card-body">

                    <form enctype="multipart/form-data" action="<?php echo e(base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/form-survei/update-display'); ?>" method="post" class="form-default">

                        <div class="form-group">
                            <textarea name="deskripsi" id="kt-ckeditor-1" value="" class="form-control" required> <?php echo $manage_survey->deskripsi_opening_survey; ?></textarea>
                        </div>


                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label font-weight-bold">Tambahkan Lampiran ? <span class="text-danger">*</span></label>
                            <div class="col-10 col-form-label">
                                <div class="radio-inline">
                                    <label class="radio radio">
                                        <input type="radio" name="is_lampiran" value="2" class="lampiran" <?php echo e($manage_survey->is_lampiran == 2 ? 'checked' : ''); ?> required>
                                        <span></span>
                                        Tidak
                                    </label>
                                </div>
                                <span class="form-text text-muted">Form Opening tidak menampilkan Lampiran.</span>
                                <hr>
                                <div class="radio-inline">
                                    <label class="radio radio">
                                        <input type="radio" name="is_lampiran" value="1" class="lampiran" <?php echo e($manage_survey->is_lampiran == 1 ? 'checked' : ''); ?>>
                                        <span></span>
                                        Ya
                                    </label>
                                </div>
                                <span class="form-text text-muted">Form Opening menampilkan Lampiran.</span>


                                <div id="form_lampiran" <?php echo $manage_survey->is_lampiran == 2 ? 'style="display:none"' : '' ?>>

                                    <div class="form-group mt-3">
                                        <label class="col-form-label font-weight-bold">Label Lampiran <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="label_lampiran" id="label_lampiran" placeholder="Masukkan Label ..." value="<?php echo e($manage_survey->label_lampiran); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label font-weight-bold">File Lampiran <span class="text-danger">*</span></label>

                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="userfile" id="file_lampiran" <?php echo e($manage_survey->file_lampiran == '' ? 'required' : ''); ?>>
                                            <label class="custom-file-label" for="validatedCustomFile">Choose
                                                file...</label>
                                        </div>
                                        <br>
                                        <small class="text-danger">* Format file harus pdf.<br>* Ukuran max
                                            file adalah 3MB.</small>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary font-weight-bold tombolSimpanPembuka">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>

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
        $(":radio.lampiran").click(function() {
            $("#form_lampiran").hide();
            if ($(this).val() == 1) {
                $("#label_lampiran").prop('required', true);
                $("#file_lampiran").prop('required', true);
                $("#form_lampiran").show();
            } else {
                $("#file_lampiran").removeAttr('required');
                $("#label_lampiran").removeAttr('required');
                $("#form_lampiran").hide();
            }
        });
    });
</script>


<script>
    $('.form_header').submit(function(e) {

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            cache: false,
            beforeSend: function() {
                $('.tombolSimpanHeader').attr('disabled', 'disabled');
                $('.tombolSimpanHeader').html('<i class="fa fa-spin fa-spinner"></i> Sedang diproses');
                $('.tombolSimpanTarget').attr('disabled', 'disabled');
                $('.tombolSimpanTarget').html('<i class="fa fa-spin fa-spinner"></i> Sedang diproses');



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
                $('.tombolSimpanHeader').removeAttr('disabled');
                $('.tombolSimpanHeader').html('Update');
                $('.tombolSimpanTarget').removeAttr('disabled');
                $('.tombolSimpanTarget').html('Update Target');
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
                    }, 1500);
                }
            }
        })
        return false;
    });

    $('.form_default').submit(function(e) {
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            cache: false,
            beforeSend: function() {
                $('.tombolSimpanForm').attr('disabled', 'disabled');
                $('.tombolSimpanForm').html('<i class="fa fa-spin fa-spinner"></i> Sedang diproses');
                $('.tombolSimpanPembuka').attr('disabled', 'disabled');
                $('.tombolSimpanPembuka').html('<i class="fa fa-spin fa-spinner"></i> Sedang diproses');

            },
            complete: function() {
                $('.tombolSimpanForm').removeAttr('disabled');
                $('.tombolSimpanForm').html('Update Form Survei');
                $('.tombolSimpanPembuka').removeAttr('disabled');
                $('.tombolSimpanPembuka').html('Update Deskripsi');
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
                }
            }
        })
        return false;
    });
</script>


<script type="text/javascript">
    $('.uploadForm').submit(function(e) {
        e.preventDefault();

        var reader = new FileReader();
        reader.readAsDataURL(document.getElementById('profil').files[0]);

        var formdata = new FormData();
        formdata.append('file', document.getElementById('profil').files[0]);
        $.ajax({
            method: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            data: formdata,
            dataType: 'json',
            url: $(this).attr('action'),
            beforeSend: function() {
                $('.tombolUploud').attr('disabled', 'disabled');
                $('.tombolUploud').html('<i class="fa fa-spin fa-spinner"></i> Sedang diproses');

            },
            complete: function() {
                $('.tombolUploud').removeAttr('disabled');
                $('.tombolUploud').html('Uploud');
            },
            error: function(e) {
                Swal.fire(
                    'Error !',
                    e,
                    'error'
                )
            },

            success: function(data) {
                if (data.error) {
                    toastr["danger"]('Data gagal disimpan');
                } else {
                    $('.uploadForm')[0].reset();
                    toastr["success"]('Data berhasil disimpan');
                    window.setTimeout(function() {
                        location.reload()
                    }, 1000);
                }

            }
        });
    });
</script>

<script type="text/javascript">
    $(function() {
        $("#is_saran").change(function() {
            console.log($("#is_saran option:selected").val());
            if ($("#is_saran option:selected").val() == 1) {
                $("#judul_form_saran").prop('required', true);
                $('#judul_saran').show();

            } else {
                $("#judul_form_saran").removeAttr('required');
                $('#judul_saran').hide();
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('include_backend/template_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp-7.3.33\htdocs\surveiku_ikk\application\views/form_survei/index.blade.php ENDPATH**/ ?>