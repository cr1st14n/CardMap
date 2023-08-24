<?php

use App\Http\Controllers\AccessController;
use App\Http\Controllers\empleadoController;
use App\Http\Controllers\reporte_accesoController;
use App\Http\Controllers\reporte_credenController;
use Illuminate\Support\Facades\Route;

Route::get('access_verificacion', [AccessController::class, 'access_verificacion']);
Route::get('reporte/empresas_t_1', [reporte_credenController::class, 'empresas_t_1']);
Route::get('reporte/empresas_t_2', [reporte_credenController::class, 'empresas_t_2']);
Route::get('reporte/listAccesos_1', [reporte_accesoController::class, 'listAccesos_1']);
Route::get('reporte/empleadoMarcaciones', [reporte_accesoController::class, 'empleadoMarcaciones']);



Route::get('empleado/search_1', [empleadoController::class, 'search_1']);
