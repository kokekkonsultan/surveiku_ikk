@extends('include_backend/template_backend')

@php
$ci = get_instance();
@endphp

@section('style')
<link href="{{ TEMPLATE_BACKEND_PATH }}plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')

<div class="container-fluid">
    <div class="card" data-aos="fade-down" data-aos-delay="300">
        <div class="card-header bg-secondary font-weight-bold">
            Detail Alasan - {{ $users->first_name . ' ' . $users->last_name }}
        </div>
        <div class="card-body">
            <div class="card card-body">
                <table width="100%" border="0">
                    <tr>
                        <td width="3%" valign="top" class="font-weight-bold"><?php echo $pertanyaan->id ?>.</td>
                        <td><?php echo $pertanyaan->isi_pertanyaan ?></td>
                    </tr>
                </table>
            </div>
            <br>
            <hr>
            <br>

            <div class="table-responsive">
                <table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
                    <thead class="bg-secondary">
                        <tr>
                            <th>No.</th>
                            <th>Nama Responden</th>
                            <th>Jawaban yang dipilih</th>
                            <th>Alasan Jawaban</th>
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
                "url": "<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(3) . '/rekap-alasan/ajax-list-detail/' .  $ci->uri->segment(4) ?>",
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