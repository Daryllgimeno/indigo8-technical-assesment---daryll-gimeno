<script>
document.addEventListener('DOMContentLoaded', function () {
    let currentQuestion = 0;
    const questions = document.querySelectorAll('.question');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const submitBtn = document.getElementById('submitBtn');

    function showQuestion(n) {
        if (questions.length === 0) return; // prevent errors if no questions

        questions.forEach(q => q.classList.remove('active'));
        questions[n].classList.add('active');

        prevBtn.style.display = n === 0 ? 'none' : 'inline';
        nextBtn.style.display = n === questions.length - 1 ? 'none' : 'inline';
        submitBtn.style.display = n === questions.length - 1 ? 'inline' : 'none';
    }

    function nextPrev(n) {
        currentQuestion += n;
        if (currentQuestion >= questions.length) currentQuestion = questions.length - 1;
        if (currentQuestion < 0) currentQuestion = 0;
        showQuestion(currentQuestion);
    }

    if (questions.length > 0) {
        showQuestion(currentQuestion);
    }

    window.nextPrev = nextPrev; 
});
</script>
