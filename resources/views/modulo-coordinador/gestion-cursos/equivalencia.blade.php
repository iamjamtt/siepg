@extends('layouts.modulo-coordinador')
@section('title', 'Gestión de Equivalencias de Cursos - Director de Unidad - Escuela de Posgrado')
@section('content')
@livewire('modulo-coordinador.gestion-cursos.equivalencia')
@endsection
@section('scripts')
    <script>
        // window.addEventListener('modal_docente', event => {
        //     $('#modal_docente').modal(event.detail.action);
        // })
        window.addEventListener('alerta_base', event => {
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
        window.addEventListener('alerta_avanzada', event => {
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
                    Livewire.emitTo('modulo-coordinador.gestion-cursos.equivalencia', event.detail.metodo, event.detail.id);
                }
            });
        });
    </script>
@endsection
