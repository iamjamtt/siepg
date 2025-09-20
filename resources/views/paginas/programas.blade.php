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
                            {{ $detalle['titulo'] }}
                        </h1>
                        <ul class="breadcumb-menu">
                            <li><a href="{{ route('pagina.inicio') }}">Inicio</a></li>
                            <li>{{ $detalle['titulo'] }}</li>
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
                        <div class="blog-img text-center" style="background-color: #ffffff;">
                            <img src="{{ asset('media/page/cabecera-detalle.png') }}" alt="cabecera-detalle" style="max-width: 65%; height: auto;">
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <a href="javascript:void(0)"><i class="far fa-user"></i>Administrador</a>
                                <a href="javascript:void(0)"><i class="far fa-clock"></i>{{ $detalle['fecha'] }}</a>
                            </div>
                            <p class="fs-18">
                                {!! \Illuminate\Support\Str::markdown($detalle['descripcion_md']) !!}
                            </p>
                        </div>
                        @if (!empty($programas))
                            <div class="blog-content text-center" style="margin-top: 40px; margin-bottom: 20px;">
                                <div class="row g-5 justify-content-center" style="margin-top: 20px;">
                                    @foreach ($programas as $programa)
                                        <div class="col-md-4">
                                            <a href="{{ route('pagina.programa-detalle', ['slug_tipo' => $programa['slug_tipo'], 'slug' => $programa['slug']]) }}">
                                                <div class="th-product product-grid">
                                                    <div class="product-img">
                                                        <img src="{{ $programa['imagen'] }}" alt="Programa Académico">
                                                    </div>
                                                    <div class="product-content">
                                                        <span class="product-title fw-bold">
                                                            {{ $programa['nombre'] }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.pagina>
