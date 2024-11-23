<div>
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Gestión de Matricula
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('plataforma.inicio') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Gestión de Matricula</li>
                </ul>
            </div>
            @if ($alumno->admitido_estado == 1)
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <button type="button" class="btn fw-bold btn-primary" wire:click="abrir_modal" wire:loading.attr="disabled" wire:target="abrir_modal">
                        Generar Matricula
                    </button>
                </div>
            @endif
        </div>
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="row mb-5 mb-xl-10">
                <div class="col-md-12 mb-md-5 mb-xl-10">
                    @if ( $matriculas->count() > 0 )
                        {{-- alerta  --}}
                        <div
                            class="alert bg-light-primary border border-3 border-primary d-flex align-items-center p-5 mb-5">
                            <i class="ki-duotone ki-information-5 fs-2qx me-4 text-primary">
                                <i class="path1"></i>
                                <i class="path2"></i>
                                <i class="path3"></i>
                            </i>
                            <div class="d-flex flex-column">
                                <span class="fw-bold fs-5">
                                    Recuerde que solo puede generar su matricula una vez haya terminado de pagar el monton total de su costo por enseñanza.
                                </span>
                            </div>
                        </div>
                        {{-- lista de matriculas registradas --}}
                        @foreach ($matriculas as $item)
                            <div wire:ignore.self class="accordion shadow rounded rounded-3 hover-elevate-up mb-5" id="acordion_ciclos_{{ $item->id_matricula }}">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="acordion_ciclos_{{ $item->id_matricula }}_header_{{ $item->id_matricula }}">
                                        <button class="accordion-button fs-1 py-8 btn-center collapsed bg-light-warning" style="font-weight: 700" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#acordion_ciclos_{{ $item->id_matricula }}_body_{{ $item->id_matricula }}"
                                            aria-expanded="false" aria-controls="acordion_ciclos_{{ $item->id_matricula }}_body_{{ $item->id_matricula }}">
                                            <i class="ki-duotone ki-award fs-3x me-3 text-gray-700">
                                                <i class="path1"></i>
                                                <i class="path2"></i>
                                                <i class="path3"></i>
                                            </i>
                                            <span class="text-gray-800">
                                                MATRICULA N° {{ $loop->iteration }}
                                            </span>
                                        </button>
                                    </h2>
                                    <div id="acordion_ciclos_{{ $item->id_matricula }}_body_{{ $item->id_matricula }}" class="accordion-collapse collapse"
                                        aria-labelledby="acordion_ciclos_{{ $item->id_matricula }}_header_{{ $item->id_matricula }}" data-bs-parent="#acordion_ciclos_{{ $item->id_matricula }}">
                                        <div class="accordion-body">
                                            <div class="row g-5 fs-5">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-4 col-md-3">
                                                            <span>
                                                                Proceso Académico
                                                            </span>
                                                        </div>
                                                        <div class="col-1">
                                                            <span>
                                                                :
                                                            </span>
                                                        </div>
                                                        <div class="col-7 col-md-8">
                                                            <span class="fw-bold text-gray-800">
                                                                {{ $item->admitido->programa_proceso->admision->admision }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-4 col-md-3">
                                                            <span>
                                                                Modalidad
                                                            </span>
                                                        </div>
                                                        <div class="col-1">
                                                            <span>
                                                                :
                                                            </span>
                                                        </div>
                                                        <div class="col-7 col-md-8">
                                                            <span class="fw-bold text-gray-800">
                                                                @if ($item->admitido->programa_proceso->programa_plan->programa->id_modalidad == 1)
                                                                    PRESENCIAL
                                                                @else
                                                                    DISTANCIA
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-4 col-md-3">
                                                            <span>
                                                                Fecha de Matricula
                                                            </span>
                                                        </div>
                                                        <div class="col-1">
                                                            <span>
                                                                :
                                                            </span>
                                                        </div>
                                                        <div class="col-7 col-md-8">
                                                            <span class="fw-bold text-gray-800">
                                                                {{ date('d/m/Y', strtotime($item->fecha_matricula)) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 text-end">
                                                    <a
                                                        href="{{ route('plataforma.matriculas-ficha', ['id_matricula' => $item->id_matricula]) }}"
                                                        target="_blank"
                                                        class="btn btn-info"
                                                    >
                                                        Descargar Ficha de Matricula (pdf)
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        {{-- alerta --}}
                        <div class="card card-body shadow-sm bg-light-info border border-3 border-info d-flex flex-column justify-content-center align-items-center mb-5" style="height: 400px">
                            <div class="bg-body px-10 py-5 rounded-4 mx-auto mb-5">
                                <i class="ki-duotone ki-information-3 fs-5x text-info">
                                    <i class="path1"></i>
                                    <i class="path2"></i>
                                    <i class="path3"></i>
                                </i>
                            </div>
                            <h3 class="card-title mb-5 text-center">
                                No se encontraron matriculas registradas
                            </h3>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{-- modal matricula --}}
    <div wire:ignore.self class="modal fade" tabindex="-1" id="modal_matricula">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        Matricula
                    </h3>

                    <div class="btn btn-icon btn-sm btn-active-light-danger ms-2" wire:click="limpiar_modal" data-bs-dismiss="modal" aria-label="Close">
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
                    <form autocomplete="off" class="row g-3">
                        @if ($matriculas->count() == 0)
                            @if ($grupos->count() > 0)
                                <div class="col-md-12">
                                    <label for="grupo" class="required form-label">
                                        Grupo
                                    </label>
                                    <select class="form-select @error('grupo') is-invalid @enderror" wire:model="grupo" id="grupo" data-control="select2" data-placeholder="Seleccione su grupo" data-allow-clear="true" data-dropdown-parent="#modal_matricula">
                                        <option></option>
                                        @foreach ($grupos as $item)
                                        @php
                                            $contador_matriculados_grupos = obtenerContadorDeMatriculasPorGrupos($alumno->id_programa_proceso, $gestion->id_matricula_gestion ?? 0, $item->id_programa_proceso_grupo);
                                        @endphp
                                        <option
                                            value="{{ $item->id_programa_proceso_grupo }}"
                                            @if ($contador_matriculados_grupos == $item->grupo_cantidad)
                                                disabled
                                            @endif
                                        >
                                            GRUPO {{ $item->grupo_detalle }} - CUPOS: {{ $item->grupo_cantidad - $contador_matriculados_grupos }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('grupo')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif
                        @endif
                        <div class="col-12">
                            <label for="pagos" class="required form-label">
                                Pagos
                            </label>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle table-rounded border mb-0 gy-5 gs-5">
                                    <thead class="bg-light-warning">
                                        <tr class="fw-bold fs-5 text-gray-900 border-bottom-2 border-gray-200">
                                            <th>Concepto Pago</th>
                                            <th class="text-center">Operacion</th>
                                            <th class="text-center">Monto</th>
                                            <th class="text-center">Fecha</th>
                                            <th class="text-center">Estado</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-700">
                                        @forelse ($pagos as $item)
                                        <tr class="fs-6 text-gray-700 fw-semibold">
                                            <td>
                                                {{ $item->concepto_pago->concepto_pago }}
                                            </td>
                                            <td class="text-center">
                                                {{ $item->pago_operacion }}
                                            </td>
                                            <td class="text-center">
                                                S/. {{ number_format($item->pago_monto, 2, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                {{ date('d/m/Y', strtotime($item->pago_fecha)) }}
                                            </td>
                                            <td class="text-center">
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
                                            <td class="text-end">
                                                <div class="form-check">
                                                    <input
                                                        type="checkbox"
                                                        class="form-check-input @error('check_pago') is-invalid @enderror"
                                                        wire:model="check_pago"
                                                        value="{{ $item->id_pago }}"
                                                    />
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr class="fs-6">
                                            <td colspan="6" class="text-center">
                                                <div class="text-muted py-4">
                                                    No se encontraron resultados
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="pagos" class="required form-label">
                                Cursos a Matricular
                            </label>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle table-rounded border mb-0 gy-5 gs-5">
                                    <thead class="bg-light-warning">
                                        <tr class="fw-bold fs-5 text-gray-900 border-bottom-2 border-gray-200">
                                            <th>Codigo</th>
                                            <th>Nombre del Curso</th>
                                            <th class="text-center">Credito</th>
                                            <th class="text-center">Ciclo</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-700">
                                        @forelse ($cursosPrematriculados as $item)
                                            <tr class="fs-6 text-gray-700 fw-semibold">
                                                <td>
                                                    {{ $item->cursoProgramaPlan->curso->curso_codigo }}
                                                </td>
                                                <td>
                                                    {{ $item->cursoProgramaPlan->curso->curso_nombre }}
                                                </td>
                                                <td align="center">
                                                    {{ $item->cursoProgramaPlan->curso->curso_credito }}
                                                </td>
                                                <td align="center">
                                                    CICLO {{ $item->cursoProgramaPlan->curso->ciclo->ciclo }}
                                                </td>
                                                <td class="text-end">
                                                    <div class="form-check">
                                                        <input
                                                            type="checkbox"
                                                            class="form-check-input @error('check_cursos') is-invalid @enderror"
                                                            wire:model="check_cursos"
                                                            value="{{ $item->id_curso_programa_plan }}"
                                                        />
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="fs-6">
                                                <td colspan="5" class="text-center">
                                                    <div class="text-muted py-4">
                                                        No se encontraron resultados
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" wire:click="limpiar_modal">
                        Cerrar
                    </button>
                    <button type="button" wire:click="alerta_generar_matricula" class="btn btn-primary" style="width: 165px" wire:loading.attr="disabled" wire:target="alerta_generar_matricula">
                        <div wire:loading.remove wire:target="alerta_generar_matricula">
                            Generar Matricula
                        </div>
                        <div wire:loading wire:target="alerta_generar_matricula">
                            Generando <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
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
    </script>
@endpush
