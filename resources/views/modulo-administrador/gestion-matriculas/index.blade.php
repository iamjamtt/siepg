@extends('layouts.modulo-administrador')
@section('title', 'Gestión de Matriculas - Administrador - Escuela de Posgrado')
@section('content')
@livewire('modulo-administrador.gestion-matricula.index')
@endsection
@section('javascript')
    <script>
        window.addEventListener('modal_gestion_matricula', event => {
            $('#modal_gestion_matricula').modal(event.detail.action);
        })
        window.addEventListener('alerta_matricula', event => {
            Swal.fire({
                title: event.detail.title,
                text: event.detail.text,
                icon: event.detail.icon,
                buttonsStyling: false,
                confirmButtonText: event.detail.confirmButtonText,
                customClass: {
                    confirmButton: "btn btn-"+event.detail.color,
                }
            });
        })
        window.addEventListener('alerta_matricula_opciones', event => {
            // alert('Name updated to: ' + event.detail.id);
            Swal.fire({
                title: event.detail.title,
                text: event.detail.text,
                icon: event.detail.icon,
                showCancelButton: true,
                confirmButtonText: event.detail.confirmButtonText,
                cancelButtonText: event.detail.cancelButtonText,
                // confirmButtonClass: 'hover-elevate-up', // Hover para elevar boton al pasar el cursor
                // cancelButtonClass: 'hover-elevate-up', // Hover para elevar boton al pasar el cursor
                customClass: {
                    confirmButton: "btn btn-"+event.detail.confirmButtonColor,
                    cancelButton: "btn btn-"+event.detail.cancelButtonColor,
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('modulo-administrador.gestion-matriculas.index', 'cambiar_estado_matricula', event.detail.id);
                }
            });
        });
    </script>
@endsection
