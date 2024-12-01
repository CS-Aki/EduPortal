$(document).ready(function() {  

            let responseData = JSON.parse(sessionStorage.getItem("stdClassDetails"));
            reDisplay(responseData);
            let newData = JSON.parse(sessionStorage.getItem("stdClassDetails"));
            display(newData);

            function display(newData){
                const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                $('#materialContent').empty();
                $('#actsContent').empty();
                $('#quizContent').empty();
        
                // console.table(responseData);
                    $.each(newData, function (key, value) {
        
                        // Checks condition if there is a post on the class
                        // If class has no post yet, do the else statement                
                        if (value["month"] != undefined) {
                            let year = value["month"].charAt(0) + value["month"].charAt(1) + value["month"].charAt(2) + value["month"].charAt(3)
                            let temp = value["month"].charAt(5) + value["month"].charAt(6);
                            let month = months[temp - 1];
                            let day = value["month"].charAt(8) + value["month"].charAt(9);
                            let hour = value["time"].charAt(0) + value["time"].charAt(1);
                            let min = value["time"].charAt(3) + value["time"].charAt(4);
                            let timePeriod = hour >= 12 ? "PM" : "AM";
        
                            $('#pageTitle').text(value["class_name"]);
        
                            $('#classCode').text(value["class_code"]);
                            $('#classSched').text(value["class_schedule"]);
                            if (value["prof_name"] == undefined) $('#classInstructor').text(value["class_teacher"]);
                            else $('#classInstructor').text(value["prof_name"]);
        
                            if (value["content_type"] == "Material") $('#materialContent').append("<div><a href='' class='view-post'><div class='container-fluid bg-body-tertiary d-flex align-content-center rounded-3 px-4 py-2 mb-2 shadow-elevation-dark-1'><div><i class='bi bi-bookmark-fill green1 fs-2 p-0 m-0'></i></div><div class='ms-3 mt-1'><label hidden></label><p class='green2 fw-bold lh-1 fs-5 mb-0 pb-0 material-title' >" + value["title"] + "</p><span class='fs-6 fw-light green3' id='material-date'>" + month + " " + day + ", " + year + "</span></div></div></a></div>");
                            if (value["content_type"] == "Activity") $('#actsContent').append("<div><a href='#' class='view-post1'> <div class='container-fluid bg-body-tertiary d-flex align-content-center rounded-3 px-4 py-2 mb-2 shadow-elevation-dark-1'><div><i class='bi bi-bookmark-fill green1 fs-2 p-0 m-0'></i></div><div class='ms-3 mt-1'> <p class='green2 fw-bold lh-1 fs-5 mb-0 pb-0 material-title' >" + value["title"] + "</p><span class='fs-6 fw-light green3' id='material-date'>" + month + " " + day + ", " + year + "</span> </div></div></a></div>");
                            // if (value["content_type"] == "Activity") $('#actsContent').append("<div><a href='' class='display-post'>" + value["title"] + "<br>Description: " + value["content"] + "<br>Posted In: " + month + " " + day + "</a></div><br><br>");
                            if (value["content_type"] == "Quiz") $('#quizContent').append("<div><a href='#' class='view-post1'> <div class='container-fluid bg-body-tertiary d-flex align-content-center rounded-3 px-4 py-2 mb-2 shadow-elevation-dark-1'><div><i class='bi bi-bookmark-fill green1 fs-2 p-0 m-0'></i></div><div class='ms-3 mt-1'> <p class='green2 fw-bold lh-1 fs-5 mb-0 pb-0 material-title' >" + value["title"] + "</p><span class='fs-6 fw-light green3' id='material-date'>" + month + " " + day + ", " + year + "</span></div></div></a></div>");
        
                            // if (value["content_type"] == "Quiz") $('#quizContent').append("<div><a href='' class='display-post'>" + value["title"] + "<br>Description: " + value["content"] + "<br>Posted In: " + month + " " + day + "</a></div><br><br>");
        
                        } else {
                            $('#pageTitle').text(value["class_name"]);
                            $('#classCode').text(value["class_code"]);
                            $('#classSched').text(value["class_schedule"]);
                            if (value["prof_name"] == undefined) $('#classInstructor').text(value["class_teacher"]);
                            else $('#classInstructor').text(value["prof_name"]);
                            
                        }
        
                    });
            }
        
            function reDisplay(responseData){
                var class_code = responseData[0]["class_code"];
                // console.log("This is the inside  " + responseData.length);
                const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                // console.log(class_code);
                $.ajax({
                    method: "POST",
                    url: "student%20backend/includes/view-class.php",
                    data: {
                      'class-code': class_code,
                    },
            
                    success: function(response) {
                    //    console.log("Inside length" + response.length);
                    //    console.table(response);


                       if(response.length != responseData.length){
                             display(response);
                       }else{
                            // console.log("else");
                             sessionStorage.setItem("stdClassDetails", JSON.stringify(response));
                       }

                    //    if(response.length == responseData.length){
                    //     console.log("equal");
                    //     display(response);
                    //   }
                    },
                    error: function(xhr, status, error) {
                      console.log("Status "+ status + " An error occured" + error)
                      // sessionStorage.setItem("classDetails", JSON.stringify(class_name));
                      // window.location.href = "prof-dashboard.php?class=" + md5(class_code);
                      //$(".sign-up-msg").html("An error occurred: " + error);
                    }
                  });
            }
        // }
            // $(window).load(function() {
            //     reDisplay(JSON.parse(sessionStorage.getItem("stdClassDetails")));
            // });

});
