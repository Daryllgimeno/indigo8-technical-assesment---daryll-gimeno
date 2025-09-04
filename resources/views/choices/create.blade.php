<!DOCTYPE html>
<html>
<head>
    <title>Add Choice</title>
</head>
<body>
    <h1>Add Choice for: {{ $question->question_text }}</h1>

    @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li style="color:red">{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('choices.store', $question->id) }}" method="POST">
        @csrf
        <label>Choice Text:</label><br>
        <input type="text" name="choice_text"><br><br>
        <button type="submit">Save</button>
    </form>
</body>
</html>
