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
            'question_text' => 'required',
            'type_of_question' => 'required',
            'choices.*' => 'nullable|string'
        ]);

      
        $question = Question::create($request->only('question_text', 'type_of_question'));

       
        if ($request->type_of_question === 'multiple_choice' || $request->type_of_question === 'checkbox') {
            if($request->has('choices')) {
                foreach($request->choices as $choice_text) {
                    if($choice_text) {
                        $question->choices()->create(['choice_text' => $choice_text]);
                    }
                }
            }
        }

        return redirect()->back()->with('success', 'Question added successfully!');
    }


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

   
    public function statistics()
    {
        $questions = Question::with('choices.responses')->get();
        return view('surveyform.statistics', compact('questions'));
    }
}
