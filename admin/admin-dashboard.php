<?php
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
    body {
    background-color: #34495e;
    }

    #form label{
        background-color: white;
    }
    .btn{
        margin-top: 10px;
    }
</style>

<body>
    <form action="admin-dashboard.php" method="get">
        <input type="submit" name="adminBtn" value="Add Class" class="btn"><br>
        <input type="submit" name="adminBtn" value="Update Class" class="btn"><br>
        <input type="submit" name="adminBtn" value="Archive Class" class="btn"><br>
        <input type="submit" name="adminBtn" value="Post Announcement" class="btn"><br>
        <input type="submit" name="adminBtn" value="Faculty List" class="btn"><br>
        <input type="submit" name="adminBtn" value="Student List" class="btn"><br>
        <input type="submit" name="adminBtn" value="Class List" class="btn"><br>
    </form>
    <br><br>

    <div>
    <?php 
        if(isset($_GET["adminBtn"])){
            switch($_GET["adminBtn"]){
                case "Add Class": include("add-class.php"); break;
                case "Update Class": include("includes/update.inc.php"); include("update-class.php"); break;
                case "Archive Class": break;
                case "Post Announcement": break;
                case "Faculty List": break;
                case "Student List": break;
                case "Class List": break;
            }
         }
    ?>
    </div>

</body>

</html>
