<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ClassSubjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AssignClassTeacherController;
use App\Http\Controllers\ExaminationsController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\FeesCollectionController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientDependentController;
use App\Http\Controllers\ClientAssistanceLogController;
use App\Http\Controllers\ClientVerificationController;
use App\Http\Controllers\Admin\ArController;
use App\Http\Controllers\Staff\ARController  as StaffARController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Staff\ReportsController as StaffReportsController;
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;
use App\Http\Controllers\RandomForestController;
use App\Http\Controllers\ImportController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\ClientRequirementController;
use Carbon\Carbon;

use App\Http\Controllers\Admin\ReportsController as AdminReportsController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


//Route::get('/', function () {
//   return view('welcome');
//});

//Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');


Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'AuthLogin']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/forgot-password', [AuthController::class, 'forgotpassword']);
Route::post('/forgot-password', [AuthController::class, 'PostForgotpassword']);
Route::get('/reset/{token}', [AuthController::class, 'reset']);
Route::post('/reset/{token}', [AuthController::class, 'PostReset']);



Route::group(['middleware' => 'admin'], function () {

    Route::get('/admin/dashboard', [DashboardController::class, 'dashboard']);

    Route::get('/admin/admin/list', [AdminController::class, 'list']);
    Route::get('/admin/admin/add', [AdminController::class, 'add']);
    Route::post('/admin/admin/add', [AdminController::class, 'insert']);
    Route::get('/admin/admin/edit/{id}', [AdminController::class, 'edit']);
    Route::post('/admin/admin/edit/{id}', [AdminController::class, 'update']);
    Route::get('/admin/admin/delete/{id}', [AdminController::class, 'delete']);
    Route::get('/admin/clustering/run', [ReportsController::class, 'runClustering'])
        ->name('admin.clustering.run');
    // staff url

    Route::get('/admin/staff/list', [StaffController::class, 'list']);
    Route::get('/admin/staff/add', [StaffController::class, 'add']);
    Route::post('/admin/staff/add', [StaffController::class, 'insert']);
    Route::get('/admin/staff/edit/{id}', [StaffController::class, 'edit']);
    Route::post('/admin/staff/edit/{id}', [StaffController::class, 'update']);
    Route::get('/admin/staff/delete/{id}', [StaffController::class, 'delete']);
    Route::get('admin/staff/add', [StaffController::class, 'add']);
    Route::post('admin/staff/insert', [StaffController::class, 'insert']);


    // client url

    Route::get('/admin/client/show/{id}', [ClientController::class, 'show']);
    Route::get('/admin/client/list', [ClientController::class, 'list']);
    Route::get('/admin/client/add', [ClientController::class, 'add']);
    Route::post('/admin/client/add', [ClientController::class, 'insert']);
    Route::get('/admin/client/edit/{id}', [ClientController::class, 'edit']);
    Route::post('/admin/client/edit/{id}', [ClientController::class, 'update']);
    Route::get('/admin/client/delete/{id}', [ClientController::class, 'delete']);

    // client dependent url

    Route::get('admin/client_dependents/list', [ClientDependentController::class, 'index']);
    Route::get('/admin/client_dependents/list/{client_id}', [ClientDependentController::class, 'list']);
    Route::get('/admin/client_dependents/add/{client_id}', [ClientDependentController::class, 'add']);
    Route::post('/admin/client_dependents/add/{client_id}', [ClientDependentController::class, 'insert']);
    Route::get('/admin/client_dependents/edit/{id}', [ClientDependentController::class, 'edit']);
    Route::post('/admin/client_dependents/edit/{id}', [ClientDependentController::class, 'update']);
    Route::get('/admin/client_dependents/delete/{id}', [ClientDependentController::class, 'delete']);

    // client assistance log url

    Route::get('/admin/client_assistance_logs/add/{client_id}', [ClientAssistanceLogController::class, 'add']);
    Route::post('/admin/client_assistance_logs/add/{client_id}', [ClientAssistanceLogController::class, 'insert']);

    // client verification url

    Route::get('/admin/client_verification/view/{client_id}', [ClientVerificationController::class, 'view']);
    Route::get('/admin/client_verification/list', [ClientVerificationController::class, 'list']);
    Route::get('/admin/client_verification/list/{client_id}', [ClientVerificationController::class, 'list']);
    Route::get('/admin/client_verification/add/{client_id}', [ClientVerificationController::class, 'add']);
    Route::post('/admin/client_verification/add/{client_id}', [ClientVerificationController::class, 'insert']);
    Route::get('/admin/client_verification/edit/{id}', [ClientVerificationController::class, 'edit']);
    Route::post('/admin/client_verification/edit/{id}', [ClientVerificationController::class, 'update']);
    Route::get('/admin/client_verification/delete/{id}', [ClientVerificationController::class, 'delete']);

    // ar url

    Route::get('/admin/ar/list', [ArController::class, 'list']);
    
    Route::get('admin/ar/create', [ArController::class, 'create']);
    Route::get('admin/ar/viewing-list', [ArController::class, 'viewingList'])->middleware('admin');
    Route::get('admin/ar/view/{id}', [ArController::class, 'view'])->middleware('admin');
    Route::get('admin/ar/edit/{id}', [ArController::class, 'edit'])->middleware('admin');
    Route::post('admin/ar/update/{id}', [ArController::class, 'update'])->middleware('admin');
    Route::get('admin/ar/add', [ArController::class, 'create'])->middleware('admin');
    Route::post('admin/ar/store', [ArController::class, 'store'])->middleware('admin');
    Route::get('admin/ar/delete/{id}', [ArController::class, 'delete'])->middleware('admin');

    // ADMIN REPORT ROUTE

    Route::get('admin/reports', [ReportsController::class, 'index'])
        ->name('admin.reports')
        ->middleware('admin'); // if you protect admin routes

    // Admin - Reports CSV Export
    Route::get('/admin/reports/export', [ReportsController::class, 'exportCsv'])
        ->name('admin.reports.export');

    Route::get('admin/reports/cluster', [ReportsController::class, 'clusterAnalysis']);
    Route::get('/admin/cluster-analysis', [ReportsController::class, 'clusterAnalysis']);

    Route::get('/admin/reports/exportCluster', [ReportsController::class, 'exportCluster'])->name('admin.reports.exportCluster');

    Route::get('admin/dashboard/cash-pattern/{range}', [DashboardController::class, 'cashPattern']);

    // ADMIN RANDOM FOREST ROUTES
    Route::middleware(['admin'])->group(function () {
        Route::get('admin/classification', [RandomForestController::class, 'index'])->name('admin.classification');
        Route::get('admin/classification/run', [RandomForestController::class, 'runAnalysis'])->name('admin.classification.run');
    });

    Route::get('/admin/classification/export', [ReportsController::class, 'exportClassificationResults'])
        ->name('admin.classification.export');

    // ✅ CSV Import Routes for Acknowledgement Receipts
    Route::middleware(['admin'])->group(function () {
        Route::get('admin/receipts/import', [ImportController::class, 'showImportForm'])->name('admin.import.form');
        Route::post('admin/receipts/import', [ImportController::class, 'importCsv'])->name('admin.import.csv');
        Route::delete('/imported-data/delete', [ImportController::class, 'deleteImportedData'])
            ->name('imported.delete');
    });

    Route::get('/admin/update-ai', function () {

        $python = config('python.python_path');

        $kmeans = public_path('python/kmeans_cluster.py');
        $rf     = public_path('python/random_forest_classifier.py');

        // Escape paths
        $cmd1 = "\"$python\" \"$kmeans\"";
        $cmd2 = "\"$python\" \"$rf\"";

        // Run the python scripts and capture output
        $output1 = shell_exec($cmd1 . " 2>&1");
        $output2 = shell_exec($cmd2 . " 2>&1");

        // Log the output so we can debug
        Log::info("[AI UPDATE] KMEANS OUTPUT: " . $output1);
        Log::info("[AI UPDATE] RF OUTPUT: " . $output2);

        // Update timestamp
        DB::table('ai_updates')->updateOrInsert(
            ['id' => 1],
            ['updated_at' => \Carbon\Carbon::now('Asia/Manila')]
        );

        return redirect()->back()->with('success', 'AI analytics updated successfully!');
    })->name('admin.updateAI');

    Route::get('/test-shell', function () {
        return shell_exec("echo Hello");
    });


    // Admin - Client Requirements Routes
    Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
        Route::get('/client/{client}/requirements', [ClientRequirementController::class, 'index'])->name('client.requirements');
        Route::post('/client/{client}/requirements', [ClientRequirementController::class, 'update'])->name('client.requirements.update');
    });
    Route::get('/admin/client/missing-requirements', [ClientRequirementController::class, 'missingRequirements'])
        ->name('client.missingRequirements');


    // parent url

    Route::get('/admin/parent/list', [ParentController::class, 'list']);
    Route::get('/admin/parent/add', [ParentController::class, 'add']);
    Route::post('/admin/parent/add', [ParentController::class, 'insert']);
    Route::get('/admin/parent/edit/{id}', [ParentController::class, 'edit']);
    Route::post('/admin/parent/edit/{id}', [ParentController::class, 'update']);
    Route::get('/admin/parent/delete/{id}', [ParentController::class, 'delete']);
    Route::get('/admin/parent/my-student/{id}', [ParentController::class, 'myStudent']);
    Route::get('admin/parent/assign_student_parent/{student_id}/{parent_id}', [ParentController::class, 'AssignStudentParent']);
    Route::get('admin/parent/assign_student_parent_delete/{student_id}', [ParentController::class, 'AssignStudentParentDelete']);

    // class url

    Route::get('/admin/class/list', [ClassController::class, 'list']);
    Route::get('/admin/class/add', [ClassController::class, 'add']);
    Route::post('/admin/class/add', [ClassController::class, 'insert']);
    Route::get('/admin/class/edit/{id}', [ClassController::class, 'edit']);
    Route::post('/admin/class/edit/{id}', [ClassController::class, 'update']);
    Route::get('/admin/class/delete/{id}', [ClassController::class, 'delete']);

    // subject url

    Route::get('/admin/subject/list', [SubjectController::class, 'list']);
    Route::get('/admin/subject/add', [SubjectController::class, 'add']);
    Route::post('/admin/subject/add', [SubjectController::class, 'insert']);
    Route::get('/admin/subject/edit/{id}', [SubjectController::class, 'edit']);
    Route::post('/admin/subject/edit/{id}', [SubjectController::class, 'update']);
    Route::get('/admin/subject/delete/{id}', [SubjectController::class, 'delete']);

    // assign_subject url

    Route::get('/admin/assign_subject/list', [ClassSubjectController::class, 'list']);
    Route::get('/admin/assign_subject/add', [ClassSubjectController::class, 'add']);
    Route::post('/admin/assign_subject/add', [ClassSubjectController::class, 'insert']);
    Route::get('/admin/assign_subject/edit/{id}', [ClassSubjectController::class, 'edit']);
    Route::post('/admin/assign_subject/edit/{id}', [ClassSubjectController::class, 'update']);
    Route::get('/admin/assign_subject/delete/{id}', [ClassSubjectController::class, 'delete']);
    Route::get('/admin/assign_subject/edit_single/{id}', [ClassSubjectController::class, 'edit_single']);
    Route::post('/admin/assign_subject/edit_single/{id}', [ClassSubjectController::class, 'update_single']);

    // assign class teacher

    Route::get('/admin/assign_class_teacher/list', [AssignClassTeacherController::class, 'list'])->name('assign_class_teacher.list');
    Route::get('/admin/assign_class_teacher/add', [AssignClassTeacherController::class, 'add']);
    Route::post('/admin/assign_class_teacher/add', [AssignClassTeacherController::class, 'insert']);
    Route::get('/admin/assign_class_teacher/delete/{id}', [AssignClassTeacherController::class, 'delete']);

    // Examinations

    Route::get('/admin/examinations/exam/list', [ExaminationsController::class, 'exam_list']);
    Route::get('/admin/examinations/exam/add', [ExaminationsController::class, 'exam_add']);
    Route::post('/admin/examinations/exam/add', [ExaminationsController::class, 'exam_insert']);
    Route::get('/admin/examinations/exam/edit/{id}', [ExaminationsController::class, 'exam_edit']);
    Route::post('/admin/examinations/exam/edit/{id}', [ExaminationsController::class, 'exam_update']);
    Route::get('/admin/examinations/exam/delete/{id}', [ExaminationsController::class, 'exam_delete']);

    // Exam Schedule

    Route::get('/admin/examinations/exam_schedule', [ExaminationsController::class, 'exam_schedule']);
    Route::post('/admin/examinations/exam_schedule_insert', [ExaminationsController::class, 'exam_schedule_insert']);

    // attendance

    Route::get('/admin/attendance/student', [AttendanceController::class, 'AttendanceStudent']);
    Route::post('/admin/attendance/student/save', [AttendanceController::class, 'AttendanceStudentSubmit']);
    Route::get('/admin/attendance/report', [AttendanceController::class, 'AttendanceReport']);

    // fees collection

    Route::get('/admin/fees_collection/collect_fees', [FeesCollectionController::class, 'collect_fees']);
    Route::get('/admin/fees_collection/collect_fees/add_fees/{student_id}', [FeesCollectionController::class, 'collect_fees_add']);
    Route::post('/admin/fees_collection/collect_fees/add_fees/{student_id}', [FeesCollectionController::class, 'collect_fees_insert']);

    // admin edit account and information

    Route::get('/admin/account', [UserController::class, 'MyAccount']);
    Route::post('/admin/account', [UserController::class, 'UpdateMyAccountAdmin']);

    Route::get('/admin/setting', [UserController::class, 'Setting']);
    Route::post('/admin/setting', [UserController::class, 'UpdateSetting']);

    //change_password url

    Route::get('/admin/change_password', [UserController::class, 'change_password']);
    Route::post('/admin/change_password', [UserController::class, 'update_change_password']);
});


