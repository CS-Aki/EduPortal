$(document).ready(function () {

    let announcements = []; 
    let currentIndex = 0;  
    
    $.ajax({
        url: "includes/announce.php",
        type: "POST",
        data: {
            newAnnouncement: "true"
        },
        success: function(response) {
            console.table(response);
    
            announcements = response;
            currentIndex = 0;
            if(announcements.length == 1){
                $("#next-btn").hide();
            }
    
            if (announcements.length > 0) {
                showAnnouncement(currentIndex); // Show first announcement
            }
        },
        error: function(xhr, status, error) {
            console.log("Error:", error);
        }
    });
    
    function showAnnouncement(index) {
        const element = announcements[index];
    
        var dateObj = new Date(element["start_date"]);
        var formattedDate = dateObj.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    
        $("#date-text").text(formattedDate);
    
        const msgTypeClass = {
            "1": "general",
            "2": "maintenance",
            "3": "exam"
        };
        $('#announcement-type').attr('class', `container-fluid rounded-top-4 ${msgTypeClass[element["msg_type"]] || ""}`);
    
        const userCategories = {
            "4": "To All Students",
            "5": "To Everyone",
            "3": "To All Instructors",
            "2": "To All Staff"
        };
        const recipient = userCategories[element["user_category"]] || "To Everyone";
    
        $("#announcement-title").text(element["title"]);
        $("#content").text(`${recipient},\n\n${element["message"]}\n\nWarm regards,\nThe EduPortal Admin Team\nEduPortal`);
    
        $('#announceModal').modal('show');
    }
    
    $("#next-btn").on('click', function() {
        currentIndex++; 
    
        if (currentIndex < announcements.length) {
            showAnnouncement(currentIndex); // Show next announcement
        } else {
            $('#announceModal').modal('hide'); 
        }
    });
    
    });