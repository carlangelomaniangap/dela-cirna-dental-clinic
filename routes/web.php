<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// super admin
use App\Http\Controllers\superadmin\SuperAdminDashboardController;


// admin
use App\Http\Controllers\admin\AdminDashboardController;
use App\Http\Controllers\admin\AdminTreatmentController;
use App\Http\Controllers\admin\AdminScheduleController;
use App\Http\Controllers\admin\AdminPatientListController;
use App\Http\Controllers\admin\AdminRecordController;
use App\Http\Controllers\admin\AdminMessagesController;
use App\Http\Controllers\admin\AdminPaymentInfoController;
use App\Http\Controllers\admin\AdminCalendarController;
use App\Http\Controllers\admin\AdminCommunityForumController;
use App\Http\Controllers\admin\AdminCommentController;

// patient
use App\Http\Controllers\patient\PatientDashboardController;
use App\Http\Controllers\patient\PatientAppointmentController;
use App\Http\Controllers\patient\PatientMessagesController;
use App\Http\Controllers\patient\PatientPaymentInfoController;
use App\Http\Controllers\patient\PatientCalendarController;
use App\Http\Controllers\patient\PatientCommunityForumController;
use App\Http\Controllers\patient\PatientCommentController;

// dentistrystudent
use App\Http\Controllers\dentistrystudent\DentistryStudentCommunityForumController;
use App\Http\Controllers\dentistrystudent\DentistryStudentCommentController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\PendingController;
use App\Http\Controllers\DentalClinicController;

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


// Create Multiple Clinic
Route::get('/dentalclinics', [DentalClinicController::class, 'create'])->name('dentalclinics.create');
Route::post('/dentalclinics/store', [DentalClinicController::class, 'store'])->name('dentalclinics.store');

Route::group(['middleware' => ['auth', 'checkUserType:superadmin']], function () {
    // dashboard
    Route::get('/superadmin', [SuperAdminDashboardController::class, 'index'])->name('superadmin.dashboard');
    Route::put('dentalclinics/{dentalClinic}/approve', [DentalClinicController::class, 'approve'])->name('dentalclinics.approve');
});

