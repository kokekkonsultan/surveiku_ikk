<?php
$ci = get_instance();
?>
<div class="modal-header bg-secondary text-white">
    <h5 class="modal-title" id="exampleModalLabel">Target <?php echo e($wilayah_survei->nama_wilayah); ?></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <i aria-hidden="true" class="ki ki-close"></i>
    </button>
</div>
<div class="modal-body">
    <form action="<?php echo base_url() . $ci->uri->segment(1) . '/' . $ci->uri->segment(2) . '/target-per-wilayah/update/' . $ci->uri->segment(5) ?>" method="POST" class="form_update">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center" style="vertical-align: middle;">No</th>
                    <th class="text-center" style="vertical-align: middle;">Nama Sektor</th>
                    <th class="text-center">Target Online</th>
                    <th class="text-center">Target Offline</th>
                    <th class="text-center">Total Target</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                ?>
                <?php $__currentLoopData = $target->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <!-- <input name="id[]" value="<?php echo e($row->id); ?>"> -->
                <tr>
                    <td class="text-center" style="vertical-align: middle;"><?php echo e($no++); ?></td>
                    <td style="vertical-align: middle;">
                        <input name="id[]" value="<?php echo e($row->id_sektor); ?>" hidden><?php echo e($row->nama_sektor); ?>

                    </td>
                    <td class="text-center">
                        <?php if($manage_survey->is_question == 1): ?>
                        <input type="number" class="form-control form-control-sm" name="target_online[]" value="<?php echo e($row->target_online); ?>" placeholder="Isikan target survei..." autofocus required>
                        <?php else: ?>
                        <span class="badge badge-secondary"><?php echo e($row->target_online); ?></span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <?php if($manage_survey->is_question == 1): ?>
                        <input type="number" class="form-control form-control-sm" name="target_offline[]" value="<?php echo e($row->target_offline); ?>" placeholder="Isikan target survei..." autofocus required>
                        <?php else: ?>
                        <span class="badge badge-secondary"><?php echo e($row->target_offline); ?></span>
                        <?php endif; ?>
                    </td>

                    <td class="text-center">
                        <span class="badge badge-info"><?php echo e($row->total_target == NULL ? 0 : $row->total_target); ?></span>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <tr>
                    <th colspan="2" class="text-center">TOTAL</th>
                    <th class="text-center">
                        <span class="badge badge-dark">
                            <?php echo e($wilayah_survei->target_wilayah_online == NULL ? 0 : $wilayah_survei->target_wilayah_online); ?>

                        </span>
                    </th>
                    <th class="text-center">
                        <span class="badge badge-dark">
                            <?php echo e($wilayah_survei->target_wilayah_offline == NULL ? 0 : $wilayah_survei->target_wilayah_offline); ?>

                        </span>
                    </th>
                    <th class="text-center">
                        <span class="badge badge-dark">
                            <?php echo e($wilayah_survei->total_target_wilayah == NULL ? 0 : $wilayah_survei->total_target_wilayah); ?>

                        </span>
                    </th>

                </tr>

            </tbody>
        </table>

        <?php if($manage_survey->is_question == 1): ?>
        <div class="text-right mt-5">
            <label><input type="checkbox" name="is_all" value="1"> Gunakan Target untuk semua
                wilayah.
                <hr>
            </label>
            <br>
            <button type="submit" class="btn btn-primary btn-sm tombolSimpan">Simpan Target</button>
        </div>
        <?php endif; ?>
    </form>
</div>


<script>
    $('.form_update').submit(function(e) {

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            cache: false,
            beforeSend: function() {
                $('.tombolSimpan').attr('disabled', 'disabled');
                $('.tombolSimpan').html('<i class="fa fa-spin fa-spinner"></i> Sedang diproses');

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
                $('.tombolSimpan').removeAttr('disabled');
                $('.tombolSimpan').html('Simpan Target');
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
</script><?php /**PATH C:\xampp-7.3.33\htdocs\surveiku_ikk\application\views/target_per_wilayah/detail.blade.php ENDPATH**/ ?>