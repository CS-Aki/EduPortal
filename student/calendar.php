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
        case 3: header("Location: ../instructor/instructor-dashboard.php"); exit(); break;
        // case 4: header("Location: student/student-dashboard.php"); break;
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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/js-md5@0.7.3/build/md5.min.js"></script>

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
                    <div class="p-4 vh-100">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    

    <script src="scripts/calendar.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
</body>
</html>
