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
    </style>
</head>
<body>
<div class="container py-5">
    <div class="card shadow-lg p-4 mx-auto" style="max-width: 800px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="card-title mb-0">List of Questions</h1>
          
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addQuestionModal">
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
                          
                            <button class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#editQuestionModal{{ $question->id }}">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>

                            <form action="{{ route('questions.destroy', $question->id) }}" method="POST" class="me-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash3"></i> Delete
                                </button>
                            </form>

                          
@if(in_array($question->type_of_question, ['multiple_choice', 'checkbox']))
    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#manageChoicesModal{{ $question->id }}">
        <i class="bi bi-list-check"></i> Manage Choices
    </button>
@endif

{{-- Manage Choices Modal --}}
<div class="modal fade" id="manageChoicesModal{{ $question->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('choices.updateForQuestion', $question->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">Manage Choices for Question: "{{ $question->question_text }}"</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="choicesList">
                        @foreach($question->choices as $choice)
                            <div class="input-group mb-2">
                                <input type="text" name="choices[{{ $choice->id }}]" 
                                       class="form-control" 
                                       value="{{ $choice->choice_text }}">
                                <button type="button" class="btn btn-danger removeChoiceBtn">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>

                    <button type="button" class="btn btn-sm btn-secondary addChoiceBtn">
                        Add another choice
                    </button>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save Choices</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

                        </div>
                    </li>

                  
                    <div class="modal fade" id="editQuestionModal{{ $question->id }}" tabindex="-1" aria-labelledby="editQuestionLabel{{ $question->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form class="editQuestionForm" action="{{ route('questions.update', $question->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editQuestionLabel{{ $question->id }}">Edit Question</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Question Text:</label>
                                            <textarea name="question_text" class="form-control" rows="4">{{ $question->question_text }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Question Type:</label>
                                            <select class="form-select questionTypeEditModal" name="type_of_question" required>
                                                <option value="">-- Select Type --</option>
                                                <option value="multiple_choice" {{ $question->type_of_question == 'multiple_choice' ? 'selected' : '' }}>Multiple Choice</option>
                                                <option value="checkbox" {{ $question->type_of_question == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                                                <option value="text" {{ $question->type_of_question == 'text' ? 'selected' : '' }}>Text</option>
                                            </select>
                                        </div>

                                        <div class="choicesContainerEditModal mb-3" style="display: {{ in_array($question->type_of_question, ['multiple_choice','checkbox']) ? 'block' : 'none' }};">
                                            <label>Choices:</label>
                                            <div class="choicesListEditModal">
                                                @foreach($question->choices as $choice)
                                                    <input type="text" name="choices[]" class="form-control choice-input mb-2" value="{{ $choice->choice_text }}">
                                                @endforeach
                                            </div>
                                            <button type="button" class="btn btn-sm btn-secondary mt-1 addChoiceButtonEditModal">Add another choice</button>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Update Question</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                @endforeach
            </ul>
        @else
            <p class="text-center mt-3">No questions found. Please add a new question.</p>
        @endif
    </div>
</div>


<div class="modal fade" id="addQuestionModal" tabindex="-1" aria-labelledby="addQuestionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="addQuestionForm" action="{{ route('questions.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addQuestionLabel">Add Question</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Question Text:</label>
                        <textarea name="question_text" class="form-control" rows="4"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Question Type:</label>
                        <select id="questionTypeAddModal" name="type_of_question" class="form-select" required>
                            <option value="">-- Select Type --</option>
                            <option value="multiple_choice">Multiple Choice</option>
                            <option value="checkbox">Checkbox</option>
                            <option value="text">Text</option>
                        </select>
                    </div>

                    <div id="choicesContainerAddModal" style="display:none;" class="mb-3">
                        <label>Choices:</label>
                        <div id="choicesListAddModal">
                            <input type="text" name="choices[]" class="form-control choice-input mb-2" placeholder="Enter choice">
                        </div>
                        <button type="button" id="addChoiceButtonAddModal" class="btn btn-sm btn-secondary mt-1">Add another choice</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save Question</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    
    const addQuestionForm = document.getElementById('addQuestionForm');
    const questionTypeAddModal = document.getElementById('questionTypeAddModal');
    const choicesContainerAddModal = document.getElementById('choicesContainerAddModal');
    const choicesListAddModal = document.getElementById('choicesListAddModal');
    const addChoiceButtonAddModal = document.getElementById('addChoiceButtonAddModal');

    questionTypeAddModal.addEventListener('change', function() {
        choicesContainerAddModal.style.display = (this.value === 'multiple_choice' || this.value === 'checkbox') ? 'block' : 'none';
    });

    addChoiceButtonAddModal.addEventListener('click', function() {
        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'choices[]';
        input.className = 'form-control choice-input mb-2';
        input.placeholder = 'Enter choice';
        choicesListAddModal.appendChild(input);
    });

   
    addQuestionForm.addEventListener('submit', function(e) {
        let errors = [];

        const questionText = addQuestionForm.querySelector('textarea[name="question_text"]').value.trim();
        const questionType = questionTypeAddModal.value;

        if (!questionText) errors.push('Question text is required.');
        if (!questionType) errors.push('Question type is required.');

        if (questionType === 'multiple_choice' || questionType === 'checkbox') {
            const choiceInputs = choicesListAddModal.querySelectorAll('input[name="choices[]"]');
            const filledChoices = Array.from(choiceInputs).filter(input => input.value.trim() !== '');

            if (filledChoices.length === 0) {
                errors.push('At least one choice is required.');
            }

            choiceInputs.forEach((input, index) => {
                if (!input.value.trim()) {
                    errors.push(`Choice #${index + 1} cannot be empty.`);
                }
            });
        }

        if (errors.length > 0) {
            e.preventDefault();
            alert(errors.join("\n"));
        }
    });

    
    document.querySelectorAll('.editQuestionForm').forEach((form) => {
        const select = form.querySelector('.questionTypeEditModal');
        const choicesContainer = form.querySelector('.choicesContainerEditModal');
        const addChoiceBtn = form.querySelector('.addChoiceButtonEditModal');
        const choicesList = form.querySelector('.choicesListEditModal');

        select.addEventListener('change', function() {
            choicesContainer.style.display = (this.value === 'multiple_choice' || this.value === 'checkbox') ? 'block' : 'none';
        });

        addChoiceBtn.addEventListener('click', function() {
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'choices[]';
            input.className = 'form-control choice-input mb-2';
            input.placeholder = 'Enter choice';
            choicesList.appendChild(input);
        });

        form.addEventListener('submit', function(e) {
            let errors = [];
            const qText = form.querySelector('textarea[name="question_text"]').value.trim();
            const qType = select.value;

            if (!qText) errors.push('Question text is required.');
            if (!qType) errors.push('Question type is required.');

            if (qType === 'multiple_choice' || qType === 'checkbox') {
                const choiceInputs = choicesList.querySelectorAll('input[name="choices[]"]');
                const filled = Array.from(choiceInputs).filter(input => input.value.trim() !== '');
                if (filled.length === 0) errors.push('At least one choice is required.');
                choiceInputs.forEach((input, i) => {
                    if (!input.value.trim()) errors.push(`Choice #${i+1} cannot be empty.`);
                });
            }

            if (errors.length > 0) {
                e.preventDefault();
                alert(errors.join("\n"));
            }
        });
    });


    document.addEventListener("DOMContentLoaded", function() {
         const alertNotification = document.querySelector('.alert-success');
    if (alertNotification) {
    
        setTimeout(() => {
            const autoDismissible = bootstrap.Alert.getOrCreateInstance(alertNotification);
            autoDismissible.close();
        }, 2000); 

        
        setTimeout(() => {
            location.reload();
        }, 2200); 
    }
  
    document.querySelectorAll('.addChoiceBtn').forEach(button => {
        button.addEventListener('click', function() {
            const container = this.closest('.modal-body').querySelector('.choicesList');
            const div = document.createElement('div');
            div.className = "input-group mb-2";
            div.innerHTML = `
                <input type="text" name="new_choices[]" class="form-control" placeholder="New choice">
                <button type="button" class="btn btn-danger removeChoiceBtn"><i class="bi bi-trash"></i></button>
            `;
            container.appendChild(div);

            div.querySelector('.removeChoiceBtn').addEventListener('click', function() {
                div.remove();
            });
        });
    });


    document.querySelectorAll('.removeChoiceBtn').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('.input-group').remove();
        });
    });
});
</script>
</body>
</html>
