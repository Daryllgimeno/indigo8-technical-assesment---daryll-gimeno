<!DOCTYPE html>
<html>
<head>
    <title>Manage Choices</title>
    <style>
        table { border-collapse: collapse; width: 50%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Choices for: {{ $question->question_text }}</h1>

    <a href="{{ route('choices.create', $question->id) }}">Add New Choice</a><br><br>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Choice Text</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($question->choices as $index => $choice)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $choice->choice_text }}</td>
                <td>
                    <a href="{{ route('choices.edit', [$question->id, $choice->id]) }}">Edit</a>
                    <form action="{{ route('choices.destroy', [$question->id, $choice->id]) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this choice?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
