$(document).ready(function () {

    $(document).on('click', '.delete-post', function (event) {
        event.preventDefault();
        let postId = $(this).closest("tr").find(".post-id").text();
        console.log(postId);
        let element = $(this);

        console.log("remove");

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to undo this action!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            reverseButtons: false
        }).then((result) => {
            if (result.isConfirmed) {
                // If the user confirms the deletion
                $.ajax({
                    url: "includes/delete-post.php",
                    type: "POST",
                    data: {
                        postId: postId // Send postId to the server
                    },
                    success: function (response) {
                        element.closest("tr").empty();
                        element.closest("tr").remove();
                        // var date = new Date();
                        Swal.fire(
                            'Deleted!',
                            'Your post has been deleted.',
                            'success'
                        );
                    },
                    error: function (xhr, status, error) {
                        console.log("Error:", status, error); // Debugging AJAX errors
                    },
                });
            } else {
                // If the user cancels the action
                Swal.fire(
                    'Cancelled',
                    'Your post is safe :)',
                    'error'
                );
            }
        });
    });


    // $('.delete-post').click(function(e) {
    //     e.preventDefault();
    //     let postId = $(this).closest("tr").find(".post-id").text();
    //     console.log(postId);

    //     $.ajax({
    //         url: "includes/delete-post.php",
    //         type: "POST",
    //         data: {
    //             postId : postId
    //         },
    //         success: function (response) {
    //             // $(this).closest(".quiz-cont").empty();
    //             $(this).closest(".quiz-cont").remove();
    //             // var date = new Date();
    //             alert("DELETE SUCCESS");
    //         },
    //         error: function (xhr, status, error) {
    //             console.log("Error:", status, error);
    //         },
    //     });

    // });
});