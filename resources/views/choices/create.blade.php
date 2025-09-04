<!DOCTYPE html>
<html>
<head>
    <title>Add Choices</title>
    <style>
        .choice-input { margin-bottom: 5px; display: block; }
        button { margin-top: 10px; }
    </style>
</head>
<body>
    <h1>Add Choices for: {{ $question->question_text }}</h1>

    @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li style="color:red">{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('choices.store', $question->id) }}" method="POST">
    @csrf

    <div id="choicesList">
        <input type="text" name="choices[]" class="choice-input" placeholder="Enter choice" value="{{ old('choices.0') }}">
    </div>

    <button type="button" id="addChoiceBtn">Add another choice</button><br><br>
    <button type="submit">Save Choices</button>
</form>


    <script>
     const addChoiceBtn = document.getElementById('addChoiceBtn');
const choicesList = document.getElementById('choicesList');

addChoiceBtn.addEventListener('click', function() {
    const input = document.createElement('input');
    input.type = 'text';
    input.name = 'choices[]';
    input.className = 'choice-input';
    input.placeholder = 'Enter choice';
    choicesList.appendChild(input);
});

    </script>
</body>
</html>
