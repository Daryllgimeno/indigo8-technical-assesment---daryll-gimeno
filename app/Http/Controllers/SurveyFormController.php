<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Response;

class SurveyFormController extends Controller
{
    
    public function index()
    {
        $questions = Question::with('choices')->get();
        return view('surveyform.index', compact('questions'));
    }

  
    public function store(Request $request)
    {
        $request->validate([
            'question_text' => 'required|string',
            'type_of_question' => 'required|string',
            'choices.*' => 'nullable|string'
        ]);

      
        $question = Question::create($request->only('question_text', 'type_of_question'));

        if (in_array($request->type_of_question, ['multiple_choice', 'checkbox']) && $request->has('choices')) {
            foreach ($request->choices as $choice_text) {
                if ($choice_text) {
                    $question->choices()->create(['choice_text' => $choice_text]);
                }
            }
        }

        return redirect()->back()->with('success', 'Question added successfully!');
    }

   
 public function submit(Request $request)
{
    $request->validate([
        'responses' => 'required|array',
    ]);

    foreach ($request->responses as $questionId => $answer) {
        $question = Question::find($questionId);

        if (!$question) continue;

        if ($question->type_of_question === 'text') {
            Response::create([
                'question_id' => $questionId,
                'text_answer' => $answer,
            ]);
        } else {
            if (is_array($answer)) {
                foreach ($answer as $choiceId) {
                    Response::create([
                        'question_id' => $questionId,
                        'choice_id' => $choiceId,
                    ]);
                }
            } else {
                Response::create([
                    'question_id' => $questionId,
                    'choice_id' => $answer,
                ]);
            }
        }
    }

 
    return redirect()->route('surveyform.index')
                     ->with('success', 'Thank you for completing the survey!');
}



    public function statistics()
    {
        $questions = Question::with(['choices.responses', 'responses'])->get();
    return view('surveyform.statistics', compact('questions'));
    }
}
