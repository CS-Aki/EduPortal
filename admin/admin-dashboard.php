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
    <title>Admin Side</title>
</head>

<style>
    .btn{
        margin-top: 10px;
    }
</style>

<body>

    <form action="admin-dashboard.php" method="POST">
        <input type="submit" name="addClassBtn" value="Add Class" class="btn"><br>
        <input type="submit" name="updateClassBtn" value="Update Class" class="btn"><br>
        <input type="submit" name="deleteClassBtn" value="Delete Class" class="btn"><br>
        <input type="submit" name="postAnnouncementBtn" value="Post Announcement" class="btn"><br>
        <input type="submit" name="facultyListBtn" value="Faculty List" class="btn"><br>
        <input type="submit" name="studentListBtn" value="Student List" class="btn"><br>
        <input type="submit" name="classListBtn" value="Class List" class="btn"><br>
    </form>

</body>

</html>
