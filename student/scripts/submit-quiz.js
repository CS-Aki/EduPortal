$(document).ready(function () {
    let isQuizSubmitted = false;
    console.log("test");

    window.addEventListener('beforeunload', function (e) {
        if (!isQuizSubmitted) {
            e.preventDefault();
            e.returnValue = ''; 
        }
    });

    console.log("quiz");

    // Variables to capture URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const classCode = urlParams.get('class');
    const postId = urlParams.get('post');
    const attempt = urlParams.get('attempt');

    // Event listener to store answers in localStorage on input change
    $('#quiz-answer-form').on('change', function () {
        const formData = new FormData(document.getElementById('quiz-answer-form'));
        const answers = {};

        formData.forEach((value, key) => {
            answers[key] = value; // Collect question_id and answers
        });

        // Combine the answers with URL parameters for unique identification
        const quizData = {
            class: classCode,
            post: postId,
            attempt: attempt,
            answers: answers
        };

        // Store data in localStorage with a unique key
        localStorage.setItem(`quiz_${classCode}_${postId}_${attempt}`, JSON.stringify(quizData));
        console.log("Saved to localStorage:", quizData);
    });

    // On page load, prefill the form with saved answers (if any)
    const savedData = localStorage.getItem(`quiz_${classCode}_${postId}_${attempt}`);
    if (savedData) {
        const parsedData = JSON.parse(savedData);
        Object.entries(parsedData.answers).forEach(([key, value]) => {
            const input = $(`[name="${key}"][value="${value}"]`);
            if (input.length) {
                input.prop("checked", true); // For radio buttons
            } else {
                const textInput = $(`[name="${key}"]`);
                if (textInput.length) textInput.val(value); // For text inputs
            }
        });
        console.log("Restored saved answers:", parsedData);
    }

    // Handle form submission
    $(document).on('submit', '#quiz-answer-form', function (e) {
        e.preventDefault();

        const formData = $('#quiz-answer-form').serialize();
        const date = $("#date").text();
        const time = $("#time").text();

        // Swal.fire({
        //     title: 'Submitting...',
        //     text: 'Please wait while we submit your answers.',
        //     didOpen: () => {
        //         Swal.showLoading();
        //     }
        // });
        console.log("Class code "   + classCode);
        console.log("Post id " + postId);

        const decryptPostId = $("#postIdValue").text();
        let decryptclassCode = $("#classCodeValue").text();

        $.ajax({
            url: 'student backend/includes/submit-quiz.php',
            type: 'POST',
            data: formData + `&postId=${decryptPostId}&classCode=${decryptclassCode}&attempt=${attempt}&date=${date}&time=${time}`,
            success: function (response) {
                isQuizSubmitted = true;
                console.log(response);

                // Remove saved answers from localStorage after successful submission
                localStorage.removeItem(`quiz_${classCode}_${postId}_${attempt}`);

                Swal.close();
                Swal.fire({
                    title: 'Success!',
                    text: "Quiz Submitted! Going To Quiz Result",
                    icon: 'success',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showConfirmButton: false
                });

                setTimeout(function () {
                    window.location.href = `quiz-result.php?class=${classCode}&post=${postId}&attempt=${attempt}`;
                }, 4000);
            },
            error: function (xhr, status, error) {
                Swal.close();
                console.log(error);
                Swal.fire({
                    title: 'Error!',
                    text: 'There was an error submitting the form.',
                    icon: 'error'
                });
            }
        });
    });
});
