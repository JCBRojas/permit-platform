<?php

use App\Http\Controllers\DietController;
use App\Models\Diet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login-b');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
     // 🔵 NUTRICIONISTA
    Route::middleware(['role:nutricionista'])->group(function () {
        Route::get('/dashboard/nutrition', [DietController::class, 'nutritionDashboard'])
            ->name('dashboard.nutrition');
    });

    // 🟢 DESPACHADOR
    Route::middleware(['role:despachador'])->group(function () {
        Route::get('/dashboard/dispatch', [DietController::class, 'dispatcherDashboard'])
            ->name('dashboard.dispatch');
    });

    Route::post('/dietas', [DietController::class, 'createDiet'])->name('dietas.create');
    Route::put('/dietas/{diet}/version', [DietController::class, 'createNewVersionDiet'])->name('dietas.update');
    Route::get('/diet-reports', [DietController::class,'nutritionReport'])
    ->name('diet.reports');
    Route::get('/entrega/index', [EntregaController::class, 'index'])->name('entrega.index');
    Route::get('/entrega/canceladas', [EntregaController::class, 'canceladas'])->name('dietas.canceladas');
    Route::get('/entrega/historial', [EntregaController::class, 'historial'])->name('historial.index');
    Route::get('/entrega/reportes', [EntregaController::class, 'reportes'])->name('reportes.nutricional');
});
