<!DOCTYPE html>
<html>
<head>
    <title>Questions</title>
</head>
<body>
    <h1>Questions</h1>

    <a href="{{ route('questions.create') }}">Add New Question</a>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <ul>
        @foreach($questions as $question)
            <li>
                {{ $question->question_text }}
                <a href="{{ route('questions.edit', $question->id) }}">Edit</a>
                <form action="{{ route('questions.destroy', $question->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
                <a href="{{ route('choices.index', $question->id) }}">Manage Choices</a>
            </li>
        @endforeach
    </ul>
</body>
</html>
