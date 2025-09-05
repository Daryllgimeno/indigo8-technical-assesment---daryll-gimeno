<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Response;
use Illuminate\Support\Facades\Mail;
use App\Mail\SurveyResponseMail;
use Illuminate\Support\Facades\Log;

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
        Log::info('Incoming request data:', $request->all());

        $request->validate([
            'responses' => 'required|array',
            'email' => 'nullable|email',
        ]);
        
        Log::info('Validation passed, processing responses');
        
        $responsesData = [];

        foreach ($request->responses as $questionId => $answer) {
            $question = Question::find($questionId);
            if (!$question) continue;

            if ($question->type_of_question === 'text') {
                Response::create([
                    'question_id' => $questionId,
                    'text_answer' => $answer,
                ]);
                $responsesData[$question->question_text] = $answer;
            } else {
                Response::create([
                    'question_id' => $questionId,
                    'choice_id' => $answer,
                ]);
                $choice = $question->choices->firstWhere('id', $answer);
                $responsesData[$question->question_text] = $choice ? $choice->choice_text : $answer;
            }
        }

        if ($request->filled('email')) {
            Log::info("Sending email to {$request->email}");

            try {
                Mail::to($request->email)->send(new SurveyResponseMail($responsesData));
                Log::info('Email sent successfully.');
            } catch (\Exception $e) {
                Log::error('Error sending email: ' . $e->getMessage());
            }
        } else {
            Log::info("No email provided, skipping email send.");
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
