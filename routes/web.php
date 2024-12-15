<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// admin
use App\Http\Controllers\admin\AdminDashboardController;
use App\Http\Controllers\admin\AdminInventoryController;
use App\Http\Controllers\admin\AdminPatientListController;
use App\Http\Controllers\admin\AdminRecordController;
use App\Http\Controllers\admin\AdminMessagesController;
use App\Http\Controllers\admin\AdminPaymentInfoController;
use App\Http\Controllers\admin\AdminCalendarController;
use App\Http\Controllers\admin\AdminReportsController;

// patient
use App\Http\Controllers\patient\PatientDashboardController;
use App\Http\Controllers\patient\PatientRecordController;
use App\Http\Controllers\patient\PatientAppointmentController;
use App\Http\Controllers\patient\PatientMessagesController;
use App\Http\Controllers\patient\PatientPaymentInfoController;
use App\Http\Controllers\patient\PatientCalendarController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\NotificationController;

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

    // inventory
    Route::get('/admin/inventory', [AdminInventoryController::class, 'index'])->name('admin.inventory');
    Route::post('/admin/inventory', [AdminInventoryController::class, 'store'])->name('admin.inventory.store');
    Route::put('/admin/inventory/{id}/update', [AdminInventoryController::class, 'update'])->name('admin.inventory.update');
    Route::put('/admin/inventory/{id}/add-stock', [AdminInventoryController::class, 'AddStock'])->name('admin.inventory.AddStock');
    Route::get('/admin/inventory/{id}/add-stock/history', [AdminInventoryController::class, 'addstock_history'])->name('admin.addstock_history');
    Route::put('/admin/inventory/{id}/issuance', [AdminInventoryController::class, 'issuance'])->name('admin.inventory.issuance');
    Route::get('/admin/inventory/{id}/issuance/history', [AdminInventoryController::class, 'issuance_history'])->name('admin.issuance_history');
    Route::put('/admin/inventory/{id}/dispose', [AdminInventoryController::class, 'dispose'])->name('admin.inventory.dispose');
    Route::get('/admin/inventory/{id}/dispose/history', [AdminInventoryController::class, 'dispose_history'])->name('admin.dispose_history');
    Route::get('/admin/inventory/print', [AdminInventoryController::class, 'print'])->name('admin.inventory.print');

    // paitent list
    Route::get('/admin/patientlist',[AdminPatientListController::class,'index'])->name('admin.patientlist');
    Route::get('/admin/patientlist/add', [AdminPatientListController::class, 'createPatient'])->name('admin.patient.create');
    Route::post('/admin/patientlist/store', [AdminPatientListController::class, 'storePatient'])->name('admin.patient.store');
    Route::post('/admin/patientlist/{patientlistId}', [AdminPatientListController::class, 'addPatient'])->name('admin.addPatient');
    Route::get('/admin/patientlist/{patientlistId}/update', [AdminPatientListController::class, 'updatePatient'])->name('admin.updatePatient');
    Route::put('/admin/patientlist/{patientlistId}/updated', [AdminPatientListController::class, 'updatedPatient'])->name('admin.updatedPatient');
    Route::delete('/admin/patientlist/{patientlistId}/delete', [AdminPatientListController::class, 'deletePatient'])->name('admin.deletePatient');
    
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
    Route::post('/admin/notifications/{id}/mark-as-read', [AdminMessagesController::class, 'markNotificationAsRead'])->name('admin.notifications.markAsRead');
    Route::get('admin/messages/{user_id}', [AdminMessagesController::class, 'index'])->name('admin.messages.messages');
    
    // payment info
    Route::get('/admin/paymentinfo',[AdminPaymentInfoController::class,'index'])->name('admin.paymentinfo');
    Route::get('/admin/paymentinfo/add', [AdminPaymentInfoController::class, 'createPayment'])->name('admin.payment.create');
    Route::post('/admin/paymentinfo/store', [AdminPaymentInfoController::class, 'storePayment'])->name('admin.payment.store');
    Route::get('/admin/paymentinfo/update/{paymentId}', [AdminPaymentInfoController::class, 'updatePayment'])->name('admin.updatePayment');
    Route::put('/admin/paymentinfo/updated/{paymentId}', [AdminPaymentInfoController::class, 'updatedPayment'])->name('admin.updatedPayment');
    Route::delete('/admin/paymentinfo/delete/{paymentId}', [AdminPaymentInfoController::class, 'deletePayment'])->name('admin.deletePayment');
    Route::post('/admin/paymentinfo/addpayment/{paymentId}', [AdminPaymentInfoController::class, 'addPayment'])->name('admin.addPayment');
    Route::get('/admin/paymentinfo/{paymentId}/history', [AdminPaymentInfoController::class, 'paymentHistory'])->name('admin.paymentHistory');
    
    // calendar
    Route::get('/admin/calendar',[AdminCalendarController::class,'index'])->name('admin.calendar');
    Route::post('/admin/calendar/approve/{calendarId}/{status}', [AdminCalendarController::class, 'approve'])->name('admin.approveCalendar');
    Route::get('/admin/calendar/appointment/{calendarId}/update', [AdminCalendarController::class, 'updateCalendar'])->name('admin.updateCalendar');
    Route::put('/admin/calendar/appointment/{calendarId}/updated', [AdminCalendarController::class, 'updatedCalendar'])->name('admin.updatedCalendar');
    Route::get('/admin/calendar/appointment/{calendarId}/details', [AdminCalendarController::class, 'viewDetails'])->name('admin.viewDetails');
    Route::post('/admin/procedure/{calendarId}', [AdminCalendarController::class, 'procedure'])->name('admin.procedure');

    // reports
    Route::get('/admin/reports/', [AdminReportsController::class, 'index'])->name('admin.reports');
    Route::get('/admin/print', [AdminReportsController::class, 'print'])->name('admin.reports');
});

