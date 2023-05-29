<div>
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        Gestión de Tipo de Seguimiento - {{ $expedienteModel->expediente }}
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('administrador.dashboard') }}" class="text-muted text-hover-primary">
                                Dashboard
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('administrador.expediente') }}" class="text-muted text-hover-primary">
                                Expediente
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Gestión de Tipo de Seguimiento</li>
                    </ul>
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="#modalExpedienteTipoSeguimiento" wire:click="modo()" class="btn btn-primary btn-sm hover-elevate-up" data-bs-toggle="modal" data-bs-target="#modalExpedienteTipoSeguimiento">Nuevo</a>
                </div>
            </div>
        </div>

        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-fluid pt-5">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-5">
                            <div class="me-1">
                                <a href="{{ route('administrador.expediente') }}" class="btn btn-secondary btn-sm hover-elevate-up d-flex justify-content-center align-items-center">
                                    <span class="svg-icon svg-icon-muted svg-icon-7">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M17.6 4L9.6 12L17.6 20H13.6L6.3 12.7C5.9 12.3 5.9 11.7 6.3 11.3L13.6 4H17.6Z" fill="currentColor"/>
                                        </svg>
                                    </span>
                                    Regresar
                                </a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-rounded border gy-4 gs-4 mb-0 align-middle">
                                <thead class="bg-light-primary">
                                    <tr align="center" class="fw-bold fs-5 text-gray-800 border-bottom-2 border-gray-200">
                                        <th scope="col" class="col-md-1">ID</th>
                                        <th>Tipo de Seguimiento</th>
                                        <th scope="col" class="col-md-2">Estado</th>
                                        <th scope="col" class="col-md-2">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @forelse ($expedienteEvaluacionModel as $item)
                                    <tr>
                                        <td align="center" class="fw-bold fs-5">{{ $item->id_expediente_tipo_evaluacion }}</td>
                                        <td >
                                            @if($item->expediente_tipo_evaluacion == '1')
                                                <span>Evaluación de Expediente</span>
                                            @elseif($item->expediente_tipo_evaluacion == '2')
                                                <span>Evaluación de Tema Tentativo de Tesis</span>
                                            @elseif($item->expediente_tipo_evaluacion == '3')
                                                <span>Evaluación de Entrevista</span>
                                            @endif
                                        </td>
                                        <td align="center">
                                            @if ($item->expediente_tipo_evaluacion_estado == 1)
                                                <span style="cursor: pointer;" wire:click="cargarAlertaEstado({{ $item->id_expediente_tipo_evaluacion }})" class="badge text-bg-success text-light hover-elevate-down px-3 py-2">Activo</span>
                                            @else
                                                <span style="cursor: pointer;" wire:click="cargarAlertaEstado({{ $item->id_expediente_tipo_evaluacion }})" class="badge text-bg-danger text-light hover-elevate-down px-3 py-2">Inactivo</span></span>
                                            @endif
                                        </td>
                                        <td align="center">
                                            <a class="btn btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary btn-sm" data-bs-toggle="dropdown">
                                                Acciones
                                                <span class="svg-icon fs-5 m-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                            <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="currentColor" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999)"></path>
                                                        </g>
                                                    </svg>
                                                </span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                                <div class="menu-item px-3">
                                                    <a href="#modalExpedienteTipoSeguimiento" wire:click="cargarVistasEvaluacion({{ $item->id_expediente_tipo_evaluacion }})" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#modalExpedienteTipoSeguimiento">
                                                        Editar
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">
                                                No hay registros
                                            </td>
                                        </tr>
                                    @endforelse --}}
                                </tbody>
                            </table>
                        </div>
                        {{-- paginacion de la tabla --}}
                        {{-- @if ($expedienteEvaluacionModel->hasPages())
                            <div class="d-flex justify-content-between mt-5">
                                <div class="d-flex align-items-center text-gray-700">
                                    Mostrando {{ $expedienteEvaluacionModel->firstItem() }} - {{ $expedienteEvaluacionModel->lastItem() }} de
                                    {{ $expedienteEvaluacionModel->total() }} registros
                                </div>
                                <div>
                                    {{ $expedienteEvaluacionModel->links() }}
                                </div>
                            </div>
                        @else
                            <div class="d-flex justify-content-between mt-5">
                                <div class="d-flex align-items-center text-gray-700">
                                    Mostrando {{ $expedienteEvaluacionModel->firstItem() }} - {{ $expedienteEvaluacionModel->lastItem() }} de
                                    {{ $expedienteEvaluacionModel->total() }} registros
                                </div>
                            </div>
                        @endif --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Expediente --}}
    {{-- <div wire:ignore.self class="modal fade" id="modalExpedienteTipoSeguimiento" tabindex="-1" aria-labelledby="modalExpedienteTipoSeguimiento"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ $titulo }}</h5>
                    <button type="button" wire:click="limpiar()" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form novalidate>
                        <div class="row g-5">                            
                            <div class="col-md-12">
                                <label class="form-label">Tipo de expediente <span class="text-danger">*</span></label>
                                <select class="form-select @error('tipo_evaluacion') is-invalid  @enderror" wire:model="tipo_evaluacion">
                                    <option value="null" selected>Seleccione</option>
                                    <option value="1" {{$validarTipoEvaluacion->where('id_expediente', $id_expediente)->contains('expediente_tipo_evaluacion', 1) ? 'disabled' : ''}} 
                                        class="{{$validarTipoEvaluacion->where('id_expediente', $id_expediente)->contains('expediente_tipo_evaluacion', 1) ? 'text-gray-400' : ''}}">
                                        Evaluación de Expediente
                                    </option>
                                    <option value="2" {{$validarTipoEvaluacion->where('id_expediente', $id_expediente)->contains('expediente_tipo_evaluacion', 2) ? 'disabled' : ''}} 
                                        class="{{$validarTipoEvaluacion->where('id_expediente', $id_expediente)->contains('expediente_tipo_evaluacion', 2) ? 'text-gray-400' : ''}}">
                                        Evaluación de Tema Tentativo de Tesis
                                    </option>
                                    <option value="3" {{$validarTipoEvaluacion->where('id_expediente', $id_expediente)->contains('expediente_tipo_evaluacion', 3) ? 'disabled' : ''}} 
                                        class="{{$validarTipoEvaluacion->where('id_expediente', $id_expediente)->contains('expediente_tipo_evaluacion', 3) ? 'text-gray-400' : ''}}">
                                        Evaluación de Entrevista
                                    </option>
                                </select>
                                @error('tipo_evaluacion')
                                    <span class="error text-danger" >{{ $message }}</span> 
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer col-12 d-flex justify-content-between">
                    <button type="button" wire:click="limpiar()" class="btn btn-secondary hover-elevate-up" data-bs-dismiss="modal">Cancelar</button>                    
                    <button type="button" wire:click="guardarExpedienteTipoEvaluacion()" class="btn btn-primary hover-elevate-up">Guardar</button>
                </div>
            </div>
        </div>
    </div> --}}

</div>