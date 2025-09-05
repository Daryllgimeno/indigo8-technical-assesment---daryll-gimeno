<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Questions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        .alert {
            margin-bottom: 20px;
        }
        .question-list {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .question-item {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }
        .question-item:last-child {
            border-bottom: none;
        }
        .question-text {
            font-weight: bold;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }
        .action-buttons a,
        .action-buttons button {
            padding: 6px 12px;
            font-size: 0.9rem;
        }
        .form-control {
            border-radius: 5px;
        }
        .form-select {
            border-radius: 5px;
        }
        .center-select {
            display: flex;
            justify-content: center;
            margin-top: 15px;
        }
        .add-question-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
        }
        .choices-container {
            margin-top: 15px;
        }
        .choice-input {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <h1>List of Questions</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="question-list">
        @if($questions->count())
            @foreach($questions as $index => $question)
                <div class="question-item">
                    <div class="d-flex justify-content-between">
                        <div>
                            <span>{{ $index + 1 }}. </span>
                            <span class="question-text">{{ $question->question_text }}</span>
                        </div>
                        <div>
                            <span><strong>Type:</strong> {{ ucfirst($question->type_of_question) }}</span>
                        </div>
                    </div>

                    <div class="action-buttons mt-3">
                        <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-warning btn-sm">
                            Edit
                        </a>
                        <form action="{{ route('questions.destroy', $question->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                        @if($question->type_of_question !== 'text')
                            <a href="{{ route('choices.index', $question->id) }}" class="btn btn-info btn-sm">
                                Manage Choices
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <p>No questions found. Please add a new question.</p>
        @endif
    </div>

    <button class="btn btn-success add-question-btn" data-bs-toggle="modal" data-bs-target="#addQuestionModal">
        Add Question
    </button>

    <div class="modal fade" id="addQuestionModal" tabindex="-1" aria-labelledby="addQuestionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addQuestionModalLabel">Add Question</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addQuestionForm" action="{{ route('questions.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="question_text" class="form-label">Question Text:</label>
                            <textarea name="question_text" class="form-control" id="question_text" rows="3">{{ old('question_text') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="questionType" class="form-label">Question Type:</label>
                            <div class="center-select">
                                <select id="questionType" name="type_of_question" class="form-select" required>
                                    <option value="">-- Select Type --</option>
                                    <option value="multiple_choice" {{ old('type_of_question') == 'multiple_choice' ? 'selected' : '' }}>Multiple Choice</option>
                                    <option value="checkbox" {{ old('type_of_question') == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                                    <option value="text" {{ old('type_of_question') == 'text' ? 'selected' : '' }}>Text</option>
                                </select>
                            </div>
                        </div>

                        <div id="choicesContainer" class="choices-container" style="display: none;">
                            <label for="choices" class="form-label">Choices:</label>
                            <div id="choicesList">
                                <input type="text" name="choices[]" class="form-control choice-input" placeholder="Enter choice">
                            </div>
                            <button type="button" id="addChoiceBtn" class="btn btn-secondary btn-sm mt-2">Add another choice</button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const addQuestionForm = document.getElementById('addQuestionForm');
        const questionTextInput = addQuestionForm.querySelector('textarea[name="question_text"]');
        const questionTypeSelect = addQuestionForm.querySelector('select[name="type_of_question"]');
        const choicesContainer = document.getElementById('choicesContainer');
        const choicesList = document.getElementById('choicesList');
        const addChoiceBtn = document.getElementById('addChoiceBtn');

        questionTypeSelect.addEventListener('change', function() {
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
            input.className = 'form-control choice-input';
            input.placeholder = 'Enter choice';
            choicesList.appendChild(input);
        });

        addQuestionForm.addEventListener('submit', function(e) {
            let errors = [];

            if(questionTextInput.value.trim() === '') {
                errors.push('Question text is required.');
            }

            if(questionTypeSelect.value === '') {
                errors.push('Question type is required.');
            }

            if((questionTypeSelect.value === 'multiple_choice' || questionTypeSelect.value === 'checkbox') && choicesList.querySelectorAll('input[name="choices[]"]').length === 0) {
                errors.push('At least one choice is required.');
            }

            if(errors.length > 0) {
                e.preventDefault();
                alert(errors.join('\n'));
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
