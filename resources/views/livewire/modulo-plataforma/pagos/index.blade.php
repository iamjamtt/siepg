<div>
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Pagos</h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('plataforma.inicio') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Pagos</li>
                </ul>
            </div>
            @if ($admitido)
                @if ($admitido->admitido_estado == 1)
                    <div class="d-flex align-items-center gap-2 gap-lg-3">
                        <a href="#modal_pago_plataforma" wire:click="modo" class="btn fw-bold btn-primary" data-bs-toggle="modal" data-bs-target="#modal_pago_plataforma">
                            Nuevo Pago
                        </a>
                    </div>
                @endif
            @endif
        </div>
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="row mb-5 mb-xl-10">
                <div class="col-md-12 mb-md-5 mb-xl-10">
                    {{-- alerta  --}}
                    <div class="alert bg-light-primary border border-3 border-primary d-flex align-items-center p-5 mb-5">
                        <i class="ki-outline ki-information-5 fs-2qx me-4 text-primary"></i>
                        <div class="d-flex flex-column">
                            <span class="fw-bold fs-5">
                                Acontinuación se muestra la lista de sus pagos realizados en la plataforma, el cual podrá filtrar por concepto de pago.
                            </span>
                        </div>
                    </div>
                    {{-- header de la tabla --}}
                    <div class="card p-4 mb-5">
                        <div class="d-flex flex-column flex-md-row align-items-center w-100">
                            <div class="col-md-4 pe-md-3 mb-2 mb-md-0">
                                <button type="button" class="btn btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary btn-center fw-bold w-100px w-md-125px"
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
                                <div class="menu menu-sub menu-sub-dropdown w-300px w-md-350px"
                                    data-kt-menu="true" id="filtros_docentes" wire:ignore.self>
                                    <div class="px-7 py-5">
                                        <div class="fs-4 text-dark fw-bold">
                                            Opciones de Filtro
                                        </div>
                                    </div>

                                    <div class="separator border-gray-200"></div>

                                    <form class="px-7 py-5" wire:submit.prevent="aplicar_filtro">
                                        <div class="mb-10">
                                            <label class="form-label fw-semibold">
                                                Concepto de Pago:
                                            </label>
                                            <div>
                                                <select class="form-select" wire:model="filtro_concepto_pago"
                                                    id="filtro_concepto_pago" data-control="select2"
                                                    data-placeholder="Seleccione su concepto de pago">
                                                    <option value=""></option>
                                                    @foreach ($conceptos_pagos as $item)
                                                        <option value="{{ $item->id_concepto_pago }}">
                                                            Concepto por {{ $item->concepto_pago }}
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
                                <input type="search" wire:model="search" class="form-control w-100"
                                    placeholder="Buscar..." />
                            </div>
                        </div>
                    </div>
                    {{-- tabla de pagos --}}
                    <div class="card shadow-sm mb-5">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle table-rounded border mb-0 gy-5 gs-5">
                                <thead class="bg-light-warning">
                                    <tr class="fw-bold fs-5 text-gray-900 border-bottom-2 border-gray-200">
                                        <th>ID</th>
                                        <th>Concepto Pago</th>
                                        <th>Operacion</th>
                                        <th>Monto</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                        <th>Comprobante</th>
                                        {{-- <th>Voucher</th> --}}
                                        <th class="text-end">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-700">
                                    @forelse ($pagos as $item)
                                    <tr class="fs-6">
                                        <td>
                                            {{ $item->id_pago }}
                                        </td>
                                        <td>
                                            Concepto por {{ $item->concepto_pago->concepto_pago }}
                                        </td>
                                        <td>
                                            {{ $item->pago_operacion }}
                                        </td>
                                        <td>
                                            S/. {{ number_format($item->pago_monto, 2, ',', '.') }}
                                        </td>
                                        <td>
                                            {{ date('d/m/Y', strtotime($item->pago_fecha)) }}
                                        </td>
                                        <td>
                                            @if ($item->pago_verificacion == 1)
                                                <span class="badge badge-warning fs-6 px-3 py-2">Pendiente</span>
                                            @elseif ($item->pago_verificacion == 2)
                                                <span class="badge badge-success fs-6 px-3 py-2">Validado</span>
                                            @elseif ($item->pago_verificacion == 0 && $item->pago_estado == 0)
                                                    <span class="badge badge-danger fs-6 px-3 py-2">Rechazado</span>
                                            @elseif ($item->pago_verificacion == 0)
                                                <span class="badge badge-danger fs-6 px-3 py-2">Observado</span>
                                            @endif
                                        </td>
                                        @if ($item->pago_verificacion == 2)
                                            <td>
                                                <a href="{{ route('plataforma.comprobante', $item->id_pago) }}" target="_blank" class="btn btn-sm btn-outline btn-outline-info">
                                                    Ver Comprobante
                                                </a>
                                            </td>
                                        @else
                                            <td>
                                                -
                                            </td>
                                        @endif
                                        {{-- <td>
                                            <a href="{{ asset($item->pago_voucher_url) }}" target="_blank" class="btn btn-outline btn-outline-info">
                                                Ver Voucher
                                            </a>
                                        </td> --}}
                                        <td class="text-end">
                                            @if ($item->pago_verificacion != 2)
                                                <a href="#modal_pago_plataforma" wire:click="cargar_pago({{ $item->id_pago }})" class="btn btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary hover-scale" data-bs-toggle="modal" data-bs-target="#modal_pago_plataforma">
                                                    Editar
                                                </a>
                                            @else
                                                <a href="#modal_pago_plataforma" wire:click="cargar_pago({{ $item->id_pago }})" class="btn btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary hover-scale disabled" data-bs-toggle="modal" data-bs-target="#modal_pago_plataforma">
                                                    Editar
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr class="fs-6">
                                        <td colspan="8" class="text-center">
                                            <div class="text-muted py-5">
                                                @if ($search == '')
                                                    No se encontraron resultados
                                                @elseif($search)
                                                    No hay resultados de la busqueda "{{ $search }}"
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{-- paginacion de la tabla de pagos --}}
                    @if ($pagos->hasPages())
                        <div class="d-flex justify-content-between mt-5">
                            <div class="d-flex align-items-center text-gray-700">
                                Mostrando {{ $pagos->firstItem() }} - {{ $pagos->lastItem() }} de {{ $pagos->total()}} registros
                            </div>
                            <div>
                                {{ $pagos->links() }}
                            </div>
                        </div>
                    @else
                        <div class="d-flex justify-content-between mt-5">
                            <div class="d-flex align-items-center text-gray-700">
                                Mostrando {{ $pagos->firstItem() }} - {{ $pagos->lastItem() }} de {{ $pagos->total()}} registros
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{-- modal registro pago --}}
    <div wire:ignore.self class="modal fade" tabindex="-1" id="modal_pago_plataforma">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        {{ $titulo_modal_pago }}
                    </h3>

                    <div class="btn btn-icon btn-sm btn-active-light-danger ms-2" wire:click="limpiar_pago" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-2hx">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor"/>
                                <rect x="7" y="15.3137" width="12" height="2" rx="1" transform="rotate(-45 7 15.3137)" fill="currentColor"/>
                                <rect x="8.41422" y="7" width="12" height="2" rx="1" transform="rotate(45 8.41422 7)" fill="currentColor"/>
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="modal-body">
                    <form autocomplete="off" class="row g-5">
                        <div class="col-md-6">
                            <label for="documento_identidad" class="required form-label">
                                Documento de Identidad
                            </label>
                            <input type="number" wire:model="documento_identidad" class="form-control @error('documento_identidad') is-invalid @enderror" placeholder="12345678" id="documento_identidad" readonly/>
                            @error('documento_identidad')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="numero_operacion" class="required form-label">
                                Numero de Operación
                            </label>
                            <span class="ms-1" data-bs-toggle="tooltip"
                                aria-label="Para encontrar la forma de poner el número de operación según el tipo de pago, haga clic en el icono de información."
                                data-bs-original-title="Para encontrar la forma de poner el número de operación según el tipo de pago, haga clic en el icono de información.">
                                <i class="ki-outline ki-information-5 text-gray-600 fs-4 cursor-pointer" data-bs-toggle="modal" data-bs-target="#modal_formas_pago"></i>
                            </span>
                            <input type="number" wire:model="numero_operacion" class="form-control @error('numero_operacion') is-invalid @enderror" placeholder="6543" id="numero_operacion"/>
                            <span class="form-text text-muted mt-2 fst-italic">
                                Nota: Omitir los ceros a la izquierda. Ejemplo: 00001265, debe ser ingresado como 1265. <br>
                            </span>
                            @error('numero_operacion')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="monto_operacion" class="required form-label">
                                Monto de Operación
                            </label>
                            <input type="number" wire:model="monto_operacion" class="form-control @error('monto_operacion') is-invalid @enderror" placeholder="00.00" id="monto_operacion"/>
                            @error('monto_operacion')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_pago" class="required form-label">
                                Fecha de Pago
                            </label>
                            <input type="date" wire:model="fecha_pago" class="form-control @error('fecha_pago') is-invalid @enderror" id="fecha_pago" max="{{ date('Y-m-d') }}" />
                            @error('fecha_pago')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="canal_pago" class="required form-label">
                                Canal de Pago
                            </label>
                            <select class="form-select @error('canal_pago') is-invalid @enderror" wire:model="canal_pago" id="canal_pago" data-control="select2" data-placeholder="Seleccione su canal de pago" data-allow-clear="true" data-dropdown-parent="#modal_pago_plataforma">
                                <option></option>
                                @foreach ($canales_pagos as $item)
                                <option value="{{ $item->id_canal_pago }}">Pago realizado en {{ $item->canal_pago }}</option>
                                @endforeach
                            </select>
                            @error('canal_pago')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="concepto_pago" class="required form-label">
                                Concepto de Pago
                            </label>
                            <select class="form-select @error('concepto_pago') is-invalid @enderror" wire:model="concepto_pago" id="concepto_pago" data-control="select2" data-placeholder="Seleccione su concepto de pago" data-allow-clear="true" data-dropdown-parent="#modal_pago_plataforma">
                                <option></option>
                                @foreach ($conceptos_pagos as $item)
                                <option value="{{ $item->id_concepto_pago }}"
                                    @if($item->id_concepto_pago == 1 || $item->id_concepto_pago == 8) disabled @endif
                                    @if($constancia_ingreso && $item->id_concepto_pago == 2) disabled @endif
                                    @if ($es_ingresante)
                                        @if (!$verificar_fecha_matricula_ingresantes) disabled @endif
                                    @else
                                        @if($activarConceptosDeMatricula == false)
                                            @if($item->id_concepto_pago == 3 || $item->id_concepto_pago == 4 || $item->id_concepto_pago == 5 || $item->id_concepto_pago == 6) disabled @endif
                                        @else
                                            @if($item->id_concepto_pago == 3 || $item->id_concepto_pago == 4 || $item->id_concepto_pago == 5 || $item->id_concepto_pago == 6) @if($deuda > 0) disabled @endif @endif
                                        @endif
                                    @endif
                                    @if($matricula_count == 0 && $item->id_concepto_pago == 7) disabled @endif
                                >
                                    Concepto por {{ $item->concepto_pago }} @if($item->id_concepto_pago != 7) - S/. {{ number_format($item->concepto_pago_monto, 2, ',', '.') }} @endif
                                </option>
                                @endforeach
                            </select>
                            @error('concepto_pago')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="voucher" class="@if($modo == 'create') required @endif @if($activar_voucher == true) required @endif form-label">
                                Voucher
                            </label>
                            <input type="file" wire:model="voucher" class="form-control @error('voucher') is-invalid @enderror" id="upload{{ $iteration }}" accept="image/jpeg, image/png, image/jpg" />
                            <span class="form-text text-muted mt-2 fst-italic">
                                Nota: El voucher debe ser imagen en formato JPG, JPEG, PNG y no debe superar los 2MB. <br>
                            </span>
                            @error('voucher')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        @if ($modo == 'create')
                            <div class="col-md-12">
                                <div class="form-check mt-2">
                                    <input class="form-check-input @error('terminos_condiciones_pagos') is-invalid @enderror" type="checkbox" wire:model="terminos_condiciones_pagos" id="terminos_condiciones_pagos" />
                                    <label class="form-check-label text-dark fw-bold" for="terminos_condiciones_pagos">
                                        El registro de pago estará sujeto a revisión por el Área Contable, cualquier inconveniente será reportado. <br>
                                        Sabiendo eso "ACEPTO LOS TERMINOS Y CONDICIONES".
                                    </label>
                                </div>
                                @error('terminos_condiciones_pagos')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" wire:click="limpiar_pago">
                        Cerrar
                    </button>
                    <button type="button" wire:click="alerta_guardar_pago" class="btn btn-primary" style="width: 150px" @if ($voucher == null) wire:target="voucher" @endif wire:loading.attr="disabled" wire:target="alerta_guardar_pago">
                        <div wire:loading.remove wire:target="alerta_guardar_pago">
                            {{ $button_modal }}
                        </div>
                        <div wire:loading wire:target="alerta_guardar_pago">
                            Procesando <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" tabindex="-1" id="modal_formas_pago"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        Formas de Pago
                    </h3>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#modal_pago_plataforma">
                        <i class="bi bi-x fs-1"></i>
                    </div>
                </div>
                <div class="modal-body">
                    <div>
                        <img src="{{ asset('media/manual-voucher/page-0001.jpg') }}" alt="img" class="mw-100"
                            style="width: 100%; height: auto" />
                        <img src="{{ asset('media/manual-voucher/page-0002.jpg') }}" alt="img" class="mw-100"
                            style="width: 100%; height: auto" />
                        <img src="{{ asset('media/manual-voucher/page-0003.jpg') }}" alt="img" class="mw-100"
                            style="width: 100%; height: auto" />
                        <img src="{{ asset('media/manual-voucher/page-0004.jpg') }}" alt="img" class="mw-100"
                            style="width: 100%; height: auto" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#modal_pago_plataforma">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        // canal_pago select2
        $(document).ready(function () {
            $('#canal_pago').select2({
                placeholder: 'Seleccione su canal de pago',
                allowClear: true,
                width: '100%',
                selectOnClose: true,
                language: {
                    noResults: function () {
                        return "No se encontraron resultados";
                    },
                    searching: function () {
                        return "Buscando..";
                    }
                }
            });
            $('#canal_pago').on('change', function(){
                @this.set('canal_pago', this.value);
            });
            Livewire.hook('message.processed', (message, component) => {
                $('#canal_pago').select2({
                    placeholder: 'Seleccione su canal de pago',
                    allowClear: true,
                    width: '100%',
                    selectOnClose: true,
                    language: {
                        noResults: function () {
                            return "No se encontraron resultados";
                        },
                        searching: function () {
                            return "Buscando..";
                        }
                    }
                });
                $('#canal_pago').on('change', function(){
                    @this.set('canal_pago', this.value);
                });
            });
        });
        // concepto_pago select2
        $(document).ready(function () {
            $('#concepto_pago').select2({
                placeholder: 'Seleccione su concepto de pago',
                allowClear: true,
                width: '100%',
                selectOnClose: true,
                language: {
                    noResults: function () {
                        return "No se encontraron resultados";
                    },
                    searching: function () {
                        return "Buscando..";
                    }
                }
            });
            $('#concepto_pago').on('change', function(){
                @this.set('concepto_pago', this.value);
            });
            Livewire.hook('message.processed', (message, component) => {
                $('#concepto_pago').select2({
                    placeholder: 'Seleccione su concepto de pago',
                    allowClear: true,
                    width: '100%',
                    selectOnClose: true,
                    language: {
                        noResults: function () {
                            return "No se encontraron resultados";
                        },
                        searching: function () {
                            return "Buscando..";
                        }
                    }
                });
                $('#concepto_pago').on('change', function(){
                    @this.set('concepto_pago', this.value);
                });
            });
        });
        // grupo select2
        $(document).ready(function () {
            $('#grupo').select2({
                placeholder: 'Seleccione su grupo',
                allowClear: true,
                width: '100%',
                selectOnClose: true,
                language: {
                    noResults: function () {
                        return "No se encontraron resultados";
                    },
                    searching: function () {
                        return "Buscando..";
                    }
                }
            });
            $('#grupo').on('change', function(){
                @this.set('grupo', this.value);
            });
            Livewire.hook('message.processed', (message, component) => {
                $('#grupo').select2({
                    placeholder: 'Seleccione su grupo',
                    allowClear: true,
                    width: '100%',
                    selectOnClose: true,
                    language: {
                        noResults: function () {
                            return "No se encontraron resultados";
                        },
                        searching: function () {
                            return "Buscando..";
                        }
                    }
                });
                $('#grupo').on('change', function(){
                    @this.set('grupo', this.value);
                });
            });
        });
        // filtro_concepto_pago select2
        $(document).ready(function () {
            $('#filtro_concepto_pago').select2({
                placeholder: 'Seleccione su concepto de pago',
                allowClear: true,
                width: '100%',
                selectOnClose: true,
                language: {
                    noResults: function () {
                        return "No se encontraron resultados";
                    },
                    searching: function () {
                        return "Buscando..";
                    }
                }
            });
            $('#filtro_concepto_pago').on('change', function(){
                @this.set('filtro_concepto_pago', this.value);
            });
            Livewire.hook('message.processed', (message, component) => {
                $('#filtro_concepto_pago').select2({
                    placeholder: 'Seleccione su concepto de pago',
                    allowClear: true,
                    width: '100%',
                    selectOnClose: true,
                    language: {
                        noResults: function () {
                            return "No se encontraron resultados";
                        },
                        searching: function () {
                            return "Buscando..";
                        }
                    }
                });
                $('#filtro_concepto_pago').on('change', function(){
                    @this.set('filtro_concepto_pago', this.value);
                });
            });
        });
    </script>
@endpush
