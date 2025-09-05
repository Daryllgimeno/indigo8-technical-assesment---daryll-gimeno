<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choices for Question</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .btn {
            font-size: 0.9rem;
        }
        .alert {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="card shadow-lg p-4 mx-auto">
        <h1 class="card-title mb-4 text-center">Choices for: {{ $question->question_text }}</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="text-end mb-3">
            <a href="{{ route('choices.create', $question->id) }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> Add Choice
            </a>
        </div>

        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>Choice</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($question->choices as $index => $choice)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $choice->choice_text }}</td>
                        <td>
                            <a href="{{ route('choices.edit', [$question->id, $choice->id]) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="{{ route('choices.destroy', [$question->id, $choice->id]) }}" method="POST" style="display:inline;" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this choice?')">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4 text-center">
            <a href="{{ route('questions.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle"></i> Back to Questions
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.min.js"></script>
</body>
</html>
