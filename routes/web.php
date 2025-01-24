<?php

use App\Http\Controllers\Docker\ServicesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(["prefix" => "hyper-five/"], function () {

    //Services URLs
    Route::get('services', [ServicesController::class, 'listServices'])->name('services.list');
});

