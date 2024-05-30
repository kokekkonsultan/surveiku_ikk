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
                            {{strtoupper($title)}} SURVEI
                        </h3>
                        @if ($is_question == 1)
                        <a class="btn btn-primary btn-sm font-weight-bold"
                            href="<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/pertanyaan-unsur/add' ?>"><i
                                class="fa fa-plus"></i> Tambah Pertanyaan Unsur</a>
                        @endif
                    </div>
                </div>
            </div>


            <div class="card card-custom card-sticky shadow" data-aos="fade-down" data-aos-delay="300">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
                            <thead class="bg-secondary">
                                <tr>
                                    <th>No.</th>
                                    <th>Dimensi</th>
                                    <th>Pertanyaan Unsur</th>
                                    <th>Pilihan Jawaban</th>
                                    <th>Bobot</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>

                            <tr class="bg-light">
                                <th colspan="4" class="text-center"><b>TOTAL BOBOT UNSUR</b></th>
                                <th><b><?php echo ROUND($total_persentase_unsur, 2) ?>%</b></th>
                                <th></th>
                            </tr>
                        </table>
                    </div>
                </div>

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
        "lengthMenu": [
            [5, 10, 25, 50, 100, -1],
            [5, 10, 25, 50, 100, "Semua data"]
        ],
        "pageLength": 5,
        "order": [],
        "language": {
            "processing": '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
        },
        "ajax": {
            "url": "{{ base_url() }}{{ $ci->uri->segment(1) }}/{{ $ci->uri->segment(2) }}/pertanyaan-unsur/ajax-list",
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
    if (confirm('Apakah anda akan menghapus pertanyaan unsur ini?')) {
        $.ajax({
            url: "{{ base_url() }}{{ $ci->session->userdata('username') }}/{{ $ci->uri->segment(2) }}/pertanyaan-unsur/delete/" +
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
function cek() {
    Swal.fire({
        icon: 'warning',
        title: 'Informasi',
        text: 'Persentase Bobot Unsur anda sudah mencapai 100% !',
        allowOutsideClick: false,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Ya, Saya mengerti !',
    });
}
</script>


@if($manage_survey->is_dimensi == 2)
<script>
$(document).ready(function() {
    Swal.fire({
        icon: 'warning',
        title: 'Informasi',
        html: '<div>Silahkan Konfirmasi Pengisian Dimensi terlebih dahulu, di menu Dimensi paling bawah. <br><a style="text-decoration:none; color: blue;" href="<?= base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/dimensi' ?>"><b>Kembali ke Dimensi</b></a></div>',
        showConfirmButton: false,
        allowOutsideClick: false

    });
});
</script>
@endif


@endsection