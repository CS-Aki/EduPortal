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
            password: $("#password").val(),
            repeatPass: $("#repeat_pass").val()
        };

            $.ajax({
                url: "includes/register-instructor.php",
                type: "POST",
                data: formData,
                
                success: function(response) {
                    // console.log("inside");
                    response = response.trim();
                    console.table(response);     
                    if(response === "Registration Success"){
                        console.log("inside success");
                        $("#registerModalMsg").empty();
                        $("#registerModalMsg").append("<div class='alert alert-success' role='alert'><span>Registration Success</span></div>");
                        // Clear the form fields
                       
                        $("#signUpForm")[0].reset();
                       

                    }else{
                        $("#registerModalMsg").empty();
                        $("#registerModalMsg").append("<div class='alert alert-danger' role='alert'><span>"+ response +"</span></div>");
                        // console.log("Error");
                    }
                },
                error: function(xhr, status, error) {
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