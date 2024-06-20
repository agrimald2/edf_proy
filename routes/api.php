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

Route::post('permutas/{id}/approve', [PermutaController::class, 'approve'])->name('permutas.approve');
Route::post('permutas/{id}/reject', [PermutaController::class, 'reject'])->name('permutas.reject');

Route::get('permutas/supervisor', [PermutaController::class, 'getSupervisorPermutas'])->name('permutas.supervisor');
Route::get('permutas/gerente', [PermutaController::class, 'getGerentePermutas'])->name('permutas.gerente');
Route::get('permutas/trade', [PermutaController::class, 'getTradePermutas'])->name('permutas.trade');
