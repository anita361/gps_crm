<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\BranchManagerController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\AssignController;
use App\Http\Controllers\WalkinController;
use App\Http\Controllers\StatusController;


Route::get('/', [LoginController::class, 'index']);
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware('login')->group(function () {

    Route::view('/branch-dashboard', 'branch.dashboard')->name('branch.dashboard');

    Route::get('/branch-manager-dashboard', [BranchManagerController::class, 'branchManagerDashboard'])
        ->name('branch.manager.dashboard');
    Route::get('/walking-details/{smobile}', [BranchManagerController::class, 'walking_details'])->name('walking-details');


    Route::view('/counselor-dashboard', 'counselor.dashboard')->name('counselor.dashboard');

    Route::view('/admin-branch-report', 'admin.admin_branch_report')->name('admin.branch.report');

    Route::view('/cc-agent-report', 'callcenter.cc_agent_report')->name('callcenter.admin.dashboard');

    Route::view('/fi-dashboard', 'status.fi_dashboard')->name('status.fi');

    Route::view('/tt-dashboard', 'status.tt_dashboard')->name('status.tt');

    Route::view('/status-dashboard', 'status.dashboard')->name('status.dashboard');

    Route::view('/cmsn', 'cmsn.index')->name('cmsn.dashboard');

    Route::view('/aol-enrolled-status', 'operation.aol_enrolled_status')->name('operation.dashboard');

    Route::view('/finance-apnt-done', 'finance.finance_apnt_done')->name('finance.dashboard');

    Route::view('/commission-enrolled-list', 'commission.list')->name('commission.dashboard');


    /*
    |--------------------------------------------------------------------------
    | Lead Routes walking_details
    |--------------------------------------------------------------------------
    */

    Route::get('/lead/create', [LeadController::class, 'create'])->name('lead.create');

    Route::post('/lead/store', [LeadController::class, 'store'])->name('lead.store');

    Route::post('/lead/check-phone', [LeadController::class, 'checkPhone'])->name('lead.check.phone');

    Route::get('/lead/{mobile}', [LeadController::class, 'show'])->name('lead.show');

    /*
    |--------------------------------------------------------------------------
    | Walk-in
    |--------------------------------------------------------------------------
    */

//   Route::get('/walking-details/{smobile}',
// [WalkinController::class,'show'])
// ->name('walking-details');

/*
|--------------------------------------------------------------------------
| Walk-in
|--------------------------------------------------------------------------
*/

Route::get('/walking-details/{smobile}', [WalkinController::class, 'show'])
    ->name('walking-details');

Route::post('/walkin/personal', [WalkinController::class, 'updatePersonal'])
    ->name('walkin.personal');

Route::post('/spouse-update', [WalkinController::class, 'updateSpouse'])
    ->name('spouse.update');

Route::post('/update-operation-status', [WalkinController::class, 'updateOperationStatus'])
    ->name('update-operation-status');

Route::post('/add-notes', [WalkinController::class, 'addNotes'])
    ->name('add-notes');

Route::post('/operation-logs', [WalkinController::class, 'operationLogs'])
    ->name('operation-logs');

Route::post('/fund-status-logs', [WalkinController::class, 'fundStatusLogs'])
    ->name('fund-status-logs');




    Route::post('/get-notes', [NotesController::class, 'getNotes'])
        ->name('notes.get');

    Route::post('/add-note', [NotesController::class, 'addNote'])
        ->name('notes.add');



    Route::get('/assign/counselors', [AssignController::class, 'counselors'])
        ->name('assign.counselors');

    Route::post('/assign', [AssignController::class, 'assign'])
        ->name('assign.store');



    Route::post('/status/update', [StatusController::class, 'update'])
        ->name('status.update');

    Route::post('/status/logs', [StatusController::class, 'logs'])
        ->name('status.logs');

    Route::post('/status/fund-logs', [StatusController::class, 'fundStatus'])
        ->name('status.fund.logs');

    /*
    |--------------------------------------------------------------------------
    | Branch Manager Logs
    |--------------------------------------------------------------------------
    */

    Route::post('/branch-manager/logs', [BranchManagerController::class, 'getLogs'])
        ->name('branch.manager.logs');
});
