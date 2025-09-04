<h1>Create Question</h1>

<form action="{{ route('questions.store') }}" method="POST">
    @csrf

    <!-- Question Text -->
    <div>
        <label for="question_text">Question Text:</label><br>
        <textarea name="question_text" id="question_text" rows="4" cols="50" required>{{ old('question_text') }}</textarea>
    </div>
    <br>

    <!-- Question Type -->
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

    <!-- Options (initially hidden) -->
    <div id="optionsDiv" style="display:none;">
        <label>Options:</label><br>
        <div id="optionsContainer">
            <!-- No required by default -->
            <input type="text" name="options[]" placeholder="Option 1"><br>
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

let optionCount = 1;

// Show/hide optionsDiv based on question type
questionType.addEventListener('change', () => {
    if(questionType.value === 'radio' || questionType.value === 'checkbox') {
        optionsDiv.style.display = '';

        // Make all visible inputs required
        optionsContainer.querySelectorAll('input').forEach(input => input.required = true);
    } else {
        optionsDiv.style.display = 'none';

        // Remove required from inputs when hidden
        optionsContainer.querySelectorAll('input').forEach(input => input.required = false);
    }
});

// Add new option dynamically
addOptionBtn.addEventListener('click', () => {
    optionCount++;
    const optionDiv = document.createElement('div');

    const input = document.createElement('input');
    input.type = 'text';
    input.name = 'options[]';
    input.placeholder = 'Option ' + optionCount;
    input.required = questionType.value === 'radio' || questionType.value === 'checkbox'; // only required if visible

    const removeBtn = document.createElement('button');
    removeBtn.type = 'button';
    removeBtn.textContent = 'Remove';
    removeBtn.addEventListener('click', () => optionDiv.remove());

    optionDiv.appendChild(input);
    optionDiv.appendChild(removeBtn);
    optionsContainer.appendChild(optionDiv);
});
</script>
