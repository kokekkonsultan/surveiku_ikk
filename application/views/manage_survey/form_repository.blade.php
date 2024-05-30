@extends('include_backend/template_backend')

@php
$ci = get_instance();
@endphp

@section('style')

@endsection

@section('content')

<div class="container-fluid">
    @include("include_backend/partials_no_aside/_inc_menu_repository")



    <div class="row mt-5">
        <div class="col-md-3">
            @include('manage_survey/menu_data_survey')
        </div>
        <div class="col-md-9">


            @if($manage_survey->organisasi == '' || $manage_survey->description == '' || $manage_survey->alamat == '' ||
            $manage_survey->no_tlpn == '' || $manage_survey->email == '' || $manage_survey->jumlah_populasi == '')
            <div class="alert alert-custom alert-notice alert-light-dark fade show" role="alert">
                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                <div class="alert-text">Silahkan lengkapi data terkait survei yang
                    dibuat, guna untuk memudahkan dalam pengambilan data hasil survei!</div>
                <div class="alert-close">
                </div>
            </div>
            @endif


            <div class="card card-custom bgi-no-repeat gutter-b" style="height: 150px; background-color: #1c2840; background-position: calc(100% + 0.5rem) 100%; background-size: 100% auto; background-image: url(/assets/img/banner/rhone-2.svg)" data-aos="fade-down">
                <div class="card-body d-flex align-items-center">
                    <div>
                        <h3 class="text-white font-weight-bolder line-height-lg mb-5">
                            {{strtoupper($title)}}
                        </h3>

                        <!-- HANYA KLIEN YANG BISA MENGEDIT -->
                        @if($profiles->group_id == 2)

                        @if($manage_survey->organisasi == '' || $manage_survey->description == '' ||
                        $manage_survey->alamat == '' || $manage_survey->no_tlpn == '' || $manage_survey->email == '' ||
                        $manage_survey->jumlah_populasi == '')
                        <button type="button" class="btn btn-secondary btn-sm font-weight-bold shadow" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-edit"></i> Lengkapi
                            Data Survei</button>

                        @else

                        <button type="button" class="btn btn-secondary btn-sm font-weight-bold shadow" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-edit"></i> Edit
                            Detail Survei</button>

                        @endif

                        @endif

                    </div>
                </div>
            </div>

            <div class="card card-custom gutter-b">
                <div class="card-body">

                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <div class="align-items-center justify-content-between">

                                <div class="d-flex align-items-center">
                                    <span class="bullet bullet-bar bg-success align-self-stretch"></span>
                                    <label class="checkbox checkbox-lg checkbox-light-success checkbox-inline flex-shrink-0 m-0 mx-4">
                                        <input type="checkbox" name="select" value="1" disabled>
                                        <span></span>
                                    </label>
                                    <div class="d-flex flex-column flex-grow-1">
                                        <div class="text-dark text-hover-success font-size-h5 font-weight-bold mb-1">
                                            {{ $profiles->survey_name }}
                                        </div>
                                        <span class="text-muted font-weight-bold">
                                            <?php if ($manage_survey->organisasi != '') {
                                                echo $manage_survey->organisasi;
                                            } else {
                                                echo 'BELUM DIISI !';
                                            } ?>
                                        </span>
                                    </div>
                                </div>

                                <hr>

                                <div class="d-flex my-2">
                                    <a href="#" class="text-muted text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                        <span class="svg-icon svg-icon-md svg-icon-gray-500 mr-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                    <path d="M21,12.0829584 C20.6747915,12.0283988 20.3407122,12 20,12 C16.6862915,12 14,14.6862915 14,18 C14,18.3407122 14.0283988,18.6747915 14.0829584,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,12.0829584 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z" fill="#000000"></path>
                                                    <circle fill="#000000" opacity="0.3" cx="19.5" cy="17.5" r="2.5">
                                                    </circle>
                                                </g>
                                            </svg>
                                        </span>
                                        <?php if ($manage_survey->email != '') {
                                            echo $manage_survey->email;
                                        } else {
                                            echo 'BELUM DIISI !';
                                        } ?>
                                    </a>

                                    <a href="#" class="text-muted text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                        <span class="svg-icon svg-icon-md svg-icon-gray-500 mr-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 24 19">
                                                <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                                            </svg>
                                        </span>
                                        <?php if ($manage_survey->no_tlpn != '') {
                                            echo $manage_survey->no_tlpn;
                                        } else {
                                            echo 'BELUM DIISI !';
                                        } ?>
                                    </a>


                                    <a href="#" class="text-muted text-hover-primary font-weight-bold">
                                        <span class="svg-icon svg-icon-md svg-icon-gray-500 mr-1">

                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                    <path d="M9.82829464,16.6565893 C7.02541569,15.7427556 5,13.1079084 5,10 C5,6.13400675 8.13400675,3 12,3 C15.8659932,3 19,6.13400675 19,10 C19,13.1079084 16.9745843,15.7427556 14.1717054,16.6565893 L12,21 L9.82829464,16.6565893 Z M12,12 C13.1045695,12 14,11.1045695 14,10 C14,8.8954305 13.1045695,8 12,8 C10.8954305,8 10,8.8954305 10,10 C10,11.1045695 10.8954305,12 12,12 Z" fill="#000000"></path>
                                                </g>
                                            </svg>
                                        </span>
                                        <?php if ($manage_survey->alamat != '') {
                                            echo $manage_survey->alamat;
                                        } else {
                                            echo 'BELUM DIISI !';
                                        } ?>
                                    </a>
                                </div>
                            </div>

                            <div class="d-flex align-items-center flex-wrap justify-content-between">
                                <div class="flex-grow-1 font-weight-bold text-dark-50 py-5 py-lg-2 mr-5">
                                    <?php if ($manage_survey->description != '') {
                                        echo $manage_survey->description;
                                    } else {
                                        echo 'BELUM DIISI !';
                                    } ?>
                                </div>
                            </div>



                            <div class="d-flex align-items-center flex-wrap justify-content-between">
                                <div class="d-flex flex-wrap align-items-center py-2">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-6">
                                            <div class="font-weight-bold mb-2">Survei Dimulai</div>
                                            <span class="btn btn-sm btn-text btn-light-primary text-uppercase font-weight-bold">{{ date("d M Y", strtotime($profiles->survey_start)) }}</span>
                                        </div>
                                        <div class="mr-6">
                                            <div class="font-weight-bold mb-2">Survei Berakhir</div>
                                            <span class="btn btn-sm btn-text btn-light-danger text-uppercase font-weight-bold">{{ date("d M Y", strtotime($profiles->survey_end)) }}</span>
                                        </div>

                                        <div class="mr-6">
                                            <div class="font-weight-bold mb-2">Klasifikasi Survei</div>
                                            <span class="btn btn-sm btn-text btn-light-info text-uppercase font-weight-bold">{{ $profiles->nama_klasifikasi_survey }}</span>
                                        </div>

                                        <div class="mr-6">
                                            <div class="font-weight-bold mb-2">Kelompok Skala</div>
                                            <span class="btn btn-sm btn-text btn-light-success text-uppercase font-weight-bold">{{ $manage_survey->nama_kelompok_skala }}</span>
                                        </div>

                                        <div class="mr-6">
                                            <div class="font-weight-bold mb-2">Wilayah Survei</div>
                                            <span class="btn btn-sm btn-text btn-light text-uppercase font-weight-bold">{{ $wilayah_survei }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="separator separator-solid my-7"></div>

                    <div class="d-flex align-items-center">
                        <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                            <span class="mr-4">
                                <i class="flaticon-network icon-2x text-muted font-weight-bold"></i>
                            </span>
                            <div class="d-flex flex-column text-dark-75">
                                <span class="font-weight-bolder font-size-sm">Metode Sampling</span>
                                <span class="text-primary font-weight-bolder font-size-h5">
                                    <span class="text-dark-50 font-weight-bold"></span>{{ $profiles->nama_sampling }}</span>
                            </div>
                        </div>



                        <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                            <span class="mr-4">
                                <i class="flaticon-file-2 icon-2x text-muted font-weight-bold"></i>
                            </span>
                            <div class="d-flex flex-column text-dark-75">
                                <span class="font-weight-bolder font-size-sm">Jumlah Populasi Yang Diambil</span>
                                <span class="text-primary font-weight-bolder font-size-h5">
                                    <span class="text-dark-50 font-weight-bold"></span>{{ $profiles->jumlah_populasi }}</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                            <span class="mr-4">
                                <i class="flaticon-file-2 icon-2x text-muted font-weight-bold"></i>
                            </span>
                            <div class="d-flex flex-column text-dark-75">
                                <span class="font-weight-bolder font-size-sm">Sample Minimal Wajib Diperoleh</span>
                                <span class="text-primary font-weight-bolder font-size-h5">
                                    <span class="text-dark-50 font-weight-bold"></span>{{ $profiles->jumlah_sampling }}</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                            <span class="mr-4">
                                <i class="flaticon-file-2 icon-2x text-muted font-weight-bold"></i>
                            </span>
                            <div class="d-flex flex-column flex-lg-fill">
                                <span class="text-dark-75 font-weight-bolder font-size-sm">Sample Yang Sudah
                                    Diperoleh</span>
                                <span class="text-primary font-weight-bolder font-size-h5">
                                    <span class="text-dark-50 font-weight-bold"></span>{{ $jumlah_kuisioner }}</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                            <span class="mr-4">
                                <i class="flaticon-file-2 icon-2x text-muted font-weight-bold"></i>
                            </span>
                            <div class="d-flex flex-column">
                                <span class="text-dark-75 font-weight-bolder font-size-sm">Sample Yang Belum
                                    Diperoleh</span>
                                <span class="text-primary font-weight-bolder font-size-h5">
                                    <span class="font-weight-bolder"></span>{{ $sampling_belum }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @php
            $di_data_responden = $ci->db->get_where("survey_$manage_survey->table_identity", ['is_end' => '* Berakhir di Data Responden', 'id_surveyor' => 0])->num_rows();
            $di_pertanyaan = $ci->db->get_where("survey_$manage_survey->table_identity", ['is_end' => '* Berakhir di Pertanyaan Unsur', 'id_surveyor' => 0])->num_rows();
            $di_saran = $ci->db->get_where("survey_$manage_survey->table_identity", ['is_end' => '* Berakhir di Pengisian Saran', 'id_surveyor' => 0])->num_rows();
            $finish = $ci->db->get_where("survey_$manage_survey->table_identity", ['is_end' => '* Finish', 'id_surveyor' => 0])->num_rows();

            //$tidak_mengisi = $ci->db->get("statistik_survei_$manage_survey->table_identity")->num_rows();
            @endphp


            <div class="card card-custom card-body bg-light-info border border-info shadow mb-5">
                <h6 class="text-info">Statistik Pengisian Survei Online</h6>
                <hr>
                <div class="d-flex align-items-center">

                    <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                        <span class="mr-4">
                            <i class="flaticon-circle icon-2x text-muted font-weight-bold"></i>
                        </span>
                        <div class="d-flex flex-column">
                            <span class="text-dark-75 font-weight-bolder font-size-sm">Hanya Melihat Link Survei</span>
                            <span class="text-info font-weight-bolder font-size-h5">
                                <span class="font-weight-bolder">
                                    {{$manage_survey->view_visitor - ($di_data_responden + $di_pertanyaan + $di_saran + $finish)}}
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                        <span class="mr-4">
                            <i class="flaticon2-user-outline-symbol icon-2x text-muted font-weight-bold"></i>
                        </span>
                        <div class="d-flex flex-column">
                            <span class="text-dark-75 font-weight-bolder font-size-sm">Berhenti di Data Responden</span>
                            <span class="text-info font-weight-bolder font-size-h5">
                                <span class="font-weight-bolder">{{$di_data_responden}}</span></span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                        <span class="mr-4">
                            <i class="flaticon2-writing icon-2x text-muted font-weight-bold"></i>
                        </span>
                        <div class="d-flex flex-column">
                            <span class="text-dark-75 font-weight-bolder font-size-sm">Berhenti di Pertanyaan
                                Unsur</span>
                            <span class="text-info font-weight-bolder font-size-h5">
                                <span class="font-weight-bolder">{{$di_pertanyaan}}</span></span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                        <span class="mr-4">
                            <i class="flaticon2-rectangular icon-2x text-muted font-weight-bold"></i>
                        </span>
                        <div class="d-flex flex-column">
                            <span class="text-dark-75 font-weight-bolder font-size-sm">Berhenti di Saran</span>
                            <span class="text-info font-weight-bolder font-size-h5">
                                <span class="font-weight-bolder">{{$di_saran}}</span></span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                        <span class="mr-4">
                            <i class="flaticon2-accept icon-2x text-muted font-weight-bold"></i>
                        </span>
                        <div class="d-flex flex-column">
                            <span class="text-dark-75 font-weight-bolder font-size-sm">Finish</span>
                            <span class="text-info font-weight-bolder font-size-h5">
                                <span class="font-weight-bolder">{{$finish}}</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- ==============================================MODAL EDIT======================================================= -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-content">
                <div class="modal-header bg-secondary">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Deskripsi Survei</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo base_url() . $ci->uri->segment(1) . '/' . $ci->uri->segment(2) . '/update-repository' ?>" class="form_pembuka">

                        <small class="text-danger"><?php echo validation_errors(); ?></small>

                        <div class="form-group row">
                            <label for="recipient-name" class="col-sm-2 col-form-label font-weight-bold">Nama
                                Survei <span style="color:red;">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nama_survei" value="<?php echo $manage_survey->survey_name ?>" autofocus required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="recipient-name" class="col-sm-2 col-form-label font-weight-bold">Organisasi
                                Yang
                                di Survei <span style="color:red;">*</span></label>
                            <div class="col-sm-10">
                                <!-- <textarea id="kt-tinymce-1" name="organisasi" class="tox-target">
                                {{ $manage_survey->organisasi }}
                                </textarea> -->

                                <textarea class="form-control" name="organisasi" value="" required><?php echo $manage_survey->organisasi ?></textarea>
                                <small>Tuliskan secara lengkap organisasi anda, karena digunakan apabila anda akan
                                    mencetak sertifikat dan laporan.</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="recipient-name" class="col-sm-2 col-form-label font-weight-bold">Deskripsi <span style="color:red;">*</span></label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="deskripsi" value="" required><?php echo $manage_survey->description ?></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="recipient-name" class="col-sm-2 col-form-label font-weight-bold">Alamat <span style="color:red;">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="alamat" value="<?php echo $manage_survey->alamat ?>" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="recipient-name" class="col-sm-2 col-form-label font-weight-bold">Email <span style="color:red;">*</span></label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" name="email" value="<?php echo $manage_survey->email ?>" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="recipient-name" class="col-sm-2 col-form-label font-weight-bold">Phone <span style="color:red;">*</span></label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="nomor" value="<?php echo $manage_survey->no_tlpn ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-2 col-form-label font-weight-bold">Metode Sampling <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                @php
                                echo form_dropdown($id_sampling);
                                @endphp

                                <!-- <p class=""><a data-toggle="modal" data-target="#myModal" href="#exampleModal">Hitung
                                        Sampling Disini</a></p> -->
                            </div>
                        </div>


                        <div class="form-group row" class="krejcie" id="krejcie" <?php echo $manage_survey->id_sampling == 1 ? '' : 'hidden' ?>>
                            <div class="col-sm-2"></div>
                            <div class="col-sm-5">
                                <label class="col-form-label font-weight-bold">Jumlah Populasi <span class="text-danger">*</span></label>
                                <input type="text" id="populasi_krejcie" name="populasi_krejcie" class="form-control" placeholder="10000" value="{{$manage_survey->id_sampling == 1 ? $manage_survey->jumlah_populasi : '' }}">
                            </div>
                            <div class="col-sm-5">
                                <label class="col-form-label font-weight-bold">Jumlah Minimal Sampling
                                    <span class="text-danger">*</span></label>
                                <input type="text" id="total_krejcie" name="total_krejcie" class="form-control" placeholder="370" style="background-color: #F3F6F9;" value="{{$manage_survey->id_sampling == 1 ? $manage_survey->jumlah_sampling : '' }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row" class="slovin" id="slovin" <?php echo $manage_survey->id_sampling == 2 ? '' : 'hidden' ?>>
                            <div class="col-sm-2"></div>
                            <div class="col-sm-5">
                                <label class="col-form-label font-weight-bold">Jumlah Populasi <span class="text-danger">*</span></label>
                                <input type="text" id="populasi_slovin" name="populasi_slovin" class="form-control" placeholder="10000" value="{{$manage_survey->id_sampling == 2 ? $manage_survey->jumlah_populasi : '' }}">
                            </div>
                            <div class=" col-sm-5">
                                <label class="col-form-label font-weight-bold">Jumlah Minimal Sampling <span class="text-danger">*</span></label>
                                <input type="text" id="total_slovin" name="total_slovin" class="form-control" placeholder="385" style="background-color: #F3F6F9;" value="{{$manage_survey->id_sampling == 2 ? $manage_survey->jumlah_sampling : '' }}" readonly>
                            </div>
                        </div>

                        <br>


                        <div class="text-right">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary font-weight-bold tombolSimpanPembuka">Update
                                Deskripsi</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
</div>

<!-- SAMPLING -->
<!-- <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Metode Sampling</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                            aria-controls="home" aria-selected="true">Krejcie</a>
                    </li>
                    {{-- <li class="nav-item" role="presentation">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                            aria-controls="profile" aria-selected="false">Cochran</a>
                    </li> --}}
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                            aria-controls="contact" aria-selected="false">Slovin</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                        <br>
                        <h5>Isikan nilai hanya pada bidang berwarna kuning</h5>
                        <br>
                        <form id="formJsKrejcie" name="formJsKrejcie" action="" method="post"
                            enctype="multipart/form-data">
                            <label class="font-weight-bold" style="display:none">lambda:</label>
                            <input type="text" name="lambda" onkeyup="OnChange(this.value)"
                                onKeyPress="return isNumberKey(event)" value="3.841" class="form-control"
                                style="display:none"><br>

                            <label class="font-weight-bold">Masukkan Jumlah Populasi (N:)</label>
                            <input type="number" name="populasi" id="populasi_krejcie" onkeyup="OnChange(this.value)"
                                onKeyPress="return isNumberKey(event)" class="form-control"
                                style="background-color: yellow;"><br>

                            <label class="font-weight-bold" style="display:none">P=Q:</label>
                            <input type="text" name="populasi_menyebar" onkeyup="OnChange(this.value)"
                                onKeyPress="return isNumberKey(event)" value="0.5" class="form-control"
                                style="display:none"><br>

                            <label class="font-weight-bold" style="display:none">d:</label>
                            <input type="text" name="val_d" onkeyup="OnChange(this.value)"
                                onKeyPress="return isNumberKey(event)" value="0.05" class="form-control"
                                style="display:none"><br>

                            <label class="font-weight-bold">Jumlah Minimal Sampling (S:)</label>
                            <input type="text" name="txtDisplay" value="" class="form-control" readonly="readonly"
                                style="background-color: black; color: #FFFFFF;">
                        </form>

                        <br><br>
                        <div class="text-right">
                            <button type="button" class="btn btn-light-primary font-weight-bold shadow-lg"
                                data-dismiss="modal">Batal</button>
                            <button type="" onclick="copytextbox_krejcie()"
                                class="btn btn-primary font-weight-bold shadow-lg">Gunakan</button>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                        <br>
                        <h5>Isikan nilai hanya pada bidang berwarna kuning</h5>
                        <br>
                        <form id="formJsCochran" name="formJsCochran" action="" method="post"
                            enctype="multipart/form-data">
                            <label class="font-weight-bold">Z:</label>
                            <input type="text" name="val_z" onkeyup="OnChangeC(this.value)"
                                onKeyPress="return isNumberKey(event)" value="1.96" class="form-control">

                            <label class="font-weight-bold">p:</label>
                            <input type="text" name="val_p" onkeyup="OnChangeC(this.value)"
                                onKeyPress="return isNumberKey(event)" value="0.5" class="form-control">

                            <label class="font-weight-bold">q:</label>
                            <input type="text" name="val_q" onkeyup="OnChangeC(this.value)"
                                onKeyPress="return isNumberKey(event)" value="0.5" class="form-control">

                            <label class="font-weight-bold">d:</label>
                            <input type="text" name="val_d" onkeyup="OnChangeC(this.value)"
                                onKeyPress="return isNumberKey(event)" class="form-control"
                                style="background-color: yellow;">

                            <label class="font-weight-bold">n:</label>
                            <input type="text" name="txtDisplay" value="" class="form-control" readonly="readonly"
                                style="background-color: black; color: #FFFFFF;">
                        </form>



                    </div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">

                        <br>
                        <h5>Isikan nilai hanya pada bidang berwarna kuning</h5>
                        <br>
                        <form id="formJsSlovin" name="formJsSlovin" action="" method="post"
                            enctype="multipart/form-data">
                            <br>
                            <label class="font-weight-bold">Masukkan Jumlah Populasi (N:)</label>
                            <input type="number" name="val_n" id="val_n" onkeyup="OnChangeS(this.value)"
                                onKeyPress="return isNumberKey(event)" class="form-control"
                                style="background-color: yellow;">

                            <label class="font-weight-bold" style="display:none">e:</label>
                            <input type="text" name="val_e" onkeyup="OnChangeS(this.value)"
                                onKeyPress="return isNumberKey(event)" value="0.05" class="form-control"
                                style="display:none">
                            <br><br>
                            <label class="font-weight-bold">Jumlah Minimal Sampling (n:)</label>
                            <input type="text" name="txtDisplay" value="" class="form-control" readonly="readonly"
                                style="background-color: black; color: #FFFFFF;">
                        </form>

                        <br><br>
                        <div class="text-right">
                            <button type="button" class="btn btn-light-primary font-weight-bold"
                                data-dismiss="modal">Batal</button>
                            <button type="" onclick="copytextbox_slovin()"
                                class="btn btn-primary font-weight-bold">Gunakan</button>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>
</div> -->


@endsection

@section('javascript')
<script src="{{ base_url() }}assets/themes/metronic/assets/plugins/custom/tinymce/tinymce.bundle.js"></script>
<script src="{{ base_url() }}assets/themes/metronic/assets/js/pages/crud/forms/editors/tinymce.js"></script>


<script type="text/javascript">
    $(function() {
        $("#id_sampling").change(function() {
            console.log($("#id_sampling option:selected").val());
            // $("#krejcie").hide();
            if ($("#id_sampling option:selected").val() == 1) {
                $('#krejcie').prop('hidden', false);
                $('#slovin').prop('hidden', true);
            } else if ($("#id_sampling option:selected").val() == 2) {
                $('#krejcie').prop('hidden', true);
                $('#slovin').prop('hidden', false);
            } else {
                $('#krejcie').prop('hidden', true);
                $('#slovin').prop('hidden', true);
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#populasi_krejcie").keyup(function() {
            var populasi_krejcie = $("#populasi_krejcie").val();
            var total_krejcie = (3.841 * parseInt(populasi_krejcie) * 0.5 * 0.5) / ((0.05 * 0.05) * (
                parseInt(populasi_krejcie) - 1) + (3.841 * 0.5 * 0.5));
            $("#total_krejcie").val(Math.ceil(total_krejcie));
        });

        $("#populasi_slovin").keyup(function() {
            var populasi_slovin = $("#populasi_slovin").val();
            var total_slovin = parseInt(populasi_slovin) / (1 + parseInt(populasi_slovin) * (0.05 * 0.05));
            $("#total_slovin").val(Math.ceil(total_slovin));
        });
    });
</script>

<!-- <script>
function copytextbox_krejcie() {
    document.getElementById('id_sampling').value = 1;
    document.getElementById('jumlah_populasi').value = document.getElementById('populasi_krejcie').value;
    $('#myModal').modal('hide');
}

function copytextbox_slovin() {
    document.getElementById('id_sampling').value = 3;
    document.getElementById('jumlah_populasi').value = document.getElementById('val_n').value;
    $('#myModal').modal('hide');
}
</script>

<script>
dim_lambda = document.formJsKrejcie.lambda.value;
document.formJsKrejcie.txtDisplay.value = dim_lambda;

dim_populasi = document.formJsKrejcie.populasi.value;
document.formJsKrejcie.txtDisplay.value = dim_populasi;

function OnChange(value) {
    dim_lambda = document.formJsKrejcie.lambda.value;
    dim_populasi = document.formJsKrejcie.populasi.value;
    dim_populasi_menyebar = document.formJsKrejcie.populasi_menyebar.value;
    dim_val_d = document.formJsKrejcie.val_d.value;

    total = (dim_lambda * dim_populasi * dim_populasi_menyebar * dim_populasi_menyebar) / ((dim_val_d * dim_val_d) * (
        dim_populasi - 1) + (dim_lambda * dim_populasi_menyebar * dim_populasi_menyebar));

    document.formJsKrejcie.txtDisplay.value = Math.ceil(total);
}
</script>

<script>
dim_d = document.formJsCochran.val_d.value;
document.formJsCochran.txtDisplay.value = dim_d;

function OnChangeC(value) {
    dim_val_z = document.formJsCochran.val_z.value;
    dim_val_p = document.formJsCochran.val_p.value;
    dim_val_q = document.formJsCochran.val_q.value;
    dim_val_d = document.formJsCochran.val_d.value;

    total = (((dim_val_z * dim_val_z) * dim_val_p * dim_val_q) / (dim_val_d * dim_val_d));

    document.formJsCochran.txtDisplay.value = Math.ceil(total);
}
</script>

<script>
dim_n = document.formJsSlovin.val_n.value;
document.formJsSlovin.txtDisplay.value = dim_n;

function OnChangeS(value) {
    dim_val_n = document.formJsSlovin.val_n.value;
    dim_val_e = document.formJsSlovin.val_e.value;

    total = dim_val_n / (1 + dim_val_n * (dim_val_e * dim_val_e));

    document.formJsSlovin.txtDisplay.value = Math.ceil(total);
}
</script> -->

<script>
    // Class definition

    var KTTinymce = function() {
        // Private functions
        var demos = function() {
            tinymce.init({
                selector: '#kt-tinymce-1',
                toolbar: false,
                statusbar: false
            });
        }
        return {
            // public functions
            init: function() {
                demos();
            }
        };
    }();

    // Initialization
    jQuery(document).ready(function() {
        KTTinymce.init();
    });
</script>


<script>
    $('.form_pembuka').submit(function(e) {

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            cache: false,
            beforeSend: function() {
                $('.tombolSimpanPembuka').attr('disabled', 'disabled');
                $('.tombolSimpanPembuka').html('<i class="fa fa-spin fa-spinner"></i> Sedang diproses');

                KTApp.block('#content_1', {
                    overlayColor: '#000000',
                    state: 'primary',
                    message: 'Processing...'
                });

                setTimeout(function() {
                    KTApp.unblock('#content_1');
                }, 1000);

            },
            complete: function() {
                $('.tombolSimpanPembuka').removeAttr('disabled');
                $('.tombolSimpanPembuka').html('Update Deskripsi');
            },
            error: function(e) {
                Swal.fire(
                    'Error !',
                    e,
                    'error'
                )
            },
            success: function(data) {
                if (data.validasi) {
                    $('.pesan').fadeIn();
                    $('.pesan').html(data.validasi);
                }
                if (data.sukses) {
                    toastr["success"]('Data berhasil disimpan');
                    window.setTimeout(function() {
                        location.reload()
                    }, 2000);
                }
            }
        })
        return false;
    });
</script>

@if($profiles->group_id == 2)
@if($manage_survey->organisasi == '' || $manage_survey->description == '' ||
$manage_survey->alamat == '' || $manage_survey->no_tlpn == '' || $manage_survey->email == '' ||
$manage_survey->jumlah_populasi == '')
<script type="text/javascript">
    $(document).ready(function() {
        Swal.fire({
            icon: 'info',
            title: 'Informasi',
            text: 'Silahkan Lengkapi Data Survei Anda !',
            confirmButtonColor: '#8950FC',
            confirmButtonText: 'Baik, saya mengerti',
        })
    });
</script>
@endif
@endif

@endsection