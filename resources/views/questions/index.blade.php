<!DOCTYPE html>
<html>
<head>
    <title>List of Question</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f0f4f8;
        }
        .card {
            border-radius: 15px;
        }
        .action-buttons form {
            display: inline-block;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="card shadow-lg p-4 mx-auto" style="max-width: 800px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="card-title mb-0">List of Question</h1>
            <a href="{{ route('questions.create') }}" class="btn btn-success">Add New Question</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($questions->count())
            <ul class="list-group">
                @foreach($questions as $question)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            {{ $question->question_text }}
                        </div>
                        <div class="action-buttons">
                            <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('questions.destroy', $question->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                            <a href="{{ route('choices.index', $question->id) }}" class="btn btn-sm btn-info">Manage Choices</a>
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
