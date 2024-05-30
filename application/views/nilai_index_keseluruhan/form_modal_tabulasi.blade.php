@php
$ci = get_instance();
@endphp
<div class="modal-header bg-secondary text-white">
    <h5 class="modal-title" id="exampleModalLabel">{{$manage_survey->survey_name}}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <i aria-hidden="true" class="ki ki-close"></i>
    </button>
</div>
<div class="modal-body">

    @if($jumlah_kuesioner_terisi > 0)
    <div class="table-responsive">
        <table class="table table-bordered table-hover" width="100%">
            <thead>
                <tr>
                    <td></td>
                    @foreach ($unsur->result() as $value)
                    <th class="bg-secondary"><?php echo $value->kode_unsur ?></th>
                    @endforeach
                </tr>
            </thead>

            <tbody>
                <tr>
                    <th class="bg-dark text-white" width="40%">Total</th>
                    @foreach ($total_nilai_unsur->result() as $row)
                    <td>{{ROUND($row->total_nilai_unsur,2)}}</td>
                    @endforeach
                </tr>

                <tr>
                    <th class="bg-dark text-white">Rata-Rata Per Unsur</th>
                    @foreach ($rata_rata_per_unsur->result() as $row)
                    <td><?php echo ROUND($row->rata_per_unsur, 3) ?></td>
                    @endforeach
                </tr>
                <tr>
                    <th class="bg-dark text-white">Rata-Rata Per Dimensi</th>
                    @foreach ($rata_rata_per_dimensi->result() as $value)
                    <td class="text-center" colspan="<?php echo $value->jumlah_unsur ?>">
                        <?php echo ROUND($value->rata_per_dimensi, 3) ?>
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <th class="bg-dark text-white">Rata-Rata x Bobot</th>
                    @foreach ($rata_rata_per_unsur_x_bobot->result() as $row)
                    <td><?php echo ROUND($row->persen_per_unsur, 3) ?></td>
                    @endforeach
                </tr>
                <tr>
                    <th class="bg-dark text-white">IKK</th>
                    <td colspan="19" class="font-weight-bold text-info">
                        <?php echo ROUND($ikk, 3) ?>
                    </td>
                </tr>
                <tr>
                    <th class="bg-dark text-white">MUTU</th>

                    <td class="text-info" colspan=19 style="font-weight: bold;">
                        <?php if ($ikk <= 20) {
                            echo 'Sadar';
                        } elseif ($ikk > 20 && $ikk <= 40) {
                            echo 'Paham';
                        } elseif ($ikk > 40 && $ikk <= 60) {
                            echo 'Mampu';
                        } elseif ($ikk > 60 && $ikk <= 80) {
                            echo 'Kritis';
                        } elseif ($ikk > 80) {
                            echo 'Berdaya';
                        } else {
                            NULL;
                        } ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    @else

    <div class="text-danger text-center"><i>Belum ada data responden yang sesuai.</i></div>
    @endif
</div>