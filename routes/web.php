<?php

use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ChoiceController;
use App\Http\Controllers\SurveyFormController;
use Illuminate\Support\Facades\Route;


Route::get('/welcome', function () {
    return view('welcome');
});

// Survey form routes
Route::get('/', [SurveyFormController::class, 'index'])->name('surveyform.index');
Route::post('/surveyform/submit', [SurveyFormController::class, 'submit'])->name('surveyform.submit');
Route::get('/surveyform/statistics', [SurveyFormController::class, 'statistics'])->name('surveyform.statistics');

// Question resource routes
Route::resource('questions', QuestionController::class);


Route::prefix('questions/{question}')->group(function () {
    Route::resource('choices', ChoiceController::class)->except(['show']);
    Route::put('choices/update-multiple', [ChoiceController::class, 'updateMultiple'])->name('choices.updateMultiple');
});
Route::put('/questions/{question}/choices/update', [ChoiceController::class, 'updateForQuestion'])
    ->name('choices.updateForQuestion');

