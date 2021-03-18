<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\MapLocation;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'web'], function(){

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
    Auth::routes();
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

});

/* Criacao de rotas de acesso
#/usuarios sera roteado pelo app/Http/Controllers/UsuariosController.php com a funcao nome index()
#/usuarios/new sera roteado pelo app/Http/Controllers/UsuariosController.php com a funcao nome new()
*/
Route::get('/usuarios', [App\Http\Controllers\UsuariosController::class, 'index'])->middleware('auth');
Route::get('/usuarios/new', [App\Http\Controllers\UsuariosController::class, 'new'])->middleware('auth');
Route::post('/usuarios/add', [App\Http\Controllers\UsuariosController::class, 'add'])->middleware('auth');
Route::get('/usuarios/{id}/edit', [App\Http\Controllers\UsuariosController::class, 'edit'])->middleware('auth');
Route::post('/usuarios/update/{id}', [App\Http\Controllers\UsuariosController::class, 'update'])->middleware('auth');
Route::delete('/usuarios/delete/{id}', [App\Http\Controllers\UsuariosController::class, 'delete'])->middleware('auth');
#Route::get('/map', MapLocation::class);
Route::get('/usuarios/mapa', [App\Http\Controllers\UsuariosController::class, 'mapa'])->middleware('auth');
Route::get('/usuarios/pendente', [App\Http\Controllers\UsuariosController::class, 'pendente'])->middleware('auth');
Route::get('/usuarios/relatorioDiario', [App\Http\Controllers\UsuariosController::class, 'relatorioDiario'])->middleware('auth');

Route::get('/usuarios/grafPieAtividade', [App\Http\Controllers\UsuariosController::class, 'grafPieAtividade'])->middleware('auth');

#Redirecionar pagina principal
Route::get('/', function () {
    return redirect('usuarios/grafPieAtividade');
});
