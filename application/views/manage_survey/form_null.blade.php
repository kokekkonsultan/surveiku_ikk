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
    @include("include_backend/partials_no_aside/_inc_menu_repository")
    <div class="row">
        <div class="col-md-3">

            @include('manage_survey/menu_data_survey')

        </div>
        <div class="col-md-9">
            <div class="card card-custom card-sticky" data-aos="fade-down" data-aos-delay="300">
                <div class="card-header">
                    <div class="card-title">{{ $title }}</div>
                    <div class="card-header"></div>
                </div>

                <div class="card-body">
                    <div class="alert alert-custom alert-notice alert-light-primary fade show" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                        <div class="alert-text">Survei belum dimulai atau belum ada responden !</div>
                        <div class="alert-close">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"><i class="ki ki-close"></i></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')

@endsection