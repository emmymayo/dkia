<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\StudentSectionSessionController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ExamRecordController;
use App\Http\Controllers\ExamRegistrationController;
use App\Http\Controllers\ExamReportCheckerController;
use App\Http\Controllers\ExamReportEntryController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ExamRegistrationApiController;
use App\Http\Controllers\ExamReportEntryApiController;
use App\Http\Controllers\SectionApiController;
use App\Http\Controllers\StudentApiController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CbtAnswerController;
use App\Http\Controllers\CbtController;
use App\Http\Controllers\CbtQuestionController;
use App\Http\Controllers\CbtResultController;
use App\Http\Controllers\CbtSectionController;
use App\Http\Controllers\CheckTransactionController;
use App\Http\Controllers\EClassController;
use App\Http\Controllers\ExamBroadsheetController;
use App\Http\Controllers\GradeSystemController;
use App\Http\Controllers\MarkController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PinController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StudentCbtController;
use App\Http\Controllers\StudentCbtResultController;
use App\Http\Controllers\StudentEClassesController;
use App\Http\Controllers\StudentSubjectController;
use App\Http\Controllers\TeacherSectionController;
use App\Http\Controllers\TeacherSectionSubjectController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\TimetableRecordController;
use App\Http\Controllers\TimetableTimeslotController;
use App\Http\Controllers\TimetableViewController;
use App\Http\Controllers\StudentSectionCSVImportController;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

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
    return view('login');
})->name('home');

//Authentication Routes
Route::get('/csrf-token/json',function(){
    request()->session()->regenerateToken();
    return response()->json();
})->middleware('auth');
Route::get('/login', function (){
    return view('login',[
                'schools' => Config::get('settings.schools'), 
                ]);
})->middleware('guest')->name('login');

Route::get('/configs', function(){
    return Config::get(request('config_key'));
})->middleware('auth');

