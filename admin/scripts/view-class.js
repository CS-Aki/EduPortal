$(document).ready(function() {

    $(document).on('click', '.view_class', function (e) {
        e.preventDefault();
        var class_code = $(this).closest('tr').find('.class_code').text();
        // var class_name = $(this).closest('tr').find('.class_name').text();
        console.log(class_code);
        // console.log(class_name);
        $("#studentTable tbody").empty();

        $.ajax({
            url: "includes/class-list.php",
            type: "POST",
            data: {
                classCode : class_code
            },
            
            success: function(response) {
                // console.log("inside");
                // console.table(response);

                if (response.noStudent) {
                    console.log("Class:", response.class[0]["class_name"]);
                    // console.error(response.error);
                } else {
                    console.log("Class:", response.class);
                    console.log("Class Details:", response.classDetail);
                }
                let dayMatch = response.class[0]["class_schedule"].match(/\((.*?)\)/);
                let daySched = dayMatch ? dayMatch[1] : "";

                let timeRange = response.class[0]["class_schedule"].replace(/\(.*?\)\s*/, "");
                let [startTime, endTime] = timeRange.split("-");                

                let startMatch = startTime.trim().match(/(\d{1,2}):(\d{2})\s*(AM|PM)/);
                let startHours = startMatch[1];
                let startMinutes = startMatch[2];
                let startPeriod = startMatch[3];

                let endMatch = endTime.trim().match(/(\d{1,2}):(\d{2})\s*(AM|PM)/);
                let endHours = endMatch[1];
                let endMinutes = endMatch[2];
                let endPeriod = endMatch[3];

                console.log("Minutes" + startMinutes);
                console.log("End" + endMinutes);
                $("#title_class_name").text(response.class[0]["class_name"]);
                $("#class_name").val(response.class[0]["class_name"]);
                $("#class_code").val(response.class[0]["class_code"]);
                $("#class_status").val(response.class[0]["class_status"]);
                $("#class_instructor").val(response.class[0]["class_teacher"]);
                $("#daySched").val(daySched);
                $("#startingHourSched").val(startHours);
                $("#startingMinuteSched").val(startMinutes);
                $("#startingPeriodSched").val(startPeriod);
                $("#endingHourSched").val(endHours);
                $("#endingMinuteSched").val(endMinutes);
                $("#endingPeriodSched").val(endPeriod);

                var dataTable = $("#studentTable").DataTable();
                // Clear existing table rows
                dataTable.clear().draw();
                
                if(response.classDetail){ 
                    console.log("inside");
                    
                    for(let i = 0; i < response.classDetail.length; i++){
                        let paddedId = "2024" + response.classDetail[i]["user_id"].toString().padStart(4, '0');
                        dataTable.row.add([
                            paddedId, // First column
                            response.classDetail[i]["name"],   // Second column
                            response.classDetail[i]["email"],  // Third column
                        ]);
                        // table.append("<tr><td>" + response.classDetail[i]["user_id"] + "</td><td>" + response.classDetail[i]["name"] + "</td><td>" + response.classDetail[i]["email"] + "</td></tr>");
                    }

                    dataTable.draw();

                }

                $('#editClassModal').modal('show');          
            
            },
            error: function(xhr, status, error) {
                console.log("error here");
                console.log(error);
            }
        });

    });
});