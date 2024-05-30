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
                                    <th>Kode</th>
                                    <th>Nama Tahapan Pembelian</th>
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


@foreach($tahapan_pembelian->result() as $row)
<div class="modal fade" id="edit_<?php echo $row->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title" id="exampleModalLabel">Edit Tahapan Pembelian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form
                    action="<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/tahapan-pembelian/edit/' . $row->id ?>"
                    class="form_edit" method="POST">

                    <div class="form-group">
                        <label class="font-weight-bold">Nama Tahapan Pembelian
                            <span class="text-danger">*</span></label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"
                                    id="basic-addon1"><?php echo $row->kode_tahapan_pembelian ?></span>
                            </div>
                            <input type="text" class="form-control" aria-describedby="basic-addon1"
                                value="<?php echo $row->nama_tahapan_pembelian ?>" name="nama_tahapan_pembelian"
                                required autofocus>
                        </div>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary font-weight-bold tombolEdit">Simpan</button>
                    </div>

                </form>



            </div>
        </div>
    </div>
</div>
@endforeach




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
            "url": "{{ base_url() }}{{ $ci->uri->segment(1) }}/{{ $ci->uri->segment(2) }}/tahapan-pembelian/ajax-list",
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
$('.form_edit').submit(function(e) {

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        dataType: 'json',
        data: $(this).serialize(),
        cache: false,
        beforeSend: function() {
            $('.tombolEdit').attr('disabled', 'disabled');
            $('.tombolEdit').html('<i class="fa fa-spin fa-spinner"></i> Sedang diproses');

            KTApp.block('#content_1', {
                overlayColor: '#000000',
                state: 'primary',
                message: 'Processing...'
            });

            setTimeout(function() {
                KTApp.unblock('#content_1');
            }, 1000);

        },
        complete: function() {
            $('.tombolEdit').removeAttr('disabled');
            $('.tombolEdit').html('Simpan');
        },
        error: function(e) {
            Swal.fire(
                'Error !',
                e,
                'error'
            )
        },
        success: function(data) {
            if (data.validasi) {
                $('.pesan').fadeIn();
                $('.pesan').html(data.validasi);
            }
            if (data.sukses) {
                toastr["success"]('Data berhasil disimpan');
                window.setTimeout(function() {
                    location.reload()
                }, 2000);
            }
        }
    })
    return false;

});
</script>
@endsection