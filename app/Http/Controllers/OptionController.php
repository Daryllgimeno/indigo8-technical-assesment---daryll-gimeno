<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\Question;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function index(Request $request)
    {
        $question_id = $request->query('question_id');
        $question = Question::findOrFail($question_id);
        $options = $question->options;
        return view('options.index', compact('question', 'options'));
    }

    public function create(Request $request)
{
    $question_id = $request->query('question_id');
    $question = Question::findOrFail($question_id);
    return view('options.create', compact('question'));
}


public function store(Request $request)
{
    $request->validate([
        'question_id' => 'required|exists:questions,id',
        'option_text' => 'required|string',
    ]);

    Option::create([
        'question_id' => $request->question_id,
        'option_text' => $request->option_text
    ]);

    return redirect()->route('options.index', ['question_id' => $request->question_id])
                     ->with('success', 'Option added!');
}


    public function edit(Option $option)
    {
        return view('options.edit', compact('option'));
    }

    public function update(Request $request, Option $option)
    {
        $request->validate([
            'option_text' => 'required|string',
        ]);

        $option->update($request->all());
        return redirect()->route('options.index', ['question_id' => $option->question_id])
                         ->with('success', 'Option updated!');
    }

    public function destroy(Option $option)
    {
        $question_id = $option->question_id;
        $option->delete();
        return redirect()->route('options.index', ['question_id' => $question_id])
                         ->with('success', 'Option deleted!');
    }
}
