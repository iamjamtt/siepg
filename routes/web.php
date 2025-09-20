<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModuloAdministrador\DashboardController;
use App\Http\Controllers\ModuloInscripcion\InscripcionController;
use App\Http\Controllers\PaginaController;
use App\Http\Controllers\RecordAcademicoController;

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

Route::get('/buscar/record-academico', [RecordAcademicoController::class, 'index'])
    ->middleware(['auth.usuario', 'verificar.usuario.record'])
    ->name('record.inicio');

Route::get('/buscar/record-academico/{admitido}', [RecordAcademicoController::class, 'buscar'])
    ->middleware(['auth.usuario', 'verificar.usuario.record'])
    ->name('record.buscar');

//

// Ruta para la pagina de inicio
Route::get('/', [PaginaController::class, 'inicio'])->name('pagina.inicio');
Route::get('/noticia/{slug}', [PaginaController::class, 'noticia'])->name('pagina.noticia');
Route::get('/anuncio/{slug}', [PaginaController::class, 'anuncio'])->name('pagina.anuncio');

Route::get('/mision', [PaginaController::class, 'mision'])->name('pagina.mision');
Route::get('/vision', [PaginaController::class, 'vision'])->name('pagina.vision');
Route::get('/objetivos', [PaginaController::class, 'objetivos'])->name('pagina.objetivos');
Route::get('/resena-historica', [PaginaController::class, 'resena_historica'])->name('pagina.resena-historica');
Route::get('/autoridades', [PaginaController::class, 'autoridades'])->name('pagina.autoridades');
Route::get('/reglamento', [PaginaController::class, 'reglamento'])->name('pagina.reglamento');

Route::get('/requisito-ingreso', [PaginaController::class, 'requisito_ingreso'])->name('pagina.requisito-ingreso');
Route::get('/procesos-cronogramas', [PaginaController::class, 'procesos_cronogramas'])->name('pagina.procesos-cronogramas');
Route::get('/costos-modalidades', [PaginaController::class, 'costos_modalidades'])->name('pagina.costos-modalidades');
Route::get('/link-siepg', [PaginaController::class, 'link_siepg'])->name('pagina.link-siepg');

Route::get('/programa/{slug}', [PaginaController::class, 'programa'])->name('pagina.programa');
Route::get('/programa/{slug_tipo}/{slug}', [PaginaController::class, 'programa_detalle'])->name('pagina.programa-detalle');

Route::get('/contacto', [PaginaController::class, 'contacto'])->name('pagina.contacto');
