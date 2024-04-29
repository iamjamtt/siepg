@extends('layouts.modulo-administrador')

@section('content')
    @livewire('modulo-administrador.gestion-pagos.pago.index')
@endsection

@section('javascript')
    <script>
        window.addEventListener('modal', event => {
            $('#modal_pago_contable').modal(event.detail.action);
            $('#modal_pago_editar').modal(event.detail.action);
        })
        window.addEventListener('alerta', event => {
            Swal.fire({
                title: event.detail.title,
                text: event.detail.text,
                icon: event.detail.icon,
                buttonsStyling: false,
                confirmButtonText: event.detail.confirmButtonText,
                customClass: {
                    confirmButton: "btn btn-" + event.detail.color,
                }
            });
        })
        window.addEventListener('alerta-2', event => {
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
                    confirmButton: "btn btn-" + event.detail.confirmButtonColor,
                    cancelButton: "btn btn-" + event.detail.cancelButtonColor,
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('modulo-administrador.gestion-pagos.pago.index', 'guardar_pago');
                }
            });
        });
        window.addEventListener('alerta-3', event => {
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
                    confirmButton: "btn btn-" + event.detail.confirmButtonColor,
                    cancelButton: "btn btn-" + event.detail.cancelButtonColor,
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('modulo-administrador.gestion-pagos.pago.index', event.detail.function);
                }
            });
        });
    </script>
@endsection
