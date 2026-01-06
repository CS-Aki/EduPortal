$(document).ready(function () {

    let currentQuestion = 0; // Keep track of the current question
    const questions = document.querySelectorAll('.question-container');

    // Show the initial question and hide the rest
    questions.forEach((question, index) => {
        question.style.display = index === 0 ? 'block' : 'none';
    });

    document.getElementById('prevBtn').style.display = 'none'; // Hide "Previous" for the first question

    function changeQuestion(direction) {
        // Hide the current question
        questions[currentQuestion].style.display = 'none';

        // Update the current question index
        currentQuestion += direction;

        // Ensure the index stays within bounds
        if (currentQuestion < 0) {
            currentQuestion = 0;
        } else if (currentQuestion >= questions.length) {
            currentQuestion = questions.length - 1;
        }
        // console.log(currentQuestion);

        // Show the new current question
        questions[currentQuestion].style.display = 'block';

        // Update the display state of navigation buttons
        document.getElementById('prevBtn').style.display = currentQuestion === 0 ? 'none' : 'block';
        document.getElementById('nextBtn').style.display = currentQuestion === questions.length - 1 ? 'none' : 'block';
    }

    $(document).on('click', '#prevBtn', function (e) {
        e.preventDefault();
        $("#item-num").val(currentQuestion);
        changeQuestion(-1);

    });

    $(document).on('click', '#nextBtn', function (e) {
        e.preventDefault();
        changeQuestion(1);
        $("#item-num").val(currentQuestion + 1);
    });

    $(document).on('change', '#item-num', function (e) {
        e.preventDefault();
        console.log($(this).val() - currentQuestion);
        changeQuestion($(this).val() - (currentQuestion + 1));
    });

});