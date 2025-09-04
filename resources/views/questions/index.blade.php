<!DOCTYPE html>
<html>
<head>
    <title>List of Questions</title>
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: #a0f3ce;
        }
        .card {
            border-radius: 15px;
        }
        .action-buttons form {
            display: inline-block;
        }
        .action-buttons a,
        .action-buttons button {
            display: inline-flex;
            align-items: center;
        }
        .action-buttons i {
            margin-right: 4px;
        }
        .question-number {
            font-weight: bold;
            width: 30px;
        }
        .question-info {
            font-size: 0.85rem;
            color: #555;
            margin-left: 16px; 
            font-weight: 500;
        }
        .question-header {
            font-size: 0.9rem;
            color: #333;
            font-weight: bold;
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="card shadow-lg p-4 mx-auto" style="max-width: 800px;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="card-title mb-0">List of Questions</h1>
                <a href="{{ route('questions.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-square"></i> Add New Question
                </a>
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
</body>
</html>
