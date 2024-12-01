$(document).ready(function() {
    // Handles sign-in form modal, elements of the error msg can be found in log and reg backend/classes/controller.Login.php and inside model.User.php under IsUserCredential function
    $("#close_code").click(function(){
        $(".join-class-msg").text("");
        $("#class_code").val("");
    });

    $("#joinClassForm").submit(function(event) {
        event.preventDefault();

        var class_code = $("#class_code").val();
        var joinClassBtn = $("#join_class_btn").val();
        console.log(class_code);
        $.ajax({
            url: "student%20backend/includes/join-class.php",
            type: "POST",
            data: {
                class_code : class_code,
                joinClassBtn : joinClassBtn
            },

            success: function(response) {
                $(".join-class-msg").html(response);
                if (response.includes("Joined Class Successfully")) {
                    $("#class-container").load("student%20backend/includes/load-classes.php", {
                        newClass : true
                    });
                }
            },
            error: function(xhr, status, error) {
                $(".join-class-msg").html("An error occurred: " + error);
            }
        });
    });

});