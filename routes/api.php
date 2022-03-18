<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->post('/childregister', function (Request $request) {
    return $request->user();
});
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
Route::match(['get', 'post'], '/login', [App\Http\Controllers\AuthController::class , 'login'])->name('login');

Route::match(['get', 'post'], '/EmployeeRegister', [App\Http\Controllers\EmployeeController::class , 'EmployeeRegister'])->name('EmployeeRegister');
Route::match(['get', 'post'], '/EmployeeEdit/{slug?}', [App\Http\Controllers\EmployeeController::class , 'EmployeeEdit'])->name('EmployeeEdit');
Route::match(['get', 'post'], '/employees', [App\Http\Controllers\EmployeeController::class , 'ActiveEmployeeListing'])->name('employeelisiting');
Route::get( '/inactiveemployee', [App\Http\Controllers\EmployeeController::class , 'InactiveEmployeeLisiting'])->name('inactiveemployeelisiting');
Route::get( '/childlist', [App\Http\Controllers\ChildDetails::class , 'ChildList'])->name('ChildList');
Route::get( '/inactivechildist', [App\Http\Controllers\ChildDetails::class , 'InactiveChildList'])->name('InactiveChildList');
Route::match(['get', 'post'], '/EmployeeDelete/{slug?}', [App\Http\Controllers\EmployeeController::class , 'EmployeeDelete'])->name('EmployeeDelete');
Route::match(['get', 'post'], '/EmployeeUpdate/{slug?}', [App\Http\Controllers\EmployeeController::class , 'EmployeeUpdate'])->name('EmployeeUpdate');
Route::match(['get', 'post'], '/childdetialsedit/{value}', [App\Http\Controllers\ChildDetails::class , 'ChildDetialsEdit'])->name('childdetialsedit');
Route::match(['get', 'post'], '/childdetialsupdate/{value}', [App\Http\Controllers\ChildDetails::class , 'ChildDetialsUpdate'])->name('childdetialsupdate');
Route::match(['get', 'post'], '/childdetialsdelete/{value}', [App\Http\Controllers\ChildDetails::class , 'ChildDetialsDelete'])->name('childdetialsdelete');
Route::match(['get', 'post'], '/childregister', [App\Http\Controllers\ChildDetails::class , 'ChildDetialsRegister'])->name('childregister');

Route::match(['get', 'post'], '/resetpassword/{email}', [App\Http\Controllers\MailController::class , 'ResetMail'])->name('resetpassword');
Route::match(['get', 'post'], '/sendhtmlemail', [App\Http\Controllers\MailController::class , 'html_email'])->name('EmployeeUpdate');
Route::match(['get', 'post'], '/sendattachmentemail', [App\Http\Controllers\MailController::class , 'attachment_email'])->name('EmployeeUpdate');
Route::post('/Verifyotp', [App\Http\Controllers\MailController::class , 'VerifyOtp'])->name('Verifyotp');
Route::post('/passwordchange', [App\Http\Controllers\MailController::class , 'ForgotPasswordChange'])->name('passwordchange');
Route::post('/Knownpasswordchange', [App\Http\Controllers\MailController::class, 'KnownPasswordChange'])->name('Knownpasswordchange');
});

