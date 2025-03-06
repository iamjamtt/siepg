<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModuloAdministrador\DashboardController;
use App\Http\Controllers\ModuloInscripcion\InscripcionController;

use App\Http\Livewire\ModuloRecord\Inicio\Index as IndexInicioRecord;

// Routa para o dashboard do administrador y otros roles
Route::get('/login', [DashboardController::class, 'auth'])->middleware(['auth.usuario.redirect.sesion'])->name('login');
// Ruta para ir a la vista de registro de alumnos
Route::get('/posgrado/registro', [InscripcionController::class, 'registro_alumnos'])->name('posgrado.registro');
// Ruta para ir a la vista de gracias al final del registro de alumnos
Route::get('/posgrado/{id}/gracias', [InscripcionController::class, 'gracias_registro'])->name('posgrado.gracias');
// Ruta para para enviar email de las credenciales
Route::get('/posgrado/{id}/credenciales', [InscripcionController::class, 'credenciales_email'])->name('posgrado.credenciales-email');

Route::get('/hash/{password}', function($password){
    return Hash::make($password);
});


// Ruta para ir a la vista de registro de docentes
Route::get('/posgrado/registro-docente', [InscripcionController::class, 'registro_docente'])->name('posgrado.registro.docente');
// Ruta para ir a la vista de gracias al final del registro de docentes
Route::get('/posgrado/{id}/gracias-docente', [InscripcionController::class, 'gracias_registro_docente'])->name('posgrado.gracias.docente');
// Ruta para para enviar email de las credenciales
Route::get('/posgrado/{id}/credenciales-docente', [InscripcionController::class, 'credenciales_email_docente'])->name('posgrado.credenciales-email.docente');
//

Route::get('/buscar/record-academico', IndexInicioRecord::class)
    // ->middleware('auth.usuario.evaluador')
    ->name('record.inicio');

//
