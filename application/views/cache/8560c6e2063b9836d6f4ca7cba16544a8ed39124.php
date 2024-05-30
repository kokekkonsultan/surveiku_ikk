

<?php
$ci = get_instance();
?>

<?php $__env->startSection('style'); ?>
<link href="<?php echo e(TEMPLATE_BACKEND_PATH); ?>plugins/custom/datatables/datatables.bundle.css" rel="stylesheet"
    type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container mt-5">

    <div class="card" data-aos="fade-up">
        <div class="card-header bg-secondary font-weight-bold">
            Pengguna Klien
        </div>
        <div class="card-body">

            <div class="text-right mb-3">
                <?php
                echo anchor(base_url().'pengguna-klien/create-klien', '<i class="fas fa-plus"></i> Tambah Klien',
                ['class' => 'btn btn-primary font-weight-bold shadow-lg'])
                ?>
                <?php
                echo anchor(base_url().'berlangganan', '<i class="fas fa-users"></i> Lihat Status Berlangganan Klien',
                ['class' => 'btn btn-light-primary font-weight-bold shadow-lg']);
                ?>
            </div>
            <div class="table-responsive">
                <table id="table" class="table table-bordered" cellspacing="0" width="100%">
                    <thead class="bg-secondary">
                        <tr>
                            <th>No.</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Groups</th>
                            <th>Status</th>
                            <th>Detail</th>
                            <th></th>
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

<div class="modal fade" id="modal_userDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title" id="exampleModalLabel">Caption</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body" id="bodyModalDetail">
                <div align="center" id="loading_registration">
                    <img src="<?php echo e(base_url()); ?>assets/img/ajax/ajax-loader-big.gif" alt="">
                </div>

            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<?php if($message): ?>
<script type="text/Javascript">
    Swal.fire('<?php
        echo $message ?> ');
</script>
<?php endif; ?>

<script src="<?php echo e(TEMPLATE_BACKEND_PATH); ?>plugins/custom/datatables/datatables.bundle.js"></script>
<script>
$(document).ready(function() {
    table = $('#table').DataTable({

        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo e(base_url()); ?>pengguna-klien/ajax-list-klien",
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

function showuserdetail(id) {
    $('#bodyModalDetail').html(
        "<div class='text-center'><img src='<?php echo e(base_url()); ?>assets/img/ajax/ajax-loader-big.gif'></div>");
    $.ajax({
        type: "post",
        url: "<?php echo e(base_url()); ?>pengguna-klien/detail",
        data: "id=" + id,
        dataType: "text",
        success: function(response) {

            $('.modal-title').text('Detail Klien Berlangganan');
            $('#bodyModalDetail').empty();
            $('#bodyModalDetail').append(response);
        }
    });
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('include_backend/template_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp-7.3.33\htdocs\surveiku_ikk\application\views/auth/list_klien.blade.php ENDPATH**/ ?>