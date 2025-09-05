<!DOCTYPE html>
<html>
<head>
    <title>Survey Statistics</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h1 {
            color: #333;
        }
        h3 {
            margin-top: 20px;
            color: #555;
        }
        ul {
            list-style-type: disc;
            margin-left: 20px;
        }
        .text-answer {
            background: #f5f5f5;
            padding: 5px 10px;
            margin: 3px 0;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Survey Statistics</h1>

    @foreach($questions as $question)
        <h3>{{ $question->question_text }}</h3>

        {{-- If the question is text type, show raw answers --}}
        @if($question->type_of_question === 'text')
            <ul>
                @forelse($question->responses as $response)
                    <li class="text-answer">{{ $response->text_answer }}</li>
                @empty
                    <li>No responses yet.</li>
                @endforelse
            </ul>
        @else
            
            <ul>
                @foreach($question->choices as $choice)
                    @php
                        $total = $question->responses->count();
                        $count = $choice->responses->count();
                        $percent = $total > 0 ? round(($count / $total) * 100, 2) : 0;
                    @endphp
                    <li>{{ $choice->choice_text }} - {{ $percent }}% ({{ $count }} votes)</li>
                @endforeach
            </ul>
        @endif
    @endforeach
</body>
</html>
