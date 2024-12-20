<div class="card rounded-3 w-md-500px">
    <div class="card-body d-flex flex-column p-10 p-lg-20 pb-lg-10">
        <div class="d-flex flex-center flex-column-fluid pb-5 pb-lg-15">
            <form class="form w-100" wire:submit.prevent="ingresar_plataforma">
                <div class="text-center mb-11">
                    <h1 class="text-dark fw-bolder mb-3">
                        Plataforma del Estudiante<br>Escuela de Posgrado
                    </h1>
                    <div class="text-gray-500 fw-semibold fs-4">
                        Iniciar sesión
                    </div>
                </div>
                <div class="fv-row mb-5">
                    <label for="usuario" class="required form-label">
                        Usuario
                    </label>
                    <input type="text" wire:model="usuario"
                        class="form-control @error('usuario') is-invalid @enderror" id="usuario"
                        placeholder="Ingrese su usuario" autocomplete="off" />
                    @error('usuario')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="fv-row mb-5">
                    <label for="password" class="required form-label">
                        Contraseña
                    </label>
                    <input type="password" wire:model="password"
                        class="form-control @error('password') is-invalid @enderror" id="password"
                        placeholder="Ingrese su contraseña" autocomplete="off" />
                    @error('password')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                @if (session()->has('message'))
                    <div class="mt-5">
                        <div class="alert alert-danger border border-3 border-danger d-flex align-items-center p-5">
                            <span class="fw-bold text-center fs-5">
                                {{ session('message') }}
                            </span>
                        </div>
                    </div>
                @endif
                <div class="mt-5">
                    <button type="submit" class="btn btn-warning w-100" wire:loading.attr="disabled">
                        <div wire:loading.remove wire:target="ingresar_plataforma">
                            Ingresar
                        </div>
                        <div wire:loading wire:target="ingresar_plataforma">
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            Verificando...
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
