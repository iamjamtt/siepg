<div>
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Mi Perfil
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('plataforma.inicio') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Mi perfil</li>
                </ul>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <a href="#modal_perfil" class="btn btn-sm fw-bold btn-primary me-2" data-bs-toggle="modal" data-bs-target="#modal_perfil">
                    Editar Perfil
                </a>
            </div>
        </div>
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="row mb-5 mb-xl-10">
                <div class="col-md-12 mb-md-5 mb-xl-10">
                    {{-- alerta para que el usuario sepa que datos puede modificar --}}
                    <div class="alert bg-light-primary border border-3 border-primary d-flex align-items-center p-5 mb-5">
                        <span class="svg-icon svg-icon-2hx svg-icon-primary me-4">
                            <i class="las la-exclamation-circle fs-1 text-primary"></i>
                        </span>
                        <div class="d-flex flex-column">
                            <span class="fw-bold fs-5">
                                Solo se podrán modificar los siguientes datos: foto de perfil y contraseña.
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="position-relative object-fit-cover rounded-4 mb-10 mb-md-18">
                                <img src="{{ asset('assets/media/auth/bg-login-posgrado.jpg') }}" class="object-fit-cover rounded-4 h-200px h-md-275px h-lg-350px" width="100%" alt="portada unu">
                                <div class="object-fit-cover rounded-4 bg-success opacity-20 h-200px h-md-275px h-lg-350px position-absolute top-0 start-0" style="width: 100%;"></div>
                                <div class="position-absolute" style="top: 50%; left: 50%; transform: translate(-50%, 0%);">
                                    <img src="@if ($usuario->usuario_estudiante_perfil_url) {{ asset($usuario->usuario_estudiante_perfil_url) }} @else {{ asset('assets/media/avatars/blank.png') }} @endif" class="rounded-circle shadow w-150px w-md-250px h-150px h-md-250px" alt="vista previa perfil">
                                </div>
                            </div>
                            <br><br>
                            <div class="text-center">
                                <span class="text-gray-900 fw-bold " style="font-size: 2rem">
                                    {{ ucwords(strtolower($persona->nombre)) }} {{ ucwords(strtolower($persona->apellido_paterno)) }} {{ ucwords(strtolower($persona->apellido_materno)) }}
                                </span>
                                <div class="d-flex flex-wrap fw-semibold fs-4 mb-2 justify-content-center mt-5">
                                    <span class="text-gray-600">
                                        Documento de Identidad:
                                    </span>
                                    <span class="text-gray-800 ms-2 fw-bold">
                                        {{ $persona->numero_documento }}
                                    </span>
                                </div>
                                @if ($admitido)
                                    <div class="d-flex flex-wrap fw-semibold fs-4 mb-2 justify-content-center">
                                        <span class="text-gray-600">
                                            Codigo de Estudiante:
                                        </span>
                                        <span class="text-gray-800 ms-2 fw-bold">
                                            {{ $admitido->admitido_codigo }}
                                        </span>
                                    </div>
                                @endif
                                <div class="d-flex flex-wrap fw-semibold fs-4 mb-2 justify-content-center">
                                    <span class="text-gray-600">
                                        Proceso de Admisión:
                                    </span>
                                    <span class="text-gray-800 ms-2 fw-bold">
                                        {{ ucwords(strtolower($inscripcion->programa_proceso->admision->admision)) }}
                                    </span>
                                </div>
                                <div class="d-flex flex-wrap fw-semibold fs-4 mb-2 justify-content-center">
                                    <span class="text-gray-600">
                                        Programa:
                                    </span>
                                    <span class="text-gray-800 ms-2 fw-bold">
                                        @if ($admitido)
                                            @if ($admitido->programa_proceso->programa_plan->programa->mencion == null)
                                                {{ ucwords(strtolower($admitido->programa_proceso->programa_plan->programa->programa)) }} en {{ ucwords(strtolower($admitido->programa_proceso->programa_plan->programa->subprograma)) }}
                                            @else
                                                {{ ucwords(strtolower($admitido->programa_proceso->programa_plan->programa->programa)) }} en {{ ucwords(strtolower($admitido->programa_proceso->programa_plan->programa->subprograma)) }} con mención en {{ ucwords(strtolower($admitido->programa_proceso->programa_plan->programa->mencion)) }}
                                            @endif
                                        @else
                                            @if ($inscripcion->programa_proceso->programa_plan->programa->mencion == null)
                                                {{ ucwords(strtolower($inscripcion->programa_proceso->programa_plan->programa->programa)) }} en {{ ucwords(strtolower($inscripcion->programa_proceso->programa_plan->programa->subprograma)) }}
                                            @else
                                                {{ ucwords(strtolower($inscripcion->programa_proceso->programa_plan->programa->programa)) }} en {{ ucwords(strtolower($inscripcion->programa_proceso->programa_plan->programa->subprograma)) }} con mención en {{ ucwords(strtolower($inscripcion->programa_proceso->programa_plan->programa->mencion)) }}
                                            @endif
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal perfil --}}
    <div wire:ignore.self class="modal fade" tabindex="-1" id="modal_perfil">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        Editar Perfil
                    </h3>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close" wire:click="limpiar_perfil">
                        <i class="bi bi-x fs-1"></i>
                    </div>
                </div>
                <div class="modal-body">
                    <form autocomplete="off">
                        <div class="mb-5">
                            <label for="perfil" class="form-label">
                                Foto de Perfil
                            </label>
                            <input type="file" class="form-control" wire:model="perfil" accept=".png, .jpg, .jpeg" id="upload{{ $iteration }}">
                            <div class="image-input image-input-outline mt-3">
                                <img src="@if($perfil) {{ asset($perfil->temporaryUrl()) }} @elseif($usuario->usuario_estudiante_perfil_url) {{ asset($usuario->usuario_estudiante_perfil_url) }} @else {{ asset('assets/media/avatars/blank.png') }} @endif" class="image-input-wrapper w-125px h-125px" alt="vista previa perfil">
                            </div>
                            <div class="form-text">Formato de imagen:  png, jpg, jpeg.</div>
                            @error('perfil')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-5">
                            <label for="password" class="form-label">
                                Nueva Contraseña
                            </label>
                            <input type="password" wire:model="password" class="form-control @error('password') is-invalid @enderror" placeholder="Ingrese su nueva contraseña" id="password"/>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-5">
                            <label for="confirm_password" class="form-label">
                                Confirmar Contraseña
                            </label>
                            <input type="password" wire:model="confirm_password" class="form-control @error('confirm_password') is-invalid @enderror" placeholder="Confirmar su nueva contraseña" id="confirm_password"/>
                            @error('confirm_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" wire:click="limpiar_perfil">
                        Cerrar
                    </button>
                    <button type="button" wire:click="actualizar_perfil" class="btn btn-primary" style="width: 160px" wire:loading.attr="disabled">
                        <div wire:loading.remove wire:target="actualizar_perfil">
                            Actualizar Datos
                        </div>
                        <div wire:loading wire:target="actualizar_perfil">
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    {{-- <script>
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
    </script> --}}
@endpush
