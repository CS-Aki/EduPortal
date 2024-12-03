$(document).ready(function() {
    console.log(io);
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

    $('#contentType').on('change', function() {
        selectedValue = $(this).val();
        console.log(selectedValue);
        title = $('#title').val();
        desc = $('#description').val();
        date = $('#deadlineDate').val();
        time = $('timeContainer').val();
       
        if(selectedValue == "material"){
            $(".sub-title").text("Create Material");
            $("#dateContainer").find('#deadlineDate').prop('required', false);
            $("#timeContainer").find('#deadlineTime').prop('required', false);
            $("#dateContainer").hide();
            $("#timeContainer").hide();
        }else if(selectedValue == "quiz"){
            $(".sub-title").text("Create Quiz");
            $("#dateContainer").removeAttr("hidden");
            $("#timeContainer").removeAttr("hidden");
            $("#dateContainer").show();
            $("#timeContainer").show();
        }else{
            $(".sub-title").text("Create Activity");
            $("#dateContainer").removeAttr("hidden");
            $("#timeContainer").removeAttr("hidden");
            $("#dateContainer").show();
            $("#timeContainer").show();
        }

    });

    $('#fileInput').on('change', function() {
        // Get the number of selected files
        var fileCount = this.files.length;

        // Update the text in the paragraph to show the file count
        if (fileCount > 0) {
            $('#fileCount').text(fileCount + ' file(s) selected');
        } else {
            $('#fileCount').text('No files selected');
        }
    });

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
        var date = $('#deadlineDate').val();
        var time = $('#deadlineTime').val();

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

        if(date == "" && selectedValue != "material"){
            $(".form-message").append("<div class='alert alert-danger' role='alert'><span>EMPTY DATE FIELDS</span></div>");
            return;
        }

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

                    $.ajax({
                        method: "POST",
                        url: "includes/create-post.php",
                        data: { "type": selectedValue,
                                "title": title,
                                "desc" : desc,
                                "date" : date,
                                "time" : time,
                                "classCode" : classCode
                        },
                
                        success: function (response) {
                            // console.table("this is ",response);
                            console.log("upload");
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
                        }
                    });
                    
                },
                error: function (xhr, status, error) {
                    console.error("Error:", status, error);
                    console.error("Response Text:", xhr.responseText);
                }
            });
        }else{
            $.ajax({
                method: "POST",
                url: "includes/create-post.php",
                data: { "type": selectedValue,
                        "title": title,
                        "desc" : desc,
                        "date" : date,
                        "time" : time,
                        "classCode" : classCode
                },
        
                success: function (response) {
                    console.table("this is ",response);
                    console.log("upload");
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
                }
            });
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


