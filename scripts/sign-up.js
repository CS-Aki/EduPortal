
$(document).ready(function() {
   
    $("#close_btn").click(function(){
        console.log("click");
        $(".sign-up-msg").text("");
        $('#signUpForm').removeClass('was-validated');
        $("#first_name, #last_name, #email, #password, #repeat_pass").val("");

    });

    $("#goSignIn").click(function(){
        console.log("to sign in");
        $(".sign-up-msg").text("");
        $('#signUpForm').removeClass('was-validated');
        $("#first_name, #last_name, #email, #password, #repeat_pass").val("");
    });

    $("#signUpModal").on("shown.bs.modal", function () {
             $(".sign-up-msg").text("");
        $('#signUpForm').removeClass('was-validated');
        $("#first_name, #last_name, #email, #password, #repeat_pass").val("");

        // console.log("display");
    });

    $("#signUpModal").on("hidden.bs.modal", function () {
        $(".sign-up-msg").text("");
        $('#signUpForm').removeClass('was-validated');
        $("#first_name, #last_name, #email, #password, #repeat_pass").val("");
        // console.log("display");
    });

    $("#signUpForm").submit(function(event) {
        event.preventDefault();

        var firstName = $("#first_name").val();
        var lastName = $("#last_name").val();
        var email = $("#email").val();
        var password = $("#password").val();
        var repeatPass = $("#repeat_pass").val();
        var registerBtn = $("#register_btn").val();
    
        $.ajax({
            url: "log%20and%20reg%20backend/includes/register.inc.php",
            type: "POST",
            data: {
                firstName : firstName,
                lastName : lastName,
                email: email,
                password: password,
                repeatPass : repeatPass,
                registerBtn: registerBtn
            },
            
            success: function(response) {
     
                $(".sign-up-msg").html(response);
                if (response.includes("REGISTRATION SUCCESSFULLY")) {
    
                    $('#signUpForm').removeClass('was-validated');
                    $("#first_name, #last_name, #email, #password, #repeat_pass").val("");
                              
                }
            },
            error: function(xhr, status, error) {
                $(".sign-up-msg").html("An error occurred: " + error);
            }
        });
    });
    

});