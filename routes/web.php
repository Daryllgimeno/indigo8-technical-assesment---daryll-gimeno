<?php
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ChoiceController;
use App\Http\Controllers\SurveyFormController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('questions', QuestionController::class);

Route::prefix('questions/{question}')->group(function () {
    Route::resource('choices', ChoiceController::class)->except(['index', 'show']);
});

Route::get('/', [SurveyFormController::class, 'index'])->name('surveyform.index');
Route::post('/surveyform/submit', [SurveyFormController::class, 'submit'])->name('surveyform.submit');
Route::get('/surveyform/statistics', [SurveyFormController::class, 'statistics'])->name('surveyform.statistics');
