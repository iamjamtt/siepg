<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Inicio
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="javascript:void(0)" class="text-muted">
                            Inicio
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="row g-3 mb-5 mb-xl-10">
                <div class="col-12 col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-body py-10">
                            <div class="row g-0">
                                <div class="col-12">
                                    <form class="row g-3" wire:submit.prevent="buscarAlumno">
                                        <div class="col-md-12 col-lg-12 col-xl-10 mx-auto">
                                            <div class="input-group">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class="ki-outline ki-profile-circle fs-1"></i>
                                                </span>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    wire:model.defer="buscar"
                                                    placeholder="Buscar alumno por codigo, nombre, apellido o DNI..."
                                                />
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-lg-12 col-xl-10 mx-auto">
                                            <button type="submit" class="btn btn-outline btn-outline-primary w-100">
                                                <i class="ki-outline ki-magnifier fs-1"></i>
                                                Buscar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($mostrarAlumnos)
                    <div class="col-12 col-lg-6">
                        <div class="card card-xl-stretch shadow-sm">
                            <div class="card-header border-0 pt-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold fs-3 mb-1">
                                        Alumnos
                                    </span>
                                    <span class="text-muted mt-1 fw-semibold fs-7">
                                        Mostrar todos los alumnos
                                    </span>
                                </h3>
                            </div>
                            <div class="card-body py-3">
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="kt_table_widget_7_tab_1" role="tabpanel">
                                        <div class="table-responsive">
                                            <table class="table align-middle gs-0 gy-3">
                                                <thead>
                                                    <tr>
                                                        <th class="p-0 w-50px"></th>
                                                        <th class="p-0"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($alumnos as $alumno)
                                                        <tr>
                                                            <td>
                                                                <div class="symbol symbol-50px me-2">
                                                                    <span class="symbol-label bg-light-success">
                                                                        <i class="ki-outline ki-user fs-2x text-success"></i>
                                                                    </span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span class="text-gray-900 fw-bold mb-1 fs-6">
                                                                    {{ $alumno->nombre_completo }}
                                                                </span>
                                                                <span class="text-muted fw-semibold d-block fs-7">
                                                                    {{ $alumno->admitido_codigo }} - {{ $alumno->numero_documento }}
                                                                </span>
                                                                <span class="text-muted fw-semibold d-block fs-7">
                                                                    @if ($alumno->mencion)
                                                                        {{ $alumno->subprograma }} CON MENCION EN {{ $alumno->mencion }}
                                                                    @else
                                                                        {{ $alumno->programa }} EN {{ $alumno->subprograma }}
                                                                    @endif
                                                                </span>
                                                            </td>
                                                            <td class="text-end">
                                                                <a
                                                                    href="{{ route('record.buscar', $alumno->id_admitido) }}"
                                                                    target="_blank"
                                                                    class="btn btn-sm btn-secondary"
                                                                >
                                                                    Ver record academico
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="3">
                                                                <div class="text-center">
                                                                    <span class="text-muted fw-semibold fs-7">
                                                                        No se encontraron registros
                                                                    </span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                    <tr>
                                                        <td colspan="3">
                                                            {{ $alumnos->links() }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
