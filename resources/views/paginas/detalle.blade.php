<x-layouts.pagina>
    <!--==============================
    Breadcumb
    ============================== -->
    <div class="breadcumb-wrapper position-relative bg-title">
        <div class="breadcumb-banner">
            <img src="https://images.unsplash.com/photo-1755867712452-871192ab3b2e?q=80&w=1752&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="bg-banner">
        </div>
        <div class="container th-container4">
            <div class="row">
                <div class="col-lg-6">
                    <div class="breadcumb-content">
                        <h1 class="breadcumb-title text-white">
                            {{ $detalle['titulo'] }}
                        </h1>
                        <ul class="breadcumb-menu">
                            <li><a href="{{ route('pagina.inicio') }}" class="text-white">Inicio</a></li>
                            @if (!empty($programa))
                                <li><a href="{{ route('pagina.programa', ['slug' => $programa['slug_tipo']]) }}" class="text-white">{{ $programa['tipo'] }}</a></li>
                            @endif
                            <li>{{ Str::limit($detalle['titulo'], 50) }}</li>
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
                            <img src="{{ asset('media/page/cabecera-detalle.png') }}" alt="cabecera-detalle" class="img-fluid" style="max-width: 65%; height: auto;">
                            <style>
                                @media (max-width: 800px) {
                                    .blog-img img {
                                        max-width: 100% !important;
                                    }
                                }
                            </style>
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
                        @if (!empty($autoridades))
                            <div class="blog-content text-center" style="margin-top: 40px; margin-bottom: 20px;">
                                <h3>ÓRGANOS DE GOBIERNO</h3>
                                <div class="row g-5 justify-content-center" style="margin-top: 20px;">
                                    @foreach ($autoridades as $autoridad)
                                        <div class="col-md-6">
                                            <img src="{{ $autoridad['foto'] }}" alt="{{ $autoridad['nombre'] }}" class="mb-3" style="max-width: 150px; border-radius: 50%;">
                                            <br>
                                            <strong>{{ $autoridad['nombre'] }}</strong>
                                            <br>
                                            {{ $autoridad['cargo'] }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if (!empty($directores))
                            <div class="blog-content text-center" style="margin-top: 80px; margin-bottom: 20px;">
                                <h3>DIRECTORES DE LAS UNIDADES DE POSGRADO</h3>
                                <div class="row g-5 justify-content-center" style="margin-top: 20px;">
                                    @foreach ($directores as $director)
                                        <div class="col-md-6">
                                            <img src="{{ $director['foto'] }}" alt="{{ $director['nombre'] }}" class="mb-3" style="max-width: 150px; border-radius: 50%;">
                                            <br>
                                            <strong>{{ $director['nombre'] }}</strong>
                                            <br>
                                            {{ $director['cargo'] }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if (!empty($reglamentos))
                            <div class="blog-content text-center" style="margin-top: 40px; margin-bottom: 20px;">
                                <div class="row g-5 justify-content-center" style="margin-top: 20px;">
                                    @foreach ($reglamentos as $reglamento)
                                        <div class="col-md-4">
                                            <a href="{{ $reglamento['archivo'] }}" target="_blank">
                                                <div class="th-product product-grid">
                                                    <div class="mb-3 text-center">
                                                        <img src="{{ $reglamento['icono'] }}" alt="{{ $reglamento['nombre'] }}" style="max-width: 100px; height: auto;">
                                                    </div>
                                                    <div class="product-content">
                                                        <p class="product-title fw-bold">
                                                            {{ $reglamento['nombre'] }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if (!empty($programa))
                            <ul class="nav nav-tabs mt-4" id="tabPrograma" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="introduccion-tab" data-bs-toggle="tab" data-bs-target="#tab-introduccion" type="button" role="tab" aria-controls="tab-introduccion" aria-selected="true">
                                        Introducción al programa
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="perfil-tab" data-bs-toggle="tab" data-bs-target="#tab-perfil" type="button" role="tab" aria-controls="tab-perfil" aria-selected="false">
                                        Perfil del egresado
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="requisitos-tab" data-bs-toggle="tab" data-bs-target="#tab-requisitos" type="button" role="tab" aria-controls="tab-requisitos" aria-selected="false">
                                        Requisitos
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="plan-estudios-tab" data-bs-toggle="tab" data-bs-target="#tab-plan-estudios" type="button" role="tab" aria-controls="tab-plan-estudios" aria-selected="false">
                                        Plan de estudios
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="costos-tab" data-bs-toggle="tab" data-bs-target="#tab-costos" type="button" role="tab" aria-controls="tab-costos" aria-selected="false">
                                        Costos
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content p-4 border border-top-0 bg-white rounded-bottom" id="tabProgramaContent">
                                <div class="tab-pane fade show active" id="tab-introduccion" role="tabpanel" aria-labelledby="introduccion-tab" tabindex="0">
                                    @if (!empty($detalle_introduccion['titulo']))
                                        <h5>{{ $detalle_introduccion['titulo'] }}</h5>
                                    @endif
                                    {!! \Illuminate\Support\Str::markdown($detalle_introduccion['descripcion_md']) !!}
                                    @if (!empty($detalle_introduccion['imagen']))
                                        <div class="row g-5 justify-content-center">
                                            <div class="col-md-10">
                                                <img src="{{ $detalle_introduccion['imagen'] }}" alt="Imagen relacionada" class="mb-3" style="width: 100%; height: auto; border-radius: 10px;">
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="tab-pane fade" id="tab-perfil" role="tabpanel" aria-labelledby="perfil-tab" tabindex="0">
                                    @if (!empty($detalle_perfil['titulo']))
                                        <h5>{{ $detalle_perfil['titulo'] }}</h5>
                                    @endif
                                    {!! \Illuminate\Support\Str::markdown($detalle_perfil['descripcion_md']) !!}
                                    @if (!empty($detalle_perfil['imagen']))
                                        <div class="row g-5 justify-content-center">
                                            <div class="col-md-10">
                                                <img src="{{ $detalle_perfil['imagen'] }}" alt="Imagen relacionada" class="mb-3" style="width: 100%; height: auto; border-radius: 10px;">
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="tab-pane fade" id="tab-requisitos" role="tabpanel" aria-labelledby="requisitos-tab" tabindex="0">
                                    @if (!empty($detalle_requisito['titulo']))
                                        <h5>{{ $detalle_requisito['titulo'] }}</h5>
                                    @endif
                                    {!! \Illuminate\Support\Str::markdown($detalle_requisito['descripcion_md']) !!}
                                    @if (!empty($detalle_requisito['imagen']))
                                        <div class="row g-5 justify-content-center">
                                            <div class="col-md-10">
                                                <img src="{{ $detalle_requisito['imagen'] }}" alt="Imagen relacionada" class="mb-3" style="width: 100%; height: auto; border-radius: 10px;">
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="tab-pane fade" id="tab-plan-estudios" role="tabpanel" aria-labelledby="plan-estudios-tab" tabindex="0">
                                    @if (!empty($detalle_plan['titulo']))
                                        <h5>{{ $detalle_plan['titulo'] }}</h5>
                                    @endif
                                    {!! \Illuminate\Support\Str::markdown($detalle_plan['descripcion_md']) !!}
                                    @if (!empty($detalle_plan['imagen']))
                                        <div class="row g-5 justify-content-center">
                                            <div class="col-md-10">
                                                <img src="{{ $detalle_plan['imagen'] }}" alt="Imagen relacionada" class="mb-3" style="width: 100%; height: auto; border-radius: 10px;">
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="tab-pane fade" id="tab-costos" role="tabpanel" aria-labelledby="costos-tab" tabindex="0">
                                    @if (!empty($detalle_costos['titulo']))
                                        <h5>{{ $detalle_costos['titulo'] }}</h5>
                                    @endif
                                    {!! \Illuminate\Support\Str::markdown($detalle_costos['descripcion_md']) !!}
                                    @if (!empty($detalle_costos['imagen']))
                                        <div class="row g-5 justify-content-center">
                                            <div class="col-md-10">
                                                <img src="{{ $detalle_costos['imagen'] }}" alt="Imagen relacionada" class="mb-3" style="width: 100%; height: auto; border-radius: 10px;">
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if (!empty($imagen))
                            <div class="blog-content text-center" style="margin-top: 20px; margin-bottom: 20px;">
                                <div class="row g-5 justify-content-center" style="margin-top: 20px;">
                                    <div class="col-md-10">
                                        <img src="{{ $imagen }}" alt="Imagen relacionada" class="mb-3" style="width: 100%; height: auto; border-radius: 10px;">
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (!empty($imagen_opcional))
                            <div class="blog-content text-center" style="margin-top: 20px; margin-bottom: 20px;">
                                <div class="row g-5 justify-content-center" style="margin-top: 20px;">
                                    <div class="col-md-10">
                                        <img src="{{ $imagen_opcional }}" alt="Imagen relacionada" class="mb-3" style="width: 100%; height: auto; border-radius: 10px;">
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (!empty($links))
                            <div class="blog-content text-center" style="margin-top: 40px; margin-bottom: 20px;">
                                <div class="row g-5 justify-content-center" style="margin-top: 20px;">
                                    @foreach ($links as $link)
                                        <div class="col-md-4">
                                            <a href="{{ $link['url'] }}" target="_blank">
                                                <div class="th-product product-grid">
                                                    <div class="mb-1 text-center">
                                                        <img src="{{ $link['icono'] }}" alt="{{ $link['nombre'] }}" style="max-width: 100px; height: auto;">
                                                    </div>
                                                    <div class="product-content mb-3">
                                                        <p class="product-title fw-bold">
                                                            {{ $link['nombre'] }}
                                                        </p>
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
