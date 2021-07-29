<?php

use App\Http\Controllers\AllClientReportController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientInstallmentController;
use App\Http\Controllers\ClientReportController;
use App\Http\Controllers\DealerController;
use App\Http\Controllers\DealerInstallmentController;
use App\Http\Controllers\DealerReportController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectPlanController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::middleware('auth')->group(function () {
    Route::get('/home', [ProjectController::class, 'index'])->name('home');

    Route::resource('projects', ProjectController::class);
    Route::resource('project-plans', ProjectPlanController::class)->except('edit');

    Route::resource('clients', ClientController::class);
    Route::resource('client-installments', ClientInstallmentController::class);
    Route::resource('client-reports', ClientReportController::class)->only('index');

    Route::resource('dealers', DealerController::class);
    Route::resource('dealer-installments', DealerInstallmentController::class);
    Route::resource('dealer-reports', DealerReportController::class)->only('index');

    Route::prefix('client-reports')->as('client-reports.')->group(function () {
        Route::get('/get-project-plans', [ClientReportController::class, 'getProjectPlans'])->name('get-project-plans');
        Route::get('/get-clients', [ClientReportController::class, 'getClients'])->name('get-clients');
        Route::get('/get-reports', [ClientReportController::class, 'getReports'])->name('get-reports');
    });

    Route::prefix('dealer-reports')->as('dealer-reports.')->group(function () {
        Route::get('/get-project-plans', [DealerReportController::class, 'getProjectPlans'])->name('get-project-plans');
        Route::get('/get-dealer', [DealerReportController::class, 'getDealer'])->name('get-dealer');
        Route::get('/get-reports', [DealerReportController::class, 'getReports'])->name('get-reports');
    });

    Route::prefix('csv')->as('csv.')->group(function () {
        Route::get('download-clients', [ClientController::class, 'downloadClients'])->name('download-clients');
        Route::get('download-unpaid-clients', [ClientController::class, 'downloadUnpaidClients'])->name('download-unpaid-clients');
    });

    Route::prefix('all-client-reports')->as('all-client-reports.')->group(function () {
        Route::get('/', [AllClientReportController::class, 'index'])->name('index');
        Route::get('/reports', [AllClientReportController::class, 'reports'])->name('reports');
    });
});
