<?php

use Illuminate\Support\Facades\Route;

/**
 * Import webpage controllers
 */
use App\Http\Controllers\AfController;
use App\Http\Controllers\SpreadsheetViewController;
use App\Http\Controllers\EvaluationPortalController;

/**
 * Import resource controllers
 */
use App\Http\Controllers\resources\UserController;
use App\Http\Controllers\resources\UserOwnedClassController;
use App\Http\Controllers\resources\ClassMemberController;
use App\Http\Controllers\resources\EvaluationController;
use App\Http\Controllers\resources\GroupController;
use App\Http\Controllers\resources\GroupMemberController;
use App\Http\Controllers\resources\SharedClassController;
use App\Http\Controllers\resources\SpreadsheetController;
use App\Http\Controllers\resources\SpreadsheetValueController;
use App\Http\Controllers\resources\TeacherController;
use App\Http\Controllers\resources\TestController;
use App\Http\Controllers\StandardsGrabber;

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
    return view('academicFidelity');
});

Auth::routes();

Route::get('/academicFidelity', [AfController::class, 'index'])->name('academicFidelity');
Route::get('/sheetView/{sheetId}', [SpreadsheetViewController::class, 'show'])->name('sheetView');
Route::get('/evaluationPortal', [EvaluationPortalController::class, 'index'])->name('evaluationPortal');

//These controllers interface with an API to get standards.
Route::get('/standardsGrabber/jurisdictions', [StandardsGrabber::class, 'listJurisdictions']);
Route::get('/standardsGrabber/standardSets/{jurisdictionId}',
    [StandardsGrabber::class, 'listStandardSets']);
Route::get('/standardsGrabber/standards/{standardSetId}', [StandardsGrabber::class, 'listStandards']);

//Returns user id. Preferable to setting a cookie.
Route::get('/userId', [UserController::class, 'getUserId']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


/**
 * API for resource interaction will be the same for all resources.
 */
//Retrieve list of classes with given boolean value for "archived".
Route::get('/class/archived/{archived}', [UserOwnedClassController::class, 'index']);

//CRUD for user's classes.
Route::resource('/class', UserOwnedClassController::class);

//Retrieve list of groups with given boolean value for "archived".
Route::get('/group/archived/{archived}', [GroupController::class, 'index']);

//CRUD for user's groups.
Route::resource('/group', GroupController::class);

//CRUD for group membership.
Route::resource('/groupMember', GroupMemberController::class);

//How is student performing on tests?
Route::get('/classMember/{id}/performance', [ClassMemberController::class, 'performance']);

//CRUD for student objects.
Route::resource('/classMember', ClassMemberController::class);

//CRUD for spreadsheets.
Route::resource('/spreadsheet', SpreadsheetController::class);

//CRUD for tests.
Route::resource('/test', TestController::class);

//CRUD for ss Values.
Route::resource('/spreadsheetValue', SpreadsheetValueController::class);

//CRUD for shared classes.
Route::resource('/sharedClass', SharedClassController::class);

//Get teachers with boolean value of "archived".
Route::get('/teacher/archived/{archived}', [TeacherController::class, 'index']);

//CRUD for teachers.
Route::resource('/teacher', TeacherController::class);

//Get observations or preobservations (depending on boolean variable in URL) of yourself.
Route::get('/evaluation/preObs/{preObs}', [EvaluationController::class, 'index']);

//CRUD for evalutions.
Route::resource('/evaluation', EvaluationController::class);
