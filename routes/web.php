<?php

use App\Http\Controllers\Core\AuthenticationController;
use App\Http\Controllers\Core\SubscriberController;
use App\Http\Controllers\Core\UEController;
use App\Http\Controllers\Core\UserController;
use App\Http\Controllers\Docker\ServicesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', [AuthenticationController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthenticationController::class, 'login'])->name('login.submit');
Route::get('/logout', [AuthenticationController::class, 'logout'])->name('logout');

//Route::get('/subscribers', [SubscriberController::class, 'index'])->name('subscribers')->middleware('auth.session');
//Route::get('/subscribers/{ueId}/{plmnId}', [SubscriberController::class, 'show'])->name('subscriber.detail');



Route::group(["prefix" => "ue/"], function () {
    Route::get('pdu-session-info', [UEController::class, 'getPduSessionInfo'])->name('ue_pdu_session_info');
    Route::get('registered-ue-context/{supi}', [UEController::class, 'getRegisteredUEContext'])->name('ue_registered_ue_context');
    Route::get('registered-ue-contexts', [UEController::class, 'getAllRegisteredUEContexts'])->name('ue_all_registered_ue_context');
    Route::get('charging-data', [UEController::class, 'getChargingData'])->name('ue_charging_data');
    Route::get('charging-records', [UEController::class, 'getChargingRecords'])->name('ue_charging_records');
});


Route::group(["prefix" => "subscribers/"], function () {

    Route::get('/', [SubscriberController::class, 'getAllSubscribers'])->name('subscribers');
    Route::get('{ueId}/{plmnId}', [SubscriberController::class, 'getSubscriber'])->name('get_subscriber');
    Route::post('add', [SubscriberController::class, 'addSubscriber'])->name('add_subscriber');
    Route::post('update', [SubscriberController::class, 'updateSubscriber'])->name('update_subscriber');
    Route::get('delete', [SubscriberController::class, 'deleteSubscriber'])->name('delete_subscriber');

});

Route::group(["prefix"=>"users"], function () {
    Route::get('/', [UserController::class, 'getUsers'])->name('all_users');
    Route::get('/{tenantId}/{userId}', [UserController::class, 'getUser'])->name('get_user');
    Route::get('add', [UserController::class, 'showCreateUserForm'])->name('add_user');
    Route::get('delete', [UserController::class, 'deleteUser'])->name('delete_user');
    Route::post('add', [UserController::class, 'createUser'])->name('create_user');
    Route::post('update', [UserController::class, 'updateUser'])->name('update_user');
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
});

