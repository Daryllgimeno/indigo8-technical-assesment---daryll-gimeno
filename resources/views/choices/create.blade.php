<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Choice for Question</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .form-control {
            border-radius: 5px;
        }
        .btn {
            font-size: 1rem;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="card shadow-lg p-4 mx-auto">
        <h1 class="card-title mb-4 text-center">Add Choice for Question: {{ $question->question_text }}</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('choices.store', $question->id) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="choice_text" class="form-label">Choice Text:</label>
                <input type="text" name="choice_text" id="choice_text" class="form-control" required>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Save Choice</button>
                <a href="{{ route('choices.index', $question->id) }}" class="btn btn-secondary">Back to Choices List</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
