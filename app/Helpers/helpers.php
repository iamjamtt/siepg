<?php

use App\Models\Admision;
use App\Models\Admitido;
use App\Models\ExpedienteAdmision;
use App\Models\ExpedienteInscripcion;
use App\Models\ExpedienteInscripcionSeguimiento;
use App\Models\Inscripcion;
use App\Models\Pago;
use App\Models\Persona;
use App\Models\ProgramaProceso;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

function getAdmision()
{
    return Admision::where('admision_estado', 1)->first();
}

function convertirFechaHora($fechaHora)
{
    // formato de fecha y hora: 12:00 pm - 12/12/2012
    return date('h:i a d/m/Y', strtotime($fechaHora));
}

function getIdTrasladoExterno()
{
    return 8; // id de traslado externo
}

function getIdConceptoPagoInscripcion()
{
    return [
        1, // id de concepto de pago de inscripcion
        8, // id de concepto de pago de inscripcion para traslado externo
        9, // id de concepto de pago de inscripcion para CONVENIO
        10 // id de concepto de pago de inscripcion para VICTIMAS DE LA VIOLENCIA
    ];
}

function getIdConceptoPagoConvenio()
{
    return 9; // id de concepto de pago de convenio
}

function getIdConceptoPagoVictimasViolencia()
{
    return 10; // id de concepto de pago de victimas de la violencia
}

function asignarPermisoFolders($base_path, $folders)
{
    $path = $base_path;
    foreach ($folders as $folder) {
        $path .= $folder . '/';
        // Asegurar que se creen los directorios con los permisos correctos
        $parent_directory = dirname($path);
        if (!file_exists($parent_directory)) {
            mkdir($parent_directory, 0777, true); // Establecer permisos en el directorio padre
        }
        if (!file_exists($path)) {
            mkdir($path, 0777, true); // 0777 establece todos los permisos para el directorio
            // Cambiar el modo de permisos después de crear los directorios
            chmod($path, 0777);
        }
    }
    return $path;
}

function registrarExpedientes($admision, $numero_documento, $expediente, $key, $inscripcion, $modo)
{
    $expediente_model = ExpedienteAdmision::where('expediente_admision_estado', 1)->where('id_expediente_admision', $key)->first();

    // Crear directorios para guardar los archivos
    $base_path = 'Posgrado/';
    $folders = [
        $admision,
        $numero_documento,
        'Expedientes'
    ];

    // Asegurar que se creen los directorios con los permisos correctos
    $path = asignarPermisoFolders($base_path, $folders);

    // Nombre del archivo
    $filename = $expediente_model->expediente->expediente_nombre_file . ".pdf";
    $nombre_db = $path . $filename;

    // Guardar el archivo
    $expediente->storeAs($path, $filename, 'files_publico');

    // Asignar todos los permisos al archivo
    chmod($nombre_db, 0777);

    if ($modo == 'crear') {
        // Registrar datos del expediente de inscripcion
        $expediente_inscripcion = new ExpedienteInscripcion();
        $expediente_inscripcion->expediente_inscripcion_url = $nombre_db;
        $expediente_inscripcion->expediente_inscripcion_estado = 1;
        $expediente_inscripcion->expediente_inscripcion_verificacion = 0;
        $expediente_inscripcion->expediente_inscripcion_fecha = now();
        $expediente_inscripcion->id_expediente_admision = $key;
        $expediente_inscripcion->id_inscripcion = $inscripcion->id_inscripcion;
        $expediente_inscripcion->save();
    } else if ($modo == 'editar') {
        // Actualizar datos del expediente de inscripcion
        $expediente_inscripcion = ExpedienteInscripcion::where('id_expediente_admision', $key)->where('id_inscripcion', $inscripcion->id_inscripcion)->first();
        $expediente_inscripcion->expediente_inscripcion_url = $nombre_db;
        $expediente_inscripcion->expediente_inscripcion_estado = 1;
        $expediente_inscripcion->expediente_inscripcion_verificacion = 0;
        $expediente_inscripcion->expediente_inscripcion_fecha = now();
        $expediente_inscripcion->save();
    }

    // cambiar el estado de la verificacion de expedientes de la inscripcion a pendiente
    $inscripcion = Inscripcion::where('id_inscripcion', $inscripcion->id_inscripcion)->first();
    $inscripcion->verificar_expedientes = 0;
    $inscripcion->save();
}

function verEstadoExpediente($id_inscripcion)
{
    $expedientes = ExpedienteInscripcion::where('id_inscripcion', $id_inscripcion)->get();
    $estado = 0;

    foreach ($expedientes as $expediente) {
        if ($expediente->expediente_inscripcion_verificacion == 0) {
            $estado = 0;
            break;
        } elseif ($expediente->expediente_inscripcion_verificacion == 2) {
            $estado = 2;
            break;
        } else {
            $estado = 1;
        }
    }

    return $estado;
}

function verificarProcesoAdmision()
{
    $admision = Admision::where('admision_estado', 1)->first();
    if ($admision->admision_fecha_inicio_inscripcion <= date('Y-m-d') && $admision->admision_fecha_fin_inscripcion >= date('Y-m-d')) {
        return true;
    } else {
        return false;
    }
}

