

<?php
$ci = get_instance();
?>

<?php $__env->startSection('style'); ?>
<link href="<?php echo e(TEMPLATE_BACKEND_PATH); ?>plugins/custom/datatables/datatables.bundle.css" rel="stylesheet"
    type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <?php echo $__env->make("include_backend/partials_no_aside/_inc_menu_repository", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="row">
        <div class="col-md-3">
            <?php echo $__env->make('manage_survey/menu_data_survey', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-md-9">

            <div class="card card-custom bgi-no-repeat gutter-b"
                style="height: 150px; background-color: #1c2840; background-position: calc(100% + 0.5rem) 100%; background-size: 100% auto; background-image: url(/assets/img/banner/rhone-2.svg)"
                data-aos="fade-down">
                <div class="card-body d-flex align-items-center">
                    <div>
                        <h3 class="text-white font-weight-bolder line-height-lg mb-5">
                            <?php echo e(strtoupper($title)); ?>

                        </h3>
                    </div>
                </div>
            </div>

            <div class="card card-custom card-sticky" data-aos="fade-down" data-aos-delay="300">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table" class="table table-hover table-bordered" cellspacing="0" width="100%">
                            <thead class="bg-secondary">
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Wilayah</th>
                                    <th>Target Online</th>
                                    <th>Target Offline</th>
                                    <th>Total Target</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                    <?php if($manage_survey->is_question == 1): ?>
                    <hr>
                    <div class="text-left mt-5">
                        <a class="btn btn-danger btn-sm"
                            onclick="return confirm('Apakah anda menghapus semua target ?')"
                            href="<?php echo base_url() . $ci->uri->segment(1) . '/' . $ci->uri->segment(2) . '/target-per-wilayah/delete' ?>"><i
                                class="fa fa-eraser"></i> Kosongkan Semua Target
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ======================================= Detail Hasil Analisa ========================================== -->
<div class="modal fade bd-example-modal-xl" id="modal_detail" tabindex="-1" role="dialog"
    aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" id="bodyModalDetail">
            <div align="center" id="loading_registration">
                <img src="<?php echo e(base_url()); ?>assets/site/img/ajax-loader.gif" alt="">
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script src="<?php echo e(TEMPLATE_BACKEND_PATH); ?>plugins/custom/datatables/datatables.bundle.js"></script>
<script>
$(document).ready(function() {
    table = $('#table').DataTable({

        "processing": true,
        "serverSide": true,
        "order": [],
        "language": {
            "processing": '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
        },
        // "lengthMenu": [
        //     [5, 10, 25, 50, 100],
        //     [5, 10, 25, 50, 100]
        // ],
        "pageLength": 10,
        "ajax": {
            "url": "<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/target-per-wilayah/ajax-list' ?>",
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


<?php if($sektor == 0 || $wilayah_survei == 0): ?>
<script>
$(document).ready(function() {
    Swal.fire({
        icon: 'warning',
        title: 'Informasi',
        html: '<div>Halaman ini hanya bisa di kelola jika pengisian pilihan <b>Sektor</b> dan <b>Wilayah Survei</b> di profil responden sudah terisi.<hr><a style="text-decoration:none; color: blue;" href="<?php echo base_url() . $ci->uri->segment(1) . '/' . $ci->uri->segment(2) . '/profil-responden-survei' ?>"><b>Kembali ke Profil Responden</b></a></div>',
        showConfirmButton: false,
        allowOutsideClick: false
    });
});
</script>
<?php endif; ?>

<?php if($manage_survey->is_target != 1): ?>
<script>
$(document).ready(function() {
    Swal.fire({
        icon: 'warning',
        title: 'Informasi',
        html: '<div>Silahkan Konfirmasi <b>Sektor dan Wilayah</b> Survei di menu Profil Responden.<hr><a style="text-decoration:none; color: blue;" href="<?php echo base_url() . $ci->uri->segment(1) . '/' . $ci->uri->segment(2) . '/profil-responden-survei' ?>"><b>Kembali ke Profil Responden</b></a></div>',
        showConfirmButton: false,
        allowOutsideClick: false
    });
});
</script>
<?php endif; ?>

<script>
function showedit(id) {
    $('#bodyModalDetail').html(
        "<div class='text-center'><img src='<?php echo e(base_url()); ?>assets/img/ajax/ajax-loader-big.gif'></div>");

    $.ajax({
        type: "post",
        url: "<?php echo base_url() . $ci->session->userdata('username') . '/' .  $ci->uri->segment(2) . '/target-per-wilayah/detail/' ?>" +
            id,
        // data: "id=" + id,
        dataType: "text",
        success: function(response) {

            // $('.modal-title').text('Edit Pertanyaan Unsur');
            $('#bodyModalDetail').empty();
            $('#bodyModalDetail').append(response);
        }
    });
}
</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('include_backend/template_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp-7.3.33\htdocs\surveiku_ikk\application\views/target_per_wilayah/index.blade.php ENDPATH**/ ?>