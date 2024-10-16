<?php
if (session_id() === "") session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Side</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<style>
    body {
        background-color: #556;
    }

    #form label {
        background-color: white;
    }

    .btn {
        margin-top: 10px;
    }
</style>

<body>

    <form action="admin-dashboard.php" method="get">
        <input type="submit" name="adminBtn" value="Add Class" class="btn"><br>
        <input type="submit" name="adminBtn" value="Update Class" class="btn"><br>
        <!-- <input type="submit" name="adminBtn" value="Archive Class" class="btn"><br> -->
        <input type="submit" name="adminBtn" value="Post Announcement" class="btn"><br>
        <input type="submit" name="adminBtn" value="Instructor List" class="btn"><br>
        <input type="submit" name="adminBtn" value="Student List" class="btn"><br>
        <input type="submit" name="adminBtn" value="Class List" class="btn"><br>
    </form>
    <br><br>

    <div>
        <?php
        if (isset($_GET["adminBtn"])) {
            switch ($_GET["adminBtn"]) {
                case "Add Class":
                    include("add-class.php");
                    break;
                case "Update Class":
                    include("update-class.php");
                    break;
                    //   case "Archive Class": include("archive-class.php"); break;
                case "Post Announcement":
                    break;
                case "Instructor List":
                    $_SESSION["searchSwitch"] = "all";
                    include("prof-list.php");
                    break;
                case "Student List":
                    break;
                case "Class List":
                    $_SESSION["searchSwitch"] = "all";
                    include("class-list.php");
                    break;
            }
        }
        ?>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>