function calcularCantidadDePersonas($tipo, $proceso, $modalidad, $programa)
{
    $cantidad = 0;
    if ($tipo == 1) {
        if ($programa) {
            $cantidad = Inscripcion::join('programa_proceso', 'programa_proceso.id_programa_proceso', '=', 'inscripcion.id_programa_proceso')
                ->join('programa_plan', 'programa_plan.id_programa_plan', '=', 'programa_proceso.id_programa_plan')
                ->join('programa', 'programa.id_programa', '=', 'programa_plan.id_programa')
                ->join('persona', 'persona.id_persona', '=', 'inscripcion.id_persona')
                ->where('programa.id_modalidad', $modalidad)
                ->where('programa.id_programa', $programa)
                ->get();
        } else if ($modalidad) {
            $cantidad = Inscripcion::join('programa_proceso', 'programa_proceso.id_programa_proceso', '=', 'inscripcion.id_programa_proceso')
                ->join('programa_plan', 'programa_plan.id_programa_plan', '=', 'programa_proceso.id_programa_plan')
                ->join('programa', 'programa.id_programa', '=', 'programa_plan.id_programa')
                ->join('persona', 'persona.id_persona', '=', 'inscripcion.id_persona')
                ->where('programa.id_modalidad', $modalidad)
                ->get();
        } else if ($proceso) {
            $cantidad = Inscripcion::join('programa_proceso', 'programa_proceso.id_programa_proceso', '=', 'inscripcion.id_programa_proceso')
                ->join('persona', 'persona.id_persona', '=', 'inscripcion.id_persona')
                ->where('programa_proceso.id_admision', $proceso)
                ->get();
        }
    } else {
        if ($programa) {
            $cantidad = Admitido::join('programa_proceso', 'programa_proceso.id_programa_proceso', '=', 'admitido.id_programa_proceso')
                ->join('programa_plan', 'programa_plan.id_programa_plan', '=', 'programa_proceso.id_programa_plan')
                ->join('programa', 'programa.id_programa', '=', 'programa_plan.id_programa')
                ->join('persona', 'persona.id_persona', '=', 'admitido.id_persona')
                ->where('programa.id_modalidad', $modalidad)
                ->where('programa.id_programa', $programa)
                ->get();
        } else if ($modalidad) {
            $cantidad = Admitido::join('programa_proceso', 'programa_proceso.id_programa_proceso', '=', 'admitido.id_programa_proceso')
                ->join('programa_plan', 'programa_plan.id_programa_plan', '=', 'programa_proceso.id_programa_plan')
                ->join('programa', 'programa.id_programa', '=', 'programa_plan.id_programa')
                ->join('persona', 'persona.id_persona', '=', 'admitido.id_persona')
                ->where('programa.id_modalidad', $modalidad)
                ->get();
        } else if ($proceso) {
            $cantidad = Admitido::join('programa_proceso', 'programa_proceso.id_programa_proceso', '=', 'admitido.id_programa_proceso')
                ->join('persona', 'persona.id_persona', '=', 'admitido.id_persona')
                ->where('programa_proceso.id_admision', $proceso)
                ->get();
        }
    }

    $correos = [];

    if ($tipo == 1) {
        foreach ($cantidad as $item) {
            $correos[] = $item->correo;
        }
    } else {
        foreach ($cantidad as $item) {
            $correos[] = $item->correo;
        }
    }

    return [
        'cantidad' => $cantidad->count(),
        'correos' => $correos
    ];
}

