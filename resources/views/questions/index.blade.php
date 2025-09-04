<h1>Options for: {{ $question->question_text }}</h1>
<a href="{{ route('options.create', ['question_id' => $question->id]) }}">Add Option</a>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<table border="1">
    <tr>
        <th>ID</th>
        <th>Option</th>
        <th>Actions</th>
    </tr>
    @foreach($options as $opt)
    <tr>
        <td>{{ $opt->id }}</td>
        <td>{{ $opt->option_text }}</td>
        <td>
            <a href="{{ route('options.edit', $opt->id) }}">Edit</a> | 
            <form action="{{ route('options.destroy', $opt->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Delete this option?')">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
<a href="{{ route('questions.index') }}">Back to Questions</a>
