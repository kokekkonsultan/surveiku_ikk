@extends('include_backend/template_backend')

@php
$ci = get_instance();
@endphp

@section('style')

@endsection

@section('content')


<div class="container">
    <div class="row justify-content-md-center">
        <div class="col">

            <div class="card card-custom card-sticky" id="kt_blockui_content" data-aos="fade-up">
                <div class="card-header bg-secondary">
                    <div class="card-title">
                        Buat Survey Baru
                    </div>
                </div>
                <div class="card-body">
                    <small>Sebuah survey setidaknya harus diisi dengan nama survey, tahun survey, kapan survey
                        dilaksanakan dan kapan survey berakhir.</small>
                    <div class="mt-5">

                        <br>

                        <div class="">

                            <form action="{{ $form_action }}" method="post" class="form_submit">

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label font-weight-bold">Nama Survei <span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        {!! form_input($survey_name); !!}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label font-weight-bold">Organisasi Yang di Survei
                                        <span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        {!! form_input($organisasi); !!}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label font-weight-bold">Tamplate <span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <div class="radio-list">
                                            <label class="radio"><input type="radio" name="template" id="2" value="2" class="template" required><span></span>&nbsp Tanpa Template</label>
                                            <label class="radio"><input type="radio" name="template" id="1" value="1" class="template"><span></span>&nbsp Dengan Template</label>
                                        </div>

                                        <br>
                                        <select class="form-control" id="id_klasifikasi_survey" name="id_klasifikasi_survey" autofocus style="display:none">
                                            <option value="">Pilih Template</option>
                                            @foreach ($klasifikasi_survey->result() as $row)
                                            <option value="{{$row->id}}">
                                                {{$row->nama_klasifikasi_survey}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label font-weight-bold">Tanggal Survei <span class="text-danger">*</span></label>
                                    <div class="col-sm-10">

                                        <div class='input-group' id='kt_daterangepicker_2'>

                                            <input class="form-control readonly" id="tanggal_survei" name="tanggal_survei" type="text" style="width: 300px;" placeholder="Pilih rentang tanggal survei" required autocomplete="off">

                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label font-weight-bold">Deskripsi
                                        <small>(Optional)</small></label>
                                    <div class="col-sm-10">
                                        @php
                                        echo form_textarea($description);
                                        @endphp
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label font-weight-bold">Link Kuesioner <span class="text-danger">*</span></label>
                                    <div class="col-10 col-form-label">
                                        <div class="radio-inline">
                                            <label class="radio radio">
                                                <input type="radio" name="custom" id="default" value="Default" class="custom" required>
                                                <span></span>
                                                Default
                                            </label>
                                        </div>
                                        <span class="form-text text-muted">Sistem akan membuat link survei untuk
                                            anda.</span>
                                        <hr>
                                        <div class="radio-inline">
                                            <label class="radio radio">
                                                <input type="radio" name="custom" id="custom" value="Custom" class="custom">
                                                <span></span>
                                                Custom
                                            </label>
                                        </div>
                                        <span class="form-text text-muted">Anda yang akan menentukan link survei.</span>

                                        <div class="mt-5">
                                            <input class="form-control" type="text" name="link" id="link" placeholder="Masukkan Link Survey Anda ..." style="display:none" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label font-weight-bold">Metode Sampling<span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        @php
                                        echo form_dropdown($id_sampling);
                                        @endphp
                                    </div>
                                </div>


                                <div class="form-group row" class="krejcie" id="krejcie" hidden>
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-5">
                                        <label class="col-form-label font-weight-bold">Jumlah Populasi <span class="text-danger">*</span></label>
                                        <input type="text" id="populasi_krejcie" name="populasi_krejcie" class="form-control" placeholder="10000">
                                    </div>
                                    <div class="col-sm-5">
                                        <label class="col-form-label font-weight-bold">Jumlah Minimal Sampling
                                            <span class="text-danger">*</span></label>
                                        <input type="text" id="total_krejcie" name="total_krejcie" class="form-control" placeholder="370" style="background-color: #F3F6F9;" readonly>
                                    </div>
                                </div>

                                <div class="form-group row" class="slovin" id="slovin" hidden>
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-5">
                                        <label class="col-form-label font-weight-bold">Jumlah Populasi <span class="text-danger">*</span></label>
                                        <input type="text" id="populasi_slovin" name="populasi_slovin" class="form-control" placeholder="10000">
                                    </div>
                                    <div class="col-sm-5">
                                        <label class="col-form-label font-weight-bold">Jumlah Minimal Sampling <span class="text-danger">*</span></label>
                                        <input type="text" id="total_slovin" name="total_slovin" class="form-control" placeholder="385" style="background-color: #F3F6F9;" readonly>
                                    </div>
                                </div>

                                <br>



                                @if($data_user->id_kelompok_skala == 2)
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label font-weight-bold">Provinsi Yang di Survei
                                        <span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        @php
                                        echo form_dropdown($wilayah_provinsi);
                                        @endphp
                                    </div>
                                </div>
                                @elseif($data_user->id_kelompok_skala == 3)
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label font-weight-bold">Kota Kabupaten Yang di
                                        Survei <span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        @php
                                        echo form_dropdown($wilayah_kota_kabupaten);
                                        @endphp
                                    </div>
                                </div>
                                @elseif($data_user->id_kelompok_skala == 4)
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label font-weight-bold">Kecamatan Yang di Survei
                                        <span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        @php
                                        echo form_dropdown($wilayah_kecamatan);
                                        @endphp
                                    </div>
                                </div>
                                @else

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label font-weight-bold">Wilayah Yang di Survei <span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <input value="1" name="id_wilayah" style="display:none;">
                                        <input value="Indonesia" class="form-control" disabled>
                                    </div>
                                </div>
                                @endif

                                <br>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label font-weight-bold">Gunakan
                                        Target pada Survei <span style="color:red;">*</span></label>

                                    <div class="col-sm-10">

                                        <div class="radio-inline">
                                            <label class="radio">
                                                <input type="radio" name="is_active_target" value="1" required>
                                                <span></span> Ya
                                            </label>
                                        </div>
                                        <span class="form-text text-muted">Jika <b>Ya</b> maka survei harus menggunakan
                                            target pengisian.</span>

                                        <hr>

                                        <div class="radio-inline">
                                            <label class="radio">
                                                <input type="radio" name="is_active_target" value="2" required>
                                                <span></span> Tidak
                                            </label>
                                        </div>
                                        <span class="form-text text-muted">Jika <b>Tidak</b> maka survei tidak
                                            menggunakan target pengisian.</span>

                                    </div>
                                </div>



                                <br>
                                <br>
                                <div class="text-right mt-5">
                                    <button type="button" onclick="link_back()" class="btn btn-secondary font-weight-bold tombolCancel">Kembali</button>
                                    <button type="submit" class="btn btn-primary font-weight-bold tombolSubmit">Buat
                                        Survei</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')

@php
$link_back = base_url().$ci->session->userdata('username').'/kelola-survei';
@endphp
<script>
    function link_back() {
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Anda akan meninggalkan halaman ini ?",
            type: 'warning',
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oke',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.value) {
                window.location.href = "{{ $link_back }}";
            }
        })
    }
