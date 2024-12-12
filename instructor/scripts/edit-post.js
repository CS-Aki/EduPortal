$(document).ready(function() {

    $(document).off('click', '#uploadFile').on('click', '#uploadFile', function (event) {
        event.preventDefault(); // Prevent default link behavior
        console.log("Opening file selection interface");
        // Safely trigger file input click without causing a recursive loop
        $("#fileInput").trigger('click');
    });

    // $(document).on('click', '#uploadFile', function (event) {
    //     event.preventDefault();
    //     console.log("Upload File");
    // });

    
    $("#editPostModal").on("hidden.bs.modal", function () {
        $(".tempFile").remove();
    });

    $(document).on('change', '#fileInput', function (event) {
        $(".tempFile").remove();
          var fileCount = this.files.length;
          var files = event.target.files; 
          var size = 0;
          var word = "";
          $.each(files, function(index, file) {
            var temp = file.size;
            // console.log(temp.toString().length);
            if(temp.toString().length >= 7 ){
                size = Math.ceil((file.size / (1024 * 1024)).toFixed(2));
                word = "MB";
            }else{
                size = Math.ceil((file.size / 1024).toFixed(2));
                word = "KB";
            }

            $("#fileContainer").append(`<a class="tempFile btn bg-body-tertiary shadow-elevation-dark-1 rounded-4 white-btn p-2 col-lg-4 col-md-12 col-sm-12 mb-1">
                                            <div class="d-flex justify-content-start ms-2 w-75">
                                                <div class="me-2 flex-shrink-0">
                                                    <i class="bi bi-file-earmark-text-fill green1 fs-2 p-0 m-0"></i>
                                                </div>
                                                <div class="text-truncate" style="min-width: 0; flex-grow: 1;">
                                                    <span class="green2 fw-bold mb-0 d-block text-truncate pe-lg-3 d-flex justify-content-start" style="max-width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${file.name}</span>
                                                    <span class="fw-light green2 fs-6 d-flex mt-0" id="material-size">${size} ${word}</span>
                                                </div>
                                            </div>
                                        </a>`);

            // $("#fileContainer").append(`
            //         <a class="btn bg-body-tertiary shadow-elevation-dark-1 rounded-4 me-2 pe-5">
            //             <div class="d-flex">
            //                 <div class="me-2">
            //                     <i class="bi bi-file-earmark-text-fill green1 fs-2 p-0 m-0"></i>
            //                 </div>
            //                 <div>
            //                     <span class="green2 fw-bold mb-0">${file.name}</span>
            //                     <span class="fw-light green2 fs-6 d-flex mt-0" id="material-size">${size} ${word}</span>
            //                 </div>
            //             </div>
            //         </a>
            // `);
 
            console.log('File name: ' + file.name);
            console.log('File type: ' + file.type);
            console.log('File size: ' + file.size + ' bytes');
            console.log('Converted File size: ' + size + " " + word);
          });
   });

   let initialTitle = $("#postTitle").val();
   let initialDesc = $("#postDesc").val();

   $("#editForm").submit(function (event) {
        console.log("Edit Files");
        event.preventDefault();

        const urlParams = new URLSearchParams(window.location.search);
        const classCode = urlParams.get('class');
        const postId = urlParams.get('post');

        // console.log(classCode);
        let title = $("#postTitle").val();
        let description = $("#postDesc").val();
        let type = $("#content-type").text();
        let startingDate = "";
        let startingTime = "";
        let deadlineDate = "";
        let deadlineTime = "";

        if(initialDesc == description && initialTitle == title && $("#fileInput")[0].files.length == 0){
            console.log("NO CHANGES");
            return;
        }

        let formData = new FormData();
        formData.append("classCode", classCode);
        formData.append("postId", postId);
        formData.append("title", title);
        formData.append("description", description);
        formData.append("startingDate", startingDate);
        formData.append("startingTime", startingTime);
        formData.append("deadlineDate", deadlineDate);
        formData.append("deadlineTime", deadlineTime);
        formData.append("type", type);


        if($("#fileInput")[0].files.length > 0){
            for (let i = 0; i < $("#fileInput")[0].files.length; i++) {
                // Append each file to the FormData object
                formData.append("files[]", $("#fileInput")[0].files[i]); 
            }

            Swal.fire({
                title: 'Uploading...',
                text: 'Please wait while we upload your file.',
                didOpen: () => {
                    Swal.showLoading();
                }
            });


            $.ajax({
                method: "POST",
                url: "includes/save-file-session.php",
                data: formData,
                processData: false,
                contentType: false,
        
                success: function (response) {
                    console.table("this is ",response);
                }
            });
        }

        $.ajax({
            url: 'includes/edit-post.php',  
            type: 'POST',
            data: formData, 
            processData: false,
            contentType: false,
            success: function(response) {
                // isQuizSubmitted = true;
                console.log(response);
                // Swal.close();
                // Swal.fire({
                //     title: 'Success!',
                //     text: "Edit Post Successfully",
                //     icon: 'success',
                // })

                $.ajax({
                    url: 'includes/view-post.php',  
                    type: 'POST',
                    data: {
                        postId : postId,
                        classCode : classCode,
                        fromEdit : "true"
                    }, 
                    success: function(response) {
                        // console.log(response);
                        // isQuizSubmitted = true;
                        // console.log(response);
                        // const data = JSON.parse(response);
                        // console.table(response);
                        $("#mat-dl-container").empty();
                        $("#fileContainer").empty();
                        
                        console.table(response);
                        response.forEach(element => {
                            $("#mat-dl-container").append(`<a href="https://drive.google.com/file/d/${element["google_drive_file_id"]}/view" target="_blank" class="btn bg-body-tertiary shadow-elevation-dark-1 rounded-4 white-btn p-2 col-lg-4 col-md-12 col-sm-12 mb-2">
                                                            <div class="d-flex justify-content-start ms-2">
                                                                <div class="me-2 flex-shrink-0">
                                                                    <i class="bi bi-file-earmark-text-fill green1 fs-2 p-0 m-0"></i>
                                                                </div>
                                                                <div class="text-truncate" style="min-width: 0; flex-grow: 1;">
                                                                    <span class="green2 fw-bold mb-0 d-block text-truncate pe-lg-3 d-flex justify-content-start" style="max-width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${element["file_name"]}</span>
                                                                    <span class="fw-light green2 fs-6 d-flex mt-0" id="material-size">${element["file_size"]}</span>
                                                                </div>
                                                            </div>
                                                        </a>`);
                        });

                        if($("#fileInput")[0].files.length > 0){
                            $('#uploadFile').after(`<a id="unsubmitFile" href="" class="btn bordergreen shadow-elevation-dark-1 rounded-4 white-btn p-2 col-lg-4 col-md-12 col-sm-12 mb-1">
                                                            <div class="d-flex justify-content-center align-items-center ms-2 w-75">
                                                                <div class="me-2 flex-shrink-0">
                                                                    <i class="bi bi-plus-lg green1 fs-2 p-0 m-0"></i>
                                                                </div>
                                                                <div class="text-truncate" style="min-width: 0; flex-grow: 1;">
                                                                    <span class="green2 fw-bold mb-0 fs-6 d-block text-truncate pe-lg-3 d-flex justify-content-start" style="max-width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Unsubmit Files</span>
                                                                </div>
                                                            </div>
                                                        </a>`);
                        }
                        displayFilesInModal();

                        $("#fileInput").val("");

                        $("#material-title").text(title);
                        $("#mat-desc-txt").text(description);

                        Swal.fire({
                            title: 'Success!',
                            text: "Edit Post Successfully",
                            icon: 'success',
                        })
                
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

   let files = [];

     $(document).on('click', '#unsubmitFile', function (event) {
        $('.file-id').each(function () {
            // Get the text content of the element and push it into the array
            console.log("pushing file");
            files.push($(this).text().trim());
        });

        event.preventDefault();
        console.log("unsubmit");

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

                Swal.fire({
                    title: 'Deleting...',
                    text: 'Please wait while we delete the file.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: 'includes/delete-file.php',  
                    type: 'POST',
                    data: {
                        files : files
                    }, 
                    success: function(response) {
                        
                        $("#mat-dl-container").empty();
                        $("#fileContainer").empty();
                        $('#unsubmitFile').remove();

                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Your file has been successfully deleted.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });

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

    displayFilesInModal();

    function displayFilesInModal(){
        const urlParams = new URLSearchParams(window.location.search);
        const classCode = urlParams.get('class');
        const postId = urlParams.get('post');
        // const fromEdit = "true";
        $.ajax({
            url: 'includes/view-post.php',  
            type: 'POST',
            data: {
                postId : postId,
                classCode : classCode,
                fromEdit : "true"
            }, 
            success: function(response) {

                // $("#mat-dl-container").empty();
                $("#fileContainer").empty();
                
                console.table(response);
           
                if(response != null){
                    response.forEach(element => {
                        $("#fileContainer").append(`<a href="https://drive.google.com/file/d/${element["google_drive_file_id"]}/view" target="_blank" class="btn bg-body-tertiary shadow-elevation-dark-1 rounded-4 white-btn p-2 col-lg-4 col-md-12 col-sm-12 mb-1">
                                                    <div class="file-id" hidden>${element["google_drive_file_id"]}</div>
                                                    <div class="d-flex justify-content-start ms-2 w-75">
                                                        <div class="me-2 flex-shrink-0">
                                                            <i class="bi bi-file-earmark-text-fill green1 fs-2 p-0 m-0"></i>
                                                        </div>
                                                        <div class="text-truncate" style="min-width: 0; flex-grow: 1;">
                                                            <span class="green2 fw-bold mb-0 d-block text-truncate pe-lg-3 d-flex justify-content-start" style="max-width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${element["file_name"]}</span>
                                                            <span class="fw-light green2 fs-6 d-flex mt-0" id="material-size">${element["file_size"]}</span>
                                                        </div>
                                                    </div>
                                                </a>`);
                    });
                }
        
            },
            error: function(xhr, status, error) {
            }
        });
    }

});