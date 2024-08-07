@extends('layouts.modulo-inscripcion')
@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl py-8">
            @livewire('modulo-inscripcion.registro-docente.gracias', [
                'id_trabajador' => $id_trabajador
            ])
        </div>
    </div>
</div>
@endsection
