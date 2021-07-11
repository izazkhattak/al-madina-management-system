<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\InstallmentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectPlanController;
use App\Http\Controllers\ReportController;
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
    Route::resource('installments', InstallmentController::class);
    Route::resource('reports', ReportController::class)->only('index');

    Route::prefix('reports')->as('reports.')->group(function () {
        Route::get('/get-project-plans', [ReportController::class, 'getProjectPlans'])->name('get-project-plans');
        Route::get('/get-clients', [ReportController::class, 'getClients'])->name('get-clients');
        Route::get('/get-reports', [ReportController::class, 'getReports'])->name('get-reports');
    });
});
