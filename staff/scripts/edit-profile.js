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
            birthdate : $("#date_of_birth1").val(),
            password: "", // No password by default
            repeatPass: "" // No confirm password by default
            birthdate : $("#date_of_birth1").val(),
            password: "", // No password by default
            repeatPass: "" // No confirm password by default
        };
    });

    $(document).on('hidden.bs.modal', '#editProfModal', function () {
        $("#profModalMsg").empty();
        $("#password").val("");      // Clear the password input
        $("#repeat_pass").val("");  // Clear the confirm password input
        $("#password").val("");      // Clear the password input
        $("#repeat_pass").val("");  // Clear the confirm password input
    });

    $("#editInstructorForm").submit(function(event) {
        event.preventDefault();

        let currentValues = {
            instructorName : $("#prof_name").val(),
            status : $("#instructor_status").val(),
            email : $("#prof_email").val(),
            gender :  $("#profGender").val(),
            address : $("#prof_address").val(),
            birthdate : $("#date_of_birth1").val(),
            password: $("#password").val().trim(),
            repeatPass: $("#repeat_pass").val().trim()
            birthdate : $("#date_of_birth1").val(),
            password: $("#password").val().trim(),
            repeatPass: $("#repeat_pass").val().trim()
        };

        let isChanged = false;
        for (let key in currentValues) {
            if (currentValues[key] !== window.initialFormValues[key]) {
                isChanged = true;
                // isChange = true;
                // console.log(`Field "${key}" has changed from "${window.initialFormValues[key]}" to "${currentValues[key]}"`);
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
        let password = currentValues.password;
        let repeatPass = currentValues.repeatPass;

        if (password !== "" || repeatPass !== "") {
            if (password !== repeatPass) {
                Swal.fire({
                    title: 'Invalid!',
                    text: "Password Does Not Match",
                    icon: 'error'
                });   
               
                return; 
            }
        }

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
                    birthdate : birthdate,
                    password: password
                    birthdate : birthdate,
                    password: password
                },
                
                success: function(response) {
                    // console.log("inside");
                    console.table(response);     
                    if(response.includes("Update Success")){
                        
                        Swal.fire({

                            title: 'Success!',

                            text: 'Profile Updated!',

                            icon: 'success'

                        });
                        
                        $("#title_name").text(instructorName);

                        window.initialFormValues = {
                            instructorName : $("#prof_name").val(),
                            status : $("#instructor_status").val(),
                            email : $("#prof_email").val(),
                            gender :  $("#profGender").val(),
                            address : $("#prof_address").val(),
                             password: "",
                            repeatPass: ""
                            address : $("#prof_address").val(),
                             password: "",
                            repeatPass: ""
                        };

                        var row = table.rows().every(function() {
                            var rowData = this.data();  // Get data for the current row
                            if (rowData[0] === id) {  // Assuming class_code is in the first column (index 0)
                                rowData[2] = instructorName;
                                rowData[3] = email;
                                rowData[4] = status;
                                console.log("changed here");
                                this.data(rowData).draw(false);
                                // Once the row is found, stop further iterations
                                return false;  // This will break out of the loop
                            }
                        });

                    }else{
                         Swal.fire({

                            title: 'Invalid!',

                            text: response,

                            icon: 'error'

                        });   
                        // console.log("Error");
                    }
                },
                error: function(xhr, status, error) {
                   
                   Swal.fire({

                        title: 'Error Encountered!!',

                        text: error,

                        icon: 'error'

                    });  
                }
            });
        }else{
            $("#profModalMsg").empty();
        }

    });

    $(document).on('hidden.bs.modal', '#editStudentsModal', function () {
        // console.log('Modal is hidden');
        $("#studentModalMsg").empty();
        $("#password").val("");      // Clear the password input
        $("#repeat_pass").val("");  // Clear the confirm password input
        $("#password").val("");      // Clear the password input
        $("#repeat_pass").val("");  // Clear the confirm password input
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
            birthdate : $("#date_of_birth1").val(),
            password: "", // No password by default
            repeatPass: "" // No confirm password by default
            birthdate : $("#date_of_birth1").val(),
            password: "", // No password by default
            repeatPass: "" // No confirm password by default
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
            birthdate : $("#date_of_birth1").val(),
            password: $("#password").val().trim(),
            repeatPass: $("#repeat_pass").val().trim()
            birthdate : $("#date_of_birth1").val(),
            password: $("#password").val().trim(),
            repeatPass: $("#repeat_pass").val().trim()

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
        let birthdate = $("#date_of_birth1").val();
        let password = currentValues.password;
        let repeatPass = currentValues.repeatPass;

        if (password !== "" || repeatPass !== "") {
            if (password !== repeatPass) {
                  Swal.fire({
            
                    title: 'Success!',
            
                    text: 'Profile Updated!',
            
                    icon: 'success'

                 });
                return; // Stop submission if passwords don't match
            }
        }

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
                    birthdate : birthdate,
                    password: password
                    birthdate : birthdate,
                    password: password
                },
                
                success: function(response) {
                    // console.log("inside");
                    console.table(response);     
                    if(response.includes("Update Success")){
                          Swal.fire({

                            title: 'Success!',

                            text: 'Profile Updated!',

                            icon: 'success'

                        });

                        window.initialFormValues = {
                            oldName : $("#title_student").text(),
                            studentName : $("#student_name").val(),
                            status : $("#student_status").val(),
                            email : $("#student_email").val(),
                            studentCode : $("#studentCode").val(),
                            gender : $("#studentGender").val(),
                            address : $("#student_address").val(),
                            password: "",
                            repeatPass: ""
                            address : $("#student_address").val(),
                            password: "",
                            repeatPass: ""
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
                         Swal.fire({

                            title: 'Invalid!',

                            text: response,

                            icon: 'error'

                        });  
                        // console.log("Error");
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({

                        title: 'Error Encountered!!',

                        text: error,

                        icon: 'error'

                    });  
                }
            });
        }else{
            $("#studentModalMsg").empty();
        }

    });



    $("#editStaffModal").on("shown.bs.modal", function () {
        // Capture the initial values of modal fields
        // tempClassName = $("#class_name").val();
        window.initialFormValues = {
            oldName : $("#title_staff").text(),
            staffName : $("#staff_name").val(),
            status : $("#staff_status").val(),
            email : $("#staff_email").val(),
            staffCode : $("#staffCode").val(),
            gender : $("#staffGender").val(),
            address : $("#staff_address").val(),
            birthdate : $("#date_of_birth1").val()
        };
    });

    $("#editStaffForm").submit(function(event) {
        event.preventDefault();

        let currentValues = {
            staffName : $("#staff_name").val(),
            status : $("#staff_status").val(),
            email : $("#staff_email").val(),
            staffCode : $("#staffCode").val(),
            gender : $("#staffGender").val(),
            address : $("#staff_address").val(),
            birthdate : $("#date_of_birth1").val()

        };

        let isChanged = false;
        for (let key in currentValues) {
            if (currentValues[key] !== window.initialFormValues[key]) {
                isChanged = true;
                // isChange = true;
                // console.log(`Field "${key}" has changed from "${window.initialFormValues[key]}" to "${currentValues[key]}"`);
            }
        }

        let oldName = $("#title_staff").text();
        let staffName = $("#staff_name").val();
        let status = $("#staff_status").val();
        let email = $("#staff_email").val();
        let staffCode = $("#staffCode").val();
        let gender = $("#staffGender").val();
        let address = $("#staff_address").val();
        let birthdate = $("#date_of_birth1").val()

      
        // const match = staffCode.match(/2024(\d+)-S$/);
        console.log("Staff Code " + staffCode);
        console.log("Staff oLD nAME " +oldName);
        console.log("Staff new name " +staffName);
        console.log("Staff status " +status);
        console.log("Staff email " +email);
        console.log("Staff gender " +gender);
        console.log("Staff address " +address);
        console.log("Staff bday " +birthdate);

        // if (match) {
        // const number = match[1].replace(/^0+/, ""); // Remove leading zeros
        // staffCode = number;
        // } 

        if(isChanged){
            $.ajax({
                url: "includes/edit-staff.php",
                type: "POST",
                data: {
                    staffName : staffName,
                    oldName : oldName,
                    status : status,
                    email : email,
                    gender : gender,
                    address, address,
                    id : staffCode,
                    birthdate : birthdate
                },
                
                success: function(response) {
                    // console.log("inside");
                    // console.table(response);     
                    if(response.includes("Update Success")){
                        console.log("inside success");
                        $("#staffModalMsg").empty();
                        $("#staffModalMsg").append("<div class='alert alert-success' role='alert'><span>Update Success</span></div>");
                    
                        window.initialFormValues = {
                            oldName : $("#title_staff").text(),
                            staffName : $("#staff_name").val(),
                            status : $("#staff_status").val(),
                            email : $("#staff_email").val(),
                            staffCode : $("#staffCode").val(),
                            gender : $("#staffGender").val(),
                            address : $("#staff_address").val()
                        };

                        $("#title_staff").text(staffName);

                        var row = table.rows().every(function() {
                            var rowData = this.data();  // Get data for the current row
                            
                            if (rowData[0] === staffCode) {  // Assuming class_code is in the first column (index 0)
                                rowData[2] = staffName;
                                rowData[3] = email;
                                rowData[4] = status;

                                this.data(rowData).draw(false);
                                // Once the row is found, stop further iterations
                                return false;  // This will break out of the loop
                            }
                        });

                    }else{
                        
                         Swal.fire({

                            title: 'Invalid!',

                            text: response,

                            icon: 'error'

                        });  
                        // console.log("Error");
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({

                        title: 'Error Encountered!!',

                        text: error,

                        icon: 'error'

                    });  
                }
            });
        }else{
            $("#staffModalMsg").empty();
        }

    });



});