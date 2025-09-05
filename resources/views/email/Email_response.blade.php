<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey Response</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212; 
            color: #b3b3b3; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card {
            border-radius: 12px;
            max-width: 600px;
            margin: 40px auto;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            background-color: #1c1c1c; 
            color: #fff;
        }
        h2 {
            color: #1DB954; 
            text-align: center;
            margin-bottom: 20px;
            font-weight: 700;
            font-size: 2rem;
        }
        .list-group-item {
            font-size: 1.2rem;
            padding: 15px;
            border: none;
            border-bottom: 1px solid #333;
            background-color: #222; 
            color: #b3b3b3;
        }
        .question-label {
            font-weight: 600;
            color: #fff;
            font-size: 1.1rem;
        }
        .answer {
            color: #b3b3b3;
            font-size: 1rem;
            margin-top: 8px;
        }
        .badge {
            background-color: #1DB954;
            color: white;
            padding: 5px 12px;
            border-radius: 12px;
            font-size: 1rem;
            margin-right: 10px;
        }
        .text-muted {
            color: #aaa !important;
        }
        .footer {
            text-align: center;
            font-size: 1rem;
            color: #b3b3b3;
            margin-top: 30px;
        }
    </style>
</head>
<body>

<div class="card">
    <h2>Survey Finished</h2>
    <p class="text-center text-muted mb-4">Here’s a quick review of your answers:</p>

    <ul class="list-group">
        @foreach($responses as $question => $answer)
            <li class="list-group-item d-flex justify-content-between">
                <div>
                    <span class="badge">{{ $loop->iteration }}</span>
                    <span class="question-label">{{ $question }}:</span>
                </div>
                <div class="answer">
                    @if(is_array($answer))
                        {{ implode(', ', $answer) }}
                    @else
                        {{ $answer }}
                    @endif
                </div>
            </li>
        @endforeach
    </ul>

    <div class="footer">
        <p>Your responses have been successfully recorded.</p>
    </div>
</div>

</body>
</html>
