<!DOCTYPE html>
<html>
<head>
    <title>Please Answer the Survey</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background: #9bc0f8;
        }
        .card {
            border-radius: 15px;
        }
        .question {
            display: none;
            transition: all 0.3s ease-in-out;
        }
        .question.active {
            display: block;
        }
        .progress {
            height: 8px;
        }
        .is-invalid {
            border-color: #dc3545 !important;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="card shadow-lg p-4 mx-auto" style="max-width: 700px;">
        <h1 class="card-title mb-4 text-center">Please Answer the Survey</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="progress mb-4">
            <div id="progressBar" class="progress-bar" role="progressbar" style="width:0%"></div>
        </div>

        <form id="surveyForm" action="{{ route('surveyform.submit') }}" method="POST">
            @csrf

            @foreach($questions as $index => $question)
                <div class="question {{ $index === 0 ? 'active' : '' }} mb-4 p-3 border rounded bg-white">
                    <h5>Question {{ $index + 1 }}: {{ $question->question_text }}</h5>

                    @if($question->type_of_question === 'text')
                        <input type="text" name="responses[{{ $question->id }}]" class="form-control mt-2">
                    @elseif($question->type_of_question === 'checkbox')
                        @foreach($question->choices as $choice)
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="responses[{{ $question->id }}][]" value="{{ $choice->id }}" id="choice_{{ $choice->id }}">
                                <label class="form-check-label" for="choice_{{ $choice->id }}">{{ $choice->choice_text }}</label>
                            </div>
                        @endforeach
                    @else
                        @foreach($question->choices as $choice)
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="radio" name="responses[{{ $question->id }}]" value="{{ $choice->id }}" id="choice_{{ $choice->id }}">
                                <label class="form-check-label" for="choice_{{ $choice->id }}">{{ $choice->choice_text }}</label>
                            </div>
                        @endforeach
                    @endif
                </div>
            @endforeach

            <div class="d-flex justify-content-between mt-3">
                <button type="button" id="PreviousButton" class="btn btn-secondary" onclick="nextPrev(-1)">Prev</button>
                <button type="button" id="NextButton" class="btn btn-success" onclick="nextPrev(1)">Next</button>
                <button type="submit" id="SubmitButton" class="btn btn-warning">Submit</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
   const alertNotification = document.querySelector('.alert');
if (alertNotification) {
    setTimeout(() => {
        const name = bootstrap.Alert.getOrCreateInstance(alertNotification);
        name.close();
    }, 2000); 
}
    let currentQuestion = 0;
    const questions = document.querySelectorAll('.question');
    const previousButton = document.getElementById('PreviousButton');
    const nextButton = document.getElementById('NextButton');
    const submitButton = document.getElementById('SubmitButton');
    const progressBar = document.getElementById('progressBar');

    function showQuestion(n) {
        questions.forEach(q => q.classList.remove('active'));
        questions[n].classList.add('active');

        previousButton.style.display = n === 0 ? 'none' : 'inline-block';
        nextButton.style.display = n === questions.length - 1 ? 'none' : 'inline-block';
        submitButton.classList.toggle('d-none', n !== questions.length - 1);

        progressBar.style.width = ((n + 1) / questions.length) * 100 + '%';
    }

    function validateQuestion(n) {
        const questionBlock = questions[n];
        const inputs = questionBlock.querySelectorAll('input');
        let answered = false;

        inputs.forEach(input => input.classList.remove('is-invalid'));

        for (let input of inputs) {
            if ((input.type === 'radio' || input.type === 'checkbox') && input.checked) {
                answered = true;
                break;
            }
            if (input.type === 'text' && input.value.trim() !== '') {
                answered = true;
                break;
            }
        }

        if (!answered) {
            inputs.forEach(input => input.classList.add('is-invalid'));
            return false;
        }

        return true;
    }

    window.nextPrev = function(n) {
        if (n === 1 && !validateQuestion(currentQuestion)) return;

        currentQuestion += n;
        currentQuestion = Math.max(0, Math.min(currentQuestion, questions.length - 1));
        showQuestion(currentQuestion);
    };

    document.getElementById('surveyForm').addEventListener('submit', function(e) {
        for (let i = 0; i < questions.length; i++) {
            if (!validateQuestion(i)) { 
                e.preventDefault(); 
                showQuestion(i); 
                return; 
            }
        }
    });

    if (questions.length > 0) showQuestion(currentQuestion);
    else { 
        previousButton.style.display = 'none'; 
        nextButton.style.display = 'none'; 
        submitButton.classList.add('d-none'); 
    }
});
</script>

</body>
</html>
