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

            for (let i = 0; i < response.length; i++) {
                var parts = response[i]["class_schedule"].match(/\((.*?)\)\s(.*?)\-(.*)/);
                startTime.push(parts[2]); 
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

            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: getInitialView(), // Determine the initial view based on screen size
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listWeek'
                },
                height: 'auto',
                events: [], 
            });

            calendar.render();

            // Adjust view on window resize
            $(window).on('resize', function () {
                const newView = getInitialView();
                if (calendar.view.type !== newView) {
                    calendar.changeView(newView);
                }
            });

            for (let i = 0; i < day.length; i++) {
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

    function getInitialView() {
        if (window.innerWidth <= 768) {
            return 'listWeek';
        } else if (window.innerWidth <= 1024) {
            return 'timeGridWeek';
        } else {
            return 'dayGridMonth';
        }
    }

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
        var classCodeLink = "class.php?class=" + md5(classCode);

        while (start.getDay() !== weekday) {
            start.setDate(start.getDate() + 1);
        }

        while (start <= end) {
            const startDateTime = `${start.toISOString().split("T")[0]}T${startTime}`;
            const endDateTime = `${start.toISOString().split("T")[0]}T${endTime}`;

            calendar.addEvent({
                title: title,
                url: classCodeLink,
                start: startDateTime,
                end: endDateTime,
                allDay: false
            });

            start.setDate(start.getDate() + 7);
        }
    }

});
