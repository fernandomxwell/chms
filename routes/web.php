<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CongregantController;
use App\Http\Controllers\CongregantServiceTypeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ServiceTypesController;
use Illuminate\Support\Facades\Route;

Route::get('login', [AuthController::class, 'create'])->name('login');
Route::post('login', [AuthController::class, 'store']);

Route::middleware(['auth'])
    ->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home.index');
        Route::resource('activities', ActivityController::class);
        Route::resource('congregants', CongregantController::class);
        Route::resource('service_types', ServiceTypesController::class);
        Route::resource('congregant_services', CongregantServiceTypeController::class)->except(['show']);
        Route::resource('schedules', ScheduleController::class)->except(['edit', 'update']);

        Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');

        Route::prefix('ajax')
            ->group(function () {
                Route::get('activities', [ActivityController::class, 'ajax'])->name('ajax.activities');
                Route::get('congregants', [CongregantController::class, 'ajax'])->name('ajax.congregants');
            });
    });
