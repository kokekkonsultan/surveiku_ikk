<!DOCTYPE html>
<html lang="en">

<head>
    <base href="">
    <meta charset="utf-8" />
    <title>{{ $title }}</title>
    <meta name="description" content="Survey Indeks Keberdayaan Konsumen." />
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" /> --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="canonical" href="https://keenthemes.com/metronic" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="{{ TEMPLATE_BACKEND_PATH }}plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ TEMPLATE_BACKEND_PATH }}plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{ TEMPLATE_BACKEND_PATH }}plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ TEMPLATE_BACKEND_PATH }}css/style.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{ TEMPLATE_BACKEND_PATH }}css/themes/layout/header/base/light.css" rel="stylesheet" type="text/css" />
    <link href="{{ TEMPLATE_BACKEND_PATH }}css/themes/layout/header/menu/light.css" rel="stylesheet" type="text/css" />
    <link href="{{ TEMPLATE_BACKEND_PATH }}css/themes/layout/brand/dark.css" rel="stylesheet" type="text/css" />
    <link href="{{ TEMPLATE_BACKEND_PATH }}css/themes/layout/aside/dark.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ VENDOR_PATH }}aos/aos.css">
    <link rel="shortcut icon" href="{{ base_url() }}assets/img/site/logo/favicon.ico" />
    @yield('style')
    <style>
    body {
        background-image: url("{{ base_url() }}assets/img/bg/main-bg.jpg");
        background-repeat: repeat;
    }

    .outer-box {
        font-size: 24px;
        width: 100%;
        height: 100px;
        padding: 2px;
    }

    .box-edge-logo {
        font-size: 14px;
        width: 110px;
        height: 110px;
        padding: 8px;
        float: left;
        text-align: center;
    }

    .box-edge-text {
        font-size: 14px;
        width: 92%;
        height: 110px;
        padding: 8px;
        /* float: left; */
    }


    .box-title {
        font-size: 15px;
        font-weight: bold;
    }

    .box-desc {
        margin-top: 5px;
        font-size: 12px;
        /* font-weight: bold; */
    }

    .conatiner-btn {
        width: 100%;
        margin-top: 10px;
        margin-bottom: 50px;
    }

    .btn-left {
        float: left;
        width: 50%;
    }

    .btn-right {
        float: left;
        width: 50%;
        text-align: right;
    }

    @media screen and (max-width: 600px) {
        .outer-box {
            float: none;
            margin: 0 auto;
            height: 225px;
        }

        .box-edge-logo {
            float: none;
            margin: 0 auto;
            text-align: center;
        }

        .box-edge-text {
            float: none;
            margin: 0 auto;
            text-align: center;
        }
    }

    @media screen and (max-width: 992px) {
        .outer-box {
            float: none;
            margin: 0 auto;
            height: 225px;
        }

        .box-edge-logo {
            float: none;
            margin: 0 auto;
            text-align: center;
        }

        .box-edge-text {
            float: none;
            margin: 0 auto;
            text-align: center;
        }
    }

    #progressbar {
        margin-bottom: 30px;
        overflow: hidden;
        color: lightgrey;
        /*Warna teks saat belum active*/
    }

    #progressbar .active {
        color: #2a3855
    }

    #progressbar li {
        list-style-type: none;
        font-size: 12px;
        float: left;
        position: relative
    }

    #progressbar #account:before {
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        content: "\f007";
    }

    #progressbar #personal:before {
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        content: "\f15c";
    }

    #progressbar #payment:before {
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        content: "\f27a";
    }

    #progressbar #confirm:before {
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        content: "\f06a";
    }

    #progressbar #completed:before {
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        content: "\f00c";
    }

    #progressbar li:before {
        width: 50px;
        height: 50px;
        line-height: 45px;
        display: block;
        font-size: 18px;
        color: #ffffff;
        background: lightgray;
        border-radius: 25%;
        margin: 0 auto 10px auto;
        padding: 2px
    }

    #progressbar li:after {
        content: '';
        width: 100%;
        height: 2px;
        background: lightgray;
        position: absolute;
        left: 0;
        top: 25px;
        z-index: -1
    }

    #progressbar li.active:before,
    #progressbar li.active:after {
        background: linear-gradient(#fdd83e, #fdd83e);
        /* color: #2a3855; */
    }
    </style>


    <style>
    .sticky-chat-button {
        position: fixed;
        background-color: white;
        border-radius: 40px;
        border: 4px solid #E4E6EF;
        bottom: 80px;
        right: 15%;
        height: 65px;
        width: 65px;
        overflow: hidden;
    }

    .sticky-chat-button span {
        display: inline-block;
        position: relative;
        text-align: center;
        height: 30px;
        width: 30px;
        padding: 15px;
    }
    </style>
</head>

