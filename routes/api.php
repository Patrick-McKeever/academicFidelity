<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * Import resource controllers.
 */
use App\Http\Controllers\resources\ClassController;
use App\Http\Controllers\resources\ClassMemberController;
use App\Http\Controllers\resources\EvaluationController;
use App\Http\Controllers\resources\GroupController;
use App\Http\Controllers\resources\GroupMemberController;
use App\Http\Controllers\resources\SlgController;
use App\Http\Controllers\resources\SharedClassController;
use App\Http\Controllers\resources\SpreadsheetController;
use App\Http\Controllers\resources\SpreadsheetValueController;
use App\Http\Controllers\resources\TeacherController;
use App\Http\Controllers\resources\TestController;
use App\Http\Controllers\sidebars\classListController;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/classList', [classListController::class, 'index']);

/**
 * API for resource interaction will be the same for all resources.
 */
Route::get('/class', [ClassController::class, 'index']);
Route::prefix('/class')->group( function() {
    Route::post('/store', [ClassController::class, 'store']);
    Route::put('/{id}', [ClassController::class, 'update']);
    Route::delete('/{id}', [ClassController::class, 'destroy']);
});

Route::get('/classMember', [ClassMemberController::class, 'index']);
Route::prefix('/classMember')->group( function() {
    Route::post('/store', [ClassMemberController::class, 'store']);
    Route::put('/{id}', [ClassMemberController::class, 'update']);
    Route::delete('/{id}', [ClassMemberController::class, 'destroy']);
});

Route::get('/evaluation', [EvaluationController::class, 'index']);
Route::prefix('/evaluation')->group( function() {
    Route::post('/store', [EvaluationController::class, 'store']);
    Route::put('/{id}', [EvaluationController::class, 'update']);
    Route::delete('/{id}', [EvaluationController::class, 'destroy']);
});

Route::get('/group', [GroupController::class, 'index']);
Route::prefix('/group')->group( function() {
    Route::post('/store', [GroupController::class, 'store']);
    Route::put('/{id}', [GroupController::class, 'update']);
    Route::delete('/{id}', [GroupController::class, 'destroy']);
});

/**
 * No update method here.
 * Since user is either member of a group or not member, we only need to create/remove rows.
 */
Route::get('/groupMember', [GroupMemberController::class, 'index']);
Route::prefix('/groupMember')->group( function() {
    Route::post('/store', [GroupMemberController::class, 'store']);
    Route::delete('/{id}', [GroupMemberController::class, 'destroy']);
});

Route::get('/slg', [SlgController::class, 'index']);
Route::prefix('/slg')->group( function() {
    Route::post('/store', [SlgController::class, 'store']);
    Route::put('/{id}', [SlgController::class, 'update']);
    Route::delete('/{id}', [SlgController::class, 'destroy']);
});

/**
 * This object exists specifically in order to show that a class is shared with a group.
 * As such, we only need creation and destruction, no updates.
 */
Route::get('/sharedClass', [SharedClassController::class, 'index']);
Route::prefix('/sharedClass')->group( function() {
    Route::post('/store', [SharedClassController::class, 'store']);
    Route::delete('/{id}', [SharedClassController::class, 'destroy']);
});

Route::get('/spreadsheet', [SpreadsheetController::class, 'index']);
Route::prefix('/spreadsheet')->group( function() {
    Route::post('/store', [SpreadsheetController::class, 'store']);
    Route::put('/{id}', [SpreadsheetController::class, 'update']);
    Route::delete('/{id}', [SpreadsheetController::class, 'destroy']);
});

Route::get('/spreadsheetValue', [SpreadsheetValueController::class, 'index']);
Route::prefix('/spreadsheetValue')->group( function() {
    Route::post('/store', [SpreadsheetValueController::class, 'store']);
    Route::put('/{id}', [SpreadsheetValueController::class, 'update']);
    Route::delete('/{id}', [SpreadsheetValueController::class, 'destroy']);
});

Route::get('/teacher', [TeacherController::class, 'index']);
Route::prefix('/teacher')->group( function() {
    Route::post('/store', [TeacherController::class, 'store']);
    Route::put('/{id}', [TeacherController::class, 'update']);
    Route::delete('/{id}', [TeacherController::class, 'destroy']);
});

Route::get('/test', [TestController::class, 'index']);
Route::prefix('/test')->group( function() {
    Route::post('/store', [TeacherController::class, 'store']);
    Route::put('/{id}', [TeacherController::class, 'update']);
    Route::delete('/{id}', [TeacherController::class, 'destroy']);
});
