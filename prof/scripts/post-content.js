$(document).ready(function () {
    displayContents();
    var container = document.getElementById("postContainer");
    $("#displayPost").click(function () {
        // console.log("post");
        //document.getElementById("postContainer").setAttribute("visibility", "visible");
        var btn = document.getElementById("displayPost");

        if (container.style.display === "none") {
            // console.log("block");
            btn.innerHTML = "HIDE POST";
            container.style.display = "block";
        } else {
            // console.log("none");
            btn.innerHTML = "DISPLAY POST";
            container.style.display = "none";
        }
    });

    $("#postForm").submit(function (event) {
        event.preventDefault();
        // console.log("clicked");

        var class_code = $('#classCode').text();
        class_code = class_code.replaceAll("CLASS CODE : ", "");
        var title = $('#title').val();
        var desc = $('#description').val();
        var type = $('#contentType').val();
        var btn = $('#post').val();
        var prof = $('#classInstructor').text();
        prof = prof.replaceAll("CLASS INSTRUCTOR : ", "");
        $.ajax({
            method: "POST",
            url: "includes/post.php",
            data: {
                'class-code': class_code,
                'title': title,
                'desc': desc,
                'type': type,
                'postBtn': btn,
                'profName': prof
            },

            success: function (response) {
                console.table(response);
                // console.table(response);
                sessionStorage.setItem("classDetails", JSON.stringify(response));
                displayContents();
                // sessionStorage.setItem("classDetails", JSON.stringify(response));
                console.log("Success")

            }
        });
    });

    $(".change-visibility").click(function() {
        // console.log("post");
        //document.getElementById("postContainer").setAttribute("visibility", "visible");
        var post_id = $(this).closest('div').find('.id').text();
        var status =  $(this).closest('div').find('.status').text();
        console.log("change visib");
        console.log("This is the " + status);
        console.log(post_id);
        let responseData = JSON.parse(sessionStorage.getItem("classDetails"));

        $.ajax({
            method: "POST",
            url: "includes/visibility.php",
            data: {
              'post_id': post_id,
              'status': status,
              'class-code': responseData[0]["class_code"]
            },
    
            success: function(response) {
            console.table(response);

            // sessionStorage.setItem("classDetails", JSON.stringify(response));
            // displayContents();
            //   console.log("test");
            //   console.log(response);
            //   // Transfer the response from this script to the script below (inside prof dashboard php)
              sessionStorage.setItem("classDetails", JSON.stringify(response));
            //   displayContents();
              window.location.href = "prof-dashboard.php?class=" + md5(response[0]["class_code"]);
            },
            error: function(xhr, status, error) {
              console.log("Status "+ status + " An error occured" + error)
              // sessionStorage.setItem("classDetails", JSON.stringify(class_name));
              // window.location.href = "prof-dashboard.php?class=" + md5(class_code);
              //$(".sign-up-msg").html("An error occurred: " + error);
            }
          });

    });

    // Receives the response from display-class js
    // Handles the data and displaying class details and contents
    function displayContents() {
        $('#materialContent').empty();
        $('#actsContent').empty();
        $('#quizContent').empty();
        var container = document.getElementById("postContainer");
        // console.log("inside");
        let responseData = JSON.parse(sessionStorage.getItem("classDetails"));
        const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        // console.log("The size of data is " + responseData.length);
        // console.log(responseData[0]["month"]);

        // console.table(responseData);
        // console.log("Hour " + hour);
        // console.log("Minute " + min);
        // console.log("Minute " + min);
        // console.log(responseData[0]["time"]);
        // console.log(responseData[0]["date"]);
        // console.log(responseData[0]["date"].charAt(5) + " " + responseData[0]["date"].charAt(6));

        const urlParams = new URLSearchParams(window.location.search);
        const param = urlParams.get('class');
        container.style.display = "none";
    
        // document.getElementById("pageTitle").setAttribute();
        if (param == null) {
            $('#pageTitle').text("All Classes");
        }
        else {

            $.each(responseData, function (key, value) {
                // Checks condition if there is a post on the class
                // If class has no post yet, do the else statement
                if (value["month"] != undefined) {
                    let temp = value["month"].charAt(5) + value["month"].charAt(6);
                    let month = months[temp - 1];
                    let day = value["month"].charAt(8) + value["month"].charAt(9);
                    let hour = value["time"].charAt(0) + value["time"].charAt(1);
                    let min = value["time"].charAt(3) + value["time"].charAt(4);
                    let timePeriod = hour >= 12 ? "PM" : "AM";

                    $('#pageTitle').text(value["class_name"]);

                    $('#classCode').text("CLASS CODE : " + value["class_code"]);
                    $('#classSched').text("CLASS SCHEDULE : " + value["class_schedule"]);
                    if (value["prof_name"] == undefined) $('#classInstructor').text("CLASS INSTRUCTOR : " + value["class_teacher"]);
                    else $('#classInstructor').text("CLASS INSTRUCTOR : " + value["prof_name"]);

                    if (value["content_type"] == "Material") $('#materialContent').append("<div><p class='id' hidden>"+value["post_id"]+"</p><a href='' class='display-post'><span class='post-title'>" + value["title"] + "</span>" + "<br>Description: " + value["content"] + "<br>Posted In: " + month + " " + day + "<br>Status : <p class='status'>"+value["visibility"]+"</p></a><button class='change-visibility'>Change Visibility</button></div><br><br>");
                    if (value["content_type"] == "Activity") $('#actsContent').append("<div><p class='id' hidden>"+value["post_id"]+"</p><a href='' class='display-post'>" + value["title"] + "<br>Description: " + value["content"] + "<br>Posted In: " + month + " " + day + "<br>Status : <p class='status'>"+value["visibility"]+"</p></a><button class='change-visibility'>Change Visibility</button></div><br><br>");
                    if (value["content_type"] == "Quiz") $('#quizContent').append("<div><p class='id' hidden>"+value["post_id"]+"</p><a href='' class='display-post'>" + value["title"] + "<br>Description: " + value["content"] + "<br>Posted In: " + month + " " + day + "<br>Status : <p class='status'>"+value["visibility"]+"</p></a><button class='change-visibility'>Change Visibility</button></div><br><br>");

                } else {
                    $('#pageTitle').text(value["class_name"]);

                    $('#classCode').text("CLASS CODE : " + value["class_code"]);
                    $('#classSched').text("CLASS SCHEDULE : " + value["class_schedule"]);
                    if (value["prof_name"] == undefined) $('#classInstructor').text("CLASS INSTRUCTOR : " + value["class_teacher"]);
                    else $('#classInstructor').text("CLASS INSTRUCTOR : " + value["prof_name"]);
                }

            });
        }

    }
});