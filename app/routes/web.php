<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//以下追加分
Route::resource('todo', 'App\Http\Controllers\TodoController');
Route::put('todo/done/{todo}', [App\Http\Controllers\TodoController::class, 'done'])->name('todo.done');
Route::put('todo/undone/{todo}', [App\Http\Controllers\TodoController::class, 'undone'])->name('todo.undone');
//ここまで