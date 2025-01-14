<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ExampleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;


Route::post('/login', [AuthController::class, 'login']); 
Route::post('/register', [AuthController::class, 'register']); 

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']); 
});

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

Route::get('/create-role', function () {
    Permission::create(['name' =>'articles']);
    Role::create(['name' => 'writer']);
    $role = Role::findByName('writer');
    $role->givePermissionTo('articles');
});

use App\Models\User;

Route::get('/test-4', function () {
    $user = User::find(2);
    $user->assignRole('editor');
});



Route::middleware(['auth:sanctum', 'role:editor'])->group(function () {
    Route::get('/admin', function () {
        
    });
    Route::post('/add', [PostController::class, 'store']);
    Route::delete('/delete/{id}', [PostController::class, 'delete']);
    Route::put('/update/{id}', [PostController::class, 'update']);
});

Route::middleware(['auth:sanctum', 'role:viewer'])->group(function () {
    Route::get('/products', [PostController::class, 'listProducts']);
    Route::get('/products/{id}', [PostController::class, 'getProduct']);
});