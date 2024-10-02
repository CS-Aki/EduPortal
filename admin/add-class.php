<?php
    require_once("classes/connection.php");
    require_once("classes/model.ClassRm.php");
    require_once("classes/controller.Admin.php");
    require_once("classes/controller.ClassRm.php");
    require_once("includes/add.inc.php");
    require_once("includes/update.inc.php");
    require_once("includes/delete.inc.php");
    if(session_id() === "") session_start();
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="add-class.php" method="POST">
            <label>Class Name</label>
            <input type="text" name="className" placeholder="Enter Class Name"><br>
            <!-- Will change this into a checkbox to choose the day and time -->
            <label>Class Sched</label>
            <input type="text" name="classSched" placeholder="Class Schedule"><br> 
            <label>Class Instructor</label>
            <input type="text" name="classProf" placeholder="Assign Class Instructor"><br>
            <input type="submit" name="createClassBtn" value="Create New Class" class="btn"><br>
            <input type="submit" name="backBtn" value="Go Back" class="btn"><br>
            
            <label for="msg"><?php if(isset($_SESSION["msg"])) {
                                          echo $_SESSION["msg"];
                                          unset($_SESSION["msg"]);
                                 }
                            ?>
            </label>
    </form>
</body>
</html>