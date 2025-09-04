<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Choice;

class ChoiceController extends Controller
{
    public function create(Question $question)
    {
        return view('choices.create', compact('question'));
    }

    public function store(Request $request, Question $question)
    {
        $request->validate([
            'choice_text' => 'required'
        ]);

        $question->choices()->create($request->all());
        return redirect()->route('questions.index')->with('success', 'Choice added successfully!');
    }

    public function edit(Question $question, Choice $choice)
    {
        return view('choices.edit', compact('question', 'choice'));
    }

    public function update(Request $request, Question $question, Choice $choice)
    {
        $request->validate([
            'choice_text' => 'required'
        ]);

        $choice->update($request->all());
        return redirect()->route('questions.index')->with('success', 'Choice updated successfully!');
    }

    public function destroy(Question $question, Choice $choice)
    {
        $choice->delete();
        return redirect()->route('questions.index')->with('success', 'Choice deleted successfully!');
    }
}
