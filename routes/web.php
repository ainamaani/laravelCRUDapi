<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Middleware\VerifyCsrfToken;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/token', function () {
    return csrf_token(); 
});

Route::post('/students/register', [StudentController::class, 'store']);

Route::get('/students', [StudentController::class, 'index']);

Route::get('/students/{id}', [StudentController::class, 'show']);

Route::delete('/students/delete/{id}', [StudentController::class, 'destroy']);

Route::put('/students/update/{id}', [StudentController::class, 'update']);



