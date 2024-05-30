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
            <li class="active" id="personal"><strong>Pertanyaan Survei</strong></li>
            <li class="active" id="payment"><strong>Saran</strong></li>
            <li id="completed"><strong>Completed</strong></li>
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow" data-aos="fade-up" id="kt_blockui_content">
                @if($judul->img_benner == '')
                <img class="card-img-top" src="{{ base_url() }}assets/img/site/page/banner-survey.jpg"
                    alt="new image" />
                @else
                <img class="card-img-top shadow"
                    src="{{ base_url() }}assets/klien/benner_survei/{{$manage_survey->img_benner}}" alt="new image">
                @endif


                <div class="card-header text-center">
                    <h4><b>SARAN</b> - @include('include_backend/partials_backend/_tanggal_survei')</h4>
                </div>

                <form
                    action="<?php echo base_url() . 'survei/' . $ci->uri->segment(2) . '/add-saran/' . $ci->uri->segment(4) ?>"
                    class="form_saran" method="POST">

                    <div class="card-body">
                        {!! validation_errors() !!}
                        <div>
                            <label
                                style="font-size: 14px; text-transform: capitalize;"><?php echo $manage_survey->judul_form_saran ?></label>
                            <br />
                            {!! form_textarea($saran) !!}
                        </div>

                    </div>

                    <div class="card-footer">
                        <table class="table table-borderless">
                            <tr>
                                <td class="text-left">
                                    @if($ci->uri->segment(5) == 'edit')
                                    <a class="btn btn-secondary btn-lg font-weight-bold shadow"
                                        href="{{base_url() . 'survei/' . $ci->uri->segment(2) . '/pertanyaan/' . $ci->uri->segment(4).'/edit'}}"><i
                                            class="fa fa-arrow-left"></i> Kembali</a>
                                    @else

                                    <a class="btn btn-secondary btn-lg font-weight-bold shadow"
                                        href="{{base_url() . 'survei/' . $ci->uri->segment(2) . '/pertanyaan/' . $ci->uri->segment(4)}}"><i
                                            class="fa fa-arrow-left"></i> Kembali</a>
                                    @endif

                                </td>
                                <td class="text-right">
                                    <button type="submit"
                                        class="btn btn-warning btn-lg font-weight-bold shadow-lg tombolSave"
                                        onclick="preventBack()">Selanjutnya
                                        <i class="fa fa-arrow-right"></i></button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@section('javascript')
<script>
$('.form_saran').submit(function(e) {

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        dataType: 'json',
        data: $(this).serialize(),
        cache: false,
        beforeSend: function() {
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
            if (data.validasi) {
                $('.pesan').fadeIn();
                $('.pesan').html(data.validasi);
            }
            if (data.sukses) {
                // toastr["success"]('Data berhasil disimpan');

                setTimeout(function() {
                    window.location.href =
                        "<?php echo base_url() . 'survei/' . $ci->uri->segment(2) . '/add-konfirmasi/' . $ci->uri->segment(4) ?>";
                }, 500);
            }
        }
    })
    return false;
});

function preventBack() {
    window.history.forward();
}
setTimeout("preventBack()", 0);
window.onunload = function() {
    null
};
</script>
@endsection