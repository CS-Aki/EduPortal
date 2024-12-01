$(document).ready(function() {

    $("#createClassModal").on("shown.bs.modal", function () {
        // console.log("display");
    });

    $("#createClassModal").on("hidden.bs.modal", function () {
        $("#create_message").empty();
        $("#create_status").val("Active");
        $("#create_name").val("");
        $("#create_instructor").val("");
        $("#createDay").val("Monday");
        $("#createStartingHourSched").val("");
        $("#createStartingMinuteSched").val("");
        $("#createStartingPeriodSched").val("");
        $("#createEndingHourSched").val("");  
        $("#createEndingMinuteSched").val("");
        $("#createEndingPeriodSched").val("");
        // console.log("display");
    });

    $("#createForm").submit(function(event) {
        event.preventDefault();
        console.log("click");
        let classCode = $("#create_code").val();
        let classStatus = $("#create_status").val();
        let className = $("#create_name").val();
        let classProf = $("#create_instructor").val();

        let daySched = $("#createDay").val();
        let startingHour = $("#createStartingHourSched").val();
        let startingMin = $("#createStartingMinuteSched").val();
        let startingPeriod = $("#createStartingPeriodSched").val();
        let endingHour = $("#createEndingHourSched").val();
        let endingMin = $("#createEndingMinuteSched").val();
        let endingPeriod = $("#createEndingPeriodSched").val();
        
        $.ajax({
            url: "includes/add-class.php",
            type: "POST",
            data: {
                classCode : classCode,
                classStatus : classStatus,
                className : className,
                classProf : classProf,
                daySched : daySched,
                startingHourSched : startingHour,
                startingMinSched : startingMin,
                startTimePeriod : startingPeriod,
                endingHourSched : endingHour,
                endingMinSched : endingMin,
                endTimePeriod : endingPeriod
            },
            
            success: function(response) {
                if(response.includes("New Class Successfully Added")){
                    $("#create_message").empty();
                    $("#create_message").append("<div class='alert alert-success' role='alert'><span>"+response+"</span></div>"); 
                }else{
                    $("#create_message").empty();
                    $("#create_message").append("<div class='alert alert-danger' role='alert'><span>"+response+"</span></div>");   
                }
            },
            error: function(xhr, status, error) {
                console.log("error here");
                console.log(error);
            }
        });
    });

});