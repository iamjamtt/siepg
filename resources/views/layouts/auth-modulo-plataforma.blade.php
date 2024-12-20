<!DOCTYPE html>
<html lang="es">
	<head>
		<title>Login - Plataforma Escuela de Posgrado</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="shortcut icon" href="{{ asset('assets/media/logos/logo-pg.png') }}"/>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->

        <!-- Resource Vite -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Scripts Livewire -->
        @livewireStyles()
	</head>
	<body id="kt_body" class="app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
		<script>
            var defaultThemeMode = "light";
            var themeMode;
            if ( document.documentElement )
            {
                if ( document.documentElement.hasAttribute("data-bs-theme-mode"))
                {
                    themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
                }
                else
                {
                    if ( localStorage.getItem("data-bs-theme") !== null )
                    {
                        themeMode = localStorage.getItem("data-bs-theme");
                    }
                    else
                    {
                        themeMode = defaultThemeMode;
                    }
                }
                if (themeMode === "system")
                {
                    themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
                }
                document.documentElement.setAttribute("data-bs-theme", themeMode);
            }
        </script>
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<style>
                body {
                    background-image: url("{{ asset('assets/media/auth/bg-login-posgrado-admin.jpg') }}");
                    background-repeat: no-repeat;
                    background-size: cover;
                    background-position: center;
                    background-attachment: fixed;
                }
                [data-bs-theme="dark"] body {
                    background-image: url("{{ asset('assets/media/auth/bg3-dark.jpg') }}");
                    background-repeat: no-repeat;
                    background-size: cover;
                    background-position: center;
                    background-attachment: fixed;
                }
            </style>
			<div class="d-flex flex-column flex-column-fluid flex-lg-row">
				<div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
					<div class="d-flex flex-center flex-column">
						<a href="https://www.unu.edu.pe/posgrado/index.php" target="_blank" class="mb-7">
							<img alt="Logo" src="{{ asset('assets/media/logos/logo-pg.png') }}" height="90" />
						</a>
						<h2 class="text-dark fw-bold m-0" style="font-size: 2rem">
                            Escuela de Posgrado
                        </h2>
					</div>
				</div>
				<div class="d-flex flex-center w-lg-50 p-10 ">
					@yield('content')
				</div>
			</div>
		</div>
		<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
		<script src="{{ asset('assets/js/custom/authentication/sign-in/general.js') }}"></script>

        @yield('javascript')
        @livewireScripts()
	</body>
	<!--end::Body-->
</html>
