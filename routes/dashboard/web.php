<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]],
    function () {
        Route::prefix('dashboard')->middleware('auth')->name('dashboard.')->group(function () {

            Route::get('/index', DashboardController::class . "@index")->name('index');
            Route::resource('users',UserController::class);
            Route::resource('categories',CategoryController::class);
            Route::resource('products',ProductController::class);



        });// end dashboard routes
    });
