<div>
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Estado de Cuenta
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('plataforma.inicio') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        Estado de Cuenta
                    </li>
                </ul>
            </div>
            {{-- <div class="d-flex align-items-center gap-2 gap-lg-3">
                <a href="{{ route('plataforma.estado-cuenta-ficha', ['id_admitido' => $admitido->id_admitido]) }}" target="_blank" class="btn fw-bold btn-primary">
                    Descargar Estado de Cuenta
                </a>
            </div> --}}
        </div>
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="row mb-5 mb-xl-10">
                <div class="col-md-12 mb-md-5 mb-xl-10">
                    {{-- alerta  --}}
                    <div class="alert bg-light-primary border border-3 border-primary d-flex align-items-center p-5 mb-5">
                        <i class="ki-duotone ki-information-5 fs-2qx me-4 text-primary">
                            <i class="path1"></i>
                            <i class="path2"></i>
                            <i class="path3"></i>
                        </i>
                        <div class="d-flex flex-column">
                            <span class="fw-bold fs-5">
                                Acontinuación se muestra la lista de sus pagos realizados y pendientes.
                            </span>
                        </div>
                    </div>

                    <div class="row mb-5 g-5">
                        <div class="col-md-4">
                            <div class="card shadow-sm">
                                <div class="pt-8 pb-6 px-7">
                                    <div class="card-title d-flex flex-column">
                                        <span class="fs-3hx fw-bold text-gray-800 me-2 lh-1 ls-n2">
                                            S/. {{ number_format($monto_total, 2, ',', ' ') }}
                                        </span>
                                        <br>
                                        <span class="text-gray-700 pt-1 fw-bold fs-4">
                                            Monto Total a Pagar
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow-sm">
                                <div class="pt-8 pb-6 px-7">
                                    <div class="card-title d-flex flex-column">
                                        <span class="fs-3hx fw-bold text-danger me-2 lh-1 ls-n2">
                                            S/. {{ number_format($deuda, 2, ',', ' ') }}
                                        </span>
                                        <br>
                                        <span class="text-gray-700 pt-1 fw-bold fs-4">
                                            Deuda
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light-success card-bordered shadow-sm">
                                <div class="pt-8 pb-6 px-7">
                                    <div class="card-title d-flex flex-column">
                                        <span class="fs-3hx fw-bold text-success me-2 lh-1 ls-n2">
                                            S/. {{ number_format($monto_pagado, 2, ',', ' ') }}
                                        </span>
                                        <br>
                                        <span class="text-gray-700 pt-1 fw-bold fs-4">
                                            Monto Total Pagado
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- header de la tabla --}}
                    <div class="card p-5 mb-5">
                        <div class="row g-3">
                            <div class="col-md-4">
                                {{-- <button type="button" class="btn btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary btn-center fw-bold w-100px w-md-125px"
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
                                                Matriculas:
                                            </label>
                                            <div>
                                                <select class="form-select" wire:model="filtro_matricula"
                                                    id="filtro_matricula" data-control="select2"
                                                    data-placeholder="Seleccione su matricua">
                                                    <option value=""></option>
                                                    @foreach ($matriculas as $item)
                                                        <option value="{{ $item->id_matricula }}">
                                                            Matricula N° {{ $loop->iteration }}
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
                                </div> --}}
                            </div>
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <input type="search" wire:model="search" class="form-control w-100" placeholder="Buscar..." />
                            </div>
                        </div>
                    </div>
                    {{-- tabla de pagos --}}
                    <div class="card shadow-sm mb-5">
                        {{-- <div class="card-body mb-0"> --}}
                            <div class="table-responsive">
                                <table class="table table-hover align-middle table-rounded border mb-0 gy-5 gs-5">
                                    <thead class="bg-light-warning">
                                        <tr class="fw-bold fs-5 text-gray-900 border-bottom-2 border-gray-200">
                                            <th>ID</th>
                                            <th class="col-4">Descripción</th>
                                            <th>Operacion</th>
                                            <th>Monto</th>
                                            <th>Fecha</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-700">
                                        @forelse ($mensualidades as $item)
                                        <tr class="fs-6">
                                            <td>
                                                {{ $item->id_mensualidad }}
                                            </td>
                                            <td>
                                                Pago por enseñanza 00{{  $loop->iteration }}
                                            </td>
                                            <td>
                                                {{ $item->pago->pago_operacion }}
                                            </td>
                                            <td>
                                                S/. {{ number_format($item->pago->pago_monto, 2, ',', '.') }}
                                            </td>
                                            <td>
                                                {{ date('d/m/Y', strtotime($item->pago->mensualidad_fecha_creacion)) }}
                                            </td>
                                            <td>
                                                @if ($item->pago->pago_verificacion == 1)
                                                    <span class="badge badge-warning fs-6 px-3 py-2">Pendiente</span>
                                                @elseif ($item->pago->pago_verificacion == 2)
                                                    <span class="badge badge-success fs-6 px-3 py-2">Pagado</span>
                                                @elseif ($item->pago->pago_verificacion == 0 && $item->pago->pago_estado == 0)
                                                    <span class="badge badge-danger fs-6 px-3 py-2">Rechazado</span>
                                                @elseif ($item->pago->pago_verificacion == 0)
                                                    <span class="badge badge-danger fs-6 px-3 py-2">Observado</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr class="fs-6">
                                            <td colspan="7" class="text-center">
                                                <div class="text-muted py-5">
                                                    No se encontraron resultados
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        {{-- </div> --}}
                    </div>
                    {{-- paginacion de la tabla de mensualidades --}}
                    @if ($mensualidades->hasPages())
                        <div class="d-flex justify-content-between mt-5">
                            <div class="d-flex align-items-center text-gray-700">
                                Mostrando {{ $mensualidades->firstItem() }} - {{ $mensualidades->lastItem() }} de {{ $mensualidades->total()}} registros
                            </div>
                            <div>
                                {{ $mensualidades->links() }}
                            </div>
                        </div>
                    @else
                        <div class="d-flex justify-content-between mt-5">
                            <div class="d-flex align-items-center text-gray-700">
                                Mostrando {{ $mensualidades->firstItem() }} - {{ $mensualidades->lastItem() }} de {{ $mensualidades->total()}} registros
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        // filtro_matricula select2
        $(document).ready(function () {
            $('#filtro_matricula').select2({
                placeholder: 'Seleccione su matricula',
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
            $('#filtro_matricula').on('change', function(){
                @this.set('filtro_matricula', this.value);
            });
            Livewire.hook('message.processed', (message, component) => {
                $('#filtro_matricula').select2({
                    placeholder: 'Seleccione su matricula',
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
                $('#filtro_matricula').on('change', function(){
                    @this.set('filtro_matricula', this.value);
                });
            });
        });
    </script>
@endpush
