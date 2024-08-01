<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermutaController;
use App\Http\Controllers\PermutaReasonController;
use App\Http\Controllers\PermutaRejectedReasonController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\MainController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('permutas', PermutaController::class);
Route::resource('permuta-reasons', PermutaReasonController::class);

Route::get('gestor/{ruta}/permutas', [PermutaController::class, 'getGestorPermutas'])->name('permutas.gestor');

Route::get('supervisor/{sv}/permutas', [PermutaController::class, 'getSupervisorPermutas'])->name('permutas.supervisor');
Route::get('supervisor/{sv}/permutas/pending', [PermutaController::class, 'getSupervisorPendingPermutas'])->name('permutas.pending.supervisor');

Route::get('trade/permutas', [PermutaController::class, 'getTradePermutas'])->name('permutas.trade');

Route::post('permutas/{id}/approve/supervisor/{sv}', [PermutaController::class, 'approveBySupervisor'])->name('permutas.approve.supervisor');
Route::post('permutas/{id}/reject/supervisor', [PermutaController::class, 'rejectBySupervisor'])->name('permutas.reject.supervisor');


Route::post('permutas/{id}/approve/gerente/{name}', [PermutaController::class, 'approveByGerente'])->name('permutas.approve.gerente');
Route::post('permutas/{id}/reject/gerente', [PermutaController::class, 'rejectByGerente'])->name('permutas.reject.gerente');
Route::post('permutas/{id}/approve/trade', [PermutaController::class, 'approveByTrade'])->name('permutas.approve.trade');
Route::post('permutas/{id}/reject/trade', [PermutaController::class, 'rejectByTrade'])->name('permutas.reject.trade');


Route::get('permuta-rejected-reasons', [PermutaRejectedReasonController::class, 'index']);

Route::get('locations', [LocationController::class, 'index']);
Route::get('regions', [RegionController::class, 'index']);

Route::get('supervisor/{sv}/limit', [SupervisorController::class, 'getSupervisorLimit'])->name('limit.supervisor');

Route::get('regions/list', [MainController::class, 'getRegions'])->name('regions.list');
Route::get('subregions/list', [MainController::class, 'getSubRegions'])->name('subregions.list');
Route::get('location/list', [MainController::class, 'getLocations'])->name('locations.list');


Route::get('supervisor/nameByMesa/{sv}', [SupervisorController::class, 'getNameByMesa'])->name('supervisor.name.mesa');