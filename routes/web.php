<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\BranchManagerController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\AssignController;
use App\Http\Controllers\WalkinController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\FinanceAppointmentController;


Route::get('/', [LoginController::class, 'index']);
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware('login')->group(function () {


    Route::get('/branch-dashboard', [BranchManagerController::class, 'branchDashboard'])
        ->name('branch.dashboard');

    Route::get('/branch-manager-dashboard', [BranchManagerController::class, 'branchManagerDashboard'])
        ->name('branch.manager.dashboard');
    Route::post('/branch-summary', [BranchManagerController::class, 'branchSummary'])
        ->name('branch.summary');



    Route::view('/counselor-dashboard', 'counselor.dashboard')->name('counselor.dashboard');


    Route::get('/admin-branch-report', [BranchManagerController::class, 'adminBranchReport'])
        ->name('admin.branch.report');
    Route::post('/fetch-city', [BranchManagerController::class, 'fetchCity']);
    Route::post('/fetch-all-city', [BranchManagerController::class, 'fetchAllCity']);

    Route::view('/cc-agent-report', 'callcenter.cc_agent_report')->name('callcenter.admin.dashboard');

    Route::view('/fi-dashboard', 'status.fi_dashboard')->name('status.fi');

    Route::view('/tt-dashboard', 'status.tt_dashboard')->name('status.tt');

    Route::view('/status-dashboard', 'status.dashboard')->name('status.dashboard');

    Route::view('/cmsn', 'cmsn.index')->name('cmsn.dashboard');


    // Route::get('/aol-enrolled-status', [OperationController::class, 'aolEnrolledStatus'])
    //     ->name('operation.dashboard');
    // Route::get(
    //     '/operation/export',
    //     [OperationController::class, 'exportExcel']
    // )
    //     ->name('operation.export');

    Route::get('/aol-enrolled-status', [OperationController::class, 'aolEnrolledStatus'])
        ->name('operation.dashboard');

    Route::get('/export', [OperationController::class, 'exportExcel'])
        ->name('operation.export');

    Route::post('/update-status', [OperationController::class, 'updateOperationStatus'])
        ->name('operation.update.status');

    Route::post('/update-fund-status', [OperationController::class, 'updateFundStatus'])
        ->name('operation.update.fund.status');

    Route::post('/notes', [OperationController::class, 'getNotes'])
        ->name('operation.notes');

    Route::post('/notes/add', [OperationController::class, 'addNote'])
        ->name('operation.notes.add');

    Route::post('/logs', [OperationController::class, 'operationLogs'])
        ->name('operation.logs');

    Route::post('/fund-logs', [OperationController::class, 'fundStatusLogs'])
        ->name('operation.fund.logs');

    Route::get('/campuses/{college}', [OperationController::class, 'getCampuses'])
        ->name('operation.campuses');

    Route::get('/programs/{college}/{campus}', [OperationController::class, 'getPrograms'])
        ->name('operation.programs');




    // Route::view('/finance-apnt-done', 'finance.finance_apnt_done')->name('finance.dashboard');
    Route::get('/finance-apnt-done', [FinanceAppointmentController::class, 'index'])->name('finance.dashboard');

    Route::post('/finance/foa-status', [FinanceAppointmentController::class, 'updateFoaStatus'])->name('finance.foa.status');

    Route::post('/finance/send-email', [FinanceAppointmentController::class, 'sendEmail'])->name('finance.send.email');

    Route::post('/finance/osap-status', [FinanceAppointmentController::class, 'saveOsapStatus'])->name('finance.osap.status');

    Route::post('/finance/osap-logs', [FinanceAppointmentController::class, 'osapLogs'])->name('finance.osap.logs');

    Route::get('/finance/export', [FinanceAppointmentController::class, 'export'])->name('finance.export');



    Route::view('/commission-enrolled-list', 'commission.list')->name('commission.dashboard');




   Route::get('/lead/create', [LeadController::class, 'create'])
    ->name('lead.create');

    Route::post('/lead/store', [LeadController::class, 'store'])
        ->name('lead.store');

    Route::post('/lead/check-phone', [LeadController::class, 'checkPhone'])
        ->name('lead.check.phone');

    Route::get('/lead/{mobile}', [LeadController::class, 'show'])
        ->name('lead.show');


    Route::get('/walking-details/{smobile}', [WalkinController::class, 'show'])
        ->name('walking-details');

    Route::post('/walkin/personal', [WalkinController::class, 'updatePersonal'])
        ->name('walkin.personal');

    Route::post('/student/spouse/save', [WalkinController::class, 'updateSpouse'])
        ->name('student.spouse.save');

    Route::post('/dependant/update', [WalkinController::class, 'updateDependant'])
        ->name('dependant.update');

    Route::post('/emergency/update', [WalkinController::class, 'updateEmergency'])
        ->name('emergency.update');

    Route::post('/documents/update', [WalkinController::class, 'updateDocuments'])
        ->name('documents.update');

    Route::post(
        '/status/update',
        [WalkinController::class, 'updateStatus']
    )
        ->name('status.update');
    // Route::post('/status/update', [StatusController::class, 'update'])
    // ->name('status.update');

    // Route::post('/message/send', [WalkinController::class, 'sendMessage'])
    //     ->name('message.send');

    Route::post('/notes/update', [WalkinController::class, 'updateNotes'])
        ->name('notes.update');

    Route::post('/update-operation-status', [WalkinController::class, 'updateOperationStatus'])
        ->name('update-operation-status');

    Route::post('/add-notes', [WalkinController::class, 'addNotes'])
        ->name('add-notes');

    Route::post('/operation-logs', [WalkinController::class, 'operationLogs'])
        ->name('operation-logs');

    Route::post('/fund-status-logs', [WalkinController::class, 'fundStatusLogs'])
        ->name('fund-status-logs');


    Route::post('/message/send', [WalkinController::class, 'sendMessage'])
        ->name('message.send');



    Route::post('/get-notes', [NotesController::class, 'getNotes'])
        ->name('notes.get');

    Route::post('/add-note', [NotesController::class, 'addNote'])
        ->name('notes.add');



    Route::get('/assign/counselors', [AssignController::class, 'counselors'])
        ->name('assign.counselors');

    Route::post('/assign', [AssignController::class, 'assign'])
        ->name('assign.store');



    // Route::post('/status/update', [StatusController::class, 'update'])
    //     ->name('status.update');

    Route::post('/status/logs', [StatusController::class, 'logs'])
        ->name('status.logs');

    Route::post('/status/fund-logs', [StatusController::class, 'fundStatus'])
        ->name('status.fund.logs');



    Route::post('/branch-manager/logs', [BranchManagerController::class, 'getLogs'])
        ->name('branch.manager.logs');
});
