<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <div>
            <img alt="Logo" src="{{ asset('assets/media/logos/logo-largo-light.png') }}" height="42"
                class="app-sidebar-logo-default theme-light-show">
            <img alt="Logo" src="{{ asset('assets/media/logos/logo-largo-dark.png') }}" height="42"
                class="app-sidebar-logo-default theme-dark-show">
            <img alt="Logo" src="{{ asset('assets/media/logos/logo-pg.png') }}" height="30"
                class="app-sidebar-logo-minimize">
        </div>
        {{-- <div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary body-bg h-30px w-30px position-absolute top-50 start-100 translate-middle rotate" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
            <span class="svg-icon svg-icon-2 rotate-180">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.5" d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z" fill="currentColor" />
                    <path d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z" fill="currentColor" />
                </svg>
            </span>
        </div> --}}
    </div>
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5"
            data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
            data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
            <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu"
                data-kt-menu="true" data-kt-menu-expand="false">

                <div class="menu-item">
                    <div class="mb-5 d-flex flex-column gap-4">
                        <div class="symbol symbol-100px text-center">
                            <img src="{{ $trabajador->trabajador_perfil_url ? asset($trabajador->trabajador_perfil_url) : $trabajador->avatar }}"
                                alt="avatar" />
                        </div>
                        <span class="fs-2 fw-bold text-center">
                            {{ $trabajador->primeros_nombres }}
                        </span>
                        <span class="badge badge-light-info py-3 d-flex justify-content-center fs-7">
                            {{ $area_administrativa->area_administrativo }}
                        </span>
                        <button type="button" wire:click="cerrar_sesion"
                            class="btn btn-flex flex-center btn-dark btn-custom text-nowrap px-0 h-40px w-100">
                            <span class="btn-label">
                                Cerrar sesión
                            </span>
                        </button>
                    </div>
                    <hr>
                </div>

                {{-- Dashboard --}}
                <div class="menu-item">
                    <a class="menu-link {{ $route === 'administrador.dashboard' ? 'active border-3 border-start border-primary' : '' }}"
                        href="{{ route('administrador.dashboard') }}">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <i class="ki-outline ki-abstract-28 fs-2"></i>
                            </span>
                        </span>
                        <span class="menu-title fs-4">Dashboard</span>
                    </a>
                </div>

                <div class="menu-item pt-5">
                    <div class="menu-content">
                        <span class="menu-heading fw-bold text-uppercase fs-5">Módulos</span>
                    </div>
                </div>

                {{-- Módulo de Usuarios --}}
                <div data-kt-menu-trigger="click"
                    class="menu-item menu-accordion {{ $route === 'administrador.usuario' || $route === 'administrador.trabajador' ? 'active show border-2 border-start border-gray-300 rounded' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span
                                class="svg-icon svg-icon-2 {{ $route === 'administrador.usuario' || $route === 'administrador.trabajador' ? 'text-primary' : '' }}">
                                <i class="ki-outline ki-profile-circle fs-2"></i>
                            </span>
                        </span>
                        <span class="menu-title fs-4">Gestión de Usuarios</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a class="menu-link {{ $route === 'administrador.usuario' ? 'active border-3 border-start border-primary' : '' }}"
                                href="{{ route('administrador.usuario') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title fs-4">Usuario</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ $route === 'administrador.trabajador' ? 'active border-3 border-start border-primary' : '' }}"
                                href="{{ route('administrador.trabajador') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title fs-4">Trabajador</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Estudiantes --}}
                <div class="menu-item">
                    <a class="menu-link {{ $route === 'administrador.estudiante' ? 'active border-3 border-start border-primary' : '' }}"
                        href="{{ route('administrador.estudiante') }}">
                        <span class="menu-icon">
                            <span
                                class="svg-icon svg-icon-2  {{ $route === 'administrador.estudiante' ? 'text-primary' : '' }}">
                                <i class="ki-outline ki-people fs-2"></i>
                            </span>
                        </span>
                        <span class="menu-title fs-4">Estudiantes</span>
                    </a>
                </div>

                {{-- Gestion de Admisión --}}
                <div data-kt-menu-trigger="click"
                    class="menu-item menu-accordion {{ $route === 'administrador.admision' || $route === 'administrador.inscripcion' || $route === 'administrador.evaluacion' || $route === 'administrador.inscripcion-pago' || $route === 'administrador.admitidos' || $route === 'administrador.links-whatsapp' ? 'active show border-2 border-start border-gray-300 rounded' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span
                                class="svg-icon svg-icon-muted svg-icon-2 {{ $route === 'administrador/admision' || $route === 'administrador.inscripcion' || $route === 'administrador.evaluacion' || $route === 'administrador.inscripcion-pago' || $route === 'administrador.admitidos' ? 'text-primary' : '' }}">
                                <i class="ki-outline ki-note-2 fs-2"></i>
                            </span>
                        </span>
                        <span class="menu-title fs-4">Gestión de Admisión</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a class="menu-link {{ $route === 'administrador.admision' ? 'active border-3 border-start border-primary' : '' }}"
                                href="{{ route('administrador.admision') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title fs-4">Admisión</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ $route === 'administrador.inscripcion' ? 'active border-3 border-start border-primary' : '' }}"
                                href="{{ route('administrador.inscripcion') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title fs-4">Inscripción</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ $route === 'administrador.inscripcion-pago' ? 'active border-3 border-start border-primary' : '' }}""
                                href=" {{ route('administrador.inscripcion-pago') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title fs-4">Inscripción de Pago</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ $route === 'administrador.evaluacion' ? 'active border-3 border-start border-primary' : '' }}""
                                href=" {{ route('administrador.evaluacion') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title fs-4">Evaluación</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ $route === 'administrador.admitidos' ? 'active border-3 border-start border-primary' : '' }}"
                                href="{{ route('administrador.admitidos') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title fs-4">Admitidos</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ $route === 'administrador.links-whatsapp' ? 'active border-3 border-start border-primary' : '' }}"
                                href="{{ route('administrador.links-whatsapp') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title fs-4">Links WhatsApp</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Gestión de Pagos --}}
                <div data-kt-menu-trigger="click"
                    class="menu-item menu-accordion {{ $route === 'administrador.canal-pago' || $route === 'administrador.concepto-pago' || $route === 'administrador.pago' ? 'active show border-2 border-start border-gray-300 rounded' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span
                                class="svg-icon svg-icon-muted svg-icon-2 {{ $route === 'administrador.canal-pago' || $route === 'administrador.concepto-pago' || $route === 'administrador.pago' ? 'text-primary' : '' }}">
                                <i class="ki-outline ki-brifecase-cros fs-2"></i>
                            </span>
                        </span>
                        <span class="menu-title fs-4">
                            Gestión de Pagos
                            @if ($pago > 0)
                                <span class="bullet bullet-dot bg-danger ms-2 h-6px w-6px animation-blink"></span>
                            @endif
                        </span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a class="menu-link {{ $route === 'administrador.canal-pago' ? 'active border-3 border-start border-primary' : '' }}"
                                href="{{ route('administrador.canal-pago') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title fs-4">Canal de Pago</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ $route === 'administrador.concepto-pago' ? 'active border-3 border-start border-primary' : '' }}"
                                href=" {{ route('administrador.concepto-pago') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title fs-4">Concepto de Pago</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ $route === 'administrador.pago' ? 'active border-3 border-start border-primary' : '' }}"
                                href="{{ route('administrador.pago') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title fs-4">Pagos</span>
                                @if ($pago > 0)
                                    <span
                                        class="badge badge-circle badge-sm badge-warning ms-2">{{ $pago }}</span>
                                @endif
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Gestión de Matriculas --}}
                <div class="menu-item">
                    <a class="menu-link {{ $route === 'administrador.matriculas' ? 'active border-3 border-start border-primary' : '' }}"
                        href="{{ route('administrador.matriculas') }}">
                        <span class="menu-icon">
                            <span
                                class="svg-icon svg-icon-2  {{ $route === 'administrador.matriculas' ? 'text-primary' : '' }}">
                                <i class="ki-outline ki-folder fs-2"></i>
                            </span>
                        </span>
                        <span class="menu-title fs-4">
                            Gestión de Matriculas
                        </span>
                    </a>
                </div>

                {{-- Configuración --}}
                <div data-kt-menu-trigger="click"
                    class="menu-item menu-accordion {{ $route === 'administrador.programa' || $route === 'administrador.plan' || $route === 'administrador.sede' || $route === 'administrador.expediente' || $route === 'administrador.tipo-seguimiento' ? 'active show border-2 border-start border-gray-300 rounded' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span
                                class="svg-icon svg-icon-muted svg-icon-2 {{ $route === 'administrador.programa' || $route === 'administrador.plan' || $route === 'administrador.sede' || $route === 'administrador.expediente' || $route === 'administrador.tipo-seguimiento' ? 'text-primary' : '' }}">
                                <i class="ki-outline ki-setting-2 fs-2"></i>
                            </span>
                        </span>
                        <span class="menu-title fs-4">Configuración</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">

                        <div class="menu-item">
                            <a class="menu-link {{ $route === 'administrador.programa' ? 'active border-3 border-start border-primary' : '' }}"
                                href="{{ route('administrador.programa') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title fs-4">Programas</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ $route === 'administrador.plan' ? 'active border-3 border-start border-primary' : '' }}""
                                href=" {{ route('administrador.plan') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title fs-4">Plan</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ $route === 'administrador.sede' ? 'active border-3 border-start border-primary' : '' }}"
                                href="{{ route('administrador.sede') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title fs-4">Sede</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ $route === 'administrador.expediente' ? 'active border-3 border-start border-primary' : '' }}"
                                href="{{ route('administrador.expediente') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title fs-4">Expedientes</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ $route === 'administrador.tipo-seguimiento' ? 'active border-3 border-start border-primary' : '' }}"
                                href="{{ route('administrador.tipo-seguimiento') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title fs-4">Tipo de Seguimiento</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Gestion de Correos Masivos --}}
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('administrador.gestion-correo*') ? 'active border-3 border-start border-primary' : '' }}"
                        href="{{ route('administrador.gestion-correo') }}">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <i class="ki-outline ki-sms fs-2"></i>
                            </span>
                        </span>
                        <span class="menu-title fs-4">
                            Gestion de Correos
                        </span>
                    </a>
                </div>

                {{-- Gestion de Reingreso --}}
                <div data-kt-menu-trigger="click"
                    class="menu-item menu-accordion {{ request()->routeIs('administrador.reingreso.masivo') || request()->routeIs('administrador.reingreso.individual') ? 'show active' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-outline ki-abstract-37 fs-1"> </i>
                        </span>
                        <span class="menu-title fw-semibold fs-4">Gestión de Reingreso</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('administrador.reingreso.individual') ? 'active' : '' }}"
                                href="{{ route('administrador.reingreso.individual') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title fs-4">Individual</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('administrador.reingreso.masivo') ? 'active' : '' }}"
                                href="{{ route('administrador.reingreso.masivo') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title fs-4">Masivo</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Gestion de Retiro --}}
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('administrador.retiro') ? 'active' : '' }}"
                        href="{{ route('administrador.retiro') }}">
                        <span class="menu-icon">
                            <i class="ki-outline ki-abstract-42 fs-1"></i>
                        </span>
                        <span class="menu-title fw-semibold fs-4">
                            Gestión de Retiro
                        </span>
                    </a>
                </div>

                {{-- Documentación --}}
                <div class="menu-item">
                    <a class="menu-link" href="https://preview.keenthemes.com/html/metronic/docs" target="_blank">
                        <span class="menu-icon">
                            <i class="ki-outline ki-laravel fs-2"></i>
                        </span>
                        <span class="menu-title fs-4">Documentation</span>
                    </a>
                </div>

                {{-- Template --}}
                <div class="menu-item">
                    <a class="menu-link" href="https://preview.keenthemes.com/metronic8/demo1/index.html"
                        target="_blank">
                        <span class="menu-icon">
                            <i class="ki-outline ki-bootstrap fs-2"></i>
                        </span>
                        <span class="menu-title fs-4">Template</span>
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
