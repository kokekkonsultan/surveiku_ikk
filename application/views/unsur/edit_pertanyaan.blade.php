@extends('include_backend/template_backend')

@php
$ci = get_instance();
@endphp

@section('style')

@endsection

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <b><?php echo $title; ?></b>
        </div>
        <div class="card-body pt-3 font-size-h6 font-weight-normal" id="kt_blockui_content">

            <?php echo form_open($form_action, ['class' => '']); ?>
            <?php echo validation_errors(); ?>

            <div class="form-group">
                <label for="">Pertanyaan <span class="text-danger">*</span></label>
                <?php echo form_textarea($pertanyaan_unsur); ?>
            </div>
            <br>
            <div class="text-right">
                <?php echo anchor(base_url() . 'unsur', 'Kembali', ['class' => 'btn btn-secondary']); ?>
                <input type="submit" class="btn btn-primary" value="Simpan">
            </div>
            <?php echo form_close(); ?>


        </div>
    </div>
</div>

@endsection

@section('javascript')
<script src="{{ TEMPLATE_BACKEND_PATH }}plugins/custom/ckeditor/ckeditor-classic.bundle.js"></script>
<script src="{{ TEMPLATE_BACKEND_PATH }}js/pages/crud/forms/editors/ckeditor-classic.js"></script>

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