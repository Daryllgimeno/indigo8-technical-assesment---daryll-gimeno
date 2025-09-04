<h1>uestion</h1>

<form action="{{ route('questions.store') }}" method="POST">
    @csrf
    <div>
        <label for="question_text">Question Text:</label><br>
        <textarea name="question_text" id="question_text" rows="4" cols="50" required>{{ old('question_text') }}</textarea>
    </div>
    <br>
    <div>
        <label for="question_type">Question Type:</label><br>
        <select name="question_type" id="question_type" required>
            <option value="">--Select Type--</option>
            <option value="radio">Multiple Choice (Single Answer)</option>
            <option value="checkbox">Multiple Choice (Multiple Answers)</option>
            <option value="text">Text / Open-ended</option>
        </select>
    </div>
    <br>
    <!-- Options div, initially hidden -->
    <div id="optionsDiv" style="display:none;">
        <label>Options:</label><br>
        <div id="optionsContainer">
            <input type="text" name="options[]" placeholder="Option 1" required><br>
        </div>
        <button type="button" id="addOptionBtn">Add Another Option</button>
        <br><br>
    </div>

    <button type="submit">Save Question</button>
</form>

<script>
const questionType = document.getElementById('question_type');
const optionsDiv = document.getElementById('optionsDiv');
const optionsContainer = document.getElementById('optionsContainer');
const addOptionBtn = document.getElementById('addOptionBtn');

questionType.addEventListener('change', () => {
    if(questionType.value === 'radio' || questionType.value === 'checkbox') {
        optionsDiv.style.display = '';
    } else {
        optionsDiv.style.display = 'none';
    }
});

let optionCount = 1;
addOptionBtn.addEventListener('click', () => {
    optionCount++;
    const input = document.createElement('input');
    input.type = 'text';
    input.name = 'options[]';
    input.placeholder = 'Option ' + optionCount;
    input.required = true;
    optionsContainer.appendChild(input);
    optionsContainer.appendChild(document.createElement('br'));
});
</script>
