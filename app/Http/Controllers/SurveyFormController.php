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
    $questions = Question::pluck('id')->toArray(); 

  
    foreach ($questions as $question_id) {
        if (!isset($request->responses[$question_id]) || empty($request->responses[$question_id])) {
            return redirect()->back()->withErrors('Please answer all questions before submitting.')->withInput();
        }
    }


    foreach ($request->responses as $question_id => $choice_id) {
        if (is_array($choice_id)) { 
            foreach ($choice_id as $c_id) {
                Response::create([
                    'question_id' => $question_id,
                    'choice_id' => $c_id
                ]);
            }
        } else {
            Response::create([
                'question_id' => $question_id,
                'choice_id' => $choice_id
            ]);
        }
    }

    return redirect()->route('surveyform.index')->with('success', 'Survey submitted successfully!');
}


   
    public function statistics()
    {
        $questions = Question::with('choices.responses')->get();
        return view('surveyform.statistics', compact('questions'));
    }
}
