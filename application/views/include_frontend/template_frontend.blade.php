@php
	$ci = get_instance();
@endphp
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="robots" content="index, follow">
	<meta name="description" content="PT. KOKEK melayani jasa konsultansi dan pelatihan bidang ekonomi dan keuangan, sistem manajemen mutu, sistem manajemen lingkungan, keselamatan serta keselamatan & kesehatan kerja.">
	<meta name="keywords" content="kokek, konsultan, konsultan iso, manajemen mutu, konsultan pemerintahan, konsultan lingkungan, konsultan keselamatan, akreditasi puskesmas, konsultansi, SNI, pt. kokek">
	<meta http-equiv="Copyright" content="2017 - 2021. PT. KOKEK. All rights reserved.">
	<meta name="author" content="PT. KOKEK">
	<meta http-equiv="imagetoolbar" content="no">
	<meta name="language" content="Indonesia">
	<meta name="revisit-after" content="7">
	<meta name="webcrawlers" content="all">
	<meta name="rating" content="general">
	<meta name="spiders" content="all">
	<meta name="googlebot" content="index,follow" />
	<link rel="shortcut icon" href="{{ base_url() }}assets/img/site/logo/favicon.ico" />
    <link rel="manifest" href="{{ TEMPLATE_FRONTEND_PATH }}assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="{{ TEMPLATE_FRONTEND_PATH }}assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">
    <script src="{{ TEMPLATE_FRONTEND_PATH }}vendors/overlayscrollbars/OverlayScrollbars.min.js"></script>
    <link href="{{ TEMPLATE_FRONTEND_PATH }}vendors/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="{{ TEMPLATE_FRONTEND_PATH }}vendors/hamburgers/hamburgers.min.css" rel="stylesheet">
    <link href="{{ TEMPLATE_FRONTEND_PATH }}vendors/loaders.css/loaders.min.css" rel="stylesheet">
    <link href="{{ TEMPLATE_FRONTEND_PATH }}assets/css/theme.min.css" rel="stylesheet" />
    <link href="{{ TEMPLATE_FRONTEND_PATH }}assets/css/user.min.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&amp;family=Open+Sans:wght@300;400;600;700;800&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ VENDOR_PATH }}aos/aos.css">
	@yield('style')
</head>
<body>
	@include('include_frontend/partials_frontend/_header')

	@yield('content')


	@include('include_frontend/partials_frontend/_footer')
	
	<script src="{{ TEMPLATE_FRONTEND_PATH }}vendors/popper/popper.min.js"></script>
    <script src="{{ TEMPLATE_FRONTEND_PATH }}vendors/bootstrap/bootstrap.min.js"></script>
    <script src="{{ TEMPLATE_FRONTEND_PATH }}vendors/is/is.min.js"></script>
    <script src="{{ TEMPLATE_FRONTEND_PATH }}vendors/bigpicture/BigPicture.js"> </script>
    <script src="{{ TEMPLATE_FRONTEND_PATH }}vendors/countup/countUp.umd.js"> </script>
    <script src="{{ TEMPLATE_FRONTEND_PATH }}vendors/swiper/swiper-bundle.min.js"></script>
    <script src="{{ TEMPLATE_FRONTEND_PATH }}vendors/fontawesome/all.min.js"></script>
    <script src="{{ TEMPLATE_FRONTEND_PATH }}vendors/lodash/lodash.min.js"></script>
    <script src="{{ TEMPLATE_FRONTEND_PATH }}vendors/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="{{ TEMPLATE_FRONTEND_PATH }}vendors/gsap/gsap.js"></script>
    <script src="{{ TEMPLATE_FRONTEND_PATH }}vendors/gsap/customEase.js"></script>
    <script src="{{ TEMPLATE_FRONTEND_PATH }}assets/js/theme.js"></script>
    <script src="{{ VENDOR_PATH }}aos/aos.js"></script>
    <script>
		var txt = "{{ $title }} | E-IKK ";
		var speed = 300;
		var refresh = null;

		function action() {
			document.title = txt;
			txt = txt.substring(1, txt.length) + txt.charAt(0);
			refresh = setTimeout("action()", speed);
		}
		action();
	</script>
	<script>
	    AOS.init();
	</script>
	@yield('javascript')
</body>
</html>