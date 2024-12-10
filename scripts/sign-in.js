$(document).ready(function() {
    // Handles sign-in form modal, elements of the error msg can be found in log and reg backend/classes/controller.Login.php and inside model.User.php under IsUserCredential function
    
    $("#close_modal").click(function(){
        $("#email1, #password1").val("");
        $(".form-message").text("");
        $('#signInForm').removeClass('was-validated');
        console.log("closing");
        // unsetSession();
    });

    $("#goSignUp").click(function(){
        $("#email1, #password1").val("");
        $(".form-message").text("");
        $('#signInForm').removeClass('was-validated');
        console.log("to sign up");
    });

    $("#signInModal").on("shown.bs.modal", function () {
        $("#email1, #password1").val("");
        $(".form-message").text("");
        $('#signInForm').removeClass('was-validated');
        // console.log("display");
    });

    $("#signInModal").on("hidden.bs.modal", function () {
        $("#email1, #password1").val("");
        $(".form-message").text("");
        $('#signInForm').removeClass('was-validated');
        // console.log("display");
    });

    
    $("#signInForm").submit(function(event) {
        event.preventDefault();
        console.log("clicked");
        var email = $("#email1").val();
        var password = $("#password1").val();
        var loginBtn = $("#login_btn").val();
        
        $.ajax({
            url: "log%20and%20reg%20backend/includes/login.inc.php",
            type: "POST",
            data: {
                email: email,
                password: password,
                loginBtn: loginBtn
            },

            success: function(response) {
                console.log(response);
                if (response.includes("Login Successfully")) {
                    if(response.includes("3")){
                        window.location.href = "instructor/instructor-dashboard.php";
                    }else if(response.includes("4")){
                        window.location.href = "student/student-dashboard.php";
                    }else if(response.includes("2")){

                    }else if(response.includes("1")){
                        window.location.href = "admin/admin-dashboard.php";
                    }
                    // $(".form-message").text("");
                    return;
                }else{
                    $(".form-message").html(response);
                }
            },
            error: function(xhr, status, error) {
                $(".form-message").html("An error occurred: " + error);
            }
        });
    });



});