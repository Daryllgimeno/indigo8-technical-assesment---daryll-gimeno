<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::all();
        return view('questions.index', compact('questions'));
    }

    public function create()
    {
        return view('questions.create');
    }

public function store(Request $request)
{
    $request->validate([
        'question_text' => 'required',
        'type_of_question' => 'required|in:multiple_choice,checkbox,text'
    ]);

    Question::create($request->only('question_text', 'type_of_question'));

    return redirect()->route('questions.index')->with('success', 'Question added successfully!');
}



    public function edit(Question $question)
    {
        return view('questions.edit', compact('question'));
    }

  public function update(Request $request, Question $question)
{
    $request->validate([
        'question_text' => 'required',
        'type_of_question' => 'required|in:multiple_choice,checkbox,text'
    ]);

    $question->update($request->only('question_text', 'type_of_question'));

    return redirect()->route('questions.index')->with('success', 'Question updated successfully!');
}
    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('questions.index')->with('success', 'Question deleted successfully!');
    }
}
