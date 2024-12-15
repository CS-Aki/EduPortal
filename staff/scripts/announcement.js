$(document).ready(function() {

    $("#announcementForm").submit(function(event) {
        event.preventDefault();

        let subject= $("#subject").val();
        let fromDate = $("#from_date").val();
        let toDate = $("#to_date").val();
        let msgType = $("#msg_type").val();
        let audience = $("#audience_visible").val();
        let message = $("#message-content").val();

        // console.log("Subject " + subject);
        // console.log("From date " + fromDate);
        // console.log("To date " + toDate);
        // console.log("Message type " + msgType);
        // console.log("Audience " + audience);
        // console.log("Message " + message);

        $.ajax({
            url: "includes/announcement.php",
            type: "POST",
            data: {
                subject : subject,
                fromDate : fromDate,
                toDate : toDate,
                msgType : msgType,
                audience : audience,
                message : message
            },
            
            success: function(response) {
                 console.log(response);
                    $.ajax({
                        url: "includes/announcement.php",
                        type: "POST",
                        data: {
                            newAnnouncement : "true"
                        },
                        success: function(response) {
                            // console.log(response);
                            $("#announce-container").empty();
                            $("#announce-container").html(response);

                            $("#subject").val("");
                            $("#from_date").val("");
                            $("#to_date").val("");
                            $("#msg_type").val("");
                            $("#audience_visible").val("");
                            $("#message-content").val("");
                        },
                        error: function(xhr, status, error) {
                            console.log("error here");
                            console.log(error);
                        }
                    });

            },
            error: function(xhr, status, error) {
                console.log("error here");
                console.log(error);
            }
        });
    });

    $(document).on('click', '.view-announcement', function (e) {    
        e.preventDefault();
        console.log("view announcement");
        let announceId = $(this).find(".announce-id").text();
        console.log(announceId);

        $.ajax({
            url: "includes/announcement.php",
            type: "POST",
            data: {
                announceId : announceId
            },
            
            success: function(response) {
               console.table(response);
               console.log(response[0]["title"]);

               var dateObj = new Date(response[0]["start_date"]);

               var formattedDate = dateObj.toLocaleDateString('en-US', {
                   year: 'numeric',
                   month: 'long',  
                   day: 'numeric'
               });

               $("#date-text").text(formattedDate);

               if(response[0]["msg_type"] == "1"){  // General
                $('#announcement-type').attr('class', 'container-fluid rounded-top-4 general');
               }else if(response[0]["msg_type"] == "2"){ // Maintenance
                $('#announcement-type').attr('class', 'container-fluid rounded-top-4 maintenance');
               }else if(response[0]["msg_type"] == "3"){ // Exam
                $('#announcement-type').attr('class', 'container-fluid rounded-top-4 exam');
               } 


               if(response[0]["user_category"] == "4"){  // Student
                $("#announcement-title").text(response[0]["title"]);
                $("#content").text(`         To All Students, \n\n${response[0]["message"]} \n\n
Warm regards,
The EduPortal Admin Team
EduPortal`);
               }
               else if(response[0]["user_category"] == "5"){  // All
                $("#announcement-title").text(response[0]["title"]);
                $("#content").text(`         To Everyone, \n\n${response[0]["message"]} \n\n
Warm regards,
The EduPortal Admin Team
EduPortal`);
               }
               else if(response[0]["user_category"] == "3"){  // Prof
                $("#announcement-title").text(response[0]["title"]);
                $("#content").text(`         To All Instructors, \n\n${response[0]["message"]} \n\n
Warm regards,
The EduPortal Admin Team
EduPortal`);
               }
               else if(response[0]["user_category"] == "2"){   // Staf
                $("#announcement-title").text(response[0]["title"]);
                $("#content").text(`         To All Staff, \n\n${response[0]["message"]} \n\n
Warm regards,
The EduPortal Admin Team
EduPortal`);
               }

               $('#announceModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.log("error here");
                console.log(error);
            }
        });

    });
});