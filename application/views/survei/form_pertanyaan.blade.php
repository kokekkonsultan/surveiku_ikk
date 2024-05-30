@extends('include_backend/_template')

@php
$ci = get_instance();
@endphp

@section('style')
<!-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> -->

<style>
    .form-radio {
        font-size: 16px;
        text-transform: capitalize;
        font-family: Arial, Helvetica, sans-serif;
    }
</style>
@endsection

@section('content')


<div class="container mt-5 mb-5" style="font-family:Arial, Helvetica, sans-serif;">
    <div class="text-center" data-aos="fade-up">
        <div id="progressbar" class="mb-5">
            <li class="active" id="account"><strong>Data Responden</strong></li>
            <li class="active" id="personal"><strong>Pertanyaan Survei</strong></li>
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
            <div class="card shadow" data-aos="fade-up" id="kt_blockui_content" style="font-size: 16px; font-family:Arial, Helvetica, sans-serif;">
                @if($manage_survey->img_benner == '')
                <img class="card-img-top" src="{{ base_url() }}assets/img/site/page/banner-survey.jpg" alt="new image" />
                @else
                <img class="card-img-top shadow" src="{{ base_url() }}assets/klien/benner_survei/{{$manage_survey->img_benner}}" alt="new image">
                @endif

                <div class="card-header text-center">
                    <div class="mt-5 mb-5" style="background-color: #FCF7B6; padding: 5px; font-size: 16px;
                        font-family:Arial,Helvetica,sans-serif; font-weight: bold; text-transform: uppercase;">
                        BERIKAN PENILAIAN SAUDARA TERHADAP UNSUR-UNSUR KEBERDAYAAN KONSUMEN <br>
                        <span class="text-danger">@include('include_backend/partials_backend/_tanggal_survei')</span>
                    </div>
                </div>

                <form action="{{base_url() . 'survei/' . $ci->uri->segment(2) . '/add-pertanyaan/' . $ci->uri->segment(4)}}" class="form_survei" method="POST">

                    <div class="card-body ml-5 mr-5">
                        <br>

                        <!-- PERTANYAAN UNSUR -->
                        @foreach ($pertanyaan_unsur->result() as $get)
                        <input type="hidden" name="id_pertanyaan_unsur[{{ $get->id_pertanyaan_unsur }}]" value="{{$get->id_pertanyaan_unsur}}">
                        <table width="100%" border="0" class="mt-5 mb-5">
                            <tr>
                                <td width="5%" valign="top">
                                    <p><span style="font-size:16px;">{{$get->kode_unsur}}. </span></p>
                                </td>
                                <td width="95%">{!! $get->isi_pertanyaan !!}</td>
                            </tr>

                            <tr>
                                <td></td>
                                <td>
                                    <div class="form-group radio-list">

                                        <label class="radio radio-lg radio-outline radio-outline-3x radio-primary" style=" font-size: 16px; font-weight:bold;">
                                            <input type="radio" name="jawaban_pertanyaan_unsur[{{ $get->id_pertanyaan_unsur }}]" value="1" class="{{$get->id_pertanyaan_unsur}}" required <?= $get->skor_jawaban == 1 ? 'checked' : '' ?>>
                                            <span></span>
                                            {{$get->jawaban_1}}
                                        </label>

                                        <label class="radio radio-lg radio-outline radio-outline-3x radio-primary" style=" font-size: 16px; font-weight:bold;">
                                            <input type="radio" name="jawaban_pertanyaan_unsur[{{ $get->id_pertanyaan_unsur }}]" value="2" class="{{$get->id_pertanyaan_unsur}}" required <?= $get->skor_jawaban == 2 ? 'checked' : '' ?>>
                                            <span></span>
                                            {{$get->jawaban_2}}
                                        </label>

                                        <label class="radio radio-lg radio-outline radio-outline-3x radio-primary" style=" font-size: 16px; font-weight:bold;">
                                            <input type="radio" name="jawaban_pertanyaan_unsur[{{ $get->id_pertanyaan_unsur }}]" value="3" class="{{$get->id_pertanyaan_unsur}}" required <?= $get->skor_jawaban == 3 ? 'checked' : '' ?>>
                                            <span></span>
                                            {{$get->jawaban_3}}
                                        </label>

                                        <label class="radio radio-lg radio-outline radio-outline-3x radio-primary" style=" font-size: 16px; font-weight:bold;">
                                            <input type="radio" name="jawaban_pertanyaan_unsur[{{ $get->id_pertanyaan_unsur }}]" value="4" class="{{$get->id_pertanyaan_unsur}}" required <?= $get->skor_jawaban == 4 ? 'checked' : '' ?>>
                                            <span></span>
                                            {{$get->jawaban_4}}
                                        </label>

                                        <label class="radio radio-lg radio-outline radio-outline-3x radio-primary" style=" font-size: 16px; font-weight:bold;">
                                            <input type="radio" name="jawaban_pertanyaan_unsur[{{ $get->id_pertanyaan_unsur }}]" value="5" class="{{$get->id_pertanyaan_unsur}}" required <?= $get->skor_jawaban == 5 ? 'checked' : '' ?>>
                                            <span></span>
                                            {{$get->jawaban_5}}
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    @php
                                    $atribute_alasan = unserialize($get->atribute_alasan);
                                    @endphp
                                    <textarea class="form-control" id="{{$get->id_pertanyaan_unsur}}" name="alasan[{{ $get->id_pertanyaan_unsur }}]" value="" placeholder="{{$get->label_alasan}}" <?= in_array($get->skor_jawaban, $atribute_alasan) ? 'required' : 'style="display:none"' ?> rows="3">{{$get->alasan_pilih_jawaban}}</textarea>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <br>
                        @endforeach




                        <!-- PERTANYAAN TERBUKA -->
                        @foreach ($pertanyaan_terbuka->result() as $row)
                        <input name="id_pertanyaan_terbuka[{{ $row->id }}]" value="{{$row->id}}" hidden>
                        <table width="100%" border="0" class="mt-5 mb-5">
                            <tr>
                                <td width="5%" valign="top">
                                    <p><span style="font-size:16px;">{{$row->nomor_pertanyaan_terbuka}}. </span></p>
                                </td>
                                <td width="95%">{!! $row->isi_pertanyaan_terbuka !!}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <div class="form-group radio-list">

                                        @foreach($ci->db->get_where("kategori_pertanyaan_terbuka_$manage_survey->table_identity", ['id_pertanyaan_terbuka' => $row->id])->result() as $val)
                                        <label class="radio radio-lg radio-outline radio-outline-3x radio-primary" style=" font-size: 16px; font-weight:bold;">
                                            <input type="radio" name="jawaban_pertanyaan_terbuka[{{ $row->id }}]" value="{{$val->nama_kategori_pertanyaan_terbuka}}" required <?= $val->nama_kategori_pertanyaan_terbuka == $row->jawaban ? 'checked' : '' ?>>
                                            <span></span>
                                            {{$val->nama_kategori_pertanyaan_terbuka}}
                                        </label>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <br>
                        @endforeach



                    </div>
                    <div class="card-footer">
                        <table class="table table-borderless">
                            <tr>
                                <td class="text-left">
                                    @if($ci->uri->segment(5) == 'edit')
                                    <a class="btn btn-secondary btn-lg shadow" href="{{base_url() . 'survei/' . $ci->uri->segment(2) . '/data-responden/' . $ci->uri->segment(4) . '/edit'}}"><i class="fa fa-arrow-left"></i> Kembali</a>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <button type="submit" class="btn btn-warning btn-lg font-weight-bold shadow-lg tombolSave">Selanjutnya
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
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>

