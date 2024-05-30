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
    <br>
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
                            TABULASI & {{strtoupper($title)}}
                        </h3>

                        <span class="btn btn-secondary btn-sm disable">
                            <i class="fa fa-bookmark"></i> <b><?php echo $jumlah_kuesioner_terisi ?>
                                Kuesioner Terisi</b></span>
                    </div>
                </div>
            </div>


            <div class="card card-custom card-sticky" data-aos="fade-down" data-aos-delay="300">

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%"
                            style="font-size: 12px;">
                            <thead class="bg-secondary">
                                <tr>
                                    <th width="5%">No.</th>
                                    <!-- <th>Status</th>
                                    <th>Surveyor</th> -->
                                    <th>Nama Lengkap</th>

                                    @foreach ($unsur->result() as $row)
                                    <th><?php echo $row->kode_unsur ?></th>
                                    @endforeach

                                    @foreach ($unsur->result() as $row)
                                    <th>A<?php echo $row->kode_alasan ?></th>
                                    @endforeach

                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <br>



            <div class="card" data-aos="fade-down" data-aos-delay="300">
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <td></td>
                                    @foreach ($unsur->result() as $value)
                                    <th class="bg-secondary"><?php echo $value->kode_unsur ?></th>
                                    @endforeach
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <th class="bg-dark text-white" width="40%">Total</th>
                                    @foreach ($total_nilai_unsur->result() as $row)
                                    <td>{{ROUND($row->total_nilai_unsur,2)}}</td>
                                    @endforeach
                                </tr>

                                <tr>
                                    <th class="bg-dark text-white">Rata-Rata</th>
                                    @foreach ($rata_rata_per_unsur->result() as $row)
                                    <td><?php echo ROUND($row->rata_per_unsur, 3) ?></td>
                                    @endforeach
                                </tr>

                                <tr>
                                    <th class="bg-dark text-white">Nilai Per Unsur</th>
                                    @foreach ($rata_rata_per_unsur->result() as $row)
                                    <td><?php echo ROUND($row->rata_per_unsur * 20, 3) ?></td>
                                    @endforeach
                                </tr>

                                <tr>
                                    <th class="bg-dark text-white">Rata-Rata Per Dimensi</th>
                                    @foreach ($rata_rata_per_dimensi->result() as $value)
                                    <td class="text-center" colspan="<?php echo $value->jumlah_unsur ?>">
                                        <?php echo ROUND($value->rata_per_dimensi * 20, 3) ?>
                                    </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <th class="bg-dark text-white">Rata-Rata x Bobot</th>
                                    @foreach ($rata_rata_per_unsur_x_bobot->result() as $row)
                                    <td><?php echo ROUND($row->persen_per_unsur * 20, 3) ?></td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <th class="bg-dark text-white">IKK</th>
                                    <td colspan="19" class="font-weight-bold text-info">
                                        <?php echo ROUND($ikk * 20, 3) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-dark text-white">MUTU</th>

                                    <td class="text-info" colspan=19 style="font-weight: bold;">
                                        <?php if (($ikk * 20) <= 20) {
                                            echo 'Sadar';
                                        } elseif (($ikk * 20) > 20 && ($ikk * 20) <= 40) {
                                            echo 'Paham';
                                        } elseif (($ikk * 20) > 40 && ($ikk * 20) <= 60) {
                                            echo 'Mampu';
                                        } elseif (($ikk * 20) > 60 && ($ikk * 20) <= 80) {
                                            echo 'Kritis';
                                        } elseif (($ikk * 20) > 80) {
                                            echo 'Berdaya';
                                        } else {
                                            NULL;
                                        } ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <a class="link font-weight-bold" data-toggle="collapse" data-target="#collapseExample"
                        aria-expanded="false" aria-controls="collapseExample"><b>Detail Peringkat Mutu</b></a>

                    <div class="collapse" id="collapseExample">
                        <br>
                        <div class="card card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nilai</th>
                                        <th>Mutu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1.</td>
                                        <td> (0-20) &lt;=20</td>
                                        <td>Sadar</td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td> (21-40) &gt;20 </td>
                                        <td>Paham</td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td> (41-60) &gt;40 </td>
                                        <td>Mampu</td>
                                    </tr>
                                    <tr>
                                        <td>4.</td>
                                        <td> (61-80) &gt;60 </td>
                                        <td>Kritis</td>
                                    </tr>
                                    <tr>
                                        <td>5.</td>
                                        <td> (81-100) &gt;80 </td>
                                        <td>Berdaya</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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
            "url": "<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/olah-data-online/ajax-list' ?>",
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