</script>

<script type="text/javascript">
    $(function() {
        $(":radio.custom").click(function() {
            $("#link").hide()
            if ($(this).val() == "Custom") {
                $("#link").show().prop('required', true);
            } else {
                $("#link").removeAttr('required').hidden();
            }
        });
    });
</script>

<script type="text/javascript">
    $(function() {
        $(":radio.template").click(function() {
            $("#id_klasifikasi_survey").hide()
            if ($(this).val() == "1") {
                $("#id_klasifikasi_survey").show().prop('required', true);
            } else {
                $("#id_klasifikasi_survey").removeAttr('required').hidden();
            }
        });
    });
</script>

<script>
    $(".readonly").on('keydown paste focus mousedown', function(e) {
        if (e.keyCode != 9) // ignore tab
            e.preventDefault();
    });
</script>

<script type="text/javascript">
    $(function() {
        $("#id_sampling").change(function() {
            console.log($("#id_sampling option:selected").val());
            // $("#krejcie").hide();
            if ($("#id_sampling option:selected").val() == 1) {
                $('#krejcie').prop('hidden', false);
                $('#slovin').prop('hidden', true);
            } else if ($("#id_sampling option:selected").val() == 2) {
                $('#krejcie').prop('hidden', true);
                $('#slovin').prop('hidden', false);
            } else {
                $('#krejcie').prop('hidden', true);
                $('#slovin').prop('hidden', true);
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#populasi_krejcie").keyup(function() {
            var populasi_krejcie = $("#populasi_krejcie").val();
            var total_krejcie = (3.841 * parseInt(populasi_krejcie) * 0.5 * 0.5) / ((0.05 * 0.05) * (
                parseInt(populasi_krejcie) - 1) + (3.841 * 0.5 * 0.5));
            $("#total_krejcie").val(Math.ceil(total_krejcie));
        });

        $("#populasi_slovin").keyup(function() {
            var populasi_slovin = $("#populasi_slovin").val();
            var total_slovin = parseInt(populasi_slovin) / (1 + parseInt(populasi_slovin) * (0.015 * 0.015));
            $("#total_slovin").val(Math.ceil(total_slovin));
        });
    });
</script>

<script>
    $(document).ready(function(e) {
        $('.form_submit').submit(function(e) {

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                dataType: 'json',
                data: $(this).serialize(),
                cache: false,
                beforeSend: function() {
                    $('.tombolCancel').attr('disabled', 'disabled');
                    $('.tombolSubmit').attr('disabled', 'disabled');
                    $('.tombolSubmit').html(
                        '<i class="fa fa-spin fa-spinner"></i> Sedang diproses');

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
                    $('.tombolCancel').removeAttr('disabled');
                    $('.tombolSubmit').removeAttr('disabled');
                    $('.tombolSubmit').html('Simpan');
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
                        window.location.href = "{{ $link_back }}";

                    }
                }
            })
            return false;
        });
    });
