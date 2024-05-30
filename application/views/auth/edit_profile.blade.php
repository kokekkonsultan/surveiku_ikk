@extends('include_backend/template_backend')

@php
$ci = get_instance();
@endphp

@section('style')
<style type="text/css">
    body {
        margin: 0;
        color: #2e323c;
        background: #f5f6fa;
        position: relative;
        height: 100%;
    }

    .account-settings .user-profile {
        margin: 0 0 1rem 0;
        padding-bottom: 1rem;
        text-align: center;
    }

    .account-settings .user-profile .user-avatar {
        margin: 0 0 1rem 0;
    }

    .account-settings .user-profile .user-avatar img {
        width: 90px;
        height: 90px;
        -webkit-border-radius: 100px;
        -moz-border-radius: 100px;
        border-radius: 100px;
    }

    .account-settings .user-profile h5.user-name {
        margin: 0 0 0.5rem 0;
    }

    .account-settings .user-profile h6.user-email {
        margin: 0;
        font-size: 0.8rem;
        font-weight: 400;
        color: #9fa8b9;
    }

    .account-settings .about {
        margin: 2rem 0 0 0;
        text-align: center;
    }

    .account-settings .about h5 {
        margin: 0 0 15px 0;
        color: #007ae1;
    }

    .account-settings .about p {
        font-size: 0.825rem;
    }

    .form-control {
        border: 1px solid #cfd1d8;
        -webkit-border-radius: 2px;
        -moz-border-radius: 2px;
        border-radius: 2px;
        font-size: 12px;
        background: #ffffff;
        color: #2e323c;
    }

    .card {
        background: #ffffff;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        border: 0;
        margin-bottom: 1rem;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row gutters">
        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
            <div class="card h-100">
                <div class="card-body">
                    <div class="account-settings">
                        <div class="user-profile">
                            <div class="user-avatar">
                                <?php if ($data_user->foto_profile == NULL) : ?>
                                    <img src="{{ base_url() }}assets/klien/foto_profile/200px.jpg" alt="" style="width: 150px; height:150px;">
                                <?php else : ?>
                                    <img src="{{ base_url() }}assets/klien/foto_profile/{{ $data_user->foto_profile }}" alt="" style="width: 150px; height:150px;">
                                <?php endif; ?>
                            </div>
                            <br>
                            <h5 class="user-name text-primary">{{ $data_user->first_name }} {{ $data_user->last_name }}</h5>
                            <h6 class="user-email">{{ $data_user->company }}</h6>
                        </div>
                        <div class="about">
                            <button class="btn btn-light-primary btn-sm font-weight-bold" type="button" data-toggle="collapse" data-target="#ubahfoto" aria-expanded="false" aria-controls="collapseExample">
                                Ubah Foto
                            </button>
                            <br>
                            <div class="collapse mt-3 mb-3 text-start" id="ubahfoto">
                                <form id="uploadForm">
                                    <div class="card">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="upload" id="profil">
                                            <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                                        </div>
                                        </br>
                                        <div class="mt-5">
                                            <a class="btn btn-secondary btn-sm" data-toggle="collapse" href="#ubahfoto" role="button" aria-expanded="false" aria-controls="ubahfoto">
                                                Cancel
                                            </a>
                                            <button type="submit" class="btn btn-primary btn-sm">Uploud</button>
                                        </div>
                                    </div>
                                </form>
                                <div id="responseDiv" class="alert text-center" style="display:none;">
                                    <button type="button" class="close" id="clearMsg"><span aria-hidden="true">&times;</span></button>
                                    <span id="message"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
            <div class="card h-100">
                <div class="card-body">
                    <form method="post" action="<?= $form_action ?>" enctype="multipart/form-data">
                        <div class="row gutters">

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mb-2 text-primary">Detail Profil</h6>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Nama Depan</label>
                                    <input type="text" class="form-control" name="first_name" placeholder="" value="{{ $data_user->first_name }}" autofocus>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Nama Belakang</label>
                                    <input type="text" class="form-control" name="last_name" placeholder="" value="{{ $data_user->last_name }}">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="" value="{{ $data_user->email }}">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="website">Telephon</label>
                                    <input type="num" class="form-control" name="phone" placeholder="" value="{{ $data_user->phone }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Organisasi</label>
                                    <textarea type="text" class="form-control" name="company" rows="3" value="{{ $data_user->company }}">{{ $data_user->company }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row gutters mt-5 ">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="text-right">
                                    <a class="btn btn-secondary" href="<?php echo base_url() . $ci->session->userdata('username') ?>">Cancel</a>
                                    <button type="submit" id="submit" name="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function() {
        $('#uploadForm').submit(function(e) {
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
                url: "<?php echo base_url() . $ci->session->userdata('username') . '/profile/update-foto' ?>",
                success: function(response) {
                    console.log(response);
                    if (response.error) {
                        $('#responseDiv').removeClass('alert-success').addClass(
                                'alert-danger')
                            .show();
                        $('#message').html(response.message);
                    } else {
                        $('#responseDiv').removeClass('alert-danger').addClass(
                                'alert-success')
                            .show();
                        setInterval('location.reload()', 1000);

                        $('#message').html(response.message);
                        $('#uploadForm')[0].reset();
                    }
                }
            });
        });

        $('#clearMsg').click(function() {
            $('#responseDiv').hide();
        });

    });
</script>
@endsection