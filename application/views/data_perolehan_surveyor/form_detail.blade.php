<?php
foreach ($responden->result() as $ps) {
?>
    <div class="example-modal">
        <div id="detail<?php echo $ps->id_responden ?>" class="modal fade" role="dialog" style="display:none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-secondary">
                        <h5 class="font-weight-bold">Detail Responden</b></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="" id="kt_blockui_content">
                            <table id="table" class="table table-hover" cellspacing="0" width="100%">
                                <tr>
                                    <th width="40%">Jenis Barang / Jasa</th>
                                    <td><?php echo $ps->handphone ?></td>
                                </tr>
                                <tr>
                                    <th width="40%">Nama Lengkap</th>
                                    <td><?php echo $ps->nama_lengkap ?></td>
                                </tr>
                                <tr>
                                    <th width="40%">Handphone</th>
                                    <td><?php echo $ps->handphone ?></td>
                                </tr>
                                <tr>
                                    <th width="40%">Jenis Kelamin</th>
                                    <td><?php echo $ps->jenis_kelamin_responden ?></td>
                                </tr>
                                <tr>
                                    <th width="40%">Umur</th>
                                    <td><?php echo $ps->umur_responden ?></td>
                                </tr>
                                <tr>
                                    <th width="40%">Pendidikan Akhir</th>
                                    <td><?php echo $ps->pendidikan_akhir_responden ?></td>
                                </tr>
                                <tr>
                                    <th width="40%">Pekerjaan Utama</th>
                                    <td><?php echo $ps->pekerjaan_utama_responden ?></td>
                                </tr>
                                <tr>
                                    <th width="40%">Pendapatan Per Bulan</th>
                                    <td><?php echo $ps->pendapatan_per_bulan_responden ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>