
$(document).ready(function() {
   
    $("#close_btn").click(function(){
        // console.log("click");
        $(".sign-up-msg").text("");
        $('#signUpForm').removeClass('was-validated');
        $("#first_name, #last_name, #email, #password, #repeat_pass").val("");

    });

    $("#goSignIn").click(function(){
        // console.log("to sign in");
        $(".sign-up-msg").text("");
        $('#signUpForm').removeClass('was-validated');
        $("#first_name, #last_name, #email, #password, #repeat_pass").val("");
    });

    $("#signUpBtn").click(function(){
        // console.log("inside sign up");
        window.location.href = "google-oauth.php";
    });

    var invalidChars = /[^a-zA-Z\s\.]/;

    function validateField(field, value) {
        if (invalidChars.test(value) || value == "") {
            $(field).removeClass("is-valid").addClass("is-invalid");
        } else {
            $(field).removeClass("is-invalid").addClass("is-valid");
        }
    }
    
    function resetValidation() {
        $("#first_name, #middle_name, #last_name").removeClass("is-valid is-invalid");
        $("#password, #repeat_pass").removeClass("is-valid is-invalid");
        console.log("reseting");
    }


    $("#first_name, #middle_name, #last_name").on("input", function () {
        validateField(this, $(this).val());
    });

    $("#password, #repeat_pass").on("input", function () {
        var password1 = $("#password").val();
        var repeatPass1 = $("#repeat_pass").val();

        if(password1.length < 4 || repeatPass1.length < 4 || password1 != repeatPass1){
             console.log("invalid");
             $("#password").removeClass("is-valid").addClass("is-invalid");
             $("#repeat_pass").removeClass("is-valid").addClass("is-invalid");
        }else{
            $("#password").removeClass("is-invalid").addClass("is-valid");
            $("#repeat_pass").removeClass("is-invalid").addClass("is-valid");

        }
    });

    $("#signUpForm").on("submit", function (event) {
        event.preventDefault();

        validateField("#first_name", $("#first_name").val());
        validateField("#middle_name", $("#middle_name").val());
        validateField("#last_name", $("#last_name").val());

        if (!$('.is-invalid').length) {
            this.submit(); 
        }
    });



    $("#signUpModal").on("hidden.bs.modal", function () {
        $.ajax({
            url: 'log and reg backend/includes/unset-session.php', // URL to your PHP script
            type: 'POST',
            success: function(response) {
                console.log('Session variable unset:', response);
            }
        });

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
  
       if (gender == "") {
            $("#gender").addClass("is-invalid");
        } else {
            $("#gender").removeClass("is-invalid");
        }
        
        // validateField("#first_name", firstName);
        // validateField("#middle_name", middleName);
        // validateField("#last_name", lastName);
        
        // if(password.length < 4 || repeatPass.length < 4 || password != repeatPass){
        //      console.log("invalid inside");
        //      $("#password").removeClass("is-valid").addClass("is-invalid");
        //      $("#repeat_pass").removeClass("is-valid").addClass("is-invalid");
        // }

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
                // $(".sign-up-msg").html(response);
                if (response.includes("REGISTRATION SUCCESSFULLY")) {
                    Swal.fire({
                        title: 'Success!!',
                        text: "User Account Successfully Registered!",
                        icon: 'success'
                    }); 
                    
                    $('#signUpForm').removeClass('was-validated');
                    $("#first_name, #last_name, #middle_name, #email, #password, #repeat_pass, #date_of_birth").val("");
                    $("#gender").val("blank");
                    $("#signUpModal").modal("hide");

                }else {
                    $("#signUpForm").removeClass("was-validated");
                    // resetValidation();
                    Swal.fire({
                        title: 'Invalid!',
                        text: response,
                        icon: 'error'
                    }); 
                }
            },
            error: function(xhr, status, error) {
                $(".sign-up-msg").html("An error occurred: " + error);
            }
        });
    });
    

});

//   document.addEventListener("DOMContentLoaded", () => {
//         const form = document.getElementById("signUpForm");

//         form.addEventListener("submit", (event) => {
//             // Prevent default form submission to validate manually
//             if (!form.checkValidity()) {
//                 event.preventDefault();
//                 event.stopPropagation();

//                 // Add validation feedback classes
//                 Array.from(form.elements).forEach((element) => {
//                     if (!element.checkValidity()) {
//                         element.classList.add("is-invalid");
//                     } else {
//                         element.classList.remove("is-invalid");
//                     }
//                 });
//             } else {
//                 // Optional: Handle form submission logic if needed
//                 console.log("Form is valid!");
//             }

//             form.classList.add("was-validated");
//         });

//         // Optional: Remove red border on input change
//         Array.from(form.elements).forEach((element) => {
//             element.addEventListener("input", () => {
//                 if (element.checkValidity()) {
//                     element.classList.remove("is-invalid");
//                 }
//             });
//         });
//     });