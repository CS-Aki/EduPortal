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

    var classProfId = 0;
    var classProf = "";

    $('#create_instructor').change(function() {
        var selectedOption = $(this).find('option:selected');
        
        classProfId = selectedOption.val(); 
        classProf = selectedOption.text();

    });

    $("#createForm").submit(function(event) {
        event.preventDefault();
        console.log("click");
        let classCode = $("#create_code").val();
        let classStatus = $("#create_status").val();
        let className = $("#create_name").val();
        let daySched = $("#createDay").val();
        let startingHour = $("#createStartingHourSched").val();
        let startingMin = $("#createStartingMinuteSched").val();
        let startingPeriod = $("#createStartingPeriodSched").val();
        let endingHour = $("#createEndingHourSched").val();
        let endingMin = $("#createEndingMinuteSched").val();
        let endingPeriod = $("#createEndingPeriodSched").val();
        console.log(classProfId);
        console.log(classProf);

        $.ajax({
            url: "includes/add-class.php",
            type: "POST",
            data: {
                classCode : classCode,
                classStatus : classStatus,
                className : className,
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
                
                if(response.includes("New Class Successfully Added")){

                    Swal.fire({
                        title: 'Success!',
                        text: 'New Class Successfully Added!',
                        icon: 'success'
                    });

                    $.ajax({
                        url: "includes/class-list.php",
                        type: "POST",
                        data: {
                            createClass : "true"
                        },
                        success: function(response) {
                            
                            

                            var table = $('#myTable').DataTable();

                            // Clear all existing rows from the table
                            table.clear().draw();
                            
                            // Parse response into individual rows
                            var newRows = $(response).filter('tr'); // Extract the rows from the response
                            
                            // Add each row dynamically
                            newRows.each(function() {
                                var row = $(this);  // Get the entire row (including classes, ids, etc.)
                            
                                // Extract and reorder columns using class names (optional, if needed for data)
                                var rowData = [];
                                rowData.push(row.find('.class_code').html());  // Instructor Code (First column)
                                rowData.push(row.find('.class_name').html());  // Instructor Code (First column)
                                rowData.push(row.find('.class_teacher').html());     // Instructor Name
                                rowData.push(row.find('.class_schedule').html());    // Email
                                rowData.push(row.find('.class_status').html());   // Status
                                rowData.push(row.find('.view_class').parent().html()); // Edit action
                            
                                // Add the full row with classes and data to the DataTable
                                table.row.add(row[0]).draw(false);  // Add the entire row, not just the data
                            });
                            
                            $("#create_message").empty();
                            // $("#create_message").append("<div class='alert alert-success' role='alert'><span>SUCCESS</span></div>"); 

                        },
                        error: function(xhr, status, error) {
                            console.log("error here");
                            console.log(error);
                        }
                    });

                }else{      
                    Swal.fire({
                        title: 'Invalid!',
                        text: response,
                        icon: 'error'
                    });   
                }
            },
            error: function(xhr, status, error) {
                console.log("error here");
                console.log(error);
            }
        });
    });

});