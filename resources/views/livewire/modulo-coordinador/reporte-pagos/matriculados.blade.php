<div>
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Reporte de Pagos de Matriculados - @if ($programa_proceso->mencion)
                        {{ ucfirst(strtolower($programa_proceso->programa)) }} en {{ ucwords(strtolower($programa_proceso->subprograma)) }} con Mencion en {{ ucwords(strtolower($programa_proceso->mencion)) }}
                    @else
                        {{ ucfirst(strtolower($programa_proceso->programa)) }} en {{ ucwords(strtolower($programa_proceso->subprograma)) }}
                    @endif - Modalidad {{ $programa_proceso->id_modalidad == 2 ? 'a Distancia' : 'Presencial' }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('coordinador.inicio') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('coordinador.reporte-pagos') }}" class="text-muted text-hover-primary">Reporte de Pagos</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        Reporte de Pagos de Matriculados
                    </li>
                </ul>
            </div>
            <div class="d-flex flex-stack">
                <div class="d-flex align-items-center text-center gap-2 gap-lg-3 ms-5">
                    {{-- <button type="button"
                        wire:click="exportar_excel"
                        class="btn btn-success fw-bold"
                        >
                        Descargar Reporte (Excel)
                    </button> --}}
                    <a href="{{ route('coordinador.reporte-pagos-pdf', [
                        'id_programa_proceso' => $id_programa_proceso,
                        'id_grupo' => $id_grupo,
                        ]) }}"
                        target="_blank"
                        class="btn btn-primary fw-bold"
                        >
                        Descargar Reporte (PDF)
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="row mb-5 mb-xl-10">
                <div class="col-md-12 mb-md-5 mb-xl-10">
                    {{-- alerta --}}
                    <div class="alert bg-light-primary border border-3 border-primary d-flex align-items-center p-5 mb-5">
                        <i class="ki-outline ki-information-5 fs-2qx me-4 text-primary"></i>
                        <div class="d-flex flex-column gap-2">
                            <span class="fw-bold fs-5">
                                Aquí se le mostrara el reporte de pagos de los matriculados en el programa y grupo seleccionado.
                            </span>
                        </div>
                    </div>
                    {{-- card monto de pagos --}}
                    <div class="card shadow-sm">
                        <div class="card-body mb-0">
                            <div class="table-responsive">
                                <div class="d-flex flex-column flex-md-row align-items-center mb-5 w-100">
                                    <div class="col-md-4 pe-md-3">
                                        <select wire:model="gestionMatricula" class="form-select w-100">
                                            @if (!$tienePrimerCiclo)
                                                <option value="0">
                                                    Ciclo I
                                                </option>
                                            @endif
                                            @foreach ($gestionesMatricula as $item)
                                                <option value="{{ $item->id_matricula_gestion }}">
                                                    Ciclo {{ $item->ciclo->ciclo }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 px-md-3"></div>
                                    <div class="col-md-4 ps-md-3">
                                        <input type="search" wire:model="search" class="form-control w-100" placeholder="Buscar..."/>
                                    </div>
                                </div>
                                <table class="table table-hover table-rounded align-middle table-row-bordered border mb-0 gy-5 gs-5">
                                    <thead class="bg-light-warning">
                                        <tr class="fw-bold fs-5 text-gray-800 border-bottom-2 border-gray-200">
                                            <th>#</th>
                                            <th>Codigo Estudiante</th>
                                            <th>Numero Documento</th>
                                            <th>Apellidos y Nombres</th>
                                            <th>Monto a Pagar</th>
                                            <th>Monto Pagado</th>
                                            <th>Deuda</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($matriculados as $item)
                                            <tr class="fs-6">
                                                <td class="fw-bold">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td>
                                                    {{ $item->admitido_codigo }}
                                                </td>
                                                <td>
                                                    {{ $item->numero_documento }}
                                                </td>
                                                <td>
                                                    {{ $item->nombre_completo }}
                                                </td>
                                                <td>
                                                    S/. {{ number_format(dataPagoMatricula($item, $item->id_matricula)['monto_total'], 2, ',', '.') }}
                                                </td>
                                                <td class="fw-bold">
                                                    S/. {{ number_format(dataPagoMatricula($item, $item->id_matricula)['monto_pagado'], 2, ',', '.')}}
                                                </td>
                                                <td class="text-danger">
                                                    S/. {{ number_format(dataPagoMatricula($item, $item->id_matricula)['deuda'], 2, ',', '.')}}
                                                </td>
                                            </tr>
                                        @empty
                                            @if ($search != '')
                                                <tr>
                                                    <td colspan="7" class="text-center text-muted">
                                                        No se encontraron resultados para la busqueda "{{ $search }}"
                                                    </td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td colspan="7" class="text-center text-muted">
                                                        No hay registros
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
