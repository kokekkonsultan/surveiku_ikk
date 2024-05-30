@extends('include_backend/template_backend')

@php
$ci = get_instance();
@endphp

@section('style')

@endsection

@section('content')

<div class="container">

    <div class="row justify-content-md-center">
        <div class="col col-lg-9 mt-5">
        <form method="post" action="<?= base_url('lokasi-survei/insert-provinsi') ?>">


            <div class="card">
                <div class="card-header font-weight-bold">
                    <?= $title; ?>
                </div>
                <div class="card-body">

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Provinsi <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_provinsi" name="nama_provinsi"  required>
                        </div>
                    </div>

                </div>
            </div>



            <div class="text-right mt-5 mb-5">
                <a href="<?= base_url('lokasi-survei') ?>" class="btn btn-light-primary
                font-weight-bold
                shadow-lg">Cancel</a>
                <input type="submit" name="submit" value="<?= $title; ?>"  class="btn btn-primary font-weight-bold shadow-lg" />

            </div>

            </form>
        </div>
    </div>
</div>

@endsection

@section('javascript')

@endsection