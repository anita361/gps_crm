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
use App\Http\Controllers\CounselorDashboardController;



Route::get('/', [LoginController::class, 'index']);
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware('login')->group(function () {


    Route::get('/branch-dashboard', [BranchManagerController::class, 'branchDashboard'])->name('branch.dashboard');

    Route::get('/branch/reports', [BranchManagerController::class, 'branchReports'])->name('branch.reports');

    Route::post('/branch/reports/data', [BranchManagerController::class, 'branchReportsData'])->name('branch.reports.data');

    Route::get('/branch/reception-dashboard-reports', [BranchManagerController::class, 'receptionDashboardReports'])->name('branch.reception.dashboard.reports');
    Route::get('/branch/reception-dashboard-reports/export', [BranchManagerController::class, 'receptionDashboardReportExport'])->name('branch.reception.dashboard.reports.export');



    Route::get('/branch-manager-dashboard', [BranchManagerController::class, 'branchManagerDashboard'])->name('branch.manager.dashboard');




    Route::post('/branch-summary', [BranchManagerController::class, 'branchSummary'])
        ->name('branch.summary');


    Route::post('/branch-dashboard/assign-counselor', [BranchManagerController::class, 'assignCounselor'])
        ->name('branch.manager.assign');



    Route::get('/counselor-dashboard', [CounselorDashboardController::class, 'index'])->name('counselor.dashboard');
    Route::get('/counselor-dashboard-report', [CounselorDashboardController::class, 'counslrdashboardReport'])->name('counselor.dashboard.report');
    Route::get('/counselor-dashboard-report/download', [CounselorDashboardController::class, 'downloadOprList'])->name('counselor.dashboard.report.download');
    Route::get('/counselor/full-report', [CounselorDashboardController::class, 'fullReport'])->name('counselor.full.report');
    Route::get('/counselor/full-report/excel', [CounselorDashboardController::class, 'counselorExcelReport'])->name('counselor.full.report.excel');

    Route::post('/counselor/drop-details', [CounselorDashboardController::class, 'dropDetails'])->name('counselor.drop.details');


    Route::post('/counselor/call-logs', [CounselorDashboardController::class, 'counselorcallLogs'])->name('counselor.call.logs');


    Route::post('/counselor/notes/get', [CounselorDashboardController::class, 'counselorgetNotes'])->name('counselor.notes.get');


    Route::post('/counselor/notes/add', [CounselorDashboardController::class, 'counseloraddNote'])->name('counselor.notes.add');
    Route::get('/counselor/email-templates', [CounselorDashboardController::class, 'emailTemplates'])->name('counselor.email.templates');

    Route::get('/counselor/email-template/create', [CounselorDashboardController::class, 'createEmailTemplate'])->name('counselor.email.template.create');


    Route::post('/counselor/email-template/store', [CounselorDashboardController::class, 'storeEmailTemplate'])->name('counselor.email.template.store');





    Route::get('/eligible-details', [CounselorDashboardController::class, 'eligibleDetails'])->name('eligible.details');
    Route::get('/aus-eligible-details', [CounselorDashboardController::class, 'ausEligibleDetails'])->name('aus.eligible.details');




    Route::get('/admin-branch-report', [BranchManagerController::class, 'adminBranchReport'])
        ->name('admin.branch.report');

    Route::post('/admin-branch-report/data', [BranchManagerController::class, 'adminBranchReportData'])
        ->name('admin.branch.report.data');


    Route::post('/admin-branch-report/details', [BranchManagerController::class, 'adminBranchReportDetails'])
        ->name('admin.branch.report.details');

    Route::post('/admin-branch-report/users', [BranchManagerController::class, 'adminBranchReportUserData'])
        ->name('admin.branch.report.users');


    Route::post('/admin/branch-report/export', [BranchManagerController::class, 'exportBranchReport'])->name('admin.branch.report.export');

    Route::get('/admin.walkn.report', [BranchManagerController::class, 'adminwalknReport'])
        ->name('admin.walkn.report');

    Route::post('/admin.walkn.report.details', [BranchManagerController::class, 'adminWalknDetails'])
        ->name('admin.walkn.report.details');

    Route::post('/admin/walkn-report/export', [BranchManagerController::class, 'adminwalknReportExport'])
        ->name('admin.walkn.report.export');

    Route::post('/get-logs', [BranchManagerController::class, 'getLogs'])
        ->name('get-logs');

    Route::post('/fetch-city', [BranchManagerController::class, 'fetchCity'])
        ->name('fetch-city');

    Route::post('/fetch-all-city', [BranchManagerController::class, 'fetchAllCity'])
        ->name('fetch-all-city');



    Route::get('/admin-counsellor-report', [BranchManagerController::class, 'adminCounsellorReport'])
        ->name('admin.counsellor.report');

    Route::post('/admin-counsellor-report/branch', [BranchManagerController::class, 'adminCounsellorReportData'])
        ->name('admin.counsellor.report.branch');

    Route::post('/admin-counsellor-report/users', [BranchManagerController::class, 'adminCounsellorReportUserData'])
        ->name('admin.counsellor.report.users');

    Route::post('/admin-counsellor-report/logs', [BranchManagerController::class, 'adminCounsellorReportLogs'])
        ->name('admin.counsellor.report.logs');

    Route::post('/admin-counsellor-report/all-city', [BranchManagerController::class, 'adminCounsellorReportAllCity'])
        ->name('admin.counsellor.report.all-city');

    Route::post('/admin/counsellor-report/export', [BranchManagerController::class, 'exportCounsellorReport'])
        ->name('admin.counsellor.report.export');

    Route::view('/cc-agent-report', 'callcenter.cc_agent_report')->name('callcenter.admin.dashboard');

    Route::view('/fi-dashboard', 'status.fi_dashboard')->name('status.fi');

    Route::view('/tt-dashboard', 'status.tt_dashboard')->name('status.tt');

    Route::view('/status-dashboard', 'status.dashboard')->name('status.dashboard');

    Route::view('/cmsn', 'cmsn.index')->name('cmsn.dashboard');

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

    Route::get('/finance-appointment-pending', [FinanceAppointmentController::class, 'financeAppointmentPending'])->name('finance.appointment.pending');

    Route::get('/finance/colleges', [FinanceAppointmentController::class, 'getColleges'])->name('finance.colleges');
    Route::get('/finance/campuses', [FinanceAppointmentController::class, 'campuses'])->name('finance.campuses');
    Route::get('/finance/programs', [FinanceAppointmentController::class, 'programs'])->name('finance.programs');
    Route::get('/finance/sub-status', [FinanceAppointmentController::class, 'getSubStatus'])->name('finance.sub.status');
    // Route::get('/finance/osap-status', [FinanceAppointmentController::class, 'getOsapStatus'])->name('finance.osap.status');
    // Route::post('/finance/osap-status', [FinanceAppointmentController::class, 'saveOsapStatus'])->name('finance.osap.status');
    Route::get(
        '/finance/sub-statuses',
        [FinanceAppointmentController::class, 'financeSubStatuses']
    )->name('finance.sub-statuses');




    Route::get('/finance-dashboard-report', [FinanceDashboardController::class, 'index'])->name('finance.dashboard.report');

    Route::get('/finance-dashboard-report/export', [FinanceExportController::class, 'export'])->name('finance.dashboard.report.export');





    Route::view('/commission-enrolled-list', 'commission.list')->name('commission.dashboard');

    Route::get('/lead/create', [LeadController::class, 'create'])->name('lead.create');

    Route::post('/lead/store', [LeadController::class, 'store'])->name('lead.store');

    Route::post('/lead/check-phone', [LeadController::class, 'checkPhone'])->name('lead.check.phone');

    Route::get('/lead/{mobile}', [LeadController::class, 'show'])->name('lead.show');


    Route::get('/walking-details/{smobile}', [WalkinController::class, 'show'])->name('walking-details');

    Route::post('/walkin/personal', [WalkinController::class, 'updatePersonal'])->name('walkin.personal');

    Route::post('/walkin/mobile/update', [WalkinController::class, 'updateMobile'])->name('walkin.mobile.update');

    Route::get('/walking/mobile-logs/{smobile}', [WalkinController::class, 'mobileLogs'])->name('walking.mobile.logs');

    Route::post('/student/update-email', [WalkinController::class, 'updateEmail'])->name('student.update.email');


    Route::get('/walking/email-logs/{email}', [WalkinController::class, 'emailLogs'])->name('walking.email.logs');

    Route::post('/student/spouse/save', [WalkinController::class, 'updateSpouse'])->name('student.spouse.save');

    Route::post('/dependant/update', [WalkinController::class, 'updateDependant'])->name('dependant.update');

    Route::post('/emergency/update', [WalkinController::class, 'updateEmergency'])->name('emergency.update');

    Route::post('/documents/update', [WalkinController::class, 'updateDocuments'])->name('documents.update');

    Route::post('/status/update', [WalkinController::class, 'updateStatus'])->name('status.update');
    Route::post('/enrollment/send-mail', [WalkinController::class, 'sendEnrollmentMail'])
        ->name('enrollment.sendMail');

    Route::post('/notes/update', [WalkinController::class, 'updateNotes'])->name('notes.update');

    Route::post('/update-operation-status', [WalkinController::class, 'updateOperationStatus'])->name('update-operation-status');

    Route::post('/add-notes', [WalkinController::class, 'addNotes'])->name('add-notes');

    Route::post('/operation-logs', [WalkinController::class, 'operationLogs'])->name('operation-logs');

    Route::post('/fund-status-logs', [WalkinController::class, 'fundStatusLogs'])->name('fund-status-logs');


    Route::post('/message/send', [WalkinController::class, 'sendMessage'])->name('message.send');

    Route::post('/get-template', [WalkinController::class, 'getTemplate'])->name('get.template');
    Route::post('/get-notes', [NotesController::class, 'getNotes'])->name('notes.get');

    Route::post('/add-note', [NotesController::class, 'addNote'])->name('notes.add');



    Route::get('/assign/counselors', [AssignController::class, 'counselors'])->name('assign.counselors');

    Route::post('/assign', [AssignController::class, 'assign'])->name('assign.store');


    Route::post('/status/logs', [StatusController::class, 'logs'])->name('status.logs');

    Route::post('/status/fund-logs', [StatusController::class, 'fundStatus'])->name('status.fund.logs');



    Route::post('/branch-manager/logs', [BranchManagerController::class, 'getLogs'])->name('branch.manager.logs');

    Route::get('/user-details', [WalkinController::class, 'userDetails'])->name('users.index');

    Route::get('/add-new-user', [WalkinController::class, 'createUser'])
        ->name('users.create');

    Route::post('/add-new-user', [WalkinController::class, 'storeUser'])
        ->name('users.store');

    Route::post('/update-user-status', [WalkinController::class, 'updateUserStatus'])
        ->name('users.status');

    Route::post('/check-username', [WalkinController::class, 'checkUsername'])
        ->name('users.checkUsername');


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
    )->name('lead.followup.notes.save');
    Route::get('/lead-followup/missed', [LeadFollowupController::class, 'missed'])
        ->name('lead.followup.missed');

    Route::get('/upload-csv', [CsvUploadController::class, 'showForm'])->name('csv.form');
    Route::post('/upload-csv', [CsvUploadController::class, 'upload'])->name('csv.upload');

    Route::get('/lead-list', [CsvUploadController::class, 'leadList'])->name('lead.list');
    Route::get('/seminar-lead-list', [CsvUploadController::class, 'seminarList'])->name('seminar.list');
    Route::get('/seminar-lead-download', [CsvUploadController::class, 'seminarDownload'])
        ->name('seminar.download');
    Route::post('/lead-assign', [CsvUploadController::class, 'assignLead'])
        ->name('lead.assign');



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

    Route::get('/reports/daily-sales/excel', [WalkinController::class, 'dailySalesExcel'])
        ->name('reports.daily-sales.excel');




    Route::get('/feedback-details', [WalkinController::class, 'feedbackDetails'])
        ->name('reports.feedback');
    Route::post('/feedback-details/view', [WalkinController::class, 'viewFeedback'])
        ->name('feedback.view');



    Route::get('/operation-status', [WalkinController::class, 'operationStatus'])
        ->name('operation.status');
    Route::get('/operation-export', [WalkinController::class, 'operationExport'])
        ->name('operationexport');


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
        ->whereNumber('id')
        ->name('student.pdf');
    Route::get('/get-campus', [WalkinController::class, 'getCampus'])->name('get.campus');

    Route::get('/get-program', [WalkinController::class, 'getProgram'])->name('get.program');
    Route::get('/fund-release-status', [WalkinController::class, 'fundReleaseStatus'])
        ->name('fund.release.status');

    Route::post(
        '/operation/student-id/update',
        [WalkinController::class, 'updateStudentId']
    )->name('operation.student-id.update');
    Route::post('/get-colleges', [WalkinController::class, 'getColleges'])->name('get.colleges');

    Route::get('/fund-release-export', [WalkinController::class, 'fundReleaseExport'])
        ->name('fund.release.export');

    Route::get('/commission-enrollment-list', [WalkinController::class, 'commissionEnrollmentList'])
        ->name('commission.enrollment.list');


    Route::post('/save-commission-status', [WalkinController::class, 'saveCommissionStatus'])
        ->name('save.commission.status');

    Route::post('/assign-operation', [WalkinController::class, 'assignOperation'])
        ->name('assign.operation');

    Route::get('/commission-list', [WalkinController::class, 'commissionList'])
        ->name('commission.list');
    Route::post('/tuition-fee-update', [WalkinController::class, 'updateTuitionFee'])
        ->name('tuition.fee.update.save');
    Route::get('/tuition-fee-update', [WalkinController::class, 'tuitionFeeUpdate'])
        ->name('tuition.fee.update');

    Route::get('/download-commission-excel', [WalkinController::class, 'downloadCommissionExcel'])
        ->name('download.commission.excel');


    Route::get('/enrolled-list', [WalkinController::class, 'enrolledList'])->name('enrolled.list');
    Route::get('/drop-list', [WalkinController::class, 'dropList'])->name('drop.list');

    //      Route::get('/finance-appointment-pending', [WalkinController::class, 'financeAppointmentPending'])->name('finance.appointment.pending');



    //      Route::get('/finance/colleges',
    //     [WalkinController::class, 'financeColleges']
    // )->name('finance.colleges');


    // Route::get('/finance/campuses',
    //     [WalkinController::class, 'financeCampuses']
    // )->name('finance.campuses');


    // Route::get('/finance/programs',
    //     [WalkinController::class, 'financePrograms']
    // )->name('finance.programs');


    // Route::post('/finance/osap-status',
    //     [WalkinController::class, 'financeOsapStatus']
    // )->name('finance.osap.status');

    Route::post('/drop/update-status', [WalkinController::class, 'updateDropStatus'])
        ->name('drop.update-status');
    Route::post('/fund-status-logs', [WalkinController::class, 'getsmaintatusLogs'])
        ->name('fund.status.logs');

    Route::post('/drop/logs', [WalkinController::class, 'dropLogs'])
        ->name('drop.logs');

    Route::post('/drop/aol-logs', [WalkinController::class, 'dropAolLogs'])
        ->name('drop.aol-logs');

    Route::post('/drop/notes', [WalkinController::class, 'dropNotes'])
        ->name('drop.notes');

    Route::post('/drop/add-note', [WalkinController::class, 'addDropNote'])
        ->name('drop.add-note');
    Route::post('/drop/excel', [WalkinController::class, 'dropExcel'])
        ->name('drop.excel');

    Route::get('/appointment-complete', [WalkinController::class, 'appointmentComplete'])
        ->name('appointment.complete');
    Route::post(
        '/appointment-complete/foa-status',
        [WalkinController::class, 'updateFoaStatus']
    )->name('appointment.complete.foa-status');


    Route::get(
        '/appointment-complete/export',
        [WalkinController::class, 'appointmentCompleteExport']
    )->name('appointment.complete.export');

    Route::get('/student-consent-pdf', [WalkinController::class, 'studentConsentPdf'])->name('student.consent.pdf');

    Route::get('/student/consent/pdf/{uid}', [WalkinController::class, 'studentOsapConsentPdf'])
        ->name('student.consent.pdf');

    Route::post(
        '/appointment/complete/finance-status-logs',
        [WalkinController::class, 'financeStatusLogs']
    )->name('appointment.complete.finance-status-logs');

    Route::post(
        '/appointment/complete/finance-sub-status',
        [WalkinController::class, 'financeSubStatus']
    )->name('appointment.complete.finance-sub-status');

    Route::post(
        '/appointment/complete/finance-status-update',
        [WalkinController::class, 'updateFinanceStatus']
    )->name('appointment.complete.finance-status-update');

    Route::get('/osap-done-enrolled', [WalkinController::class, 'osapDoneEnrolled'])
        ->name('osap.done.enrolled');

    Route::post(
        '/osap/campuses',
        [WalkinController::class, 'getOsapCampuses']
    )->name('osap.campuses');


    Route::post(
        '/osap/programs',
        [WalkinController::class, 'getOsapPrograms']
    )->name('osap.programs');


    Route::post(
        '/osap/foa-status',
        [WalkinController::class, 'updateFoaStatus']
    )->name('osap.foa.status');


    Route::post(
        '/osap/send-email',
        [WalkinController::class, 'sendOsapEmail']
    )->name('osap.send.email');


    Route::post(
        '/osap/logs',
        [WalkinController::class, 'getOsapLogs']
    )->name('osap.logs');


    Route::post(
        '/osap/status',
        [WalkinController::class, 'updateOsapStatus']
    )->name('osap.status.update');


    Route::post(
        '/osap/sub-status',
        [WalkinController::class, 'getOsapSubStatus']
    )->name('osap.sub.status');

    Route::get('/osap/consent-form', [WalkinController::class, 'consentForm'])
        ->name('osap.consent.form');



    Route::get('/dashboard-reports', [WalkinController::class, 'dashboardReports'])
        ->name('dashboard.reports');
    Route::get('/dashboard-reports/excel', [WalkinController::class, 'dashboardReportsExcel'])
        ->name('dashboard.reports.excel');


    Route::get('/lead-date-dashboard', [WalkinController::class, 'leadDashboardReport'])
        ->name('lead.date.dashboard');

    Route::get('/lead-date-dashboard/download', [WalkinController::class, 'leadDashboardDownloadcsv'])
        ->name('lead.date.csv');


    Route::get(
        '/daily-activity-reports',
        [WalkinController::class, 'dailyActivityReports']
    )->name('daily.activity.reports');

    Route::get(
        '/daily-activity-reports/download',
        [WalkinController::class, 'dailyActivityReportDownload']
    )->name('daily.activity.report.download');

    Route::get('/stitching-reports', [WalkinController::class, 'stitchingReports'])
        ->name('stitching.reports');



    Route::get(
        '/all-lead-list',
        [WalkinController::class, 'allLeadList']
    )->name('all.lead.list');




    Route::post(
        '/all-lead/add-note',
        [WalkinController::class, 'addallNote']
    )->name('all.lead.add.note');


    Route::post(
        '/all-lead/get-notes',
        [WalkinController::class, 'getallNotes']
    )->name('all.lead.get.notes');

    Route::post(
        '/all-lead/get-call-logs',
        [WalkinController::class, 'getallCallLogs']
    )->name('all.lead.get.call.logs');




    Route::post(
        '/all-lead/assign-operation',
        [WalkinController::class, 'assignallOperation']
    )->name('all.lead.assign.operation');




    Route::post(
        '/all-lead/get-colleges',
        [WalkinController::class, 'getallColleges']
    )->name('all.lead.get.colleges');



    Route::post(
        '/all-lead/get-campuses',
        [WalkinController::class, 'getallCampuses']
    )->name('all.lead.get.campuses');




    Route::post(
        '/all-lead/get-programs',
        [WalkinController::class, 'getallPrograms']
    )->name('all.lead.get.programs');



    Route::post(
        '/all-lead/drop-three',
        [WalkinController::class, 'dropThree']
    )->name('all.lead.drop.three');


    Route::post(
        '/all-lead/drop-three-head',
        [WalkinController::class, 'dropThreeHead']
    )->name('all.lead.drop.three.head');


    Route::post(
        '/all-lead/lead-report-drop',
        [WalkinController::class, 'leadReportDrop']
    )->name('all.lead.report.drop');


    Route::post(
        '/all-lead/daily-lead-report-drop',
        [WalkinController::class, 'dailyLeadReportDrop']
    )->name('all.lead.daily.drop');


    Route::get('/all-lead/download', [WalkinController::class, 'downloadAllLeadsExcel'])
        ->name('all.lead.download');


    Route::post('/get-finance-user', [WalkinController::class, 'getFinanceUser'])
        ->name('get.finance.user');
});
Route::post('/enrolled/send-mail', [WalkinController::class, 'sendMail'])
    ->name('enrolled.sendMail');

Route::get('/student-consent', [WalkinController::class, 'studentConsent'])
    ->name('student-consent');


Route::post('/student-consent/signature', [WalkinController::class, 'saveStudentSignature'])
    ->name('student-consent.signature');

Route::get('/student-consent/success/{id}', [WalkinController::class, 'studentConsentSuccess'])
    ->name('student-consent.success');
