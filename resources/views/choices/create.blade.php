<h1>Add Choice for Question: {{ $question->question_text }}</h1>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<form action="{{ route('choices.store', $question->id) }}" method="POST">
    @csrf

    <label>Choice Text:</label><br>
    <input type="text" name="choice_text" required><br><br>

    <button type="submit">Save Choice</button>
</form>

<a href="{{ route('choices.index', $question->id) }}">Back to Choices List</a>
