@extends('include_backend/template_backend')

@php
$ci = get_instance();
@endphp

@section('style')

@endsection

@section('content')

<div class="container-fluid">

    @include("include_backend/partials_no_aside/_inc_menu_repository")

    <div class="row mt-5">
        <div class="col-md-3">
            @include('manage_survey/menu_data_survey')
        </div>
        <div class="col-md-9">

            <div class="row justify-content-md-center">
                <div class="col col-lg-12">

                    @include('setting_survei/menu_settings')<br>

                    <div class="card border-danger" data-aos="fade-down">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <h5 class="card-title">Delete Survey</h5>
                                    <p class="card-text">Setelah Anda menghapus survey, data tidak akan bisa
                                        dikembalikan. Harap yakin.</p>
                                </div>
                                <div class="col-md-4 text-right mt-3">
                                    <button type="button" class="btn btn-danger font-weight-bold"
                                        onclick="delete_data(<?php echo $id_manage_survey ?>)">Hapus Survey Ini</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection

@section('javascript')
<script>
function delete_data(id) {
    Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Anda akan menghapus survey ini beserta semua datanya!",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Batal',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, saya menghapusnya!'
    }).then((result) => {
        if (result.value) {

            $.ajax({
                url: "{{ base_url() }}manage-survey/delete/" + id,
                type: "POST",
                dataType: "JSON",
                beforeSend: function() {
                    Swal.fire({
                        title: 'Memproses data',
                        html: 'Mohon tunggu sebentar. Sistem sedang melakukan request anda.',
                        allowOutsideClick: false,
                        onOpen: () => {
                            swal.showLoading()
                        }
                    });
                },
                success: function(data) {
                    if (data.status) {

                        window.location.href =
                            "{{ base_url().$ci->session->userdata('username') }}/kelola-survei";

                    } else {

                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error deleting data');
                }
            });
        }
    });
}
</script>

<script>
$('.form_atribut_pertanyaan').submit(function(e) {

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        dataType: 'json',
        data: $(this).serialize(),
        cache: false,
        beforeSend: function() {
            $('.tombolSimpanJenisPertanyaan').attr('disabled', 'disabled');
            $('.tombolSimpanJenisPertanyaan').html(
                '<i class="fa fa-spin fa-spinner"></i> Sedang diproses');

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
            $('.tombolSimpanJenisPertanyaan').removeAttr('disabled');
            $('.tombolSimpanJenisPertanyaan').html('Update Jenis Pertanyaan');
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
                }, 1000);
            }
        }
    })
    return false;

});
</script>
@endsection