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
            <li class="active" id="account"><strong>Data Responden</strong></li>
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
            <div class="card shadow" data-aos="fade-up" id="kt_blockui_content">
                @if($manage_survey->img_benner == '')
                <img class="card-img-top" src="{{ base_url() }}assets/img/site/page/banner-survey.jpg"
                    alt="new image" />
                @else
                <img class="card-img-top shadow"
                    src="{{ base_url() }}assets/klien/benner_survei/{{$manage_survey->img_benner}}" alt="new image">
                @endif
                <div class="card-header text-center">
                    <h4><b>DATA RESPONDEN</b> - @include('include_backend/partials_backend/_tanggal_survei')</h4>
                </div>
                <div class="card-body">

                    <form action="<?php echo $form_action ?>" class="form_responden" method="POST">

                        <span style="color: red; font-style: italic;">{!! validation_errors() !!}</span>
                        <input name="id_surveyor" value="{{$surveyor_id}}" hidden>

                        <input name="lat" value="{{$ci->session->userdata('lat')}}" hidden>
                        <input name="lng" value="{{$ci->session->userdata('lng')}}" hidden>
                        <input name="loc" id="loc" hidden>



                        @if($ci->uri->segment(4) == NULL)

                        @foreach ($profil_responden->result() as $row)
                        <div class="form-group">
                            <label class="font-weight-bold"><?php echo $row->nama_profil_responden ?> <span
                                    class="text-danger">*</span></label>

                            @if ($row->jenis_isian == 2)
                            <input class="form-control" type="<?php echo $row->type_data ?>"
                                name="<?php echo $row->nama_alias ?>" placeholder="Masukkan data anda ..." required>
                            @else
                            <select class="form-control" name="<?php echo $row->nama_alias ?>" required>
                                <option value="">Please Select</option>
                                @foreach ($kategori_profil_responden->result() as $value)
                                @if ($value->id_profil_responden == $row->id)
                                <option value="<?php echo $value->id ?>">
                                    <?php echo $value->nama_kategori_profil_responden ?></option>
                                @endif
                                @endforeach
                            </select>
                            @endif

                        </div>
                        </br>
                        @endforeach

                        @else

                        <input name="wilayah_survei" value="{{$surveyor->id_wilayah_survei}}" hidden>

                        @foreach ($profil_responden->result() as $row)
                        @if($row->nama_alias != 'wilayah_survei')
                        <div class="form-group">
                            <label class="font-weight-bold"><?php echo $row->nama_profil_responden ?> <span
                                    class="text-danger">*</span></label>

                            @if ($row->jenis_isian == 2)
                            <input class="form-control" type="<?php echo $row->type_data ?>"
                                name="<?php echo $row->nama_alias ?>" placeholder="Masukkan data anda ..." required>
                            @else
                            <select class="form-control" name="<?php echo $row->nama_alias ?>" required>
                                <option value="">Please Select</option>
                                @foreach ($kategori_profil_responden->result() as $value)
                                @if ($value->id_profil_responden == $row->id)
                                <option value="<?php echo $value->id ?>">
                                    <?php echo $value->nama_kategori_profil_responden ?></option>
                                @endif
                                @endforeach
                            </select>
                            @endif

                        </div>
                        </br>
                        @endif
                        @endforeach


                        @endif


                </div>
                <div class="card-footer">
                    <table class="table table-borderless">
                        <tr>
                            <td class="text-left">
                                @if ($ci->uri->segment(4) == NULL)
                                <a class="btn btn-secondary btn-lg shadow"
                                    href="{{base_url().'survei/'.$ci->uri->segment(2)}}"><i
                                        class="fa fa-arrow-left"></i> Kembali</a>
                                @else
                                <a class="btn btn-secondary btn-lg shadow"
                                    href="{{base_url().'survei/'.$ci->uri->segment(2) . '/' . $ci->uri->segment(4)}}"><i
                                        class="fa fa-arrow-left"></i> Kembali</a>
                                @endif
                            </td>
                            <td class="text-right">
                                <button type="submit" class="btn btn-warning btn-lg font-weight-bold shadow tombolSave"
                                    onclick="preventBack()">Selanjutnya <i class="fa fa-arrow-right"></i></button>
                            </td>
                        </tr>
                    </table>
                </div>
                </form>
            </div>

            <br><br>
        </div>
    </div>
