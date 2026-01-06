$(document).ready(function () {
    let files = [];

    $('.file-id').each(function () {
        // Get the text content of the element and push it into the array
        files.push($(this).text().trim());
    });

    console.table(files);
    // console.log($(".file-id").length);
    $(document).on('click', '#unsubmitFile', function (e) {
        console.log("unsubmt");
        console.log($(this).find(".file-id").text());
        Swal.fire({
            title: "Unsubmit Files?",
            text: "Files will be deleted upon continuing",
            icon: "warning", // Use "icon" instead of "type"
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, continue",
            cancelButtonText: "No, I want to keep my files",
        }).then((result) => {
            if (result.isConfirmed) {
                
                $(".act-status").empty();
                console.log("removing dpost");
                
                Swal.fire({
                    title: 'Deleting...',
                    text: 'Please wait while we delete the file.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Swal.fire({
                //     title: 'Deleting...',
                //     text: 'Please wait while we delete the file.',
                //     allowOutsideClick: false,
                //     onBeforeOpen: () => {
                //         Swal.showLoading()
                //     }
                // });


                $.ajax({
                    url: 'student backend/includes/delete-file.php',  // PHP script to handle form submission
                    type: 'POST',
                    data: {
                        files : files
                    }, 
                    success: function(response) {

                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Your file has been successfully deleted.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                        
                    //    console.log(response);
 
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

                // User clicked "Yes"
                // Swal.fire(
                //     'Continued!',
                //     'You chose to continue.',
                //     'success'
                // );

                // Place your jQuery code here that you want to execute on confirmation
                // Example:
                // $('#someElement').fadeOut();

            } else if (result.dismiss === Swal.DismissReason.cancel) {
                // User clicked "No"
                console.table(files);

                Swal.fire(
                    'Cancelled',
                    'Files Retained!',
                    'info'
                );
            }
        });
    });
});
