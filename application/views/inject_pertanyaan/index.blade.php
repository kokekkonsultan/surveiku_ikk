@extends('include_backend/template_backend')

@php
$ci = get_instance();
@endphp

@section('style')
<link href="{{ TEMPLATE_BACKEND_PATH }}plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="container">
    <div class="card shadow" data-aos="fade-up">
        <div class="card-header bg-secondary font-weight-bold">
            {{ $title }}
        </div>
        <div class="card-body pt-3 font-size-h6 font-weight-normal" id="kt_blockui_content">

            <form action="<?php echo base_url() . 'inject-pertanyaan/get' ?>" class="form_default" method="POST">

                <br>


                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Klasifikasi Survei <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="id_klasifikasi_survey" class="form-control" required>
                            <option value="">Please Select</option>

                            @foreach($ci->db->get("klasifikasi_survey")->result() as $row)
                            <option value="{{$row->id}}">{{$row->nama_klasifikasi_survey}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>


                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Terapkan Pada Survei ?
                        <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <div class="checkbox-list required">
                            @foreach($ci->db->query("SELECT *, manage_survey.id AS id_survey
                            FROM manage_survey
                            JOIN users ON manage_survey.id_user = users.id")->result() as $row)
                            <label class="checkbox">
                                <input type="checkbox" name="id_survey[]" value="{{$row->id_survey}}" required>
                                <span></span> {{$row->survey_name}}
                                <b>({{$row->first_name . ' ' . $row->last_name}})</b>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <br>



                <div class="text-right">
                    <?php echo anchor(base_url() . 'dashboard', 'Kembali', ['class' => 'btn btn-secondary font-weight-bold shadow']); ?>
                    <button type="submit" class="btn btn-primary font-weight-bold shadow tombolSimpan">Proses</button>
                </div>

            </form>


        </div>
    </div>
</div>

@endsection

@section('javascript')
<script src="{{ TEMPLATE_BACKEND_PATH }}plugins/custom/datatables/datatables.bundle.js"></script>

<script>
    // $('div.checkbox-list.required :checkbox:checked').length > 0;
    // $('div.checkbox-group.required :checkbox:checked').length > 0;

    $(function() {
        var requiredCheckboxes = $('.checkbox-list :checkbox[required]');
        requiredCheckboxes.change(function() {
            if (requiredCheckboxes.is(':checked')) {
                requiredCheckboxes.removeAttr('required');
            } else {
                requiredCheckboxes.attr('required', 'required');
            }
        });
    });
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
                $('.tombolSimpan').attr('disabled', 'disabled');
                $('.tombolSimpan').html('<i class="fa fa-spin fa-spinner"></i> Sedang diproses');


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
                $('.tombolSimpan').removeAttr('disabled');
                $('.tombolSimpan').html('Proses');
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
                    Swal.fire(
                        'Informasi',
                        'Berhasil memproses data!',
                        'success'
                    );
                    window.setTimeout(function() {
                        location.href = "<?php echo base_url() . 'dashboard' ?>"
                    }, 2500);
                }
            }
        })
        return false;
    });
</script>

@endsection