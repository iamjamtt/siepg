@extends('layouts.modulo-plataforma')
@section('title', 'Matriculas - Plataforma Escuela de Posgrado')
@section('content')
@livewire('modulo-plataforma.matriculas.index')
@endsection
@section('scripts')
<script>
    window.addEventListener('modal_matricula', event => {
        $('#modal_matricula').modal(event.detail.action);
    })
    window.addEventListener('modal_matricula_ingresantes', event => {
        $('#modal_matricula_ingresantes').modal(event.detail.action);
    })
    window.addEventListener('alerta_generar_matricula', event => {
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
    window.addEventListener('alerta_generar_matricula_2', event => {
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
                Livewire.emitTo('modulo-plataforma.matriculas.index', 'generar_matricula');
            }
        });
    });
    window.addEventListener('alerta_generar_matricula_ingresante', event => {
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
                Livewire.emitTo('modulo-plataforma.matriculas.index', 'generar_matricula_ingresante');
            }
        });
    });
    window.addEventListener('alerta_generar_matricula_temporizador', event => {
        let timerInterval;
        Swal.fire({
            title: 'Espere un momento, estamos generando su ficha de matrícula',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            padding: '2em 2em 3em 2em',
            didOpen: () => {
                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                timerInterval = setInterval(() => {
                    b.textContent = Swal.getTimerLeft()
                }, 100)
            },
            willClose: () => {
                clearInterval(timerInterval)
            }
        }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {
                Livewire.emitTo('modulo-plataforma.matriculas.index', 'ficha_matricula');
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
            }
        })
    });
    window.addEventListener('enviar_ficha_matricula', event => {
        const { id_matricula } = event.detail;
        // Aquí puedes agregar la lógica para manejar la ficha de matrícula con el id_matricula
        console.log('ID de matrícula recibida:', id_matricula);
        // abrir la ruta de ver ficha de matrícula
        window.open('/plataforma/matriculas-ficha/' + id_matricula, '_blank');
    });
</script>
@endsection
