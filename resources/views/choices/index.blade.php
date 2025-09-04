<h1>Choices for: {{ $question->question_text }}</h1>

<a href="{{ route('choices.create', $question->id) }}">Add Choice</a>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<table border="1">
    <tr>
        <th>#</th>
        <th>Choice</th>
        <th>Actions</th>
    </tr>
    @foreach($question->choices as $index => $choice)
    <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $choice->choice_text }}</td>
        <td>
            <a href="{{ route('choices.edit', [$question->id, $choice->id]) }}">Edit</a> | 
            <form action="{{ route('choices.destroy', [$question->id, $choice->id]) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Delete this choice?')">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

<a href="{{ route('questions.index') }}">Back to Questions</a>