</div>


@endsection

@section('javascript')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA1MgLuZuyqR_OGY3ob3M52N46TDBRI_9k&callback=initia">
</script>

<script>
$('.form_responden').submit(function(e) {

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        dataType: 'json',
        data: $(this).serialize(),
        cache: false,
        beforeSend: function() {
            $('.tombolCancel').attr('disabled', 'disabled');
            $('.tombolSave').attr('disabled', 'disabled');
            $('.tombolSave').html('<i class="fa fa-spin fa-spinner"></i> Sedang diproses');

            KTApp.block('#kt_blockui_content', {
                overlayColor: '#FFA800',
                state: 'primary',
                message: 'Processing...'
            });

            setTimeout(function() {
                KTApp.unblock('#kt_blockui_content');
            }, 1000);

        },
        complete: function() {
            $('.tombolCancel').removeAttr('disabled');
            $('.tombolSave').removeAttr('disabled');
            $('.tombolSave').html('Selanjutnya <i class="fa fa-arrow-right"></i>');
        },

        error: function(e) {
            Swal.fire(
                'Error !',
                e,
                'error'
            )
        },

        success: function(data) {
            if (data.full) {
                Swal.fire({
                    icon: 'info',
                    title: 'Oops...',
                    text: data.full
                })
            }
            if (data.sukses) {
                // toastr["success"]('Data berhasil disimpan');
                setTimeout(function() {
                    window.location.href = "{{base_url() . 'survei/' . $ci->uri->segment(2) . '/pertanyaan/'}}" + data.uuid;
                }, 500);
            }
        }
    })
    return false;
});
</script>


<script>
function preventBack() {
    window.history.forward();
}
setTimeout("preventBack()", 0);
window.onunload = function() {
    null
};
</script>


<script>
$(document).ready(function() {

    $('#id_provinsi').change(function() {
        var id = $(this).val();
        $.ajax({
            url: "{{ base_url() . 'survei/' . $ci->uri->segment(2) . '/link-survei/get-kota-kab' }}",
            method: "POST",
            data: {id: id},
            async: true,
            dataType: 'json',
            success: function(data) {
                var html =
                    '<option value="">Pilih Kota / Kabupaten Sesuai Domisili Anda Saat Ini</option>';
                var i;
                for (i = 0; i < data.length; i++) {
                    html += '<option value=' + data[i].id + '>' + data[i].nama_kota_kab_indonesia + '</option>';
                }
                $('#kota_kab').html(html);

            }
        });
        return false;
    });

});
</script>



<script>
$(document).ready(function() {
    var lat = "{{$ci->session->userdata('lat')}}";
    var lng = "{{$ci->session->userdata('lng')}}";
    var geocoder;
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(lat, lng);

    geocoder.geocode({
            'latLng': latlng
        },
        function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    var add = results[0].formatted_address;
                    var value = add.split(",");

                    document.getElementById("loc").value = add;
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: 'Alamat tidak terdeteksi.<br>Silakan reset izin lokasi di perangkat anda dan pastikan koneksi internet anda baik.',
                        confirmButtonColor: '#8950FC',
                        confirmButtonText: 'Baik, Terimakasih',
                    }).then((result) => {
                        if (result.value) {
                            window.location.href =
                                "{{base_url() . 'survei/' . $ci->uri->segment(2) . '/' . $ci->uri->segment(4)}}";
                        }
                    });
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    html: "Akses geocoder gagal: " + status +
                        '<br>Silakan reset izin lokasi di perangkat anda dan pastikan koneksi internet anda baik.',
                    confirmButtonColor: '#8950FC',
                    confirmButtonText: 'Baik, Terimakasih',
                }).then((result) => {
                    if (result.value) {
                        window.location.href =
                            "{{base_url() . 'survei/' . $ci->uri->segment(2) . '/' . $ci->uri->segment(4)}}";
                    }
                });
            }
        }
    );
});
</script>
@endsection