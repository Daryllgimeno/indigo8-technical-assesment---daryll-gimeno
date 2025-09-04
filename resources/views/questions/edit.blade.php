<h1>Edit Question</h1>

<form action="{{ route('questions.update', $question->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div>
        <label for="question_text">Question Text:</label><br>
        <textarea name="question_text" id="question_text" rows="4" cols="50" required>{{ old('question_text', $question->question_text) }}</textarea>
    </div>
    <br>
    <div>
        <label for="question_type">Question Type:</label><br>
        <select name="question_type" id="question_type" required>
            <option value="">--Select Type--</option>
            <option value="radio" {{ old('question_type', $question->question_type) == 'radio' ? 'selected' : '' }}>Multiple Choice (Single Answer)</option>
            <option value="checkbox" {{ old('question_type', $question->question_type) == 'checkbox' ? 'selected' : '' }}>Multiple Choice (Multiple Answers)</option>
            <option value="text" {{ old('question_type', $question->question_type) == 'text' ? 'selected' : '' }}>Text / Open-ended</option>
        </select>
    </div>
    <br>

    <!-- Options div -->
    <div id="optionsDiv" style="display:none;">
        <label>Options:</label><br>
        <div id="optionsContainer">
            @if($question->options)
                @foreach($question->options as $index => $option)
                    <div class="option-item">
                        <input type="text" name="options[]" value="{{ old('options.'.$index, $option->option_text) }}" placeholder="Option {{ $index + 1 }}" required>
                        <button type="button" class="removeOptionBtn">Remove</button>
                    </div>
                @endforeach
            @else
                <div class="option-item">
                    <input type="text" name="options[]" placeholder="Option 1" required>
                    <button type="button" class="removeOptionBtn">Remove</button>
                </div>
            @endif
        </div>
        <button type="button" id="addOptionBtn">Add Another Option</button>
        <br><br>
    </div>

    <button type="submit">Update</button>
</form>

<a href="{{ route('questions.index') }}">Back</a>

<script>
const questionType = document.getElementById('question_type');
const optionsDiv = document.getElementById('optionsDiv');
const optionsContainer = document.getElementById('optionsContainer');
const addOptionBtn = document.getElementById('addOptionBtn');

// Show/hide optionsDiv based on question type
function toggleOptionsDiv() {
    if(questionType.value === 'radio' || questionType.value === 'checkbox') {
        optionsDiv.style.display = '';
    } else {
        optionsDiv.style.display = 'none';
    }
}

// Initial check
toggleOptionsDiv();

questionType.addEventListener('change', toggleOptionsDiv);

// Add new option
let optionCount = optionsContainer.querySelectorAll('input').length;
addOptionBtn.addEventListener('click', () => {
    optionCount++;
    const optionDiv = document.createElement('div');
    optionDiv.className = 'option-item';

    const input = document.createElement('input');
    input.type = 'text';
    input.name = 'options[]';
    input.placeholder = 'Option ' + optionCount;
    input.required = true;

    const removeBtn = document.createElement('button');
    removeBtn.type = 'button';
    removeBtn.className = 'removeOptionBtn';
    removeBtn.textContent = 'Remove';
    removeBtn.addEventListener('click', () => optionDiv.remove());

    optionDiv.appendChild(input);
    optionDiv.appendChild(removeBtn);
    optionsContainer.appendChild(optionDiv);
});


document.querySelectorAll('.removeOptionBtn').forEach(btn => {
    btn.addEventListener('click', function() {
        this.parentElement.remove();
    });
});
</script>
