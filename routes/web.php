<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\MainController;


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
Route::get('/', [MainController::class, 'searchByRuta']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::get('/{ruta}/info', [MainController::class, 'getInfoByRuta'])->name('infoByRuta');
Route::get('/searchByRoute', [MainController::class, 'searchByRuta'])->name('searchByRuta');
Route::post('/upload-excel', [MainController::class, 'replaceDataFromExcel'])->name('upload.excel');