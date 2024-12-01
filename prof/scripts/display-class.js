$(document).ready(function() {

    $('.dislay-class').click(function(e) {
      e.preventDefault();
      var class_code = $(this).closest('div').find('.class-code').text();
      var class_name = $(this).closest('div').find('.class-name').text();
      $.ajax({
        method: "GET",
        url: "includes/display-class.php",
        data: {
          'class-code': class_code,
        },

        success: function(response) {
        
          console.log(response);
          // Transfer the response from this script to the script below (inside prof dashboard php)
          sessionStorage.setItem("classDetails", JSON.stringify(response));
          window.location.href = "prof-dashboard.php?class=" + md5(response[0]["class_code"]);
        },
        error: function(xhr, status, error) {
          console.log("Status "+ status + " An error occured" + error)
          // sessionStorage.setItem("classDetails", JSON.stringify(class_name));
          // window.location.href = "prof-dashboard.php?class=" + md5(class_code);
          //$(".sign-up-msg").html("An error occurred: " + error);
        }
      });

    });

  });