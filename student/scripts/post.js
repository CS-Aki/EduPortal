

$(document).ready(function() {
    // console.log(io);
    console.log("test");

    // console.log("This is the ", $("#token").val().length);
    // // let hide = true;
    //   const socket = io("https://eduportal-wgrc.onrender.com", {
    //     transports: ["websocket"] // Ensure WebSocket transport
    //   });
    
    //   socket.on('connect_error', (err) => {
    //       console.error("Connection error:", err);
    //   });
    
    //   socket.on('connect', () => {
    //     console.log('Connected to Socket.IO server');
    //   });

    // var selectedValue = "material";

    // $('#contentType').on('change', function() {
    //     selectedValue = $(this).val();
    //     console.log(selectedValue);
    //     title = $('#title').val();
    //     desc = $('#description').val();
    //     date = $('#deadlineDate').val();
    //     time = $('timeContainer').val();
       
    //     if(selectedValue == "material"){
    //         $(".sub-title").text("Create Material");
    //         $("#dateContainer").find('#deadlineDate').prop('required', false);
    //         $("#timeContainer").find('#deadlineTime').prop('required', false);
    //         $("#dateContainer").hide();
    //         $("#timeContainer").hide();
    //         $("#uploadContainer").show();
    //     }else if(selectedValue == "quiz"){
    //         $(".sub-title").text("Create Quiz");
    //         $("#dateContainer").removeAttr("hidden");
    //         $("#timeContainer").removeAttr("hidden");
    //         $("#dateContainer").show();
    //         $("#timeContainer").show();
    //         $("#uploadContainer").hide();
    //     }else{
    //         $(".sub-title").text("Create Activity");
    //         $("#dateContainer").removeAttr("hidden");
    //         $("#timeContainer").removeAttr("hidden");
    //         $("#dateContainer").show();
    //         $("#timeContainer").show();
    //         $("#uploadContainer").show();
    //     }
    // });

   $(document).off('click', '#uploadLink').on('click', '#uploadLink', function (event) {
        event.preventDefault(); // Prevent default link behavior
        console.log("Opening file selection interface");

        // Safely trigger file input click without causing a recursive loop
        $("#fileInput").trigger('click');
    });

    window.onerror = function (message, source, lineno, colno, error) {
        console.error("Global Error Caught:", message, "at", source, "line:", lineno, "column:", colno);
    };

    $(document).on('change', '#fileInput', function (event) {
        $("#fileContainer").empty();
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

            $("#fileContainer").append(`
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

    $("#formSubmit").click(function (event) {
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
                            // const data = JSON.parse(response);
        
                            // console.log( "Selected "+ selectedValue);
                            // console.log("Title " + title);
                                    
                            // socket.emit("serverRcvPost", data);
                            $(".form-message").append("<div class='alert alert-success' role='alert'><span>POST SUCCESS</span></div>");
                            $('#title').val("");
                            $('#description').val("");
                            $('#fileInput').empty();
                            $("#fileCount").empty();
                            $("#fileContainer").empty();
                        },
                        error: function (xhr, status, error) {
                            console.error("Error:", status, error);
                            console.error("Response Text:", xhr.responseText);
                        }
                    });
                }
            });


        }else{
            console.log("uploading iwthout file");
            
        }
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


