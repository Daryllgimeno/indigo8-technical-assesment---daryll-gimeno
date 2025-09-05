<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::with('choices')->get();
        return view('questions.index', compact('questions'));
    }
public function store(Request $request)
{
  
    $rules = [
        'question_text' => 'required|string',
        'type_of_question' => 'required|in:multiple_choice,checkbox,text',
    ];

   
    if (in_array($request->type_of_question, ['multiple_choice', 'checkbox'])) {
        $rules['choices'] = 'required|array|min:1';
        $rules['choices.*'] = 'required|string';
    }

    $validated = $request->validate($rules);

   
    $question = Question::create([
        'question_text' => $validated['question_text'],
        'type_of_question' => $validated['type_of_question'],
    ]);

    
    if (in_array($validated['type_of_question'], ['multiple_choice', 'checkbox'])) {
        foreach ($validated['choices'] as $choiceText) {
            if (!empty($choiceText)) { 
                $question->choices()->create(['choice_text' => $choiceText]);
            }
        }
    }

    return redirect()->route('questions.index')->with('success', 'Question added successfully!');
}

    public function edit(Question $question)
    {
        $question->load('choices');
        return view('questions.edit', compact('question'));
    }

    public function update(Request $request, Question $question)
    {
        $rules = [
            'question_text' => 'required|string',
            'type_of_question' => 'required|in:multiple_choice,checkbox,text',
        ];

        if (in_array($request->type_of_question, ['multiple_choice', 'checkbox'])) {
            $rules['choices'] = 'required|array|min:1';
            $rules['choices.*'] = 'required|string';
        }

        $request->validate($rules);

        $question->update($request->only('question_text', 'type_of_question'));

        
        $question->choices()->delete();
        if ($request->has('choices')) {
            foreach ($request->choices as $choiceText) {
                $question->choices()->create(['choice_text' => $choiceText]);
            }
        }

        return redirect()->route('questions.index')->with('success', 'Question updated successfully!');
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('questions.index')->with('success', 'Question deleted successfully!');
    }
}
