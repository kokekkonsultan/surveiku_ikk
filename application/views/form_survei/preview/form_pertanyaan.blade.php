@extends('include_backend/_template')

@php
$ci = get_instance();
@endphp

@section('style')
<!-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> -->
@endsection

@section('content')


<div class="container mt-5 mb-5" style="font-family: nunito;">
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
            <div class="card shadow" data-aos="fade-up" id="kt_blockui_content"
                style="font-size: 16px; font-family:Arial, Helvetica, sans-serif;">
                @if($manage_survey->img_benner == '')
                <img class="card-img-top" src="{{ base_url() }}assets/img/site/page/banner-survey.jpg"
                    alt="new image" />
                @else
                <img class="card-img-top shadow"
                    src="{{ base_url() }}assets/klien/benner_survei/{{$manage_survey->img_benner}}" alt="new image">
                @endif
                <div class="card-header text-center">
                    <div class="mt-5 mb-5" style="background-color: #FCF7B6; padding: 5px; font-size: 16px;
                        font-family:Arial,Helvetica,sans-serif; font-weight: bold; text-transform: uppercase;">
                        BERIKAN PENILAIAN SAUDARA TERHADAP UNSUR-UNSUR KEBERDAYAAN KONSUMEN <br>
                        <span class="text-danger">@include('include_backend/partials_backend/_tanggal_survei')</span>
                    </div>
                </div>


                <form>

                    <div class="card-body ml-5 mr-5">
                        <br>

                        @php
                        $i = 1;
                        @endphp
                        @foreach ($pertanyaan->result() as $get)
                        <table width="100%" border="0" class="mt-5 mb-5">
                            <tr>
                                <td width="4%" valign="top">
                                    <p><span style="font-size:16px;"><?php echo $get->kode_unsur ?>. </span></p>
                                </td>
                                <td width="96%"> <?php echo $get->isi_pertanyaan ?> </td>
                            </tr>

                            <input type="hidden" name="id_pertanyaan_unsur[{{ $i }}]"
                                value="<?php echo $get->id_pertanyaan_unsur ?>">
                        </table>

                        <table width="100%" border="0" style="font-weight: bold;">
                            <tr>
                                <td width="5%"></td>
                                <td width="95%">
                                    <div
                                        style="font-size: 16px; text-transform: capitalize; font-family: Arial,Helvetica,sans-serif; ">
                                        <label><input type="radio" name="jawaban_pertanyaan_unsur[{{ $i }}]" value="1"
                                                class="<?php echo $get->id_pertanyaan_unsur ?>">
                                            <?php echo $get->jawaban_1; ?></label><br>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td width="5%"></td>
                                <td width="95%">
                                    <div
                                        style="font-size: 16px; text-transform: capitalize; font-family: Arial,Helvetica,sans-serif; ">
                                        <label><input type="radio" name="jawaban_pertanyaan_unsur[{{ $i }}]" value="2"
                                                class="<?php echo $get->id_pertanyaan_unsur ?>">
                                            <?php echo $get->jawaban_2; ?></label><br>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td width="5%"></td>
                                <td width="95%">
                                    <div
                                        style="font-size: 16px; text-transform: capitalize; font-family: Arial,Helvetica,sans-serif; ">
                                        <label><input type="radio" name="jawaban_pertanyaan_unsur[{{ $i }}]" value="3"
                                                class="<?php echo $get->id_pertanyaan_unsur ?>">
                                            <?php echo $get->jawaban_3; ?></label><br>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td width="5%"></td>
                                <td width="95%">
                                    <div
                                        style="font-size: 16px; text-transform: capitalize; font-family: Arial,Helvetica,sans-serif; ">
                                        <label><input type="radio" name="jawaban_pertanyaan_unsur[{{ $i }}]" value="4"
                                                class="<?php echo $get->id_pertanyaan_unsur ?>">
                                            <?php echo $get->jawaban_4; ?></label><br>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td width="5%"></td>
                                <td width="95%">
                                    <div
                                        style="font-size: 16px; text-transform: capitalize; font-family: Arial,Helvetica,sans-serif; ">
                                        <label><input type="radio" name="jawaban_pertanyaan_unsur[{{ $i }}]" value="5"
                                                class="<?php echo $get->id_pertanyaan_unsur ?>">
                                            <?php echo $get->jawaban_5; ?></label><br>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td width="4%"></td>
                                <td width="96%">
                                    <br>
                                    <textarea class="form-control" id="<?php echo $get->id_pertanyaan_unsur ?>"
                                        name="alasan[{{ $i }}]" value=""
                                        placeholder="Masukkan Alasan Anda Pada Bidang Ini ..." style="display:none"
                                        rows="3"></textarea>
                                </td>
                            </tr>

                        </table>
                        <br>
                        <hr>
                        <br>
                        <br>
                        @php
                        $i++;
                        @endphp
                        @endforeach



                    </div>
                    <div class="card-footer">
                        <table class="table table-borderless">
                            <tr>
                                <td class="text-left">
                                    {!! anchor(base_url() . $ci->session->userdata('username') . '/' .
                                    $ci->uri->segment(2)
                                    . '/form-survei/data-responden', '<i class="fa fa-arrow-left"></i>
                                    Kembali',
                                    ['class' => 'btn btn-secondary btn-lg font-weight-bold shadow']) !!}
                                </td>
                                <td class="text-right">
                                    <a class="btn btn-warning btn-lg shadow-lg"
                                        href="<?php echo $url_next ?>">Selanjutnya <i
                                            class=" fa fa-arrow-right"></i></a>
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

@foreach ($ci->db->get_where("pertanyaan_unsur_$manage_survey->table_identity", array('is_active_alasan' => 1))->result() as $pr)
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
        $(":radio.<?php echo $pr->id; ?>").click(function() {
            $("#<?php echo $pr->id; ?>").hide()
            if (<?php echo $pilihan ?>) {
                $("#<?php echo $pr->id; ?>").show().prop('required', true);
            } else {
                $("#<?php echo $pr->id; ?>").removeAttr('required').hidden();
            }
        });
    });
</script>
@endforeach

@endsection