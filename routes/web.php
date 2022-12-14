<?php

use App\Http\Controllers\credencialesController;
use App\Http\Controllers\credvisitaController;
use App\Http\Controllers\empresaController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\TermAeroController;
use App\Http\Controllers\usuarioController;
use App\Http\Controllers\vehiculoController;
use App\Models\Empresas;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest')->name('login');

Route::any('log1', [loginController::class, 'login']);
Route::post('logout', [loginController::class, 'logout'])->name('logout');

Route::get('index', [homeController::class, 'index']);

Route::group(['prefix' => 'credenciales'], function () {
    Route::get('view_1', [credencialesController::class, 'view_1']); // * vista modal create registro
    Route::any('query_create_1', [credencialesController::class, 'queryCreate_1']); //* create
    Route::get('queryShow_1', [credencialesController::class, 'queryShow_1']); //* lista general
    Route::any('query_add_photo/{e}', [credencialesController::class, 'query_add_photo']); //* agregar imagen
    Route::post('query_destroy_credencial', [credencialesController::class, 'query_destroy_credencial']); //* eliminar item
    Route::post('query_edit_emp', [credencialesController::class, 'query_edit_emp']);
    Route::post('query_update_emp', [credencialesController::class, 'query_update_emp']);
    Route::get('query_buscar_A', [credencialesController::class, 'query_buscar_A']);
    Route::post('query_renovar_creden/{tipo}', [credencialesController::class, 'query_renovar_creden']);
    // * mod credencial
    Route::get('query_update_TLC', [credencialesController::class, 'query_update_TLC']);
    // * credencial formato
    Route::get('query_cons_1', [credencialesController::class, 'query_cons_1']);
    Route::get('pdf_creden_emp_a/{e}/{t}', [credencialesController::class, 'pdf_creden_emp_a']);

    // * Credenciales de visitas
    Route::get('view_cv_1', [credvisitaController::class, 'viewHome']);
    Route::get('query_listCV', [credvisitaController::class, 'query_listCV']);
    Route::post('query_createCV', [credvisitaController::class, 'query_createCV']);
    Route::post('query_crevis_destroy', [credvisitaController::class, 'query_crevis_destroy']);
    Route::get('pdf_creden_v/{id}', [credvisitaController::class, 'pdf_creden_v']);
});
Route::group(['prefix' => 'Usuarios'], function () {
    Route::get('view_2_user', [usuarioController::class, 'view_1']);
    Route::post('create_user', [usuarioController::class, 'create_user']);
    Route::get('query_list', [usuarioController::class, 'query_list']);
    Route::post('query_destroyUser', [usuarioController::class, 'query_destroyUser']);
});
Route::group(['prefix' => 'Empresa'], function () {
    Route::get('view_2_empr', [empresaController::class, 'view_2_empr']);
    Route::get('query_list', [empresaController::class, 'query_list']);
    Route::get('query_buscar_A', [empresaController::class, 'query_buscar_A']);
    Route::post('query_create', [empresaController::class, 'query_create']);
    Route::get('query_orden_list_1', [empresaController::class, 'query_orden_list_1']);
    Route::get('query_edit', [empresaController::class, 'query_edit']);
    Route::post('query_update/{id}', [empresaController::class, 'query_update']);
});
Route::group(['prefix' => 'Vehiculo'], function () {
    Route::get('view_vei_home', [vehiculoController::class, 'view_1']);
    Route::get('query_list1', [vehiculoController::class, 'query_list1']);
    Route::get('query_detalle_1', [vehiculoController::class, 'query_detalle_1']);
    Route::get('create_1', [vehiculoController::class, 'create_1']);
    Route::post('query_store_1', [vehiculoController::class, 'store_1']);
    // * rutas para pdf de viñetas
    Route::get('pdf_viñeta_1/{e}/{f}/{t}', [vehiculoController::class, 'pdf_viñeta_1']);
});
Route::group(['prefix' => 'terminal'], function () {
    Route::get('view_home',[TermAeroController::class, 'index']);
    Route::get('query_list_1',[TermAeroController::class, 'query_list_1']);
    Route::post('query_create_1',[TermAeroController::class, 'query_create_1']);
});