function generarFichaInscripcion($id_inscripcion)
{
    $id = $id_inscripcion;
    $inscripcion = Inscripcion::where('id_inscripcion', $id)->first(); // Datos de la inscripcion

    $pago = Pago::where('id_pago', $inscripcion->id_pago)->first();
    $pago_monto = $pago->pago_monto; // Monto del pago

    $admision = $inscripcion->programa_proceso->admision->admision; // Admision de la inscripcion

    $fecha_actual = date('h:i:s a d/m/Y', strtotime($inscripcion->inscripcion_fecha)); // Fecha de inscripcion
    $fecha_actual2 = date('d-m-Y', strtotime($inscripcion->inscripcion_fecha)); // Fecha de inscripcion
    $programa = ProgramaProceso::where('id_programa_proceso', $inscripcion->id_programa_proceso)->first(); // Programa de la inscripcion
    $inscripcion_codigo = Inscripcion::where('id_inscripcion', $id)->first()->inscripcion_codigo;
    $tiempo = 6;
    $valor = '+ ' . intval($tiempo) . ' month';
    setlocale(LC_ALL, "es_ES@euro", "es_ES", "esp");
    $final = strftime('%d de %B del %Y', strtotime($fecha_actual2 . $valor));
    $persona = Persona::where('id_persona', $inscripcion->id_persona)->first();
    $expediente_inscripcion = ExpedienteInscripcion::where('id_inscripcion', $id)->get();
    $expediente = ExpedienteAdmision::join('expediente', 'expediente.id_expediente', '=', 'expediente_admision.id_expediente')
        ->join('admision', 'admision.id_admision', '=', 'expediente_admision.id_admision')
        ->where('expediente_admision.expediente_admision_estado', 1)
        ->where('expediente.expediente_estado', 1)
        ->where('admision.admision_estado', 1)
        ->where(function ($query) use ($inscripcion) {
            $query->where('expediente.expediente_tipo', 0)
                ->orWhere('expediente.expediente_tipo', $inscripcion->inscripcion_tipo_programa);
        })
        ->get();

    // verificamos si tiene expediente en seguimientos
    $seguimiento_count = ExpedienteInscripcionSeguimiento::join('expediente_inscripcion', 'expediente_inscripcion.id_expediente_inscripcion', '=', 'expediente_inscripcion_seguimiento.id_expediente_inscripcion')
        ->where('expediente_inscripcion.id_inscripcion', $id)
        ->where('expediente_inscripcion_seguimiento.tipo_seguimiento', 1)
        ->where('expediente_inscripcion_seguimiento.expediente_inscripcion_seguimiento_estado', 1)
        ->count();

    $data = [
        'persona' => $persona,
        'fecha_actual' => $fecha_actual,
        'programa' => $programa,
        'admision' => $admision,
        'pago' => $pago,
        'inscripcion' => $inscripcion,
        'inscripcion_codigo' => $inscripcion_codigo,
        'pago_monto' => $pago_monto,
        'expediente_inscripcion' => $expediente_inscripcion,
        'expediente' => $expediente,
        'seguimiento_count' => $seguimiento_count
    ];

    // Crear directorios para guardar los archivos
    $base_path = 'Posgrado/';
    $folders = [
        $admision,
        $persona->numero_documento,
        'Expedientes'
    ];

    // Asegurar que se creen los directorios con los permisos correctos
    $path = asignarPermisoFolders($base_path, $folders);

    // Crear el directorio si no existe
    $fullPath = public_path($path);
    if (!file_exists($fullPath)) {
        if (!mkdir($fullPath, 0777, true) && !is_dir($fullPath)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $fullPath));
        }
    }

    // si existe el archivo, eliminarlo y crear uno nuevo
    if ($inscripcion->inscripcion_ficha_url) {
        if (file_exists($inscripcion->inscripcion_ficha_url)) {
            unlink($inscripcion->inscripcion_ficha_url);
        }
    }

    // Nombre del archivo
    $nombre_pdf = 'ficha-inscripcion-' . Str::slug($persona->nombre_completo, '-') . '.pdf';
    $nombre_db = $path . $nombre_pdf;

    // Generar el pdf de inscripcion
    PDF::loadView('modulo-inscripcion.ficha-inscripcion', $data)->save($fullPath . '/' . $nombre_pdf);

    $inscripcion = Inscripcion::find($id);
    $inscripcion->inscripcion_ficha_url = $nombre_db;
    $inscripcion->save();

    // Asignar todos los permisos al archivo
    chmod($nombre_db, 0777);
}

function finalizar_evaluacion($evaluacion, $puntaje)
{
    if ($evaluacion->id_tipo_evaluacion == 1) {
        $puntaje_final = $evaluacion->puntaje_expediente + $evaluacion->puntaje_entrevista;
        if ($evaluacion->puntaje_expediente && $evaluacion->puntaje_entrevista) {
            if ($puntaje->puntaje_maestria <= $puntaje_final) {
                $evaluacion->evaluacion_observacion = null;
                $evaluacion->evaluacion_estado = 2; // 1 = Pendiente // 2 = Aprobado // 3 = Rechazado
            } else {
                $evaluacion->evaluacion_observacion = 'El puntaje total no supera el puntaje mínimo.';
                $evaluacion->evaluacion_estado = 3; // 1 = Pendiente // 2 = Aprobado // 3 = Rechazado
            }
            $evaluacion->puntaje_final = $puntaje_final;
            $evaluacion->save();
        }
    } else if ($evaluacion->id_tipo_evaluacion == 2) {
        $puntaje_final = $evaluacion->puntaje_expediente + $evaluacion->puntaje_investigacion + $evaluacion->puntaje_entrevista;
        if ($evaluacion->puntaje_expediente && $evaluacion->puntaje_investigacion && $evaluacion->puntaje_entrevista) {
            if ($puntaje->puntaje_doctorado <= $puntaje_final) {
                $evaluacion->evaluacion_observacion = null;
                $evaluacion->evaluacion_estado = 2; // 1 = Pendiente // 2 = Aprobado // 3 = Rechazado
            } else {
                $evaluacion->evaluacion_observacion = 'El puntaje total no supera el puntaje mínimo.';
                $evaluacion->evaluacion_estado = 3; // 1 = Pendiente // 2 = Aprobado // 3 = Rechazado
            }
            $evaluacion->puntaje_final = $puntaje_final;
            $evaluacion->save();
        }
    }

    if ($puntaje_final == 0) {
        $evaluacion->evaluacion_observacion = 'No se presentó a la evaluación de entrevista.';
        $evaluacion->save();
    }
}

//
