<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermutaController;
use App\Http\Controllers\PermutaReasonController;

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


Route::get('supervisor/{sv}/permutas', [PermutaController::class, 'getSupervisorPermutas'])->name('permutas.supervisor');
Route::get('gerente/permutas', [PermutaController::class, 'getGerentePermutas'])->name('permutas.gerente');
Route::get('trade/permutas', [PermutaController::class, 'getTradePermutas'])->name('permutas.trade');

Route::post('permutas/{id}/approve/supervisor', [PermutaController::class, 'approveBySupervisor'])->name('permutas.approve.supervisor');
Route::post('permutas/{id}/reject/supervisor', [PermutaController::class, 'rejectBySupervisor'])->name('permutas.reject.supervisor');

Route::post('permutas/{id}/approve/gerente', [PermutaController::class, 'approveByGerente'])->name('permutas.approve.gerente');
Route::post('permutas/{id}/reject/gerente', [PermutaController::class, 'rejectByGerente'])->name('permutas.reject.gerente');

Route::post('permutas/{id}/approve/trade', [PermutaController::class, 'approveByTrade'])->name('permutas.approve.trade');
Route::post('permutas/{id}/reject/trade', [PermutaController::class, 'rejectByTrade'])->name('permutas.reject.trade');