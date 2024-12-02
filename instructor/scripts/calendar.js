$(document).ready(function () {
    let className = [];
    let classCode = [];
    let day = [];
    let startTime = [];
    let endTime = [];

    $.ajax({
        url: "includes/calendar.php",
        type: "POST",
        success: function (response) {
            if (typeof response === "string") {
                response = JSON.parse(response);
            }

            console.table(response);
            console.log(response.length);
            
            for (let i = 0; i < response.length; i++) {
                var parts = response[i]["class_schedule"].match(/\((.*?)\)\s(.*?)\-(.*)/);
                startTime.push(parts[2]); // Extracted start time
                endTime.push(parts[3]);
                className.push(response[i]["class_name"]);
                classCode.push(response[i]["class_code"]);

                let wordDay = response[i]["class_schedule"].substring(1, 4);
                switch (wordDay) {
                    case "Mon": day.push(1); break;
                    case "Tue": day.push(2); break;
                    case "Wed": day.push(3); break;
                    case "Thu": day.push(4); break;
                    case "Fri": day.push(5); break;
                    case "Sat": day.push(6); break;
                    case "Sun": day.push(0); break; 
                }
            }

            // console.log("Day:", day);
            // console.log("Start Time:", startTime);
            // console.log("End Time:", endTime);

            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                initialDate: '2024-10-07',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: [] 
            });

            calendar.render();

            for (let i = 0; i < day.length; i++) {
                // console.log(`Processing event ${i}:`);
                // console.log("Class Name:", className[i]);
                // console.log("Day:", day[i]);
                // console.log("Start Time:", startTime[i]);
                // console.log("End Time:", endTime[i]);

                const convertedStartTime = convertTo24Hour(startTime[i]);
                const convertedEndTime = convertTo24Hour(endTime[i]);

                if (!convertedStartTime || !convertedEndTime) {
                    console.error(`Invalid time format for event ${i}:`, {
                        originalStartTime: startTime[i],
                        originalEndTime: endTime[i],
                    });
                    continue; 
                }

                addWeeklyEventWithMinutes(calendar, className[i], "2024-11-01", "2024-12-31", day[i], convertedStartTime, convertedEndTime, classCode[i]);
            }
        },
        error: function (xhr, status, error) {
            console.log("Error:", status, error);
        },
    });

    function convertTo24Hour(time) {
        const timeParts = time.match(/(\d+):(\d+)\s?(AM|PM)/);
        if (!timeParts) return null;

        let hours = parseInt(timeParts[1]);
        const minutes = timeParts[2];
        const period = timeParts[3];

        if (period === "PM" && hours !== 12) {
            hours += 12;
        } else if (period === "AM" && hours === 12) {
            hours = 0;
        }

        return `${hours.toString().padStart(2, "0")}:${minutes}`;
    }

    function addWeeklyEventWithMinutes(calendar, title, startDate, endDate, weekday, startTime, endTime, classCode) {
        var start = new Date(startDate);
        var end = new Date(endDate);     
        // console.log(md5(classCode));   
        var classCodeLink = "class.php?class=" + md5(classCode);
        // Adjust `start` to the first occurrence of the desired weekday
        while (start.getDay() !== weekday) {
            start.setDate(start.getDate() + 1);
        }

        // Loop through each week until the end date
        while (start <= end) {
            // Combine `start` date with the converted `startTime` and `endTime`
            const startDateTime = `${start.toISOString().split("T")[0]}T${startTime}`;
            const endDateTime = `${start.toISOString().split("T")[0]}T${endTime}`;

            // Add the event to the calendar
            // console.log("Adding event:", {
            //     title: title,
            //     start: startDateTime,
            //     end: endDateTime
            // });
            calendar.addEvent({
                title: title,
                url : classCodeLink,
                start: startDateTime,
                end: endDateTime,
                allDay: false // Ensure it's not an all-day event
            });

            // Increment by 7 days (1 week)
            start.setDate(start.getDate() + 7);
        }
    }
}); 