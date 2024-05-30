@extends('include_backend/template_backend')

@php
$ci = get_instance();
@endphp

@section('style')

@endsection

@section('content')

<div class="container">
    <div class="card shadow" data-aos="fade-up">
        <div class="card-header bg-secondary font-weight-bold">
            {{ $title }}
        </div>
        <div class="card-body">
            {!! $table_tahapan_pembelian !!}
        </div>
    </div>
</div>

@endsection

@section('javascript')

@endsection