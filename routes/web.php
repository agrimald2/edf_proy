<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\GerenteController;
use App\Http\Controllers\TradeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PermutaController;
use App\Http\Controllers\GestorController;
use App\Http\Controllers\NotificationController;

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
    Route::get('/gerente/permutas', [PermutaController::class, 'getGerentePermutas'])->name('permutas.gerente');
    Route::get('/gerente/permutas/pending', [GerenteController::class, 'showPermutasPendingList'])->name('permutas.pending.gerente');
    Route::get('/gerente/permutas/pending/list', [PermutaController::class, 'getGerentePendingPermutas'])->name('permutas.pending.list.gerente');
    
    Route::get('/gerente/locations', [GerenteController::class, 'getGerenteLocations'])->name('locations.gerente');
    
    Route::get('/trade/pendingPermutas', [TradeController::class, 'exportPendingPermutas']);
    Route::post('/trade/importPendingPermutas', [TradeController::class, 'importPendingPermutas']);

    // Added route for NotificationController's getActiveNotificacions method
    Route::get('/admin/dashboard/notifications/', [AdminController::class, 'notificacionsIndex'])->name('notifications.admin');
    Route::get('/notifications', [NotificationController::class, 'getNotificacions'])->name('notifications.all');
    Route::get('/notifications/active', [NotificationController::class, 'getActiveNotificacions'])->name('notifications.active');
    Route::post('/notifications', [NotificationController::class, 'store'])->name('notifications.store');
    Route::put('/notifications/{notification}', [NotificationController::class, 'update'])->name('notifications.update');
    Route::put('/notifications/toggle/{notification}', [NotificationController::class, 'toggleStatus'])->name('notifications.toggle');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
});

Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::get('/search', [MainController::class, 'search'])->name('search');
Route::post('/upload-excel', [MainController::class, 'replaceDataFromExcel'])->name('upload.excel');

Route::get('/ruta/{ruta}/info', [MainController::class, 'getInfoByRuta'])->name('infoByRuta');
Route::get('/mesa/{mesa}/info', [MainController::class, 'getInfoByMesa'])->name('infoByMesa');

Route::get('/gestor/{ruta}/permutas', [GestorController::class, 'showPermutasList'])->name('gestor.permutas.list');
Route::get('/supervisor/{mesa}/dashboard/permutas', [SupervisorController::class, 'showPermutasList'])->name('supervisor.permutas.list');
Route::get('/supervisor/{mesa}/dashboard/permutas/pending', [SupervisorController::class, 'showPermutasPendingList'])->name('supervisor.permutas.pending.list');



Route::get('/login/{code}', [MainController::class, 'loginByCode'])->name('loginByCode');


