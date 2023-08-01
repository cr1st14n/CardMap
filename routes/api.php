<?php

use App\Http\Controllers\AccessController;
use Illuminate\Support\Facades\Route;

Route::get('access_verificacion', [AccessController::class, 'access_verificacion']);
