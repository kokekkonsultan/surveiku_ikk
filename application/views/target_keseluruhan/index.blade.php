@extends('include_backend/template_backend')

@php
$ci = get_instance();
@endphp

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">

            <div class="card card-custom bgi-no-repeat gutter-b" style="height: 150px; background-color: #1c2840; background-position: calc(100% + 0.5rem) 100%; background-size: 100% auto; background-image: url(/assets/img/banner/rhone-2.svg)" data-aos="fade-down">
                <div class="card-body d-flex align-items-center">
                    <div>
                        <h3 class="text-white font-weight-bolder line-height-lg mb-5">
                            {{strtoupper($title)}}
                        </h3>
                    </div>
                </div>
            </div>

            <div class="card card-custom card-sticky" data-aos="fade-down" data-aos-delay="300">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table" class="table table-hover table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <td rowspan="2" class="text-center" style="vertical-align: middle;">No</td>
                                    <td rowspan="2" class="text-center" style="vertical-align: middle;">Barang / Jasa</td>
                                    <td rowspan="2" class="text-center" style="vertical-align: middle;">Akumulasi (Persentase)</td>
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
                            <tbody>

                                @php
                                $no = 1;
                                $total_target_online = 0;
                                $total_perolehan_online = 0;
                                $total_target_offline = 0;
                                $total_perolehan_offline = 0;
                                @endphp

                                @foreach ($sektor->result() as $value)
                                @php
                                //ONLINE
                                $total_target_online += $value->total_target_online;
                                $total_perolehan_online += $value->total_perolehan_online;

                                //OFFLINE
                                $total_target_offline += $value->total_target_offline;
                                $total_perolehan_offline += $value->total_perolehan_offline;
                                @endphp

                                <tr>
                                    <td class="text-center">{{$no++}}</td>
                                    <td>{{$value->nama_sektor}}</td>
                                    <td class="text-center">
                                        <span class="badge badge-info">
                                            {{ ROUND((($value->total_perolehan_online + $value->total_perolehan_offline) / ($value->total_target_online + $value->total_target_offline)) * 100,2) }} %
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-secondary">{{$value->total_target_online}}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-success">{{$value->total_perolehan_online}}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-danger">
                                            {{$value->total_target_online - $value->total_perolehan_online < 0 ? 0 : $value->total_target_online - $value->total_perolehan_online}}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-secondary">{{$value->total_target_offline}}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-success">{{$value->total_perolehan_offline}}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-danger">
                                            {{$value->total_target_offline - $value->total_perolehan_offline < 0 ? 0 : $value->total_target_offline - $value->total_perolehan_offline}}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                    <td colspan="2" align="center"><b>TOTAL</b></td>
                                    <td class="text-center">
                                        <span class="badge badge-dark">
                                            {{ ROUND((($total_perolehan_online + $total_perolehan_offline) / ($total_target_online + $total_target_offline)) * 100,2) }} %
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-dark">{{$total_target_online}}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-dark">{{$total_perolehan_online}}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-dark">{{ $total_target_online - $total_perolehan_online }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-dark">{{$total_target_offline}}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-dark">{{$total_perolehan_offline}}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-dark">{{ $total_target_offline - $total_perolehan_offline }}</span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>


                    </div>

                    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection