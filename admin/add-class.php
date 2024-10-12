<?php
    require_once("classes/connection.php");
    require_once("classes/model.ClassRm.php");
    require_once("classes/controller.Admin.php");
    require_once("classes/controller.ClassRm.php");
    require_once("includes/add.inc.php");
    require_once("includes/schedule.inc.php");
    require_once("includes/ses-message.inc.php");
    require_once("includes/class-list.inc.php");
   // if(session_id() === "") session_start();

    $className = isset($_SESSION["className"]) ? $_SESSION["className"] : "";
    $daySched = isset($_SESSION['daySched']) ? $_SESSION['daySched'] : "";
    $startingHourSched = isset($_SESSION['startingHourSched']) ? $_SESSION['startingHourSched'] : "";
    $startingMinSched = isset($_SESSION['startingMinSched']) ? $_SESSION['startingMinSched'] : "";
    $startTimePeriod = isset($_SESSION['startTimePeriod']) ? $_SESSION['startTimePeriod'] : "";
    $endingHourSched = isset($_SESSION['endingHourSched']) ? $_SESSION['endingHourSched'] : "";
    $endingMinSched = isset($_SESSION['endingMinSched']) ? $_SESSION['endingMinSched'] : "";
    $endTimePeriod = isset($_SESSION['endTimePeriod']) ? $_SESSION['endTimePeriod'] : "";
    $status = isset($_SESSION['status']) ? $_SESSION['status'] : "";
    $classProf = isset($_SESSION['classProf']) ? $_SESSION['classProf'] : "";

    ?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script defer src="scripts/retain-info.js"></script>
</head>

<style media="screen">
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
    <form id="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?adminBtn=" . $_GET["adminBtn"];?>" method="POST">
            <label>Class Name</label><br>
            <input type="text" name="className" placeholder="Enter Class Name" id="className" value="<?php if(isset($_SESSION["className"])) echo $_SESSION["className"]; ?>"><br><br>

            <label>Class Schedule:</label><br>
            <label>Day</label>
            <select name="daySched" id="daySched">
            <option value="blank"></option>
            <option value="Monday" <?php if ($daySched == "Monday") echo "selected"; ?>>Monday</option>
            <option value="Tuesday" <?php if ($daySched == "Tuesday") echo "selected"; ?>>Tuesday</option>
            <option value="Wednesday" <?php if ($daySched == "Wednesday") echo "selected"; ?>>Wednesday</option>
            <option value="Thursday" <?php if ($daySched == "Thursday") echo "selected"; ?>>Thursday</option>
            <option value="Friday" <?php if ($daySched == "Friday") echo "selected"; ?>>Friday</option>
            <option value="Saturday" <?php if ($daySched == "Saturday") echo "selected"; ?>>Saturday</option>
            <option value="Sunday" <?php if ($daySched == "Sunday") echo "selected"; ?>>Sunday</option>
            </select>

            <label>From</label>
            <select name="startingHourSched" id="startingHourSched">
                <option value="blank"></option>
                <?php for ($i = 1; $i <= 12; $i++): ?>
                   <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>" <?php if ($startingHourSched == str_pad($i, 2, "0", STR_PAD_LEFT)) echo "selected"; ?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                <?php endfor; ?>
            </select>

            <select name="startingMinSched" id="startingMinSched">
                <option value="blank"> </option>
                <?php for ($i = 0; $i < 60; $i += 10): ?>
                    <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>" <?php if ($startingMinSched == str_pad($i, 2, "0", STR_PAD_LEFT)) echo "selected"; ?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                <?php endfor; ?>
            </select>

            <select name="startTimePeriod" id="timePeriod">
                <option value="blank"> </option>
                <option value="AM" <?php if ($startTimePeriod == "AM") echo "selected"; ?>>AM</option>
                <option value="PM" <?php if ($startTimePeriod == "PM") echo "selected"; ?>>PM</option>
            </select>


            <label>To</label>
            <select name="endingHourSched" id="endingHourSched">
                <option value="blank"> </option>
                <?php for ($i = 1; $i <= 12; $i++): ?>
                    <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>" <?php if ($endingHourSched == str_pad($i, 2, "0", STR_PAD_LEFT)) echo "selected"; ?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                <?php endfor; ?>
            </select>

            <select name="endingMinSched" id="endingMinSched">
                <option value="blank"> </option>
                <?php for ($i = 0; $i < 60; $i += 10): ?>
                    <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>" <?php if ($endingMinSched == str_pad($i, 2, "0", STR_PAD_LEFT)) echo "selected"; ?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                <?php endfor; ?>
            </select>

            <select name="endTimePeriod" id="timePeriod">
                <option value="blank"> </option>
                <option value="AM" <?php if ($endTimePeriod == "AM") echo "selected"; ?>>AM</option>
                <option value="PM" <?php if ($endTimePeriod == "PM") echo "selected"; ?>>PM</option>
            </select><br><br>

            <label>Class Status</label>
            <select name="status" id="status">
                <option value="blank"> </option>
                <option value="Active" <?php if ($status == "Active") echo "selected"; ?>>Active</option>
                <option value="Inactive" <?php if ($status == "Inactive") echo "selected"; ?>>Inactive</option>
            </select><br><br>

            <label>Class Instructor</label><br>
            <input type="text" name="classProf" placeholder="Assign Class Instructor" value="<?php if(isset($_SESSION["classProf"])) echo $_SESSION["classProf"]; ?>"><br><br>
            <input type="submit" name="createClassBtn" value="Create New Class" class="btn"><br><br>
            <input type="submit" name="backBtn" value="Go Back" class="btn"><br>

            <label for="msg" id="msg"><?php displaySessionMessage("msg", 1); ?></label>
            <br><br>

    </form>

</body>
</html>

<?php
    session_unset();
?>