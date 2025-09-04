<h1>Add Question</h1>

@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('success'))
    <div style="color:green;">
        {{ session('success') }}
    </div>
@endif

<h1>Add Question</h1>

<form action="{{ route('questions.store') }}" method="POST">
    @csrf
    <div>
        <label for="question_text">Question Text:</label><br>
        <textarea name="question_text" id="question_text" rows="4" cols="50" required>{{ old('question_text') }}</textarea>
    </div>
    <br>
    <div>
        <label for="question_type">Question Type:</label><br>
        <select name="question_type" id="question_type">
            <option value="radio">Multiple Choice (Single Answer)</option>
            <option value="checkbox">Multiple Choice (Multiple Answers)</option>
            <option value="text">Text / Open-ended</option>
        </select>
    </div>
    <br>
    <button type="submit">Save</button>
</form>


<br>
<a href="{{ route('questions.index') }}">Back to Questions</a>
