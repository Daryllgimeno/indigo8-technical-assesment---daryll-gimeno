<h1>Edit Choice for Question: {{ $question->question_text }}</h1>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<form action="{{ route('choices.update', [$question->id, $choice->id]) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Choice Text:</label><br>
    <input type="text" name="choice_text" value="{{ old('choice_text', $choice->choice_text) }}" required><br><br>

    <button type="submit">Update Choice</button>
</form>

<a href="{{ route('choices.index', $question->id) }}">Back to Choices List</a>
