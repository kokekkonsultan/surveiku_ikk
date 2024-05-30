@extends('include_backend/template_backend')

@php
$ci = get_instance();
@endphp

@section('style')

@endsection

@section('content')

<div class="container">
    <div class="card">
        <div class="card-header font-weight-bold">
            Penyimpanan data kedalam format pdf dengan data lebih dari {{ $per_page }} record akan di pecah menjadi
            beberapa bagian.
        </div>
        <div class="card-body">


            <table class="table table-hover">

                @php

                // cek jika jumlah data lebih dari nilai Properti per_page

                if ($jumlah_data > $per_page) {

                $sisa_hasil_bagi = $jumlah_data % $per_page;

                $jumlah_bagi = ($jumlah_data - $sisa_hasil_bagi) / $per_page;

                $no = 1;
                $no_awal = 0;
                $no_pembagi = $per_page;
                for ($i = 0; $i < $jumlah_bagi; $i++) { 
                  $arr=[]; for ($j=$no_awal; $j < $no_pembagi; $j++) { array_push( $arr, $j ); } $gabung=implode(",",$arr);

        $arr_first = reset($arr) + 1;
        $arr_last = $arr[count($arr)-1] + 1;

        echo '<tr><td>'.$no++.') Download record kuesioner ('.$arr_first.' - '.$arr_last.' record)<td><td>';

        echo form_open(base_url().$ci->session->userdata('username').'/'.$ci->uri->segment(2).'/rekap-saran/create-pdf', ['target' => '_blank']);

        echo form_hidden('arr', $gabung);

        echo form_submit('submit', 'Create Pdf').'</td></tr>';

        echo form_close();


        $no_awal += $per_page;
        $no_pembagi += $per_page;

      }

      if ($sisa_hasil_bagi != 0) {

        $arr = [];
        for ($j = $no_awal; $j < $jumlah_data; $j++) {
          array_push( $arr, $j );
        }
        
        $gabung = implode(",",$arr);

        $arr_first = reset($arr) + 1;
        $arr_last = $arr[count($arr)-1] + 1;

        echo '<tr><td>'.$no++.') Download record kuesioner ('.$arr_first.' - '.$arr_last.' record)<td><td>';

        echo form_open(base_url().$ci->session->userdata('username').'/'.$ci->uri->segment(2).'/rekap-saran/create-pdf', ['target' => '_blank']);

        echo form_hidden('arr', $gabung);

        echo form_submit('submit', 'Create Pdf').'</td></tr>';

        echo form_close();

      }

    } else {

      echo '<tr><td>'." 1) Download record kuesioner (".$jumlah_data." Record)<td>
                    <td>";

                        // create array
                        $arr = [];
                        for ($j = 0; $j < $jumlah_data; $j++) { array_push( $arr, $j ); } $gabung=implode(",",$arr);

      echo form_open(base_url().$ci->session->userdata('username').'/'.$ci->uri->segment(2).'/rekap-saran/create-pdf', ['target' => '_blank']);

      echo form_hidden('arr', $gabung);

      echo form_submit('submit', 'Create Pdf').'</td></tr>';

      echo form_close();
    }

    @endphp

    </table>

    	</div>
	</div>

</div>

@endsection

@section('javascript')

@endsection