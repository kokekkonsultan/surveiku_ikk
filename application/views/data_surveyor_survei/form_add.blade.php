@extends('include_backend/template_backend')

@php
$ci = get_instance();
@endphp

@section('style')

@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">

            @include('manage_survey/menu_data_survey')

        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <b> {{ $title }}</b>
                </div>
                <div class="card-body">

                    <div id="infoMessage"><?php echo $message; ?></div>

                    <form
                        action="<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/data-surveyor-survei/add' ?>"
                        method="POST">


                        <div class="form-group">
                            <label style="background-color: yellow; font-weight:bold;">&nbsp; Pilih Wilayah Survei
                                &nbsp;</label>
                            @php
                            echo form_dropdown($wilayah_survei);
                            @endphp
                        </div>



                        <br>
                        <span style="background-color: yellow; font-weight:bold;">&nbsp; Identitas Surveyor
                            &nbsp;</span>
                        <hr>


                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Nama Depan <span style="color: red;">*</span></label>
                                @php
                                echo form_input($first_name);
                                @endphp
                            </div>

                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Nama Belakang <span style="color: red;">*</span></label>
                                @php
                                echo form_input($last_name);
                                @endphp
                            </div>
                        </div>

                        <div class="form-row">
                            @php
                            if ($identity_column !== 'email') {
                            echo '<div class="form-group col-md-6">';
                                echo '<label class="font-weight-bold">Username <span
                                        style="color:red;">*</span></label>';
                                echo form_error('identity');
                                echo form_input($identity);
                                echo '</div>';
                            }
                            @endphp

                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Kode Surveyor <span style="color: red;">*</span></label>
                                @php
                                echo form_input($kode_surveyor);
                                @endphp
                            </div>
                        </div>

                        <div>
                            <label class="font-weight-bold">Company <span style="color: red;">*</span></label>
                            @php
                            echo form_input($company);
                            @endphp
                        </div>

                        <br>

                        <div>
                            <label class="font-weight-bold">Email <span style="color: red;">*</span></label>
                            @php
                            echo form_input($email);
                            @endphp
                        </div>

                        <br>

                        <div>
                            <label class="font-weight-bold">Phone <span style="color: red;">*</span></label>
                            @php
                            echo form_input($phone);
                            @endphp
                        </div>

                        <br>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Password <span style="color: red;">*</span></label>
                                @php
                                echo form_input($password);
                                @endphp
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Confirm Password <span
                                        style="color: red;">*</span></label>
                                @php
                                echo form_input($password_confirm);
                                @endphp
                            </div>
                        </div>

                        <div class="text-right">
                            <a href="<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/data-surveyor-survei' ?>"
                                class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection

@section('javascript')

@endsection