<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\StudentInfoController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//SUBJECT
//GET
Route::get('/students/{id}/subjects', [SubjectController::class, 'index']);
//POST
Route::post('/students/{id}/subjects', [SubjectController::class, 'add']);
//GET (SPECIFIC)
Route::get('/students/{id}/subjects/{subject_id}', [SubjectController::class, 'find']);
//PATCH
Route::patch('/students/{id}/subjects/{subject_id}', [SubjectController::class, 'update']);
//Student-Info
//GET
Route::get('/students', [StudentInfoController::class, 'index']);
//POST
Route::post('/students', [StudentInfoController::class, 'register']);
//GET (SPECIFIC)
Route::get('/students/{id}', [StudentInfoController::class, 'find']);
//PATCH
Route::patch('/students/{id}', [StudentInfoController::class, 'update']);