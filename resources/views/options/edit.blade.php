<h1>Edit Option</h1>

<form action="{{ route('options.update', $option->id) }}" method="POST">
    @csrf
    @method('PUT')
    <label>Option Text:</label><br>
    <input type="text" name="option_text" value="{{ $option->option_text }}" required><br><br>
    <button type="submit">Update</button>
</form>

<a href="{{ route('options.index', ['question_id' => $option->question_id]) }}">Back</a>
