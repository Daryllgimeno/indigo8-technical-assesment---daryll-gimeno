<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\QuestionController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\SurveyController;

Route::get('/', [SurveyController::class, 'index'])->name('survey.index');
Route::post('/survey/submit', [SurveyController::class, 'submit'])->name('survey.submit');
Route::get('/survey/stats', [SurveyController::class, 'stats'])->name('survey.stats');

Route::resource('questions', QuestionController::class);
Route::resource('options', OptionController::class);
