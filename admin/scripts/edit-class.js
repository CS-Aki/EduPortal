$(document).ready(function() {
    let isChange = false;
    let tempClassName = "";
    var table = $('#myTable').DataTable();
   
    $(document).on('hidden.bs.modal', '#editClassModal', function () {
        // console.log('Modal is hidden');
        $("#message").empty();
    });

    var classProfId = 0;
    var classProf = "";

    $('#class_instructor').change(function() {
        var selectedOption = $(this).find('option:selected');
        
        classProfId = selectedOption.val(); 
        classProf = selectedOption.text();

    });


    $("#editClassModal").on("shown.bs.modal", function () {
        // Capture the initial values of modal fields
        tempClassName = $("#class_name").val();
        window.initialFormValues = {
            className: $("#class_name").val(),
            classCode: $("#class_code").val(),
            classStatus: $("#class_status").val(),
            classProf: $("#class_instructor").val(),
            daySched: $("#daySched").val(),
            startingHour: $("#startingHourSched").val(),
            startingMin: $("#startingMinuteSched").val(),
            startingPeriod: $("#startingPeriodSched").val(),
            endingHour: $("#endingHourSched").val(),
            endingMin: $("#endingMinuteSched").val(),
            endingPeriod: $("#endingPeriodSched").val(),
        };
    });

    $("#editClassForm").submit(function(event) {

        let currentValues = {
            className: $("#class_name").val(),
            classCode: $("#class_code").val(),
            classStatus: $("#class_status").val(),
            classProf: $("#class_instructor").val(),
            daySched: $("#daySched").val(),
            startingHour: $("#startingHourSched").val(),
            startingMin: $("#startingMinuteSched").val(),
            startingPeriod: $("#startingPeriodSched").val(),
            endingHour: $("#endingHourSched").val(),
            endingMin: $("#endingMinuteSched").val(),
            endingPeriod: $("#endingPeriodSched").val(),
        };
     
        let isChanged = false;
        for (let key in currentValues) {
            if (currentValues[key] !== window.initialFormValues[key]) {
                isChanged = true;
                isChange = true;
                console.log(`Field "${key}" has changed from "${window.initialFormValues[key]}" to "${currentValues[key]}"`);
            }
        }

        // Not working
        for (let key in currentValues) {
            if (currentValues[key] !== window.initialFormValues[key]) {
                console.log(currentValues[key]);
                $(`#${key}`).addClass("changed"); // Add a CSS class to highlight
            } else {
                $(`#${key}`).removeClass("changed"); // Remove the highlight if unchanged
            }
        }
        
        event.preventDefault();

        let className = $("#class_name").val();
        let classCode = $("#class_code").val();
        let classStatus = $("#class_status").val();
        let classProf = $("#class_instructor").find('option:selected').text();
        let classProfId = $("#class_instructor").val();
        let daySched = $("#daySched").val();
        let startingHour = $("#startingHourSched").val();
        let startingMin = $("#startingMinuteSched").val();
        let startingPeriod = $("#startingPeriodSched").val();
        let endingHour = $("#endingHourSched").val();
        let endingMin = $("#endingMinuteSched").val();
        let endingPeriod = $("#endingPeriodSched").val();

        if(isChange != false){
            $.ajax({
                url: "includes/edit-class.php",
                type: "POST",
                data: {
                    className : className,
                    tempClassName : tempClassName,
                    classCode : classCode,
                    classStatus : classStatus,
                    classProfId : classProfId,
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
                    $("#message").empty();
                    tempClassName = className;
                    if(response.includes("Edit Successfully")){
                        isChange = false;
                        window.initialFormValues = {
                            className: $("#class_name").val(),
                            classCode: $("#class_code").val(),
                            classStatus: $("#class_status").val(),
                            classProf: $("#class_instructor").val(),
                            daySched: $("#daySched").val(),
                            startingHour: $("#startingHourSched").val(),
                            startingMin: $("#startingMinuteSched").val(),
                            startingPeriod: $("#startingPeriodSched").val(),
                            endingHour: $("#endingHourSched").val(),
                            endingMin: $("#endingMinuteSched").val(),
                            endingPeriod: $("#endingPeriodSched").val(),
                        };

                        console.log(classCode);

                        var row = table.rows().every(function() {
                            var rowData = this.data();  // Get data for the current row
                            
                            if (rowData[0] === classCode) {  // Assuming class_code is in the first column (index 0)
                                console.log(rowData[0]);
                                rowData[1] = className;
                                rowData[2] = classProf;
                                rowData[3] = "(" + daySched + ")" + " " + startingHour + ":" + startingMin + " " + startingPeriod + "-" + endingHour + ":" + endingMin + " " + endingPeriod;
                                rowData[4] = classStatus;

    
                                this.data(rowData).draw(false);
                                // Once the row is found, stop further iterations
                                return false;  // This will break out of the loop
                            }
                        });

                        $("#message").empty();
                        $("#message").append("<div class='alert alert-success' role='alert'><span>Update Successfully</span></div>");

                    }else{
                    
                        $("#message").append("<div class='alert alert-danger' role='alert'><span>"+response+"</span></div>");
                    }
                
                },
                error: function(xhr, status, error) {
                    console.log("error here");
                    console.log(error);
                }
            });
        }else{
            $("#message").empty();
            $("#message").append("<div class='alert alert-danger' role='alert'><span>No Changes Made</span></div>");
            console.log("no changes ");
        }
        
    });
     // console.log(className);
            // console.log(classCode);
            // console.log(classStatus);
            // console.log(classProf);
            
            // console.log(daySched);
            // console.log(startingHour);
            // console.log(startingMin);
            // console.log(startingPeriod);
            // console.log(endingHour);
            // console.log(endingMin);
            // console.log(endingPeriod);

    
});