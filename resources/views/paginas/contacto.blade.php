<x-layouts.pagina>
    <!--==============================
    Breadcumb
    ============================== -->
    <div class="breadcumb-wrapper position-relative " data-bg-src="{{ asset('media/page/breadcrumb-shep.png') }}">
        <div class="breadcumb-banner">
            <img src="https://images.unsplash.com/photo-1755867712452-871192ab3b2e?q=80&w=1752&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="bg-banner">
        </div>
        <div class="container th-container4">
            <div class="row">
                <div class="col-xxl-9">
                    <div class="breadcumb-content">
                        <h1 class="breadcumb-title">
                            Contáctenos
                        </h1>
                        <ul class="breadcumb-menu">
                            <li><a href="{{ route('pagina.inicio') }}">Inicio</a></li>
                            <li>Contáctenos</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--==============================
    Contact Info Area
    ==============================-->
    <div class="space overflow-hidden">
        <div class="container th-container4">
            <div class="row justify-content-between">
                <div class="col-lg-6 col-xxl-6">
                    <div class="title-area">
                        <h2 class="sec-title">
                            Información de Contacto
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row g-3 justify-content-center">
                <div class="col-lg-6 col-xl-7">
                    <div class="contact-feature">
                        <div class="box-icon">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div class="media-body">
                            <h3 class="box-title">Dirección</h3>
                            <p class="box-text">Carretera Federico Basadre Km. 6.00</p>
                        </div>
                    </div>
                    <div class="contact-feature">
                        <div class="box-icon">
                            <i class="fa-solid fa-phone-volume"></i>
                        </div>
                        <div class="media-body">
                            <h3 class="box-title">Números de Teléfono</h3>
                            <p class="box-text">
                                <a href="tel:+51999999999">+51 999999999</a>
                                <a href="tel:+51988888888">+51 988888888</a>
                            </p>
                        </div>
                    </div>
                    <div class="contact-feature">
                        <div class="box-icon">
                            <i class="fa-light fa-envelope"></i>
                        </div>
                        <div class="media-body">
                            <h3 class="box-title">Correo Electrónico</h3>
                            <p class="box-text">
                                <a href="mailto:mesadepartes_epg@unu.edu.pe">mesadepartes_epg@unu.edu.pe</a>
                                <a href="mailto:admision_posgrado@unu.edu.pe">admision_posgrado@unu.edu.pe</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-5">
                    <div class="contact-image text-center">
                        <img src="https://plus.unsplash.com/premium_photo-1713296255442-e9338f42aad8?q=80&w=844&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--==============================
    Map Area
    ==============================-->
    <div class="">
        <div class="container-fluid">
            <div class="contact-map style3">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d478.3193654686672!2d-74.57722388561221!3d-8.395642429450357!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91a3bd9d902e45bb%3A0xd8e679989ac133be!2sEscuela%20de%20Posgrado%20UNU!5e0!3m2!1ses-419!2spe!4v1758379205967!5m2!1ses-419!2spe" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    <img src="assets/img/icon/location-dot.svg" alt="">
                </div>
            </div>
        </div>
    </div>
</x-layouts.pagina>
