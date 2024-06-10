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
Route::get('/', [MainController::class, 'search']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::get('/search', [MainController::class, 'search'])->name('search');

Route::post('/upload-excel', [MainController::class, 'replaceDataFromExcel'])->name('upload.excel');

Route::get('/test/{ruta}/info', [MainController::class, 'getInfoByRuta2'])->name('infoByRuta2');


Route::get('/ruta/{ruta}/info', [MainController::class, 'getInfoByRuta'])->name('infoByRuta');
Route::get('/mesa/{mesa}/info', [MainController::class, 'getInfoByMesa'])->name('infoByMesa');
