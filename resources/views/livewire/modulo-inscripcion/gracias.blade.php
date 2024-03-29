<div>
    {{-- header --}}
    <div class="py-10 border-bottom border-gray-500 d-flex flex-column gap-5">
        <span class="text-success" style="font-weight: 700; font-size: 3rem">
            Gracias por registrarte
        </span>
        <span class="text-muted fs-2">
            Los datos rellenados han sido registrados con éxito.
        </span>
    </div>
    {{-- alerta --}}
    <div class="alert bg-light-primary border border-3 border-primary d-flex align-items-center gap-2 mt-5 p-5">
        <i class="ki-duotone ki-information-5 fs-2qx me-4 text-primary">
            <i class="path1"></i>
            <i class="path2"></i>
            <i class="path3"></i>
        </i>
        <div class="d-flex flex-column">
            <h4 class="mb-0 fs-3">
                Su ficha de inscripción ha sido enviado a su correo electrónico y se encuentra disponible para descargarlo a continuación.
            </h4>
        </div>
    </div>
    {{-- alerta --}}
    <div class="alert bg-light-warning border border-3 border-warning d-flex align-items-center gap-2 mt-5 p-5">
        <i class="ki-duotone ki-information-5 fs-2qx me-4 text-warning">
            <i class="path1"></i>
            <i class="path2"></i>
            <i class="path3"></i>
        </i>
        <div class="d-flex flex-column">
            <h4 class="mb-0 fs-3">
                Se le hace recordar que su inscripción esta sujeta a la verificación de los expedientes presentados y el pago de la inscripción. Cualquier observación será comunicada a su correo electrónico.
            </h4>
        </div>
    </div>
    {{-- boton --}}
    <div class="d-flex justify-content-between">
        <a href="{{ route('inscripcion.auth') }}" class="btn btn-secondary">
            <i class="fa-sharp fa-solid fa-arrow-left"></i>
            Volver al inicio
        </a>
        <button wire:click="descargar_pdf({{ $id_inscripcion }})" class="btn btn-primary hover-scale">
            <i class="fa-sharp fa-solid fa-download"></i>
            Descargar ficha de inscripción
        </button>
    </div>
    {{-- pdf --}}
    <div class="my-5">
        <embed src="{{ asset($inscripcion->inscripcion_ficha_url) }}" class="rounded" type="application/pdf" width="100%" height="700px" />
    </div>
</div>
