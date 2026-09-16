<?php

use Illuminate\Support\Facades\Route;


Route::as('admin.')->middleware([])->group(function (){

    Route::prefix('/')->middleware([])->group(function (){
        Route::get('/login',[\App\Http\Controllers\V1\Web\AuthController::class,'index'])->name('login.index');
        Route::post('/login',[\App\Http\Controllers\V1\Web\AuthController::class,'login'])->name('login');
        Route::post('/logout',[\App\Http\Controllers\V1\Web\AuthController::class,'logout'])->name('logout');
    });

    Route::prefix('admin')->middleware(['authCheck'])->group(function (){
        Route::get('/',[\App\Http\Controllers\V1\Web\DashboardController::class,'index'])->name('index');
        Route::post('/clear-cache', [\App\Http\Controllers\V1\Web\DashboardController::class, 'clearCache'])->name('clearCache');
        Route::get('/settings',[\App\Http\Controllers\V1\Web\SettingController::class,'index'])->name('settings.index');
        Route::post('/settings',[\App\Http\Controllers\V1\Web\SettingController::class,'update'])->name('settings.update');
        Route::resource('users',\App\Http\Controllers\V1\Web\UserController::class);
        Route::resource('admins',\App\Http\Controllers\V1\Web\AdminController::class);
        Route::resource('roles',\App\Http\Controllers\V1\Web\RoleController::class);
        Route::resource('provinces',\App\Http\Controllers\V1\Web\ProvinceController::class);
        Route::resource('cities',\App\Http\Controllers\V1\Web\CityController::class);

    });

});
