<!DOCTYPE html>
<html>
<head>
    <title>Survey Statistics</title>
</head>
<body>
    <h1>Survey Statistics</h1>

    @foreach($questions as $question)
        <h3>{{ $question->question_text }}</h3>
        <ul>
            @foreach($question->choices as $choice)
                @php
                    $total = $question->responses->count();
                    $count = $choice->responses->count();
                    $percent = $total > 0 ? round(($count / $total) * 100, 2) : 0;
                @endphp
                <li>{{ $choice->choice_text }} - {{ $percent }}%</li>
            @endforeach
        </ul>
    @endforeach
</body>
</html>
