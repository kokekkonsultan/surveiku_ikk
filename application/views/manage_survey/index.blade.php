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
      @if($group->group_id == 2)
      <div class="text-right mb-5">
        <button type="button" class="btn btn-primary btn-sm font-weight-bold shadow-lg" data-toggle="modal" data-target="#modalCreateSurvey">
          <i class="fas fa-book"></i> Tambah Survey
        </button>
      </div>
      @endif
      <div class="table-responsive">
        <table id="table" cellspacing="0" width="100%">
          <thead>
            <tr>
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


@if($group->group_id == 2)
<div class="modal fade" id="modalCreateSurvey" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pilih Paket</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i aria-hidden="true" class="ki ki-close"></i>
        </button>
      </div>
      <div class="modal-body" id="bodyModalCreateSurvey">

        @if ($client_packet->num_rows() > 0)
        @php
        $last_packet = $client_packet->last_row();

        // cek jumlah terpakai
        $ci->db->select('manage_survey.id');
        $ci->db->from('berlangganan');
        $ci->db->join('manage_survey', 'manage_survey.id_berlangganan = berlangganan.id');
        $ci->db->where('berlangganan.uuid', $last_packet->uuid_berlangganan);
        $jumlah_kuesioner_dibuat = $ci->db->get()->num_rows();
        @endphp

        <p>
          Paket anda yang tersedia :
        </p>
        <a class="" <?php echo $status ?> title="Create Survei Dengan Paket Ini">
          <div class="card shadow" style="background-color: Bisque;">
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <h4>
                    <div class="font-weight-bold">
                      {{ $last_packet->nama_paket }}
                    </div>
                  </h4>
                  <div class="text-dark">
                    {!! $last_packet->deskripsi_paket !!}
                  </div>
                </div>
                <div class="col-md-6 text-right">
                  <div class="text-dark">
                    {{ $jumlah_kuesioner_dibuat }} kuesioner dibuat dari
                    {{ $last_packet->jumlah_kuesioner }} kuesioner kuota
                  </div>
                </div>
              </div>


            </div>
          </div>
        </a>
        @else
        <div class="text-center">
          Anda belum memiliki paket pembelian.
        </div>
        @endif

      </div>
    </div>
  </div>
</div>
@endif

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
        "url": "<?php echo base_url() . $ci->session->userdata('username') . '/kelola-survei/ajax-list' ?>",
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
  function cek() {
    Swal.fire({
      icon: 'warning',
      title: 'Informasi',
      text: 'Jumlah survei yang anda buat sudah memenuhi kuota paket yang anda beli!',
      allowOutsideClick: false,
      confirmButtonColor: '#DD6B55',
      confirmButtonText: 'Ya, Saya mengerti !',
    });
  }
</script>
@endsection