<?php

namespace App\Http\Controllers;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;



class SurveyController extends Controller
{
public function index()
{
    $questions = Question::with('options')->get();
    return view('survey.index', compact('questions'));
}


public function submit(Request $request)
{
    $answers = $request->input('answers', []);
    foreach ($answers as $question_id => $option_id) {
        Answer::create([
            'question_id' => $question_id,
            'option_id' => $option_id
        ]);
    }

    return redirect()->route('survey.index')->with('success', 'Survey submitted!');
}
public function stats()
{
    $questions = Question::with('options.answers')->get();
    return view('survey.stats', compact('questions'));
}

}
