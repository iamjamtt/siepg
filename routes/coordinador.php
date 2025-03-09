<?php

use App\Http\Controllers\ModuloCoordinador\CoordinadorController;
use Illuminate\Support\Facades\Route;

// ruta para ir al inicio de la plataforma
Route::get('/', [CoordinadorController::class, 'inicio'])->middleware(['auth.usuario', 'verificar.usuario.coordinador'])->name('coordinador.inicio');

// ruta para ir a la pagina de perfil
Route::get('/perfil', [CoordinadorController::class, 'perfil'])->middleware(['auth.usuario', 'verificar.usuario.coordinador'])->name('coordinador.perfil');

// ruta para ir a la pagina de los programas de la modalidad
Route::get('/{id}/programas', [CoordinadorController::class, 'programas'])->middleware(['auth.usuario', 'verificar.usuario.coordinador'])->name('coordinador.programas');

// ruta para ir a la pagina de las evaluaciones del programa de la modalidad
Route::get('/programas/{id}/proceso/{id_admision}/evaluaciones', [CoordinadorController::class, 'evaluaciones'])->middleware(['auth.usuario', 'verificar.usuario.coordinador'])->name('coordinador.evaluaciones');

// ruta para ir a la pagina de las inscripciones del programa de la modalidad
Route::get('/programas/{id}/proceso/{id_admision}/inscripciones', [CoordinadorController::class, 'inscripciones'])->middleware(['auth.usuario', 'verificar.usuario.coordinador'])->name('coordinador.inscripciones');

// ruta para ir a la pagina de evalaucion de expediente
Route::get('/programas/{id}/proceso/{id_admision}/evaluaciones/{id_evaluacion}/expediente', [CoordinadorController::class, 'evaluacion_expediente'])->middleware(['auth.usuario', 'verificar.usuario.coordinador'])->name('coordinador.evaluacion-expediente');

// ruta para ir a la pagina de evalaucion de investigacion
Route::get('/programas/{id}/proceso/{id_admision}/evaluaciones/{id_evaluacion}/investigacion', [CoordinadorController::class, 'evaluacion_investigacion'])->middleware(['auth.usuario', 'verificar.usuario.coordinador'])->name('coordinador.evaluacion-investigacion');

// ruta para ir a la pagina de evalaucion de entrevista
Route::get('/programas/{id}/proceso/{id_admision}/evaluaciones/{id_evaluacion}/entrevista', [CoordinadorController::class, 'evaluacion_entrevista'])->middleware(['auth.usuario', 'verificar.usuario.coordinador'])->name('coordinador.evaluacion-entrevista');

// ruta para ir a la pagina de evalaucion de entrevista
Route::get('/reportes/{id_programa}/proceso/{id_admision}/maestria', [CoordinadorController::class, 'reporte_maestria'])->middleware(['auth.usuario', 'verificar.usuario.coordinador'])->name('coordinador.reporte-maestria');

// ruta para ir a la pagina de evalaucion de entrevista
Route::get('/reportes/{id_programa}/proceso/{id_admision}/doctorado', [CoordinadorController::class, 'reporte_doctorado'])->middleware(['auth.usuario', 'verificar.usuario.coordinador'])->name('coordinador.reporte-doctorado');

// ruta para ir a la pagina de gestion de docentes
Route::get('/docentes', [CoordinadorController::class, 'docentes'])->middleware(['auth.usuario', 'verificar.usuario.coordinador'])->name('coordinador.docentes');

// ruta para ir a la pagina de gestion de cursos
Route::get('/cursos', [CoordinadorController::class, 'cursos'])->middleware(['auth.usuario', 'verificar.usuario.coordinador'])->name('coordinador.cursos');

// ruta para ir a la pagina de gestion de equivalencias de los cursos
Route::get('/cursos/equivalencias', [CoordinadorController::class, 'equivalencias_cursos'])->middleware(['auth.usuario', 'verificar.usuario.coordinador'])->name('coordinador.equivalencias');

// ruta para ir a la pagina de reportes de pagos
Route::get('/reporte-pagos', [CoordinadorController::class, 'reporte_pagos'])->middleware(['auth.usuario', 'verificar.usuario.coordinador'])->name('coordinador.reporte-pagos');

// ruta para ir a la pagina de reportes de pagos d3e los programas
Route::get('/reporte-pagos/{id_programa_proceso}/programa', [CoordinadorController::class, 'reporte_programas'])->middleware(['auth.usuario', 'verificar.usuario.coordinador'])->name('coordinador.reporte-programas');

// ruta para ir a la pagina de reportes de pagos de los programas y matriculados
Route::get('/reporte-pagos/{id_programa_proceso}/programa/{id_grupo}/grupo', [CoordinadorController::class, 'reporte_programas_grupos'])->middleware(['auth.usuario', 'verificar.usuario.coordinador'])->name('coordinador.reporte-programas-grupos');

// ruta para ir a la pagina de gestion de matriculas
Route::get('/matriculas', [CoordinadorController::class, 'matriculas'])->middleware(['auth.usuario', 'verificar.usuario.coordinador'])->name('coordinador.matriculas');

// ruta para exportar el reporte de pagos
Route::get('/reporte-pagos/{id_programa_proceso}/programa/{id_grupo}/grupo/{id_gestion_matricula}/pdf', [CoordinadorController::class, 'reporte_pagos_pdf'])->middleware(['auth.usuario', 'verificar.usuario.coordinador'])->name('coordinador.reporte-pagos-pdf');
