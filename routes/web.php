<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('{page}', App\Http\Controllers\MainController::class)->where('page', '.*');
