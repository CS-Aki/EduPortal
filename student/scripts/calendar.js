$(document).ready(function () {
    var calendarEl = document.getElementById('calendar');
    if (!calendarEl) {
        console.error("Calendar element not found");
    } else {
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: getInitialView(),
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listWeek'
            },
            height: 'auto',
        });

        // Render the calendar to attach it to the DOM
        calendar.render();
    }

    $.ajax({
        url: "student backend/includes/calendar.php",
        type: "POST",
        success: function (response) {
            if (typeof response === "string") {
                response = JSON.parse(response);
            }

            console.table(response);

            response.forEach((eventData) => {
                // Ensure class_code and post id are valid
                if (!eventData["class_code"] || !eventData["post id"]) {
                    console.error("Missing class_code or post id:", eventData);
                    return; // Skip this iteration
                }

                // Convert inputs to strings and hash them
                const classHash = md5(String(eventData["class_code"]));
                const postHash = md5(String(eventData["post id"]));
                const eventUrl = `material.php?class=${classHash}&post=${postHash}`;

                // Add event for the Activity start date
                if (eventData["act start date"] && eventData["act start time"]) {
                    const actStart = `${eventData["act start date"]}T${eventData["act start time"]}`;
                    calendar.addEvent({
                        title: `${eventData["post title"]} (Activity Start)`,
                        start: actStart,
                        url: eventUrl,
                        allDay: false
                    });
                }

                // Add event for the Activity deadline date
                if (eventData["act deadline date"] && eventData["act deadline time"]) {
                    const actEnd = `${eventData["act deadline date"]}T${eventData["act deadline time"]}`;
                    calendar.addEvent({
                        title: `${eventData["post title"]} (Activity Deadline)`,
                        start: actEnd,
                        url: eventUrl,
                        allDay: false
                    });
                }

                // Add event for the Quiz start date
                if (eventData["quiz start date"] && eventData["quiz start time"]) {
                    const quizStart = `${eventData["quiz start date"]}T${eventData["quiz start time"]}`;
                    calendar.addEvent({
                        title: `${eventData["post title"]} (Quiz Start)`,
                        start: quizStart,
                        url: eventUrl,
                        allDay: false
                    });
                }

                // Add event for the Quiz deadline date
                if (eventData["quiz deadline date"] && eventData["quiz deadline time"]) {
                    const quizEnd = `${eventData["quiz deadline date"]}T${eventData["quiz deadline time"]}`;
                    calendar.addEvent({
                        title: `${eventData["post title"]} (Quiz Deadline)`,
                        start: quizEnd,
                        url: eventUrl,
                        allDay: false
                    });
                }
            });
        },
        error: function (xhr, status, error) {
            console.log("Error:", status, error);
        }
    });

    // Determine initial calendar view based on screen size
    function getInitialView() {
        if (window.innerWidth <= 768) {
            return 'listWeek';
        } else if (window.innerWidth <= 1024) {
            return 'timeGridWeek';
        } else {
            return 'dayGridMonth';
        }
    }
});
