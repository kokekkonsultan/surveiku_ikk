<?php
$ci = get_instance();
?>

<div class="card card-custom">
    <div class="card-body">
        <!-- <div class="text-center"> -->
        <table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
            <thead class="bg-secondary">
                <tr>
                    <th>No</th>
                    <th>Nama Survey</th>
                    <th>Nilai IKK</th>
                    <th>Mutu Pelayanan</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <!-- </div> -->
    </div>
</div>

<!-- ======================================= Detail Hasil Analisa ========================================== -->
<div class="modal fade bd-example-modal-xl" id="modal_detail" tabindex="-1" role="dialog"
    aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title" id="exampleModalLabel">Detail Hasil Analisa</h5>
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


<script>
$(document).ready(function() {
    table = $('#table').DataTable({

        "processing": true,
        "serverSide": true,
        "lengthMenu": [
            [10, 15, -1],
            [10, 15, "Semua data"]
        ],
        "pageLength": 10,
        "order": [],
        "language": {
            "processing": '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
        },
        "ajax": {
            "url": "<?php echo base_url() . 'dashboard/ajax-list-tabel-survei-induk' ?>",
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
<?php /**PATH C:\xampp-7.3.33\htdocs\surveiku_ikk\application\views/dashboard/tabel_survei_induk.blade.php ENDPATH**/ ?>