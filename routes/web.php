<?php

use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('tasks');
});

Route::get('/api/test', function () {
    return 'API test is working!';
});

Route::get('/dashboard', function () {
    return view('tasks');
});

Route::prefix('api/tasks')->middleware('throttle:60,1')->group(function () {
    Route::get('/', [TaskController::class, 'index']);
    Route::post('/', [TaskController::class, 'store']);
    Route::patch('/{task}/status', [TaskController::class, 'updateStatus']);
    Route::delete('/{task}', [TaskController::class, 'destroy']);
    Route::get('/report', [TaskController::class, 'dailyReport']);
});
