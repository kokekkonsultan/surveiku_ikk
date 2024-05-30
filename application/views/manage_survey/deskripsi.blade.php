@extends('include_backend/template_backend')

@php
$ci = get_instance();
@endphp

@section('style')
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
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">

            @include('manage_survey/menu_data_survey')

        </div>
        <div class="col-md-9">
        <div class="card shadow" data-aos="fade-down" data-aos-delay="300">
                <div class="card-header bg-secondary font-weight-bold">
                    {{ $title }}
                </div>
                <div class="card-body">

                    <table class="table">
                        <tr>
                            <th width="30%">Nama Survei</th>
                            <td>{{ $manage_survey->survey_name }}</td>
                        </tr>
                        <tr>
                            <th>Deskripsi</th>
                            <td>{{ $manage_survey->description }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Survei Dimulai</th>
                            <td>{{ date('d-m-Y', strtotime($manage_survey->survey_start)) }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Survei Berakhir</th>
                            <td>{{ date('d-m-Y', strtotime($manage_survey->survey_end)) }}</td>
                        </tr>
                        <tr>
                            <th>Klasifikasi Survei</th>
                            <td>{{ $manage_survey->nama_klasifikasi_survey }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Sampling</th>
                            <td>{{ $manage_survey->nama_sampling }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah Populasi</th>
                            <td>{{ $manage_survey->jumlah_populasi }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <br>

            <div class="card shadow" data-aos="fade-down" data-aos-delay="300">
                <div class="card-header">
                    <div class="row">
                        <div class="col sm-6">
                            <b>Desain Header Form Survei</b>
                        </div>
                        <div class="col sm-6 text-right">
                            <button class=" btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                <i class="fa fa-edit"></i> Edit Header Survei
                            </button>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div class="collapse" id="collapseExample">
                        <div class="card shadow">

                            <div class="card-body">
                                <?php echo form_open($form_action, ['class' => '']); ?>
                                <?php echo validation_errors(); ?>
                                <div class="form-group">
                                    <textarea name="title" id="kt-ckeditor-1" value="" class="form-control" required>
                                        <?php echo $manage_survey->title_header_survey ?>
                                    </textarea>
                                </div>
                                <div class="text-right">
                                    <button class="btn btn-secondary btn-sm" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                        Close
                                    </button>
                                    <input type="submit" class="btn btn-primary" value="Simpan">
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                        <br>
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
                                    SURVEI INDEKS KEBERDAYAAN KONSUMEN
                                </div>
                                <div class="box-desc">
                                    <?php echo $manage_survey->title_header_survey ?>
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection

@section('javascript')
<script src="{{ base_url() }}assets/themes/metronic/assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js"></script>
<script src="{{ base_url() }}assets/themes/metronic/assets/js/pages/crud/forms/editors/ckeditor-classic.js"></script>

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
@endsection