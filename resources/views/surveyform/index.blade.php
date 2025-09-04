<!DOCTYPE html>
<html>
<head>
    <title>Survey Form</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="card shadow-sm p-4">
        <h1 class="card-title mb-4 text-center">Survey Form</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form id="surveyForm" action="{{ route('surveyform.submit') }}" method="POST">
            @csrf

            @foreach($questions as $index => $question)
                <div class="question mb-4 p-3 border rounded bg-white {{ $index == 0 ? '' : 'd-none' }}">
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

            <div class="d-flex justify-content-between">
                <button type="button" id="prevBtn" onclick="nextPrev(-1)" class="btn btn-secondary">Prev</button>
                <button type="button" id="nextBtn" onclick="nextPrev(1)" class="btn btn-primary">Next</button>
                <button type="submit" id="submitBtn" class="btn btn-success d-none">Submit</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let currentQuestion = 0;
    const questions = document.querySelectorAll('.question');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const submitBtn = document.getElementById('submitBtn');

    function showQuestion(n) {
        questions.forEach(q => q.classList.add('d-none'));
        questions[n].classList.remove('d-none');

        prevBtn.style.display = n === 0 ? 'none' : 'inline-block';
        nextBtn.style.display = n === questions.length - 1 ? 'none' : 'inline-block';
        submitBtn.classList.toggle('d-none', n !== questions.length - 1);
    }

    function validateQuestion(n) {
        const questionBlock = questions[n];
        const inputs = questionBlock.querySelectorAll('input');
        let answered = false;

        inputs.forEach(input => {
            if ((input.type === 'radio' || input.type === 'checkbox') && input.checked) answered = true;
            if (input.type === 'text' && input.value.trim() !== '') answered = true;
        });

        if (!answered) alert('Please answer this question before proceeding.');
        return answered;
    }

    window.nextPrev = function(n) {
        if (n === 1 && !validateQuestion(currentQuestion)) return;
        currentQuestion += n;
        currentQuestion = Math.max(0, Math.min(currentQuestion, questions.length - 1));
        showQuestion(currentQuestion);
    };

    document.getElementById('surveyForm').addEventListener('submit', function(e) {
        for (let i = 0; i < questions.length; i++) {
            if (!validateQuestion(i)) { e.preventDefault(); return; }
        }
    });

    if (questions.length > 0) showQuestion(currentQuestion);
    else { prevBtn.style.display = 'none'; nextBtn.style.display = 'none'; submitBtn.classList.add('d-none'); }
});
</script>

</body>
</html>
