<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DataBarangController;
use App\Http\Controllers\API\NamaPenjualController;
use App\Http\Controllers\API\PenjualController;
use App\Models\NamaPenjual;
use App\Models\Penjual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', [AuthController::class,'login']);
Route::resource('/databarang', DataBarangController::class);
Route::post('/databarang/{idBarang}', [DataBarangController::class,'update']);
Route::resource('/datapenjual', NamaPenjualController::class);

Route::group(['middleware'=>'auth:sanctum'], function () {
    Route::resource('/namapenjual', NamaPenjualController::class);
    Route::post('/namapenjual/{idPenjual}', [NamaPenjualController::class,'update']);
});

