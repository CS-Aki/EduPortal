$(document).ready(function() {

    var table = $('#myTable').DataTable();

    $("#editProfModal").on("shown.bs.modal", function () {
        // Capture the initial values of modal fields
        $("#profModalMsg").empty();
        // tempClassName = $("#class_name").val();
        window.initialFormValues = {
            instructorName : $("#prof_name").val(),
            status : $("#instructor_status").val(),
            email : $("#prof_email").val(),
            gender :  $("#profGender").val(),
            address : $("#prof_address").val(),
            birthdate : $("#date_of_birth1").val()
        };
    });

    $(document).on('hidden.bs.modal', '#editProfModal', function () {
        $("#profModalMsg").empty();
    });

    $("#editInstructorForm").submit(function(event) {
        event.preventDefault();

        let currentValues = {
            instructorName : $("#prof_name").val(),
            status : $("#instructor_status").val(),
            email : $("#prof_email").val(),
            gender :  $("#profGender").val(),
            address : $("#prof_address").val(),
            birthdate : $("#date_of_birth1").val()
        };

        let isChanged = false;
        for (let key in currentValues) {
            if (currentValues[key] !== window.initialFormValues[key]) {
                isChanged = true;
                // isChange = true;
                console.log(`Field "${key}" has changed from "${window.initialFormValues[key]}" to "${currentValues[key]}"`);
            }
        }

        let instructorName = $("#prof_name").val();
        let oldName = $("#title_name").text();
        let status = $("#instructor_status").val();
        let email = $("#prof_email").val();
        let gender =  $("#profGender").val();
        let address = $("#prof_address").val();
        let id =  $("#profCode").val();
        let birthdate = $("#date_of_birth1").val();

        console.log(id);
        // console.log($("#title_name").text());

        if(isChanged){
            $.ajax({
                url: "includes/edit-instructor.php",
                type: "POST",
                data: {
                    instructorName : instructorName,
                    oldName : oldName,
                    status : status,
                    email : email,
                    gender : gender,
                    address, address,
                    userId : id,
                    birthdate : birthdate
                },
                
                success: function(response) {
                    // console.log("inside");
                    console.table(response);     
                    if(response.includes("Update Success")){
                        console.log("inside success");
                        $("#profModalMsg").empty();
                        $("#profModalMsg").append("<div class='alert alert-success' role='alert'><span>Update Success</span></div>");
                        $("#title_name").text(instructorName);

                        window.initialFormValues = {
                            instructorName : $("#prof_name").val(),
                            status : $("#instructor_status").val(),
                            email : $("#prof_email").val(),
                            gender :  $("#profGender").val(),
                            address : $("#prof_address").val()
                        };


                        var row = table.rows().every(function() {
                            var rowData = this.data();  // Get data for the current row
                            
                            if (rowData[0] === id) {  // Assuming class_code is in the first column (index 0)
                                rowData[2] = instructorName;
                                rowData[3] = email;
                                rowData[4] = status;

                                this.data(rowData).draw(false);
                                // Once the row is found, stop further iterations
                                return false;  // This will break out of the loop
                            }
                        });

                    }else{
                        $("#profModalMsg").empty();
                        $("#profModalMsg").append("<div class='alert alert-danger' role='alert'><span>"+ response +"</span></div>");
                        // console.log("Error");
                    }
                },
                error: function(xhr, status, error) {
                    console.log("error here");
                    console.log(error);
                }
            });
        }else{
            $("#profModalMsg").empty();
        }

    });

    $(document).on('hidden.bs.modal', '#editStudentsModal', function () {
        // console.log('Modal is hidden');
        $("#studentModalMsg").empty();
    });

    $("#editStudentsModal").on("shown.bs.modal", function () {
        // Capture the initial values of modal fields
        // tempClassName = $("#class_name").val();
        window.initialFormValues = {
            oldName : $("#title_student").text(),
            studentName : $("#student_name").val(),
            status : $("#student_status").val(),
            email : $("#student_email").val(),
            studentCode : $("#studentCode").val(),
            gender : $("#studentGender").val(),
            address : $("#student_address").val(),
            birthdate : $("#date_of_birth1").val()
        };
    });

    $("#editStudentForm").submit(function(event) {
        event.preventDefault();

        let currentValues = {
            studentName : $("#student_name").val(),
            status : $("#student_status").val(),
            email : $("#student_email").val(),
            studentCode : $("#studentCode").val(),
            gender : $("#studentGender").val(),
            address : $("#student_address").val(),
            birthdate : $("#date_of_birth1").val()

        };

        let isChanged = false;
        for (let key in currentValues) {
            if (currentValues[key] !== window.initialFormValues[key]) {
                isChanged = true;
                // isChange = true;
                console.log(`Field "${key}" has changed from "${window.initialFormValues[key]}" to "${currentValues[key]}"`);
            }
        }

        let oldName = $("#title_student").text();
        let studentName = $("#student_name").val();
        let status = $("#student_status").val();
        let email = $("#student_email").val();
        let studentCode = $("#studentCode").val();
        let gender = $("#studentGender").val();
        let address = $("#student_address").val();
        let birthdate = $("#date_of_birth1").val()

        studentCode = studentCode.trim();
        const match = studentCode.match(/2024(\d+)-S$/);

        if (match) {
        const number = match[1].replace(/^0+/, ""); // Remove leading zeros
        studentCode = number;
        } 

        if(isChanged){
            $.ajax({
                url: "includes/edit-student.php",
                type: "POST",
                data: {
                    studentName : studentName,
                    oldName : oldName,
                    status : status,
                    email : email,
                    gender : gender,
                    address, address,
                    id : studentCode,
                    birthdate : birthdate
                },
                
                success: function(response) {
                    // console.log("inside");
                    console.table(response);     
                    if(response.includes("Update Success")){
                        console.log("inside success");
                        $("#studentModalMsg").empty();
                        $("#studentModalMsg").append("<div class='alert alert-success' role='alert'><span>Update Success</span></div>");
                    

                        window.initialFormValues = {
                            oldName : $("#title_student").text(),
                            studentName : $("#student_name").val(),
                            status : $("#student_status").val(),
                            email : $("#student_email").val(),
                            studentCode : $("#studentCode").val(),
                            gender : $("#studentGender").val(),
                            address : $("#student_address").val()
                        };

                        $("#title_student").text(studentName);

                        var row = table.rows().every(function() {
                            var rowData = this.data();  // Get data for the current row
                            
                            if (rowData[0] === studentCode) {  // Assuming class_code is in the first column (index 0)
                                rowData[2] = studentName;
                                rowData[3] = status;
                                rowData[4] = email;

                                this.data(rowData).draw(false);
                                // Once the row is found, stop further iterations
                                return false;  // This will break out of the loop
                            }
                        });

                    }else{
                        $("#studentModalMsg").empty();
                        $("#studentModalMsg").append("<div class='alert alert-danger' role='alert'><span>"+ response +"</span></div>");
                        // console.log("Error");
                    }
                },
                error: function(xhr, status, error) {
                    console.log("error here");
                    console.log(error);
                }
            });
        }else{
            $("#studentModalMsg").empty();
        }

    });

});