Route::group(['middleware' => ['auth', 'checkUserType:patient']], function () {
    // dashboard
    Route::get('/patient', [PatientDashboardController::class, 'index'])->name('patient.dashboard');

    Route::get('/patient/records', [PatientRecordController::class, 'showRecord'])->name('patient.showRecord');
    Route::get('/patient/records/{recordId}/download', [PatientRecordController::class, 'downloadRecord'])->name('patient.downloadRecord');

    // appointments
    Route::get('/patient/appointment',[PatientAppointmentController::class,'index'])->name('patient.appointment');
    Route::get('/patient/appointment/add', [PatientCalendarController::class, 'createCalendar'])->name('patient.calendar.create');
    Route::post('/patient/appointment/store', [PatientCalendarController::class, 'storeCalendar'])->name('patient.calendar.store');
    Route::get('/patient/getBookedTimes', [PatientCalendarController::class, 'getBookedTimes']);
    
    // messages
    Route::get('/patient/messages',[PatientMessagesController::class,'index'])->name('patient.messages');
    Route::post('/patient/messages', [PatientMessagesController::class, 'storeMessage'])->name('patient.messages.store');
    Route::get('/patient/messages/search', [PatientMessagesController::class, 'search'])->name('patient.messages.search');
    Route::post('/patient/notifications/{id}/mark-as-read', [PatientMessagesController::class, 'markNotificationAsRead'])->name('patient.notifications.markAsRead');
    Route::get('/patient/messages/{sender_id}', [PatientMessagesController::class, 'index'])->name('patient.messages.messages');

    // payment info
    Route::get('/patient/paymentinfo',[PatientPaymentInfoController::class,'index'])->name('patient.paymentinfo');
    Route::get('/patient/paymentinfo/{paymentId}/history', [PatientPaymentInfoController::class, 'paymentHistory'])->name('patient.paymentHistory');
    
    // calendar
    Route::get('/patient/calendar',[PatientCalendarController::class,'index'])->name('patient.calendar');
    Route::get('/patient/calendar/appointment/{calendarId}/details', [PatientCalendarController::class, 'viewDetails'])->name('patient.viewDetails');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/notifications/{notification}', [NotificationController::class, 'markAsRead'])->name('markAsRead');

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