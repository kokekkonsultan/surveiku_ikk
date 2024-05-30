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
    <div class="row">
        <div class="col">
            <div class="card" data-aos="fade-up">
                <div class="card-header bg-secondary font-weight-bold">
                    {{ $title }}
                </div>
                <div class="card-body">
                    <!-- <div class="text-right mb-3">
                        @php
                        echo anchor(base_url(). $ci->session->userdata('username') . '/data-perolehan-surveyor/export',
                        '<i class="fa fa-file-excel"></i></i> Export Excel', ['class' => 'btn
                        btn-success btn-sm font-weight-bold shadow-lg'])
                        @endphp
                    </div> -->
                    <div class="table-responsive">
                        <table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
                            <thead class="bg-secondary">
                                <tr>
                                    <th width="5%">No.</th>
                                    <th>Status</th>
                                    <th>Form</th>
                                    <!-- <th>Surveyor</th> -->
                                    <!-- <th>Nama Responden</th>
                                    <th>Asal Daerah</th> -->

                                    @foreach ($profil as $row)
                                    <th><?php echo $row->nama_profil_responden ?></th>
                                    @endforeach

                                    @foreach ($unsur->result() as $row)
                                    <th><?php echo $row->kode_unsur ?></th>
                                    @endforeach

                                    @foreach ($unsur->result() as $row)
                                    <th>A<?php echo $row->kode_alasan ?></th>
                                    @endforeach

                                    <th>Saran</th>
                                    <th>Waktu Isi Survei</th>
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
@endsection

@section('javascript')
<script src="{{ TEMPLATE_BACKEND_PATH }}plugins/custom/datatables/datatables.bundle.js"></script>
<script>
$(document).ready(function() {
    table = $('#table').DataTable({

        // "searching": true,
        // paging: true,
        // dom: 'Blfrtip',
        // "buttons": [{
        //     extend: 'collection',
        //     text: 'Export',
        //     buttons: [
        //         'excel'
        //     ]
        // }],

        "processing": true,
        "serverSide": true,
        // "lengthMenu": [
        //     [5, 10, 25, 50, 100, -1],
        //     [5, 10, 25, 50, 100, "Semua data"]
        // ],
        // "pageLength": 5,
        "order": [],
        "language": {
            "processing": '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
        },
        "ajax": {
            "url": "<?php echo base_url() . $ci->session->userdata('username') . '/data-perolehan-surveyor/ajax-list' ?>",
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