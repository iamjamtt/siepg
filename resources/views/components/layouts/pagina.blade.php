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
    <!--==============================
    Sidemenu
    ============================== -->
    <div class="sidemenu-wrapper ">
        <div class="sidemenu-content">
            <button class="closeButton sideMenuCls"><i class="far fa-times"></i></button>
            <div class="widget footer-widget">
                <div class="th-widget-about">
                    <div class="about-logo">
                        <a href="home-university.html">
                            <img src="assets/img/logo2.svg" alt="Stadum">
                        </a>
                    </div>
                    <p class="about-text">Since 1999, when the newly minted Stadum team embraced its mandate to breathe new life into the downtrodden neighbourhood, East Village’s transformation has been nothing short of remarkable. </p>
                    <div class="footer-info">
                        <a href="#">
                            <span class="footer-info-icon"><i class="fa-solid fa-location-dot"></i></span> 45 New Eskaton Road, Austria
                        </a>
                        <a href="mailto:infomail@example.com">
                            <span class="footer-info-icon"><i class="fa-solid fa-envelope"></i></span> infomail@example.com
                        </a>
                    </div>
                </div>
            </div>
            <div class="widget footer-widget">
                <h3 class="widget_title">Recent Posts</h3>
                <div class="recent-post-wrap">
                    <div class="recent-post">
                        <div class="media-img">
                            <a href="blog-details.html"><img src="assets/img/blog/recent-post-1-1.jpg" alt="Blog Image"></a>
                        </div>
                        <div class="media-body">
                            <h4 class="post-title">
                                <a class="text-inherit" href="blog-details.html">Trailblazers in Faculty Perspectives</a>
                            </h4>
                            <div class="recent-post-meta">
                                <a href="blog.html"><i class="far fa-calendar"></i>26/6/2025</a>
                            </div>
                        </div>
                    </div>
                    <div class="recent-post">
                        <div class="media-img">
                            <a href="blog-details.html"><img src="assets/img/blog/recent-post-1-2.jpg" alt="Blog Image"></a>
                        </div>
                        <div class="media-body">
                            <h4 class="post-title"><a class="text-inherit" href="blog-details.html">Future Focus Preparing for Tomorrow</a></h4>
                            <div class="recent-post-meta">
                                <a href="blog.html"><i class="far fa-calendar"></i>24/6/2025</a>
                            </div>
                        </div>
                    </div>
                    <div class="recent-post">
                        <div class="media-img">
                            <a href="blog-details.html"><img src="assets/img/blog/recent-post-1-3.jpg" alt="Blog Image"></a>
                        </div>
                        <div class="media-body">
                            <h4 class="post-title">
                                <a class="text-inherit" href="blog-details.html">The Green Initiative Sustainability in Action</a>
                            </h4>
                            <div class="recent-post-meta">
                                <a href="blog.html"><i class="far fa-calendar"></i>24/6/2025</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="widget footer-widget">
                <h3 class="widget_title">Popular Tags</h3>
                <div class="th-social">
                    <a href="https://facebook.com"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://twitter.com"><i class="fab fa-twitter"></i></a>
                    <a href="https://pinterest.com"><i class="fab fa-pinterest-p"></i></a>
                    <a href="https://linkedin.com"><i class="fab fa-linkedin-in"></i></a>
                    <a href="https://linkedin.com"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </div>
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
                                        <a href="javascript:void(0)">Nombre de dirección</a>
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
                                        <a href="tel:example@unu.edu.pe">example@unu.edu.pe</a>
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
    <!--==============================
    Hero Area
    ==============================-->
    <div class="th-hero-wrapper hero-1" id="hero">
        <div class="swiper th-slider" id="heroSlide" data-slider-options='{"effect":"fade"}'>
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="hero-inner">
                        <div class="th-hero-bg" data-bg-src="https://images.unsplash.com/photo-1627556704290-2b1f5853ff78?q=80&w=1740&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"></div>
                        <div class="container th-container2">
                            <div class="row gy-60 align-items-center">
                                <div class="col-xxl-6 col-xl-8 col-lg-9">
                                    <div class="hero-style1">
                                        <div class="hero-text-wrap">
                                            <h1 class="hero-title text-white" data-ani="slideinup" data-ani-delay="0.3s">
                                                Bienvenidos a la Escuela de Posgrado
                                            </h1>
                                            <p class="hero-text text-white" data-ani="slideinup" data-ani-delay="0.5s">
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae possimus dolorem voluptate quos odit quis itaque, autem explicabo doloribus.
                                            </p>
                                            <div class="btn-wrap justify-content-center justify-content-lg-start" data-ani="slideinup" data-ani-delay="0.8s">
                                                <a href="#" class="th-btn white-hover th-icon">Ver Admisión</a>
                                                <a href="#" class="th-btn style-border1 th-icon white-hover">Ver Programa</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-xl-4 col-lg-3">
                                    <div class="hero-video text-center ms-xl-5 ps-xl-5" data-ani="fadeinright" data-ani-delay="0.9s">
                                        <a href="https://www.youtube.com/watch?v=EZfLOSQ8hW8" class="video-play-btn popup-video">
                                            <i class="fa-sharp fa-solid fa-play"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="hero-inner">
                        <div class="th-hero-bg" data-bg-src="https://images.unsplash.com/photo-1627556704290-2b1f5853ff78?q=80&w=1740&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"></div>
                        <div class="container th-container2">
                            <div class="row gy-60 align-items-center">
                                <div class="col-xxl-6 col-xl-8 col-lg-9">
                                    <div class="hero-style1">
                                        <div class="hero-text-wrap">
                                            <h1 class="hero-title text-white" data-ani="slideinup" data-ani-delay="0.3s">
                                                Todos somos parte de un mismo equipo
                                            </h1>
                                            <p class="hero-text text-white" data-ani="slideinup" data-ani-delay="0.5s">
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae possimus dolorem voluptate quos odit quis itaque, autem explicabo doloribus.
                                            </p>
                                            <div class="btn-wrap justify-content-center justify-content-lg-start" data-ani="slideinup" data-ani-delay="0.8s">
                                                <a href="#" class="th-btn white-hover th-icon">Ver Admisión</a>
                                                <a href="#" class="th-btn style-border1 th-icon white-hover">Ver Programa</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-xl-4 col-lg-3">
                                    <div class="hero-video text-center ms-xl-5 ps-xl-5" data-ani="fadeinright" data-ani-delay="0.9s">
                                        <a href="https://www.youtube.com/watch?v=EZfLOSQ8hW8" class="video-play-btn popup-video">
                                            <i class="fa-sharp fa-solid fa-play"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="slider-pagination"></div>
        </div>
    </div>
    {{-- <!--======== / Hero Section ========-->
    <div class="feature-sec-1 position-relative overflow-hidden space-bottom">
        <div class="about-shep-2 shape-mockup  d-none d-xxl-block" data-top="19%" data-left="0%">
            <img src="assets/img/shape/feature-shep-home-1.png" alt="shape">
        </div>
        <div class="container th-container2">
            <div class="row gx-10 gy-10">
                <div class="col-xl-3 col-md-6 feature-card_wrapp">
                    <div class="feature-card wow fadeInUp" data-wow-delay=".2s">
                        <div class="box-icon">
                            <img src="assets/img/icon/feature-icon1-1.svg" alt="icon">
                        </div>
                        <h3 class="box-title">University Life</h3>
                        <p class="box-text style2">On the other hand denounce with righteous indignation dislike.</p>
                        <a href="program.html" class="th-btn style-border2 th-icon">Learn More</a>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 feature-card_wrapp">
                    <div class="feature-card wow fadeInUp" data-wow-delay=".4s">
                        <div class="box-icon">
                            <img src="assets/img/icon/feature-icon1-2.svg" alt="icon">
                        </div>
                        <h3 class="box-title">Research</h3>
                        <p class="box-text style2">On the other hand denounce with righteous indignation dislike.</p>
                        <a href="program.html" class="th-btn style-border2 th-icon">Learn More</a>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 feature-card_wrapp">
                    <div class="feature-card wow fadeInUp" data-wow-delay=".6s">
                        <div class="box-icon">
                            <img src="assets/img/icon/feature-icon1-3.svg" alt="icon">
                        </div>
                        <h3 class="box-title">Athletics</h3>
                        <p class="box-text style2">On the other hand denounce with righteous indignation dislike.</p>
                        <a href="program.html" class="th-btn style-border2 th-icon">Learn More</a>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 feature-card_wrapp">
                    <div class="feature-card wow fadeInUp" data-wow-delay=".8s">
                        <div class="box-icon">
                            <img src="assets/img/icon/feature-icon1-4.svg" alt="icon">
                        </div>
                        <h3 class="box-title">Academics</h3>
                        <p class="box-text style2">On the other hand denounce with righteous indignation dislike.</p>
                        <a href="program.html" class="th-btn style-border2 th-icon">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- <!--==============================
    About Area
    ==============================-->
    <div class="about1-area position-relative overflow-hidden space-bottom" id="about-sec">
        <div class="about-shep-2 shape-mockup d-none d-xxl-block" data-bottom="0%" data-right="0%">
            <img src="assets/img/shape/feature-shep-2-home-1.png" alt="shape">
        </div>
        <span class="about-shape-right shape-mockup jump-reverse" data-right="3%" data-top="2%"><img src="assets/img/shape/ab-shape1-2.png" alt=""></span>
        <div class="container">
            <div class="about-wrap1 position-relative z-index-2">
                <div class="row gy-60 align-items-center justify-content-center">
                    <div class="col-xl-6">
                        <div class="img-box1">
                            <div class="img1 text-center text-sm-start wow fadeInLeft" data-wow-delay=".2s">
                                <img src="assets/img/about/home-1-about-thumb1-1.jpg" alt="About">
                            </div>
                            <div class="img2 wow fadeInUp" data-wow-delay=".3s">
                                <div class="position-relative">
                                    <img class="mb-25" src="assets/img/about/home-1-about-thumb1-2.jpg" alt="About">
                                </div>
                                <div class="position-relative wow fadeInUp" data-wow-delay=".3s">
                                    <img src="assets/img/about/home-1-about-thumb1-3.jpg" alt="About">
                                </div>
                            </div>
                            <div class="about-wrapp">
                                <div class="discount-wrapp">
                                    <div class="logo">
                                        <img src="assets/img/circle-logo.svg" alt="img">
                                    </div>
                                    <div class="discount-tag">
                                        <span class="discount-anime">* 1996 EST * 25 Years Quality Teaching</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="about-content ms-xxl-4 ps-xxl-2 ms-xl-2">
                            <div class="title-area">
                                <span class="sub-title text-anim">About Us</span>
                                <h2 class="sec-title text-anim2"> We Offer best program for Shaping the best Future
                                </h2>

                                <p class="sec-text mt-25 mb-0 wow fadeInUp" data-wow-delay=".2s">We are committed
                                    to leaving the world a better place. We pursue new technology, encourage
                                    creativity, engage
                                    with our communities, and share an entrepreneurial mindset.</p>
                            </div>
                            <div class="about-feature-box">
                                <div class="about-feature wow fadeInUp" data-wow-delay=".3s">
                                    <span class="box-icon">
                                        <img src="assets/img/icon/ab-users.svg" alt="icon">
                                    </span>
                                    <div class="box-content">
                                        <h3 class="box-title">Three MBA degrees</h3>
                                        <p class="box-text">Our team is ready for any challenge! We put our joint efforts to
                                            generate brave business ideas.</p>
                                    </div>
                                </div>
                                <div class="about-feature wow fadeInUp" data-wow-delay=".4s">
                                    <span class="box-icon">
                                        <img src="assets/img/icon/ab-message.svg" alt="icon">
                                    </span>
                                    <div class="box-content">
                                        <h3 class="box-title">Choose From 98+ Degrees</h3>
                                        <p class="box-text">Our team is ready for any challenge! We put our joint efforts to
                                            generate brave business ideas.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="btn-wrap wow fadeInUp" data-wow-delay=".5s">
                                <a href="about.html" class="th-btn th-icon">Learn More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <span class="about-shape-left shape-mockup movingX d-none d-xxl-block" data-bottom="0%" data-left="2%"><img src="assets/img/shape/ab-shape1-1.png" alt=""></span>
    </div>
    <div class="counter-area1 overflow-hidden ">
        <div class="container th-container2">
            <div class="counter-wrap1">
                <div class="counter-card wow fadeInUp" data-wow-delay=".2s">
                    <div class="box-icon">
                        <img src="assets/img/icon/counter-icon1-1.svg" alt="icon">
                    </div>
                    <div class="media-body">
                        <h3 class="box-number"><span class="counter-number">157</span>+</h3>
                        <p class="box-text">Total Programs</p>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="counter-card wow fadeInUp" data-wow-delay=".4s">
                    <div class="box-icon">
                        <img src="assets/img/icon/counter-icon1-2.svg" alt="icon">
                    </div>
                    <div class="media-body">
                        <h3 class="box-number"><span class="counter-number">18,250</span></h3>
                        <p class="box-text">Faculty & Staff</p>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="counter-card wow fadeInUp" data-wow-delay=".6s">
                    <div class="box-icon">
                        <img src="assets/img/icon/counter-icon1-3.svg" alt="icon">
                    </div>
                    <div class="media-body">
                        <h3 class="box-number"><span class="counter-number">48</span>k</h3>
                        <p class="box-text">Worldwide Alumni</p>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="counter-card wow fadeInUp" data-wow-delay=".7s">
                    <div class="box-icon">
                        <img src="assets/img/icon/counter-icon1-4.svg" alt="icon">
                    </div>
                    <div class="media-body">
                        <h3 class="box-number"><span class="counter-number">155</span>k</h3>
                        <p class="box-text">Total Students</p>
                    </div>
                </div>
                <div class="divider"></div>
            </div>
        </div>
    </div> --}}
    <section class="academic1-area space overflow-hidden" id="program-sec">
        <div class="container">
            <div class="row justify-content-lg-between justify-content-center align-items-center">
                <div class="col-lg-9 col-12">
                    <div class="title-area text-center text-lg-start mb-75">
                        <span class="sub-title text-anim">SECCIÓN</span>
                        <h2 class="sec-title text-anim2">Anuncios Importantes</h2>
                    </div>
                </div>
                <div class="col-auto align-self-end">
                    <div class="sec-btn wow fadeInUp" data-wow-delay=".3s">
                        <a href="#" class="th-btn style-border1 th-icon"> Explorar todos </a>
                    </div>
                </div>
            </div>
            <div class="academic-wrapp">
                <div class="slider-area">
                    <div class="swiper th-slider has-shadow" id="academicSlider2" data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"1"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"3"},"1400":{"slidesPerView":"3", "spaceBetween": "24"}},"autoHeight": "true", "autoplay" : "false"}'>
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="academic-card">
                                    <div class="academic-img">
                                        <a href="program-details.html">
                                            <img src="https://images.unsplash.com/photo-1755867712452-871192ab3b2e?q=80&w=1752&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="anuncio 1">
                                        </a>
                                        <div class="academic-tag">
                                            <span><i class="fa-solid fa-tags"></i> Importante</span>
                                        </div>
                                    </div>
                                    <div class="academic-content">
                                        <h3 class="box-title">
                                            <a href="program-details.html">Titulo del anuncio</a>
                                        </h3>
                                        <div class="academic-review">
                                            <span><i class="fa-solid fa-star"></i></span>
                                            <span><i class="fa-solid fa-star"></i></span>
                                            <span><i class="fa-solid fa-star"></i></span>
                                            <span><i class="fa-solid fa-star"></i></span>
                                            <span><i class="fa-solid fa-star"></i></span>
                                            <p class="review-text">(4.8)</p>
                                        </div>
                                        <p class="box-text style2">
                                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Distinctio doloribus quas ipsam culpa eligendi iste consectetur ducimus officiis ipsa, in, aperiam quasi?.
                                        </p>
                                    </div>
                                    <div class="academic-meta-wrap">
                                        <div class="academic-meta">
                                            <a href="#" class="duration"><i class="fa-solid fa-clock"></i> 04/10/2025</a>
                                        </div>
                                        <a href="#" class="th-btn style-border1 th-icon">Ver</a>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="academic-card">
                                    <div class="academic-img">
                                        <a href="program-details.html">
                                            <img src="https://images.unsplash.com/photo-1755867712452-871192ab3b2e?q=80&w=1752&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="anuncio 1">
                                        </a>
                                        <div class="academic-tag">
                                            <span><i class="fa-solid fa-tags"></i> Importante</span>
                                        </div>
                                    </div>
                                    <div class="academic-content">
                                        <h3 class="box-title">
                                            <a href="program-details.html">Titulo del anuncio</a>
                                        </h3>
                                        <div class="academic-review">
                                            <span><i class="fa-solid fa-star"></i></span>
                                            <span><i class="fa-solid fa-star"></i></span>
                                            <span><i class="fa-solid fa-star"></i></span>
                                            <span><i class="fa-solid fa-star"></i></span>
                                            <span><i class="fa-solid fa-star"></i></span>
                                            <p class="review-text">(4.8)</p>
                                        </div>
                                        <p class="box-text style2">
                                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Distinctio doloribus quas ipsam culpa eligendi iste consectetur ducimus officiis ipsa, in, aperiam quasi?.
                                        </p>
                                    </div>
                                    <div class="academic-meta-wrap">
                                        <div class="academic-meta">
                                            <a href="#" class="duration"><i class="fa-solid fa-clock"></i> 04/10/2025</a>
                                        </div>
                                        <a href="#" class="th-btn style-border1 th-icon">Ver</a>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="academic-card">
                                    <div class="academic-img">
                                        <a href="program-details.html">
                                            <img src="https://images.unsplash.com/photo-1755867712452-871192ab3b2e?q=80&w=1752&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="anuncio 1">
                                        </a>
                                        <div class="academic-tag">
                                            <span><i class="fa-solid fa-tags"></i> Importante</span>
                                        </div>
                                    </div>
                                    <div class="academic-content">
                                        <h3 class="box-title">
                                            <a href="program-details.html">Titulo del anuncio</a>
                                        </h3>
                                        <div class="academic-review">
                                            <span><i class="fa-solid fa-star"></i></span>
                                            <span><i class="fa-solid fa-star"></i></span>
                                            <span><i class="fa-solid fa-star"></i></span>
                                            <span><i class="fa-solid fa-star"></i></span>
                                            <span><i class="fa-solid fa-star"></i></span>
                                            <p class="review-text">(4.8)</p>
                                        </div>
                                        <p class="box-text style2">
                                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Distinctio doloribus quas ipsam culpa eligendi iste consectetur ducimus officiis ipsa, in, aperiam quasi?.
                                        </p>
                                    </div>
                                    <div class="academic-meta-wrap">
                                        <div class="academic-meta">
                                            <a href="#" class="duration"><i class="fa-solid fa-clock"></i> 04/10/2025</a>
                                        </div>
                                        <a href="#" class="th-btn style-border1 th-icon">Ver</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- <section class="why-area why-bg position-relative space overflow-hidden">
        <div class="why-shape jump shape-mockup" data-left="0%" data-bottom="10%">
            <img src="assets/img/shape/why-1-1.png" alt="">
        </div>
        <div class="container">
            <div class="row gy-4">
                <div class="col-xl-8">
                    <div class="title-area text-center text-lg-start">
                        <span class="sub-title text-anim">WHY CHOOSEUS</span>
                        <h2 class="sec-title text-anim2">We help every student to <span class="d-block"> stantout from the
                                rest</span></h2>
                    </div>
                    <div class="row gy-60">
                        <!--==============================
                        Why Choose Us Area
                        ==============================-->
                        <div class="col-lg-6 col-md-6">
                            <div class="why-card wow fadeInUp" data-wow-delay=".2s">
                                <div class="why-content">
                                    <div class="why-titlebox">
                                        <span class="why-number position-relative">1</span>
                                        <h3 class="box-title">
                                            <a href="about.html">Get a Top-Tier Global Education</a>
                                        </h3>
                                    </div>
                                    <div class="box-text-wrap">
                                        <p class="box-text">A Kingdom perspective is integrated into your studies and woven through the entire stadum experience.</p>
                                    </div>
                                </div>
                                <a href="about.html" class="th-btn style-border1 th-icon mt-40">Explore More</a>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <div class="why-card wow fadeInUp" data-wow-delay=".4s">
                                <div class="why-content">
                                    <div class="why-titlebox">
                                        <span class="why-number position-relative">2</span>
                                        <h3 class="box-title">
                                            <a href="about.html">Join a Spiritually Vibrant Campus Community</a>
                                        </h3>
                                    </div>
                                    <div class="box-text-wrap">
                                        <p class="box-text">Opportunities for faith and fellowship are all around, from chapel worship and dorm devotions to communal meals, clubs and activities.</p>
                                    </div>
                                </div>
                                <a href="about.html" class="th-btn style-border1 th-icon mt-40">Explore More</a>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <div class="why-card wow fadeInUp" data-wow-delay=".6s">
                                <div class="why-content">
                                    <div class="why-titlebox">
                                        <span class="why-number position-relative">3</span>
                                        <h3 class="box-title">
                                            <a href="about.html">Be Prepared for a Thriving Career</a>
                                        </h3>
                                    </div>
                                    <div class="box-text-wrap">
                                        <p class="box-text">A Kingdom perspective is integrated into your studies and woven through the entire stadum experience.</p>
                                    </div>
                                </div>
                                <a href="about.html" class="th-btn style-border1 th-icon mt-40">Explore More</a>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <div class="why-card wow fadeInUp" data-wow-delay=".8s">
                                <div class="why-content">
                                    <div class="why-titlebox">
                                        <span class="why-number position-relative">4</span>
                                        <h3 class="box-title">
                                            <a href="about.html">Experience a Cost-Competitive Education</a>
                                        </h3>
                                    </div>
                                    <div class="box-text-wrap">
                                        <p class="box-text">Opportunities for faith and fellowship are all around, from chapel worship and dorm devotions to communal meals, clubs and activities.</p>
                                    </div>
                                </div>
                                <a href="about.html" class="th-btn style-border1 th-icon mt-40">Explore More</a>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="why-video">
                        <div class="why-video-bg overflow-hidden gsap-parallax">
                            <img src="assets/img/why/why-video1-1.jpg" alt="image">
                            <div class="why-video-btn">
                                <a href="https://www.youtube.com/watch?v=_sI_Ps7JSEk" class="play-btn popup-video">
                                    <i class="fa-sharp fa-solid fa-play"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    {{-- <section class="campus overflow-hidden space">
        <div class="campus-shape jump shape-mockup  d-none d-xxl-block" data-bottom="22%" data-right="5%">
            <img src="assets/img/shape/campus-1-1.png" alt="shape">
        </div>
        <div class="container">
            <div class="row justify-content-lg-between justify-content-center align-items-center">
                <div class="col-lg-8 col-12">
                    <div class="title-area text-center text-lg-start">
                        <span class="sub-title text-anim">EXPERIENCE STADUM</span>
                        <h2 class="sec-title text-anim2">Campus Life</h2>
                    </div>
                </div>
                <div class="col-auto align-self-end">
                    <div class="sec-btn">
                        <a href="campus.html" class="th-btn style-border1 th-icon wow fadeInUp" data-wow-delay=".2s"> Explore All</a>
                    </div>
                </div>
            </div>
            <div class="row gy-5 justify-content-center">
                <div class="col-xl-4 col-lg-6">
                    <div class="campus-card wow fadeInLeft" data-wow-delay=".2s">
                        <div class="campus-img global-img">
                            <a href="campus.html" class="d-block position-relative">
                                <img src="assets/img/campus/campus-1-1.jpg" alt="campus image" class="img-1">
                            </a>
                        </div>
                        <div class="campus-content">
                            <h3 class="box-title">
                                <a href="campus.html">Mentor Lecture</a>
                            </h3>
                            <p class="box-text">Schedule a personalized tour of our Ancaster, Ontario campus and a one-on-one meeting with an Admissions Counsellor. Daily visits are offered regularly to accommodate your schedule.</p>
                        </div>
                        <a href="campus.html" class="th-btn style-border1 th-icon">View The Campus</a>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-6">
                    <div class="campus-card wow fadeInLeft" data-wow-delay=".4s">
                        <div class="campus-img global-img">
                            <a href="campus.html" class="d-block position-relative">
                                <img src="assets/img/campus/campus-1-2.jpg" alt="campus image" class="img-1">
                            </a>
                        </div>
                        <div class="campus-content">
                            <h3 class="box-title">
                                <a href="campus.html">Group Study in Campus</a>
                            </h3>
                            <p class="box-text">Our scheduled visits are pre-planned days that are specially catered to the different interests of each student. Tour campus and connect with staff, faculty and current students to help discover your place.</p>
                        </div>
                        <a href="campus.html" class="th-btn style-border1 th-icon">View The Campus</a>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-6">
                    <div class="campus-card wow fadeInLeft" data-wow-delay=".6s">
                        <div class="campus-img global-img">
                            <a href="campus.html" class="d-block position-relative">
                                <img src="assets/img/campus/campus-1-3.jpg" alt="campus image" class="img-1">
                            </a>
                        </div>
                        <div class="campus-content">
                            <h3 class="box-title">
                                <a href="campus.html">Art & Culture</a>
                            </h3>
                            <p class="box-text">Can’t make it to campus? Explore parts of Redeemer’s 70-acre campus through a series of short videos and get a glimpse of what it has to offer—wherever and whenever works best for you.</p>
                        </div>
                        <a href="campus.html" class="th-btn style-border1 th-icon">View The Campus</a>
                    </div>
                </div>

            </div>
        </div>
    </section> --}}
    {{-- <!--==============================
    Story Area
    ==============================-->
    <div class="story-area-1 overflow-hidden">
        <div class="container">
            <div class="row justify-content-lg-between justify-content-center align-items-center">
                <div class="col-lg-8 col-12">
                    <div class="title-area text-center text-lg-start">
                        <span class="sub-title text-anim">STUDENT STORIES</span>
                        <h2 class="sec-title text-anim2">Our Student Stories</h2>
                    </div>
                </div>
                <div class="col-auto align-self-end">
                    <div class="sec-btn wow fadeInUp" data-wow-delay=".3s">
                        <a href="program.html" class="th-btn style-border1 th-icon"> Discover More Stories </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="swiper th-slider story-slider1" id="storySlider1" data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"1400":{"slidesPerView":"5"},"1200":{"slidesPerView":"4"},"992":{"slidesPerView":"4"},"768":{"slidesPerView":"3"},"576":{"slidesPerView":"2"}},"spaceBetween":"0"}'>
                <div class="swiper-wrapper">
                    <!--==============================
                    Story Area
                    ==============================-->
                    <div class="swiper-slide">
                        <div class="story-card">
                            <div class="box-img">
                                <img src="assets/img/story/story-1-1.jpg" alt="img">
                            </div>
                            <div class="story-content">

                                <h3 class="box-title"><a href="program.html">Alex Smith</a></h3>
                            </div>
                            <div class="story-content hover-style">
                                <div class="quote-icon">
                                    <img src="assets/img/icon/quote.svg" alt="">
                                </div>
                                <p class="box-text">"Stadum University’s humanities program is helping me develop the perspective, critical thinking and adaptability I need to navigate and contribute to this changing world."</p>
                                <h3 class="box-title"><a href="program.html">Alex Smith</a></h3>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="story-card">
                <div class="story-thumb">
                    <img src="assets/img/story/story-1-1.jpg" alt="Icon">
                </div>
                <div class="story-content text-center">
                    <h3 class="box-title text-white">
                        <a href="program.html">Alex Smith</a>
                    </h3>
                </div>
                <div class="story-content hover-style text-center">
                    <span class="quote-icon">
                        <img src="assets/img/icon/quote.svg" alt="">
                    </span>
                    <p class="box-text text-white">"Stadum University’s humanities program is helping me develop the perspective, critical thinking and adaptability I need to navigate and contribute to this changing world."</p>
                    <h3 class="box-title text-white">
                        <a href="program.html">Alex Smith</a>
                    </h3>
                </div>
            </div> -->

                    <div class="swiper-slide">
                        <div class="story-card">
                            <div class="box-img">
                                <img src="assets/img/story/story-1-2.jpg" alt="img">
                            </div>
                            <div class="story-content">

                                <h3 class="box-title"><a href="program.html">Brone Due</a></h3>
                            </div>
                            <div class="story-content hover-style">
                                <div class="quote-icon">
                                    <img src="assets/img/icon/quote.svg" alt="">
                                </div>
                                <p class="box-text">"Stadum University’s humanities program is helping me develop the perspective, critical thinking and adaptability I need to navigate and contribute to this changing world."</p>
                                <h3 class="box-title"><a href="program.html">Brone Due</a></h3>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="story-card">
                <div class="story-thumb">
                    <img src="assets/img/story/story-1-2.jpg" alt="Icon">
                </div>
                <div class="story-content text-center">
                    <h3 class="box-title text-white">
                        <a href="program.html">Brone Due</a>
                    </h3>
                </div>
                <div class="story-content hover-style text-center">
                    <span class="quote-icon">
                        <img src="assets/img/icon/quote.svg" alt="">
                    </span>
                    <p class="box-text text-white">"Stadum University’s humanities program is helping me develop the perspective, critical thinking and adaptability I need to navigate and contribute to this changing world."</p>
                    <h3 class="box-title text-white">
                        <a href="program.html">Brone Due</a>
                    </h3>
                </div>
            </div> -->

                    <div class="swiper-slide">
                        <div class="story-card">
                            <div class="box-img">
                                <img src="assets/img/story/story-1-3.jpg" alt="img">
                            </div>
                            <div class="story-content">

                                <h3 class="box-title"><a href="program.html">Moumita Mira</a></h3>
                            </div>
                            <div class="story-content hover-style">
                                <div class="quote-icon">
                                    <img src="assets/img/icon/quote.svg" alt="">
                                </div>
                                <p class="box-text">"Stadum University’s humanities program is helping me develop the perspective, critical thinking and adaptability I need to navigate and contribute to this changing world."</p>
                                <h3 class="box-title"><a href="program.html">Moumita Mira</a></h3>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="story-card">
                <div class="story-thumb">
                    <img src="assets/img/story/story-1-3.jpg" alt="Icon">
                </div>
                <div class="story-content text-center">
                    <h3 class="box-title text-white">
                        <a href="program.html">Moumita Mira</a>
                    </h3>
                </div>
                <div class="story-content hover-style text-center">
                    <span class="quote-icon">
                        <img src="assets/img/icon/quote.svg" alt="">
                    </span>
                    <p class="box-text text-white">"Stadum University’s humanities program is helping me develop the perspective, critical thinking and adaptability I need to navigate and contribute to this changing world."</p>
                    <h3 class="box-title text-white">
                        <a href="program.html">Moumita Mira</a>
                    </h3>
                </div>
            </div> -->

                    <div class="swiper-slide">
                        <div class="story-card">
                            <div class="box-img">
                                <img src="assets/img/story/story-1-4.jpg" alt="img">
                            </div>
                            <div class="story-content">

                                <h3 class="box-title"><a href="program.html">Maya Lily</a></h3>
                            </div>
                            <div class="story-content hover-style">
                                <div class="quote-icon">
                                    <img src="assets/img/icon/quote.svg" alt="">
                                </div>
                                <p class="box-text">"Stadum University’s humanities program is helping me develop the perspective, critical thinking and adaptability I need to navigate and contribute to this changing world."</p>
                                <h3 class="box-title"><a href="program.html">Maya Lily</a></h3>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="story-card">
                <div class="story-thumb">
                    <img src="assets/img/story/story-1-4.jpg" alt="Icon">
                </div>
                <div class="story-content text-center">
                    <h3 class="box-title text-white">
                        <a href="program.html">Maya Lily</a>
                    </h3>
                </div>
                <div class="story-content hover-style text-center">
                    <span class="quote-icon">
                        <img src="assets/img/icon/quote.svg" alt="">
                    </span>
                    <p class="box-text text-white">"Stadum University’s humanities program is helping me develop the perspective, critical thinking and adaptability I need to navigate and contribute to this changing world."</p>
                    <h3 class="box-title text-white">
                        <a href="program.html">Maya Lily</a>
                    </h3>
                </div>
            </div> -->

                    <div class="swiper-slide">
                        <div class="story-card">
                            <div class="box-img">
                                <img src="assets/img/story/story-1-5.jpg" alt="img">
                            </div>
                            <div class="story-content">

                                <h3 class="box-title"><a href="program.html">Sony & Ovi</a></h3>
                            </div>
                            <div class="story-content hover-style">
                                <div class="quote-icon">
                                    <img src="assets/img/icon/quote.svg" alt="">
                                </div>
                                <p class="box-text">"Stadum University’s humanities program is helping me develop the perspective, critical thinking and adaptability I need to navigate and contribute to this changing world."</p>
                                <h3 class="box-title"><a href="program.html">Sony & Ovi</a></h3>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="story-card">
                <div class="story-thumb">
                    <img src="assets/img/story/story-1-5.jpg" alt="Icon">
                </div>
                <div class="story-content text-center">
                    <h3 class="box-title text-white">
                        <a href="program.html">Sony & Ovi</a>
                    </h3>
                </div>
                <div class="story-content hover-style text-center">
                    <span class="quote-icon">
                        <img src="assets/img/icon/quote.svg" alt="">
                    </span>
                    <p class="box-text text-white">"Stadum University’s humanities program is helping me develop the perspective, critical thinking and adaptability I need to navigate and contribute to this changing world."</p>
                    <h3 class="box-title text-white">
                        <a href="program.html">Sony & Ovi</a>
                    </h3>
                </div>
            </div> -->

                    <div class="swiper-slide">
                        <div class="story-card">
                            <div class="box-img">
                                <img src="assets/img/story/story-1-1.jpg" alt="img">
                            </div>
                            <div class="story-content">

                                <h3 class="box-title"><a href="program.html">Alex Smith</a></h3>
                            </div>
                            <div class="story-content hover-style">
                                <div class="quote-icon">
                                    <img src="assets/img/icon/quote.svg" alt="">
                                </div>
                                <p class="box-text">"Stadum University’s humanities program is helping me develop the perspective, critical thinking and adaptability I need to navigate and contribute to this changing world."</p>
                                <h3 class="box-title"><a href="program.html">Alex Smith</a></h3>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="story-card">
                <div class="story-thumb">
                    <img src="assets/img/story/story-1-1.jpg" alt="Icon">
                </div>
                <div class="story-content text-center">
                    <h3 class="box-title text-white">
                        <a href="program.html">Alex Smith</a>
                    </h3>
                </div>
                <div class="story-content hover-style text-center">
                    <span class="quote-icon">
                        <img src="assets/img/icon/quote.svg" alt="">
                    </span>
                    <p class="box-text text-white">"Stadum University’s humanities program is helping me develop the perspective, critical thinking and adaptability I need to navigate and contribute to this changing world."</p>
                    <h3 class="box-title text-white">
                        <a href="program.html">Alex Smith</a>
                    </h3>
                </div>
            </div> -->

                    <div class="swiper-slide">
                        <div class="story-card">
                            <div class="box-img">
                                <img src="assets/img/story/story-1-2.jpg" alt="img">
                            </div>
                            <div class="story-content">

                                <h3 class="box-title"><a href="program.html">Brone Due</a></h3>
                            </div>
                            <div class="story-content hover-style">
                                <div class="quote-icon">
                                    <img src="assets/img/icon/quote.svg" alt="">
                                </div>
                                <p class="box-text">"Stadum University’s humanities program is helping me develop the perspective, critical thinking and adaptability I need to navigate and contribute to this changing world."</p>
                                <h3 class="box-title"><a href="program.html">Brone Due</a></h3>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="story-card">
                <div class="story-thumb">
                    <img src="assets/img/story/story-1-2.jpg" alt="Icon">
                </div>
                <div class="story-content text-center">
                    <h3 class="box-title text-white">
                        <a href="program.html">Brone Due</a>
                    </h3>
                </div>
                <div class="story-content hover-style text-center">
                    <span class="quote-icon">
                        <img src="assets/img/icon/quote.svg" alt="">
                    </span>
                    <p class="box-text text-white">"Stadum University’s humanities program is helping me develop the perspective, critical thinking and adaptability I need to navigate and contribute to this changing world."</p>
                    <h3 class="box-title text-white">
                        <a href="program.html">Brone Due</a>
                    </h3>
                </div>
            </div> -->

                    <div class="swiper-slide">
                        <div class="story-card">
                            <div class="box-img">
                                <img src="assets/img/story/story-1-3.jpg" alt="img">
                            </div>
                            <div class="story-content">

                                <h3 class="box-title"><a href="program.html">Moumita Mira</a></h3>
                            </div>
                            <div class="story-content hover-style">
                                <div class="quote-icon">
                                    <img src="assets/img/icon/quote.svg" alt="">
                                </div>
                                <p class="box-text">"Stadum University’s humanities program is helping me develop the perspective, critical thinking and adaptability I need to navigate and contribute to this changing world."</p>
                                <h3 class="box-title"><a href="program.html">Moumita Mira</a></h3>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="story-card">
                <div class="story-thumb">
                    <img src="assets/img/story/story-1-3.jpg" alt="Icon">
                </div>
                <div class="story-content text-center">
                    <h3 class="box-title text-white">
                        <a href="program.html">Moumita Mira</a>
                    </h3>
                </div>
                <div class="story-content hover-style text-center">
                    <span class="quote-icon">
                        <img src="assets/img/icon/quote.svg" alt="">
                    </span>
                    <p class="box-text text-white">"Stadum University’s humanities program is helping me develop the perspective, critical thinking and adaptability I need to navigate and contribute to this changing world."</p>
                    <h3 class="box-title text-white">
                        <a href="program.html">Moumita Mira</a>
                    </h3>
                </div>
            </div> -->

                    <div class="swiper-slide">
                        <div class="story-card">
                            <div class="box-img">
                                <img src="assets/img/story/story-1-4.jpg" alt="img">
                            </div>
                            <div class="story-content">

                                <h3 class="box-title"><a href="program.html">Maya Lily</a></h3>
                            </div>
                            <div class="story-content hover-style">
                                <div class="quote-icon">
                                    <img src="assets/img/icon/quote.svg" alt="">
                                </div>
                                <p class="box-text">"Stadum University’s humanities program is helping me develop the perspective, critical thinking and adaptability I need to navigate and contribute to this changing world."</p>
                                <h3 class="box-title"><a href="program.html">Maya Lily</a></h3>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="story-card">
                <div class="story-thumb">
                    <img src="assets/img/story/story-1-4.jpg" alt="Icon">
                </div>
                <div class="story-content text-center">
                    <h3 class="box-title text-white">
                        <a href="program.html">Maya Lily</a>
                    </h3>
                </div>
                <div class="story-content hover-style text-center">
                    <span class="quote-icon">
                        <img src="assets/img/icon/quote.svg" alt="">
                    </span>
                    <p class="box-text text-white">"Stadum University’s humanities program is helping me develop the perspective, critical thinking and adaptability I need to navigate and contribute to this changing world."</p>
                    <h3 class="box-title text-white">
                        <a href="program.html">Maya Lily</a>
                    </h3>
                </div>
            </div> -->

                    <div class="swiper-slide">
                        <div class="story-card">
                            <div class="box-img">
                                <img src="assets/img/story/story-1-5.jpg" alt="img">
                            </div>
                            <div class="story-content">

                                <h3 class="box-title"><a href="program.html">Sony & Ovi</a></h3>
                            </div>
                            <div class="story-content hover-style">
                                <div class="quote-icon">
                                    <img src="assets/img/icon/quote.svg" alt="">
                                </div>
                                <p class="box-text">"Stadum University’s humanities program is helping me develop the perspective, critical thinking and adaptability I need to navigate and contribute to this changing world."</p>
                                <h3 class="box-title"><a href="program.html">Sony & Ovi</a></h3>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="story-card">
                <div class="story-thumb">
                    <img src="assets/img/story/story-1-5.jpg" alt="Icon">
                </div>
                <div class="story-content text-center">
                    <h3 class="box-title text-white">
                        <a href="program.html">Sony & Ovi</a>
                    </h3>
                </div>
                <div class="story-content hover-style text-center">
                    <span class="quote-icon">
                        <img src="assets/img/icon/quote.svg" alt="">
                    </span>
                    <p class="box-text text-white">"Stadum University’s humanities program is helping me develop the perspective, critical thinking and adaptability I need to navigate and contribute to this changing world."</p>
                    <h3 class="box-title text-white">
                        <a href="program.html">Sony & Ovi</a>
                    </h3>
                </div>
            </div> -->

                    <div class="swiper-slide">
                        <div class="story-card">
                            <div class="box-img">
                                <img src="assets/img/story/story-1-1.jpg" alt="img">
                            </div>
                            <div class="story-content">

                                <h3 class="box-title"><a href="program.html">Alex Smith</a></h3>
                            </div>
                            <div class="story-content hover-style">
                                <div class="quote-icon">
                                    <img src="assets/img/icon/quote.svg" alt="">
                                </div>
                                <p class="box-text">"Stadum University’s humanities program is helping me develop the perspective, critical thinking and adaptability I need to navigate and contribute to this changing world."</p>
                                <h3 class="box-title"><a href="program.html">Alex Smith</a></h3>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="story-card">
                <div class="story-thumb">
                    <img src="assets/img/story/story-1-1.jpg" alt="Icon">
                </div>
                <div class="story-content text-center">
                    <h3 class="box-title text-white">
                        <a href="program.html">Alex Smith</a>
                    </h3>
                </div>
                <div class="story-content hover-style text-center">
                    <span class="quote-icon">
                        <img src="assets/img/icon/quote.svg" alt="">
                    </span>
                    <p class="box-text text-white">"Stadum University’s humanities program is helping me develop the perspective, critical thinking and adaptability I need to navigate and contribute to this changing world."</p>
                    <h3 class="box-title text-white">
                        <a href="program.html">Alex Smith</a>
                    </h3>
                </div>
            </div> -->

                </div>
            </div>
        </div>
    </div> --}}
    {{-- <!--==============================
    Event Area 1
    ==============================-->
    <section class="event-area-1 position-relative overflow-hidden space" id="event-sec">
        <div class="event-shape shape-mockup d-none d-xxl-block" data-top="0%" data-left="0%">
            <img src="assets/img/shape/shape-2.png" alt="">
        </div>
        <div class="event-shape jump shape-mockup  d-none d-xxl-block" data-bottom="0%" data-left="3%">
            <img src="assets/img/shape/event-1-1.png" alt="">
        </div>
        <div class="container">
            <div class="row justify-content-lg-between justify-content-center align-items-center">
                <div class="col-lg-8 col-12">
                    <div class="title-area text-center text-lg-start">
                        <span class="sub-title text-anim">STUDENT EVENTS</span>
                        <h2 class="sec-title text-anim2">Alumni Events</h2>
                    </div>
                </div>
                <div class="col-auto align-self-end">
                    <div class="sec-btn wow fadeInUp" data-wow-delay=".3s">
                        <a href="event.html" class="th-btn style-border1 th-icon">Explore All</a>
                    </div>
                </div>
            </div>
            <div class="event-card-wrap">
                <div class="event-card wow fadeInUp" data-wow-delay=".2s">
                    <div class="event-card-img global-img">
                        <img src="assets/img/event/event-1-1.jpg" alt="event">
                        <p class="event-card-tag"><span class="tag-number">12</span>Jan</p>
                    </div>
                    <div class="event-content">
                        <div class="event-wrapp">
                            <h3 class="box-title text-anim2"><a href="event-details.html">Programming languages for a better world</a></h3>
                            <p class="box-text">Come for a quick session on how this question has crucially helped humanity with achieving one of its most impressive feats yet: orchestrating electric currents.</p>
                            <div class="blog-meta">
                                <a class="location" href="#">
                                    <i class="fa-solid fa-location-dot"></i>
                                    25 Circular Road, New York City </a>
                                <a class="date" href="#">
                                    <i class="fa-regular fa-calendar-days"></i>
                                    25.02.2025 </a>
                                <a class="time" href="#">
                                    <i class="fa-solid fa-clock"></i>
                                    09:00am - 12:00pm </a>
                            </div>
                        </div>
                        <div class="btn-wrap">
                            <a class="th-btn style-border1 th-icon" href="event-details.html">Details</a>
                        </div>
                    </div>
                </div>

                <div class="event-card wow fadeInUp" data-wow-delay=".4s">
                    <div class="event-card-img global-img">
                        <img src="assets/img/event/event-1-2.jpg" alt="event">
                        <p class="event-card-tag"><span class="tag-number">07</span>Feb</p>
                    </div>
                    <div class="event-content">
                        <div class="event-wrapp">
                            <h3 class="box-title text-anim2"><a href="event-details.html">Center for Subjectivity Research 2024</a></h3>
                            <p class="box-text">Center for subjectivity research at the university of copenhagen was established in 2002 on the basis of a grant from national research.</p>
                            <div class="blog-meta">
                                <a class="location" href="#">
                                    <i class="fa-solid fa-location-dot"></i>
                                    25 Circular Road, New York City </a>
                                <a class="date" href="#">
                                    <i class="fa-regular fa-calendar-days"></i>
                                    03.08.2025 </a>
                                <a class="time" href="#">
                                    <i class="fa-solid fa-clock"></i>
                                    10:00am - 03:20pm </a>
                            </div>
                        </div>
                        <div class="btn-wrap">
                            <a class="th-btn style-border1 th-icon" href="event-details.html">Details</a>
                        </div>
                    </div>
                </div>

                <div class="event-card wow fadeInUp" data-wow-delay=".6s">
                    <div class="event-card-img global-img">
                        <img src="assets/img/event/event-1-3.jpg" alt="event">
                        <p class="event-card-tag"><span class="tag-number">22</span>Sep</p>
                    </div>
                    <div class="event-content">
                        <div class="event-wrapp">
                            <h3 class="box-title text-anim2"><a href="event-details.html">The Future of Archives in the Digital Age</a></h3>
                            <p class="box-text">This talk explores the potential future of archives in the digital age, using one of the oldest philosophical archives and research institutes for philosophy in Germany</p>
                            <div class="blog-meta">
                                <a class="location" href="#">
                                    <i class="fa-solid fa-location-dot"></i>
                                    25 Circular Road, New York City </a>
                                <a class="date" href="#">
                                    <i class="fa-regular fa-calendar-days"></i>
                                    14.11.2025 </a>
                                <a class="time" href="#">
                                    <i class="fa-solid fa-clock"></i>
                                    11:00am - 04:00pm </a>
                            </div>
                        </div>
                        <div class="btn-wrap">
                            <a class="th-btn style-border1 th-icon" href="event-details.html">Details</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section> --}}
    <section class="apply-stadum-area bg-title position-relative space overflow-hidden">
        <div class="container">
            <div class="row gy-4 align-items-center justify-content-between">
                <div class="col-xl-6 order-1 order-xl-0">
                    <div class="apply-stadum-titlebox title-area ">
                        <div class="sec-title-wrap">
                            <span class="sub-title text-anim">SECCIÓN</span>
                            <h2 class="sec-title text-white text-anim2">
                                Información de Admisiones
                            </h2>
                        </div>
                        <div class="box-text-wrap">
                            <p class="box-text text-white mt-25 wow fadeInUp" data-wow-delay=".2s">
                                Este es un mensaje importante para todos los estudiantes interesados en unirse a nuestra institución. Aquí encontrará información clave sobre el proceso de admisión, requisitos y fechas importantes. Le recomendamos revisar cuidadosamente todos los detalles para asegurarse de cumplir con los criterios necesarios y no perderse ninguna oportunidad.
                            <p>
                        </div>
                    </div>
                    <div class="apply-stadum-wrapp">
                        <div class="apply-stadum-box">
                            <div class="checklist">
                                <ul class="list-unstyled">
                                    <li class="wow fadeInUp" data-wow-delay=".2s"> Opción de Pregrado</li>
                                    <li class="wow fadeInUp" data-wow-delay=".3s"> Opción de Posgrado</li>
                                    <li class="wow fadeInUp" data-wow-delay=".4s"> Oportunidades de Becas </li>
                                </ul>
                            </div>
                            <div class="checklist">
                                <ul class="list-unstyled">
                                    <li class="wow fadeInUp" data-wow-delay=".5s"> Opción de Transferencia</li>
                                    <li class="wow fadeInUp" data-wow-delay=".6s"> Opción de Ayuda Financiera</li>
                                </ul>
                            </div>
                        </div>
                        <div class="apply-stadum-action th-btn-wrap wow fadeInUp" data-wow-delay=".10s">
                            <a href="#" class="th-btn th-icon white-hover">
                                Mas Información
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 order-0 order-xl-1">
                    <div class="apply-stadum-thumb reveal">
                        <img src="https://images.unsplash.com/photo-1606761568499-6d2451b23c66?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="image" class="">
                    </div>
                </div>
            </div>
        </div>
        <span class="apply-stadum-shape wow fadeInRight" data-wow-delay=".3s"></span>
    </section>
    {{-- <section class="chancellor-area position-relative space">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-xl-6">
                    <div class="chancellor-thumb">
                        <img src="assets/img/chancellor/chancellor-img-home-1.jpg" alt="image">
                        <div class="ripple-shape style2">
                            <span class="ripple-1"></span>
                            <span class="ripple-2"></span>
                            <span class="ripple-3"></span>
                            <span class="ripple-4"></span>
                            <span class="ripple-5"></span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="chancellor-wrapp">
                        <div class="chancellor-titlebox title-area">
                            <span class="sub-title text-anim">OUR CHANCELLOR & LECTURE</span>
                            <h2 class="sec-title text-anim2">Chancellor & Lecturer
                            </h2>
                            <p class="box-text mt-25 wow fadeInUp" data-wow-delay=".4s">A place to provide
                                students with enough knowledge and skills in a complex world. Are you looking for
                                exceptional
                                education experience? Stadum might be the place for you.</p>
                        </div>
                        <div class="chancellor-content">
                            <!--==============================
                            Skill Area Home 1
                            ==============================-->

                            <div class="skill-feature wow fadeInUp" data-wow-delay=".2s">
                                <h3 class="skill-feature-title">Faculty Skilled</h3>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 95%;">
                                        <div class="progress-value">95%</div>
                                    </div>
                                </div>
                            </div>
                            <div class="skill-feature wow fadeInUp" data-wow-delay=".4s">
                                <h3 class="skill-feature-title">Computer Science</h3>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 98%;">
                                        <div class="progress-value">98%</div>
                                    </div>
                                </div>
                            </div>
                            <div class="skill-feature wow fadeInUp" data-wow-delay=".6s">
                                <h3 class="skill-feature-title">Communication</h3>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 95%;">
                                        <div class="progress-value">95%</div>
                                    </div>
                                </div>
                            </div>
                            <div class="chancellor-bottom">
                                <div class="chancellor-action">
                                    <a href="contact.html" class="th-btn th-icon">Lecturer at Faculty</a>
                                </div>
                                <div class="chancellor-signature-box text-sm-center">
                                    <p class="box-text">Prof. Dr. Simons Doe, Ph.D</p>
                                    <img src="assets/img/icon/signature.png" class="chancellor-signature" alt="signature">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    {{-- <!--==============================
    Marquee Area
    ==============================-->
    <div class="marquee-area space-bottom overflow-hidden">
        <div class="container-fluid p-0">
            <div class="swiper th-slider marquee-slider1" data-slider-options='{"breakpoints":{"0":{"slidesPerView":"auto"}},"autoplay":{"delay":0,"disableOnInteraction":false},"noSwiping":"true","speed":10000,"spaceBetween":40}'>
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="marquee-card">
                            <div class="color-masking">
                                <img src="assets/img/icon/open-book.svg" alt="icon">
                            </div>
                            <a target="_blank" href="#">CREATION</a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="marquee-card">
                            <div class="color-masking">
                                <img src="assets/img/icon/scollarship.svg" alt="icon">
                            </div>
                            <a target="_blank" href="#">DISCOVER</a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="marquee-card">
                            <div class="color-masking">
                                <img src="assets/img/icon/open-book.svg" alt="icon">
                            </div>
                            <a target="_blank" href="#">INNOVATE</a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="marquee-card">
                            <div class="color-masking">
                                <img src="assets/img/icon/open-book.svg" alt="icon">
                            </div>
                            <a target="_blank" href="#">EDUCATION</a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="marquee-card">
                            <div class="color-masking">
                                <img src="assets/img/icon/scollarship.svg" alt="icon">
                            </div>
                            <a target="_blank" href="#">CASE STUDIES</a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="marquee-card">
                            <div class="color-masking">
                                <img src="assets/img/icon/open-book.svg" alt="icon">
                            </div>
                            <a target="_blank" href="#">CREATION</a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="marquee-card">
                            <div class="color-masking">
                                <img src="assets/img/icon/open-book.svg" alt="icon">
                            </div>
                            <a target="_blank" href="#">DISCOVER</a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="marquee-card">
                            <div class="color-masking">
                                <img src="assets/img/icon/scollarship.svg" alt="icon">
                            </div>
                            <a target="_blank" href="#">INNOVATE</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- <div class="community-area space" data-bg-src="assets/img/bg/community-home-1.png">
        <div class="container">
            <div class="row">
                <div class="col-xxl-7">
                    <div class="community-wrap">
                        <div class="title-area">
                            <span class="sub-title text-anim">INTERESTED IN JOINING WITH US?</span>
                            <h2 class="sec-title text-anim2 mb-55">Join Us For Information About New Student Admission</h2>
                            <div class="box-text-wrap mt-30 wow fadeInUp" data-wow-delay=".3s">
                                <p class="box-text">At stadum eductin, we redefine consultancy through a dynamic fusion of innovation, expertise, and strategic vision. Our dedicated team is committed to delivering tailored solutions that transcend traditional consulting boundaries.</p>
                            </div>
                        </div>
                        <div class="btn-wrap wow fadeInUp" data-wow-delay=".4s">
                            <a href="contact.html" class="th-btn th-icon"> Join Community </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!--==============================
    Blog Area 1
    ==============================-->
    <section class="blog-area-1 overflow-hidden space" id="blog-sec">
        <div class="container">
            <div class="row justify-content-lg-between justify-content-center align-items-center">
                <div class="col-lg-8 col-12">
                    <div class="title-area text-center text-lg-start">
                        <span class="sub-title text-anim">SECCIÓN</span>
                        <h2 class="sec-title text-anim2">Noticias</h2>
                    </div>
                </div>
                <div class="col-auto align-self-end">
                    <div class="sec-btn wow fadeInUp" data-wow-delay=".3s">
                        <a href="blog.html" class="th-btn style-border1 th-icon"> Ver Todas </a>
                    </div>
                </div>
            </div>
            <div class="row gy-4">
                <div class="col-lg-4">
                    <div class="blog-card wow fadeInUp">
                        <div class="blog-img position-relative">
                            <a href="#">
                                <div class="blog-img-box position-relative overflow-hidden">
                                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=1742&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="blog image">
                                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=1742&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="blog image">
                                </div>
                            </a>
                            <div class="blog-date">
                                <h5 class="blog-date-title">24</h5>
                                <p class="blog-date-text">FEB,2025</p>
                            </div>
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <a class="author" href="blog.html">
                                    <span class="author-icon"><img src="https://icons.veryicon.com/png/o/miscellaneous/standard/avatar-15.png" alt="img"></span>Autor
                                </a>
                            </div>
                            <h3 class="box-title">
                                <a href="blog-details.html">
                                    Nombre de la noticia
                                </a>
                            </h3>
                            <p class="box-text">
                                Aqui va una pequeña descripcion de la noticia para que los usuarios tengan una idea de su contenido.
                            </p>
                            <div class="btn-wrap">
                                <a href="blog-details.html" class="th-btn style-border1 th-icon">
                                    Leer Más
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog-card wow fadeInUp">
                        <div class="blog-img position-relative">
                            <a href="#">
                                <div class="blog-img-box position-relative overflow-hidden">
                                    <img src="https://images.unsplash.com/photo-1561089489-f13d5e730d72?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="blog image">
                                    <img src="https://images.unsplash.com/photo-1561089489-f13d5e730d72?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="blog image">
                                </div>
                            </a>
                            <div class="blog-date">
                                <h5 class="blog-date-title">04</h5>
                                <p class="blog-date-text">SET,2025</p>
                            </div>
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <a class="author" href="blog.html">
                                    <span class="author-icon"><img src="https://icons.veryicon.com/png/o/miscellaneous/standard/avatar-15.png" alt="img"></span>Autor
                                </a>
                            </div>
                            <h3 class="box-title">
                                <a href="blog-details.html">
                                    Nombre de la noticia
                                </a>
                            </h3>
                            <p class="box-text">
                                Aqui va una pequeña descripcion de la noticia para que los usuarios tengan una idea de su contenido.
                            </p>
                            <div class="btn-wrap">
                                <a href="blog-details.html" class="th-btn style-border1 th-icon">
                                    Leer Más
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--==============================
    Faq Area 1
    ==============================-->
    <section class="faq-area-1 position-relative space overflow-hidden">
        {{-- <div class="faq-shape1 shape-mockup" data-top="0%" data-left="0%">
            <img src="https://images.unsplash.com/photo-1494809610410-160faaed4de0?q=80&w=688&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="shape">
        </div> --}}
        <div class="ripple-shape d-none d-xl-block">
            <span class="ripple-1"></span>
            <span class="ripple-2"></span>
            <span class="ripple-3"></span>
            <span class="ripple-4"></span>
            <span class="ripple-5"></span>
        </div>
        <div class="container">
            <div class="row gy-30 gx-30 align-items-center justify-content-center">
                <div class="col-12">
                    <div class="faq-content">
                        <div class="faq-wrap">
                            <div class="title-area">
                                <span class="sub-title text-anim">SECCIÓN</span>
                                <h2 class="sec-title text-anim2">Preguntas Frecuentes</h2>
                                <p class="box-text mt-20 wow fadeInUp" data-wow-delay=".3s">Estamos comprometidos a dejar el mundo en un lugar mejor. Buscamos nuevas tecnologías, fomentamos la creatividad</p>
                            </div>
                        </div>
                        <div class="faq-box">
                            <!--==============================
                            Faq Area
                            ==============================-->
                            <div class="faq-wrap1">
                                <div class="accordion" id="faqAccordion">
                                    <div class="accordion-card wow fadeInUp" data-wow-delay=".1s">
                                        <div class="accordion-header" id="collapse-item-1">
                                            <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#collapse-1" aria-expanded="true" aria-controls="collapse-1">
                                                01. ¿Qué es la Escuela de Posgrado?
                                            </button>
                                        </div>
                                        <div id="collapse-1" class="accordion-collapse collapse show" aria-labelledby="collapse-item-1" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                <p class="faq-text">
                                                    La Escuela de Posgrado es una institución educativa dedicada a ofrecer programas de educación superior, como maestrías y doctorados, para profesionales que buscan especializarse y avanzar en sus carreras.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-card wow fadeInUp" data-wow-delay=".2s">
                                        <div class="accordion-header" id="collapse-item-2">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-2" aria-expanded="false" aria-controls="collapse-2">
                                                02. ¿Cuál es la misión de la Escuela de Posgrado?
                                            </button>
                                        </div>
                                        <div id="collapse-2" class="accordion-collapse collapse " aria-labelledby="collapse-item-2" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                <p class="faq-text">
                                                    La misión de la Escuela de Posgrado es formar profesionales altamente capacitados, mediante la oferta de programas académicos de calidad, que contribuyan al desarrollo sostenible de la sociedad y al avance del conocimiento en sus respectivas áreas.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-card wow fadeInUp" data-wow-delay=".3s">
                                        <div class="accordion-header" id="collapse-item-3">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-3" aria-expanded="false" aria-controls="collapse-3">
                                                03. ¿Qué servicios ofrece?
                                            </button>
                                        </div>
                                        <div id="collapse-3" class="accordion-collapse collapse " aria-labelledby="collapse-item-3" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                <p class="faq-text">
                                                    La Escuela de Posgrado ofrece una variedad de servicios, incluyendo asesoramiento académico, acceso a recursos de investigación, y oportunidades de networking con profesionales del sector. Nuestro objetivo es apoyar a nuestros estudiantes en su desarrollo profesional y académico.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus maxime nisi reiciendis magni. Animi sint asperiores, dicta atque doloremque, deserunt sed aliquam deleniti debitis adipisci consequatur temporibus mollitia tempora ducimus.
                                </p>
                                <div class="footer-info">
                                    <a href="#">
                                        <span class="footer-info-icon"><i class="fa-solid fa-location-dot"></i></span> Dirección de la Escuela de Posgrado
                                    </a>
                                    <a href="mailto:example@unu.edu.pe">
                                        <span class="footer-info-icon"><i class="fa-solid fa-envelope"></i></span> example@unu.edu.pe
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-auto">
                        <div class="widget widget_nav_menu footer-widget">
                            <h3 class="widget_title">SubMenu</h3>
                            <div class="menu-all-pages-container">
                                <ul class="menu">
                                    <li><a href="#">Opción 1</a></li>
                                    <li><a href="#">Opción 2</a></li>
                                    <li><a href="#">Opción 3</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-auto">
                        <div class="widget widget_nav_menu footer-widget">
                            <h3 class="widget_title">SubMenu</h3>
                            <div class="menu-all-pages-container">
                                <ul class="menu">
                                    <li><a href="#">Opción 1</a></li>
                                    <li><a href="#">Opción 2</a></li>
                                    <li><a href="#">Opción 3</a></li>
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
