$(document).ready(function () {
    // console.log("Max " + maxPoints);
    let points = 1;
    let maxPoints = parseInt($("#max-points").text());
    $("#points").on("input", function() {
         points = parseInt($(this).val()); 
         maxPoints = parseInt($("#max-points").text()); 
    
        console.log(points, maxPoints); 
        if (points > maxPoints) {
            Swal.fire({
                title: 'Invalid!',
                text: 'Points cannot exceed the maximum limit.',
                icon: 'error'
            });
            $(this).val(maxPoints);
        }
    });

    $(document).on('click', '#grade-btn', function (e) {
        // const urlParams = new URLSearchParams(window.location.search);
        const classCode = $(".class-code").text();
        const postId = $(".post-id").text();
        const userId = $(".user-id").text();
        const status = $(".submit-status").text();
        const submitGrade = true;
        e.preventDefault();
        console.log("Grade click");
        // console.log( "status"+status);
        // console.log(userId);
        // console.log(classCode);
        // console.log(postId);

        $.ajax({
            method: "POST",
            url: "includes/grading.php",
            data: {
              'points': points,
              'maxPoints': maxPoints,
              'classCode': classCode,
              'postId': postId,
              'userId' : userId,
              'status': status,
              'submit': submitGrade
            },
      
            success: function(response) {
                console.log(response);

                Swal.fire({
                    title: 'Success!',
                    text: 'Grade Submitted!',
                    icon: 'success'
                });

                $("#grading-container").empty();
                $("#grading-container").append(`   <a href="#" id="edit-grade">
                                                            <div class="container-fluid green shadow-elevation-dark-1 rounded-3">
                                                                <div class="d-flex justify-content-center align-items-center p-2">
                                                                    <span class="white2 fw-semibold mb-0">Edit Grade</span>
                                                                </div> 
                                                            </div>
                                                        </a>`);
            },
            error: function(xhr, status, error) {
              console.log("Status "+ status + " An error occured" + error)
            }
          });
    });

    $(document).on('click', '#edit-grade', function (e) {
        // const urlParams = new URLSearchParams(window.location.search);
        const classCode = $(".class-code").text();
        const postId = $(".post-id").text();
        const userId = $(".user-id").text();
        const status = $(".submit-status").text();
        const submitGrade = false;
        e.preventDefault();
        console.log("Grade click");
        // console.log( "status"+status);
        // console.log(userId);
        // console.log(classCode);
        // console.log(postId);

        $.ajax({
            method: "POST",
            url: "includes/grading.php",
            data: {
              'points': points,
              'maxPoints': maxPoints,
              'classCode': classCode,
              'postId': postId,
              'userId' : userId,
              'status': status,
              'submit': submitGrade
            },
      
            success: function(response) {
                console.log(response);

                Swal.fire({
                    title: 'Success!',
                    text: 'Grade Updated!',
                    icon: 'success'
                });

                $("#grading-container").empty();
                $("#grading-container").append(`   <a href="#" id="edit-grade">
                                                            <div class="container-fluid green shadow-elevation-dark-1 rounded-3">
                                                                <div class="d-flex justify-content-center align-items-center p-2">
                                                                    <span class="white2 fw-semibold mb-0">Edit Grade</span>
                                                                </div> 
                                                            </div>
                                                        </a>`);
            },
            error: function(xhr, status, error) {
              console.log("Status "+ status + " An error occured" + error)
            }
          });
    });


});