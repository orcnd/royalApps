<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/authors', [App\Http\Controllers\HomeController::class, 'authors'])->name('authors');
Route::get('/author/{id}', [App\Http\Controllers\HomeController::class, 'viewAuthor'])->name('viewAuthor');
Route::get('/deleteAuthor/{id}', [App\Http\Controllers\HomeController::class, 'deleteAuthor'])->name('deleteAuthor');
Route::post('/deleteAuthor/{id}', [App\Http\Controllers\HomeController::class, 'deleteAuthorDestroy'])->name('deleteAuthorDestroy');


Route::get('/book/{id}', [App\Http\Controllers\HomeController::class, 'viewBook'])->name('viewBook');
Route::get('/deleteBook/{id}', [App\Http\Controllers\HomeController::class, 'deleteBook'])->name('deleteBook');
Route::post('/deleteBook/{id}', [App\Http\Controllers\HomeController::class, 'deleteBookDestroy'])->name('deleteBookDestroy');
Route::get('/newBook', [App\Http\Controllers\HomeController::class, 'newBook'])->name('newBook');
Route::post('/newBook', [App\Http\Controllers\HomeController::class, 'newBookStore'])->name('newBookStore');

Route::get('/login', [App\Http\Controllers\ApiUserController::class, 'login'])->name('login');
Route::post('/login', [App\Http\Controllers\ApiUserController::class, 'loginEnter'])->name('login');

Route::get('/logout', [App\Http\Controllers\ApiUserController::class, 'logout'])->name('logout');