// STAFF CLIENT ROUTES


Route::middleware(['staff'])->group(function () {
    Route::get('/staff/dashboard', [StaffDashboardController::class, 'dashboard'])->name('staff.dashboard');
    Route::get('/staff/dashboard/cash-pattern/{range}', [\App\Http\Controllers\Staff\DashboardController::class, 'cashPattern']);

Route::group(['middleware' => 'staff'], function () {

    Route::get('/staff/dashboard', [DashboardController::class, 'dashboard']);


    Route::get('/staff/client/list', [App\Http\Controllers\Staff\ClientController::class, 'list']);
    Route::get('/staff/client/add', [App\Http\Controllers\Staff\ClientController::class, 'add']);
    Route::post('/staff/client/add', [App\Http\Controllers\Staff\ClientController::class, 'insert']);
    Route::get('/staff/client/edit/{id}', [App\Http\Controllers\Staff\ClientController::class, 'edit']);
    Route::post('/staff/client/edit/{id}', [App\Http\Controllers\Staff\ClientController::class, 'update']);
    Route::get('/staff/client/delete/{id}', [App\Http\Controllers\Staff\ClientController::class, 'delete']);
    Route::get('/staff/client/show/{id}', [App\Http\Controllers\Staff\ClientController::class, 'show']);

    // STAFF CLIENT DEPENDENT ROUTES

    Route::get('staff/client_dependents/list', [App\Http\Controllers\Staff\ClientDependentController::class, 'index']);
    Route::get('/staff/client_dependents/list/{client_id}', [App\Http\Controllers\Staff\ClientDependentController::class, 'list']);
    Route::get('/staff/client_dependents/add/{client_id}', [App\Http\Controllers\Staff\ClientDependentController::class, 'add']);
    Route::post('/staff/client_dependents/add/{client_id}', [App\Http\Controllers\Staff\ClientDependentController::class, 'insert']);
    Route::get('/staff/client_dependents/edit/{id}', [App\Http\Controllers\Staff\ClientDependentController::class, 'edit']);
    Route::post('/staff/client_dependents/edit/{id}', [App\Http\Controllers\Staff\ClientDependentController::class, 'update']);
    Route::get('/staff/client_dependents/delete/{id}', [App\Http\Controllers\Staff\ClientDependentController::class, 'delete']);

    // Staff: Beneficiaries (Client Verification)
    Route::get('/staff/client_verification/list/{client_id?}', [App\Http\Controllers\Staff\ClientVerificationController::class, 'list']);
    Route::get('/staff/client_verification/add/{client_id}', [App\Http\Controllers\Staff\ClientVerificationController::class, 'add']);
    Route::post('/staff/client_verification/add/{client_id}', [App\Http\Controllers\Staff\ClientVerificationController::class, 'insert']);
    Route::get('/staff/client_verification/edit/{id}', [App\Http\Controllers\Staff\ClientVerificationController::class, 'edit']);
    Route::post('/staff/client_verification/edit/{id}', [App\Http\Controllers\Staff\ClientVerificationController::class, 'update']);
    Route::get('/staff/client_verification/delete/{id}', [App\Http\Controllers\Staff\ClientVerificationController::class, 'delete']);

    Route::get('/staff/client_assistance_logs/add/{client_id}', [\App\Http\Controllers\Staff\ClientAssistanceLogsController::class, 'add']);
Route::post('/staff/client_assistance_logs/add/{client_id}', [\App\Http\Controllers\Staff\ClientAssistanceLogsController::class, 'insert']);


    Route::get('/staff/ar/list', [App\Http\Controllers\Staff\ARController::class, 'list']);


    // AR ROUTES - Cleaning up the double declaration
    Route::prefix('staff')->group(function () {
        // Use the name you defined in the import or the full path
        Route::get('ar/list', [App\Http\Controllers\Staff\ARController::class, 'list']);
        Route::get('ar/add', [App\Http\Controllers\Staff\ARController::class, 'create']);
        Route::post('ar/store', [App\Http\Controllers\Staff\ARController::class, 'store']);
        Route::get('ar/viewing-list', [App\Http\Controllers\Staff\StaffARController::class, 'viewingList']);
        Route::get('ar/view/{id}', [App\Http\Controllers\Staff\StaffARController::class, 'view']);
        Route::get('ar/edit/{id}', [App\Http\Controllers\Staff\StaffARController::class, 'edit']);
        Route::post('ar/update/{id}', [App\Http\Controllers\Staff\StaffARController::class, 'update']);
        Route::get('ar/delete/{id}', [App\Http\Controllers\Staff\StaffARController::class, 'delete']);
    });

    // STAFF REPORT ROUTES
    // STAFF REPORT ROUTES
    Route::get('staff/reports', [ReportsController::class, 'index'])->name('staff.reports');
    Route::get('staff/reports/cluster', [ReportsController::class, 'clusterAnalysis']);
    Route::get('staff/reports/export', [ReportsController::class, 'exportCsv'])->name('staff.reports.export');
    Route::get('staff/reports/exportCluster', [ReportsController::class, 'exportCluster'])->name('staff.reports.exportCluster');


    Route::get('staff/dashboard', [StaffDashboardController::class, 'dashboard'])
        ->name('staff.dashboard');
    Route::get('/staff/dashboard/cash-pattern/{range}', [\App\Http\Controllers\Staff\DashboardController::class, 'cashPattern'])
        ->name('staff.dashboard.cashPattern');
});

// staff account and information

Route::get('/staff/account', [UserController::class, 'MyAccount']);
Route::post('/staff/account', [UserController::class, 'UpdateMyAccount']);

Route::get('/staff/my_class_subject', [AssignClassTeacherController::class, 'MyClassSubject']);

Route::get('/staff/my_student', [StudentController::class, 'MyStudent']);

Route::get('/staff/my_exam_timetable', [ExaminationsController::class, 'MyExamTimetableTeacher']);

// attendance

Route::get('/staff/attendance/student', [AttendanceController::class, 'AttendanceStudentTeacher']);
Route::post('/staff/attendance/student/save', [AttendanceController::class, 'AttendanceStudentSubmit']);
Route::get('/staff/attendance/report', [AttendanceController::class, 'AttendanceReportTeacher']);

//change_password url

Route::get('/staff/change_password', [UserController::class, 'change_password']);
Route::post('/staff/change_password', [UserController::class, 'update_change_password']);



    Route::prefix('staff')->middleware(['staff'])->group(function () {
        Route::get('ar/list', [StaffARController::class, 'list']);
        Route::get('ar/add', [StaffARController::class, 'create']);
        Route::post('ar/store', [StaffARController::class, 'store']);
        Route::get('ar/viewing-list', [StaffARController::class, 'viewingList']);
        Route::get('ar/view/{id}', [StaffARController::class, 'view']);
        Route::get('ar/edit/{id}', [StaffARController::class, 'edit']);
        Route::post('ar/update/{id}', [StaffARController::class, 'update']);
        Route::get('ar/delete/{id}', [StaffARController::class, 'delete']);
    });

    // STAFF REPORT ROUTES
    Route::middleware(['staff'])->group(function () {
        Route::get('staff/reports', [StaffReportsController::class, 'index'])->name('staff.reports');
        Route::get('staff/reports/cluster', [StaffReportsController::class, 'clusterAnalysis']);
        Route::get('staff/reports/export', [StaffReportsController::class, 'exportCsv'])->name('staff.reports.export');
        Route::get('staff/reports/exportCluster', [StaffReportsController::class, 'exportCluster'])->name('staff.reports.exportCluster');
    });

    // STAFF DASHBOARD ROUTES
    Route::middleware(['staff'])->group(function () {
        Route::get('staff/dashboard', [StaffDashboardController::class, 'dashboard'])
            ->name('staff.dashboard');
    });

    // staff account and information

    Route::get('/staff/account', [UserController::class, 'MyAccount']);
    Route::post('/staff/account', [UserController::class, 'UpdateMyAccount']);

    Route::get('/staff/my_class_subject', [AssignClassTeacherController::class, 'MyClassSubject']);

    Route::get('/staff/my_student', [StudentController::class, 'MyStudent']);

    Route::get('/staff/my_exam_timetable', [ExaminationsController::class, 'MyExamTimetableTeacher']);

    // attendance

    Route::get('/staff/attendance/student', [AttendanceController::class, 'AttendanceStudentTeacher']);
    Route::post('/staff/attendance/student/save', [AttendanceController::class, 'AttendanceStudentSubmit']);
    Route::get('/staff/attendance/report', [AttendanceController::class, 'AttendanceReportTeacher']);

    //change_password url

});



