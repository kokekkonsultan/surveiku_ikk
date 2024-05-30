<!---------------------------------------------- MODAL ADD ---------------------------------------->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Dimensi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form
                    action="<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/dimensi/add' ?>"
                    class="form_simpan" method="POST">

                    <div class="form-group">
                        <label class="font-weight-bold">Tahapan Pembelian <span class="text-danger">*</span></label>
                        <?php echo form_dropdown($id_tahapan_pembelian); ?>
                    </div>


                    <input name="kode_dimensi" value="<?php echo $kode_dimensi ?>" hidden>
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
                            <input type="number" class="form-control" placeholder="Masukkan Bobot Dimensi"
                                id="persentase_dimensi" name="persentase_dimensi" required>
                            <div class="input-group-append">
                                <span class="input-group-text font-weight-bold" id="basic-addon2">%</span>
                            </div>
                        </div>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary font-weight-bold tombolSimpan">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\xampp-7.3.33\htdocs\surveiku_ikk\application\views/dimensi_survei/modal_add.blade.php ENDPATH**/ ?>