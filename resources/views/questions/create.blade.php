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

<form action="{{ route('questions.store') }}" method="POST">
    @csrf 
    <div>
        <label for="question_text">Question Text:</label><br>
        <textarea name="question_text" id="question_text" rows="4" cols="50" required>{{ old('question_text') }}</textarea>
    </div>
    <br>
    <button type="submit">Save</button>
</form>

<br>
<a href="{{ route('questions.index') }}">Back to Questions</a>
