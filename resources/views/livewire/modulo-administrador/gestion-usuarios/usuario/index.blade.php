<div>

    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        Usuario
                    </h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('administrador.dashboard') }}" class="text-muted text-hover-primary">
                                Dashboard
                            </a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Usuario</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <!--begin::Primary button-->
                    <a href="#modalUsuario" wire:click="modo()" class="btn btn-primary btn-sm hover-elevate-up" data-bs-toggle="modal" data-bs-target="#modalUsuario">Nuevo</a>
                    <!--end::Primary button-->
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->

        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-fluid pt-5">
                <!--begin::Row-->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-5">
                            <div class="d-flex justify-content-between align-items-center gap-4">
                            </div>
                            <div class="w-25">
                                <input class="form-control form-control-sm text-muted" type="search" wire:model="search"
                                    placeholder="Buscar...">
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-rounded border gy-4 gs-4 mb-0 align-middle">
                                <thead class="bg-light-primary">
                                    <tr align="center" class="fw-bold fs-5 text-gray-800 border-bottom-2 border-gray-200">
                                        <th scope="col" class="col-md-1">ID</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Correo</th>
                                        <th scope="col" class="col-md-1">Estado</th>
                                        <th scope="col" class="col-md-2">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($usuarios as $item)
                                        <tr>
                                            <td align="center" class="fw-bold fs-5">{{ $item->id_usuario }}</td>
                                            <td>
                                                <div class="d-flex flex-column gap-1">
                                                    <span class="fw-bold fs-6">{{ $item->usuario_nombre }}</span>
                                                    <span class="text-muted">{{ $item?->trabajador_tipo_trabajador?->trabajador->trabajador_numero_documento ?? '' }}</span>
                                                </div>
                                            </td>
                                            <td>{{ $item->usuario_correo }}</td>
                                            <td align="center">
                                                @if ($item->usuario_estado == 1)
                                                    <span style="cursor: pointer;" wire:click="cargarAlerta({{ $item->id_usuario }})" class="badge text-bg-success text-light hover-elevate-down fs-6 px-3 py-2">Activo</span>
                                                @endif
                                                @if ($item->usuario_estado == 2)
                                                    <span style="cursor: pointer;" wire:click="cargarAlerta({{ $item->id_usuario }})" class="badge text-bg-primary text-light hover-elevate-down fs-6 px-3 py-2">Asignado</span>
                                                @endif
                                                @if ($item->usuario_estado == 0)
                                                    <span style="cursor: pointer;" wire:click="cargarAlerta({{ $item->id_usuario }})" class="badge text-bg-danger text-light hover-elevate-down fs-6 px-3 py-2">Inactivo</span>
                                                @endif
                                            </td>

                                            <td align="center">
                                                <a class="btn btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary btn-sm" data-bs-toggle="dropdown">
                                                    Actions
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
                                                        <a href="#modalUsuario"
                                                        wire:click="cargarUsuario({{ $item->id_usuario }})"
                                                        class="menu-link px-3" data-bs-toggle="modal"
                                                        data-bs-target="#modalUsuario">
                                                            Editar
                                                        </a>
                                                    </div>
                                                    @if ($item->id_trabajador_tipo_trabajador != null)
                                                        @if ($item->trabajador_tipo_trabajador->id_tipo_trabajador == 1)
                                                        <div class="menu-item px-3">
                                                            <a wire:click="enviar_credenciales({{ $item->id_usuario }}, 'docente',{{ $item->trabajador_tipo_trabajador->id_trabajador }})"
                                                            class="menu-link px-3 cursor-pointer">
                                                                Enviar Credenciales
                                                            </a>
                                                        </div>
                                                        @endif
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        @if ($search != '')
                                            <tr>
                                                <td colspan="7" class="text-center text-muted">
                                                    No se encontraron resultados para la busqueda
                                                    "{{ $search }}"
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
                        {{-- paginacion de la tabla --}}
                        @if ($usuarios->hasPages())
                            <div class="d-flex justify-content-between mt-5">
                                <div class="d-flex align-items-center text-gray-700">
                                    Mostrando {{ $usuarios->firstItem() }} - {{ $usuarios->lastItem() }} de
                                    {{ $usuarios->total() }} registros
                                </div>
                                <div>
                                    {{ $usuarios->links() }}
                                </div>
                            </div>
                        @else
                            <div class="d-flex justify-content-between mt-5">
                                <div class="d-flex align-items-center text-gray-700">
                                    Mostrando {{ $usuarios->firstItem() }} - {{ $usuarios->lastItem() }} de
                                    {{ $usuarios->total() }} registros
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->

    {{-- Modal Usuario --}}
    <div wire:ignore.self class="modal fade" tabindex="-1" id="modalUsuario">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">
                        {{ $titulo }}
                    </h2>
                    <div class="btn btn-icon btn-sm btn-active-light-danger ms-2" data-bs-dismiss="modal"
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
                    <form autocomplete="off">
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Username <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('username') is-invalid  @enderror" wire:model="username" placeholder="Ingrese su nombre de usuario">
                                @error('username') <span class="error text-danger" >{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3 col-md-12">
                                <label class="form-label">Correo <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('correo') is-invalid  @enderror"
                                    wire:model="correo" placeholder="Ingrese su correo electrónico" autocomplete="off">
                                @error('correo')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-12">
                                <label class="form-label">Contraseña @if($modo==1) <span class="text-danger">*</span> @endif</label>
                                <div class="input-group">
                                    <input type="{{ $showPassword ? 'text' : 'password' }}" class="form-control @error('password') is-invalid  @enderror" wire:model="password" placeholder="Ingrese su contraseña" autocomplete="off" aria-describedby="password">
                                    <button class="input-group-text" id="password" type="button" wire:click="toggleShowPassword">
                                        <i class="{{ $showPassword ? 'fas fa-eye-slash' : 'fas fa-eye' }}"></i>
                                    </button>
                                </div>
                                @error('password') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3 col-md-12">
                                <label class="form-label">Confirmar Contraseña @if($modo==1) <span class="text-danger">*</span> @endif</label>
                                <div class="input-group">
                                    <input type="{{ $showPassword_confirmation ? 'text' : 'password' }}" class="form-control @error('password_confirmation') is-invalid  @enderror" wire:model="password_confirmation" placeholder="Confirme su contraseña" autocomplete="off" aria-describedby="password_confirmation">
                                    <button class="input-group-text" id="password_confirmation" type="button" wire:click="toggleShowPasswordConfirmation">
                                        <i class="{{ $showPassword_confirmation ? 'fas fa-eye-slash' : 'fas fa-eye' }}"></i>
                                    </button>
                                </div>
                                @error('password_confirmation') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer col-12 d-flex justify-content-between">
                    <button type="button" wire:click="limpiar()" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" wire:click="guardarUsuario()" class="btn btn-primary" wire:loading.attr="disabled">
                        <div wire:loading.remove wire:target="guardarUsuario">
                            Guardar
                        </div>
                        <div wire:loading wire:target="guardarUsuario">
                            <span class="spinner-border spinner-border-sm align-middle me-2"></span>
                            Guardando...
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
