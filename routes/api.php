<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('signup', [App\Http\Controllers\AuthController::class, 'signup'])->name('signup');
Route::post('login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
//acceso a edicion o eliminacion tareas si ha iniciado sesion
Route::group(
    ['middleware' => ["auth:sanctum"]],
    function () {
        Route::post('/newtask', [App\Http\Controllers\TareasController::class, 'newtask'])->name('newtask');
        Route::get('gettask/{user_id}', [App\Http\Controllers\TareasController::class, 'gettask'])->name('gettask');
        Route::delete('deletetask/{id}', [App\Http\Controllers\TareasController::class, 'deletetask'])->name('deletetask');
        Route::get('logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
    }
);