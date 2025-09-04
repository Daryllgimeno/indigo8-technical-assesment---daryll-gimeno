<h1>All Questions</h1>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<table border="1">
    <tr>
        <th>ID</th>
        <th>Question</th>
        <th>Type</th>
        <th>Actions</th>
    </tr>
    @foreach($questions as $question)
    <tr>
        <td>{{ $question->id }}</td>
        <td>{{ $question->question_text }}</td>
        <td>{{ $question->question_type ?? '-' }}</td>
        <td>
            <a href="{{ route('questions.edit', $question->id) }}">Edit</a> |
            <form action="{{ route('questions.destroy', $question->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Delete this question?')">Delete</button>
            </form> |
            <a href="{{ route('options.index', ['question_id' => $question->id]) }}">Options</a>
        </td>
    </tr>
    @endforeach
</table>

<a href="{{ route('questions.create') }}">Add New Question</a>
