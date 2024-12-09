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
        // Swal.fire({
        //     title: 'Submitting...',
        //     text: 'Please wait while we submit your answers.',
        //     didOpen: () => {
        //         Swal.showLoading();
        //     }
        // });

        $.ajax({
            url: 'student backend/includes/submit-quiz.php',  // PHP script to handle form submission
            type: 'POST',
            data: formData + `&postId=${postId}&classCode=${classCode}&attempt=${attempt}`, // Append extra data
                // Send serialized form data
            success: function(response) {
                isQuizSubmitted = true;
                console.log(response);
                // Hide the loading screen
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
                // Handle the response from PHP (e.g., success message)
                setTimeout(function() {
                    window.location.href = `quiz-result.php?class=${code}&post=${id}&attempt=${tempAttempt}`;
                    // alert("This alert is delayed by 2 seconds!");
                }, 4000);
             
            },
            error: function(xhr, status, error) {
                // Hide the loading screen
                Swal.close();
                console.log(error);
                // Handle error
                Swal.fire({
                    title: 'Error!',
                    text: 'There was an error submitting the form.',
                    icon: 'error'
                });
            }
        });

    });
});