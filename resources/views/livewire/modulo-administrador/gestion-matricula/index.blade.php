<div>
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Gestión de Matriculas
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('administrador.dashboard') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        Gestión de Matriculas
                    </li>
                </ul>
            </div>
            <div class="d-flex flex-stack">
                <div class="d-flex align-items-center text-center gap-2 gap-lg-3 ms-5">
                    {{-- boton para crear maticulas --}}
                    <button type="button" class="btn btn-primary fw-bold" wire:click="modo" data-bs-toggle="modal"
                        data-bs-target="#modal_gestion_matricula">
                        Nuevo Matricula
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="row mb-5 mb-xl-10">
                <div class="col-md-12 mb-md-5 mb-xl-10">
                    {{-- alerta --}}
                    <div
                        class="alert bg-light-primary border border-3 border-primary d-flex align-items-center p-5 mb-5">
                        <i class="ki-outline ki-information-2 fs-2qx me-4 text-primary"></i>
                        <div class="d-flex flex-column gap-2">
                            <span class="fw-bold fs-5">
                                A continuación se muestra la lista de matriculas registradas en el sistema. Puede filtrar la información por diferentes criterios.
                            </span>
                        </div>
                    </div>
                    {{-- card la tabla --}}
                    <div class="card shadow-sm">
                        <div class="card-body mb-0">
                            {{-- header de la tabla --}}
                            <div class="d-flex flex-column flex-md-row align-items-center mb-5 w-100">
                                <div class="col-md-4 pe-md-3 mb-2 mb-md-0">
                                    <button type="button" class="btn btn btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary btn-center fw-bold w-100px w-md-125px"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start">
                                        <span class="svg-icon svg-icon-3 me-1">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z"
                                                    fill="currentColor" />
                                            </svg>
                                        </span>
                                        Filtrar
                                    </button>
                                    <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px"
                                        data-kt-menu="true" id="filtros_docentes" wire:ignore.self>
                                        <div class="px-7 py-5">
                                            <div class="fs-4 text-dark fw-bold">
                                                Opciones de Filtro
                                            </div>
                                        </div>

                                        <div class="separator border-gray-200"></div>

                                        <form class="px-7 py-5" wire:submit.prevent="aplicar_filtro">
                                            <div class="mb-5">
                                                <label class="form-label fw-semibold">
                                                    Proceso Académico:
                                                </label>
                                                <div>
                                                    <select class="form-select" wire:model="filtro_proceso"
                                                        id="filtro_proceso" data-control="select2"
                                                        data-placeholder="Seleccione su proceso académico">
                                                        @foreach ($admisiones as $item)
                                                            <option value=""></option>
                                                            <option value="{{ $item->id_admision }}">
                                                                PROCESO {{ $item->admision_año }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-5">
                                                <label class="form-label fw-semibold">
                                                    Programa Académico:
                                                </label>
                                                <div>
                                                    <select class="form-select" wire:model="filtro_programa"
                                                        id="filtro_programa" data-control="select2"
                                                        data-placeholder="Seleccione el programa">
                                                        @foreach ($programas_model_filtro as $item)
                                                            <option value="{{ $item->id_programa_proceso }}">
                                                                @if ($item->mencion)
                                                                    MENCION EN {{ $item->mencion }}
                                                                @else
                                                                    {{ $item->programa }} EN {{ $item->subprograma }}
                                                                @endif
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-10">
                                                <label class="form-label fw-semibold">
                                                    Ciclo Académico:
                                                </label>
                                                <div>
                                                    <select class="form-select" wire:model="filtro_ciclo"
                                                        id="filtro_ciclo" data-control="select2"
                                                        data-placeholder="Seleccione el ciclo">
                                                        @foreach ($ciclos_model_filtro as $item)
                                                            <option value="{{ $item->id_ciclo }}">
                                                                CICLO {{ $item->ciclo }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-end">
                                                <button type="button" wire:click="resetear_filtro"
                                                    class="btn btn-light btn-active-light-primary me-2"
                                                    data-kt-menu-dismiss="true">Resetear</button>
                                                <button type="submit" class="btn btn-primary"
                                                    data-kt-menu-dismiss="true">Aplicar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-md-4 px-md-3 mb-2 mb-md-0"></div>
                                <div class="col-md-4 ps-md-3">
                                    {{-- <input type="search" wire:model="search" class="form-control w-100"
                                        placeholder="Buscar..." /> --}}
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle table-rounded border mb-0 gy-5 gs-5">
                                    <thead class="bg-light-warning">
                                        <tr class="fw-bold fs-5 text-gray-900 border-bottom-2 border-gray-200">
                                            <th>#</th>
                                            <th>Programa</th>
                                            <th>Proceso</th>
                                            <th>Ciclo</th>
                                            <th>Fecha Inicio</th>
                                            <th>Fecha Fin</th>
                                            <th>Alumnos minimos</th>
                                            <th>Resoluciones</th>
                                            <th>Estado</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-700">
                                        @forelse ($matriculas as $item)
                                            <tr>
                                                <td class="fw-bold fs-6">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td class="fs-6">
                                                    @if ($item->programa_proceso->programa_plan->programa->mencion)
                                                        MENCION EN {{ $item->programa_proceso->programa_plan->programa->mencion }}
                                                    @else
                                                        {{ $item->programa_proceso->programa_plan->programa->programa }} EN {{ $item->programa_proceso->programa_plan->programa->subprograma }}
                                                    @endif
                                                </td>
                                                <td class="fs-6">
                                                    <span class="badge badge-light-primary fs-6 px-3 py-2">
                                                        PROCESO {{ $item->admision->admision_año }}
                                                    </span>
                                                </td>
                                                <td class="fs-6">
                                                    <span class="badge badge-light-info fs-6 px-3 py-2">
                                                        CICLO {{ $item->ciclo->ciclo }}
                                                    </span>
                                                </td>
                                                <td class="fs-6">
                                                    {{ date('d/m/Y', strtotime($item->matricula_gestion_fecha_inicio)) }}
                                                </td>
                                                <td class="fs-6">
                                                    {{ date('d/m/Y', strtotime($item->matricula_gestion_fecha_extemporanea_fin)) }}
                                                </td>
                                                <td class="fs-6">
                                                    {{ $item->matricula_gestion_minimo_alumnos }}
                                                </td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-flex btn-center fw-bold btn-outline btn-outline-dashed btn-outline-info btn-active-light-info hover-scale"
                                                        {{-- data-kt-menu-trigger="click" --}}
                                                        {{-- data-kt-menu-placement="bottom-end" --}}
                                                        data-bs-toggle="dropdown">
                                                        Resoluciones
                                                        <span class="svg-icon fs-5 rotate-180 ms-2 me-0 m-0">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                width="24px" height="24px" viewBox="0 0 24 24"
                                                                version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none"
                                                                    fill-rule="evenodd">
                                                                    <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                                    <path
                                                                        d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z"
                                                                        fill="currentColor" fill-rule="nonzero"
                                                                        transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999)">
                                                                    </path>
                                                                </g>
                                                            </svg>
                                                        </span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-6 w-250px py-4"
                                                        data-kt-menu="true">
                                                        <div class="menu-item px-3">
                                                            @if ($item->matricula_gestion_resolucion_url)
                                                                <a href="{{ asset($item->matricula_gestion_resolucion_url) }}"
                                                                    target="_blank" class="menu-link px-3 fs-6">
                                                                    Ver Resolución
                                                                </a>
                                                            @endif
                                                            @if ($item->matricula_gestion_resolucion_ampliacion_url)
                                                                <a href="{{ asset($item->matricula_gestion_resolucion_ampliacion_url) }}"
                                                                    target="_blank" class="menu-link px-3 fs-6">
                                                                    Ver Resolución Ampliación
                                                                </a>
                                                            @endif
                                                            @if ($item->matricula_gestion_resolucion_url == null && $item->matricula_gestion_resolucion_ampliacion_url == null)
                                                                <span class="menu-link px-3 fs-6">
                                                                    Sin Resoluciones
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="fs-6">
                                                    @if ($item->matricula_gestion_estado == 1)
                                                        <span class="badge badge-primary fs-6 px-3 py-2"
                                                            {{-- wire:click="alerta_cambiar_estado({{ $item->id_docente }})" --}}
                                                            style="cursor: pointer;">
                                                            Activo
                                                        </span>
                                                    @else
                                                        <span class="badge badge-danger fs-6 px-3 py-2"
                                                            {{-- wire:click="alerta_cambiar_estado({{ $item->id_docente }})" --}}
                                                            style="cursor: pointer;">
                                                            Inactivo
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <button type="button"
                                                        class="btn btn-flex btn-center fw-bold btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary hover-scale"
                                                        {{-- data-kt-menu-trigger="click" --}}
                                                        {{-- data-kt-menu-placement="bottom-end" --}}
                                                        data-bs-toggle="dropdown">
                                                        Acciones
                                                        <span class="svg-icon fs-5 rotate-180 ms-2 me-0 m-0">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                width="24px" height="24px" viewBox="0 0 24 24"
                                                                version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none"
                                                                    fill-rule="evenodd">
                                                                    <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                                    <path
                                                                        d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z"
                                                                        fill="currentColor" fill-rule="nonzero"
                                                                        transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999)">
                                                                    </path>
                                                                </g>
                                                            </svg>
                                                        </span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-6 w-150px py-4"
                                                        data-kt-menu="true">
                                                        <div class="menu-item px-3">
                                                            <a href="#modal_gestion_matricula"
                                                                wire:click="cargar_matricula({{ $item->id_matricula_gestion }})"
                                                                class="menu-link px-3 fs-6" data-bs-toggle="modal"
                                                                data-bs-target="#modal_gestion_matricula">
                                                                Editar Datos
                                                            </a>
                                                            <a href="#modal_gestion_matricula"
                                                                wire:click="cargar_matricula_ampliacion({{ $item->id_matricula_gestion }})"
                                                                class="menu-link px-3 fs-6" data-bs-toggle="modal"
                                                                data-bs-target="#modal_gestion_matricula">
                                                                Ampliación
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center text-muted">
                                                    No hay registros
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{-- paginacion de la tabla --}}
                            @if ($matriculas->hasPages())
                                <div class="d-flex justify-content-between mt-5">
                                    <div class="d-flex align-items-center text-gray-700">
                                        Mostrando {{ $matriculas->firstItem() }} - {{ $matriculas->lastItem() }} de
                                        {{ $matriculas->total() }} registros
                                    </div>
                                    <div>
                                        {{ $matriculas->links() }}
                                    </div>
                                </div>
                            @else
                                <div class="d-flex justify-content-between mt-5">
                                    <div class="d-flex align-items-center text-gray-700">
                                        Mostrando {{ $matriculas->firstItem() }} - {{ $matriculas->lastItem() }} de
                                        {{ $matriculas->total() }} registros
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" tabindex="-1" id="modal_gestion_matricula">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">
                        {{ $title_modal }}
                    </h2>

                    <div class="btn btn-icon btn-sm btn-active-light-danger ms-2" data-bs-dismiss="modal" wire:click="limpiar_modal"
                        aria-label="Close">
                        <span class="svg-icon svg-icon-2hx">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.3" x="2" y="2" width="20" height="20"
                                    rx="5" fill="currentColor" />
                                <rect x="7" y="15.3137" width="12" height="2" rx="1"
                                    transform="rotate(-45 7 15.3137)" fill="currentColor" />
                                <rect x="8.41422" y="7" width="12" height="2" rx="1"
                                    transform="rotate(45 8.41422 7)" fill="currentColor" />
                            </svg>
                        </span>
                    </div>
                </div>

                <div class="modal-body">
                    <form autocomplete="off" class="row g-5">
                        @if ($modo != 'ampliacion')
                        <div class="col-md-12">
                            <label for="proceso" class="required form-label">
                                Procesos Académicos
                            </label>
                            <select class="form-select @error('proceso') is-invalid @enderror"
                                wire:model="proceso" id="proceso" data-control="select2"
                                data-placeholder="Seleccione su proceso académico" data-allow-clear="true"
                                data-dropdown-parent="#modal_gestion_matricula">
                                <option></option>
                                @foreach ($admisiones as $item)
                                    <option value="{{ $item->id_admision }}">PROCESO {{ $item->admision_año }}
                                    </option>
                                @endforeach
                            </select>
                            @error('proceso')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="programa_academico" class="required form-label">
                                Programas Académicos
                            </label>
                            <select class="form-select @error('programa_academico') is-invalid @enderror"
                                wire:model="programa_academico" id="programa_academico" data-control="select2"
                                data-placeholder="Seleccione su programa académico" data-allow-clear="true"
                                data-dropdown-parent="#modal_gestion_matricula">
                                <option></option>
                                @foreach ($programas_model as $item)
                                    <option value="{{ $item->id_programa_proceso }}">
                                        @if ($item->mencion)
                                            MENCION EN {{ $item->mencion }}
                                        @else
                                            {{ $item->programa }} EN {{ $item->subprograma }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('programa_academico')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="ciclo" class="required form-label">
                                Ciclos
                            </label>
                            <select class="form-select @error('ciclo') is-invalid @enderror"
                                wire:model="ciclo" id="ciclo" data-control="select2"
                                data-placeholder="Seleccione su ciclo" data-allow-clear="true"
                                data-dropdown-parent="#modal_gestion_matricula">
                                <option></option>
                                @foreach ($ciclos_model as $item)
                                    <option value="{{ $item->id_ciclo }}">
                                        CICLO {{ $item->ciclo }}
                                    </option>
                                @endforeach
                            </select>
                            @error('ciclo')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="alumnos_minimos" class="required form-label">
                                Alumnos minimos
                            </label>
                            <input type="number" wire:model="alumnos_minimos"
                                class="form-control @error('alumnos_minimos') is-invalid @enderror"
                                placeholder="Ingrese los alumnos minimos" id="alumnos_minimos" />
                            @error('alumnos_minimos')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        @endif
                        <div class="col-md-6">
                            <label for="fecha_inicio" class="required form-label">
                                Fecha Matricula Inicio
                            </label>
                            <input type="date" wire:model="fecha_inicio"
                                class="form-control @error('fecha_inicio') is-invalid @enderror" id="fecha_inicio" />
                            @error('fecha_inicio')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_fin" class="required form-label">
                                Fecha Matricula Fin
                            </label>
                            <input type="date" wire:model="fecha_fin"
                                class="form-control @error('fecha_fin') is-invalid @enderror" id="fecha_fin" />
                            @error('fecha_fin')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_extemporanea_inicio" class="required form-label">
                                Fecha Matricula Extemporanea Inicio
                            </label>
                            <input type="date" wire:model="fecha_extemporanea_inicio"
                                class="form-control @error('fecha_extemporanea_inicio') is-invalid @enderror" id="fecha_extemporanea_inicio" />
                            @error('fecha_extemporanea_inicio')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_extemporanea_fin" class="required form-label">
                                Fecha Matricula Extemporanea Fin
                            </label>
                            <input type="date" wire:model="fecha_extemporanea_fin"
                                class="form-control @error('fecha_extemporanea_fin') is-invalid @enderror" id="fecha_extemporanea_fin" />
                            @error('fecha_extemporanea_fin')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="nombre_resolucion" class="required form-label">
                                {{ $nombre_resolucion_form }}
                            </label>
                            <input class="form-control @error('nombre_resolucion') is-invalid @enderror"
                                wire:model="nombre_resolucion" id="nombre_resolucion" type="text" placeholder="Ingrese el nombre de la resolucion" />
                            @error('nombre_resolucion')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="nombre_resolucion" class="required form-label">
                                {{ $resolucion_form }}
                            </label>
                            <input class="form-control @error('resolucion') is-invalid @enderror"
                                wire:model="resolucion" id="upload({{ $iteration }})" type="file" accept="application/pdf" />
                            @error('resolucion')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal"
                        wire:click="limpiar_modal">Cerrar</button>
                    <button type="button" wire:click="guardar_matricula" class="btn btn-primary" style="width: 150px"
                        wire:loading.attr="disabled" wire:target="guardar_matricula">
                        <div wire:loading.remove wire:target="guardar_matricula">
                            Guardar
                        </div>
                        <div wire:loading wire:target="guardar_matricula">
                            Procesando <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        // proceso select2
        $(document).ready(function() {
            $('#proceso').select2({
                placeholder: 'Seleccione su proceso académico',
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
            $('#proceso').on('change', function() {
                @this.set('proceso', this.value);
            });
            Livewire.hook('message.processed', (message, component) => {
                $('#proceso').select2({
                    placeholder: 'Seleccione su proceso académico',
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
                $('#proceso').on('change', function() {
                    @this.set('proceso', this.value);
                });
            });
        });
        // programa_academico select2
        $(document).ready(function() {
            $('#programa_academico').select2({
                placeholder: 'Seleccione su programa académico',
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
            $('#programa_academico').on('change', function() {
                @this.set('programa_academico', this.value);
            });
            Livewire.hook('message.processed', (message, component) => {
                $('#programa_academico').select2({
                    placeholder: 'Seleccione su programa académico',
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
                $('#programa_academico').on('change', function() {
                    @this.set('programa_academico', this.value);
                });
            });
        });
        // ciclo select2
        $(document).ready(function() {
            $('#ciclo').select2({
                placeholder: 'Seleccione su ciclo',
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
            $('#ciclo').on('change', function() {
                @this.set('ciclo', this.value);
            });
            Livewire.hook('message.processed', (message, component) => {
                $('#ciclo').select2({
                    placeholder: 'Seleccione su ciclo',
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
                $('#ciclo').on('change', function() {
                    @this.set('ciclo', this.value);
                });
            });
        });
        // filtro_proceso select2
        $(document).ready(function() {
            $('#filtro_proceso').select2({
                placeholder: 'Seleccione su proceso académico',
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
                    placeholder: 'Seleccione su proceso académico',
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
        // filtro_programa select2
        $(document).ready(function() {
            $('#filtro_programa').select2({
                placeholder: 'Seleccione su programa académico',
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
            $('#filtro_programa').on('change', function() {
                @this.set('filtro_programa', this.value);
            });
            Livewire.hook('message.processed', (message, component) => {
                $('#filtro_programa').select2({
                    placeholder: 'Seleccione su programa académico',
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
                $('#filtro_programa').on('change', function() {
                    @this.set('filtro_programa', this.value);
                });
            });
        });
        // filtro_ciclo select2
        $(document).ready(function() {
            $('#filtro_ciclo').select2({
                placeholder: 'Seleccione su ciclo académico',
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
            $('#filtro_ciclo').on('change', function() {
                @this.set('filtro_ciclo', this.value);
            });
            Livewire.hook('message.processed', (message, component) => {
                $('#filtro_ciclo').select2({
                    placeholder: 'Seleccione su ciclo académico',
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
                $('#filtro_ciclo').on('change', function() {
                    @this.set('filtro_ciclo', this.value);
                });
            });
        });
    </script>
@endpush