</script>

<script>
    var KTTinymce = function() {
        var demos = function() {
            tinymce.init({
                selector: '#tinymce-kuesioner',
                menubar: false,
                statusbar: false,
                branding: false,
                toolbar: [
                    'undo redo | cut copy paste | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent | code'
                ],
                plugins: 'advlist autolink link image lists charmap print preview code'
            });
        }
        return {
            init: function() {
                demos();
            }
        };
    }();
    jQuery(document).ready(function() {
        KTTinymce.init();
    });
</script>


<script>
    var KTBootstrapDaterangepicker = function() {

        // Private functions
        var demos = function() {
            // input group and left alignment setup
            $('#kt_daterangepicker_2').daterangepicker({
                buttonClasses: ' btn',
                applyClass: 'btn-primary',
                cancelClass: 'btn-secondary'
            }, function(start, end, label) {
                $('#kt_daterangepicker_2 .form-control').val(start.format('YYYY-MM-DD') + ' / ' + end
                    .format('YYYY-MM-DD'));
            });
        }

        return {
            // public functions
            init: function() {
                demos();
            }
        };
    }();

    jQuery(document).ready(function() {
        KTBootstrapDaterangepicker.init();
    });
</script>


<script>
    var KTSelect2 = function() {
        var demos = function() {
            $('#id_wilayah').select2({
                placeholder: 'Please Select'
            });

            $('#id_wilayah').select2({
                placeholder: 'Please Select'
            });
        }
        return {
            init: function() {
                demos();
            }
        };
    }();

    jQuery(document).ready(function() {
        KTSelect2.init();
    });
</script>
@endsection