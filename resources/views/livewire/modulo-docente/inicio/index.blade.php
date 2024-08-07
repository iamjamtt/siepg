<div>
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Inicio
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('docente.inicio') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Inicio</li>
                </ul>
            </div>
        </div>
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="row mb-5 mb-xl-10">
                <div class="col-md-12 mb-md-5 mb-xl-10">
                    @if ($cursos_docente->count() > 0)
                        {{-- alerta --}}
                        <div class="alert bg-light-primary border border-4 border-primary d-flex align-items-center p-5 mb-5">
                            <i class="ki-outline ki-information-5 fs-2qx me-4 text-primary"></i>
                            <div class="d-flex flex-column">
                                <span class="fw-bold fs-3">
                                    A continuación se muestran los cursos que fueron asignados.
                                </span>
                            </div>
                        </div>
                        <div class="card mb-5">
                            <div class="card-header border-0">
                                <div class="card-title">
                                    <div class="d-flex align-items-center position-relative my-1">
                                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <input type="text" wire:model="search" class="form-control w-400px ps-13" placeholder="Buscar cursos...">
                                    </div>
                                </div>
                                <div class="card-toolbar" data-select2-id="select2-data-133-g6fa">
                                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base"
                                        data-select2-id="select2-data-132-zllr">
                                        <button type="button" class="btn btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary me-3" data-kt-menu-trigger="click"
                                            data-kt-menu-placement="bottom-end">
                                            <i class="ki-duotone ki-filter fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i> Filtro
                                        </button>
                                        <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true" wire:ignore.self>
                                            <div class="px-7 py-5">
                                                <div class="fs-5 text-dark fw-bold">
                                                    Opciones de filtrado
                                                </div>
                                            </div>
                                            <div class="separator border-gray-200"></div>
                                            <div class="px-7 py-5" data-kt-user-table-filter="form">
                                                <div class="mb-5">
                                                    <label class="form-label fw-semibold">
                                                        Procesos Académicos:
                                                    </label>
                                                    <div>
                                                        <select class="form-select" wire:model="filtro_proceso"
                                                            id="filtro_proceso" data-control="select2"
                                                            data-placeholder="Seleccione su proceso académico">
                                                            <option value=""></option>
                                                            @foreach ($procesos as $item)
                                                                <option value="{{ $item->id_admision }}">
                                                                    Procesos {{ $item->admision_año }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-10" data-select2-id="select2-data-137-o1oi">
                                                    <label class="form-label fs-5 fw-semibold">Estado:</label>
                                                    <div class="form-check mb-2 form-check-custom">
                                                        <input class="form-check-input" wire:model="filtro_estado" type="radio" value="1" id="activo"/>
                                                        <label class="form-check-label" for="activo">
                                                            Curso Activo
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-2 form-check-custom">
                                                        <input class="form-check-input" wire:model="filtro_estado" type="radio" value="0" id="inactivo"/>
                                                        <label class="form-check-label" for="inactivo">
                                                            Inhabilitado
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-2 form-check-custom">
                                                        <input class="form-check-input" wire:model="filtro_estado" type="radio" value="2" id="curso_terminado"/>
                                                        <label class="form-check-label" for="curso_terminado">
                                                            Curso Terminado
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <button type="button" wire:click="resetear_filtro" class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6" data-kt-menu-dismiss="true">
                                                        Resetear
                                                    </button>
                                                    <button type="button" wire:click="aplicar_filtro" class="btn btn-primary fw-semibold px-6" data-kt-menu-dismiss="true">
                                                        Aplicar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    {{-- card  --}}
                    <div class="row g-5 mb-5">
                        @forelse ($cursos_docente as $item2)
                            <div class="col-md-12">
                                {{-- <div class="bg-body shadow-sm px-0 rounded rounded-3">
                                    <div class="card-header py-5 px-8 rounded rounded-3 text-center"> --}}
                                        <span class="fw-bold fs-1 text-gray-800">
                                            Cursos asignados en el Proceso {{ $item2['proceso']->admision_año }}
                                        </span>
                                    {{-- </div>
                                </div> --}}
                            </div>
                            @forelse ($item2['programa'] as $item)
                                <div class="col-md-12">
                                    <div class="bg-body shadow-sm px-0 rounded rounded-3">
                                        <div class="card-header {{ $item['colorlight'] }} py-5 px-8 rounded rounded-3">
                                            <span class="card-title fs-2 text-gray-800 text-uppercase" style="font-weight: 700;">
                                                @if ($item['programa']->mencion)
                                                    {{ $item['programa']->programa }} EN {{ $item['programa']->subprograma }} CON MENCIÓN
                                                    {{ $item['programa']->mencion }} - MODALIDAD
                                                    {{ $item['programa']->id_modalidad == 1 ? 'PRESENCIAL' : 'A DISTANCIA' }}
                                                @else
                                                    {{ $item['programa']->programa }} EN {{ $item['programa']->subprograma }} - MODALIDAD
                                                    {{ $item['programa']->id_modalidad == 1 ? 'PRESENCIAL' : 'A DISTANCIA' }}
                                                @endif
                                            </span>
                                        </div>
                                        <div class="py-8 px-8">
                                            <div class="row g-5">
                                                @forelse ($item['cursos'] as $curso)
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4">
                                                        <div class="card card-bordered shadow-sm h-100 hover-elevate-up parent-hover">
                                                            @if ($curso['docente_curso_estado'] == 1)
                                                                <div class="ribbon ribbon-top">
                                                                    <div class="ribbon-label bg-success fw-bold fs-5">
                                                                        Curso Activo
                                                                    </div>
                                                                </div>
                                                            @elseif ($curso['docente_curso_estado'] == 0)
                                                                <div class="ribbon ribbon-top">
                                                                    <div class="ribbon-label bg-danger fw-bold fs-5">
                                                                        Inhabilitado
                                                                    </div>
                                                                </div>
                                                            @elseif ($curso['docente_curso_estado'] == 2)
                                                                <div class="ribbon ribbon-top">
                                                                    <div class="ribbon-label bg-secondary text-gray-700 fw-bold fs-5">
                                                                        Curso Terminado
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <div
                                                                class="card-body mb-0 d-flex flex-column justify-content-center px-10 py-10">
                                                                <div class="mb-2 text-center">
                                                                    <span class="fs-2 text-gray-800 fw-bold text-uppercase parent-hover-primary">
                                                                        {{ $curso['curso_programa_plan']->curso->curso_nombre }}
                                                                    </span>
                                                                </div>
                                                                <div class="mb-5 fs-6 text-gray-600 fw-bold text-center">
                                                                    <span>
                                                                        {{ $curso['curso_programa_plan']->curso->curso_codigo }} -
                                                                        CICLO
                                                                        {{ $curso['curso_programa_plan']->curso->ciclo->ciclo }} -
                                                                        GRUPO
                                                                        {{ $curso['programa_proceso_grupo']->grupo_detalle }}
                                                                    </span>
                                                                </div>
                                                                <div class="d-flex flex-column row-gap-5">
                                                                    <button wire:click="ingresar({{ $curso['id_docente_curso'] }})" class="btn btn-primary w-100">
                                                                        Ingresar
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                        <div class="mb-0 py-4 text-center">
                                                            <span class="fs-2 text-gray-500 fw-bold text-uppercase">
                                                                No se encontraron resultados
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <div class="mb-0 py-20 text-center">
                                        <span class="fs-2 text-gray-500 fw-bold text-uppercase">
                                            No se encontraron cursos asignados
                                        </span>
                                    </div>
                                </div>
                            @endforelse
                        @empty
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="mb-0 py-20 text-center">
                                    <span class="fs-2 text-gray-500 fw-bold text-uppercase">
                                        No se encontraron cursos asignados
                                    </span>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        // filtro_proceso select2
        $(document).ready(function() {
            $('#filtro_proceso').select2({
                placeholder: 'Seleccione',
                allowClear: true,
                width: '100%',
                selectOnClose: true,
                language: {
                    noResults: function() {
                        return "No se encontraron resultados";
                    },
                    searching: function() {
                        return "Buscando..";
                    }
                }
            });
            $('#filtro_proceso').on('change', function() {
                @this.set('filtro_proceso', this.value);
            });
            Livewire.hook('message.processed', (message, component) => {
                $('#filtro_proceso').select2({
                    placeholder: 'Seleccione',
                    allowClear: true,
                    width: '100%',
                    selectOnClose: true,
                    language: {
                        noResults: function() {
                            return "No se encontraron resultados";
                        },
                        searching: function() {
                            return "Buscando..";
                        }
                    }
                });
                $('#filtro_proceso').on('change', function() {
                    @this.set('filtro_proceso', this.value);
                });
            });
        });
    </script>
@endpush
