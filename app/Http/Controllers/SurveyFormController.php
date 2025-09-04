<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Response;

class SurveyFormController extends Controller
{
    // Show all questions for survey
    public function index()
    {
        $questions = Question::with('choices')->get();
        return view('surveyform.index', compact('questions'));
    }

    // Submit survey responses
    public function submit(Request $request)
    {
        $responses = $request->input('responses', []);

        foreach ($responses as $question_id => $choice_id) {
            Response::create([
                'question_id' => $question_id,
                'choice_id' => $choice_id
            ]);
        }

        return redirect()->route('surveyform.index')->with('success', 'Survey submitted successfully!');
    }

    // Show survey statistics
    public function statistics()
    {
        $questions = Question::with('choices.responses')->get();
        return view('surveyform.statistics', compact('questions'));
    }
}
