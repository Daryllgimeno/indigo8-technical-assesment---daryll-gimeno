<!DOCTYPE html>
<html>
<head>
    <title>Survey Form</title>
    <style>
        .question { display: none; }
        .active { display: block; }
        .navigation { margin-top: 20px; }
    </style>
</head>
<body>
    <h1>Survey Form</h1>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <form id="surveyForm" action="{{ route('surveyform.submit') }}" method="POST">
        @csrf

        @foreach($questions as $index => $question)
            <div class="question {{ $index == 0 ? 'active' : '' }}">
                <h3>Question {{ $index + 1 }}: {{ $question->question_text }}</h3>

                @if($question->type_of_question === 'text')
                    <input type="text" name="responses[{{ $question->id }}]">
                @elseif($question->type_of_question === 'checkbox')
                    @foreach($question->choices as $choice)
                        <div>
                            <input type="checkbox" name="responses[{{ $question->id }}][]" value="{{ $choice->id }}" id="choice_{{ $choice->id }}">
                            <label for="choice_{{ $choice->id }}">{{ $choice->choice_text }}</label>
                        </div>
                    @endforeach
                @else
                    @foreach($question->choices as $choice)
                        <div>
                            <input type="radio" name="responses[{{ $question->id }}]" value="{{ $choice->id }}" id="choice_{{ $choice->id }}">
                            <label for="choice_{{ $choice->id }}">{{ $choice->choice_text }}</label>
                        </div>
                    @endforeach
                @endif
            </div>
        @endforeach

        <div class="navigation">
            <button type="button" id="prevBtn" onclick="nextPrev(-1)">Prev</button>
            <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
            <button type="submit" id="submitBtn" style="display:none;">Submit</button>
        </div>
    </form>

   <script>
document.addEventListener('DOMContentLoaded', function () {
    let currentQuestion = 0;
    const questions = document.querySelectorAll('.question');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const submitBtn = document.getElementById('submitBtn');

    function showQuestion(n) {
        questions.forEach(q => q.classList.remove('active'));
        questions[n].classList.add('active');

        prevBtn.style.display = n === 0 ? 'none' : 'inline';
        nextBtn.style.display = n === questions.length - 1 ? 'none' : 'inline';
        submitBtn.style.display = n === questions.length - 1 ? 'inline' : 'none';
    }

    function validateQuestion(n) {
        const questionBlock = questions[n];
        const inputs = questionBlock.querySelectorAll('input');
        let answered = false;

        inputs.forEach(input => {
            if ((input.type === 'radio' || input.type === 'checkbox') && input.checked) {
                answered = true;
            } else if (input.type === 'text' && input.value.trim() !== '') {
                answered = true;
            }
        });

        if (!answered) {
            alert('Please answer this question before proceeding.');
        }

        return answered;
    }

    window.nextPrev = function(n) {
        if (n === 1 && !validateQuestion(currentQuestion)) return;
        currentQuestion += n;
        if (currentQuestion >= questions.length) currentQuestion = questions.length - 1;
        if (currentQuestion < 0) currentQuestion = 0;
        showQuestion(currentQuestion);
    };

    document.getElementById('surveyForm').addEventListener('submit', function(e) {
        // Validate all questions before submitting
        for (let i = 0; i < questions.length; i++) {
            if (!validateQuestion(i)) {
                e.preventDefault();
                return;
            }
        }
    });

    if (questions.length > 0) showQuestion(currentQuestion);
    else {
        prevBtn.style.display = 'none';
        nextBtn.style.display = 'none';
        submitBtn.style.display = 'none';
    }
});
</script>

</body>
</html>
