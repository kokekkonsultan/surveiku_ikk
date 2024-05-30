@php
$ci = get_instance();
$ci->load->helper('form');
@endphp

<form
    action="{{base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/dimensi/edit/'.$ci->uri->segment(5)}}"
    method="POST" class="form_edit">

    <div class="form-group">
        <label class="font-weight-bold">Tahapan Pembelian <span class="text-danger">*</span></label>
        <?php echo form_input($id_tahapan_pembelian); ?>
    </div>

    <div class="form-group">
        <label class="font-weight-bold">Nama Dimensi <span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text font-weight-bold"><?php echo $kode_dimensi ?></span>
            </div>
            <?php echo form_input($nama_dimensi); ?>
        </div>
    </div>

    <div class="form-group">
        <label class="font-weight-bold">Persentase Bobot <span class="text-danger">*</span></label>
        <div class="input-group mb-3">
            <input type="number" class="form-control" placeholder="Masukkan Bobot Dimensi" id="persentase_edit"
                name="persentase_dimensi" value="<?php echo $persentase_dimensi ?>" required>
            <div class="input-group-append">
                <span class="input-group-text font-weight-bold" id="basic-addon2">%</span>
            </div>
        </div>
    </div>

    <div class="text-right mb-5">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary tombolEdit">Simpan</button>
    </div>
</form>




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
            $('.tombolEdit').html(
                '<i class="fa fa-spin fa-spinner"></i> Sedang diproses');
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


<script type="text/javascript">
$(document).ready(function() {
    $("#persentase_edit").keyup(function() {
        var total_bobot_edit = <?php echo $total_persentase ?>;
        var persentase_edit = $("#persentase_edit").val();

        if ((parseInt(total_bobot_edit) + parseInt(persentase_edit)) > 100) {
            $('.tombolEdit').attr('disabled', 'disabled');
            $('.tombolEdit').html('Bobot Sudah Melebihi 100%');
            alert('Bobot anda sudah melebihi 100%');

        } else {
            $('.tombolEdit').removeAttr('disabled');
            $('.tombolEdit').html('Simpan');
        }
    });
});
</script>