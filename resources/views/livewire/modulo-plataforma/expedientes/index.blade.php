<div>
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Expedientes</h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('plataforma.inicio') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Expedientes</li>
                </ul>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <div class="m-0">
                    <a href="#" class="btn btn-sm btn-flex bg-body btn-color-gray-700 btn-active-color-primary shadow-sm fw-bold" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                        <span class="svg-icon svg-icon-6 svg-icon-muted me-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="currentColor" />
                            </svg>
                        </span>
                        Filtrar por Proceso de Admisión
                    </a>
                    <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="menu_expediente" wire:ignore.self>
                        <div class="px-7 py-5">
                            <div class="fs-5 text-dark fw-bold">
                                Opciones de filtrado
                            </div>
                        </div>
                        <div class="separator border-gray-200"></div>
                        <form class="px-7 py-5" wire:submit.prevent="aplicar_filtro">
                            <div class="mb-10">
                                <label class="form-label fw-semibold">Proceso de Admisión:</label>
                                <div>
                                    <select class="form-select" wire:model="filtro_proceso" id="filtro_proceso"  data-control="select2" data-placeholder="Seleccione" data-hide-search="true">
                                        $@foreach ($admisiones as $item)
                                        <option value="{{ $item->admision->cod_admi }}">{{ $item->admision->admision }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- <div class="mb-10">
                                <label class="form-label fw-semibold">Member Type:</label>
                                <div class="d-flex">
                                    <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                        <input class="form-check-input" type="checkbox" value="1" />
                                        <span class="form-check-label">Author</span>
                                    </label>
                                    <label class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="2" checked="checked" />
                                        <span class="form-check-label">Customer</span>
                                    </label>
                                </div>
                            </div>
                            <div class="mb-10">
                                <label class="form-label fw-semibold">Notifications:</label>
                                <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="" name="notifications" checked="checked" />
                                    <label class="form-check-label">Enabled</label>
                                </div>
                            </div> --}}
                            <div class="d-flex justify-content-end">
                                <button type="button" wire:click="resetear_filtro" class="btn btn-sm btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true">Resetear</button>
                                <button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">Aplicar</button>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- <a href="#" class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Create</a> --}}
            </div>
        </div>
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="row mb-5 mb-xl-10">
                <div class="col-md-12 mb-md-5 mb-xl-10">
                    {{-- alerta de fecha de actualizacion de expedientes --}}
                    @if ($admision->fecha_fin < today())
                        <div class="alert bg-light-danger border border-danger d-flex alig-items-center p-5 mb-5">
                            <span class="svg-icon svg-icon-2hx svg-icon-danger me-4">
                                <i class="las la-exclamation-circle fs-2 text-danger"></i>
                            </span>
                            <div class="d-flex flex-column">
                                <span class="fw-bold">
                                    La fecha limite para actualizar sus expedientes ha expirado
                                </span>
                            </div>
                        </div>
                    @else
                        <div class="alert bg-light-warning border border-warning d-flex alig-items-center p-5 mb-5">
                            <span class="svg-icon svg-icon-2hx svg-icon-warning me-4">
                                <i class="las la-exclamation-triangle fs-2 text-warning"></i>
                            </span>
                            <div class="d-flex flex-column">
                                <span class="fw-bold">
                                    Recuerde que la fecha limite para actualizar sus expedientes es el {{ $fecha_fin_admision }}
                                </span>
                            </div>
                        </div>
                    @endif
                    {{-- alerta para que el usuario sepa de donde abrir los expedientes --}}
                    <div class="alert bg-light-primary border border-primary d-flex alig-items-center p-5 mb-5">
                        <span class="svg-icon svg-icon-2hx svg-icon-primary me-4">
                            <i class="las la-exclamation-circle fs-2 text-primary"></i>
                        </span>
                        <div class="d-flex flex-column">
                            <span class="fw-bold">
                                Nota: Para abrir los expedientes debe hacer click en el nombre de cada uno de los expedientes
                            </span>
                        </div>
                    </div>
                    {{-- tabla de expedientes --}}
                    <div class="card shadow-sm mb-5">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle table-rounded border mb-0 gy-5 gs-5">
                                <thead>
                                    <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                        <th>Expedientes</th>
                                        <th>Estado</th>
                                        <th>Fecha de Entrega</th>
                                        @if ($inscripcion->admision_cod_admi == $admision->cod_admi)
                                            @if ($admision->fecha_fin >= today())
                                            <th></th>
                                            @endif
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $valor = 0; @endphp
                                    @foreach ($expedientes_model as $item2)
                                        @if ($expedientes)
                                            @foreach ($expedientes as $item)
                                                @if($item2->cod_exp == $item->expediente_cod_exp)
                                                <tr>
                                                    <td>
                                                        <a href="{{ asset($item->nom_exped) }}" target="_blank" class="text-gray-800">
                                                            {{ $item->expediente->tipo_doc }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-success">Entregado</span>
                                                    </td>
                                                    <td>
                                                        {{ date('d/m/Y', strtotime($item->fecha_entre)) }}
                                                    </td>
                                                    @if ($inscripcion->admision_cod_admi == $admision->cod_admi)
                                                        @if ($admision->fecha_fin >= today())
                                                        <td class="text-end">
                                                            <a href="#modal_expediente" wire:click="cargar_expediente_inscripcion({{ $item->cod_ex_insc }})" class="btn btn-light-primary btn-sm hover-scale" data-bs-toggle="modal" data-bs-target="#modal_expediente">
                                                                Editar
                                                            </a>
                                                        </td>
                                                        @endif
                                                    @endif
                                                </tr>
                                                @php $valor = 1; @endphp
                                                @endif
                                            @endforeach
                                            @if ($expedientes->count() == 0)
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted">No hay expedientes registrados</td>
                                                </tr>
                                            @endif
                                            @if ($valor == 0)
                                                <tr>
                                                    <td class="text-gray-800">
                                                        {{ $item2->tipo_doc }}
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-danger">No Entregado</span>
                                                    </td>
                                                    <td>
                                                        Sin fecha
                                                    </td>
                                                    @if ($inscripcion->admision_cod_admi == $admision->cod_admi)
                                                        @if ($admision->fecha_fin >= today())
                                                        <td class="text-end">
                                                            <a href="#modal_expediente" wire:click="cargar_expediente({{ $item2->cod_exp }})" class="btn btn-light-success btn-sm hover-scale" data-bs-toggle="modal" data-bs-target="#modal_expediente">
                                                                Agregar
                                                            </a>
                                                        </td>
                                                        @endif
                                                    @endif
                                                </tr>
                                            @endif
                                        @endif
                                        @php $valor = 0; @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal create/edit expediente --}}
    <div wire:ignore.self class="modal fade" tabindex="-1" id="modal_expediente">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        {{ $titulo_modal }}
                    </h3>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close" wire:click="limpiar_expediente">
                        <i class="bi bi-x fs-1"></i>
                    </div>
                </div>
                <div class="modal-body">
                    <form autocomplete="off">
                        <div class="mb-5">
                            <label for="expediente" class="required form-label">
                                {{ $expediente_nombre }}
                            </label>
                            <input type="file" wire:model="expediente" class="form-control mb-1 @error('expediente') is-invalid @enderror" accept=".pdf" id="upload{{ $iteration }}"/>
                            <span class="text-muted">
                                Nota: El archivo debe ser en formato PDF y no debe pesar mas de 10MB <br>
                            </span>
                            @error('expediente')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" wire:click="limpiar_expediente">
                        Cerrar
                    </button>
                    <button type="button" wire:click="registrar_expediente" class="btn btn-primary" @if($expediente == null) disabled @endif wire:loading.attr="disabled">
                        <div wire:loading.remove wire:target="registrar_expediente">
                            {{ $boton_modal }}
                        </div>
                        <div wire:loading wire:target="registrar_expediente">
                            Procesando...
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        // filtro_proceso select2
        $(document).ready(function () {
            $('#filtro_proceso').select2({
                placeholder: 'Seleccione',
                allowClear: true,
                width: '100%',
                selectOnClose: true,
                minimumResultsForSearch: Infinity,
                language: {
                    noResults: function () {
                        return "No se encontraron resultados";
                    },
                    searching: function () {
                        return "Buscando..";
                    }
                }
            });
            $('#filtro_proceso').on('change', function(){
                @this.set('filtro_proceso', this.value);
            });
            Livewire.hook('message.processed', (message, component) => {
                $('#filtro_proceso').select2({
                    placeholder: 'Seleccione',
                    allowClear: true,
                    width: '100%',
                    selectOnClose: true,
                    minimumResultsForSearch: Infinity,
                    language: {
                        noResults: function () {
                            return "No se encontraron resultados";
                        },
                        searching: function () {
                            return "Buscando..";
                        }
                    }
                });
                $('#filtro_proceso').on('change', function(){
                    @this.set('filtro_proceso', this.value);
                });
            });
        });
    </script>
@endpush