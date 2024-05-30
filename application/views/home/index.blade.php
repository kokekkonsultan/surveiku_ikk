@extends('include_frontend/template_frontend')

@php
$ci = get_instance();
@endphp

@section('style')

@endsection

@section('content')

<section class="py-0">
  <div class="swiper theme-slider min-vh-100" data-swiper='{"loop":true,"allowTouchMove":false,"autoplay":{"delay":5000},"effect":"fade","speed":800}'>
    <div class="swiper-wrapper">
      <div class="swiper-slide" data-zanim-timeline="{}">
        <div class="bg-holder" style="background-image:url({{ base_url() }}assets/themes/elixir/v3.0.0/assets/img/header-7.jpg);"></div>
        <!--/.bg-holder-->
        <div class="container">
          <div class="row min-vh-100 py-8 align-items-center" data-inertia='{"weight":1.5}'>
            <div class="col-sm-8 col-lg-7 px-5 px-sm-3">
              <div class="overflow-hidden">
                <h1 class="fs-4 fs-md-5 lh-1" data-zanim-xs='{"delay":0}'>E-IKK</h1>
              </div>
              <div class="overflow-hidden">
                <p class="text-primary pt-4 mb-5 fs-1 fs-md-2 lh-xs" data-zanim-xs='{"delay":0.1}'>Indikator untuk mengukur keberhasikan pelaksanaan perlindungan konsumen dapat dilihat dari tingkat keberdayaan konsumen.</p>
              </div>
              <div class="overflow-hidden">
                <div data-zanim-xs='{"delay":0.2}'><a class="btn btn-primary me-3 mt-3" href="{{ base_url() }}about">Baca selengkapnya<span class="fas fa-chevron-right ms-2"></span></a><a class="btn btn-warning mt-3" href="{{ base_url() }}contact">Kontak Kami<span class="fas fa-chevron-right ms-2"></span></a></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="swiper-slide" data-zanim-timeline="{}">
        <div class="bg-holder" style="background-image:url({{ base_url() }}assets/themes/elixir/v3.0.0/assets/img/header-8.jpg);"></div>
        <!--/.bg-holder-->
        <div class="container">
          <div class="row min-vh-100 py-8 align-items-center" data-inertia='{"weight":1.5}'>
            <div class="col-sm-8 col-lg-7 px-5 px-sm-3">
              <div class="overflow-hidden">
                <h1 class="fs-4 fs-md-5 lh-1" data-zanim-xs='{"delay":0}'>Kuesioner</h1>
              </div>
              <div class="overflow-hidden">
                <p class="text-primary pt-4 mb-5 fs-1 fs-md-2 lh-xs" data-zanim-xs='{"delay":0.1}'>Penyusunan Survei Keberdayaan Konsumen dilaksanakan berdasarkan dasar hukum serta peraturan perundangan yang berlaku.</p>
              </div>
              <div class="overflow-hidden">
                <div data-zanim-xs='{"delay":0.2}'><a class="btn btn-primary me-3 mt-3" href="{{ base_url() }}about">Baca selengkapnya<span class="fas fa-chevron-right ms-2"></span></a><a class="btn btn-warning mt-3" href="{{ base_url() }}contact">Kontak Kami<span class="fas fa-chevron-right ms-2"></span></a></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="swiper-slide" data-zanim-timeline="{}">
        <div class="bg-holder" style="background-image:url({{ base_url() }}assets/themes/elixir/v3.0.0/assets/img/header-10.jpg);"></div>
        <!--/.bg-holder-->
        <div class="container">
          <div class="row min-vh-100 py-8 align-items-center" data-inertia='{"weight":1.5}'>
            <div class="col-sm-8 col-lg-7 px-5 px-sm-3">
              <div class="overflow-hidden">
                <h1 class="fs-4 fs-md-5 lh-1" data-zanim-xs='{"delay":0}'>Keberdayaan</h1>
              </div>
              <div class="overflow-hidden">
                <p class="text-primary pt-4 mb-5 fs-1 fs-md-2 lh-xs" data-zanim-xs='{"delay":0.1}'>Semakin tinggi nilai IKK menunjukkan bahwa semakin berdaya konsumen.</p>
              </div>
              <div class="overflow-hidden">
                <div data-zanim-xs='{"delay":0.2}'><a class="btn btn-primary me-3 mt-3" href="{{ base_url() }}about">Baca selengkapnya<span class="fas fa-chevron-right ms-2"></span></a><a class="btn btn-warning mt-3" href="{{ base_url() }}contact">Kontak Kami<span class="fas fa-chevron-right ms-2"></span></a></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
    </div>
    <div class="swiper-nav">
      <div class="swiper-button-prev"><span class="fas fa-chevron-left"></span></div>
      <div class="swiper-button-next"><span class="fas fa-chevron-right"></span></div>
    </div>
  </div>
