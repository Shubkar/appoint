<?php

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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExpenseController;

Route::get('/', 'HomeController@login');

Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
Auth::routes(['register' => false,'reset' => false]);

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', 'AppointmentController@index')->name('home');
Route::get('/Users/getUsersList','UserController@index');
Route::get('/Users/editUser/{userId}','UserController@editUser');
Route::post('/saveUser','UserController@saveUser');
Route::post('/deleteUser','UserController@deleteUser');
Route::get('/getAllUsers/{status?}','UserController@getAllUsers');
Route::post('/checkPassword','UserController@checkPassword');
Route::get('/getDoctors','UserController@getDoctors');

Route::get('/templates/MyTemplates','MsgTemplatesController@index');
Route::post('/saveTemplates','MsgTemplatesController@store');
Route::post('/saveMasterData','MasterController@store');
Route::post('/saveSettings','AppSettingsController@store');

Route::get('/customers/getCustomersList','CustomerController@index')->name('customerList');
Route::get('/customers/editCustomer/{customerId}','CustomerController@editCustomer');
Route::post('/saveCustomer','CustomerController@saveCustomer');
Route::post('/deleteCustomer','CustomerController@deleteCustomer');
Route::get('/getAllCustomers/{userId}/{status?}','CustomerController@getAllCustomers');
Route::get('/loadCustomers/{userId}', 'CustomerController@loadCustomerData');
Route::get('/customers/importCsv','CustomerController@importCSV')->name('importCSV');
Route::post('/customers/postCSV','CustomerController@postCSV');
Route::post('/updateCustomer','CustomerController@updateCustomer');
Route::get('/directory/{caseId}','CustomerController@directory');
Route::post('/uploadpatientfile','CustomerController@uploadpatientfile');
Route::post('/uploadpatientfile_2','CustomerController@uploadpatientfile_2');
Route::post('/fetch_all_files','CustomerController@fetch_all_files');
Route::post('/deletpateintFile','CustomerController@deletpateintFile');
Route::get('/archive','CustomerController@archive');
Route::get('/fetch_all_archive_files','CustomerController@fetch_all_archive_files');
Route::post('/restorepateintFile','CustomerController@restorepateintFile');
Route::get('/photo/{caseId}','CustomerController@photo');
Route::post('/webcam_capture','CustomerController@webcam_capture')->name('webcam_capture');
Route::post('/UploadProfilePic','CustomerController@UploadProfilePic')->name('UploadProfilePic');
Route::get('/PatientHistory/{caseId}','CustomerController@PatientHistory');

Route::get('/appointments/manageAppointment','AppointmentController@index');
Route::get('/letters/myAppointments','AppointmentController@getMyAppointments');
Route::post('/appointments/newAppointment', 'AppointmentController@newAppointment');
Route::post('/appointments/QuickAppointment','AppointmentController@QuickAppointment');
Route::post('/appointments/BookPastAppointment','AppointmentController@BookPastAppointment');

Route::post('/appointments/getFromServer', 'AppointmentController@getFromServer');
Route::get('/getAppointments/{userId}/{customerId}/{fromDate?}/{toDate?}','AppointmentController@getAppointments');
Route::get('/appointments/editAppointment/{appointmentID}','AppointmentController@edit');
Route::post('/appointments/rescheduleAppointment','AppointmentController@reschedule');
Route::get('/appointments/deleteAppointment/{appointmentID}','AppointmentController@deleteAppointment');
Route::get('/appointments/markAttended/{appointmentID}','AppointmentController@attendAppointment');
Route::get('/appointments/folloup/{appointmentID}','AppointmentController@followup');
Route::post('/appointments/setupFolloup','AppointmentController@Setfollowup');
Route::post('/appointments/sendMessage','MessageController@selectTemplate');
Route::post('/appointments/addToQueue','MessageController@addQueue');

Route::get('/getAllAppointments/{userId}','MyEventsController@getAllAppointments');
Route::get('/editAppointment/{appointmentId}','MyEventsController@editAppointment');
Route::get('/appointments/changeAppointmentType/{appointmentId}','MyEventsController@changeAppointmentType');
Route::post('/letters/saveAppointments','MyEventsController@saveAppointments');
Route::get('/letters/generateLetters/{appointmentId}','MyEventsController@generateLetters');

Route::get('/getAllTreatement/{appointmentId}','TreatementController@getAllTreatement');
Route::post('/saveTreatement','TreatementController@saveTreatement');
Route::post('/deleteTreatement','TreatementController@deleteTreatement');

Route::post('/api/sycnAppData','AndroidApiController@syncContactsAndGetTemplates');
Route::post('/api/checkLogin','AndroidApiController@checkUser');
Route::post('/api/saveEvents','AndroidApiController@saveEvents');
Route::post('/api/getAppointment','AndroidApiController@getAppointment');
Route::post('/api/getQueue','AndroidApiController@getQueue');
Route::post('/api/processQueue','AndroidApiController@processQueue');
Route::post('/api/getTemplates','AndroidApiController@getTemplates');

Route::get('/reports/SummarySheetclear','ReportsController@summarySheetClear');
Route::get('/reports/SummarySheet','ReportsController@summarySheet');
Route::get('/reports/generateSummarysheet/{dtFrom}/{dtTo}/{userId}/{courier?}/{paid?}/{customerId?}/{followup?}/{isonline?}/{forFeeReport?}','ReportsController@generateSummarysheet');
Route::get('/reports/getOpeningClosingBalance/{dtFrom}/{dtTo}/{userId}/{patientId}','ReportsController@getOpeningClosingBalance');
Route::post('/updateOpeningBalance','ReportsController@updateOpeningBalance');
Route::get('/reports/sendInvoice/{appointmentId}','ReportsController@sendInvoice');
Route::get('/reports/feeStatus/{dtFrom}/{dtTo}/{userId}/{courier?}/{paid?}/{customerId?}/{followup?}/{isonline?}','ReportsController@getFeeStatus');

Route::get('/dbmanage/createBackup','BackupRestoreController@createBackup');

Route::post('/appointments/saveLettersData','LettersController@saveLettersData');
Route::get('/invoiceView','PublicViewController@viewInvoice');

Route::post('file-upload/upload', 'ReportsController@upload')->name('upload');
Route::get('/patientReports/getPatientReports/{appointmentId}','PatientReportController@getPatientReports');
Route::post('/deleteReport','PatientReportController@deleteReport');

Route::get('/appointmentReports/index','ReportsController@index');
Route::get('/appointmentReports/indexClear','ReportsController@indexCLear');
Route::get('/feeReports/feeReport','ReportsController@feeReport');
Route::get('/feeReports/feeReportClear','ReportsController@feeReportClear');


Route::get('/editAppointmentPayment/{appointmentId}','MyEventsController@editPayment');
Route::get('/getAppointmentPayment/{appointmentId}','MyEventsController@getAppointmentPayment');
Route::post('/deleteAppointmentPayment','MyEventsController@deleteAppointmentPayment');
Route::post('/payment/savePayment','MyEventsController@saveAppointmentPayment');

Route::get('/expense','ExpenseController@index')->name('expenses.index');
Route::post('/store_expense','ExpenseController@store')->name('expenses.store');

Route::get('/expenses/export', 'ExpenseController@export')->name('expenses.export');
