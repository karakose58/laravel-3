<?php

use App\Http\Controllers\AA;
use App\Http\Controllers\FrontController;

Route::get('/register', [FrontController::class, 'registerPage'])->name('register.page');
Route::post('/register', [FrontController::class, 'register'])->name('register');

Route::get('/login', [FrontController::class, 'loginPage'])->name('login.page');
Route::post('/login', [FrontController::class, 'login'])->name('login');

Route::get('/home', [FrontController::class, 'home'])->name('home');

Route::post('/logout', [FrontController::class, 'logout'])->name('logout');

Route::get('/add', [FrontController::class, 'add'])->name('add.product');
Route::post('/add', [FrontController::class, 'store'])->name('store.product');

Route::get('/edit/{id}', [FrontController::class, 'edit'])->name('edit.product');
Route::put('/update/{id}', [FrontController::class, 'update'])->name('update.product');

Route::delete('/delete/{id}', [FrontController::class, 'delete'])->name('delete.product');
Route::get('/show/{id}', [FrontController::class, 'show'])->name('show.product');
