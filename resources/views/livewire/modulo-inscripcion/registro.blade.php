<div>
    {{-- alerta --}}
    <div class="alert bg-light-primary border border-primary d-flex align-items-center gap-2 p-5">
        <span class="svg-icon svg-icon-2hx svg-icon-primary me-3">
            <i class="fa-sharp fa-solid fa-circle-info fs-1 text-primary"></i>
        </span>
        <div class="d-flex flex-column">
            <h4 class="mb-1 text-dark">
                Nota
            </h4>
            <span class="fw-mediun">
                Al terminar con el registro de sus datos espere un momento, ya que se estará generando su ficha de inscripción.
            </span>
        </div>
    </div>
    {{-- pasos de inscripcion --}}
    <div class="row mt-8">
        <div class="col-md-4">
            <div class="alert @if($paso == 1) bg-primary @else bg-secondary @endif p-5">
                <div class="text-center w-100 @if($paso == 1) text-light @else text-muted @endif">
                    <span class="fw-bolder fs-3 text-center">
                        Paso 1
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="alert @if($paso == 2) bg-primary @else bg-secondary @endif p-5">
                <div class="text-center w-100 @if($paso == 2) text-light @else text-muted @endif">
                    <span class="fw-bolder fs-3 text-center">
                        Paso 2
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="alert @if($paso == 3) bg-primary @else bg-secondary @endif p-5">
                <div class="text-center w-100 @if($paso == 3) text-light @else text-muted @endif">
                    <span class="fw-bolder fs-3 text-center">
                        Paso 3
                    </span>
                </div>
            </div>
        </div>
    </div>
    {{-- formulario --}}
    <form autocomplete="off" class="mt-0">
        {{-- formulario paso 1 --}}
        @if ($paso === 1)
            <div class="card shadow-sm mt-5">
                <div class="card-header">
                    <h3 class="card-title fw-bold fs-2">
                        Selección de Modalidad y Programa
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-5">
                                <label for="modalidad" class="required form-label">
                                    Modalidad
                                </label>
                                <select wire:model="modalidad" class="form-select @error('modalidad') is-invalid @enderror" id="modalidad" data-control="select2" data-placeholder="Seleccione su modalidad" data-allow-clear="true">
                                    <option></option>
                                    @foreach ($modalidad_array as $item)
                                    <option value="{{ $item->id_modalidad }}">{{ $item->modalidad }}</option>
                                    @endforeach
                                </select>
                                @error('modalidad')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-5">
                                <label for="programa" class="required form-label">
                                    Programa
                                </label>
                                <select wire:model="programa" class="form-select @error('programa') is-invalid @enderror" id="programa" data-control="select2" data-placeholder="Seleccione su programa">
                                    <option></option>
                                    @if ($modalidad)
                                    @foreach ($programa_array as $item)
                                    <option value="{{ $item->id_programa_proceso }}">
                                        {{ $item->programa_plan->programa->sede->sede }} /
                                        {{ $item->programa_plan->programa->programa }} /
                                        {{ $item->programa_plan->programa->subprograma }}
                                        @if($item->programa_plan->programa->mencion) / {{ $item->programa_plan->programa->mencion }} @endif
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                                @error('programa')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- botones --}}
            <div class="d-flex justify-content-between mt-8">
                <div></div>
                <button type="button" class="btn btn-primary hover-elevate-down" style="width: 150px" wire:click.prevent="paso_2()">
                    Siguiente
                </button>
            </div>
        @endif
        {{-- formulario paso 2 --}}
        @if ($paso === 2)
            <div class="card shadow-sm mt-5">
                <div class="card-header">
                    <h3 class="card-title fw-bold fs-2">
                        Información Personal
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-5">
                                <label for="paterno" class="required form-label">
                                    Apellidos Paterno
                                </label>
                                <input type="text" wire:model="paterno" class="form-control @error('paterno') is-invalid @enderror" id="paterno" placeholder="Ingrese su apellido paterno">
                                @error('paterno')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-5">
                                <label for="materno" class="required form-label">
                                    Apellidos Materno
                                </label>
                                <input type="text" wire:model="materno" class="form-control @error('materno') is-invalid @enderror" id="materno" placeholder="Ingrese su apellido materno">
                                @error('materno')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-5">
                                <label for="nombres" class="required form-label">
                                    Nombres
                                </label>
                                <input type="text" wire:model="nombres" class="form-control @error('nombres') is-invalid @enderror" id="nombres" placeholder="Ingrese sus nombres">
                                @error('nombres')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-5">
                                <label for="fecha_nacimiento" class="required form-label">
                                    Fecha de Nacimiento
                                </label>
                                <input type="date" wire:model="fecha_nacimiento" class="form-control @error('fecha_nacimiento') is-invalid @enderror" id="fecha_nacimiento">
                                @error('fecha_nacimiento')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-5">
                                <label for="genero" class="required form-label">
                                    Genero
                                </label>
                                <select wire:model="genero" class="form-select @error('genero') is-invalid @enderror" id="genero" data-control="select2" data-placeholder="Seleccione su genero" data-allow-clear="true">
                                    <option></option>
                                    @foreach ($genero_array as $item)
                                    <option value="{{ $item->id_genero }}">{{ $item->genero }}</option>
                                    @endforeach
                                </select>
                                @error('genero')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-5">
                                <label for="estado_civil" class="required form-label">
                                    Estado Civil
                                </label>
                                <select wire:model="estado_civil" class="form-select @error('genero') is-invalid @enderror" id="estado_civil" data-control="select2" data-placeholder="Seleccione su estado civil" data-allow-clear="true">
                                    <option></option>
                                    @foreach ($estado_civil_array as $item)
                                    <option value="{{ $item->id_estado_civil }}">{{ $item->estado_civil }}</option>
                                    @endforeach
                                </select>
                                @error('estado_civil')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-5">
                                <label for="discapacidad" class="form-label">
                                    Discapacidad
                                </label>
                                <select wire:model="discapacidad" class="form-select @error('discapacidad') is-invalid @enderror" id="discapacidad"  data-control="select2" data-placeholder="Seleccione su discapacidad" data-allow-clear="true">
                                    <option></option>
                                    @foreach ($tipo_discapacidad_array as $item)
                                    <option value="{{ $item->id_discapacidad }}">{{ $item->discapacidad }}</option>
                                    @endforeach
                                </select>
                                @error('discapacidad')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-5">
                                <label for="celular" class="required form-label">
                                    Número de Celular
                                </label>
                                <input type="number" wire:model="celular" class="form-control @error('celular') is-invalid @enderror" id="celular" placeholder="Ingrese su número de celular">
                                @error('celular')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-5">
                                <label for="celular_opcional" class="form-label">
                                    Número de Celular Opcional
                                </label>
                                <input type="number" wire:model="celular_opcional" class="form-control @error('celular_opcional') is-invalid @enderror" id="celular_opcional" placeholder="Ingrese su número de celular opcional">
                                @error('celular_opcional')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-5">
                                <label for="email" class="required form-label">
                                    Correo Electrónico
                                </label>
                                <input type="email" wire:model="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Ingrese su correo electrónico">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-5">
                                <label for="email_opcional" class="form-label">
                                    Correo Electrónico Opcional
                                </label>
                                <input type="email" wire:model="email_opcional" class="form-control @error('email_opcional') is-invalid @enderror" id="email_opcional" placeholder="Ingrese su correo electrónico opcional">
                                @error('email_opcional')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-sm mt-10">
                <div class="card-header">
                    <h3 class="card-title fw-bold fs-2">
                        Información de Dirección y Lugar de Nacimiento
                    </h3>
                </div>
                <div class="card-body">
                    <div class="mb-5">
                        <span class="fw-bold fs-3">
                            Datos de Dirección
                        </span>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-5">
                                <label for="ubigeo_direccion" class="required form-label">
                                    Ubigeo de Dirección
                                </label>
                                <select wire:model="ubigeo_direccion" class="form-select @error('ubigeo_direccion') is-invalid @enderror" id="ubigeo_direccion" data-control="select2" data-placeholder="Seleccione su ubigeo de direccion" data-allow-clear="true">
                                    <option></option>
                                    @foreach ($ubigeo_direccion_array as $item)
                                    <option value="{{ $item->id_ubigeo }}">{{ $item->ubigeo }} / {{ $item->departamento }} / {{ $item->provincia }} / {{ $item->distrito }}</option>
                                    @endforeach
                                </select>
                                @error('ubigeo_direccion')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        @if ($ubigeo_direccion == 1893)
                        <div class="col-md-12">
                            <div class="mb-5">
                                <label for="pais_direccion" class="required form-label">
                                    País de Dirección
                                </label>
                                <input type="text" wire:model="pais_direccion" class="form-control @error('pais_direccion') is-invalid @enderror" id="pais_direccion" placeholder="Ingrese el pais del ubigeo seleccionado">
                                @error('pais_direccion')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        @endif
                        <div class="col-md-12">
                            <div class="mb-5">
                                <label for="direccion" class="required form-label">
                                    Dirección
                                </label>
                                <input type="text" wire:model="direccion" class="form-control @error('direccion') is-invalid @enderror" id="direccion" placeholder="Ingrese su dirección">
                                @error('direccion')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-5">
                        <span class="fw-bold fs-3">
                            Datos de Nacimiento
                        </span>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-5">
                                <label for="ubigeo_nacimiento" class="required form-label">
                                    Ubigeo de Nacimiento
                                </label>
                                <select wire:model="ubigeo_nacimiento" class="form-select @error('ubigeo_nacimiento') is-invalid @enderror" id="ubigeo_nacimiento" data-control="select2" data-placeholder="Seleccione su ubigeo de nacimiento" data-allow-clear="true">
                                    <option></option>
                                    @foreach ($ubigeo_nacimiento_array as $item)
                                    <option value="{{ $item->id_ubigeo }}">{{ $item->ubigeo }} / {{ $item->departamento }} / {{ $item->provincia }} / {{ $item->distrito }}</option>
                                    @endforeach
                                </select>
                                @error('ubigeo_nacimiento')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        @if ($ubigeo_nacimiento == 1893)
                        <div class="col-md-12">
                            <div class="mb-5">
                                <label for="pais_nacimiento" class="required form-label">
                                    Pais de Nacimiento
                                </label>
                                <input type="text" wire:model="pais_nacimiento" class="form-control @error('pais_nacimiento') is-invalid @enderror" id="pais_nacimiento" placeholder="Ingrese su pais de nacimiento">
                                @error('pais_nacimiento')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card shadow-sm mt-10">
                <div class="card-header">
                    <h3 class="card-title fw-bold fs-2">
                        Información de Grado Académico, Universidad y Experiencia Laboral
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-5">
                                <label for="grado_academico" class="required form-label">
                                    Grado Académico o Titulo
                                </label>
                                <select wire:model="grado_academico" class="form-select @error('grado_academico') is-invalid @enderror" id="grado_academico"  data-control="select2" data-placeholder="Seleccione su grado academico" data-allow-clear="true">
                                    <option></option>
                                    @foreach ($grado_academico_array as $item)
                                        <option value="{{ $item->id_grado_academico }}">{{ $item->grado_academico }}</option>
                                    @endforeach
                                </select>
                                @error('grado_academico')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-5">
                                <label for="especialidad_carrera" class="required form-label">
                                    Especialidad de Carrera
                                </label>
                                <input type="text" wire:model="especialidad_carrera" class="form-control @error('especialidad_carrera') is-invalid @enderror" id="especialidad_carrera" placeholder="Ingrese la especialidad de su carrera">
                                @error('especialidad_carrera')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-5">
                                <label for="año_egreso" class="required form-label">
                                    Año de Egreso de la Universidad o Maestría
                                </label>
                                <input type="number" wire:model="año_egreso" class="form-control @error('año_egreso') is-invalid @enderror" id="año_egreso" placeholder="Ingrese su año egreso">
                                @error('año_egreso')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-5">
                                <label for="universidad" class="required form-label">
                                    Universidad de Egreso
                                </label>
                                <select wire:model="universidad" class="form-select @error('universidad') is-invalid @enderror" id="universidad" data-control="select2" data-placeholder="Seleccione su universidad" data-allow-clear="true">
                                    <option></option>
                                    @foreach ($universidad_array as $item)
                                        <option value="{{ $item->id_universidad }}">{{ $item->universidad }}</option>
                                    @endforeach
                                </select>
                                @error('universidad')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-5">
                                <label for="centro_trabajo" class="required form-label">
                                    Centro de Trabajo
                                </label>
                                <input type="text" wire:model="centro_trabajo" class="form-control @error('centro_trabajo') is-invalid @enderror" id="centro_trabajo" placeholder="Ingrese su centro de trabajo">
                                @error('centro_trabajo')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- botones --}}
            <div class="d-flex justify-content-between mt-8">
                <button type="button" class="btn btn-secondary hover-elevate-down" style="width: 150px" wire:click.prevent="paso_1()">
                    Regresar
                </button>
                <button type="button" class="btn btn-primary hover-elevate-down" style="width: 150px" wire:click.prevent="paso_3()">
                    Siguiente
                </button>
            </div>
        @endif
        {{-- formulario paso 3 --}}
        @if ($paso === 3)
            {{-- alerta --}}
            <div class="alert bg-light-danger border border-danger d-flex align-items-center gap-2 p-5 mb-8 mt-3">
                <span class="svg-icon svg-icon-2hx svg-icon-primary me-3">
                    <div class="form-check form-check-custom form-check-primary">
                        <input class="form-check-input" type="checkbox" wire:model="check_expediente" />
                    </div>
                </span>
                <div class="d-flex flex-column">
                    <h4 class="mb-1 text-dark">
                        ¡Importante! - La casilla debe ser marcada sólo si no cumple con el requisito de constancia de registro de la SUNEDU.
                    </h4>
                    <span class="fw-mediun">
                        En caso de no disponer de mi constancia de registro de la SUNEDU, presentaré un documento que acredite que se encuentra en trámite (resolución de grado, grado academico, entre otros).
                    </span>
                </div>
            </div>
            {{-- expedientes --}}
            <div class="card shadow-sm mt-5">
                <div class="card-header">
                    <h3 class="card-title fw-bold fs-2">
                        Ingreso de Expedientes
                    </h3>
                </div>
                <div class="card-body">
                    <div class="alert bg-light-danger d-flex flex-column flex-sm-row p-5 mb-8">
                        <div class="d-flex flex-column pe-0 pe-sm-10">
                            <span class="fw-bold">
                                Todos los documentos deben ser en formato <strong>PDF</strong>. (cualquier otro formato de archivo no es aceptado/compatible)
                            </span>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0 align-middle table-rounded table-hover border gy-5 gs-5 gx-5">
                            <thead>
                                <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                                    <th colspan="3" class="fw-bold fs-4">Documentos</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($expediente_array)
                                    @foreach ($expediente_array as $item)
                                    @php
                                        $exped_inscripcion = App\Models\ExpedienteInscripcion::where('id_expediente_admision', $item->id_expediente_admision)->where('id_inscripcion', $id_inscripcion)->first();
                                    @endphp
                                    <tr>
                                        <td>
                                            {{ $item->expediente->expediente }} @if ($item->expediente->expediente_requerido == 1) <span class="text-danger" style="font-size: 0.9rem">(Obligatorio)</span> @endif
                                        </td>
                                        <td align="center" class="col-md-2">
                                            @if ($exped_inscripcion)
                                            <span class="badge badge-primary">Enviado</span>
                                            @else
                                            <span class="badge badge-danger">No enviado</span>
                                            @endif
                                        </td>
                                        <td align="center" class="col-md-2">
                                            <a href="#modal_registro_expediente" wire:click="cargar_modal_expediente({{ $item->id_expediente_admision }})" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal_registro_expediente">
                                                Subir
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="3">
                                        <div class="text-center fw-bold text-muted">Seleccione su programa para ver sus expedientes requeridos.</div>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- declaracion jurada --}}
            <div class="alert bg-light-secondary border border-secondary d-flex align-items-center gap-2 p-5 mb-8 mt-8">
                <div class="form-check form-check-custom form-check-solid">
                    <input class="form-check-input @error('declaracion_jurada') is-invalid @enderror" type="checkbox" wire:model="declaracion_jurada" id="declaracion_jurada"/>
                    <label class="fw-bold fs-5 @error('declaracion_jurada') text-danger @enderror ms-5" for="declaracion_jurada">
                        DECLARO BAJO JURAMENTO QUE LOS DOCUMENTOS PRESENTADOS Y LOS DATOS CONSIGNADOS EN EL PRESENTE PROCESO DE ADMISIÓN SON FIDEDIGNOS
                    </label>
                </div>
            </div>
            {{-- botones --}}
            <div class="d-flex justify-content-between mt-8">
                <button type="button" class="btn btn-secondary hover-elevate-down" style="width: 150px" wire:click.prevent="paso_2()">
                    Regresar
                </button>
                <button type="button" wire:click.prevent="registrar_inscripcion()" class="btn btn-primary hover-elevate-down" style="width: 150px">
                    Registrar
                </button>
            </div>
        @endif
    </form>
    {{-- modal subida de expediente --}}
    <div wire:ignore.self class="modal fade" tabindex="-1" id="modal_registro_expediente">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        Subir Expediente
                    </h3>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close" wire:click="limpiar_registro_pago">
                        <i class="bi bi-x fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <div class="modal-body">
                    <form autocomplete="off">
                        <div class="mb-5">
                            <label for="expediente" class="required form-label">
                                {{ $expediente_nombre }}
                            </label>
                            <input type="file" wire:model="expediente" class="form-control mb-3 @error('expediente') is-invalid @enderror" id="upload{{ $iteration }}" accept=".pdf" />
                            <span class="form-text text-muted fst-italic">
                                Nota: El expediente debe ser en formato PDF con un maximo de 10MB. <br>
                            </span>
                            @error('expediente')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" wire:click="limpiar_modal_expediente">
                        Cerrar
                    </button>
                    <button type="button" wire:click="registrar_expediente" wire:loading.remove wire:target="registrar_expediente" class="btn btn-primary" @if($expediente == null) disabled @endif>
                        Registrar Expediente
                    </button>
                    <button wire:loading wire:target="registrar_expediente" class="btn btn-primary" type="button" disabled>
                        Procesando...
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        // modalidad select2
        $(document).ready(function () {
            $('#modalidad').select2({
                placeholder: 'Seleccione su modalidad',
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
            $('#modalidad').on('change', function(){
                @this.set('modalidad', this.value);
            });
            Livewire.hook('message.processed', (message, component) => {
                $('#modalidad').select2({
                    placeholder: 'Seleccione su modalidad',
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
                // $('#modalidad').on('change', function(){
                //     @this.set('modalidad', this.value);
                // });
            });
        });
        // programa select2
        $(document).ready(function () {
            $('#programa').select2({
                placeholder: 'Seleccione su programa',
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
            $('#programa').on('change', function(){
                @this.set('programa', this.value);
                console.log(this.value);
            });
            Livewire.hook('message.processed', (message, component) => {
                $('#programa').select2({
                    placeholder: 'Seleccione su programa',
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
                // $('#programa').on('change', function(){
                //     @this.set('programa', this.value);
                //     console.log(this.value);
                // });
            });
        });
        // ubigeo_direccion select2
        $(document).ready(function () {
            $('#ubigeo_direccion').select2({
                placeholder: 'Seleccione su ubigeo de direccion',
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
            $('#ubigeo_direccion').on('change', function(){
                @this.set('ubigeo_direccion', this.value);
            });
            Livewire.hook('message.processed', (message, component) => {
                $('#ubigeo_direccion').select2({
                    placeholder: 'Seleccione su ubigeo de direccion',
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
                $('#ubigeo_direccion').on('change', function(){
                    @this.set('ubigeo_direccion', this.value);
                });
            });
        });
        // ubigeo_nacimiento select2
        $(document).ready(function () {
            $('#ubigeo_nacimiento').select2({
                placeholder: 'Seleccione su ubigeo de direccion',
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
            $('#ubigeo_nacimiento').on('change', function(){
                @this.set('ubigeo_nacimiento', this.value);
            });
            Livewire.hook('message.processed', (message, component) => {
                $('#ubigeo_nacimiento').select2({
                    placeholder: 'Seleccione su ubigeo de direccion',
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
                $('#ubigeo_nacimiento').on('change', function(){
                    @this.set('ubigeo_nacimiento', this.value);
                });
            });
        });
        // genero select2
        $(document).ready(function () {
            $('#genero').select2({
                placeholder: 'Seleccione su genero',
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
            $('#genero').on('change', function(){
                @this.set('genero', this.value);
            });
            Livewire.hook('message.processed', (message, component) => {
                $('#genero').select2({
                    placeholder: 'Seleccione',
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
                $('#genero').on('change', function(){
                    @this.set('genero', this.value);
                });
            });
        });
        // estado_civil select2
        $(document).ready(function () {
            $('#estado_civil').select2({
                placeholder: 'Seleccione su estado civil',
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
            $('#estado_civil').on('change', function(){
                @this.set('estado_civil', this.value);
            });
            Livewire.hook('message.processed', (message, component) => {
                $('#estado_civil').select2({
                    placeholder: 'Seleccione su estado civil',
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
                $('#estado_civil').on('change', function(){
                    @this.set('estado_civil', this.value);
                });
            });
        });
        // discapacidad select2
        $(document).ready(function () {
            $('#discapacidad').select2({
                placeholder: 'Seleccione su discapacidad',
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
            $('#discapacidad').on('change', function(){
                @this.set('discapacidad', this.value);
            });
            Livewire.hook('message.processed', (message, component) => {
                $('#discapacidad').select2({
                    placeholder: 'Seleccione',
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
                $('#discapacidad').on('change', function(){
                    @this.set('discapacidad', this.value);
                });
            });
        });
        // grado_academico select2
        $(document).ready(function () {
            $('#grado_academico').select2({
                placeholder: 'Seleccione su grado academico',
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
            $('#grado_academico').on('change', function(){
                @this.set('grado_academico', this.value);
            });
            Livewire.hook('message.processed', (message, component) => {
                $('#grado_academico').select2({
                    placeholder: 'Seleccione su grado academico',
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
                $('#grado_academico').on('change', function(){
                    @this.set('grado_academico', this.value);
                });
            });
        });
        // universidad select2
        $(document).ready(function () {
            $('#universidad').select2({
                placeholder: 'Seleccione universidad',
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
            $('#universidad').on('change', function(){
                @this.set('universidad', this.value);
            });
            Livewire.hook('message.processed', (message, component) => {
                $('#universidad').select2({
                    placeholder: 'Seleccione universidad',
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
                $('#universidad').on('change', function(){
                    @this.set('universidad', this.value);
                });
            });
        });
    </script>
@endpush
