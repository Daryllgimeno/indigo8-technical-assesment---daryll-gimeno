<h1>Survey</h1>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<form id="surveyForm" method="POST" action="{{ route('survey.submit') }}">
    @csrf
    @foreach($questions as $index => $question)
        <div class="question" style="{{ $index > 0 ? 'display:none;' : '' }}">
            <p><strong>Question {{ $index + 1 }}:</strong> {{ $question->question_text }}</p>

            @if($question->question_type === 'radio' || $question->question_type === 'checkbox')
                @foreach($question->options as $option)
                    <label>
                        <input 
                            type="{{ $question->question_type }}" 
                            name="answers[{{ $question->id }}]{{ $question->question_type === 'checkbox' ? '[]' : '' }}" 
                            value="{{ $option->id }}"
                        >
                        {{ $option->option_text }}
                    </label><br>
                @endforeach
            @elseif($question->question_type === 'text')
                <textarea name="answers[{{ $question->id }}]" rows="3" cols="50" placeholder="Your answer here"></textarea>
            @endif
        </div>
    @endforeach

    <br>
    <button type="button" id="prevBtn" style="display:none;">Prev</button>
    <button type="button" id="nextBtn">Next</button>
    <button type="submit" id="submitBtn" style="display:none;">Submit</button>
</form>

<script>
let current = 0;
const questions = document.querySelectorAll('.question');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');
const submitBtn = document.getElementById('submitBtn');

function showQuestion(index) {
    questions.forEach((q, i) => q.style.display = i === index ? '' : 'none');
    prevBtn.style.display = index === 0 ? 'none' : '';
    nextBtn.style.display = index === questions.length - 1 ? 'none' : '';
    submitBtn.style.display = index === questions.length - 1 ? '' : 'none';
}

showQuestion(current);

prevBtn.addEventListener('click', () => {
    if (current > 0) current--;
    showQuestion(current);
});

nextBtn.addEventListener('click', () => {
    if (current < questions.length - 1) current++;
    showQuestion(current);
});
</script>
