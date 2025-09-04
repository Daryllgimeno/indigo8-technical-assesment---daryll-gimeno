<!DOCTYPE html>
<html>
<head>
    <title>Add / Edit Choices</title>
    <style>
        .choice-input { margin-bottom: 5px; display: inline-block; width: 300px; }
        .choice-item { margin-bottom: 5px; }
        .remove-btn { margin-left: 5px; }
        button { margin-top: 10px; }
    </style>
</head>
<body>
    <h1>Add / Edit Choices for: {{ $question->question_text }}</h1>

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
            {{-- Existing choices --}}
            @foreach($question->choices as $existingChoice)
                <div class="choice-item">
                    <input type="text" name="existing_choices[{{ $existingChoice->id }}]" class="choice-input" value="{{ $existingChoice->choice_text }}">
                    <button type="button" class="remove-btn" onclick="removeChoice(this)">Remove</button>
                </div>
            @endforeach

            {{-- New blank choice input --}}
            <div class="choice-item">
                <input type="text" name="choices[]" class="choice-input" placeholder="Enter new choice">
            </div>
        </div>

        <button type="button" id="addChoiceBtn">Add another choice</button><br><br>
        <button type="submit">Save Choices</button>
    </form>

    <script>
        const addChoiceBtn = document.getElementById('addChoiceBtn');
        const choicesList = document.getElementById('choicesList');

        // Add new blank input
        addChoiceBtn.addEventListener('click', function() {
            const div = document.createElement('div');
            div.className = 'choice-item';

            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'choices[]';
            input.className = 'choice-input';
            input.placeholder = 'Enter new choice';

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'remove-btn';
            removeBtn.textContent = 'Remove';
            removeBtn.onclick = function() { removeChoice(removeBtn); };

            div.appendChild(input);
            div.appendChild(removeBtn);
            choicesList.appendChild(div);
        });

        // Remove choice row
        function removeChoice(button) {
            button.parentElement.remove();
        }
    </script>
</body>
</html>
