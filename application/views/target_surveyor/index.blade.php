@extends('include_backend/template_backend')

@php
$ci = get_instance();
@endphp

@section('style')

@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card" data-aos="fade-up">
                <div class="card-header bg-secondary font-weight-bold">
                    {{ $title }}
                </div>
                <div class="card-body">

                    <table class="table table-bordered table-hover">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Barang / Jasa</th>
                            <th>Target</th>
                            <th>Perolehan</th>
                            <th>Kekurangan</th>
                        </tr>
                        <?php
                        $no = 1;
                        foreach ($target_surveyor->result() as $row) { ?>
                            <tr>
                                <td class="text-center">{{$no++}}</td>
                                <td>{{$row->nama_sektor}}</td>
                                <td class="text-center"><span class="badge badge-info">{{$row->target}}</span></td>
                                <td class="text-center"><span class="badge badge-success">{{$row->perolehan}}</span></td>
                                <td class="text-center"><span class="badge badge-danger">{{$row->target - $row->perolehan}}</span></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection

@section('javascript')

@endsection