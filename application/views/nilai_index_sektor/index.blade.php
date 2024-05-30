@extends('include_backend/template_backend')

@php
$ci = get_instance();
@endphp

@section('style')
<link href="{{ TEMPLATE_BACKEND_PATH }}plugins/custom/datatables/datatables.bundle.css" rel="stylesheet"
    type="text/css" />
@endsection

@section('content')

<div class="container-fluid">
    @include("include_backend/partials_no_aside/_inc_menu_repository")

    <div class="row mt-5">
        <div class="col-md-3">
            @include('manage_survey/menu_data_survey')
        </div>
        <div class="col-md-9">

            <div class="card card-custom bgi-no-repeat gutter-b"
                style="height: 150px; background-color: #1c2840; background-position: calc(100% + 0.5rem) 100%; background-size: 100% auto; background-image: url(/assets/img/banner/rhone-2.svg)"
                data-aos="fade-down">
                <div class="card-body d-flex align-items-center">
                    <div>
                        <h3 class="text-white font-weight-bolder line-height-lg mb-5">
                            {{strtoupper($title)}}
                        </h3>

                    </div>
                </div>
            </div>

            <div class="card card-custom card-sticky" data-aos="fade-down">

                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover example" cellspacing="0" width="100%"
                            style="font-size: 12px;">
                            <thead class="bg-secondary">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Sektor</th>
                                    <th>Nilai IKK</th>
                                    <th>Mutu Pelayanan</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $no = 1;
                                @endphp
                                @foreach($sektor->result() as $row)

                                @php
                                $olah_data = $ci->db->query("SELECT kode_unsur, (SELECT
                                unsur_$table_identity.persentase_unsur /
                                100) AS persentase_unsur,

                                (SELECT AVG(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity
                                JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey =
                                survey_$table_identity.id
                                JOIN responden_$table_identity ON survey_$table_identity.id_responden =
                                responden_$table_identity.id
                                WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && is_submit = 1 &&
                                sektor = $row->id) AS
                                rata_per_unsur,

                                ((SELECT AVG(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity
                                JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_survey =
                                survey_$table_identity.id
                                JOIN responden_$table_identity ON survey_$table_identity.id_responden =
                                responden_$table_identity.id
                                WHERE id_pertanyaan_unsur = pertanyaan_unsur_$table_identity.id && is_submit = 1 &&
                                sektor = $row->id) *
                                (unsur_$table_identity.persentase_unsur / 100)) AS persen_per_unsur

                                FROM pertanyaan_unsur_$table_identity
                                JOIN unsur_$table_identity ON pertanyaan_unsur_$table_identity.id_unsur =
                                unsur_$table_identity.id");

                                $total = [];
                                $ikk = 0;
                                foreach ($olah_data->result() as $value) {
                                $total[] = $value->persen_per_unsur;
                                $ikk = array_sum($total) * 20;
                                }

                                @endphp
                                <tr>
                                    <td>{{$no++}}</td>
                                    <td>{{$row->nama_sektor}}</td>
                                    <td class="text-primary"><b>{{$ikk == null ? 0 : ROUND($ikk,3)}}</b></td>
                                    <td class="text-dark-50"><b>
                                            <?php if ($ikk <= 20) {
                                                echo 'Sadar';
                                            } elseif ($ikk > 20 && $ikk <= 40) {
                                                echo 'Paham';
                                            } elseif ($ikk > 40 && $ikk <= 60) {
                                                echo 'Mampu';
                                            } elseif ($ikk > 60 && $ikk <= 80) {
                                                echo 'Kritis';
                                            } elseif ($ikk > 80) {
                                                echo 'Berdaya';
                                            } else {
                                                NULL;
                                            } ?></b>
                                    </td>
                                    <td>
                                        <a class="btn btn-light-info btn-sm shadow font-weight-bold" data-toggle="modal"
                                            onclick="showedit({{$row->id}})" href="#modal_detail"><i
                                                class="fa fa-info-circle"></i> Detail</a>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="modal fade bd-example-modal-xl" id="modal_detail" tabindex="-1" role="dialog"
    aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" id="bodyModalDetail">
            <div align="center" id="loading_registration">
                <img src="{{ base_url() }}assets/site/img/ajax-loader.gif" alt="">
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script src="{{ base_url() }}assets/themes/metronic/assets/plugins/custom/datatables/datatables.bundle.js"></script>
<script>
$(document).ready(function() {
    $('.example').DataTable();
});
</script>


<script>
function showedit(id) {
    $('#bodyModalDetail').html(
        "<div class='text-center'><img src='{{ base_url() }}assets/img/ajax/ajax-loader-big.gif'></div>");

    $.ajax({
        type: "post",
        url: "<?php echo base_url() . $ci->session->userdata('username') . '/' .  $ci->uri->segment(2) . '/nilai-index-sektor/' ?>" +
            id,
        // data: "id=" + id,
        dataType: "text",
        success: function(response) {
            // $('.modal-title').text('Edit Pertanyaan Unsur');
            $('#bodyModalDetail').empty();
            $('#bodyModalDetail').append(response);
        }
    });
}
</script>
@endsection