@extends('include_backend/template_backend')

@php
$ci = get_instance();
@endphp

@section('style')
<link href="{{ TEMPLATE_BACKEND_PATH }}plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')

<div class="container-fluid">
    <div class="card shadow" data-aos="fade-up">
        <div class="card-header bg-secondary font-weight-bold">
            {{ $title }}
        </div>
        <div class="card-body">
            <div class="text-right mb-3">
                <a href="<?php echo base_url() . 'lokasi-survei/create-provinsi/' ?>" class="btn btn-primary btn-sm font-weight-bold">Tambah Provinsi</a>
            </div>
            <div class="table-responsive">
                <table id="table" class="table" cellspacing="0" width="100%">
                    <thead class="bg-secondary">
                        <tr>
                            <th>Pilih Provinsi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
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
            "url": "{{ base_url() }}lokasi-survei/ajax-list",
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
@endsection