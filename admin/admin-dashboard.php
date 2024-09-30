<?php
    require_once("classes/connection.php");
    require_once("classes/model.Admin.php");
    require_once("classes/controller.Admin.php");
    require_once("includes/add.inc.php");
    require_once("includes/update.inc.php");
    require_once("includes/delete.inc.php");
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
    <form action="admin-dashboard.php" method="GET">
        <input type="submit" name="addClass" value="Add Class" class="btn"><br>
        <input type="submit" name="updateClass" value="Update Class" class="btn"><br>
        <input type="submit" name="deleteClass" value="Delete Class" class="btn"><br>
        <input type="submit" name="postAnnouncement" value="Post Announcement" class="btn"><br>
        <input type="submit" name="facultyList" value="Faculty List" class="btn"><br>
        <input type="submit" name="studentList" value="Student List" class="btn"><br>
        <input type="submit" name="classList" value="Class List" class="btn"><br>
    </form>
</body>

</html>
