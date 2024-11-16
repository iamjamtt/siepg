<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <div class="app-sidebar-logo px-8" id="kt_app_sidebar_logo">
        <a href="{{ route('coordinador.inicio') }}">
            <img alt="Logo" src="{{ asset('assets/media/logos/logo-largo-light.png') }}" height="42"
                class="app-sidebar-logo-default theme-light-show">
            <img alt="Logo" src="{{ asset('assets/media/logos/logo-largo-dark.png') }}" height="42"
                class="app-sidebar-logo-default theme-dark-show">
            <img alt="Logo" src="{{ asset('assets/media/logos/logo-pg.png') }}" height="30"
                class="app-sidebar-logo-minimize">
        </a>
        <div id="kt_app_sidebar_toggle"
            class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary body-bg h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="app-sidebar-minimize">
            <span class="svg-icon svg-icon-2 rotate-180">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.5"
                        d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
                        fill="currentColor" />
                    <path
                        d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
                        fill="currentColor" />
                </svg>
            </span>
        </div>
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
                            <img src="{{ $trabajador->trabajador_perfil_path ? asset($trabajador->trabajador_perfil_path) : $trabajador->avatar }}"
                                alt="avatar" />
                        </div>
                        <span class="fs-2 fw-bold text-center">
                            {{ $trabajador->trabajador_nombre_completo }}
                        </span>
                        <span class="badge badge-light-info py-3 d-flex justify-content-center fs-7">
                            DIRECTOR DE UNIDAD
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
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('coordinador.inicio') || request()->routeIs('coordinador.programas') || request()->routeIs('coordinador.evaluaciones') || request()->routeIs('coordinador.inscripciones') || request()->routeIs('coordinador.evaluacion-expediente') || request()->routeIs('coordinador.evaluacion-investigacion') || request()->routeIs('coordinador.evaluacion-entrevista') ? 'active' : '' }}"
                        href="{{ route('coordinador.inicio') }}">
                        <span class="menu-icon">
                            <i class="ki-outline ki-bookmark-2 fs-1"></i>
                        </span>
                        <span class="menu-title fw-semibold fs-4">Evaluaciones</span>
                    </a>
                </div>
                <div class="menu-item pt-5">
                    <div class="menu-content">
                        <span class="menu-heading fw-bold text-uppercase fs-5">Menu</span>
                    </div>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('coordinador.docentes') ? 'active' : '' }}"
                        href="{{ route('coordinador.docentes') }}">
                        <span class="menu-icon">
                            <i class="ki-outline ki-people fs-1"></i>
                        </span>
                        <span class="menu-title fw-semibold fs-4">
                            Gestión de Docentes
                        </span>
                    </a>
                </div>
                <div data-kt-menu-trigger="click"
                    class="menu-item menu-accordion {{ request()->routeIs('coordinador.cursos') || request()->routeIs('coordinador.equivalencias') ? 'show active' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-outline ki-book fs-1"> </i>
                        </span>
                        <span class="menu-title fw-semibold fs-4">Gestión de Cursos</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('coordinador.cursos') ? 'active' : '' }}"
                                href="{{ route('coordinador.cursos') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title fs-4">
                                    Cursos
                                </span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('coordinador.equivalencias') ? 'active' : '' }}"
                                href="{{ route('coordinador.equivalencias') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title fs-4">
                                    Equivalencias de Cursos
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                {{-- <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('coordinador.matriculas') ? 'active' : '' }}"
                        href="{{ route('coordinador.matriculas') }}">
                        <span class="menu-icon">
                            <i class="ki-outline ki-teacher fs-1"></i>
                        </span>
                        <span class="menu-title fw-semibold fs-4">
                            Gestión de Matriculas
                        </span>
                    </a>
                </div> --}}
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('coordinador.reporte-pagos') || request()->routeIs('coordinador.reporte-programas') ? 'active' : '' }}"
                        href="{{ route('coordinador.reporte-pagos') }}">
                        <span class="menu-icon">
                            <i class="ki-outline ki-financial-schedule fs-1"></i>
                        </span>
                        <span class="menu-title fw-semibold fs-4">
                            Reporte de Pagos
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
