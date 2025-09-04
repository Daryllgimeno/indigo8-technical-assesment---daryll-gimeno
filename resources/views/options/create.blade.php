<h1>Add Option for Question: {{ $question->question_text }}</h1>

<form action="{{ route('options.store') }}" method="POST">
    @csrf
    <input type="hidden" name="question_id" value="{{ $question->id }}">

    <label>Option Text:</label><br>
    <input type="text" name="option_text" required><br><br>

    <button type="submit">Save Option</button>
</form>

<a href="{{ route('options.index', ['question_id' => $question->id]) }}">Back</a>
