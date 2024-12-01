<?php 
if (session_id() === "") session_start();

if(!isset($_SESSION["user_category"])){
    header("Location: ../index.php");
}

if(isset($_SESSION["user_category"])){
    $category = $_SESSION["user_category"];
    switch($category){
        case 1: header("Location: ../admin/admin-dashboard.php"); exit(); break;
        case 2: break;
        // case 3: header("Location: instructor/instructor-dashboard.php"); break;
        case 4: header("Location: ../student/student-dashboard.php"); exit(); break;
    }
}else{
    header("Location: ../");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar</title>
    <?php require('inc/links.php'); ?>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        initialDate: '2024-10-07',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: [
            {
            title: 'All Day Event',
            start: '2024-10-01'
            },
            {
            title: 'Long Event',
            start: '2024-10-07',
            end: '2024-10-10'
            },
            {
            groupId: '999',
            title: 'Repeating Event',
            start: '2024-10-09T16:00:00'
            },
            {
            groupId: '999',
            title: 'Repeating Event',
            start: '2024-10-16T16:00:00'
            },
            {
            title: 'Conference',
            start: '2024-10-11',
            end: '2024-10-13'
            },
            {
            title: 'Meeting',
            start: '2024-10-12T10:30:00',
            end: '2024-10-12T12:30:00'
            },
            {
            title: 'Lunch',
            start: '2024-10-12T12:00:00'
            },
            {
            title: 'Meeting',
            start: '2024-10-12T14:30:00'
            },
            {
            title: 'Birthday Party',
            start: '2024-10-13T07:00:00'
            },
            {
            title: 'Click for Google',
            url: 'https://google.com/',
            start: '2024-10-28'
            }
        ]
        });

        calendar.render();
    });

    </script>
</head>
<body class="bg-white">
    <?php require('inc/header.php'); ?>
    <div class="container-fluid p-4" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto">
                <div class="container mt-2 px-lg-5 px-sm-2">
                    <div class="d-flex align-items-center justify-content-between">
                        <h1 class="h-font green1 me-2 sub-title fs-2">Calendar</h1>
                        <div class="line-h"></div>
                    </div>
                    <div class="p-lg-2 p-md-1 p-sm-1 vh-100">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
</body>
</html>