Route::group(['middleware' => 'student'], function () {

    Route::get('/student/dashboard', [DashboardController::class, 'dashboard']);

    Route::get('/student/account', [UserController::class, 'MyAccount']);
    Route::post('/student/account', [UserController::class, 'UpdateMyAccountStudent']);

    Route::get('/student/my_subject', [SubjectController::class, 'MySubject']);

    Route::get('/student/my_exam_timetable', [ExaminationsController::class, 'MyExamTimetable']);

    Route::get('/student/fees_collection', [FeesCollectionController::class, 'CollectFeesStudent']);
    Route::post('/student/fees_collection', [FeesCollectionController::class, 'CollectFeesStudentPayment']);


    Route::get('/student/paypal/payment-error', [FeesCollectionController::class, 'PaymentError']);
    Route::get('/student/paypal/payment-success', [FeesCollectionController::class, 'PaymentSuccess']);

    //change_password url

    Route::get('/student/change_password', [UserController::class, 'change_password']);
    Route::post('/student/change_password', [UserController::class, 'update_change_password']);
});


Route::group(['middleware' => 'parent'], function () {

    Route::get('/parent/dashboard', [DashboardController::class, 'dashboard']);

    Route::get('/parent/account', [UserController::class, 'MyAccount']);
    Route::post('/parent/account', [UserController::class, 'UpdateMyAccountParent']);

    Route::get('/parent/my_student', [ParentController::class, 'MyStudentParent']);

    Route::get('parent/my_student/subject/{student_id}', [SubjectController::class, 'ParentStudentSubject']);

    Route::get('parent/my_student/fees_collection/{student_id}', [FeesCollectionController::class, 'CollectFeesStudentParent']);
    Route::post('parent/my_student/fees_collection/{student_id}', [FeesCollectionController::class, 'CollectFeesStudentPaymentParent']);

    //change_password url

    Route::get('/parent/change_password', [UserController::class, 'change_password']);
    Route::post('/parent/change_password', [UserController::class, 'update_change_password']);
});



