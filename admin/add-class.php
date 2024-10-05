<?php
    require_once("classes/connection.php");
    require_once("classes/model.ClassRm.php");
    require_once("classes/controller.Admin.php");
    require_once("classes/controller.ClassRm.php");
    require_once("includes/add.inc.php");
    require_once("includes/schedule.inc.php");
    require_once("includes/ses-message.inc.php");
    require_once("includes/class-list.inc.php");
    if(session_id() === "") session_start();
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
    <form id="form" action="add-class.php" method="POST">
            <label>Class Name</label><br>
            <input type="text" name="className" placeholder="Enter Class Name" id="className"><br><br>

            <label>Class Schedule:</label><br>
            <label>Day</label>
            <select name="daySched" id="daySched">
                <option value="blank"></option>
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
                <option value="Sunday">Sunday</option>
            </select>

            <label>From</label>
            <select name="startingHourSched" id="startingHourSched">
                <option value="blank"></option>
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="01">05</option>
                <option value="02">06</option>
                <option value="03">07</option>
                <option value="04">08</option>
                <option value="01">09</option>
                <option value="02">10</option>
                <option value="03">11</option>
                <option value="04">12</option>
            </select>

            <select name="startingMinSched" id="startingMinSched">
                <option value="blank"> </option>
                <option value="00">00</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
                <option value="40">40</option>
                <option value="50">50</option>
            </select>

            <select name="startTimePeriod" id="timePeriod">
                <option value="blank"> </option>
                <option value="AM">AM</option>
                <option value="PM">PM</option>
            </select>


            <label>To</label>
            <select name="endingHourSched" id="endingHourSched">
                <option value="blank"> </option>
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="01">05</option>
                <option value="02">06</option>
                <option value="03">07</option>
                <option value="04">08</option>
                <option value="01">09</option>
                <option value="02">10</option>
                <option value="03">11</option>
                <option value="04">12</option>
            </select>

            <select name="endingMinSched" id="endingMinSched">
                <option value="blank"> </option>
                <option value="00">00</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
                <option value="40">40</option>
                <option value="50">50</option>
            </select>

            <select name="endTimePeriod" id="timePeriod">
                <option value="blank"> </option>
                <option value="AM">AM</option>
                <option value="PM">PM</option>
            </select><br><br>

            <label>Class Status</label>
            <select name="status" id="status">
                <option value="blank"> </option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select><br><br>



            <label>Class Instructor</label><br>
            <input type="text" name="classProf" placeholder="Assign Class Instructor"><br><br>
            <input type="submit" name="createClassBtn" value="Create New Class" class="btn"><br><br>
            <input type="submit" name="backBtn" value="Go Back" class="btn"><br>

            <label for="msg" id="msg"><?php displaySessionMessage("msg", 1); ?></label>
            <br><br>

    </form>

</body>
</html>
