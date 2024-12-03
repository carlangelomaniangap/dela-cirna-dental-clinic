<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// admin
use App\Http\Controllers\admin\AdminDashboardController;
use App\Http\Controllers\admin\AdminTreatmentController;
use App\Http\Controllers\admin\AdminScheduleController;
use App\Http\Controllers\admin\AdminInventoryController;
use App\Http\Controllers\admin\AdminPatientListController;
use App\Http\Controllers\admin\AdminRecordController;
use App\Http\Controllers\admin\AdminMessagesController;
use App\Http\Controllers\admin\AdminPaymentInfoController;
use App\Http\Controllers\admin\AdminCalendarController;
use App\Http\Controllers\admin\AdminNotificationController;
// patient
use App\Http\Controllers\patient\PatientDashboardController;
use App\Http\Controllers\patient\PatientAppointmentController;
use App\Http\Controllers\patient\PatientMessagesController;
use App\Http\Controllers\patient\PatientPaymentInfoController;
use App\Http\Controllers\patient\PatientCalendarController;
use App\Http\Controllers\patient\PatientNotificationController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Auth\GoogleController;

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

Route::group(['middleware' => ['auth', 'checkUserType:admin']], function () {
    // dashboard
    Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('/admin/treatments', AdminTreatmentController::class);
    Route::resource('/admin/schedules', AdminScheduleController::class);

    // inventory
    Route::get('/admin/inventory', [AdminInventoryController::class, 'index'])->name('admin.inventory');
    Route::post('/admin/inventory', [AdminInventoryController::class, 'store'])->name('admin.inventory.store');
    Route::get('/admin/inventory/{inventory}', [AdminInventoryController::class, 'show'])->name('admin.inventory.show');
    Route::put('/admin/inventory/{inventory}', [AdminInventoryController::class, 'update'])->name('admin.inventory.update');
    Route::delete('/admin/inventory/{inventory}', [AdminInventoryController::class, 'destroy'])->name('admin.inventory.destroy');
    
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
    Route::post('/admin/calendar/approve/{appointmentId}/{status}', [AdminCalendarController::class, 'approve'])->name('admin.approveCalendar');
    Route::get('/admin/calendar/appointment/{appointmentId}/update', [AdminCalendarController::class, 'updateCalendar'])->name('admin.updateCalendar');
    Route::put('/admin/calendar/appointment/{appointmentId}/updated', [AdminCalendarController::class, 'updatedCalendar'])->name('admin.updatedCalendar');
    Route::get('/admin/calendar/appointment/{appointmentId}/details', [AdminCalendarController::class, 'viewDetails'])->name('admin.viewDetails');
    
    // notification
    Route::get('admin/notifications', [AdminNotificationController::class, 'index'])->name('admin.notifications');
    Route::get('admin/notifications/{notification}', [AdminNotificationController::class, 'markAsRead'])->name('admin.markAsRead');
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
    Route::get('/patient/calendar/appointment/{appointmentId}/details', [PatientCalendarController::class, 'viewDetails'])->name('patient.viewDetails');

    // notification
    Route::get('patient/notifications', [PatientNotificationController::class, 'index'])->name('patient.notifications');
    Route::get('patient/notifications/{notification}', [PatientNotificationController::class, 'markAsRead'])->name('patient.markAsRead');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/auth/google/redirect', [GoogleController::class, 'redirect'])->name('auth.google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('auth.google.callback');


require __DIR__.'/auth.php';