</section>

<section class="bg-white text-center">
    <div class="container">
      <div class="row justify-content-center text-center">
        <div class="col-10 col-md-6">
          <h3 class="fs-2 fs-lg-3">E-IKK – Layanan Indeks Keberdayaan Konsumen.</h3>
          <p class="px-lg-4 mt-3">Menyediakan layanan survei keberdayaan konsumen berbasis web bagi institusi pemerintah.</p>
          <hr class="short" data-zanim-xs='{"from":{"opacity":0,"width":0},"to":{"opacity":1,"width":"4.20873rem"},"duration":0.8}' data-zanim-trigger="scroll" />
        </div>
      </div>
    </div>
  </section>


<section class="bg-100">
    <div class="container">
      <div class="text-center mb-6">
        <h3 class="fs-2 fs-md-3">E-IKK</h3>
        <hr class="short" data-zanim-xs='{"from":{"opacity":0,"width":0},"to":{"opacity":1,"width":"4.20873rem"},"duration":0.8}' data-zanim-trigger="scroll" />
      </div>
      <div class="row g-0 position-relative mb-4 mb-lg-0">
        <div class="col-lg-6 py-3 py-lg-0 mb-0 position-relative" style="min-height:400px;">
          <div class="bg-holder rounded-ts-lg rounded-te-lg rounded-lg-te-0  " style="background-image:url({{ base_url() }}assets/themes/elixir/v3.0.0/assets/img/our_1.jpg);"></div>
          <!--/.bg-holder-->
        </div>
        <div class="col-lg-6 px-lg-5 py-lg-6 p-4 my-lg-0 bg-white rounded-bs-lg rounded-lg-bs-0 rounded-be-lg rounded-lg-be-0 rounded-lg-te-lg ">
          <div class="elixir-caret d-none d-lg-block"></div>
          <div class="d-flex align-items-center h-100">
            <div data-zanim-timeline="{}" data-zanim-trigger="scroll">
              <div class="overflow-hidden">
                <h5 data-zanim-xs='{"delay":0}'>Tentang IKK</h5>
              </div>
              <div class="overflow-hidden">
                <p class="mt-3" data-zanim-xs='{"delay":0.1}'>Indeks keberdayaan konsumen (IKK) merupakan parameter yang menunjukkan tingkat keberanian masyarakat suatu negara sebagai konsumen apabila tidak puas dengan produk dan layanan atau merasa dirugikan dalam suatu aktivitas perdagangan. IKK merupakan dasar untuk menetapkan kebijakan di bidang perlindungan konsumen dan untuk mengukur kesadaran dan pemahaman konsumen akan hak dan kewajibannya, serta kemampuan dalam berinteraksi dengan pasar. Sehingga penting bagi pemerintah untuk terus meningkatkan angka IKK.</p>
              </div>
              <div class="overflow-hidden">
                {{-- <div data-zanim-xs='{"delay":0.2}'><a class="d-flex align-items-center" href="{{ base_url() }}services/sistem-manajemen-mutu-iso-9001">Baca Selengkapnya<div class="overflow-hidden ms-2"><span class="d-inline-block" data-zanim-xs='{"from":{"opacity":0,"x":-30},"to":{"opacity":1,"x":0},"delay":0.8}'>&xrarr;</span></div></a></div> --}}
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row g-0 position-relative mb-4 mb-lg-0">
        <div class="col-lg-6 py-3 py-lg-0 mb-0 position-relative order-lg-2" style="min-height:400px;">
          <div class="bg-holder rounded-ts-lg rounded-te-lg rounded-lg-te-0  rounded-lg-ts-0" style="background-image:url({{ base_url() }}assets/themes/elixir/v3.0.0/assets/img/our_3.jpg);"></div>
          <!--/.bg-holder-->
        </div>
        <div class="col-lg-6 px-lg-5 py-lg-6 p-4 my-lg-0 bg-white rounded-bs-lg rounded-lg-bs-0 rounded-be-lg  rounded-lg-be-0">
          <div class="elixir-caret d-none d-lg-block"></div>
          <div class="d-flex align-items-center h-100">
            <div data-zanim-timeline="{}" data-zanim-trigger="scroll">
              <div class="overflow-hidden">
                <h5 data-zanim-xs='{"delay":0}'>Tujuan:</h5>
              </div>
              <div class="overflow-hidden">
                <p class="mt-3" data-zanim-xs='{"delay":0.1}'>
                <ol>
                    <li>Kegiatan Survei Keberdayaan Konsumen dimaksudkan untuk mendapatkan data keberdayaan konsumen berdasarkan karakteristik sosial, demografi dan perilaku konsumen pada saat pra pembelian, saat pembelian, hingga pasca pembelian.</li>
                    <li>Kegiatan Survei Keberdayaan Konsumen bertujuan untuk mendapatkan Indeks Keberdayaan Konsumen.</li>
                </ol></p>
              </div>
              <div class="overflow-hidden">
                {{-- <div data-zanim-xs='{"delay":0.2}'><a class="d-flex align-items-center" href="{{ base_url() }}services/sistem-manajemen-anti-penyuapan-iso-37001">Baca Selengkapnya<div class="overflow-hidden ms-2"><span class="d-inline-block" data-zanim-xs='{"from":{"opacity":0,"x":-30},"to":{"opacity":1,"x":0},"delay":0.8}'>&xrarr;</span></div></a></div> --}}
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row g-0 position-relative mb-4 mb-lg-0">
        <div class="col-lg-6 py-3 py-lg-0 mb-0 position-relative" style="min-height:400px;">
          <div class="bg-holder rounded-ts-lg rounded-te-lg rounded-lg-te-0 rounded-lg-ts-0 rounded-bs-0 rounded-lg-bs-lg " style="background-image:url({{ base_url() }}assets/themes/elixir/v3.0.0/assets/img/our_4.jpg);"></div>
          <!--/.bg-holder-->
        </div>
        <div class="col-lg-6 px-lg-5 py-lg-6 p-4 my-lg-0 bg-white rounded-bs-lg rounded-lg-bs-0 rounded-be-lg  ">
          <div class="elixir-caret d-none d-lg-block"></div>
          <div class="d-flex align-items-center h-100">
            <div data-zanim-timeline="{}" data-zanim-trigger="scroll">
              <div class="overflow-hidden">
                <h5 data-zanim-xs='{"delay":0}'>Survei Indeks Keberdayaan Konsumen jika dilakukan secara periodik dapat memberikan manfaat:</h5>
              </div>
              <div class="overflow-hidden">
                <p class="mt-3" data-zanim-xs='{"delay":0.1}'>
                  <ol>
                    <li>Bagi pemerintah, mengetahui dampak atau keberhasilan atas implementasi program-program pemberdayaan konsumen, sehingga dapat menentukan langkah strategis yang akan diambil kedepan untuk peningkatan keberdayaan konsumen.</li>
                    <li>Bagi lembaga penyelenggara perlindungan konsumen, adanya kegiatan Survei Keberdayaan Konsumen ini akan menjadi perhatian bagi lembaga penyelenggara perlindungan konsumen sehingga akan mendorong lembaga perlindungan konsumen untuk meningkatkan program kerjanya melalui berbagai aktivitas perlindungan konsumen.</li>
                    <li>Bagi masyarakat, memberikan wawasan kepada masyarakat mengenai kerangka besar Undang-Undang Perlindungan Konsumen (UUPK) agar masyarakat selaku konsumen mampu memahami hak dan kewajibannya sebagai konsumen, serta mampu memahami tanggung jawab dan kewajiban pelaku usaha, sehingga terwujud konsumen cerdas, mandiri, dan cinta produk dalam negeri.</li>
                </ol>
              </p>
              </div>
              <div class="overflow-hidden">
                {{-- <div data-zanim-xs='{"delay":0.2}'><a class="d-flex align-items-center" href="{{ base_url() }}services/survei-kepuasan-masyarakat">Baca Selengkapnya<div class="overflow-hidden ms-2"><span class="d-inline-block" data-zanim-xs='{"from":{"opacity":0,"x":-30},"to":{"opacity":1,"x":0},"delay":0.8}'>&xrarr;</span></div></a></div> --}}
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row g-0 position-relative mb-4 mb-lg-0">
        <div class="col-lg-6 py-3 py-lg-0 mb-0 position-relative order-lg-2" style="min-height:400px;">
          <div class="bg-holder rounded-ts-lg rounded-te-lg rounded-lg-te-0  rounded-lg-ts-0" style="background-image:url({{ base_url() }}assets/themes/elixir/v3.0.0/assets/img/our_2.jpg);"></div>
          <!--/.bg-holder-->
        </div>
        <div class="col-lg-6 px-lg-5 py-lg-6 p-4 my-lg-0 bg-white rounded-bs-lg rounded-lg-bs-0 rounded-be-lg  rounded-lg-be-0">
          <div class="elixir-caret d-none d-lg-block"></div>
          <div class="d-flex align-items-center h-100">
            <div data-zanim-timeline="{}" data-zanim-trigger="scroll">
              <div class="overflow-hidden">
                <h5 data-zanim-xs='{"delay":0}'>Sasaran:</h5>
              </div>
              <div class="overflow-hidden">
                <p class="mt-3" data-zanim-xs='{"delay":0.1}'>
                <ol>
                    <li>Mengetahui dampak atau keberhasilan atas implementasi program-program pemberdayaan konsumen, agar dapat ditentukan langkah strategis yang akan diambil kedepan untuk peningkatan keberdayaan konsumen.</li>
                    <li>Mendorong lembaga penyelenggara perlindungan konsumen dalam meningkatkan program kerjanya melalui berbagai aktivitas perlindungan konsumen.</li>
                    <li>Memberikan wawasan kepada masyarakat mengenai kerangka besar Undang-Undang Perlindungan Konsumen (UUPK) agar mampu memahami hak dan kewajibannya sebagai konsumen sehingga dapat menjadi konsumen cerdas, mandiri, dan cinta produk dalam negeri.</li>
                </ol>
              </p>
              </div>
              <div class="overflow-hidden">
                {{-- <div data-zanim-xs='{"delay":0.2}'><a class="d-flex align-items-center" href="{{ base_url() }}services/sistem-manajemen-anti-penyuapan-iso-37001">Baca Selengkapnya<div class="overflow-hidden ms-2"><span class="d-inline-block" data-zanim-xs='{"from":{"opacity":0,"x":-30},"to":{"opacity":1,"x":0},"delay":0.8}'>&xrarr;</span></div></a></div> --}}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div><!-- end of .container-->
  </section>





@endsection

@section('javascript')

@endsection