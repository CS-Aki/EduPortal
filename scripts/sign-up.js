
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
        var middleName = $("#middle_name").val();
        var birthdate = $("#date_of_birth").val();
        var lastName = $("#last_name").val();
        var gender = $("#gender").val();
        var address = $("#address").val();
        var email = $("#email").val();
        var password = $("#password").val();
        var repeatPass = $("#repeat_pass").val();
        var registerBtn = $("#register_btn").val();
  
        console.log(middleName);

        $.ajax({
            url: "log%20and%20reg%20backend/includes/register.inc.php",
            type: "POST",
            data: {
                firstName : firstName,
                middleName : middleName,
                lastName : lastName,
                email: email,
                password: password,
                repeatPass : repeatPass,
                registerBtn: registerBtn,
                birthdate : birthdate,
                gender : gender,
                address : address
            },
            
            success: function(response) {
     
                $(".sign-up-msg").html(response);
                if (response.includes("REGISTRATION SUCCESSFULLY")) {
    
                    $('#signUpForm').removeClass('was-validated');
                    $("#first_name, #last_name, #middle_name, #email, #password, #repeat_pass, #date_of_birth").val("");
                    $("#gender").val("blank");
                              
                }
            },
            error: function(xhr, status, error) {
                $(".sign-up-msg").html("An error occurred: " + error);
            }
        });
    });
    

});