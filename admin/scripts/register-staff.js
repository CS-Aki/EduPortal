$(document).ready(function() {

    $('#signUpModal').on('hidden.bs.modal', function () {
        $("#signUpForm")[0].reset();
        $("#profModalMsg").empty(); // Clear any messages
    });

    $("#signUpForm").submit(function(event) {
        event.preventDefault();

        let formData = {
            firstName: $("#first_name").val(),
            lastName: $("#last_name").val(),
            middleName: $("#middle_name").val(),
            email: $("#email").val(),
            birthdate: $("#date_of_birth").val(),
            gender: $("#gender").val(),
            address: $("#address").val(),
            password: $("#password1").val(),
            repeatPass: $("#repeat_pass1").val()
        };

            $.ajax({
                url: "includes/register-staff.php",
                type: "POST",
                data: formData,
                
                success: function(response) {
                    console.log("inside");
                    response = response.trim();
                    console.table(response);     
                    if(response === "Registration Success"){

                        Swal.fire({
                            title: 'Success!',
                            text: 'New Staff Account Created!',
                            icon: 'success'
                        });

                        console.log("inside success");
                        // $("#registerModalMsg").empty();
                        // $("#registerModalMsg").append("<div class='alert alert-success' role='alert'><span>Registration Success</span></div>");
                        // // Clear the form fields
                        $("#signUpForm")[0].reset();

                            $.ajax({
                                url: "includes/staff-list.php",
                                type: "POST",
                                data: {
                                    updatedStaff : "true"
                                },
                                success: function(response) {
                                    var table = $('#myTable').DataTable();

                                    // Clear all existing rows from the table
                                    table.clear().draw();
                                    
                                    // Parse response into individual rows
                                    var newRows = $(response).filter('tr'); // Extract the rows from the response
                                    
                                    // Add each row dynamically
                                    newRows.each(function() {
                                        var row = $(this);  // Get the entire row (including classes, ids, etc.)
                                    
                                        // Extract and reorder columns using class names (optional, if needed for data)
                                        var rowData = [];
                                        rowData.push(row.find('.staff_id').html());  // Instructor Code (First column)
                                        rowData.push(row.find('.staff_id_text').html());  // Instructor Code (First column)
                                        rowData.push(row.find('.staff_name').html());     // Instructor Name
                                        rowData.push(row.find('.staff_email').html());    // Email
                                        rowData.push(row.find('.staff_status').html());   // Status
                                        rowData.push(row.find('.view_staff_profile').parent().html()); // Edit action
                                    
                                        // Add the full row with classes and data to the DataTable
                                        table.row.add(row[0]).draw(false);  // Add the entire row, not just the data
                                    });
                                    
                                    // Hide the first column if necessary (using DataTables)
                                    table.columns([0]).visible(false);
                                    
                                    },
                                error: function(xhr, status, error) {
                                    console.log("error here");
                                    console.log(error);
                                }
                            });

                    }else{
                        Swal.fire({
                            title: 'Error!',
                            text: response,
                            icon: 'error'
                        });
                        // $("#registerModalMsg").empty();
                        // $("#registerModalMsg").append("<div class='alert alert-danger' role='alert'><span>"+ response +"</span></div>");
                        // console.log("Error");
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'Error Encountered!',
                        text: error,
                        icon: 'error'
                    });
                    console.log("error here");
                    console.log(error);
                }
            });
       

    });

            // Clear modal messages when the modal is closed
            $("#signUpModal").on('hidden.bs.modal', function() {
                $("#registerModalMsg").empty(); // Clear any appended messages
                $("#signUpForm")[0].reset();    // Ensure form fields are reset
            });

});