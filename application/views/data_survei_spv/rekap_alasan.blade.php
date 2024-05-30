@extends('include_backend/template_backend')

@php
$ci = get_instance();
@endphp

@section('style')
<link href="{{ TEMPLATE_BACKEND_PATH }}plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')

<div class="container-fluid">
    @include("include_backend/partials_no_aside/_inc_menu_repository")
    <div class="row">
        <div class="col-md-3">
            @include('manage_survey/menu_data_survey')
        </div>
        <div class="col-md-9">
            <div class="card card-custom bgi-no-repeat gutter-b" style="height: 150px; background-color: #1c2840; background-position: calc(100% + 0.5rem) 100%; background-size: 100% auto; background-image: url(/assets/img/banner/rhone-2.svg)" data-aos="fade-down">
                <div class="card-body d-flex align-items-center">
                    <div>
                        <h3 class="text-white font-weight-bolder line-height-lg mb-5">
                            {{strtoupper($title)}}
                        </h3>
                    </div>
                </div>
            </div>

            <div id="chart"></div>

            <br>

            <div class="card card-custom card-sticky" data-aos="fade-down" data-aos-delay="300">

                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover example" cellspacing="0" width="100%">
                            <thead class="bg-secondary">
                                <th>No.</th>
                                <th>Pertanyaan</th>
                                <th>Alasan</th>
                            </thead>

                            <tbody>
                                @php
                                $no =1;
                                @endphp
                                @foreach($pertanyaan->result() as $row)
                                <tr>
                                    <td>{{$no++}}</td>
                                    <td>{!! $row->isi_pertanyaan !!}</td>
                                    <td>
                                        @php
                                        $jawaban = $ci->db->query("SELECT *
                                            FROM jawaban_pertanyaan_unsur_$table_identity
                                            JOIN survey_$table_identity ON survey_$table_identity.id = jawaban_pertanyaan_unsur_$table_identity.id_survey
                                            WHERE is_submit = 1 && id_surveyor = 0 && id_pertanyaan_unsur = $row->id && alasan_pilih_jawaban != ''")
                                        @endphp

                                        @foreach($jawaban->result() as $value)
                                        <li>{{$value->alasan_pilih_jawaban}}</li>
                                        @endforeach

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


@endsection

@section('javascript')
<script src="{{ base_url() }}assets/themes/metronic/assets/plugins/custom/datatables/datatables.bundle.js"></script>
<script>
$(document).ready(function() {
    $('.example').DataTable({
        "processing": true,
        "lengthMenu": [
            [5, 10, 25, 50],
            [5, 10, 25, 50]
        ],
        "pageLength": 5,
        "language": {
            "processing": '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
        }
    });
});
</script>

@endsection