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

        calendar.render();
    }

    var addedEvents = new Set();

    $.ajax({
        url: "includes/calendar.php",
        type: "POST",
        success: function (response) {
            if (typeof response === "string") {
                response = JSON.parse(response);
            }

            console.table(response);

            response.forEach((eventData, index) => {
                console.log(`Processing event ${index + 1}:`, eventData);
            
                if (!eventData["class_code"] || !eventData["post id"]) {
                    console.error("Skipping due to missing fields:", eventData);
                    return; 
                }
            
                const classHash = md5(String(eventData["class_code"]));
                const postHash = md5(String(eventData["post id"]));
                let eventUrl = `material.php?class=${classHash}&post=${postHash}`;
            
                if (eventData["content type"] === "Activity") {
                    if (eventData["act start date"] && eventData["act start time"]) {
                        const actStart = `${eventData["act start date"]}T${eventData["act start time"]}`;
                        const uniqueKey = `${actStart}-${eventData["post id"]}`;
                        if (!addedEvents.has(uniqueKey)) {
                            calendar.addEvent({
                                title: `${eventData["post title"]} (Activity Start)`,
                                start: actStart,
                                url: eventUrl,
                                allDay: false
                            });
                            addedEvents.add(uniqueKey);
                        }
                    }

                    if (eventData["act deadline date"] && eventData["act deadline time"]) {
                        const actStart = `${eventData["act deadline date"]}T${eventData["act deadline time"]}`;
                        const uniqueKey = `${actStart}-${eventData["post id"]}`;
                        if (!addedEvents.has(uniqueKey)) {
                            calendar.addEvent({
                                title: `${eventData["post title"]} (Activity Deadline)`,
                                start: actStart,
                                url: eventUrl,
                                allDay: false
                            });
                            addedEvents.add(uniqueKey);
                        }
                    }
                    // Add act deadline similar to the above.
                }
                if (eventData["content type"] === "Quiz") {
                    eventUrl = `quiz-form.php?class=${classHash}&post=${postHash}`;
                    // Similar logic for quiz start and deadline
                    if (eventData["quiz start date"] && eventData["quiz start time"]) {
                        const actStart = `${eventData["quiz start date"]}T${eventData["quiz start time"]}`;
                        const uniqueKey = `${actStart}-${eventData["post id"]}`;
                        if (!addedEvents.has(uniqueKey)) {
                            calendar.addEvent({
                                title: `${eventData["post title"]} (Quiz Start)`,
                                start: actStart,
                                url: eventUrl,
                                allDay: false
                            });
                            addedEvents.add(uniqueKey);
                        }
                    }

                    if (eventData["quiz deadline date"] && eventData["quiz deadline time"]) {
                        eventUrl = `quiz-form.php?class=${classHash}&post=${postHash}`;
                        const actStart = `${eventData["quiz deadline date"]}T${eventData["quiz deadline time"]}`;
                        const uniqueKey = `${actStart}-${eventData["post id"]}`;
                        if (!addedEvents.has(uniqueKey)) {
                            calendar.addEvent({
                                title: `${eventData["post title"]} (Quiz Deadline)`,
                                start: actStart,
                                url: eventUrl,
                                allDay: false
                            });
                            addedEvents.add(uniqueKey);
                        }
                    }
                }
            });
            
        },
        error: function (xhr, status, error) {
            console.log("Error:", status, error);
        }
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
});
