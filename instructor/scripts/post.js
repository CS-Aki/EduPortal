

$(document).ready(function() {
    // console.log(io);
    console.log("test");

    // let searchParams = new URLSearchParams(window.location.search);
    // let classUrl = searchParams.get('class');
    // console.log(classUrl);

    // const socket = io('http://localhost:4000');
    console.log("This is the ", $("#token").val().length);
    // let hide = true;
      const socket = io("https://eduportal-wgrc.onrender.com", {
        transports: ["websocket"] // Ensure WebSocket transport
      });
    
      socket.on('connect_error', (err) => {
          console.error("Connection error:", err);
      });
    
      socket.on('connect', () => {
        console.log('Connected to Socket.IO server');
      });

    var selectedValue = "material";
    
    //   console.log("Content : " + $('#contentType').val());

    if($('#contentType').val() == "quiz"){
        console.log("inside");
        $(".sub-title").text("Create Quiz");
        $('#pointsContainer').removeAttr("hidden");
        $("#dateContainer").removeAttr("hidden");
        $("#timeContainer").removeAttr("hidden");
        $("#dateContainer").show();
        $("#timeContainer").show();
        $(".quiz-list-container").removeAttr("hidden");
        $(".quiz-list-container").show();
        $('#pointsContainer').show();
        $("#uploadContainer").hide();
    }

    $('#contentType').on('change', function() {
        selectedValue = $(this).val();
        console.log(selectedValue);
        title = $('#title').val();
        desc = $('#description').val();
        date = $('#deadlineDate').val();
        time = $('#timeContainer').val();
        $points = $('#pointsContainer');
        $attemptContainer = $("#attemptCont");
        // <div class="d-flex col-2">
        //                         <span style="font-size: large;" class="ms-2 form-label">Point:</span>
        //                         <div class="form-floating ms-2" style="flex: 1;">
        //                             <input type="number" class="rounded-2 ps-2" id="points" value="1" min="1" max="100" placeholder="Enter number" required>
        //                         </div>
        //                     </div>
        if(selectedValue == "material"){
            $(".sub-title").text("Create Material");
            $("#dateContainer").find('#startingDate').prop('required', false);
            $("#timeContainer").find('#startingTime').prop('required', false);
            $("#dateContainer").find('#deadlineDate').prop('required', false);
            $("#timeContainer").find('#deadlineTime').prop('required', false);
            $('#pointsContainer').find("#points").prop("required", false);
            $('#pointsContainer').find("#points").val(1);
            $('#pointsContainer').hide();
            $("#dateContainer").hide();
            $("#timeContainer").hide();
            $("#uploadContainer").show();
            $(".quiz-list-container").hide();
            $("#attemptCont").hide();

        }else if(selectedValue == "quiz"){
            $(".sub-title").text("Create Quiz");
            $('#pointsContainer').removeAttr("hidden");
            $("#dateContainer").removeAttr("hidden");
            $("#timeContainer").removeAttr("hidden");
            $("#dateContainer").show();
            $("#timeContainer").show();
            $(".quiz-list-container").removeAttr("hidden");
            $(".quiz-list-container").show();
            $('#pointsContainer').hide();
            $("#uploadContainer").hide();
            $("#attemptCont").removeAttr("hidden");
            $("#attemptCont").show();

        }else{
            $(".sub-title").text("Create Activity");
            $('#pointsContainer').removeAttr("hidden");
            $("#dateContainer").removeAttr("hidden");
            $("#timeContainer").removeAttr("hidden");
            $("#dateContainer").show();
            $("#timeContainer").show();
            $('#pointsContainer').show();
            $("#uploadContainer").show();
            $(".quiz-list-container").hide();
            $("#attemptCont").hide();

        }
    });


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

            $("#fileContainer").append(`
                    <a class="btn bg-body-tertiary shadow-elevation-dark-1 rounded-4 me-2 pe-5">
                        <div class="d-flex">
                            <div class="me-2">
                                <i class="bi bi-file-earmark-text-fill green1 fs-2 p-0 m-0"></i>
                            </div>
                            <div>
                                <span class="green2 fw-bold mb-0">${file.name}</span>
                                <span class="fw-light green2 fs-6 d-flex mt-0" id="material-size">${size} ${word}</span>
                            </div>
                        </div>
                    </a>
            `);
 
            console.log('File name: ' + file.name);
            console.log('File type: ' + file.type);
            console.log('File size: ' + file.size + ' bytes');
            console.log('Converted File size: ' + size + " " + word);
          });
  
          if (fileCount > 0) {
              $('#fileCount').text(fileCount + ' file(s) selected');
          } else {
              $('#fileCount').text('No files selected');
          }
   });

   console.log("CONTENT TYPE: " + $('#contentType').val());

    $("#combinedForm").submit(function (event) {
        event.preventDefault();

        $(".form-message").empty();
        // console.log("clicked");
        if($("#token").val().length > 0){
            var hasToken = true;
        }else{
            var hasToken = false;
        }

        var title = $('#title').val();
        var desc = $('#description').val();
           // Get the current date and time
        const currentDate = new Date();

        const startDate = $("#startingDate").val();
        const startTime = $("#startingTime").val();
        const startingDateTime = new Date(`${startDate}T${startTime}`);

        const deadlineDate = $('#deadlineDate').val();
        const deadlineTime = $('#deadlineTime').val();
        const deadlineDateTime = new Date(`${deadlineDate}T${deadlineTime}`);

        // Perform validations
        if ($(".sub-title").text() != "Create Material") {

            if (!startDate || !startTime) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Start Time',
                    text: 'Start date and time should not be empty.',
                });
                return; 
            }
        
       
            if (!deadlineDate || !deadlineTime) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Deadline Time',
                    text: 'Deadline date and time should not be empty.',
                });
                return; 
            }
        
            if (startingDateTime < currentDate) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Starting Time',
                    text: 'Starting time and date should not be less than the current time and date.',
                });
                return;
            }
        
            if (startingDateTime > deadlineDateTime) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Starting Time',
                    text: 'Starting time and date should not be greater than the deadline time and date.',
                });
                return; 
            }
        
            if (deadlineDateTime <= currentDate) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Deadline Time',
                    text: 'Deadline time and date should be greater than the current time and date.',
                });
                return; 
            }
        
            if (startDate === deadlineDate) {
                if (startingDateTime >= deadlineDateTime) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid Time Comparison',
                        text: 'Starting time cannot be the same or later than the deadline time on the same day.',
                    });
                    return;
                }
            }
        }
        
        const urlParams = new URLSearchParams(window.location.search);
        const classCode = urlParams.get('class');

        let formData = new FormData();
        formData.append("classCode", classCode);

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
        }
     
        // for (let pair of formData.entries()) {
        //     console.log(pair[0], pair[1]);
        // }
        let points = $("#points").val();
        let attempt = $("#attempt").val();
        // if(selectedValue != "material"){
        //     return;
        // }
        // console.log("ATTEMPT " + attempt);
        console.log($("#fileInput")[0].files.length);

        // Handles file transfer to gdrive and upload to db
        if($("#fileInput")[0].files.length > 0){
            
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
            // $("#fileForm").submit();

            $.ajax({
                method: "POST",
                url: "includes/create-post.php",
                data: { "type": selectedValue,
                        "title": title,
                        "desc" : desc,
                        "date" : deadlineDate,
                        "time" : deadlineTime,
                        "classCode" : classCode,
                        "startDate" : startDate,
                        "startTime" : startTime,
                        "points" : points,
                        "attempts" : attempt
                },
        
                success: function (response) {
                    console.table("this ",response);
                    console.log("upload");
                    // console.log(response.date);
                    var data = {
                        title : title,
                        date : response[0]["month"],
                        classCode : classCode,
                        postId : md5(response[0]["post_id"]),
                        contentType : selectedValue
                    };
                         
                    $.ajax({
                        method: "POST",
                        url: "includes/upload-file.php",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            console.log(response);
                            // console.log(hasToken);
                            if(hasToken == false){
                                console.log(response);
                                const data = JSON.parse(response);
                                if (data.authUrl) {
                                    hasToken = true;
                                    // Redirect to Google OAuth if authUrl is returned
                                    console.log(data);
                                    // window.location.href = data.authUrl;
                                }else{
                                    console.log("Error");
                                }
                            }else{
                                console.log("Success");
                            }

                            console.log( "Selected "+ selectedValue);
                            console.log("Title " + title);
                                    
                            socket.emit("serverRcvPost", data);
                            $(".form-message").append("<div class='alert alert-success' role='alert'><span>POST SUCCESS</span></div>");
                            $('#title').val("");
                            $('#description').val("");
                            $('#fileInput').empty();
                            $("#fileCount").empty();
                            $("#fileContainer").empty();

                            Swal.fire({
                                title: 'Success!',
                                text: 'Added New Post Successfully!',
                                icon: 'success'
                            });
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
            $.ajax({
                method: "POST",
                url: "includes/create-post.php",
                data: { "type": selectedValue,
                        "title": title,
                        "desc" : desc,
                        "date" : deadlineDate,
                        "time" : deadlineTime,
                        "classCode" : classCode,
                        "startDate" : startDate,
                        "startTime" : startTime,
                        "points" : points,
                        "attempts" : attempt

                },
        
                success: function (response) {
                    // console.log("testtt");
                    console.table("this is ",response);
                    // console.log("upload");
                    // console.log(response.date);
    
                    var data = {
                        title : title,
                        date : response[0]["month"],
                        classCode : classCode,
                        postId : md5(response[0]["post_id"]),
                        contentType : selectedValue
                    };
    
                    socket.emit("serverRcvPost", data);
    
                    $(".form-message").append("<div class='alert alert-success' role='alert'><span>POST SUCCESS</span></div>");
                    $('#title').val("");
                    $('#description').val("");
                    $('#fileInput').val("");
                    $("#fileContainer").empty();
                    // $("form-message").append("<div class='alert alert-success' role='alert'><span>POST SUCCESS</span></div>");

                    Swal.fire({
                        title: 'Success!',
                        text: 'Added New Post Successfully!',
                        icon: 'success'
                    });

                },
                error: function (xhr, status, error) {
                    // Swal.fire({
                    //     title: 'Error!',
                    //     text: 'There was an error uploading the file.',
                    //     icon: 'error'
                    // });
                    console.error("Error:", status, error);
                    console.error("Response Text:", xhr.responseText);
                }
            });
        }
        console.log("testasda");
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


