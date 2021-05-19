<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//http://localhost:8000/api/prueba
Route::get("/prueba", function(){
    return \App\Models\Producto::all();
});

Route::post('login', [\App\Http\Controllers\UserController::class, 'login'])->name('login');

Route::get('productos', [\App\Http\Controllers\ProductoController::class, 'index'])->name('productos'); //CRUD tabla pruductos
Route::put('set_like/{producto}', [\App\Http\Controllers\ProductoController::class, 'setLike'])->name('set_like');
Route::put('set_dislike/{producto}', [\App\Http\Controllers\ProductoController::class, 'setDislike'])->name('set_dislike');

Route::group(['middleware' => 'auth:api'], function(){

    //Route::apiResource('productos', \App\Http\Controllers\ProductoController::class); //CRUD tabla pruductos
    Route::apiResource('productos', \App\Http\Controllers\ProductoController::class, ['except' => ['index']]); //CRUD tabla pruductos
    Route::put('set_imagen/{producto}', [\App\Http\Controllers\ProductoController::class, 'setImagen'])->name('set_imagen');    

    Route::post('logout', [\App\Http\Controllers\UserController::class, 'logout'])->name('logout');
});

// Route::get('productos', [\App\Http\Controllers\ProductoController::class, 'index']);
// Route::get('productos/{producto}', [\App\Http\Controllers\ProductoController::class, 'show']);
// Route::delete('productos/{producto}', [\App\Http\Controllers\ProductoController::class, 'destroy']);
// Route::post('productos', [\App\Http\Controllers\ProductoController::class, 'store']);
// Route::put('productos/{producto}', [\App\Http\Controllers\ProductoController::class, 'update']);