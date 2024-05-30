@extends('include_backend/template_backend')

@php
$ci = get_instance();
@endphp

@section('style')

@endsection

@section('content')
<div class="container">
    <div class="card shadow" data-aos="fade-up">
        <div class="card-header bg-secondary font-weight-bold">
            {{ $title }}
        </div>
        <div class="card-body pt-3 font-size-h6 font-weight-normal" id="kt_blockui_content">

            {!! form_open($form_action, ['class' => '']) !!}
            {!! validation_errors() !!}

            <br>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label"><b>Pertanyaan</b> <span class="text-danger">*</span></label>
                <div class="col-sm-10"><?php echo form_textarea($pertanyaan_unsur); ?></div>
            </div>
            <br>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label font-weight-bold">Tampilkan Alasan Jawaban di Form Survei ? <span style="color:red;">*</span></label>
                <div class="col-10 col-form-label">
                    <div class="radio-inline">
                        <label class="radio radio-md">
                            <input type="radio" name="is_active_alasan" value="1" class="is_alasan" required <?php echo $pertanyaan->is_active_alasan == 1 ? 'checked' : '' ?>>
                            <span></span>
                            Ya
                        </label>
                    </div>
                    <div class="mt-3 mb-5" id="inputan" <?php echo $pertanyaan->is_active_alasan == 1 ? "" : "style='display: none;'" ?>>
                        <input class="form-control" name="label_alasan" placeholder="Silahkan isi label jika ditampilkan alasan ..." value="{{$pertanyaan->label_alasan}}">
                        <small class="text-dark-50">Jika kosong maka label akan di isi default (Masukkan alasan jawaban pada bidang ini ...)</small>

                        @php
                                $atribute_alasan = unserialize($pertanyaan->atribute_alasan);
                                @endphp
                                <div class="form-group row mt-5">
                                    <label class="col-sm-3 col-form-label font-weight-bold">Munculkan Alasan pada ?
                                        <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <div class="checkbox-list">
                                            <label class="checkbox">
                                                <input type="checkbox" name="atribute_alasan[]" value="1" {{in_array(1, $atribute_alasan) ? 'checked' : ''}}>
                                                <span></span> Pilihan Jawaban 1
                                            </label>
                                            <label class="checkbox">
                                                <input type="checkbox" name="atribute_alasan[]" value="2" {{in_array(2, $atribute_alasan) ? 'checked' : ''}}>
                                                <span></span> Pilihan Jawaban 2
                                            </label>
                                            <label class="checkbox">
                                                <input type="checkbox" name="atribute_alasan[]" value="3" {{in_array(3, $atribute_alasan) ? 'checked' : ''}}>
                                                <span></span> Pilihan Jawaban 3
                                            </label>
                                            <label class="checkbox">
                                                <input type="checkbox" name="atribute_alasan[]" value="4" {{in_array(4, $atribute_alasan) ? 'checked' : ''}}>
                                                <span></span> Pilihan Jawaban 4
                                            </label>
                                            <label class="checkbox">
                                                <input type="checkbox" name="atribute_alasan[]" value="5" {{in_array(5, $atribute_alasan) ? 'checked' : ''}}>
                                                <span></span> Pilihan Jawaban 5
                                            </label>
                                        </div>
                                    </div>
                                </div>
                    </div>
                    <hr>
                    <div class="radio-inline">
                        <label class="radio radio-md">
                            <input type="radio" name="is_active_alasan" value="2" class="is_alasan" <?php echo $pertanyaan->is_active_alasan == 2 ? 'checked' : '' ?>>
                            <span></span>
                            Tidak
                        </label>

                    </div>
                </div>
            </div>
            <br>

            <h5>Pilihan Jawaban</h5>
            <hr>

            <?php
            $no = 1;
            foreach ($nilai_unsur_pelayanan as $row) {
            ?>
            <input type="text" name="id[]" value="{{ $row->id }}" hidden>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label"><b>Pilihan Jawaban <?php echo $no++; ?></b> <span
                        style="color: red;">*</span></label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nama_jawaban[]"
                        value="<?php echo $row->nama_jawaban; ?>">
                </div>
            </div>
            <?php
            }
            ?>

            <div class="text-right">
                <?php echo anchor(base_url().'pertanyaan', 'Kembali', ['class' => 'btn btn-secondary font-weight-bold shadow']); ?>
                <input type="submit" class="btn btn-primary font-weight-bold shadow" value="Simpan">
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script src="{{ base_url() }}assets/themes/metronic/assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js"></script>
<script src="{{ base_url() }}assets/themes/metronic/assets/js/pages/crud/forms/editors/ckeditor-classic.js"></script>

<script type="text/javascript">
    $(function() {
        $(":radio.is_alasan").click(function() {
            $("#inputan").hide()
            if ($(this).val() == "1") {
                $("#inputan").show();
            } else {
                $("#inputan").hidden();
            }
        });
    });
</script>

<script>
var KTTinymce = function() {
    // Private functions
    var demos = function() {
        tinymce.init({
            selector: '#tinymce-survei',
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
        // public functions
        init: function() {
            demos();
        }
    };
}();

// Initialization
jQuery(document).ready(function() {
    KTTinymce.init();
});
</script>
@endsection