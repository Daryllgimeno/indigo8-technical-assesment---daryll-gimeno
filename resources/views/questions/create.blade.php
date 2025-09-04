<!DOCTYPE html>
<html>
<head>
    <title>Add Question</title>
    <style>
        .choice-input { margin-bottom: 5px; }
    </style>
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
        <textarea name="question_text" rows="4" cols="50">{{ old('question_text') }}</textarea><br><br>

     <label>Question Type:</label><br>
<select id="questionType" name="type_of_question" required>
    <option value="">-- Select Type --</option>
    <option value="multiple_choice" {{ old('type_of_question') == 'multiple_choice' ? 'selected' : '' }}>Multiple Choice (One answer)</option>
    <option value="checkbox" {{ old('type_of_question') == 'checkbox' ? 'selected' : '' }}>Checkbox (Multiple answers)</option>
    <option value="text" {{ old('type_of_question') == 'text' ? 'selected' : '' }}>Text (Open-ended)</option>
</select>













        
        <!-- Choices Section -->
        <div id="choicesContainer" style="display:none;">
            <label>Choices:</label><br>
            <div id="choicesList">
                <input type="text" name="choices[]" class="choice-input" placeholder="Enter choice">
            </div>
            <button type="button" id="addChoiceBtn">Add another choice</button><br><br>
        </div>

        <button type="submit">Save</button>
    </form>

    <script>
        const questionType = document.getElementById('questionType');
        const choicesContainer = document.getElementById('choicesContainer');
        const addChoiceBtn = document.getElementById('addChoiceBtn');
        const choicesList = document.getElementById('choicesList');

        questionType.addEventListener('change', function() {
            // Show choices input only for multiple_choice or checkbox
            if(this.value === 'multiple_choice' || this.value === 'checkbox') {
                choicesContainer.style.display = 'block';
            } else {
                choicesContainer.style.display = 'none';
            }
        });

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
