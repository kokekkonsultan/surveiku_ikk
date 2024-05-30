@extends('include_backend/template_backend')

@php
$ci = get_instance();
@endphp

@section('style')
<link href="{{ TEMPLATE_BACKEND_PATH }}plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class=" container-fluid">

    <div class="card card-custom bgi-no-repeat gutter-b aos-init aos-animate" style="height: 150px; background-color: #1c2840; background-position: calc(100% + 0.5rem) 100%; background-size: 100% auto; background-image: url(/assets/img/banner/rhone-2.svg)" data-aos="fade-down">
        <div class="card-body d-flex align-items-center">
            <div>
                <h3 class="text-white font-weight-bolder line-height-lg mb-5">
                    TABULASI & OLAH DATA
                    <br>
                    KESELURUHAN
                </h3>
            </div>
        </div>
    </div>



    <div class="card shadow aos-init aos-animate" data-aos="fade-up">
        <div class="card-body">

            @if($cek_survey->num_rows() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%">
                    <thead>
                        <tr>
                            <td></td>
                            @foreach ($total_nilai_unsur->result() as $value)
                            <th class="bg-secondary">U{{$value->id_pertanyaan_unsur}}</th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <th class="bg-dark text-white" width="40%">Total</th>
                            @foreach ($total_nilai_unsur->result() as $row)
                            <td>{{ROUND($row->total_nilai)}}</td>
                            @endforeach
                        </tr>

                        <tr>
                            <th class="bg-dark text-white">Rata-Rata</th>
                            @foreach ($total_nilai_unsur->result() as $row)
                            <td>{{ROUND($row->rata_nilai,2)}}</td>
                            @endforeach

                        </tr>

                        <tr>
                            <th class="bg-dark text-white">Nilai Per Unsur</th>
                            @foreach ($total_nilai_unsur->result() as $row)
                            <td>{{ROUND($row->rata_nilai * 20,2)}}</td>
                            @endforeach

                        </tr>

                        <tr>
                            <th class="bg-dark text-white">Nilai Per Dimensi</th>
                            @foreach ($total_nilai_dimensi->result() as $value)
                            <td class="text-center" colspan="{{$value->jumlah_dimensi_per_pertanyaan}}">
                                {{ROUND($value->rata_nilai * 20,3)}}
                            </td>
                            @endforeach
                        </tr>

                        <tr>
                            <th class="bg-dark text-white">Rata-Rata x Bobot</th>
                            @foreach ($total_nilai_unsur->result() as $row)
                            @php
                            $total[] = $row->persen_per_unsur * 20;
                            $ikk = array_sum($total);
                            @endphp
                            <td>{{ROUND($row->persen_per_unsur * 20, 3)}}</td>
                            @endforeach
                        </tr>

                        <tr>
                            <th class="bg-dark text-white">IKK</th>
                            <td colspan="19" class="font-weight-bold text-info">
                                {{ROUND($ikk, 3)}}
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
    </div>
</div>


@endsection

@section('javascript')

@endsection