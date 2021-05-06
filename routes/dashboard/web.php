<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => LaravelLocalization::setLocale()],
    function () {
        Route::prefix('dashboard')->middleware('auth')->name('dashboard.')->group(function () {

            Route::get('/index', DashboardController::class . "@index")->name('index');


        });// end dashboard routes
    });
