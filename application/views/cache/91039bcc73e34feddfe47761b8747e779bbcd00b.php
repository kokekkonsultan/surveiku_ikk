<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Divisi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="<?php echo base_url() . $ci->session->userdata('username') . '/add-division' ?>"
                    method="POST">

                    <input name="id_berlangganan" value="<?php echo e($data_langganan->id_berlangganan); ?>" hidden>
                    <input name="uuid_berlangganan" value="<?php echo e($ci->uri->segment(4)); ?>" hidden>

                    <div class="form-group">
                        <label class="form-label font-weight-bold">Nama Divisi <span style="color:red;">*</span></label>
                        <input class="form-control" name="division_name" autofocus required>
                    </div>

                    <div class="text-right">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>


<?php $__currentLoopData = $division->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="edit<?php echo e($row->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title" id="exampleModalLabel">Edit Divisi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="<?php echo base_url() . $ci->session->userdata('username') . '/edit-division' ?>"
                    method="POST">

                    <input name="id" value="<?php echo e($row->id); ?>" hidden>
                    <input name="uuid_berlangganan" value="<?php echo e($ci->uri->segment(4)); ?>" hidden>

                    <div class="form-group">
                        <label class="form-label font-weight-bold">Nama Divisi <span style="color:red;">*</span></label>
                        <input class="form-control" name="division_name" value="<?php echo e($row->division_name); ?>" autofocus
                            required>
                    </div>

                    <div class="text-right">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__currentLoopData = $supervisor->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="detail<?php echo e($value->user_id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title" id="exampleModalLabel">Detail Supervisor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <table id="table" class="table table-hover" cellspacing="0" width="100%">
                    <tr>
                        <th width="40%">Nama Lengkap</th>
                        <td><?php echo $value->first_name ?> <?php echo $value->last_name ?></td>
                    </tr>
                    <tr>
                        <th width="40%">Username</th>
                        <td class="text-primary"><?php echo $value->username ?></td>
                    </tr>
                    <tr>
                        <th width="40%">Email</th>
                        <td><?php echo $value->email ?></td>
                    </tr>
                    <tr>
                        <th width="40%">Telephone</th>
                        <td><?php echo $value->phone ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH C:\xampp-7.3.33\htdocs\surveiku_ikk\application\views/users_management/form_modal_divisi.blade.php ENDPATH**/ ?>