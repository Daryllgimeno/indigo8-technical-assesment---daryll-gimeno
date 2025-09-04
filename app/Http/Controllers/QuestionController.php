<?php
namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

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
        'question_text' => 'required|string',
        'question_type' => 'required|string',
        'options' => 'sometimes|array'
    ]);

    $question = Question::create([
        'question_text' => $request->question_text,
        'question_type' => $request->question_type,
    ]);

    if(in_array($request->question_type, ['radio','checkbox']) && $request->options){
        foreach($request->options as $optText){
            $question->options()->create(['option_text' => $optText]);
        }
    }

    return redirect()->route('questions.index')->with('success', 'Question added!');
}


    public function edit(Question $question)
    {
        return view('questions.edit', compact('question'));
    }

    public function update(Request $request, Question $question)
    {
        $request->validate([
            'question_text' => 'required|string',
            'question_type' => 'required|string|in:radio,checkbox,text', 
        ]);

        $question->update($request->only('question_text', 'question_type'));
        return redirect()->route('questions.index')->with('success', 'Question updated!');
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('questions.index')->with('success', 'Question deleted!');
    }
}
