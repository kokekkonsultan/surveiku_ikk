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
                    @php
                    echo form_open($form_action);
                    echo validation_errors();
                    @endphp


                    <div class=" form-row">
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">Wilayah Survei <span style="color:red;">*</span></label>
                            @php
                            echo form_dropdown($wilayah_survei);
                            @endphp
                        </div>
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">Kode Surveyor <span style="color:red;">*</span></label>
                            @php
                            echo form_input($kode_surveyor);
                            @endphp
                        </div>
                    </div>

                    <div class=" form-row">
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">First Name <span style="color:red;">*</span></label>
                            @php
                            echo form_input($first_name);
                            @endphp
                        </div>
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">Last Name <span style="color:red;">*</span></label>
                            @php
                            echo form_input($last_name);
                            @endphp
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">Email</label>
                            @php
                            echo form_input($email);
                            @endphp
                        </div>
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">Company Name <span style="color:red;">*</span></label>
                            @php
                            echo form_input($company);
                            @endphp
                        </div>
                    </div>


                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">Phone <span style="color:red;">*</span></label>
                            @php
                            echo form_input($phone);
                            @endphp
                        </div>

                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">Status Surveyor <span style="color:red;">*</span></label>
                            <select class="form-control" name="is_active" id="is_active">

                                <option value='1' <?php echo $is_active == 1 ? "selected" : '' ?>>Aktif
                                </option>
                                <option value='2' <?php echo $is_active == 2 ? "selected" : '' ?>>Tidak Aktif
                                </option>

                            </select>
                        </div>
                    </div>


                    <br>


                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">Password <span style="color:red;">*</span></label>
                            @php
                            echo form_input($password);
                            @endphp
                        </div>
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">Confirm Password <span style="color:red;">*</span></label>
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

                    <?php echo form_close(); ?>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection

@section('javascript')

@endsection