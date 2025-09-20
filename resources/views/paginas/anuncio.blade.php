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
                            {{ $anuncio['titulo'] }}
                        </h1>
                        <ul class="breadcumb-menu">
                            <li><a href="{{ route('pagina.inicio') }}">Inicio</a></li>
                            <li>{{ $anuncio['titulo_corto'] }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--==============================
    Blog Area
    ==============================-->
    <section class="th-blog-wrapper blog-details space-top space-extra2-bottom overflow-hidden">
        <div class="container th-container2">
            <div class="row justify-content-center">
                <div class="col-xl-9">
                    <div class="th-blog blog-single">
                        <div class="blog-img">
                            <img src="{{ $anuncio['imagen'] }}" alt="{{ $anuncio['slug'] }}">
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <a href="javascript:void(0)"><i class="far fa-user"></i>Administrador</a>
                                <a href="javascript:void(0)"><i class="far fa-clock"></i>{{ $anuncio['fecha'] }}</a>
                            </div>
                            <p class="fs-18">
                                {!! \Illuminate\Support\Str::markdown($anuncio['descripcion_md']) !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.pagina>
