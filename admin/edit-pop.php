<?php 
    require_once("classes/connection.php");
    require_once("classes/model.ClassRm.php");
    require_once("classes/controller.Admin.php");
    require_once("classes/controller.ClassRm.php");
    require_once("classes/controller.Lists.php");
    require_once("includes/update.inc.php");
    require_once("includes/class-list.inc.php");
    require_once("includes/search.inc.php");
    require_once("includes/ses-message.inc.php");

    // Initialize class sched 
    include("includes/edit-init.inc.php");
    $class_num = $_SESSION['classNumber'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>EDIT FORM</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?adminBtn=" . urlencode($_GET["adminBtn"]);?>" method="post">
          <label>Class Name</label><br>
          <input type="text" name="className" placeholder="Enter Class Name" id="className" value="<?php echo $_SESSION['list'][$class_num]['class_name']; ?>"><br><br>
        
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
                   <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>" <?php if ($startingHour == str_pad($i, 2, "0", STR_PAD_LEFT)) echo "selected"; ?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                <?php endfor; ?>
            </select>

            <select name="startingMinSched" id="startingMinSched">
                <option value="blank"> </option>
                <?php for ($i = 0; $i < 60; $i += 10): ?>
                    <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>" <?php if ($startingMin == str_pad($i, 2, "0", STR_PAD_LEFT)) echo "selected"; ?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                <?php endfor; ?>
            </select>

            <select name="startTimePeriod" id="timePeriod">
                <option value="blank"> </option>
                <option value="AM" <?php if ($startingPeriod == "AM") echo "selected"; ?>>AM</option>
                <option value="PM" <?php if ($startingPeriod == "PM") echo "selected"; ?>>PM</option>
            </select>

            <label>To</label>
            <select name="endingHourSched" id="endingHourSched">
                <option value="blank"> </option>
                <?php for ($i = 1; $i <= 12; $i++): ?>
                    <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>" <?php if ($endingHour == str_pad($i, 2, "0", STR_PAD_LEFT)) echo "selected"; ?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                <?php endfor; ?>
            </select>

            <select name="endingMinSched" id="endingMinSched">
                <option value="blank"> </option>
                <?php for ($i = 0; $i < 60; $i += 10): ?>
                    <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>" <?php if ($endingMin == str_pad($i, 2, "0", STR_PAD_LEFT)) echo "selected"; ?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                <?php endfor; ?>
            </select>

            <select name="endTimePeriod" id="timePeriod">
                <option value="blank"> </option>
                <option value="AM" <?php if ($endingPeriod == "AM") echo "selected"; ?>>AM</option>
                <option value="PM" <?php if ($endingPeriod == "PM") echo "selected"; ?>>PM</option>
            </select><br><br>

          <label>Class Status</label>
            <select name="status" id="status">
                <option value="Active" <?php if ($_SESSION['list'][$class_num]['class_status'] == "Active") echo "selected"; ?>>Active</option>
                <option value="Inactive" <?php if ($_SESSION['list'][$class_num]['class_status'] == "Inactive") echo "selected"; ?>>Inactive</option>
            </select><br><br>

          <label>Class Instructor</label><br>
          <input type="text" name="classProf" placeholder="Assign Class Instructor" value="<?php echo $_SESSION['list'][$class_num]['class_teacher']; ?>"><br><br>
    </form>
</body>
</html>
