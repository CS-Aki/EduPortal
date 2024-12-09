

$(document).ready(function() {
    // console.log(io);
    console.log("test");
    
    function createUploadButton() {
        return `
            <a href="" id="uploadLink">
                <div class="container-fluid bg-white white-btn shadow-elevation-dark-1 rounded-3">
                    <div class="d-flex justify-content-start align-items-center text-center">
                        <div class="me-2">
                            <i class="bi bi-plus green1 fs-2 p-0 m-0"></i>
                        </div>
                        <div>
                            <span class="green2 fw-bold mb-0">Add or create</span>
                        </div>  
                    </div> 
                </div>
            </a>
        `;
    }
    
    function createSubmitButton() {
        return `
            <a href="#" id="formSubmit">
                <div class="container-fluid green shadow-elevation-dark-1 rounded-3">
                    <div class="d-flex justify-content-center align-items-center p-2">
                        <span class="submit-text white2 fw-semibold mb-0">Submit</span>
                    </div> 
                </div>
            </a>
        `;
    }
    
    function createFileElement(data) {
        return `
            <div id="${data.file_id}">
                <a href="https://drive.google.com/file/d/${data.google_drive_file_id}/view" target='_blank'>
                    <div class="file-id" hidden>${data.google_drive_file_id}</div>
                    <div class="container-fluid bg-white white-btn rounded-3 p-1 shadow-elevation-dark-1 mb-2">
                        <div class="d-flex justify-content-start">
                            <div class="me-2 ms-2">
                                <i class="bi bi-file-earmark-text-fill green1 fs-2 p-0 m-0"></i>
                            </div>
                            <div>
                                <span class="green2 fw-bold mb-0">${data.file_name}</span>
                                <span class="fw-light green2 fs-6 d-flex mt-0" id="material-size">${data.file_size}</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        `;
    }

    $(document).on('click', '#unsubmitFile', function () {
        console.log("Unsubmit button clicked.");
        console.log($(this).length + " is the length");

        if($(this).length == 1) return;
        // $("#fileContainer").empty(); // Clear file list
        // $("#add-container").empty(); // Clear buttons

        // // Append "Add or Create" and "Submit" buttons
        $("#add-container").append(createUploadButton());
        $("#add-container").append(createSubmitButton());
        // Perform unsubmit action here
    });
    
    // $(document).on('click', '#formSubmit', function () {
    //     console.log("Submit button clicked.");
    //     // Perform submit action here
    // });


   $(document).off('click', '#uploadLink').on('click', '#uploadLink', function (event) {
        event.preventDefault(); // Prevent default link behavior
        console.log("Opening file selection interface");

        // Safely trigger file input click without causing a recursive loop
        $("#fileInput").trigger('click');
    });

    $(document).on('change', '#fileInput', function (event) {
        $(".new-file").empty();
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
            // let fileName = "";
            
            var mimeType = file.type; // E.g., "image/png", "application/pdf"
            var fileExtension = mimeType.split('/').pop(); // Get the extension (e.g., "png", "pdf")
    
            // Shorten the file name if it's too long
            var fileName = "";
            if (file.name.length > 35) {
                fileName = file.name.substring(0, 15) + "..." + "." + fileExtension;
            } else {
                fileName = file.name;
            }

            $(".new-file").append(`
                <div class="fileCont">
                    <a>
                        <div class="container-fluid bg-white white-btn rounded-3 p-1 shadow-elevation-dark-1 mb-2" id="file">
                            <div class="d-flex justify-content-start">
                                <div class="me-2 ms-2">
                                    <i class="bi bi-file-earmark-text-fill green1 fs-2 p-0 m-0"></i>
                                </div>
                                <div>
                                    <span class="green2 fw-bold mb-0">${fileName}</span>
                                    <span class="fw-light green2 fs-6 d-flex mt-0" id="material-size">${size} ${word}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            `);
            
 
            // console.log('File name: ' + file.name);
            // console.log('File type: ' + file.type);
            // console.log('File size: ' + file.size + ' bytes');
            // console.log('Converted File size: ' + size + " " + word);
          });
  
          if (fileCount > 0) {
              $('#fileCount').text(fileCount + ' file(s) selected');
          } else {
              $('#fileCount').text('No files selected');
          }
   });

   let files = [];

   $(document).on('click', '#formSubmit', function () {
        console.log("clicked");
        event.preventDefault();

        $(".form-message").empty();

        // console.log("clicked");
        // if($("#token").val().length > 0){
        //     var hasToken = true;
        // }else{
        //     var hasToken = false;
        // }

        // var title = $('#title').val();
        // var desc = $('#description').val();
        // var date = $('#deadlineDate').val();
        // var time = $('#deadlineTime').val();

        const urlParams = new URLSearchParams(window.location.search);
        const classCode = urlParams.get('class');
    
        let formData = new FormData();
        formData.append("classCode", classCode);

        if($("#fileInput")[0].files.length > 0){
            for (let i = 0; i < $("#fileInput")[0].files.length; i++) {
                // Append each file to the FormData object
                formData.append("files[]", $("#fileInput")[0].files[i]); 
            }
        }

        // for (let pair of formData.entries()) {
        //     console.log(pair[0], pair[1]);
        // }

        // if(date == "" && selectedValue != "material"){
        //     $(".form-message").append("<div class='alert alert-danger' role='alert'><span>EMPTY DATE FIELDS</span></div>");
        //     return;
        // }

         console.log($("#fileInput")[0].files.length);

        // Handles file transfer to gdrive and upload to db
        if($("#fileInput")[0].files.length > 0){
            
            Swal.fire({
                title: 'Uploading...',
                text: 'Please wait while we upload your file.',
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                method: "POST",
                url: "student backend/includes/save-file-session.php",
                data: formData,
                processData: false,
                contentType: false,
        
                success: function (response) {
                    console.table("this is ",response);

                    $.ajax({
                        method: "POST",
                        url: "student backend/includes/upload-file.php",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            console.log(response);

                            // for (let [key, value] of formData.entries()) {
                            //     console.log(key, value);
             
                            // }
                            // const data = JSON.parse(response);
        
                            // console.log( "Selected "+ selectedValue);
                            // console.log("Title " + title);
                                    
                            // socket.emit("serverRcvPost", data);
                            $.ajax({
                                method: "POST",
                                url: "student backend/includes/view-post.php",
                                data: {
                                    displayFiles : "temp"
                                },
                                success: function (response) {
                                    console.log(response);

                                    Swal.fire({
                                        title: 'Success!',
                                        text: 'File uploaded successfully!',
                                        icon: 'success'
                                    });
                                    $("#fileContainer").empty();

                                    // $("#fileContainer").empty(); 
                                    console.log(response); 
                                    $(".fileCont").empty();
                                    const data = response; 
                                    // $(".new-file").empty();
                                    // createFileElement(data);
                                    data.forEach(file => {
                                        $("#fileContainer").append(createFileElement(file));
                                    });

                                    // for(let i = 0; i < data.length; i++){
                                    //     console.log(data[i]["file_name"]);
                                    //     $("#fileContainer").append(`
                                    //         <div id='${data[i]["file_id"]}'></div>
                                    //         <a href="https://drive.google.com/file/d/${data[i]["google_drive_file_id"]}/view" target='_blank'>
                                    //              <div class='file-id' hidden>${data[i]["google_drive_file_id"]}</div>
                                    //             <div class='container-fluid bg-white white-btn rounded-3 p-1 shadow-elevation-dark-1 mb-2'>
                                    //                 <div class='d-flex justify-content-start'>
                                    //                     <div class='me-2 ms-2'>
                                    //                         <i class='bi bi-file-earmark-text-fill green1 fs-2 p-0 m-0'></i>
                                    //                     </div>
                                    //                     <div>
                                    //                         <span class='green2 fw-bold mb-0'>${data[i]["file_name"]}</span>
                                    //                         <span class='fw-light green2 fs-6 d-flex mt-0' id='material-size'>${data[i]["file_size"]}</span>
                                    //                     </div>
                                    //                 </div>
                                    //             </div>
                                    //         </a>
                                    //     `);
                                    
                                    // }

                                      $("#add-container").empty(); // Clear buttons

                                        // Append "Unsubmit" button
                                        $("#add-container").append(`
                                            <a href="#" id="unsubmitFile">
                                                <div class="container-fluid green shadow-elevation-dark-1 rounded-3">
                                                    <div class="d-flex justify-content-center align-items-center p-2">
                                                        <span class="submit-text white2 fw-semibold mb-0">Unsubmit</span>
                                                    </div>
                                                </div>
                                            </a>
                                        `);

                                    
                              
                                    // console.log( "Selected "+ selectedValue);
                                    // console.log("Title " + title);
                                            
                                    // socket.emit("serverRcvPost", data);
                                    // $(".form-message").append("<div class='alert alert-success' role='alert'><span>POST SUCCESS</span></div>");
                                  
                                    // $('#title').val("");
                                    // $('#description').val("");
                                    // $('#fileInput').empty();
                                    // $("#fileCount").empty();
                                    // $("#fileContainer").empty();
                                },
                                error: function (xhr, status, error) {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'There was an error uploading the file.',
                                        icon: 'error'
                                    });
                                    console.error("Error:", status, error);
                                    console.error("Response Text:", xhr.responseText);
                                }
                            });
                            // $(".form-message").append("<div class='alert alert-success' role='alert'><span>POST SUCCESS</span></div>");
                            // $('#title').val("");
                            // $('#description').val("");
                            // $('#fileInput').empty();
                            // $("#fileCount").empty();
                            // $("#fileContainer").empty();
                        },
                        error: function (xhr, status, error) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'There was an error uploading the file.',
                                icon: 'error'
                            });
                            console.error("Error:", status, error);
                            console.error("Response Text:", xhr.responseText);
                        }
                    });
                }
            });


        }else{
            Swal.fire({
                title: 'No File Selected',
                text: 'Please choose a file before proceeding.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            
        }
    });

    console.log("File id size " + files.length);
    $(document).on('click', '#unsubmitFile', function (e) {
        $('.file-id').each(function () {
            // Get the text content of the element and push it into the array
            files.push($(this).text().trim());
        });
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
                        $("#fileContainer").empty();
                        $("#add-container").empty();
                        $("#add-container").append(createUploadButton());
                        $("#add-container").append(createSubmitButton());
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

    // $("#fileForm").submit(function (event) {
    //     event.preventDefault();
    //     console.log("inside post form");
    //     const urlParams = new URLSearchParams(window.location.search);
    //     const classCode = urlParams.get('class');
    
    //     let formData = new FormData();
    //     formData.append("classCode", classCode);
    //     if($("#fileInput")[0].files.length > 0){
    //         for (let i = 0; i < $("#fileInput")[0].files.length; i++) {
    //             // Append each file to the FormData object
    //             formData.append("files[]", $("#fileInput")[0].files[i]); 
    //         }
    //     }

    //     $.ajax({
    //         method: "POST",
    //         url: "includes/upload-file.php",
    //         data: formData,
    //         processData : false,
    //         contentType : false,
    
    //         success: function (response) {
    //             // console.log("this is response of ", response);
    //             console.log(response);
    //             // window.location.href = response;
    //         },
    //         error: function (xhr, status, error) {
    //             console.error("Error:", status, error);
    //             console.error("Response Text:", xhr.responseText);
    //         }
    //     });
    // });
});


