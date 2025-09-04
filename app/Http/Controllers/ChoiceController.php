<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Choice;

class ChoiceController extends Controller
{
    // Show form to add choices


     public function index(Question $question)
    {
        $question->load('choices'); 
        return view('choices.index', compact('question'));
    }
    public function create(Question $question)
    {
        return view('choices.create', compact('question'));
    }

    // Store multiple choices at once
   public function store(Request $request, Question $question)
{
    $request->validate([
        'choices' => 'required|array|min:1',       
        'choices.*' => 'required|string|max:255', 
    ]);

    foreach ($request->choices as $choice_text) {
        if ($choice_text) {
            $question->choices()->create(['choice_text' => $choice_text]);
        }
    }

    return redirect()->route('questions.index')->with('success', 'Choices added successfully!');
}

    // Show form to edit a single choice
    public function edit(Question $question, Choice $choice)
    {
        return view('choices.edit', compact('question', 'choice'));
    }

    // Update a single choice
    public function update(Request $request, Question $question, Choice $choice)
    {
        $request->validate([
            'choice_text' => 'required|string|max:255'
        ]);

        $choice->update([
            'choice_text' => $request->choice_text
        ]);

        return redirect()->route('questions.index')->with('success', 'Choice updated successfully!');
    }

    // Delete a choice
    public function destroy(Question $question, Choice $choice)
    {
        $choice->delete();
        return redirect()->route('questions.index')->with('success', 'Choice deleted successfully!');
    }

    public function updateMultiple(Request $request, Question $question)
{
    // Update existing choices
    if ($request->has('choices_existing')) {
        foreach ($request->choices_existing as $id => $text) {
            $choice = $question->choices()->find($id);
            if ($choice) {
                $choice->update(['choice_text' => $text]);
            }
        }
    }

    // Add new choices
    if ($request->has('choices_new')) {
        foreach ($request->choices_new as $text) {
            if ($text) {
                $question->choices()->create(['choice_text' => $text]);
            }
        }
    }

    return redirect()->route('questions.index')->with('success', 'Choices updated successfully!');
}

}
