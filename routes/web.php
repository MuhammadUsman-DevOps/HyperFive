<?php

use App\Http\Controllers\Core\AuthenticationController;
use App\Http\Controllers\Core\SubscriberController;
use App\Http\Controllers\Core\TenantController;
use App\Http\Controllers\Core\UEController;
use App\Http\Controllers\Core\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Docker\ServiceManagementController;
use App\Http\Controllers\Docker\ServiceConfigController;
use App\Http\Controllers\Docker\CommandController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', [AuthenticationController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthenticationController::class, 'login'])->name('login.submit');
Route::get('/logout', [AuthenticationController::class, 'logout'])->name('logout');

//Route::get('/subscribers', [SubscriberController::class, 'index'])->name('subscribers')->middleware('auth.session');
//Route::get('/subscribers/{ueId}/{plmnId}', [SubscriberController::class, 'show'])->name('subscriber.detail');


Route::group(["prefix" => "ue/"], function () {
    Route::get('pdu-session-info/{smContextRef}', [UEController::class, 'getPduSessionInfo'])->name('ue_pdu_session_info');
    Route::get('registered-ue-context/{supi}', [UEController::class, 'getRegisteredUEContext'])->name('ue_registered_ue_context');
    Route::get('registered-ue-contexts', [UEController::class, 'getAllRegisteredUEContexts'])->name('ue_all_registered_ue_context');
    Route::get('charging-data', [UEController::class, 'getChargingData'])->name('ue_charging_data');
    Route::get('charging-records', [UEController::class, 'getChargingRecords'])->name('ue_charging_records');
});


Route::group(["prefix" => "subscribers/"], function () {

    Route::get('/', [SubscriberController::class, 'getAllSubscribers'])->name('subscribers');
    Route::get('{ueId}/{plmnId}', [SubscriberController::class, 'getSubscriber'])->name('get_subscriber');
    Route::get('add', [SubscriberController::class, 'showAddSubscriberForm'])->name('add_subscriber');
    Route::get('import', [SubscriberController::class, 'importSubscribers'])->name('import_subscriber');
    Route::post('add', [SubscriberController::class, 'addSubscriber'])->name('add_subscriber');
    Route::post('update', [SubscriberController::class, 'updateSubscriber'])->name('update_subscriber');
    Route::get('delete', [SubscriberController::class, 'deleteSubscriber'])->name('delete_subscriber');

});

Route::group(["prefix"=>"users/"], function () {
    Route::get('{tenantId}', [UserController::class, 'getUsers'])->name('all_users');
    Route::get('{tenantId}/{userId}', [UserController::class, 'getUser'])->name('get_user');
    Route::get('add', [UserController::class, 'showCreateUserForm'])->name('add_user');
    Route::get('delete', [UserController::class, 'deleteUser'])->name('delete_user');
    Route::post('add', [UserController::class, 'createUser'])->name('create_user');
    Route::post('update', [UserController::class, 'updateUser'])->name('update_user');
});


Route::group(["prefix"=>"tenants/"], function () {
    Route::get('', [TenantController::class, 'getAllTenants'])->name('all_tenants');
    Route::get('{tenantId}/{userId}', [TenantController::class, 'getTenant'])->name('get_tenant');
    Route::get('add', [TenantController::class, 'addTenant'])->name('add_tenant');
    Route::get('delete', [TenantController::class, 'deleteTenant'])->name('delete_tenant');
    Route::post('add', [TenantController::class, 'addTenant'])->name('create_tenant');
    Route::post('update', [TenantController::class, 'updateTenant'])->name('update_tenant');
});


Route::prefix('hyper-five')->group(function () {

     ///////////  Service Management Routes ///////////

    Route::controller(ServiceManagementController::class)->group(function () {
        Route::get('services', 'listServices')->name('services.list');
        Route::post('start-engine', 'startFullSetup')->name('start_engine');
        Route::post('stop-engine', 'stopFullSetup')->name('stop_engine');

        Route::post('docker/start/{containerId}', 'startService')->name('start_service');
        Route::post('docker/stop/{containerId}', 'stopService')->name('stop_service');
        Route::post('docker/restart/{containerId}', 'restartService')->name('restart_service');
    });

    /////////// Configuration Routes ///////////

    Route::controller(ServiceConfigController::class)->prefix('config')->group(function () {
        Route::get('/', 'getConfigFromVM')->name('config.list');
        Route::get('amf', 'AMFConfigs')->name('amf_configs');
        Route::get('smf', 'SMFConfigs')->name('smf_configs');
        Route::get('udm', 'UDMConfigs')->name('udm_configs');
        Route::get('udr', 'UDRConfigs')->name('udr_configs');
        Route::get('ausf', 'AUSFConfigs')->name('ausf_configs');
        Route::get('pcf', 'PCFConfigs')->name('pcf_configs');
        Route::get('chf', 'CHFConfigs')->name('chf_configs');
        Route::get('ehr', 'EHRConfigs')->name('ehr_configs');
        Route::get('nrf', 'NRFconfigs')->name('nrf_configs');
        Route::get('upf', 'UPFConfigs')->name('upf_configs');
        Route::get('system', 'systemConfigs')->name('system_configs');
    });

    ///////////  Command Execution Routes ///////////
    
    Route::controller(CommandController::class)->group(function () {
        Route::get('docker/logs/{containerId}', 'viewLogs')->name('view_logs');
        Route::get('docker/command/{containerId}', 'commandExecutionPage')->name('command_execution');
        Route::post('docker/execute/{containerId}', 'executeCommand')->name('execute_command');
        Route::post('containers/{containerId}/stop-command', 'stopCommand')->name('stop_command');
    });
});


