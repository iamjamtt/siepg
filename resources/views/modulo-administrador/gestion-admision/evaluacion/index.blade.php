@extends('layouts.modulo-administrador')

@section('content')

@livewire('modulo-administrador.gestion-admision.evaluacion.index')

@endsection

@section('javascript')
<script>

    window.addEventListener('modal', event => {
        $(event.detail.titleModal).modal('hide');
    })

    // Alerta para confirmacion
	window.addEventListener('alerta', event => {
        Swal.fire({
            title: event.detail.title,
            text: event.detail.text,
            icon: event.detail.icon,
            buttonsStyling: false,
            confirmButtonText: event.detail.confirmButtonText,
            customClass: {
                confirmButton: "btn btn-"+event.detail.color+" hover-elevate-up", // Color del boton de confirmación y Hover
            }
        });
    });

    //alerta
    window.addEventListener('alertaConfirmacion', event => {
        Swal.fire({
            title: event.detail.title,
            text: event.detail.text,
            icon: event.detail.icon,
            showCancelButton: true,
            confirmButtonText: event.detail.confirmButtonText,
            cancelButtonText: event.detail.cancelButtonText,
            customClass: {
                confirmButton: "btn btn-"+event.detail.confimrColor+" hover-elevate-up", //Hover y color del boton Confirmar
                cancelButton: "btn btn-"+event.detail.cancelColor+" hover-elevate-up", //Hover y color del boton Cancel
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.emitTo('modulo-administrador.gestion-admision.evaluacion.index', event.detail.metodo, event.detail.id);
            }
        })
    })

</script>
@endsection
