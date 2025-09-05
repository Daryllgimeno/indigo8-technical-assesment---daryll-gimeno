<!DOCTYPE html>
<html>
<head>
    <title>List of Questions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #a0f3ce; }
        .card { border-radius: 15px; }
        .action-buttons form { display: inline-block; }
        .action-buttons a, .action-buttons button { display: inline-flex; align-items: center; }
        .action-buttons i { margin-right: 4px; }
        .question-number { font-weight: bold; width: 30px; }
        .question-info { font-size: 0.85rem; color: #555; margin-left: 16px; font-weight: 500; }
        .question-header { font-size: 0.9rem; color: #333; font-weight: bold; margin-right: 8px; }
        .choice-input { margin-bottom: 5px; }
        .form-label { font-weight: bold; margin-top: 10px; }
        .btn-space { margin-right: 8px; }
        #choicesContainer { margin-top: 10px; }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="card shadow-lg p-4 mx-auto" style="max-width: 800px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="card-title mb-0">List of Questions</h1>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addQuestionModal">
                <i class="bi bi-plus-square"></i> Add New Question
            </button>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($questions->count())
            <ul class="list-group">
                @foreach($questions as $index => $question)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex flex-column">
                            <div class="d-flex align-items-center">
                                <span class="question-number">{{ $index + 1 }}.</span>
                                <span>{{ $question->question_text }}</span>
                            </div>
                            <div class="d-flex align-items-center mt-1">
                                <span class="question-header">Type of Question:</span>
                                <span class="question-info">{{ ucfirst($question->type_of_question) }}</span>
                            </div>
                        </div>

                        <div class="action-buttons">
                            <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-sm btn-warning me-2">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="{{ route('questions.destroy', $question->id) }}" method="POST" class="me-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash3"></i> Delete
                                </button>
                            </form>
                            <a href="{{ route('choices.index', $question->id) }}" class="btn btn-sm btn-info">
                                <i class="bi bi-list-check"></i> Manage Choices
                            </a>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-center mt-3">No questions found. Please add a new question.</p>
        @endif
    </div>
</div>

<!-- Add Question Modal -->
<div class="modal fade" id="addQuestionModal" tabindex="-1" aria-labelledby="addQuestionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="addQuestionForm" action="{{ route('questions.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Question</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
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

                    <label class="form-label">Question Text:</label>
                    <textarea name="question_text" class="form-control" rows="4">{{ old('question_text') }}</textarea>

                    <label class="form-label mt-3">Question Type:</label>
                    <select id="questionType" name="type_of_question" class="form-select" required>
                        <option value="">-- Select Type --</option>
                        <option value="multiple_choice" {{ old('type_of_question') == 'multiple_choice' ? 'selected' : '' }}>Multiple Choice (One answer)</option>
                        <option value="checkbox" {{ old('type_of_question') == 'checkbox' ? 'selected' : '' }}>Checkbox (Multiple answers)</option>
                        <option value="text" {{ old('type_of_question') == 'text' ? 'selected' : '' }}>Text (Open-ended)</option>
                    </select>

                    <div id="choicesContainer" style="display:none;">
                        <label class="form-label mt-3">Choices:</label>
                        <div id="choicesList">
                            <input type="text" name="choices[]" class="form-control choice-input" placeholder="Enter choice">
                        </div>
                        <button type="button" id="addChoiceBtn" class="btn btn-sm btn-secondary mt-2">Add another choice</button>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-space">
                        <i class="bi bi-check-circle"></i> Save
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
const addQuestionForm = document.getElementById('addQuestionForm');
const questionTextInput = addQuestionForm.querySelector('textarea[name="question_text"]');
const questionTypeSelect = addQuestionForm.querySelector('select[name="type_of_question"]');
const choicesContainer = document.getElementById('choicesContainer');
const choicesList = document.getElementById('choicesList');
const addChoiceBtn = document.getElementById('addChoiceBtn');

// Show/hide choices container based on question type
questionTypeSelect.addEventListener('change', function() {
    if(this.value === 'multiple_choice' || this.value === 'checkbox') {
        choicesContainer.style.display = 'block';
    } else {
        choicesContainer.style.display = 'none';
    }
});

// Add new choice input
addChoiceBtn.addEventListener('click', function() {
    const input = document.createElement('input');
    input.type = 'text';
    input.name = 'choices[]';
    input.className = 'form-control choice-input';
    input.placeholder = 'Enter choice';
    choicesList.appendChild(input);
});

// Validate before submit
addQuestionForm.addEventListener('submit', function(e) {
    let errors = [];

    if(questionTextInput.value.trim() === '') {
        errors.push('Question text is required.');
    }

    if(questionTypeSelect.value === '') {
        errors.push('Question type is required.');
    }

    if(questionTypeSelect.value === 'multiple_choice' || questionTypeSelect.value === 'checkbox') {
        const choiceInputs = choicesList.querySelectorAll('input[name="choices[]"]');
        const filledChoices = Array.from(choiceInputs).filter(input => input.value.trim() !== '');
        if(filledChoices.length === 0) {
            errors.push('At least one choice is required.');
        }

        choiceInputs.forEach((input, idx) => {
            if(input.value.trim() === '') {
                errors.push(`Choice #${idx + 1} cannot be empty.`);
            }
        });
    }

    if(errors.length > 0) {
        e.preventDefault();
        alert(errors.join('\n'));
    }
});
</script>
</body>
</html>
