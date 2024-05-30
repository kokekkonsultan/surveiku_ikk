@extends('include_backend/template_backend')

@php
$ci = get_instance();
@endphp

@section('style')

@endsection

@section('content')

<div class="container">

    <div class="card shadow mb-5" data-aos="fade-up">
        <div class="card-header bg-secondary font-weight-bold">
            Barang Jasa
        </div>
        <div class="card-body">
            {!! $table_barang_jasa !!}
        </div>
    </div>

    <div class="card shadow mb-5" data-aos="fade-up">
        <div class="card-header bg-secondary font-weight-bold">
            Jenis Kelamin
        </div>
        <div class="card-body">
            {!! $table_jenis_kelamin !!}
        </div>
    </div>

    <div class="card shadow mb-5" data-aos="fade-up">
        <div class="card-header bg-secondary font-weight-bold">
            Umur
        </div>
        <div class="card-body">
            {!! $table_umur !!}
        </div>
    </div>

    <div class="card shadow mb-5" data-aos="fade-up">
        <div class="card-header bg-secondary font-weight-bold">
            Pendidikan Terakhir
        </div>
        <div class="card-body">
            {!! $table_pendidikan_akhir !!}
        </div>
    </div>

    <div class="card shadow mb-5" data-aos="fade-up">
        <div class="card-header bg-secondary font-weight-bold">
            Pekerjaan Utama
        </div>
        <div class="card-body">
            {!! $table_pekerjaan_utama !!}
        </div>
    </div>

    <div class="card shadow mb-5" data-aos="fade-up">
        <div class="card-header bg-secondary font-weight-bold">
            Pendapatan Per Bulan
        </div>
        <div class="card-body">
            {!! $table_pendapatan !!}
        </div>
    </div>
</div>

@endsection

@section('javascript')

@endsection