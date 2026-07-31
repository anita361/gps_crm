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
use App\Http\Controllers\LeadFollowupController;
use App\Http\Controllers\FinanceDashboardController;
use App\Http\Controllers\FinanceExportController;
use App\Http\Controllers\CsvUploadController;



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





    Route::get('/finance-apnt-done', [FinanceAppointmentController::class, 'index'])->name('finance.dashboard');

    Route::post('/finance/foa-status', [FinanceAppointmentController::class, 'updateFoaStatus'])->name('finance.foa.status');

    Route::post('/finance/send-email', [FinanceAppointmentController::class, 'sendEmail'])->name('finance.send.email');

    Route::post('/finance/osap-status', [FinanceAppointmentController::class, 'saveOsapStatus'])->name('finance.osap.status');

    Route::post('/finance/osap-logs', [FinanceAppointmentController::class, 'osapLogs'])->name('finance.osap.logs');

    Route::get('/finance/export', [FinanceAppointmentController::class, 'export'])->name('finance.export');

    /*
|--------------------------------------------------------------------------
| Finance Dashboard Report
|--------------------------------------------------------------------------
*/


    Route::get('/finance-dashboard-report', [FinanceDashboardController::class, 'index'])
        ->name('finance.dashboard.report');

    Route::get('/finance-dashboard-report/export', [FinanceExportController::class, 'export'])
        ->name('finance.dashboard.report.export');



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

    Route::post('/get-template', [WalkinController::class, 'getTemplate'])
        ->name('get.template');




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

    Route::get('/user-details', [WalkinController::class, 'userDetails'])
        ->name('users.index');

    Route::get('/add-new-user', [WalkinController::class, 'createUser'])
        ->name('users.create');

    Route::post('/add-new-user', [WalkinController::class, 'storeUser'])
        ->name('users.store');

    Route::post('/update-user-status', [WalkinController::class, 'updateUserStatus'])
        ->name('users.status');

    Route::post('/check-username', [WalkinController::class, 'checkUsername'])
        ->name('users.checkUsername');
    /*
    |--------------------------------------------------------------------------
    | Lead Followup
    |--------------------------------------------------------------------------
    */

    Route::get('/lead-followup', [LeadFollowupController::class, 'index'])
        ->name('lead.followup');

    Route::post('/lead-followup/filter', [LeadFollowupController::class, 'filter'])
        ->name('lead.followup.filter');

    Route::get('/lead-followup/today', [LeadFollowupController::class, 'today'])
        ->name('lead.followup.today');

    Route::get('/lead-followup/notes/{id}', [LeadFollowupController::class, 'notes'])
        ->name('lead.followup.notes');

    Route::get('/lead-followup/logs/{id}', [LeadFollowupController::class, 'logs'])
        ->name('lead.followup.logs');
    Route::post(
        '/lead-followup/notes/save',
        [LeadFollowupController::class, 'saveNote']
    )
        ->name('lead.followup.notes.save');

    Route::get('/upload-csv', [CsvUploadController::class, 'showForm'])->name('csv.form');
    Route::post('/upload-csv', [CsvUploadController::class, 'upload'])->name('csv.upload');

    Route::get('/lead-list', [CsvUploadController::class, 'leadList'])->name('lead.list');
    Route::get('/seminar-lead-list', [CsvUploadController::class, 'seminarList'])->name('seminar.list');
    Route::get('/seminar-lead-download', [CsvUploadController::class, 'seminarDownload'])
        ->name('seminar.download');
    Route::post('/lead-assign', [CsvUploadController::class, 'assignLead'])
        ->name('lead.assign');

    /*
    |--------------------------------------------------------------------------
    | Reports
    |--------------------------------------------------------------------------
    */

    Route::get('/full-branch-report', [WalkinController::class, 'fullBranchReport'])
        ->name('reports.branch');

    Route::get('/lead-report', [WalkinController::class, 'leadReport'])
        ->name('reports.lead');
    Route::post('/lead-report-count', [WalkinController::class, 'leadReportCount'])
        ->name('reports.lead.count');

    Route::get('/source-report', [WalkinController::class, 'sourceReport'])
        ->name('reports.source');

    Route::get('/daily-sales-report', [WalkinController::class, 'dailySalesReport'])
        ->name('reports.daily-sales');


    Route::get('/feedback-details', [WalkinController::class, 'feedbackDetails'])
        ->name('reports.feedback');
    Route::post('/feedback-details/view', [WalkinController::class, 'viewFeedback'])
        ->name('feedback.view');



    /*
|--------------------------------------------------------------------------
| Enrolled Menu Routes
|--------------------------------------------------------------------------
*/

    Route::get('/operation-status', [WalkinController::class, 'operationStatus'])
        ->name('operation.status');


    Route::post(
        '/operation/update-status',
        [WalkinController::class, 'updateStatus']
    )->name('operation.updateStatus');
    Route::post(
        '/operation/logs',
        [WalkinController::class, 'operationLogs']
    )->name('operation.logs');

    Route::post(
        '/operation/notes/save',
        [WalkinController::class, 'addNotes']
    )->name('operation.notes.save');
    Route::post(
        '/student/id/save',
        [WalkinController::class, 'updateStudentId']
    )->name('student.id.save');
    Route::get('/student/pdf/{id}', [WalkinController::class, 'studentPdf'])
        ->name('student.pdf');

    Route::get('/fund-release-status', [WalkinController::class, 'fundReleaseStatus'])
        ->name('fund.release.status');

    Route::get('/commission-enrollment-list', [WalkinController::class, 'commissionEnrollmentList'])
        ->name('commission.enrollment.list');

    Route::get('/commission-list', [WalkinController::class, 'commissionList'])
        ->name('commission.list');

    Route::get('/enrolled-list', [WalkinController::class, 'enrolledList'])
        ->name('enrolled.list');

    Route::get('/drop-list', [WalkinController::class, 'dropList'])
        ->name('drop.list');

    Route::get('/appointment-complete', [WalkinController::class, 'appointmentComplete'])
        ->name('appointment.complete');

    Route::get('/osap-done-enrolled', [WalkinController::class, 'osapDoneEnrolled'])
        ->name('osap.done.enrolled');
});
