<!DOCTYPE html>
<html>
<head>
    <title>Edit Question</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: #a0f3ce;
        }
        .card {
            border-radius: 15px;
        }
        .choice-input { margin-bottom: 5px; }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="card shadow-lg p-4 mx-auto" style="max-width: 800px;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="card-title mb-0">Edit Question</h1>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('questions.update', $question->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Question Text:</label>
                    <textarea name="question_text" class="form-control" rows="4">{{ $question->question_text }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Question Type:</label>
                    <select id="questionType" name="type_of_question" class="form-select" required>
                        <option value="">-- Select Type --</option>
                        <option value="multiple_choice" {{ $question->type_of_question == 'multiple_choice' ? 'selected' : '' }}>Multiple Choice (One answer)</option>
                        <option value="checkbox" {{ $question->type_of_question == 'checkbox' ? 'selected' : '' }}>Checkbox (Multiple answers)</option>
                        <option value="text" {{ $question->type_of_question == 'text' ? 'selected' : '' }}>Text (Open-ended)</option>
                    </select>
                </div>

         
                <div id="choicesContainer" style="display: none;" class="mb-3">
                    <label>Choices:</label>
                    <div id="choicesList">
                        @if($question->choices)
                            @foreach($question->choices as $choice)
                                <input type="text" name="choices[]" class="form-control choice-input mb-2" value="{{ $choice->choice_text }}">
                            @endforeach
                        @else
                            <input type="text" name="choices[]" class="form-control choice-input mb-2" placeholder="Enter choice">
                        @endif
                    </div>
                    <button type="button" id="addChoiceBtn" class="btn btn-sm btn-secondary mt-1">Add another choice</button>
                </div>

                <button type="submit" class="btn btn-success">Update Question</button>
                <a href="{{ route('questions.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const questionType = document.getElementById('questionType');
        const choicesContainer = document.getElementById('choicesContainer');
        const addChoiceBtn = document.getElementById('addChoiceBtn');
        const choicesList = document.getElementById('choicesList');

        function toggleChoices() {
            if(questionType.value === 'multiple_choice' || questionType.value === 'checkbox') {
                choicesContainer.style.display = 'block';
            } else {
                choicesContainer.style.display = 'none';
            }
        }

        toggleChoices();

        questionType.addEventListener('change', toggleChoices);

        addChoiceBtn.addEventListener('click', function() {
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'choices[]';
            input.className = 'form-control choice-input mb-2';
            input.placeholder = 'Enter choice';
            choicesList.appendChild(input);
        });
    </script>
</body>
</html>