Route::group(['middleware' => ['auth', 'checkUserType:admin']], function () {
    // dashboard
    Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('/admin/inventory', AdminDashboardController::class);
    Route::resource('admin/treatments', AdminTreatmentController::class);
    Route::resource('admin/schedules', AdminScheduleController::class);
    
    // paitent list
    Route::get('/admin/patientlist',[AdminPatientListController::class,'index'])->name('admin.patientlist');
    Route::get('/admin/patientlist/add', [AdminPatientListController::class, 'createPatient'])->name('admin.patient.create');
    Route::post('/admin/patientlist/store', [AdminPatientListController::class, 'storePatient'])->name('admin.patient.store');
    Route::post('/admin/patientlist/{patientlistId}', [AdminPatientListController::class, 'addPatient'])->name('admin.addPatient');
    Route::get('/admin/patientlist/{patientlistId}/update', [AdminPatientListController::class, 'updatePatient'])->name('admin.updatePatient');
    Route::put('/admin/patientlist/{patientlistId}/updated', [AdminPatientListController::class, 'updatedPatient'])->name('admin.updatedPatient');
    Route::delete('/admin/patientlist/{patientlistId}/delete', [AdminPatientListController::class, 'deletePatient'])->name('admin.deletePatient');
    
    Route::get('/admin/patientlist/search', [AdminPatientlistController::class, 'search'])->name('admin.search');
    
    // record
    Route::get('/admin/patientlist/{patientlistId}/records', [AdminRecordController::class, 'showRecord'])->name('admin.showRecord');
    Route::get('/admin/patientlist/{patientlistId}/records/add', [AdminRecordController::class, 'createRecord'])->name('admin.record.create');
    Route::post('/admin/patientlist/{patientlistId}/records/store', [AdminRecordController::class, 'storeRecord'])->name('admin.record.store');
    
    Route::put('/admin/patientlist/{patientlistId}/records/{recordId}/updated', [AdminRecordController::class, 'updatedRecord'])->name('admin.record.update');
    Route::delete('/admin/patientlist/{patientlistId}/records/{recordId}/delete', [AdminRecordController::class, 'deleteRecord'])->name('admin.deleteRecord');
    Route::get('/admin/patientlist/{patientlistId}/records/{recordId}/download', [AdminRecordController::class, 'downloadRecord'])->name('admin.downloadRecord');
    Route::get('/admin/patientlist/{patientlistId}/records/{recordId}/count', [AdminRecordController::class, 'showRecords']);
    
    Route::get('/admin/patientlist/{patientlistId}/records/note/add', [AdminRecordController::class, 'createNote'])->name('admin.note.create');
    Route::post('/admin/patientlist/{patientlistId}/records/note/store', [AdminRecordController::class, 'storeNote'])->name('admin.note.store');
    Route::put('/admin/patientlist/{patientlistId}/records/note/{noteId}', [AdminRecordController::class, 'update'])->name('admin.note.update');

    // messages
    Route::get('/admin/messages',[AdminMessagesController::class,'index'])->name('admin.messages');
    Route::post('/admin/messages', [AdminMessagesController::class, 'storeMessage'])->name('admin.messages.store');
    Route::get('/admin/messages/search', [AdminMessagesController::class, 'search'])->name('admin.messages.search');
    
    // payment info
    Route::get('/admin/paymentinfo',[AdminPaymentInfoController::class,'index'])->name('admin.paymentinfo');
    Route::get('/admin/paymentinfo/add', [AdminPaymentInfoController::class, 'createPayment'])->name('admin.payment.create');
    Route::post('/admin/paymentinfo/store', [AdminPaymentInfoController::class, 'storePayment'])->name('admin.payment.store');
    Route::get('/admin/paymentinfo/update/{paymentId}', [AdminPaymentInfoController::class, 'updatePayment'])->name('admin.updatePayment');
    Route::put('/admin/paymentinfo/updated/{paymentId}', [AdminPaymentInfoController::class, 'updatedPayment'])->name('admin.updatedPayment');
    Route::delete('/admin/paymentinfo/delete/{paymentId}', [AdminPaymentInfoController::class, 'deletePayment'])->name('admin.deletePayment');
    Route::get('/admin/paymentinfo/search', [AdminPaymentInfoController::class, 'search'])->name('admin.paymentinfo.search');
    Route::post('/admin/paymentinfo/addpayment/{paymentId}', [AdminPaymentInfoController::class, 'addPayment'])->name('admin.addPayment');
    Route::get('/admin/paymentinfo/{paymentId}/history', [AdminPaymentInfoController::class, 'paymentHistory'])->name('admin.paymentHistory');
    // calendar
    Route::get('/admin/calendar',[AdminCalendarController::class,'index'])->name('admin.calendar');
    Route::post('/calendar/approve/{appointmentId}', [AdminCalendarController::class, 'approve'])->name('admin.approveCalendar');
    Route::get('/admin/calendar/appointment/{appointmentId}/update', [AdminCalendarController::class, 'updateCalendar'])->name('admin.updateCalendar');
    Route::put('/admin/calendar/appointment/{appointmentId}/updated', [AdminCalendarController::class, 'updatedCalendar'])->name('admin.updatedCalendar');
    Route::delete('/admin/calendar/appointment/{appointmentId}/delete', [AdminCalendarController::class, 'deleteCalendar'])->name('admin.deleteCalendar');
    Route::get('/admin/calendar/appointment/{appointmentId}/details', [AdminCalendarController::class, 'viewDetails'])->name('admin.viewDetails');
    // community forum
    Route::get('/admin/communityforum',[AdminCommunityForumController::class,'index'])->name('admin.communityforum');
    Route::get('/admin/communityforum/post', [AdminCommunityForumController::class, 'createCommunityforum'])->name('admin.communityforum.create');
    Route::post('/admin/communityforum/store', [AdminCommunityForumController::class, 'store'])->name('admin.communityforum.store');
    Route::get('/admin/communityforum/edit/{id}', [AdminCommunityForumController::class, 'editCommunityforum'])->name('admin.editCommunityforum');
    Route::put('/admin/communityforum/update/{id}', [AdminCommunityForumController::class, 'updateCommunityforum'])->name('admin.updatedCommunityforum');
    Route::delete('/admin/communityforum/delete/{id}', [AdminCommunityForumController::class, 'deleteCommunityforum'])->name('admin.deleteCommunityforum');
    Route::get('/communityforum', [AdminCommunityForumController::class, 'comment'])->name('admin.communityforum');
    
    Route::post('/communityforum/{communityforum}/comment', [AdminCommentController::class, 'addComment'])->name('admin.addComment');
    Route::put('/communityforum/comment/{comment}', [AdminCommentController::class, 'updateComment'])->name('admin.updatedComment');
    Route::delete('/communityforum/comment/{comment}', [AdminCommentController::class, 'deleteComment'])->name('admin.deleteComment');
    Route::get('/communityforum/comment/{comment}/edit', [AdminCommentController::class, 'editComment'])->name('admin.editComment');

    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Route::group(['middleware' => ['auth', 'checkUserType:patient']], function () {
    // dashboard
    Route::get('/patient', [PatientDashboardController::class, 'index'])->name('patient.dashboard');

    // appointments
    Route::get('/patient/appointment',[PatientAppointmentController::class,'index'])->name('patient.appointment');
    Route::get('/patient/appointment/add', [PatientCalendarController::class, 'createCalendar'])->name('patient.calendar.create');
    Route::post('/patient/appointment/store', [PatientCalendarController::class, 'storeCalendar'])->name('patient.calendar.store');

    // messages
    Route::get('/patient/messages',[PatientMessagesController::class,'index'])->name('patient.messages');
    Route::post('/patient/messages', [PatientMessagesController::class, 'storeMessage'])->name('patient.messages.store');
    Route::get('/patient/messages/search', [PatientMessagesController::class, 'search'])->name('patient.messages.search');
    // payment info
    Route::get('/patient/paymentinfo',[PatientPaymentInfoController::class,'index'])->name('patient.paymentinfo');
    Route::get('/patient/payment/search', [PatientPaymentInfoController::class, 'search'])->name('patient.paymentinfo.search');
    Route::get('/patient/paymentinfo/{paymentId}/history', [PatientPaymentInfoController::class, 'paymentHistory'])->name('patient.paymentHistory');
    // calendar
    Route::get('/patient/calendar',[PatientCalendarController::class,'index'])->name('patient.calendar');
    Route::get('/patient/calendar/appointment/{appointmentId}/update', [PatientCalendarController::class, 'updateCalendar'])->name('patient.updateCalendar');
    Route::put('/patient/calendar/appointment/{appointmentId}/updated', [PatientCalendarController::class, 'updatedCalendar'])->name('patient.updatedCalendar');
    Route::delete('/patient/calendar/appointment/{appointmentId}/delete', [PatientCalendarController::class, 'deleteCalendar'])->name('patient.deleteCalendar');
    Route::get('/patient/calendar/appointment/{appointmentId}/details', [PatientCalendarController::class, 'viewDetails'])->name('patient.viewDetails');
    // community forum
    Route::get('/patient/communityforum',[PatientCommunityForumController::class,'index'])->name('patient.communityforum');
    Route::get('/patient/communityforum/post', [PatientCommunityForumController::class, 'createCommunityforum'])->name('patient.communityforum.create');
    Route::post('/patient/communityforum/store', [PatientCommunityForumController::class, 'store'])->name('patient.communityforum.store');
    Route::get('/patient/communityforum/edit/{id}', [PatientCommunityForumController::class, 'editCommunityforum'])->name('patient.editCommunityforum');
    Route::put('/patient/communityforum/update/{id}', [PatientCommunityForumController::class, 'updateCommunityforum'])->name('patient.updatedCommunityforum');
    Route::delete('/patient/communityforum/delete/{id}', [PatientCommunityForumController::class, 'deleteCommunityforum'])->name('patient.deleteCommunityforum');
    Route::get('/communityforum', [PatientCommunityForumController::class, 'comment'])->name('patient.communityforum');
    
    Route::post('/patient/communityforum/{communityforum}/comment', [PatientCommentController::class, 'addComment'])->name('patient.addComment');
    Route::put('/patient/communityforum/comment/{comment}', [PatientCommentController::class, 'updateComment'])->name('patient.updatedComment');
    Route::delete('/patient/communityforum/comment/{comment}', [PatientCommentController::class, 'deleteComment'])->name('patient.deleteComment');
    Route::get('/patient/communityforum/comment/{comment}/edit', [PatientCommentController::class, 'editComment'])->name('patient.editComment');

    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Route::group(['middleware' => ['auth', 'checkUserType:dentistrystudent']], function () {
    // community forum
    Route::get('/dentistrystudent/communityforum',[DentistryStudentCommunityForumController::class,'index'])->name('dentistrystudent.communityforum');
    Route::get('/dentistrystudent/communityforum/post', [DentistryStudentCommunityForumController::class, 'createCommunityforum'])->name('dentistrystudent.communityforum.create');
    Route::post('/dentistrystudent/communityforum/store', [DentistryStudentCommunityForumController::class, 'store'])->name('dentistrystudent.communityforum.store');
    Route::get('/dentistrystudent/communityforum/edit/{id}', [DentistryStudentCommunityForumController::class, 'editCommunityforum'])->name('dentistrystudent.editCommunityforum');
    Route::put('/dentistrystudent/communityforum/update/{id}', [DentistryStudentCommunityForumController::class, 'updateCommunityforum'])->name('dentistrystudent.updatedCommunityforum');
    Route::delete('/dentistrystudent/communityforum/delete/{id}', [DentistryStudentCommunityForumController::class, 'deleteCommunityforum'])->name('dentistrystudent.deleteCommunityforum');
    Route::get('/communityforum', [DentistryStudentCommunityForumController::class, 'comment'])->name('dentistrystudent.communityforum');
    
    Route::post('/dentistrystudent/communityforum/{communityforum}/comment', [DentistryStudentCommentController::class, 'addComment'])->name('dentistrystudent.addComment');
    Route::put('/dentistrystudent/communityforum/comment/{comment}', [DentistryStudentCommentController::class, 'updateComment'])->name('dentistrystudent.updatedComment');
    Route::delete('/dentistrystudent/communityforum/comment/{comment}', [DentistryStudentCommentController::class, 'deleteComment'])->name('dentistrystudent.deleteComment');
    Route::get('/dentistrystudent/communityforum/comment/{comment}/edit', [DentistryStudentCommentController::class, 'editComment'])->name('dentistrystudent.editComment');


    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::get('/pending', [PendingController::class, 'index'])->name('pending');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
