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

    <div class="card card-custom bgi-no-repeat gutter-b"
        style="height: 150px; background-color: #1c2840; background-position: calc(100% + 0.5rem) 100%; background-size: 100% auto; background-image: url(/assets/img/banner/rhone-2.svg)"
        data-aos="fade-down">
        <div class="card-body d-flex align-items-center">
            <div>
                <h3 class="text-white font-weight-bolder line-height-lg mb-5">
                    {{strtoupper($title)}}
                    <br>
                    {{ strtoupper($users->first_name . ' ' . $users->last_name)}}
                </h3>
            </div>
        </div>
    </div>

    @php
    $target = $ci->db->get("target_$manage_survey->table_identity")->num_rows();
    $target_online = $ci->db->get_where("target_$manage_survey->table_identity", array('target_online' =>
    null))->num_rows();
    $target_offline = $ci->db->get_where("target_$manage_survey->table_identity", array('target_offline' =>
    null))->num_rows();
    @endphp


    @if($target != 0 && $target_online == 0 && $target_offline == 0)
    <div class="card card-custom card-sticky" data-aos="fade-down" data-aos-delay="300">
        <div class="card-body">
            <div class="table-responsive">
                <table id="table" class="table table-hover table-bordered" cellspacing="0" width="100%">
                    <thead class="bg-secondary">
                        <tr>
                            <th>No.</th>
                            <th>Nama Wilayah</th>
                            <th>Akumulasi (Persentase)</th>
                            <th>Target</th>
                            <th>Perolehan</th>
                            <th>Kekurangan</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="card card-custom card-sticky mt-5" data-aos="fade-down" data-aos-delay="300">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td rowspan="2" class="text-center" style="vertical-align: middle;">No</td>
                            <td rowspan="2" class="text-center" style="vertical-align: middle;">Barang / Jasa</td>
                            <td rowspan="2" class="text-center" style="vertical-align: middle;">Akumulasi (Persentase)
                            </td>
                            <td colspan="3" class="text-center">Online</td>
                            <td colspan="3" class="text-center">Offline</td>
                        </tr>
                        <tr>
                            <th class="text-center">Target</th>
                            <th class="text-center">Perolehan</th>
                            <th class="text-center">Kekurangan</th>
                            <th class="text-center">Target</th>
                            <th class="text-center">Perolehan</th>
                            <th class="text-center">Kekurangan</th>
                        </tr>
                    </thead>
                    <tbody>

                        @php
                        $no = 1;
                        @endphp
                        @foreach ($sektor->result() as $value)

                        @php
                        //ONLINE
                        $target_all_online[] = $value->target_online;
                        $total_target_online = array_sum($target_all_online);
                        $perolehan_all_online[] = $value->perolehan_online;
                        $total_perolehan_online = array_sum($perolehan_all_online);
                        $kekurangan_all_online[] = $value->kekurangan_online;
                        $total_kekurangan_online = array_sum($kekurangan_all_online);

                        //SURVEYOR
                        $target_all_offline[] = $value->target_offline;
                        $total_target_offline = array_sum($target_all_offline);
                        $perolehan_all_offline[] = $value->perolehan_offline;
                        $total_perolehan_offline = array_sum($perolehan_all_offline);
                        $kekurangan_all_offline[] = $value->kekurangan_offline;
                        $total_kekurangan_offline = array_sum($kekurangan_all_offline);

                        $total_akumulasi_persen = ((($total_perolehan_online + $total_perolehan_offline) /
                        ($total_target_online + $total_target_offline)) * 100);
                        @endphp

                        <tr>
                            <td class="text-center">{{$no++}}</td>
                            <td>{{$value->nama_sektor}}</td>
                            <td class="text-center">
                                <span class="badge badge-info">{{ROUND($value->akumulasi_persen, 2)}} %</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-secondary">{{$value->target_online}}</span>
                            </td>
                            <td class="text-center"><span
                                    class="badge badge-success">{{$value->perolehan_online}}</span>
                            </td>
                            <td class="text-center"><span
                                    class="badge badge-danger">{{$value->kekurangan_online}}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-secondary">{{$value->target_offline}}</span>
                            </td>
                            <td class="text-center"><span
                                    class="badge badge-success">{{$value->perolehan_offline}}</span>
                            </td>
                            <td class="text-center"><span
                                    class="badge badge-danger">{{$value->kekurangan_offline}}</span>
                            </td>
                        </tr>
                        @endforeach


                        <tr>
                            <td colspan="2" align="center"><b>TOTAL</b></td>
                            <td class="text-center">
                                <span class="badge badge-dark">{{ROUND($total_akumulasi_persen, 2)}} %</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-dark">{{$total_target_online}}</span>
                            </td>
                            <td class="text-center"><span class="badge badge-dark">{{$total_perolehan_online}}</span>
                            </td>
                            <td class="text-center"><span class="badge badge-dark">{{$total_kekurangan_online}}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-dark">{{$total_target_offline}}</span>
                            </td>
                            <td class="text-center"><span class="badge badge-dark">{{$total_perolehan_offline}}</span>
                            </td>
                            <td class="text-center"><span class="badge badge-dark">{{$total_kekurangan_offline}}</span>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @else

    <div class="card card-body">

        <div class="text-danger text-center"><i>Target belum di isi.</i></div>
    </div>

    @endif

</div>

<!-- ======================================= Detail Hasil Analisa ========================================== -->
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
<script src="{{ TEMPLATE_BACKEND_PATH }}plugins/custom/datatables/datatables.bundle.js"></script>
<script>
$(document).ready(function() {
    table = $('#table').DataTable({

        "processing": true,
        "serverSide": true,
        "order": [],
        "language": {
            "processing": '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
        },
        "lengthMenu": [
            [5, 10, 25, 50, 100],
            [5, 10, 25, 50, 100]
        ],
        "pageLength": 5,
        "ajax": {
            "url": "<?php echo base_url() . $users->username . '/' . $slug . '/rekap-per-wilayah/ajax-list' ?>",
            "type": "POST",
            "data": function(data) {}
        },

        "columnDefs": [{
            "targets": [-1],
            "orderable": false,
        }, ],

    });
});

$('#btn-filter').click(function() {
    table.ajax.reload();
});
$('#btn-reset').click(function() {
    $('#form-filter')[0].reset();
    table.ajax.reload();
});
</script>


<script>
function showedit(id) {
    $('#bodyModalDetail').html(
        "<div class='text-center'><img src='{{ base_url() }}assets/img/ajax/ajax-loader-big.gif'></div>");

    $.ajax({
        type: "post",
        url: "<?php echo base_url() . $ci->session->userdata('username') . '/' .  $ci->uri->segment(2) . '/rekap-per-wilayah/detail/' ?>" +
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