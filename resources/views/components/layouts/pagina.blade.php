<!doctype html>
<html class="no-js " lang="es" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ $title ?? 'Escuela de Posgrado' }}</title>
    <meta name="author" content="Stadum">
    <meta name="description" content="Escuela de Posgrado - Universidad Nacional de Ucayali">
    <meta name="keywords" content="Escuela de Posgrado, Universidad Nacional de Ucayali">
    <meta name="robots" content="INDEX,FOLLOW">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons - Place favicon.ico in the root directory -->
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/logo-pg.png') }}" />
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('assets/media/logos/logo-pg.png') }}">
    <meta name="theme-color" content="#ffffff">

    <!--==============================
	  Google Fonts
	============================== -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!--==============================
	    All CSS File
	============================== -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets_page/css/bootstrap.min.css') }}">
    <!-- Fontawesome Icon -->
    <link rel="stylesheet" href="{{ asset('assets_page/css/fontawesome.min.css') }}">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="{{ asset('assets_page/css/magnific-popup.min.css') }}">
    <!-- Swiper Js -->
    <link rel="stylesheet" href="{{ asset('assets_page/css/swiper-bundle.min.css') }}">
    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets_page/css/style.css') }}">

</head>

<body>
    <!--==============================
     Preloader
    ==============================-->
    {{-- <div class="preloader ">
        <button class="th-btn preloaderCls">Cancel Preloader </button>
        <div class="preloader-inner">
            <img src="{{ asset('assets/media/logos/logo-pg.png') }}" alt="img">
            <span class="loader">
                <span class="loading-text">Escuela de Posgrado</span>
            </span>
        </div>
    </div> --}}
    <div class="popup-search-box">
        <button class="searchClose"><i class="far fa-times"></i></button>
        <form action="#">
            <input type="text" placeholder="What are you looking for?">
            <button type="submit"><i class="fal fa-search"></i></button>
        </form>
    </div>
    <!--==============================
    Mobile Menu
    ============================== -->
    <div class="th-menu-wrapper">
        <div class="th-menu-area text-center">
            <button class="th-menu-toggle"><i class="fal fa-times"></i></button>
            <div class="mobile-logo">
                <a href="home-university.html">
                    <img src="{{ asset('assets/media/logos/logo-pg.png') }}" width="100" alt="Logo">
                    <br>
                    <b>Escuela de Posgrado</b>
                </a>
            </div>
            <div class="th-mobile-menu">
                <ul>
                    <li><a href="{{ route('pagina.inicio') }}">Inicio</a></li>
                    <li class="menu-item-has-children">
                        <a href="#">Nosotros</a>
                        <ul class="sub-menu">
                            <li><a href="#">Misión</a></li>
                            <li><a href="#">Visión</a></li>
                            <li><a href="#">Objetivos</a></li>
                            <li><a href="#">Reseña Histórica</a></li>
                            <li><a href="#">Autoridades</a></li>
                            <li><a href="#">Reglamento</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children">
                        <a href="#">Admisión</a>
                        <ul class="sub-menu">
                            <li><a href="#">Requisitos de ingreso</a></li>
                            <li><a href="#">Procesos y cronogramas</a></li>
                            <li><a href="#">Costos y modalidades de pago</a></li>
                            <li><a href="#">Link para SIEPG</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children">
                        <a href="#">Programas académicos</a>
                        <ul class="sub-menu">
                            <li class="menu-item-has-children">
                                <a href="#">Maestrías</a>
                                <ul class="sub-menu">
                                    <li><a href="#">Maestría 1</a></li>
                                    <li><a href="#">Maestría 2</a></li>
                                </ul>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="#">Doctorados</a>
                                <ul class="sub-menu">
                                    <li><a href="#">Doctorado 1</a></li>
                                    <li><a href="#">Doctorado 2</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li><a href="#">Contáctenos</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!--==============================
	Header Area
    ==============================-->
    <header class="th-header header-layout1">
        {{-- <div class="header-top">
            <div class="container th-container4">
                <div class="row justify-content-center justify-content-lg-between align-items-center gy-2">
                    <div class="col-auto d-none d-lg-block">
                        <div class="header-links">
                            <ul class="header-left-wrap">
                                <li>
                                    <div class="dropdown-link">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink1" data-bs-toggle="dropdown" aria-expanded="false"> Studients</a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                                            <li>
                                                <a href="#">Scrollship</a>
                                                <a href="#">Forening</a>
                                                <a href="#">Online</a>
                                                <a href="#">Bysexual</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li><a href="contact.html">Staff</a></li>
                                <li><a href="alumni.html">Alumni</a></li>
                                <li><a href="faculty.html">Faculty</a> </li>
                                <li><a href="contact.html">Community</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="header-links">
                            <ul class="header-right-wrap">
                                <li><i class="fa-solid fa-user"></i><a href="#login-form" class="popup-content">Login / Register</a></li>
                                <li><i class="fas fa-comments"></i><a href="faq.html">FAQ</a></li>
                                <li>
                                    <div class="dropdown-link">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink2" data-bs-toggle="dropdown" aria-expanded="false"><img src="assets/img/icon/lang.svg" alt=""> </a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink2">
                                            <li>
                                                <a href="#">German</a>
                                                <a href="#">French</a>
                                                <a href="#">Italian</a>
                                                <a href="#">Latvian</a>
                                                <a href="#">Spanish</a>
                                                <a href="#">Greek</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="header-info d-none d-sm-block">
            <div class="container th-container2">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                        <div class="header-logo">
                            <a href="{{ route('pagina.inicio') }}">
                                <img src="{{ asset('assets/media/logos/logo-texto-pg.png') }}" alt="Logo" width="180">
                            </a>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="header-info-right">
                            <div class="header-info-item">
                                <div class="header-info-icon">
                                    <i class="fa-solid fa-location-dot"></i>
                                </div>
                                <div class="header-info-content">
                                    <span class="header-info-text">Dirección</span>
                                    <h3 class="header-info-title">
                                        <a href="javascript:void(0)">Carretera Federico Basadre Km. 6.00</a>
                                    </h3>
                                </div>
                            </div>
                            <div class="header-info-item">
                                <div class="header-info-icon">
                                    <i class="fa-solid fa-envelope"></i>
                                </div>
                                <div class="header-info-content">
                                    <span class="header-info-text">Correo electrónico</span>
                                    <h3 class="header-info-title">
                                        <a href="tel:mesadepartes_epg@unu.edu.pe">mesadepartes_epg@unu.edu.pe</a>
                                    </h3>
                                </div>
                            </div>
                            <div class="header-info-item">
                                <div class="header-info-icon">
                                    <i class="fa-solid fa-phone"></i>
                                </div>
                                <div class="header-info-content">
                                    <span class="header-info-text">Número de teléfono</span>
                                    <h3 class="header-info-title">
                                        <a href="tel:+51999999999">+51 999999999</a>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sticky-wrapper">
            <!-- Main Menu Area -->
            <div class="menu-area">
                <div class="container th-container2">
                    <div class="menu-wrapp">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-auto">
                                <div class="header-left d-flex align-items-center">
                                    <div class="header-logo d-block d-sm-none">
                                        <a href="{{ route('pagina.inicio') }}">
                                            <img src="{{ asset('assets/media/logos/logo-texto-pg.png') }}" alt="Logo" width="120">
                                        </a>
                                    </div>
                                    <div class="header-button d-none d-sm-block">
                                        <a href="#" class="th-btn">
                                            Obtén más información
                                            <i class="fa-solid fa-arrow-right-long"></i>
                                        </a>
                                    </div>
                                    <nav class="main-menu d-none d-xl-block">
                                        <ul>
                                            <li><a href="{{ route('pagina.inicio') }}">Inicio</a></li>
                                            <li class="menu-item-has-children">
                                                <a href="#">Nosotros</a>
                                                <ul class="sub-menu">
                                                    <li><a href="{{ route('pagina.mision') }}">Misión</a></li>
                                                    <li><a href="{{ route('pagina.vision') }}">Visión</a></li>
                                                    <li><a href="{{ route('pagina.objetivos') }}">Objetivos</a></li>
                                                    <li><a href="{{ route('pagina.resena-historica') }}">Reseña Histórica</a></li>
                                                    <li><a href="{{ route('pagina.autoridades') }}">Autoridades</a></li>
                                                    <li><a href="{{ route('pagina.reglamento') }}">Reglamento</a></li>
                                                </ul>
                                            </li>
                                            <li class="menu-item-has-children">
                                                <a href="#">Admisión</a>
                                                <ul class="sub-menu">
                                                    <li><a href="#">Requisitos de ingreso</a></li>
                                                    <li><a href="#">Procesos y cronogramas</a></li>
                                                    <li><a href="#">Costos y modalidades de pago</a></li>
                                                    <li><a href="#">Link para SIEPG</a></li>
                                                </ul>
                                            </li>
                                            <li class="menu-item-has-children">
                                                <a href="#">Programas académicos</a>
                                                <ul class="sub-menu">
                                                    <li class="menu-item-has-children">
                                                        <a href="#">Maestrías</a>
                                                        <ul class="sub-menu">
                                                            <li><a href="#">Maestría 1</a></li>
                                                            <li><a href="#">Maestría 2</a></li>
                                                        </ul>
                                                    </li>
                                                    <li class="menu-item-has-children">
                                                        <a href="#">Doctorados</a>
                                                        <ul class="sub-menu">
                                                            <li><a href="#">Doctorado 1</a></li>
                                                            <li><a href="#">Doctorado 2</a></li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li><a href="#">Contáctenos</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            <div class="col-auto ms-lg-auto">
                                <div class="header-button">
                                    <form class="search-form">
                                        <input type="text" placeholder="Buscar...">
                                        <button type="button"><i class="fa-light fa-magnifying-glass"></i></button>
                                    </form>
                                    {{-- <a href="#" class="icon-btn sideMenuToggler d-none d-xl-block"><img src="assets/img/icon/grid2.svg" alt=""></a> --}}
                                    <button type="button" class="th-menu-toggle d-inline-block d-xl-none"><i class="far fa-bars"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{ $slot }}

    <!--==============================
	Footer Area
    ==============================-->
    <footer class="footer-wrapper footer-default footer-overlay bg-title">
        {{-- <div class="footer-top">
            <div class="container">
                <div class="row gy-40 align-items-center justify-content-between">
                    <div class="col-xl-auto">
                        <div class="footer-logo z-index-common" data-cue="slideInLeft">
                            <a href="{{ route('pagina.inicio') }}">
                                <img src="{{ asset('assets/media/logos/logo-pg.png') }}" alt="Logo" width="100">
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-auto">
                        <div class="client-group-wrap z-index-common" data-cue="slideInRight">
                            <h4 class="title">
                                Estamos para ayudarte
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="container">
            <div class="widget-area">
                <div class="row justify-content-between">
                    <div class="col-md-6 col-xl-auto">
                        <div class="widget footer-widget">
                            <div class="th-widget-about">
                                <h3 class="widget_title">Sobre la Escuela de Posgrado</h3>
                                <p class="about-text">
                                    Mediante Resolución Nº 061-2005-R-UNU del 12 de Febrero del 2005, se designa la Comisión encargada del Estudio y Organización para la creación de la Escuela de Posgrado de la Universidad Nacional de Ucayali, presidida por el Blgo. Mg. Emilio Pascual Valentín.
                                </p>
                                <div class="footer-info">
                                    <a href="#">
                                        <span class="footer-info-icon"><i class="fa-solid fa-location-dot"></i></span> Carretera Federico Basadre Km. 6.00
                                    </a>
                                    <a href="mailto:mesadepartes_epg@unu.edu.pe">
                                        <span class="footer-info-icon"><i class="fa-solid fa-envelope"></i></span> mesadepartes_epg@unu.edu.pe
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-auto">
                        <div class="widget widget_nav_menu footer-widget">
                            <h3 class="widget_title">Enlaces de Interés</h3>
                            <div class="menu-all-pages-container">
                                <ul class="menu">
                                    <li><a href="http://www.minedu.gob.pe/">MINISTERIO DE EDUCACIÓN</a></li>
                                    <li><a href="http://www.sanciones.gob.pe:8081/transparencia/">RNSSC Transparencia</a></li>
                                    <li><a href="http://www.sunedu.gob.pe/">SUNEDU</a></li>
                                    <li><a href="http://dina.concytec.gob.pe/InvestigadorPorInstitucion/frm_InvestigadoresInstitucion.zul?path=DUZDh0v4PPDrc3slZrBckg%3D%3D">DINA</a></li>
                                    <li><a href="http://cinda.cl/">CINDA</a></li>
                                    <li><a href="http://www.unesco.org/new/es">UNESCO</a></li>
                                    <li><a href="http://rpu.edu.pe/">RED PERUANA DE UNIVERSIDADES</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-wrap z-index-common">
            <div class="container">
                <div class="row justify-content-center gy-3 align-items-center">
                    <div class="col-lg-6">
                        <p class="copyright-text">
                            <i class="fal fa-copyright"></i> Copyright 2025 <a href="{{ route('pagina.inicio') }}">Escuela de Posgrado</a>. Todos los derechos reservados.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!--********************************
			Code End  Here
	******************************** -->

    <!-- Scroll To Top -->
    <div class="scroll-top">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;">
            </path>
        </svg>
    </div>
    <!--==============================
    modal Area
    ==============================-->
    <div id="login-form" class="popup-login-register mfp-hide">
        <ul class="nav" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-menu" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="false">Login</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-menu active" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="true">Register</button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <h3 class="box-title mb-30">Sign in to your account</h3>
                <div class="th-login-form">
                    <form action="mail.php" method="POST" class="login-form ajax-contact">
                        <div class="row">
                            <div class="form-group col-12">
                                <label>Username or email</label>
                                <input type="text" class="form-control" name="email" id="email" required="required">
                            </div>
                            <div class="form-group col-12">
                                <label>Password</label>
                                <input type="password" class="form-control" name="pasword" id="pasword" required="required">
                            </div>

                            <div class="form-btn mb-20 col-12">
                                <button class="th-btn btn-fw th-radius2 ">Send Message</button>
                            </div>
                        </div>
                        <div id="forgot_url">
                            <a href="my-account.html">Forgot password?</a>
                        </div>
                        <p class="form-messages mb-0 mt-3"></p>
                    </form>
                </div>
            </div>
            <div class="tab-pane fade active show" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <h3 class="th-form-title mb-30">Sign in to your account</h3>
                <form action="mail.php" method="POST" class="login-form ajax-contact">
                    <div class="row">
                        <div class="form-group col-12">
                            <label>Username*</label>
                            <input type="text" class="form-control" name="usename" id="usename" required="required">
                        </div>
                        <div class="form-group col-12">
                            <label>First name*</label>
                            <input type="text" class="form-control" name="firstname" id="firstname" required="required">
                        </div>
                        <div class="form-group col-12">
                            <label>Last name*</label>
                            <input type="text" class="form-control" name="lastname" id="lastname" required="required">
                        </div>
                        <div class="form-group col-12">
                            <label for="new_email">Your email*</label>
                            <input type="text" class="form-control" name="new_email" id="new_email" required="required">
                        </div>
                        <div class="form-group col-12">
                            <label for="new_email_confirm">Confirm email*</label>
                            <input type="text" class="form-control" name="new_email_confirm" id="new_email_confirm" required="required">
                        </div>
                        <div class="statement">
                            <span class="register-notes">A password will be emailed to you.</span>
                        </div>

                        <div class="form-btn mt-20 col-12">
                            <button class="th-btn btn-fw th-radius2 ">Sign up</button>
                        </div>
                    </div>
                    <p class="form-messages mb-0 mt-3"></p>
                </form>
            </div>
        </div>
    </div>
    <!--==============================
        All Js File
    ============================== -->
    <!-- Jquery -->
    <script src="{{ asset('assets_page/js/vendor/jquery-3.7.1.min.js') }}"></script>
    <!-- Swiper Js -->
    <script src="{{ asset('assets_page/js/swiper-bundle.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('assets_page/js/bootstrap.min.js') }}"></script>
    <!-- Magnific Popup -->
    <script src="{{ asset('assets_page/js/jquery.magnific-popup.min.js') }}"></script>
    <!-- Counter Up -->
    <script src="{{ asset('assets_page/js/jquery.counterup.min.js') }}"></script>
    <!-- Range Slider -->
    <script src="{{ asset('assets_page/js/jquery-ui.min.js') }}"></script>
    <!-- Isotope Filter -->
    <script src="{{ asset('assets_page/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets_page/js/isotope.pkgd.min.js') }}"></script>
    <!-- Wow Js -->
    <script src="{{ asset('assets_page/js/wow.min.js') }}"></script>

    <!-- Gsap Animation -->
    <script src="{{ asset('assets_page/js/gsap.min.js') }}"></script>
    <!-- ScrollTrigger -->
    <script src="{{ asset('assets_page/js/ScrollTrigger.min.js') }}"></script>
    <!-- SplitText -->
    <script src="{{ asset('assets_page/js/SplitText.min.js') }}"></script>
    <!-- Lenis Js -->
    <script src="{{ asset('assets_page/js/lenis.min.js') }}"></script>
    <!-- Main Js File -->
    <script src="{{ asset('assets_page/js/main.js') }}"></script>

</body>

</html>
