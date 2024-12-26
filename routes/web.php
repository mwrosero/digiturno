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

Route::get('/refreshToken', [DigiturnoController::class, 'refreshToken'])->name('refreshToken');
Route::get('/{mac}', [DigiturnoController::class, 'index'])->name('index');
Route::get('/ingreso/{mac}', [DigiturnoController::class, 'ingreso'])->name('ingreso');
Route::get('/ingreso2/{mac}', [DigiturnoController::class, 'ingreso2'])->name('ingreso2');
Route::get('/portal/{portalToken}', [DigiturnoController::class, 'portal'])->name('portal');
Route::get('/turno/{portalToken}', [DigiturnoController::class, 'turno'])->name('turno');
Route::get('/turnero/{mac}', [DigiturnoController::class, 'turnero'])->name('turnero');
Route::get('/turnero/laboratorio/{mac}', [DigiturnoController::class, 'turneroLaboratorio'])->name('turneroLaboratorio');


Route::get('/test', function () {
    return response('welcome Akold');
});


Route::get('/git-pull', function () {
    if (request()->header('X-Git-Token') !== '**Ecu@dor123') {
        return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
    }

    $output = [];
    $returnCode = null;

    exec('cd /var/www/html/digiturno/digiturno && git pull 2>&1', $output, $returnCode);

    if ($returnCode === 0) {
        return response()->json(['status' => 'success', 'message' => 'Git pull executed successfully', 'output' => $output]);
    }

    return response()->json(['status' => 'error', 'message' => 'Failed to execute git pull', 'output' => $output], 500);
});
