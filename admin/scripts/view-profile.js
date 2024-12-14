$(document).ready(function() {

    $(document).on('click', '.view_instructor_profile', function (e) {
        e.preventDefault();
        var userId = $(this).closest('tr').find('.instructor_id').text();
        
        var userName =  $(this).closest('tr').find('.instructor_name').text();
        console.log(userId);

        $.ajax({
            url: "includes/instructor-list.php",
            type: "POST",
            data: {
                userId : userId,
                userName : userName
            },
            
            success: function(response) {
                $("#title_name").text(response[0]["class_teacher"]);
                // console.log(response[0]["image"]);
                $("#instructor_img").attr("src", (response[0]["image"]));
            
                if(response[0]["class_teacher"] == undefined){
                    $("#prof_name").val(response[0]["name"]);
                }else{
                    $("#prof_name").val(response[0]["class_teacher"]);
                }

                $("#instructor_status").val(response[0]["status"]);
                $("#prof_email").val(response[0]["email"]);
                $("#profCode").val(userId);
                var year = response[0]["created"].substr(0, 4);

                // while (userId.length < 4) {
                //     year += "0";
                // }

                for(let i = userId.length; i < 4; i++){
                    year += "0";
                }

                year += userId + "-S";

                $("#profCodeText").val(year);

                $("#profGender").val(response[0]["gender"]);
                $("#prof_address").val(response[0]["address"]);
                $("#date_of_birth1").val(response[0]["birthdate"]);
                console.log("birthdate" + response[0]["birthdate"]);
                var dataTable = $("#classTable").DataTable();
                // Clear existing table rows
                dataTable.clear().draw();
                if(response[0]["class_teacher"] != undefined){
                    for(let i = 0; i < response.length; i++){
                        // let paddedId = "2024" + response.classDetail[i]["user_id"].toString().padStart(4, '0');
                        dataTable.row.add([
                            response[i]["class_code"],
                            response[i]["class_name"],   
                            response[i]["class_schedule"],  
                            response[i]["class_teacher"],  
                            response[i]["class_status"]
                        ]);
                        // table.append("<tr><td>" + response.classDetail[i]["user_id"] + "</td><td>" + response.classDetail[i]["name"] + "</td><td>" + response.classDetail[i]["email"] + "</td></tr>");
                    }
                }
           
                dataTable.draw();

                $('#editProfModal').modal('show');          

            },
            error: function(xhr, status, error) {
                console.log("error here");
                console.log(error);
            }
        });
    });

    $(document).on('click', '.view_student_profile', function (e) {
        e.preventDefault();
        var userId = $(this).closest('tr').find('.student_id').text();
        var userName =  $(this).closest('tr').find('.student_name').text();
        // console.log(userName);

        $.ajax({
            url: "includes/student-list.php",
            type: "POST",
            data: {
                userId : userId,
                userName : userName
            },
            
            success: function(response) {
                console.table(response);
                // console.log(response[0]["status"]);
        
                var dataTable = $("#studentTable").DataTable();
                
                // Clear existing table rows
                dataTable.clear().draw();
                if(response.listOfClass == undefined){
                    var year = response[0]["created"].substr(0, 4);

                    for(let i = userId.length; i < 4; i++){
                        year += "0";
                    }
    
                    year += userId + "-S";

                    $("#date_of_birth1").val(response[0]["birthdate"]);
                    $("#title_student").text(response[0]["name"]);
                    $("#student_image").attr("src", (response[0]["image"]));    
                    $("#student_name").val(response[0]["name"]);
                    $("#student_status").val(response[0]["status"]);
                    $("#student_email").val(response[0]["email"]);
                    let paddedId = "2024" + userId.toString().padStart(4, '0');
                    $("#studentCode").val(userId.toString());
                    $("#studentCodeText").val(year);

                    $("#studentGender").val(response[0]["gender"]);
                    $("#student_address").val(response[0]["address"]);
                }else{
                    var year = response.studentDetail[0]["created"].substr(0, 4);

                    for(let i = userId.length; i < 4; i++){
                        year += "0";
                    }
    
                    year += userId + "-S";

                    $("#title_student").text(response.studentDetail[0]["name"]);
                    $("#student_image").attr("src", (response.studentDetail[0]["image"]));    
                    $("#student_name").val(response.studentDetail[0]["name"]);
                    $("#student_status").val(response.studentDetail[0]["status"]);
                    $("#student_email").val(response.studentDetail[0]["email"]);
                    let paddedId = "2024" + userId.toString().padStart(4, '0');
                    $("#studentCode").val(userId);
                    $("#studentCodeText").val(year);
                    $("#studentGender").val(response.studentDetail[0]["gender"]);
                    $("#student_address").val(response.studentDetail[0]["address"]);
                    $("#date_of_birth1").val(response.studentDetail[0]["birthdate"]);

                    for(let i = 0; i < response.listOfClass.length; i++){
                        // let paddedId = "2024" + response.classDetail[i]["user_id"].toString().padStart(4, '0');
                        // console.log(response.listOfClass[i]["class_code"]);
                        // console.log(response.listOfClass[i]["class_name"]);
                        // console.log(response.listOfClass[i]["class_schedule"]);
                        // console.log(response.listOfClass[i]["class_teacher"]);
                        // console.log(response.listOfClass[i]["class_status"]);
                        dataTable.row.add([
                            response.listOfClass[i]["class_code"],
                            response.listOfClass[i]["class_name"],   
                            response.listOfClass[i]["class_schedule"],  
                            response.listOfClass[i]["class_teacher"],  
                            response.listOfClass[i]["class_status"]
                        ]);
                        // table.append("<tr><td>" + response.classDetail[i]["user_id"] + "</td><td>" + response.classDetail[i]["name"] + "</td><td>" + response.classDetail[i]["email"] + "</td></tr>");
                    }
                }

                dataTable.draw();

                $('#editStudentsModal').modal('show');          

                // $("#title_name").text(response[0]["class_teacher"]);
                // // console.log(response[0]["image"]);
                // $("#instructor_img").attr("src", (response[0]["image"]));
            
                // if(response[0]["class_teacher"] == undefined){
                //     $("#prof_name").val(response[0]["name"]);
                // }else{
                //     $("#prof_name").val(response[0]["class_teacher"]);
                // }

                // $("#instructor_status").val(response[0]["status"]);
                // $("#prof_email").val(response[0]["email"]);
                // $("#profCode").val(userId);
                // $("#profGender").val(response[0]["gender"]);
                // $("#prof_address").val(response[0]["address"]);

                // var dataTable = $("#classTable").DataTable();
                // // Clear existing table rows
                // dataTable.clear().draw();
                // if(response[0]["class_teacher"] != undefined){
                //     for(let i = 0; i < response.length; i++){
                //         // let paddedId = "2024" + response.classDetail[i]["user_id"].toString().padStart(4, '0');
                //         dataTable.row.add([
                //             response[i]["class_code"],
                //             response[i]["class_name"],   
                //             response[i]["class_schedule"],  
                //             response[i]["class_teacher"],  
                //             response[i]["class_status"]
                //         ]);
                //         // table.append("<tr><td>" + response.classDetail[i]["user_id"] + "</td><td>" + response.classDetail[i]["name"] + "</td><td>" + response.classDetail[i]["email"] + "</td></tr>");
                //     }
                // }
           
                // dataTable.draw();


            },
            error: function(xhr, status, error) {
                // console.log("error here");
                console.log(error);
            }
        });
    });
});