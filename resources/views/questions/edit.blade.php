<h1>Edit Question</h1>
<form action="{{ route('questions.update', $question->id) }}" method="POST">
    @csrf
    @method('PUT')
    <label>Question Text:</label><br>
    <textarea name="question_text" required>{{ $question->question_text }}</textarea><br><br>
    <button type="submit">Update</button>
</form>
<a href="{{ route('questions.index') }}">Back</a>
