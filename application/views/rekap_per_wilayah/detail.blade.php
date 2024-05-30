@php
$ci = get_instance();
@endphp
<div class="modal-header bg-secondary text-white">
    <h5 class="modal-title" id="exampleModalLabel">{{$wilayah_survei->nama_wilayah}}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <i aria-hidden="true" class="ki ki-close"></i>
    </button>
</div>
<div class="modal-body">

    <table class="table table-bordered">
        <thead>
            <thead>
                <tr>
                    <td rowspan="2" class="text-center" style="vertical-align: middle;">No</td>
                    <td rowspan="2" class="text-center" style="vertical-align: middle;">Barang / Jasa</td>
                    <td rowspan="2" class="text-center" style="vertical-align: middle;">Akumulasi (Persentase)
                    </td>
                    <td colspan="3" class="text-center">Online</td>
                    <td colspan="3" class="text-center">Offline</td>
                </tr>
                <tr>
                    <th class="text-center">Target</th>
                    <th class="text-center">Perolehan</th>
                    <th class="text-center">Kekurangan</th>
                    <th class="text-center">Target</th>
                    <th class="text-center">Perolehan</th>
                    <th class="text-center">Kekurangan</th>
                </tr>
            </thead>
        </thead>
        <tbody>

            @php
            $no = 1;
            @endphp
            @foreach ($sektor->result() as $row)

            @php
            $target_online[] = $row->target_online;
            $target_offline[] = $row->target_offline;
            $perolehan_online[] = $row->perolehan_online;
            $perolehan_offline[] = $row->perolehan_offline;

            $total_target_online = array_sum($target_online);
            $total_perolehan_online = array_sum($perolehan_online);
            $total_target_offline = array_sum($target_offline);
            $total_perolehan_offline = array_sum($perolehan_offline);
            @endphp

            <tr>
                <td class="text-center">{{$no++}}</td>
                <td>{{$row->nama_sektor}}</td>
                <td class="text-center">
                    <span class="badge badge-info">{{ ROUND(($row->perolehan_online + $row->perolehan_offline)/($row->target_online + $row->target_offline) * 100, 2)}}
                        %</span>
                </td>
                <td class="text-center">
                    <span class="badge badge-secondary">{{$row->target_online}}</span>
                </td>
                <td class="text-center">
                    <span class="badge badge-success">{{$row->perolehan_online}}</span>
                </td>
                <td class="text-center">
                    <span class="badge badge-danger">{{$row->target_online - $row->perolehan_online}}</span>
                </td>
                <td class="text-center">
                    <span class="badge badge-secondary">{{$row->target_offline}}</span>
                </td>
                <td class="text-center">
                    <span class="badge badge-success">{{$row->perolehan_offline}}</span>
                </td>
                <td class="text-center">
                    <span class="badge badge-danger">{{$row->target_offline - $row->perolehan_offline}}</span>
                </td>
            </tr>
            @endforeach

            <tr>
                <td class="text-center" colspan="2"><b>TOTAL</b></td>
                <td class="text-center">
                    <span class="badge badge-dark">{{ ROUND(($total_perolehan_online + $total_perolehan_offline)/($total_target_online + $total_target_offline) * 100, 2)}}
                        %</span>
                </td>
                <td class="text-center">
                    <span class="badge badge-dark">{{$total_target_online}}</span>
                </td>
                <td class="text-center">
                    <span class="badge badge-dark">{{$total_perolehan_online}}</span>
                </td>
                <td class="text-center">
                    <span class="badge badge-dark">{{$total_target_online - $total_perolehan_online}}</span>
                </td>
                <td class="text-center">
                    <span class="badge badge-dark">{{$total_target_offline}}</span>
                </td>
                <td class="text-center">
                    <span class="badge badge-dark">{{$total_perolehan_offline}}</span>
                </td>
                <td class="text-center">
                    <span class="badge badge-dark">{{$total_target_offline - $total_perolehan_offline}}</span>
                </td>
            </tr>
        </tbody>
    </table>
</div>