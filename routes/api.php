<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubjectController;

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