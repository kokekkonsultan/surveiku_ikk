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
    <div class="row">
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

                        <button type="button" class="btn btn-secondary btn-sm font-weight-bold shadow"
                            data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fa fa-info-circle"></i>
                            Detail Surveyor Per
                            Wilayah
                        </button>


                        <a class="btn btn-secondary btn-sm font-weight-bold shadow"
                            href="<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) .  '/data-surveyor-survei/add' ?>">
                            <i class="fa fa-plus"></i> Tambah Surveyor
                        </a>
                    </div>
                </div>
            </div>


            <div class="card card-custom card-sticky" data-aos="fade-down" data-aos-delay="300">

                <div class="card-body">
                    <div class="text-right mb-3">

                    </div>
                    <div class="table-responsive">
                        <table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
                            <thead class="bg-secondary">
                                <tr>
                                    <th>No.</th>
                                    <th></th>
                                    <th>Nama Lengkap</th>
                                    <th>Kode Surveyor</th>
                                    <th>Status</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- MODAL DETAIL SURVEYOR PER PROVINSI -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title" id="exampleModalLongTitle">Detail Surveyor Per Wilayah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <tr class="font-weight-bold text-center">
                            <td>No</td>
                            <td>Wilayah di Survei</td>
                            <td>Total Surveyor</td>
                            <td>Nama Surveyor</td>
                        </tr>

                        <?php
                        $no = 1;
                        foreach ($wilayah_survei->result() as $row) {
                            $total_all[] = $row->total_surveyor_per_wilayah;
                            $total = array_sum($total_all);
                            ?>

                        <tr>
                            <td class="text-center">{{$no++}}</td>
                            <td>{{$row->nama_wilayah}}</td>
                            <td class="text-center"><span class="badge badge-danger">
                                    {{$row->total_surveyor_per_wilayah}}</span></td>
                            <td>
                                <ul>
                                    @foreach ($surveyor_per_wilayah->result() as $value)
                                    @if ($row->id == $value->id_wilayah_survei && $value->id_manage_survey ==
                                    $id_manage_survey)

                                    <li>{{$value->first_name . ' ' . $value->last_name}}</li>

                                    @endif
                                    @endforeach
                                </ul>
                            </td>
                        </tr>

                        <?php } ?>

                        <tr class="font-weight-bold text-center" style="background-color: grey; color:white;">
                            <td colspan="2">TOTAL</td>
                            <td colspan="2">{{$total}} Surveyor</td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include("data_surveyor_survei/form_detail")

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
        "ajax": {
            "url": "<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/data-surveyor-survei/ajax-list' ?>",
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


function delete_data(id) {
    if (confirm('Are you sure delete this data?')) {
        $.ajax({
            url: "<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/data-surveyor-survei/delete/' ?>" +
                id,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                if (data.status) {

                    table.ajax.reload();

                    Swal.fire(
                        'Informasi',
                        'Berhasil menghapus data',
                        'success'
                    );
                } else {
                    Swal.fire(
                        'Informasi',
                        'Hak akses terbatasi. Bukan akun administrator.',
                        'warning'
                    );
                }


            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error deleting data');
            }
        });

    }
}
</script>

<script>
"use strict";
var KTClipboardDemo = function() {
    var demos = function() {
        new ClipboardJS('[data-clipboard=true]').on('success', function(e) {
            e.clearSelection();
            toastr["success"]('Link berhasil dicopy, Silahkan paste di browser anda sekarang.');
        });
    }

    return {
        init: function() {
            demos();
        }
    };
}();

jQuery(document).ready(function() {
    KTClipboardDemo.init();
});
</script>
@endsection