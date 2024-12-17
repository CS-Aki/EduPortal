$(document).ready(function () {
    var calendarEl = document.getElementById('calendar');
    if (!calendarEl) {
        console.error("Calendar element not found");
        return;
    }

    // Determine the initial view and header toolbar based on screen size
    function getInitialView() {
        return window.innerWidth <= 768 ? 'listWeek' : 'dayGridMonth';
    }

    function getHeaderToolbar() {
        if (window.innerWidth <= 768) {
            return {
                left: 'prev,next today',
                center: 'title',
                right: 'listWeek' // Only show the list button on mobile
            };
        } else {
            return {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listWeek'
            };
        }
    }

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: getInitialView(),
        headerToolbar: getHeaderToolbar(),
        height: 'auto',
    });

    calendar.render();

    // Dynamically adjust the calendar view and toolbar on window resize
    $(window).on('resize', function () {
        const newView = getInitialView();
        const newToolbar = getHeaderToolbar();

        if (calendar.view.type !== newView) {
            calendar.changeView(newView);
        }
        calendar.setOption('headerToolbar', newToolbar);
    });

    var addedEvents = new Set();

    // Fetch events via AJAX
    $.ajax({
        url: "includes/calendar.php",
        type: "POST",
        success: function (response) {
            if (typeof response === "string") {
                response = JSON.parse(response);
            }

            console.table(response);

            response.forEach((eventData) => {
                if (!eventData["class_code"] || !eventData["post id"]) {
                    console.error("Missing class_code or post id:", eventData);
                    return;
                }

                const classHash = md5(String(eventData["class_code"]));
                const postHash = md5(String(eventData["post id"]));
                const eventUrl = `material.php?class=${classHash}&post=${postHash}`;

                if (eventData["content type"] === "Activity") {
                    if (eventData["act start date"] && eventData["act start time"]) {
                        const actStart = `${eventData["act start date"]}T${eventData["act start time"]}`;
                        if (!addedEvents.has(actStart)) {
                            calendar.addEvent({
                                title: `${eventData["post title"]} (Activity Start)`,
                                start: actStart,
                                url: eventUrl,
                                allDay: false
                            });
                            addedEvents.add(actStart);
                        }
                    }
                    if (eventData["act deadline date"] && eventData["act deadline time"]) {
                        const actEnd = `${eventData["act deadline date"]}T${eventData["act deadline time"]}`;
                        if (!addedEvents.has(actEnd)) {
                            calendar.addEvent({
                                title: `${eventData["post title"]} (Activity Deadline)`,
                                start: actEnd,
                                url: eventUrl,
                                allDay: false
                            });
                            addedEvents.add(actEnd);
                        }
                    }
                }

                if (eventData["content type"] === "Quiz") {
                    if (eventData["quiz start date"] && eventData["quiz start time"]) {
                        const quizStart = `${eventData["quiz start date"]}T${eventData["quiz start time"]}`;
                        if (!addedEvents.has(quizStart)) {
                            calendar.addEvent({
                                title: `${eventData["post title"]} (Quiz Start)`,
                                start: quizStart,
                                url: eventUrl,
                                allDay: false
                            });
                            addedEvents.add(quizStart);
                        }
                    }
                    if (eventData["quiz deadline date"] && eventData["quiz deadline time"]) {
                        const quizEnd = `${eventData["quiz deadline date"]}T${eventData["quiz deadline time"]}`;
                        if (!addedEvents.has(quizEnd)) {
                            calendar.addEvent({
                                title: `${eventData["post title"]} (Quiz Deadline)`,
                                start: quizEnd,
                                url: eventUrl,
                                allDay: false
                            });
                            addedEvents.add(quizEnd);
                        }
                    }
                }
            });
        },
        error: function (xhr, status, error) {
            console.log("Error:", status, error);
        }
    });
});
