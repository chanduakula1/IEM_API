<?phpuse Illuminate\Http\Request;use Illuminate\Support\Facades\Route;/*|--------------------------------------------------------------------------| API Routes|--------------------------------------------------------------------------|| Here is where you can register API routes for your application. These| routes are loaded by the RouteServiceProvider within a group which| is assigned the "api" middleware group. Enjoy building your API!|*/// Route::middleware('auth:sanctum')->post('/childregister', function (Request $request) {//     return $request->user();// });// Route::group([//     'middleware' => 'api',//     'prefix' => 'auth'// ], function ($router) {// Route::match(['get', 'post'], '/login', [App\Http\Controllers\AuthController::class , 'login'])->name('login');//Route::post('login', [App\Http\Controllers\EmployeeController::class, 'login']);Route::match(['get', 'post'], '/EmployeeRegister', [App\Http\Controllers\EmployeeController::class, 'EmployeeRegister'])->name('EmployeeRegister'); //Route::group(['middleware' => ['jwt.verify']], function() {Route::match(['get', 'post'], '/EmployeeEdit/{slug?}', [App\Http\Controllers\EmployeeController::class , 'EmployeeEdit'])->name('EmployeeEdit');Route::match(['get', 'post'], '/employees', [App\Http\Controllers\EmployeeController::class , 'ActiveEmployeeListing'])->name('employeelisiting');Route::get( '/inactiveemployee', [App\Http\Controllers\EmployeeController::class , 'InactiveEmployeeLisiting'])->name('inactiveemployeelisiting');// Route::get( '/childlist', [App\Http\Controllers\ChildDetails::class , 'ChildList'])->name('ChildList');Route::get( '/inactivechildist', [App\Http\Controllers\ChildDetails::class , 'InactiveChildList'])->name('InactiveChildList');Route::match(['get', 'post'], '/EmployeeDelete/{slug?}', [App\Http\Controllers\EmployeeController::class , 'EmployeeDelete'])->name('EmployeeDelete');Route::match(['get', 'post'], '/EmployeeUpdate/{slug?}', [App\Http\Controllers\EmployeeController::class , 'EmployeeUpdate'])->name('EmployeeUpdate');Route::match(['get', 'post'], '/childdetialsedit/{value}', [App\Http\Controllers\ChildDetails::class , 'ChildDetialsEdit'])->name('childdetialsedit');Route::match(['get', 'post'], '/childdetialsupdate/{value}', [App\Http\Controllers\ChildDetails::class , 'ChildDetialsUpdate'])->name('childdetialsupdate');Route::match(['get', 'post'], '/childdetialsdelete/{value}', [App\Http\Controllers\ChildDetails::class , 'ChildDetialsDelete'])->name('childdetialsdelete');Route::match(['get', 'post'], '/childregister', [App\Http\Controllers\ChildDetails::class , 'ChildDetialsRegister'])->name('childregister');Route::match(['get', 'post'], '/resetpassword/{email}', [App\Http\Controllers\MailController::class , 'ResetMail'])->name('resetpassword');Route::match(['get', 'post'], '/sendhtmlemail', [App\Http\Controllers\MailController::class , 'html_email'])->name('EmployeeUpdate');Route::match(['get', 'post'], '/sendattachmentemail', [App\Http\Controllers\MailController::class , 'attachment_email'])->name('EmployeeUpdate');Route::post('/Verifyotp', [App\Http\Controllers\MailController::class , 'VerifyOtp'])->name('Verifyotp');Route::post('/passwordchange', [App\Http\Controllers\MailController::class , 'ForgotPasswordChange'])->name('passwordchange');Route::post('/Knownpasswordchange', [App\Http\Controllers\MailController::class, 'KnownPasswordChange'])->name('Knownpasswordchange');Route::post('/leaveapplication', [App\Http\Controllers\LeaveManagementController::class, 'LeaveApply'])->name('leaveapplication');Route::post('/withdrawleave', [App\Http\Controllers\LeaveManagementController::class, 'WithdrawLeaveApplication'])->name('withdrawleave');Route::post('/CreateNewCourse', [App\Http\Controllers\CourseController::class, 'CreateNewCourse'])->name('CreateNewCourse');Route::post('/DeleteCourse/{slug}', [App\Http\Controllers\CourseController::class, 'DeleteCourse'])->name('DeleteCourse');Route::get('/ListingCourses', [App\Http\Controllers\CourseController::class, 'ListingCourses'])->name('ListingCourses');Route::get('/UpdateCourse/{slug}', [App\Http\Controllers\CourseController::class, 'UpdateCourse'])->name('UpdateCourse');Route::post('/UpdateCouserDetials/{slug}', [App\Http\Controllers\CourseController::class, 'UpdateCouserDetials'])->name('UpdateCouserDetials');Route::post('/EmployeeRegisterCourse', [App\Http\Controllers\EmployeeCourses::class, 'EmployeeRegisterCourse'])->name('EmployeeRegisterCourse');Route::post('/EmployeeCourseDelete/{slug}', [App\Http\Controllers\EmployeeCourses::class, 'EmployeeCourseDelete'])->name('EmployeeCourseDelete');Route::post('/EmployeeCourseList', [App\Http\Controllers\EmployeeCourses::class, 'EmployeeCourseList'])->name('EmployeeCourseList');Route::get('/EmployeeCourseUpdate/{slug}', [App\Http\Controllers\EmployeeCourses::class, 'EmployeeCourseUpdate'])->name('EmployeeCourseUpdate');Route::post('/EmployeeCourseUpdateData/{slug}', [App\Http\Controllers\EmployeeCourses::class, 'EmployeeCourseUpdateData'])->name('EmployeeCourseUpdateData');Route::post('/ChangeLeaveDates', [App\Http\Controllers\LeaveManagementController::class, 'ChangeLeaveDates'])->name('ChangeLeaveDates');Route::get('/IndividualEmployeeLeaves', [App\Http\Controllers\LeaveManagementController::class, 'IndividualEmployeeLeaves'])->name('IndividualEmployeeLeaves');Route::get('/ListingLeaves', [App\Http\Controllers\LeaveManagementController::class, 'ListingLeaves'])->name('ListingLeaves');Route::post('/RegisterTraining', [App\Http\Controllers\TrainingDetailController::class, 'RegisterTraining'])->name('RegisterTraining');Route::post('/PersonalDiarySubmit', [App\Http\Controllers\employee\PersonalDiaryController::class, 'PersonalDiarySubmit'])->name('PersonalDiarySubmit');Route::get('/Personaldairy', [App\Http\Controllers\employee\PersonalDiaryController::class, 'Personaldairy'])->name('Personaldairy');Route::get('/Personaldairyupdate', [App\Http\Controllers\employee\PersonalDiaryController::class, 'Personaldairyupdate'])->name('Personaldairyupdate');Route::get('/Personaldairydelete', [App\Http\Controllers\employee\PersonalDiaryController::class, 'Personaldairydelete'])->name('Personaldairydelete');Route::post('/PersonalJournalSubmit', [App\Http\Controllers\employee\PersonalJournalController::class, 'PersonalJournalSubmit'])->name('PersonalJournalSubmit');Route::get('/PersonalJournals', [App\Http\Controllers\employee\PersonalJournalController::class, 'PersonalJournals'])->name('PersonalJournals');// });Route::post('/PersonalJournalsUpdate/{slug}', [App\Http\Controllers\employee\PersonalJournalController::class, 'PersonalJournalsUpdate'])->name('PersonalJournalsUpdate');Route::post('/PersonalJournalsDelete/{slug}', [App\Http\Controllers\employee\PersonalJournalController::class, 'PersonalJournalsDelete'])->name('PersonalJournalsDelete');Route::post('/MinistryDetailSubmit', [App\Http\Controllers\employee\MinistryDetailsController::class, 'MinistryDetailSubmit'])->name('MinistryDetailSubmit');Route::post('/MinistryDetailDelete/{slug}', [App\Http\Controllers\employee\MinistryDetailsController::class, 'MinistryDetailDelete'])->name('MinistryDetailDelete');Route::post('/MinistryDetailUpdate/{slug}', [App\Http\Controllers\employee\MinistryDetailsController::class, 'MinistryDetailUpdate'])->name('MinistryDetailUpdate');Route::post('/MinistryDetailEdit/{slug}', [App\Http\Controllers\employee\MinistryDetailsController::class, 'MinistryDetailEdit'])->name('MinistryDetailEdit');Route::get('/MinistryDetails/', [App\Http\Controllers\employee\MinistryDetailsController::class, 'MinistryDetails'])->name('MinistryDetails');Route::get('get_user', [App\Http\Controllers\EmployeeController::class, 'get_user']);Route::post('getEmployeesList', [App\Http\Controllers\EmployeeController::class, 'getEmployeesList']);Route::get('logout', [App\Http\Controllers\EmployeeController::class, 'logout']);Route::get('childlist', [App\Http\Controllers\ChildDetails::class , 'ChildList'])->name('ChildList');Route::post('childlist', [App\Http\Controllers\ChildDetails::class , 'ChildList'])->name('ChildList');Route::post('ApplyBill', [App\Http\Controllers\BillsAndAdvancesController::class , 'ApplyBill'])->name('ApplyBill');Route::post('/BillDelete/{slug}', [App\Http\Controllers\BillsAndAdvancesController::class , 'BillDelete'])->name('BillDelete');Route::post('/Billsadvances', [App\Http\Controllers\BillsAndAdvancesController::class , 'Billsadvances'])->name('Billsadvances');Route::post('/InactiveBillsAdvances', [App\Http\Controllers\BillsAndAdvancesController::class , 'InactiveBillsAdvances'])->name('InactiveBillsAdvances');Route::post('/FurtherStudiesAndTraining', [App\Http\Controllers\employee\FurtherStudiesAndTrainingController::class , 'FurtherStudiesAndTraining'])->name('FurtherStudiesAndTraining');Route::post('/InactiveFurthureStudiesAndTraining', [App\Http\Controllers\employee\FurtherStudiesAndTrainingController::class , 'InactiveFurthureStudiesAndTraining'])->name('InactiveFurthureStudiesAndTraining');Route::get('/FurtherStudiesAndTrainingDetails', [App\Http\Controllers\employee\FurtherStudiesAndTrainingController::class , 'FurtherStudiesAndTrainingDetails'])->name('FurtherStudiesAndTrainingDetails');Route::get('/InactiveFurtherStudiesAndTrainingDetails', [App\Http\Controllers\employee\FurtherStudiesAndTrainingController::class , 'InactiveFurtherStudiesAndTrainingDetails'])->name('InactiveFurtherStudiesAndTrainingDetails');Route::get('/FurtherStudiesAndTrainingDetailsEdit', [App\Http\Controllers\employee\FurtherStudiesAndTrainingController::class , 'FurtherStudiesAndTrainingDetailsEdit'])->name('FurtherStudiesAndTrainingDetailsEdit');Route::post('/UpdateStudiesAndTrainingDetails', [App\Http\Controllers\employee\FurtherStudiesAndTrainingController::class , 'UpdateStudiesAndTrainingDetails'])->name('UpdateStudiesAndTrainingDetails');Route::post('AddRole', [App\Http\Controllers\employee\RoleController::class , 'AddRole'])->name('AddRole');Route::post('RoleDelete/{slug}', [App\Http\Controllers\employee\RoleController::class , 'RoleDelete'])->name('RoleDelete');Route::get('GetDataToBeUpdated/{slug}', [App\Http\Controllers\employee\RoleController::class , 'GetDataToBeUpdated'])->name('GetDataToBeUpdated');Route::post('UpdateRole/{slug}', [App\Http\Controllers\employee\RoleController::class , 'UpdateRole'])->name('UpdateRole');Route::get('Roles', [App\Http\Controllers\employee\RoleController::class , 'Roles'])->name('Roles');Route::post('/Ministries', [App\Http\Controllers\employee\MinistryDetailsController::class, 'Ministries'])->name('Ministries');Route::post('/LeaveReports', [App\Http\Controllers\employee\ExactReportsController::class, 'LeaveReports'])->name('LeaveReports');Route::post('/MinistryReports', [App\Http\Controllers\employee\ExactReportsController::class, 'MinistryReports'])->name('MinistryReports');Route::post('/BillsAndAdvances', [App\Http\Controllers\employee\ExactReportsController::class, 'BillsAndAdvances'])->name('BillsAndAdvances');Route::post('/CorrespondenceWithSupporters', [App\Http\Controllers\employee\ExactReportsController::class, 'CorrespondenceWithSupporters'])->name('CorrespondenceWithSupporters');});