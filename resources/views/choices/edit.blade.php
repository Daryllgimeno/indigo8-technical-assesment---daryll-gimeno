<!DOCTYPE html>
<html>
<head>
    <title>Edit Choice</title>
</head>
<body>
    <h1>Edit Choice for: {{ $question->question_text }}</h1>

    @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li style="color:red">{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('choices.update', [$question->id, $choice->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <label>Choice Text:</label><br>
        <input type="text" name="choice_text" value="{{ $choice->choice_text }}"><br><br>
        <button type="submit">Update</button>
    </form>
</body>
</html>
