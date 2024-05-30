@extends('include_backend/_template')

@php
$ci = get_instance();
@endphp

@section('style')
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
@endsection

@section('content')

<div class="container mt-5 mb-5" style="font-family:Arial, Helvetica, sans-serif;">
    <div class="text-center" data-aos="fade-up">
        <div id="progressbar" class="mb-5">
            <li id="account"><strong>Data Responden</strong></li>
            <li id="personal"><strong>Pertanyaan Survei</strong></li>
            @if($status_saran == 1)
            <li id="payment"><strong>Saran</strong></li>
            @endif
            <li id="completed"><strong>Completed</strong></li>
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow" data-aos="fade-up">
                @if($judul->img_benner == '')
                <img class="card-img-top" src="{{ base_url() }}assets/img/site/page/banner-survey.jpg" alt="new image" />
                @else
                <img class="card-img-top shadow" src="{{ base_url() }}assets/klien/benner_survei/{{$manage_survey->img_benner}}" alt="new image">
                @endif
                <div class="card-body">
                    <div>
                        {!! $manage_survey->deskripsi_opening_survey !!}
                    </div>
         
                    <br>
                    <br>
                    <a class="btn btn-warning btn-block font-weight-bold shadow" onclick="getLocation()">IKUT SURVEI</a>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('javascript')
<script src="{{ TEMPLATE_BACKEND_PATH }}plugins/custom/datatables/datatables.bundle.js"></script>
<script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"></script>

<script>
function getLocation() {

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        Swal.fire({ 
            icon: 'error',
            title: 'Error',
            html: 'Geolocation tidak didukung oleh browser ini, silahkan gunakan browser lain.',
            confirmButtonColor: '#8950FC',
            confirmButtonText: 'Baik, Terimakasih',
        });
    }
}

function showError(error) {
    console.log(error);
    Swal.fire({ 
        icon: 'info',
        title: 'Informasi',
        html: 'Silakan aktifkan izin lokasi di perangkat anda untuk bisa melanjutkan ke pengisian survei.',
        confirmButtonColor: '#8950FC',
        confirmButtonText: 'Baik, Terimakasih',
    }).then((result) => {
        if (result.value) {
            location.reload();
        }
    });
}

function showPosition(position) {
    var lat = position.coords.latitude;
    var lng = position.coords.longitude;
    
    console.log(position.coords);
    location.href = "{{$url_next}}?lat=" + lat + '&lng=' + lng;
}
</script>
@endsection