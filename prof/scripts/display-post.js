$(document).ready(function () {

    $('.display-post').click(function (e) {
        e.preventDefault();

        // Used to get the class code
        let responseData = JSON.parse(sessionStorage.getItem("classDetails"));
        
        var title =  $(this).closest('div').find('.post-title').text();
        var class_code = responseData[0]["class_code"];
        console.log("class code " + responseData[0]["class_code"]);
        console.log("Title " + title);
               
        // var class_name = $(this).closest('div').find('.class-name').text();
        $.ajax({
            method: "GET",
            url: "includes/display-post.php",
            data: {
                'title': title,
                'class-code': class_code,
            },

            success: function (response) {

                console.log(response);
                // Transfer the response from this script to the script below (inside prof dashboard php)
                // sessionStorage.setItem("classDetails", JSON.stringify(response));
                window.location.href = "prof-dashboard.php?class=" + md5(class_code) + "&post=" + md5(title);
            },
            error: function (xhr, status, error) {
                console.log("Status " + status + " An error occured" + error)
                // sessionStorage.setItem("classDetails", JSON.stringify(class_name));
                // window.location.href = "prof-dashboard.php?class=" + md5(class_code);
                //$(".sign-up-msg").html("An error occurred: " + error);
            }
        });

    });

});