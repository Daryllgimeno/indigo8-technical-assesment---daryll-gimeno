<?php

namespace App\Http\Controllers;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;




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

    foreach ($answers as $question_id => $optionIds) {
        // Ensure $optionIds is an array (for checkboxes)
        $optionIds = (array) $optionIds;

        foreach ($optionIds as $option_id) {
            \DB::table('answers')->insert([
                'question_id' => $question_id,
                'option_id' => $option_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    return redirect()->back()->with('success', 'Survey submitted successfully!');
}

public function stats()
{
    $questions = Question::with('options.answers')->get();
    return view('survey.stats', compact('questions'));
}

}
