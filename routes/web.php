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
    Route::get('config/smf', [ServicesController::class, 'SMFConfigs'])->name('smf_configs');
    Route::get('config/udm', [ServicesController::class, 'UDMConfigs'])->name('udm_configs');
    Route::get('config/udr', [ServicesController::class, 'UDRConfigs'])->name('udr_configs');
    Route::get('config/ausf', [ServicesController::class, 'AUSFConfigs'])->name('ausf_configs');
    Route::get('config/pcf', [ServicesController::class, 'PCFConfigs'])->name('pcf_configs');
    Route::get('config/chf', [ServicesController::class, 'CHFConfigs'])->name('chf_configs');
    Route::get('config/ehr', [ServicesController::class, 'EHRConfigs'])->name('ehr_configs');
    Route::get('config/nrf', [ServicesController::class, 'NRFconfigs'])->name('nrf_configs');
    Route::get('config/upf', [ServicesController::class, 'UPFConfigs'])->name('upf_configs');
    Route::get('config/system', [ServicesController::class, 'systemConfigs'])->name('system_configs');


    Route::post('/docker/start/{containerId}', [ServicesController::class, 'startService'])->name('start_service');
    Route::post('/docker/stop/{containerId}', [ServicesController::class, 'stopService'])->name('stop_service');
    Route::post('/docker/restart/{containerId}', [ServicesController::class, 'restartService'])->name('restart_service');


    Route::get('/docker/logs/{containerId}', [ServicesController::class, 'viewLogs'])->name('view_logs');

    Route::get('/docker/command/{containerId}', [ServicesController::class, 'commandExecutionPage'])->name('command_execution');
    Route::post('/docker/execute/{containerId}', [ServicesController::class, 'executeCommand'])->name('execute_command');
    Route::post('/containers/{containerId}/stop-command', [ServicesController::class, 'stopCommand'])->name('stop_command');

    Route::get('/containers/{containerId}/logs/stream', [ServicesController::class, 'streamLogs']);
});

