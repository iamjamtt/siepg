<?php

use App\Http\Controllers\ModuloPlataforma\PlataformaController;
use Illuminate\Support\Facades\Route;

// ruta para el login
Route::get('/login', [PlataformaController::class, 'login'])->middleware(['auth.plataforma.redirect.sesion'])->name('plataforma.login');

// ruta para ir al inicio de la plataforma
Route::get('/', [PlataformaController::class, 'inicio'])->middleware(['auth.plataforma'])->name('plataforma.inicio');

// ruta para ir al proceso admision de la plataforma
Route::get('/admision', [PlataformaController::class, 'admision'])->middleware(['auth.plataforma'])->name('plataforma.admision');

// ruta para ir al perfil del usuario
Route::get('/perfil', [PlataformaController::class, 'perfil'])->middleware(['auth.plataforma'])->name('plataforma.perfil');

// ruta para ir a los expedientes
Route::get('/expedientes', [PlataformaController::class, 'expediente'])->middleware(['auth.plataforma'])->name('plataforma.expediente');

// ruta para ir a los pagos de los estudiantes
Route::get('/pagos', [PlataformaController::class, 'pago'])->middleware(['auth.plataforma'])->name('plataforma.pago');

// ruta para ir a ver el compromiso de pago
Route::get('/{id_pago}/comprobante', [PlataformaController::class, 'comprobante'])->middleware(['auth.plataforma'])->name('plataforma.comprobante');

// ruta para ir a los pagos de los estudiantes el estado de cuenta
Route::get('/estado-cuenta', [PlataformaController::class, 'estado_cuenta'])->middleware(['auth.plataforma'])->name('plataforma.estado-cuenta');

// ruta para ir ver la ficha de estado de cuenta
Route::get('/estado-cuenta-ficha/{id_admitido}', [PlataformaController::class, 'estado_cuenta_ficha'])->middleware(['auth.plataforma'])->name('plataforma.estado-cuenta-ficha');

// ruta para ir ver la constancia de ingreso
Route::get('/constancia-ingreso', [PlataformaController::class, 'constancia'])->middleware(['auth.plataforma'])->name('plataforma.constancia');

// ruta para ir ver las matriculas
Route::get('/matriculas', [PlataformaController::class, 'matriculas'])->middleware(['auth.plataforma'])->name('plataforma.matriculas');

Route::get('/matriculas-ficha/{id_matricula}', [PlataformaController::class, 'fichaMatricula'])->name('plataforma.matriculas-ficha');

// ruta para ir ver el record academico
Route::get('/record-academico', [PlataformaController::class, 'record_academico'])->middleware(['auth.plataforma'])->name('plataforma.record-academico');

// ruta para ir ver la ficha del record academico
Route::get('/record-academico-ficha/{id_admitido}', [PlataformaController::class, 'record_academico_ficha'])->middleware(['auth.plataforma'])->name('plataforma.record-academico-ficha');

Route::get('/evaluacion-docentes', [PlataformaController::class, 'evaluacion_docente'])->middleware(['auth.plataforma'])->name('plataforma.evaluacion-docentes');
