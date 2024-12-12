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
                        postId: postId,
                        type : "Quiz",
                        temp : "temp"
                    },
                    success: function (response) {
                        console.log(response);
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

    let files = [];

    $('.file-id').each(function () {
        // Get the text content of the element and push it into the array
        files.push($(this).text().trim());
    });

    $(document).on('click', '.delete-btn', function (event) {
        event.preventDefault();
        // console.log("Deleting");
        console.table(files);

        let type = $("#content-type").text();
        const urlParams = new URLSearchParams(window.location.search);
        const classCode = urlParams.get('class');
        const postId = urlParams.get('post');

        Swal.fire({
            title: 'Deleting...',
            text: 'Please wait while we delete the file.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        // console.log(type);
        $.ajax({
            url: 'includes/delete-post.php',  // PHP script to handle form submission
            type: 'POST',
            data: {
                files : files,
                classCode : classCode,
                postId : postId,
                type : type
            }, 
            success: function(response) {

                if($(".post-id").text() != "" || $(".post-id").text() != null){
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'Your file has been successfully deleted.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });

                }else{
                    Swal.fire({
                        title: 'Deleted!',
                        text: "Your file has been successfully deleted. Going Back To Class",
                        icon: 'success',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        showConfirmButton: false
                    })
                    setTimeout(function() {
                        window.location.href = `class.php?class=${classCode}`;
                    }, 3000);
    
                }
                // Swal.close();
  
                console.log(response);

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