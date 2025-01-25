<?php

use App\Http\Controllers\Docker\ServicesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(["prefix" => "hyper-five/"], function () {

    //Services URLs
    Route::get('services', [ServicesController::class, 'listServices'])->name('services.list');
    Route::get('config', [ServicesController::class, 'getConfigFromVM'])->name('config.list');
    Route::get('config/amf', [ServicesController::class, 'AMFConfigs'])->name('amf_configs');
    Route::get('config/udm', [ServicesController::class, 'UDMConfigs'])->name('amf_configs');
});