<body id="kt_body"
    class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable">

    @if($ci->uri->segment(5) == 'edit')
    <div class="" style="text-align: center; background-color: #AE0000; color: #FFFFFF; font-size:14px;">
        <b>DATA SURVEI SEDANG DI EDIT</b>
    </div>
    @endif


    @if($ci->uri->segment(3) == 'form-survei')
    <div class="" style="text-align: center; background-color: orange; color: #FFFFFF; font-size:14px;">
        <b>PREVIEW FORM SURVEI</b>
    </div>

    <!-- <a class="sticky-chat-button shadow" data-toggle="tooltip" data-placement="right" title="Edit Form Survei"
        href="{{base_url().$ci->uri->segment(1).'/'.$ci->uri->segment(2).'/edit-form-survei/opening'}}" target="_blank">
        <span>
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-pencil-fill"
                viewBox="0 0 16 16">
                <path fill="#E4E6EF"
                    d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
            </svg>

        </span>
    </a> -->
    @endif

    <nav class="navbar navbar-light bg-white shadow mb-5">
        <div class="outer-box">
            <div class="box-edge-logo">

                @php
                $slug = $ci->uri->segment(2);

                $data_user = $ci->db->query("SELECT *, iF(is_saran = 1, '25%', '33.3%') AS style_saran
                FROM manage_survey
                JOIN users ON manage_survey.id_user = users.id
                WHERE slug = '$slug'")->row();
                $style_saran = $data_user->style_saran;
                @endphp

                @php
                $identitas_survey = $ci->db->query("
                SELECT *, DATE_FORMAT(survey_end, '%d %M %Y') AS survey_selesai, IF(CURDATE() > survey_end,1,NULL) AS
                survey_berakhir,
                IF(CURDATE() < survey_start ,1,NULL) AS survey_belum_mulai FROM manage_survey JOIN users ON
                    manage_survey.id_user=users.id WHERE slug='$slug' ")->row();
                @endphp

                <style>
                    #progressbar li {
                        width: <?php echo $style_saran ?>;
                    }
                </style>

                    @if ($data_user->foto_profile == NULL)
                    <img src=" <?php echo base_url(); ?>assets/klien/foto_profile/200px.jpg" width="90%" class=""
                    alt="">
                    @else
                    <img src="<?php echo base_url(); ?>assets/klien/foto_profile/<?php echo $data_user->foto_profile ?>"
                        width="90%" class="" alt="">
                    @endif

            </div>
            @php
            $title_header = unserialize($manage_survey->title_header_survey);
            $title_1 = $title_header[0];
            $title_2 = $title_header[1];
            @endphp
            <div class="box-edge-text">
                <div class="box-title">
                    <?php echo $title_1 ?>
                </div>
                <div class="box-desc">
                    <?php echo $title_2 ?>
                </div>
            </div>
        </div>
    </nav>



    <div class="">
        @yield('content')
    </div>
    <script src="{{ VENDOR_PATH }}jquery/jquery-3.6.0.min.js"></script>
    <script src="{{ TEMPLATE_BACKEND_PATH }}plugins/global/plugins.bundle.js"></script>
    <script src="{{ TEMPLATE_BACKEND_PATH }}plugins/custom/prismjs/prismjs.bundle.js"></script>
    <script src="{{ TEMPLATE_BACKEND_PATH }}js/scripts.bundle.js"></script>
    <script src="{{ TEMPLATE_BACKEND_PATH }}plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
    <script src="{{ TEMPLATE_BACKEND_PATH }}js/pages/widgets.js"></script>
    <script src="{{ VENDOR_PATH }}aos/aos.js"></script>
    @yield('javascript')
    <script>
    AOS.init();
    </script>

    <script>
    var KTAppSettings = {
        "breakpoints": {
            "sm": 576,
            "md": 768,
            "lg": 992,
            "xl": 1200,
            "xxl": 1400
        },
        "colors": {
            "theme": {
                "base": {
                    "white": "#ffffff",
                    "primary": "#3699FF",
                    "secondary": "#E5EAEE",
                    "success": "#1BC5BD",
                    "info": "#8950FC",
                    "warning": "#FFA800",
                    "danger": "#F64E60",
                    "light": "#E4E6EF",
                    "dark": "#181C32"
                },
                "light": {
                    "white": "#ffffff",
                    "primary": "#E1F0FF",
                    "secondary": "#EBEDF3",
                    "success": "#C9F7F5",
                    "info": "#EEE5FF",
                    "warning": "#FFF4DE",
                    "danger": "#FFE2E5",
                    "light": "#F3F6F9",
                    "dark": "#D6D6E0"
                },
                "inverse": {
                    "white": "#ffffff",
                    "primary": "#ffffff",
                    "secondary": "#3F4254",
                    "success": "#ffffff",
                    "info": "#ffffff",
                    "warning": "#ffffff",
                    "danger": "#ffffff",
                    "light": "#464E5F",
                    "dark": "#ffffff"
                }
            },
            "gray": {
                "gray-100": "#F3F6F9",
                "gray-200": "#EBEDF3",
                "gray-300": "#E4E6EF",
                "gray-400": "#D1D3E0",
                "gray-500": "#B5B5C3",
                "gray-600": "#7E8299",
                "gray-700": "#5E6278",
                "gray-800": "#3F4254",
                "gray-900": "#181C32"
            }
        },
        "font-family": "Poppins"
    };
    </script>
    <script src="{{ base_url() }}assets/themes/metronic/assets/plugins/global/plugins.bundle.js"></script>
    <script src="{{ base_url() }}assets/themes/metronic/assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
    <script src="{{ base_url() }}assets/themes/metronic/assets/js/scripts.bundle.js"></script>
    <script src="{{ base_url() }}assets/plugins/wow/wow.min.js"></script>
    <script>
    new WOW().init();
    </script>
</body>

</html>