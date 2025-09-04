<h1>Survey Statistics</h1>
@foreach($questions as $question)
    <h3>{{ $question->question_text }}</h3>
    @foreach($question->options as $option)
        @php
            $count = $option->answers()->count();
            $total = $question->answers()->count();
            $percentage = $total > 0 ? round(($count / $total) * 100, 2) : 0;
        @endphp
        <p>{{ $option->option_text }}: {{ $percentage }}%</p>
    @endforeach
@endforeach
