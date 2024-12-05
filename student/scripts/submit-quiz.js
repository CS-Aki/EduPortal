$(document).ready(function() {
    $(document).on('submit', '#quiz-answer-form', function (e) {
        e.preventDefault();

        var formData = $('#quiz-answer-form').serialize(); 
        let postId = $("#postIdValue").text();
        let classCode = $("#classCodeValue").text();
        
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
            data: formData + `&postId=${postId}&classCode=${classCode}`, // Append extra data
                // Send serialized form data
            success: function(response) {
                console.log(response);
                // Hide the loading screen
                // Swal.close();
                // // Handle the response from PHP (e.g., success message)
                // Swal.fire({
                //     title: 'Success!',
                //     text: response,
                //     icon: 'success'
                // });
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