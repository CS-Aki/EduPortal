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

    // Set to track added events by start date-time
    var addedEvents = new Set();

    // Assuming the response is already in JSON format
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

                // Activity event handling (based on content type)
                if (eventData["content type"] === "Activity") {
                    // Add event for Activity Start and Deadline
                    if (eventData["act start date"] && eventData["act start time"]) {
                        const actStart = `${eventData["act start date"]}T${eventData["act start time"]}`;
                        // Check if the event has already been added for this start time
                        if (!addedEvents.has(actStart)) {
                            calendar.addEvent({
                                title: `${eventData["post title"]} (Activity Start)`,
                                start: actStart,
                                url: eventUrl,
                                allDay: false
                            });
                            addedEvents.add(actStart); // Mark as added
                        }
                    }
                    if (eventData["act deadline date"] && eventData["act deadline time"]) {
                        const actEnd = `${eventData["act deadline date"]}T${eventData["act deadline time"]}`;
                        // Check if the event has already been added for this end time
                        if (!addedEvents.has(actEnd)) {
                            calendar.addEvent({
                                title: `${eventData["post title"]} (Activity Deadline)`,
                                start: actEnd,
                                url: eventUrl,
                                allDay: false
                            });
                            addedEvents.add(actEnd); // Mark as added
                        }
                    }
                }

                // Quiz event handling (based on content type)
                if (eventData["content type"] === "Quiz") {
                    // Add event for Quiz Start and Deadline
                    if (eventData["quiz start date"] && eventData["quiz start time"]) {
                        const quizStart = `${eventData["quiz start date"]}T${eventData["quiz start time"]}`;
                        // Check if the event has already been added for this start time
                        if (!addedEvents.has(quizStart)) {
                            calendar.addEvent({
                                title: `${eventData["post title"]} (Quiz Start)`,
                                start: quizStart,
                                url: eventUrl,
                                allDay: false
                            });
                            addedEvents.add(quizStart); // Mark as added
                        }
                    }
                    if (eventData["quiz deadline date"] && eventData["quiz deadline time"]) {
                        const quizEnd = `${eventData["quiz deadline date"]}T${eventData["quiz deadline time"]}`;
                        // Check if the event has already been added for this end time
                        if (!addedEvents.has(quizEnd)) {
                            calendar.addEvent({
                                title: `${eventData["post title"]} (Quiz Deadline)`,
                                start: quizEnd,
                                url: eventUrl,
                                allDay: false
                            });
                            addedEvents.add(quizEnd); // Mark as added
                        }
                    }
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
