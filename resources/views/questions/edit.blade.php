<!DOCTYPE html>
<html>
<head>
    <title>Edit Question</title>
</head>
<body>
    <h1>Edit Question</h1>

    @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li style="color:red">{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('questions.update', $question->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label>Question Text:</label><br>
        <textarea name="question_text" rows="4" cols="50">{{ $question->question_text }}</textarea><br><br>
        <button type="submit">Update</button>
    </form>
</body>
</html>
