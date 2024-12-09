$(document).ready(function() {

    let isQuizSubmitted = false;
    // console.log("test");
    window.addEventListener('beforeunload', function (e) {
        if (!isQuizSubmitted) {
            e.preventDefault();
            e.returnValue = ''; // Required for modern browsers
        }
    });

    $(document).on('submit', '#quiz-answer-form', function (e) {
        e.preventDefault();

        var formData = $('#quiz-answer-form').serialize(); 
        let postId = $("#postIdValue").text();
        let classCode = $("#classCodeValue").text();
        let searchParams = new URLSearchParams(window.location.search);
        let attempt = searchParams.get('attempt');
        let date = $("#date").text();
        let time = $("#time").text();

        const urlParams = new URLSearchParams(window.location.search);
        const code = urlParams.get('class');
        const id = urlParams.get('post');
        const tempAttempt = urlParams.get('attempt');
        // const classCode = urlParams.get('class');
        // attempt += 1;
        // console.log(attempt);

        console.log(postId);
        console.log(classCode);
        // console.log($("#postIdValue").text());
        // console.log($("#classCodeValue").text());
        Swal.fire({
            title: 'Submitting...',
            text: 'Please wait while we submit your answers.',
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: 'student backend/includes/submit-quiz.php',  // PHP script to handle form submission
            type: 'POST',
            data: formData + `&postId=${postId}&classCode=${classCode}&attempt=${attempt}&date=${date}&time=${time}`, // Append extra data
            success: function(response) {
                isQuizSubmitted = true;
                console.log(response);
                Swal.close();
                Swal.fire({
                    title: 'Success!',
                    text: "Quiz Submitted! Going To Quiz Result",
                    icon: 'success',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showConfirmButton: false
                })
                setTimeout(function() {
                    window.location.href = `quiz-result.php?class=${code}&post=${id}&attempt=${tempAttempt}`;
                }, 4000);
             
            },
            error: function(xhr, status, error) {
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