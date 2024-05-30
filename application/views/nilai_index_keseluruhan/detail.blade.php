@extends('include_backend/template_backend')

@php
$ci = get_instance();
@endphp

@section('style')
<link href="{{ TEMPLATE_BACKEND_PATH }}plugins/custom/datatables/datatables.bundle.css" rel="stylesheet"
    type="text/css" />
@endsection

@section('content')
<div class=" container-fluid">


    <div class="card shadow aos-init aos-animate" data-aos="fade-up">
        <div class="card-header bg-secondary font-weight-bold">
            {{ $sektor->nama_sektor }}
        </div>
        <div class="card-body">
            <table id="table" class="table table-bordered table-hover mt-5" cellspacing="0" width="100%">
                <thead class="bg-gray-300">
                    <tr>
                        <th width="5%">No</th>
                        <th>Sektor</th>
                        <th>Nilai IKK</th>
                        <th>Mutu Pelayanan</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
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
<script src="{{ TEMPLATE_BACKEND_PATH }}plugins/custom/datatables/datatables.bundle.js"></script>
<script>
var table;
$(document).ready(function() {
    table = $("#table").DataTable({
        "processing": true,
        "serverSide": true,
        "lengthMenu": [
            [5, 10, -1],
            [5, 10, "Semua data"]
        ],
        "pageLength": 5,
        "ordering": true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo base_url() . 'nilai-index-keseluruhan/ajax-list/' . $ci->uri->segment(2) ?>",
            "type": "POST",
            "dataType": "json",
            "dataSrc": function(jsonData) {
                return jsonData.data;
            },
            "data": function(data) {},

        },
        "columnDefs": [{
            "targets": [0],
            "orderable": false,
        }, ],

    });
});
</script>


<script>
function showedit(id) {
    $('#bodyModalDetail').html(
        "<div class='text-center'><img src='{{ base_url() }}assets/img/ajax/ajax-loader-big.gif'></div>");

    $.ajax({
        type: "post",
        url: "<?php echo base_url() . 'nilai-index-keseluruhan/'  . $ci->uri->segment(2) . '/' ?>" + id,
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