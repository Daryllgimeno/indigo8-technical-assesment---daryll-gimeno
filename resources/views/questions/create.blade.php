<!DOCTYPE html>
<html>
<head>
    <title>Add Question</title>
</head>
<body>
    <h1>Add Question</h1>

    @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li style="color:red">{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('questions.store') }}" method="POST">
        @csrf
        <label>Question Text:</label><br>
        <textarea name="question_text" rows="4" cols="50"></textarea><br><br>
        <button type="submit">Save</button>
    </form>
</body>
</html>
