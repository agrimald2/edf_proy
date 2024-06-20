<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\MainController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\GerenteController;
use App\Http\Controllers\TradeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PermutaController;

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
Route::get('/', [MainController::class, 'search']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () { return Inertia::render('Dashboard'); })->name('dashboard');
    Route::get('/admin/permutas', [MainController::class, 'showPermutasAdmin'])->name('permutas');
    Route::get('/admin/dashboard', function () { return Inertia::render('Dashboard'); })->name('admin.dashboard');
    Route::get('/supervisor/dashboard', [SupervisorController::class, 'index'])->name('supervisor.dashboard');
    Route::get('/gerente/dashboard', [GerenteController::class, 'index'])->name('gerente.dashboard');
    Route::get('/trade/dashboard', [TradeController::class, 'index'])->name('trade.dashboard');
});

Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::get('/search', [MainController::class, 'search'])->name('search');
Route::post('/upload-excel', [MainController::class, 'replaceDataFromExcel'])->name('upload.excel');

Route::get('/ruta/{ruta}/info', [MainController::class, 'getInfoByRuta2'])->name('infoByRuta');




Route::get('/test/{ruta}/info', [MainController::class, 'getInfoByRuta2'])->name('infoByRuta2');
Route::get('/supervisor/{mesa}/dashboard/permutas', [SupervisorController::class, 'showPermutasList'])->name('supervisor.permutas.list');

Route::get('/mesa/{mesa}/info', [MainController::class, 'getInfoByMesa'])->name('infoByMesa');

