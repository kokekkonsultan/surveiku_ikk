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
            <?php echo $title; ?>
        </div>
        <div class="card-body">
            <?php echo $table_kelompok_skala; ?>
        </div>
    </div>
</div>

@endsection

@section('javascript')

@endsection