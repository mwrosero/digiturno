<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DigiturnoController;
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

Route::get('/{mac}', [DigiturnoController::class, 'index'])->name('index');
Route::get('/ingreso/{mac}', [DigiturnoController::class, 'ingreso'])->name('ingreso');
Route::get('/ingreso2/{mac}', [DigiturnoController::class, 'ingreso2'])->name('ingreso2');
Route::get('/portal/{portalToken}', [DigiturnoController::class, 'portal'])->name('portal');
Route::get('/turno/{portalToken}', [DigiturnoController::class, 'turno'])->name('turno');
Route::get('/turnero/{mac}', [DigiturnoController::class, 'turnero'])->name('turnero');

Route::get('/test', function () {
    return response('welcome Akold');
});
