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
                        <span
                            class="badge badge-light-info py-3 d-flex justify-content-center fs-7">
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
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect x="2" y="2" width="9" height="9" rx="2"
                                        fill="currentColor" />
                                    <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2"
                                        fill="currentColor" />
                                    <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2"
                                        fill="currentColor" />
                                    <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2"
                                        fill="currentColor" />
                                </svg>
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
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3"
                                        d="M16.5 9C16.5 13.125 13.125 16.5 9 16.5C4.875 16.5 1.5 13.125 1.5 9C1.5 4.875 4.875 1.5 9 1.5C13.125 1.5 16.5 4.875 16.5 9Z"
                                        fill="currentColor" />
                                    <path
                                        d="M9 16.5C10.95 16.5 12.75 15.75 14.025 14.55C13.425 12.675 11.4 11.25 9 11.25C6.6 11.25 4.57499 12.675 3.97499 14.55C5.24999 15.75 7.05 16.5 9 16.5Z"
                                        fill="currentColor" />
                                    <rect x="7" y="6" width="4" height="4" rx="2"
                                        fill="currentColor" />
                                </svg>
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
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M16.0173 9H15.3945C14.2833 9 13.263 9.61425 12.7431 10.5963L12.154 11.7091C12.0645 11.8781 12.1072 12.0868 12.2559 12.2071L12.6402 12.5183C13.2631 13.0225 13.7556 13.6691 14.0764 14.4035L14.2321 14.7601C14.2957 14.9058 14.4396 15 14.5987 15H18.6747C19.7297 15 20.4057 13.8774 19.912 12.945L18.6686 10.5963C18.1487 9.61425 17.1285 9 16.0173 9Z"
                                        fill="currentColor" />
                                    <rect opacity="0.3" x="14" y="4" width="4" height="4" rx="2"
                                        fill="currentColor" />
                                    <path
                                        d="M4.65486 14.8559C5.40389 13.1224 7.11161 12 9 12C10.8884 12 12.5961 13.1224 13.3451 14.8559L14.793 18.2067C15.3636 19.5271 14.3955 21 12.9571 21H5.04292C3.60453 21 2.63644 19.5271 3.20698 18.2067L4.65486 14.8559Z"
                                        fill="currentColor" />
                                    <rect opacity="0.3" x="6" y="5" width="6" height="6" rx="3"
                                        fill="currentColor" />
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title fs-4">Estudiantes</span>
                    </a>
                </div>

                {{-- Gestion de Admisión --}}
                <div data-kt-menu-trigger="click"
                    class="menu-item menu-accordion {{ $route === 'administrador.admision' || $route === 'administrador.inscripcion' || $route === 'administrador.inscripcion-pago' || $route === 'administrador.admitidos' || $route === 'administrador.links-whatsapp' ? 'active show border-2 border-start border-gray-300 rounded' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span
                                class="svg-icon svg-icon-muted svg-icon-2 {{ $route === 'administrador/admision' || $route === 'administrador.inscripcion' || $route === 'administrador.inscripcion-pago' || $route === 'administrador.admitidos' ? 'text-primary' : '' }}">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3"
                                        d="M3 6C2.4 6 2 5.6 2 5V3C2 2.4 2.4 2 3 2H5C5.6 2 6 2.4 6 3C6 3.6 5.6 4 5 4H4V5C4 5.6 3.6 6 3 6ZM22 5V3C22 2.4 21.6 2 21 2H19C18.4 2 18 2.4 18 3C18 3.6 18.4 4 19 4H20V5C20 5.6 20.4 6 21 6C21.6 6 22 5.6 22 5ZM6 21C6 20.4 5.6 20 5 20H4V19C4 18.4 3.6 18 3 18C2.4 18 2 18.4 2 19V21C2 21.6 2.4 22 3 22H5C5.6 22 6 21.6 6 21ZM22 21V19C22 18.4 21.6 18 21 18C20.4 18 20 18.4 20 19V20H19C18.4 20 18 20.4 18 21C18 21.6 18.4 22 19 22H21C21.6 22 22 21.6 22 21ZM16 11V9C16 6.8 14.2 5 12 5C9.8 5 8 6.8 8 9V11C7.2 11 6.5 11.7 6.5 12.5C6.5 13.3 7.2 14 8 14V15C8 17.2 9.8 19 12 19C14.2 19 16 17.2 16 15V14C16.8 14 17.5 13.3 17.5 12.5C17.5 11.7 16.8 11 16 11ZM13.4 15C13.7 15 14 15.3 13.9 15.6C13.6 16.4 12.9 17 12 17C11.1 17 10.4 16.5 10.1 15.7C10 15.4 10.2 15 10.6 15H13.4Z"
                                        fill="currentColor" />
                                    <path
                                        d="M9.2 12.9C9.1 12.8 9.10001 12.7 9.10001 12.6C9.00001 12.2 9.3 11.7 9.7 11.6C10.1 11.5 10.6 11.8 10.7 12.2C10.7 12.3 10.7 12.4 10.7 12.5L9.2 12.9ZM14.8 12.9C14.9 12.8 14.9 12.7 14.9 12.6C15 12.2 14.7 11.7 14.3 11.6C13.9 11.5 13.4 11.8 13.3 12.2C13.3 12.3 13.3 12.4 13.3 12.5L14.8 12.9ZM16 7.29998C16.3 6.99998 16.5 6.69998 16.7 6.29998C16.3 6.29998 15.8 6.30001 15.4 6.20001C15 6.10001 14.7 5.90001 14.4 5.70001C13.8 5.20001 13 5.00002 12.2 4.90002C9.9 4.80002 8.10001 6.79997 8.10001 9.09997V11.4C8.90001 10.7 9.40001 9.8 9.60001 9C11 9.1 13.4 8.69998 14.5 8.29998C14.7 9.39998 15.3 10.5 16.1 11.4V9C16.1 8.5 16 8 15.8 7.5C15.8 7.5 15.9 7.39998 16 7.29998Z"
                                        fill="currentColor" />
                                </svg>
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
                            <a class="menu-link {{ $route === 'administrador.' ? 'active border-3 border-start border-primary' : '' }}""
                                href=" {{ route('administrador.inscripcion-pago') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title fs-4">Puntajes de Evaluación</span>
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
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3"
                                        d="M20 15H4C2.9 15 2 14.1 2 13V7C2 6.4 2.4 6 3 6H21C21.6 6 22 6.4 22 7V13C22 14.1 21.1 15 20 15ZM13 12H11C10.5 12 10 12.4 10 13V16C10 16.5 10.4 17 11 17H13C13.6 17 14 16.6 14 16V13C14 12.4 13.6 12 13 12Z"
                                        fill="currentColor" />
                                    <path
                                        d="M14 6V5H10V6H8V5C8 3.9 8.9 3 10 3H14C15.1 3 16 3.9 16 5V6H14ZM20 15H14V16C14 16.6 13.5 17 13 17H11C10.5 17 10 16.6 10 16V15H4C3.6 15 3.3 14.9 3 14.7V18C3 19.1 3.9 20 5 20H19C20.1 20 21 19.1 21 18V14.7C20.7 14.9 20.4 15 20 15Z"
                                        fill="currentColor" />
                                </svg>
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

                {{-- Configuración --}}
                <div data-kt-menu-trigger="click"
                    class="menu-item menu-accordion {{ $route === 'administrador.programa' || $route === 'administrador.plan' || $route === 'administrador.sede' || $route === 'administrador.expediente' || $route === 'administrador.tipo-seguimiento' ? 'active show border-2 border-start border-gray-300 rounded' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span
                                class="svg-icon svg-icon-muted svg-icon-2 {{ $route === 'administrador.programa' || $route === 'administrador.plan' || $route === 'administrador.sede' || $route === 'administrador.expediente' || $route === 'administrador.tipo-seguimiento' ? 'text-primary' : '' }}">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3"
                                        d="M22.1 11.5V12.6C22.1 13.2 21.7 13.6 21.2 13.7L19.9 13.9C19.7 14.7 19.4 15.5 18.9 16.2L19.7 17.2999C20 17.6999 20 18.3999 19.6 18.7999L18.8 19.6C18.4 20 17.8 20 17.3 19.7L16.2 18.9C15.5 19.3 14.7 19.7 13.9 19.9L13.7 21.2C13.6 21.7 13.1 22.1 12.6 22.1H11.5C10.9 22.1 10.5 21.7 10.4 21.2L10.2 19.9C9.4 19.7 8.6 19.4 7.9 18.9L6.8 19.7C6.4 20 5.7 20 5.3 19.6L4.5 18.7999C4.1 18.3999 4.1 17.7999 4.4 17.2999L5.2 16.2C4.8 15.5 4.4 14.7 4.2 13.9L2.9 13.7C2.4 13.6 2 13.1 2 12.6V11.5C2 10.9 2.4 10.5 2.9 10.4L4.2 10.2C4.4 9.39995 4.7 8.60002 5.2 7.90002L4.4 6.79993C4.1 6.39993 4.1 5.69993 4.5 5.29993L5.3 4.5C5.7 4.1 6.3 4.10002 6.8 4.40002L7.9 5.19995C8.6 4.79995 9.4 4.39995 10.2 4.19995L10.4 2.90002C10.5 2.40002 11 2 11.5 2H12.6C13.2 2 13.6 2.40002 13.7 2.90002L13.9 4.19995C14.7 4.39995 15.5 4.69995 16.2 5.19995L17.3 4.40002C17.7 4.10002 18.4 4.1 18.8 4.5L19.6 5.29993C20 5.69993 20 6.29993 19.7 6.79993L18.9 7.90002C19.3 8.60002 19.7 9.39995 19.9 10.2L21.2 10.4C21.7 10.5 22.1 11 22.1 11.5ZM12.1 8.59998C10.2 8.59998 8.6 10.2 8.6 12.1C8.6 14 10.2 15.6 12.1 15.6C14 15.6 15.6 14 15.6 12.1C15.6 10.2 14 8.59998 12.1 8.59998Z"
                                        fill="currentColor" />
                                    <path
                                        d="M17.1 12.1C17.1 14.9 14.9 17.1 12.1 17.1C9.30001 17.1 7.10001 14.9 7.10001 12.1C7.10001 9.29998 9.30001 7.09998 12.1 7.09998C14.9 7.09998 17.1 9.29998 17.1 12.1ZM12.1 10.1C11 10.1 10.1 11 10.1 12.1C10.1 13.2 11 14.1 12.1 14.1C13.2 14.1 14.1 13.2 14.1 12.1C14.1 11 13.2 10.1 12.1 10.1Z"
                                        fill="currentColor" />
                                </svg>
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

                {{-- Documentación --}}
                <div class="menu-item">
                    <a class="menu-link" href="https://preview.keenthemes.com/html/metronic/docs" target="_blank">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-laravel fs-2">
                                <i class="path1"></i>
                                <i class="path2"></i>
                                <i class="path3"></i>
                                <i class="path4"></i>
                                <i class="path5"></i>
                                <i class="path6"></i>
                                <i class="path7"></i>
                            </i>
                        </span>
                        <span class="menu-title fs-4">Documentation</span>
                    </a>
                </div>

                {{-- Template --}}
                <div class="menu-item">
                    <a class="menu-link" href="https://preview.keenthemes.com/metronic8/demo1/index.html"
                        target="_blank">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-bootstrap fs-2">
                                <i class="path1"></i>
                                <i class="path2"></i>
                                <i class="path3"></i>
                            </i>
                        </span>
                        <span class="menu-title fs-4">Template</span>
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>