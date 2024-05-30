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

    <div class="row mt-5">
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

                        @if ($is_question == 1)
                        <a class="btn btn-primary btn-sm font-weight-bold" href="" data-toggle="modal"
                            data-target="#profil_responden"><i class="fa fa-plus"></i>
                            Tambah Profile Responden</a>
                        @endif

                    </div>
                </div>
            </div>

            <div class="card card-custom card-sticky" data-aos="fade-down">

                <div class="card-body">
                    <form
                        action="<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/profil-responden-survei/update-urutan' ?>"
                        method="POST" class="form_default">

                        <div class="table-responsive">
                            <table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%"
                                style="font-size: 12px;">
                                <thead class="bg-secondary">
                                    <tr>
                                        <th width="5%">Urutan</th>
                                        <th>Nama Profil Responden</th>
                                        <th>Pilihan Jawaban</th>
                                        @if ($is_question == 1)
                                        <th></th>
                                        <th></th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                        @if ($is_question == 1)
                        <hr>
                        <div class="mt-5">
                            <button type="submit" class="btn btn-light-success btn-sm tombolSimpanUrutan">Simpan
                                Urutan Profil Responden
                            </button>
                        </div>
                        @endif
                    </form>

                </div>
            </div>


            @if($manage_survey->is_active_target == 1 && $manage_survey->is_question == 1)
            @php
            if($manage_survey->is_target == 1){
            $bg = 'bg-light-danger';
            $text_color = 'text-danger';
            $konfirmasi = 'Dengan menekan tombol konfirmasi dibawah ini berarti anda akan merubah susunan sektor dan
            wilayah survei, proses ini akan menghapus semua target yang sudah di isi. Jangan khawatir,
            anda masih bisa mengelolanya setelah ini.';
            $label = 'Ubah Pengisian Sektor & Wilayah Survei';
            } else {
            $bg = 'bg-light-primary';
            $text_color = 'text-primary';
            $konfirmasi = 'Dengan menekan tombol konfirmasi dibawah ini berarti menutup pengisian sektor dan wilayah
            survei. Jangan khawatir, anda masih bisa mengelola halaman target setelah ini.';
            $label = 'Simpan Pengisian Sektor & Wilayah Survei';
            }
            @endphp
            <div class="card card-body shadow mt-5 {{$bg}}" data-aos="fade-down" data-aos-delay="300">
                <form
                    action="<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/profil-responden-survei/konfirmasi' ?>"
                    class="form_default" method="POST">

                    <div class="my-5">
                        <h3 class="text-dark font-weight-bold mb-5">{{$label}}</h3>

                        <p>{{$konfirmasi}}</p>
                        <br>

                        <button type="submit"
                            class="btn btn-white font-weight-bold shadow btn-block tombolKonfirmasi {{$text_color}}"
                            onclick="return confirm('Apakah anda yakin ingin mengkonfirmasi susunan sektor dan wilayah survei ?')"><i
                                class="fas fa-check-circle {{$text_color}}"></i>
                            Konfirmasi
                        </button>
                    </div>
                </form>
            </div>
            @endif

        </div>
    </div>
</div>


<!------------------------------------------------------- MODAL ------------------------------------------------------>
<div class="example-modal">
    <div id="profil_responden" class="modal fade" role="dialog" style="display:none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-secondary">
                    <h5 class="font-weight-bold">Tambah Profil Responden</h5>
                </div>
                <div class="modal-body">
                    <div class="" id="kt_blockui_content">

                        <button class="btn btn-success btn-sm btn-block shadow  font-weight-bold" type="button"
                            data-toggle="collapse" data-target="#collapseExample" aria-expanded="false"
                            aria-controls="collapseExample">
                            <i class="fa fa-history"></i> Ambil Dari Template
                        </button>

                        <div class="collapse" id="collapseExample">

                            <form
                                action="<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/profil-responden-survei/add-default' ?>"
                                class="form_default" method="POST">

                                <div class="card border-success card-body mt-3">

                                    @foreach ($profil_default->result() as $row)
                                    <div class="col">
                                        <label>
                                            <input class="form-check-input" type="checkbox"
                                                value="<?php echo $row->id ?>" name="check_list[]">
                                            <?php echo $row->nama_profil_responden ?>
                                        </label>
                                    </div>
                                    @endforeach

                                    @if($profil_default->num_rows() > 0)
                                    <div class=" text-right mt-3">
                                        <button type="submit"
                                            class="btn btn-light-primary btn-sm tombolSimpanDefault">Simpan</button>
                                    </div>
                                    @else
                                    <div class="text-center text-info">Semua Profil Default sudah digunakan!</div>
                                    @endif

                                </div>
                            </form>
                        </div>


                        <a class="btn btn-info btn-sm btn-block shadow mt-5 font-weight-bold"
                            href="<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/profil-responden-survei/add-custom' ?>"><i
                                class="fa fa-edit"></i> Custom Profil
                        </a>
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
            [5, 10, -1],
            [5, 10, "Semua data"]
        ],
        "pageLength": 5,
        "order": [],
        "language": {
            "processing": '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
        },
        "ajax": {
            "url": "<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/profil-responden-survei/ajax-list' ?>",
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
            url: "<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/profil-responden-survei/delete/' ?>" +
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
$('.form_default').submit(function(e) {

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        dataType: 'json',
        data: $(this).serialize(),
        cache: false,
        beforeSend: function() {
            $('.tombolSimpanDefault').attr('disabled', 'disabled');
            $('.tombolSimpanDefault').html('<i class="fa fa-spin fa-spinner"></i> Sedang diproses');
            $('.tombolSimpanUrutan').attr('disabled', 'disabled');
            $('.tombolSimpanUrutan').html('<i class="fa fa-spin fa-spinner"></i> Sedang diproses');
            $('.tombolKonfirmasi').attr('disabled', 'disabled');
            $('.tombolKonfirmasi').html('<i class="fa fa-spin fa-spinner"></i> Sedang diproses');


            Swal.fire({
                title: 'Memproses data',
                html: 'Mohon tunggu sebentar. Sistem sedang menyiapkan request anda.',
                allowOutsideClick: false,
                onOpen: () => {
                    swal.showLoading()
                }
            });

        },
        complete: function() {
            $('.tombolSimpanDefault').removeAttr('disabled');
            $('.tombolSimpanDefault').html('Simpan');
            $('.tombolSimpanUrutan').removeAttr('disabled');
            $('.tombolSimpanUrutan').html('Simpan Urutan Profil Responden');
            $('.tombolKonfirmasi').removeAttr('disabled');
            $('.tombolKonfirmasi').html(
                '<i class="fas fa-check-circle {{$text_color}}"></i> Konfirmasi');
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
                }, 2500);
            }
        }
    })
    return false;
});
</script>


<script>
// $(document).ready(function() {
//     $('#myCheck').change(function() {
//         if ($(this).is(":checked")) {
//             $('.btn-konfirmasi').removeAttr('disabled');
//             alert('Bobot anda sudah melebihi 100%');
//         } else {
//             $('.btn-konfirmasi').attr('disabled', 'disabled');
//             alert('Bobot anda sudah melebihi 10%');
//         }
//     });
// });
</script>
@endsection