Route::post('/login',[LoginController::class,'login']);
Route::any('/logout',[LoginController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('/dashboard',[UserDashboardController::class,'toUserDashboard'])->middleware('auth')->name('dashboard');


Route::get('/profile',ProfileController::class)->middleware('auth');

//Admin Routes
Route::resource('admins', AdminController::class)->middleware('auth');

//Teacher Routes
Route::resource('teachers', TeacherController::class)->middleware('auth');
Route::get('/teachers/get/all', [TeacherController::class,'getTeachers'])->middleware('auth');

//Teacher Assignment
Route::get('/teachers/assign/index',[TeacherController::class,'assignTeacher'])->middleware(['auth','can:admin-only']);

//Teacher Sections Routes
Route::get('/teachers/{teacher_id}/sections',[TeacherSectionController::class,'getTeacherSections'])->middleware('auth');
Route::post('/teachers/{teacher_id}/sections/toggle',[TeacherSectionController::class,'toggleTeacherSection'])->middleware('auth');

//Teacher Sections Subjects Routes
Route::get('/teachers/{teacher_id}/sections/{section_id}',[TeacherSectionSubjectController::class,'getTeacherSectionSubjects'])->middleware('auth');
Route::post('/teachers/{teacher_id}/sections/{section_id}/toggle',[TeacherSectionSubjectController::class,'toggleTeacherSectionSubject'])->middleware('auth');

//Student  Routes
Route::resource('students', StudentController::class)->middleware('auth');
Route::post('/students/{student}/set-class',[StudentController::class,'setClass'])->middleware('auth');
Route::get('/students/exams/{exam_id}/sections/{section_id}',[StudentController::class,'getExamSectionStudents'])->middleware('auth');
Route::get('/students/section/{section_id}',[StudentApiController::class,'sectionIndex'])->middleware('auth');
Route::get('/students/{student}/find',[StudentApiController::class,'show'])->middleware('auth');

//Student Subjects Routes
Route::get('/students/subjects/registered',[StudentSubjectController::class,'studentRegisteredSubjects'])->middleware(['auth','can:student-only']);
Route::get('/students/subjects/register',[StudentSubjectController::class,'studentRegistration'])->middleware(['auth','exam.registration.open','can:student-only']);
Route::get('/students/{student_id}/subjects/registered/json',[StudentSubjectController::class,'registeredSubjectsJson'])->middleware('auth');

//Student E classes Routes
Route::get('/students/me/e-classes/',[StudentEClassesController::class,'index'])->middleware('auth');

//User Routes
Route::post('/users/{user}/upload-photo',[UserController::class,'uploadPhoto'])->middleware('auth');
Route::get('/users/{user}/reset-password',[UserController::class,'resetPassword'])->middleware('auth');
Route::get('/users/{user}/toggle-status',[UserController::class,'toggleStatus'])->middleware('auth');
Route::patch('/users/{user}/change-password',[UserController::class,'changePassword'])->middleware('auth');

//Classes Routes
Route::get('/classes',[ClassesController::class,'index'])->middleware('auth');
Route::post('/classes',[ClassesController::class,'store'])->middleware('auth');
Route::get('/classes/{classes}/edit',[ClassesController::class,'edit'])->middleware('auth');
Route::patch('/classes/{classes}',[ClassesController::class,'update'])->middleware('auth');
Route::delete('/classes/{classes}',[ClassesController::class,'destroy'])->middleware('auth');
Route::get('/classes/all',[ClassesController::class,'getClasses'])->middleware('auth'); 



//Sections Routes
Route::resource('sections', SectionController::class)->middleware('auth');
Route::get('/sections/classes/{classes_id}',[SectionApiController::class,'classSections'])->middleware('auth');
Route::get('/sections/classes/{classes_id}/user',[SectionApiController::class,'mySections'])->middleware('auth');
Route::get('/sections/get/{section}',[SectionApiController::class,'show'])->middleware('auth');
Route::get('/sections/user',[SectionApiController::class,'userSection'])->middleware('auth');
Route::get('/sections/{section}/import-students',[StudentSectionCSVImportController::class,'index'])->middleware('auth');
Route::post('/sections/{section}/import-students',[StudentSectionCSVImportController::class,'import'])->middleware('auth');


//Student Sections  Routes (Promotion)
Route::resource('studentsectionsessions', StudentSectionSessionController::class)->middleware('auth');

//Exams routes
Route::resource('exams', ExamController::class)->middleware('auth');
Route::get('/exams/{exam}/publish', [ExamController::class,'publish'])->middleware('auth');
Route::get('/exams/find/all', [ExamController::class,'getExams'])->middleware('auth');


//Exam Registration
Route::get('/exams-registration', [ExamRegistrationController::class,'index'])->middleware(['auth','exam.registration.open','can:admin-and-teacher-only']);
Route::get('/exams-registration/register/{student_id}/{section_id}', [ExamRegistrationController::class,'register'])->middleware('auth');
Route::post('/exams-registration',[ExamRegistrationController::class,'store'])->middleware(['auth','exam.registration.open']);
Route::get('/exams-registration/subjects',[ExamRegistrationApiController::class,'SubjectIndex'])->middleware('auth');
Route::get('/exams-registration/active-exam',[ExamRegistrationApiController::class,'activeExam'])->middleware('auth');
Route::get('/exams-registration/student/{student_id}/section/{section_id}/registered',
        [ExamRegistrationApiController::class,'studentRegisteredSubjects'])->middleware('auth');


//Exam report Entry
Route::get('/exams-entry', [ExamReportEntryController::class,'index'])->middleware(['auth','can:admin-and-teacher-only']);
Route::get('/exams-entry/view', [ExamReportEntryController::class,'viewEntries'])->middleware(['auth','can:admin-and-teacher-only']);
Route::post('/exams-entry/{mark_id}/update', [ExamReportEntryController::class,'update'])->middleware('auth');
//exam report entry 
Route::get('/exams-entry/section/{section_id}/subject/{subject_id}', 
        [ExamReportEntryApiController::class,'sectionSubjectEntries'])->middleware('auth');
Route::get('/exams-entry/subjects', [ExamReportEntryApiController::class,'subjectIndex'])->middleware('auth');

//Exam Beahavioural analysis Entry
Route::get('/exams-record', [ExamRecordController::class,'index'])->middleware(['auth','can:admin-and-teacher-only']);
Route::get('/exams-record/{student_id}/{section_id}', [ExamRecordController::class,'getExamRecord'])->middleware('auth');
Route::post('/exams-record/{student_id}/{section_id}/update', [ExamRecordController::class,'update'])->middleware('auth');

//Exam Report Checker
Route::get('/exams/report/checker',[ExamReportCheckerController::class,'index'])->middleware(['auth','can:admin-only']);
Route::get('/exams/report/checker/student',[ExamReportCheckerController::class,'Studentindex'])->middleware(['auth','can:student-only']);
Route::post('/exams/report',[ExamReportCheckerController::class,'check'])->middleware('auth');
//Route::post('/exams/report/{exam_id}/{student_id}',[ExamReportCheckerController::class,'check'])->middleware('auth');

//MArks Routes
// get marks by applying filters (student_id,section_id etc) and ordering direction
Route::get('/marks/get',[MarkController::class,'getMarks'])->middleware('auth');

//Broadsheet
Route::get('/exams/students/broadsheet',[ExamBroadsheetController::class,'index'])->middleware(['auth','can:admin-and-teacher-only']);

//Subjects  Routes
Route::resource('subjects', SubjectController::class)->middleware('auth');
Route::get('/subjects/get/all', [SubjectController::class,'getSubjects'])->middleware('auth');
Route::get('/subjects/get/user/{section_id}', [SubjectController::class,'mySubjects'])->middleware('auth');
Route::get('/subjects/exams/{exam_id}/sections/{section_id}', [SubjectController::class,'getExamSectionSubjects'])->middleware('auth');

//Attendance Routes
Route::get('/attendances/roll/call',[AttendanceController::class,'rollCallIndex'])->middleware(['auth','can:admin-and-teacher-only']);
Route::get('/attendances/roll/view',[AttendanceController::class,'rollViewIndex'])->middleware(['auth','can:admin-and-teacher-only']);
Route::get('/attendances/student/view',[AttendanceController::class,'studentViewIndex'])->middleware(['auth','can:student-only']);
Route::get('/attendances/student/{student_id}/events',[AttendanceController::class,'studentEvents'])->middleware('auth');
Route::post('/attendances/student/{student_id}/{section_id}',[AttendanceController::class,'getStudentRoll'])->middleware('auth');
Route::post('/attendances/student/{student_id}/{section_id}/update',[AttendanceController::class,'updateStudentRoll'])->middleware('auth');

//Sessions Routes

//Settings
Route::get('/settings',[SettingController::class,'index'])->middleware('auth');
Route::get('/settings/all',[SettingController::class,'getSettings'])->middleware('auth');
Route::get('/settings/sessions/all',[SettingController::class,'getSessions'])->middleware('auth');
Route::post('/settings/update',[SettingController::class,'updateSetting'])->middleware('auth');
Route::get('/settings/school/logo',[SettingController::class,'schoolLogoIndex'])->middleware('auth');
Route::post('/settings/school/logo',[SettingController::class,'uploadSchoolLogo'])->middleware('auth');
Route::get('/settings/keys/{unique_key}',[SettingController::class,'getSetting'])->middleware('auth');

//Pin Routes
Route::get('/pins/exam/{exam_id}',[PinController::class,'getExamPins'])->middleware(['auth','exam.locked']);
Route::get('/pins/{pin}/by',[PinController::class,'usedBy'])->middleware(['auth','exam.locked']);
Route::get('/pins/generate',[PinController::class,'generateIndex'])->middleware(['auth','exam.locked']);
Route::get('/pins/manage',[PinController::class,'manage'])->middleware(['auth','exam.locked']);
Route::post('/pins/generate',[PinController::class,'generatePin'])->middleware(['auth','exam.locked']);
Route::post('/pins/revoke/{pin}',[PinController::class,'revokePin'])->middleware(['auth','exam.locked']);
Route::post('/pins/reset/{pin}',[PinController::class,'resetPin'])->middleware(['auth','exam.locked']);
Route::post('/pins/remove/{pin}',[PinController::class,'removePin'])->middleware(['auth','exam.locked']);

//Promotions routes

Route::get('/promotions',[PromotionController::class,'index'])->middleware(['auth','can:admin-and-teacher-only']);
Route::post('/promotions',[PromotionController::class,'promoteStudent'])->middleware('auth');

//Timetable routes 
Route::get('/timetables',[TimetableController::class,'index'])->middleware('auth');
Route::get('/timetables/{timetable}',[TimetableController::class,'show'])->middleware('auth');
Route::post('/timetables',[TimetableController::class,'store'])->middleware('auth');
Route::put('/timetables/{timetable}',[TimetableController::class,'update'])->middleware('auth');
Route::delete('/timetables/{timetable}',[TimetableController::class,'destroy'])->middleware('auth');

//Timeslot routes
Route::get('/timetable-timeslots',[TimetableTimeslotController::class,'index'])->middleware('auth');
Route::get('/timetable-timeslots/{id}',[TimetableTimeslotController::class,'show'])->middleware('auth');
Route::get('/timetable-timeslots/timetables/{timetable_id}',[TimetableTimeslotController::class,'getTimeslotsByTimetable'])->middleware('auth');
Route::post('/timetable-timeslots',[TimetableTimeslotController::class,'store'])->middleware('auth');
Route::put('/timetable-timeslots/{id}',[TimetableTimeslotController::class,'update'])->middleware('auth');
Route::delete('/timetable-timeslots/{id}',[TimetableTimeslotController::class,'destroy'])->middleware('auth');

//Timetable record routes
Route::get('/timetable-records',[TimetableRecordController::class,'index'])->middleware('auth');
Route::get('/timetable-records/{id}',[TimetableRecordController::class,'show'])->middleware('auth');
Route::post('/timetable-records',[TimetableRecordController::class,'store'])->middleware('auth');
Route::put('/timetable-records/{id}',[TimetableRecordController::class,'update'])->middleware('auth');
Route::delete('/timetable-records/{id}',[TimetableRecordController::class,'destroy'])->middleware('auth');

//Timetable Viewer
Route::get('/timetable-viewer',[TimetableViewController::class,'index'])->middleware('auth');

//Grade Systems Routes
Route::get('/gradesystems',[GradeSystemController::class,'index'])->middleware('auth');
Route::get('/gradesystems/{id}',[GradeSystemController::class,'show'])->middleware('auth');
Route::post('/gradesystems',[GradeSystemController::class,'store'])->middleware('auth');
Route::put('/gradesystems/{id}',[GradeSystemController::class,'update'])->middleware('auth');
Route::delete('/gradesystems/{id}',[GradeSystemController::class,'destroy'])->middleware('auth');

//Notices

Route::get('/notices',[NoticeController::class,'index'])->middleware('auth');
Route::get('/notices/list',[NoticeController::class,'list'])->middleware('auth');
Route::get('/notices/{id}',[NoticeController::class,'show'])->middleware('auth');
Route::post('/notices',[NoticeController::class,'store'])->middleware('auth');
Route::put('/notices/{id}',[NoticeController::class,'update'])->middleware('auth');
Route::delete('/notices/{id}',[NoticeController::class,'destroy'])->middleware('auth');

//E Class

Route::get('/e-classes',[EClassController::class,'index'])->middleware('auth');
Route::get('/e-classes/{id}/retrieve',[EClassController::class,'retrieve'])->middleware('auth');
Route::get('/e-classes/{id}',[EClassController::class,'show'])->middleware('auth');
Route::post('/e-classes',[EClassController::class,'store'])->middleware('auth');
Route::put('/e-classes/{id}',[EClassController::class,'update'])->middleware('auth');
Route::delete('/e-classes/{id}',[EClassController::class,'destroy'])->middleware('auth');

//Roles

Route::get('/roles',[RoleController::class,'index'])->middleware('auth');

//CBT Routes
Route::get('/cbts',[CbtController::class, 'index'])->middleware('auth');
Route::get('/cbts/{id}',[CbtController::class, 'show'])->middleware('auth');
Route::post('/cbts',[CbtController::class, 'store'])->middleware('auth');
Route::put('/cbts/{id}',[CbtController::class, 'update'])->middleware('auth');
Route::put('/cbts/{id}/reset',[CbtController::class, 'reset'])->middleware('auth');
Route::delete('/cbts/{id}',[CbtController::class, 'destroy'])->middleware('auth');

//CBT questions routes
Route::get('cbt-questions',[CbtQuestionController::class,'index'])->middleware('auth');
Route::get('/cbt-questions/{id}',[CbtQuestionController::class,'show'])->middleware('auth');
Route::post('/cbt-questions',[CbtQuestionController::class,'store'])->middleware('auth');
Route::put('/cbt-questions/{id}',[CbtQuestionController::class,'update'])->middleware('auth');
Route::delete('/cbt-questions/{id}',[CbtQuestionController::class,'destroy'])->middleware('auth');
Route::patch('/cbt-questions/{id}/image',[CbtQuestionController::class,'uploadImage'])->middleware('auth');

//CBT answers routes
Route::get('cbt-answers',[CbtAnswerController::class,'index'])->middleware('auth');
Route::get('/cbt-answers/{id}',[CbtAnswerController::class,'show'])->middleware('auth');
Route::post('/cbt-answers',[CbtAnswerController::class,'store'])->middleware('auth');
Route::put('/cbt-answers/{id}',[CbtAnswerController::class,'update'])->middleware('auth');
Route::delete('/cbt-answers/{id}',[CbtAnswerController::class,'destroy'])->middleware('auth');


//CBT result routes
Route::get('/cbt-results',[CbtResultController::class,'index'])->middleware('auth');
Route::get('/cbt-results/{id}',[CbtResultController::class,'show'])->middleware('auth');
Route::post('/cbt-results',[CbtResultController::class,'store'])->middleware('auth');
Route::put('/cbt-results/{id}',[CbtResultController::class,'update'])->middleware('auth');
Route::delete('/cbt-results/{id}',[CbtResultController::class,'destroy'])->middleware('auth');
Route::get('/cbt-results/cbts/sections',[CbtResultController::class,'getCbtSectionStudent'])->middleware('auth');

//CBT Sections
Route::get('/cbt-sections',[CbtSectionController::class,'index'])->middleware('auth');
Route::put('/cbt-sections/toggle',[CbtSectionController::class,'toggle'])->middleware('auth');

// Student CBT 
Route::get('/student-cbts',[StudentCbtController::class, 'index'])->middleware('auth');

// Student cbt result
Route::get('/student-cbt-results',[StudentCbtResultController::class,'index'])->middleware('auth');
Route::get('/student-cbt-results/calculate',[StudentCbtResultController::class,'calculateResult'])->middleware('auth');
Route::patch('/student-cbt-results',[StudentCbtResultController::class,'update'])->middleware('auth');

//Payment Route
Route::get('/payment/create', [PaymentController::class, 'createTransaction'])->middleware('auth')->name('create-payment');
Route::post('/payment', [PaymentController::class, 'startTransaction'])->name('save_payment');
Route::get('/payment/status', [App\Http\Controllers\PaymentController::class, 'handleGatewayCallback'])->middleware('auth')->name('initiate-payment');
Route::get('/payment/cancel', [PaymentController::class, 'cancelTransaction'])->middleware('auth')->name('cancel-payment');

//Check payment
Route::get('/payments-history', [CheckTransactionController::class, 'myPayment'])->middleware('auth');
Route::post('/payment-invoice/{id}', [CheckTransactionController::class, 'show_receipt'])->middleware('auth')->name('get-receipt');
Route::get('/check-payments', [CheckTransactionController::class, 'check_payment'])->middleware('auth')->name('check-payment');

//Artisan

Route::get('/commands/artisan/{command}', function($command){
    if($command=='db:seed' AND config('app.env') != 'production'){
        Artisan::call($command);
        return Artisan::output();
    }
    //only supper admins can make commands besides db:seed which will only work when not in production
    Gate::authorize('super-only');

    Artisan::call($command);
    return Artisan::output();
})->middleware();

//Student Section import
Route::get('/import', [StudentSectionCSVImportController::class, 'index']);
Route::post('/import', [StudentSectionCSVImportController::class, 'import']);
