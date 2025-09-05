<?php

use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ChoiceController;
use App\Http\Controllers\SurveyFormController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

Route::get('/welcome', function () {
    return view('welcome');
});


Route::get('/', [SurveyFormController::class, 'index'])->name('surveyform.index');
Route::post('/surveyform/submit', [SurveyFormController::class, 'submit'])->name('surveyform.submit');
Route::get('/surveyform/statistics', [SurveyFormController::class, 'statistics'])->name('surveyform.statistics');


Route::resource('questions', QuestionController::class);


Route::prefix('questions/{question}')->group(function () {
    Route::resource('choices', ChoiceController::class)->except(['show']);

    
    Route::put('choices/update-multiple', [ChoiceController::class, 'updateMultiple'])
        ->name('choices.updateMultiple');

   
    Route::put('choices/update-for-question', [ChoiceController::class, 'updateForQuestion'])
        ->name('choices.updateForQuestion');

       
});
Route::get('/test-mail', function () {
    Mail::raw('This is a test email from Laravel!', function ($message) {
        $message->to('your-sandbox-email@mailtrap.io')
                ->subject('Test Email');
    });
    return 'Test email sent!';
});