@foreach ($ci->db->get_where("pertanyaan_unsur_$manage_survey->table_identity", array('is_active_alasan' =>
1))->result() as $pr)
@php
$atribute_alasan = unserialize($pr->atribute_alasan);

$data = [];
foreach($atribute_alasan as $value){
$data[] = '$(this).val() ==' . $value;
}
$pilihan = implode(" || ", $data);
@endphp
<script type="text/javascript">
    $(function() {
        $(":radio.{{$pr->id}}").click(function() {
            $("#{{$pr->id}}").hide()
            if (<?= $pilihan ?>) {
                $("#{{$pr->id}}").show().prop('required', true);
            } else {
                $("#{{$pr->id}}").removeAttr('required').hidden();
            }
        });
    });
</script>
@endforeach


<script>
    $('.form_survei').submit(function(e) {

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
                if (data.full) {
                    // Swal.fire({
                    //     icon: 'info',
                    //     title: 'Oops...',
                    //     text: data.full
                    // })

                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        html: data.full,
                        showConfirmButton: false,
                        allowOutsideClick: false

                    });

                }
                if (data.sukses) {
                    // toastr["success"]('Data berhasil disimpan');

                    setTimeout(function() {
                        window.location.href = "{{$url_next}}";
                    }, 500);
                }
            }
        })
        return false;
    });
</script>
@endsection