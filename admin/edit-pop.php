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
echo $_SESSION['classNumber'];
$class_num = $_SESSION['classNumber'];
//include("modal.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!-- 
<div class="modal fade" id="editClass" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editClassLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editClassLabel">Update Class Information</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="form-group">
            <label>Class Name</label><br>
            <input type="text" name="className" placeholder="Enter Class Name" id="className" class="form-control"value="<?php echo $_SESSION['list'][$class_num]['class_name']; ?>">
          </div>

          <label>Class Schedule:</label>
          <div class="form-group">
           <br> 
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
          </div>

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
            </select>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Update Class</button>
        </div>
      </div>
    </div>
  </div>  -->

    <h1>EDIT FORM</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?adminBtn=" . urlencode($_GET["adminBtn"]); ?>" method="post">
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

        <input type="submit" name="editClassBtn" value="SAVE EDIT" class="btn"><br><br>
        <input type="submit" name="closeBtn" value="CLOSE EDIT TAB" class="btn"><br>
    </form>

    <script>
        // document.getElementById("editForm").addEventListener("submit", function(event) {
        //     event.preventDefault(); // Prevent the form from submitting
        //     var confirmationModal = new bootstrap.Modal(document.getElementById('editClassLabel'));
        //     confirmationModal.show(); // Show the modal
        // });

        // document.getElementById("confirmSubmitBtn").addEventListener("click", function() {
        //     document.getElementById("myForm").submit(); // Submit the form after confirmation
        // });
    </script>
</body>

</html>