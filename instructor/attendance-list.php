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
        // case 3: header("Location: instructor/instructor-dashboard.php"); break;
        case 4: header("Location: ../student/student-dashboard.php"); exit(); break;
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
    <title>Professor Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <?php require('inc/links.php'); include("includes/view-attendance-list.php");?>
</head>

<style>
    table, th, td {
        padding: 2px 60px 20px 80px;
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>
<body>
    <?php require('inc/header.php'); ?>

    <div class="container-fluid p-0 m-0" id="main-content">
        <div class="row">
            <div class="col-lg-10 col-sm-12 ms-auto">
                <nav class="navbar navbar-expand-lg sticky-top line fs-5 z-2">
                    <div class="container-fluid sticky-top">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse green1" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="class.php?class=<?php echo md5($details[0]["class_code"]); ?>" >Class Name</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="submittedworks.php?class=<?php echo md5($details[0]["class_code"]); ?>">Submitted Works</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="list.php?class=<?php echo md5($details[0]["class_code"]); ?>">List of Students</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <div class="container mt-4 px-lg-5 px-sm-2">
                    <!-- <div class="mt-2" id="professor-container">
                        <div class="">
                            <h1 class="h-font green1 me-2 sub-title mb-0 pb-0">Professor</h1>
                            <div class="line-h mt-0"></div>
                        </div>
                        <div class="ms-3">
                            <div class="d-flex align-items-center mb-3 mt-3" id="professor">
                                 <img src="images/profile.png" style="width: 40px;" class="rounded-5 me-3"></span>
                                 <p class="green1 fw-semibold lh-sm m-0 p-0 fs-5 " id="professor-name"><?php echo $details[0]["class_teacher"]; ?></p>
                            </div>                         
                        </div>
                    </div> -->
                    <div class="mt-2" id="student-container">
                        <div class="">
                            <h1 class="h-font green1 me-2 sub-title mb-0 pb-0">Students</h1>
                            <div class="line-h mt-0"></div>
                        </div>
                        <div class="ms-3 mt-3">
                            <form action="includes/attendance.php" method="post" id="attendanceForm">
                            <table>
                            <thead>
                                <th>NAME</th>
                                <th>STATUS</th>
                                <th colspan=3>BUTTON</th>
                            </thead>
                            <tbody id="loadStudents">

                            <td><label>Check All</label></td><td></td><td><input type="checkbox" id="checkAllPresent" name="checkAll" value="Present"></td><td><input type="checkbox" id="checkAllAbsent" name="checkAll" value="Absent"></td><td><input type="checkbox" name="checkAll" id="checkAllLate" value="Late"></td>
                            
                           <?php
                                if(isset($studentList[0]["status"])){
                                    for($i = 0 ; $i < count($studentList); $i++){
                                        echo "<tr>
                                                <td>
                                                    <div class='d-flex align-items-center mb-2'>
                                                        <img src='images/profile.png' style='width: 40px;' class='rounded-5 me-3'>
                                                        <p class='green2 fw-semibold lh-sm m-0 p-0 fs-5 student-name'>{$studentList[$i]["name"]} </p>
                                                    </div>
                                                </td>
                                                <td class='student-status'>{$studentList[$i]["status"]}</td>
                                                <td><input type='checkbox' name='status[{$studentList[$i]["user_id"]}]' class='status present' value='Present'> Present</td>
                                                <td><input type='checkbox' name='status[{$studentList[$i]["user_id"]}]' class='status absent' value='Absent'> Absent</td>
                                                <td><input type='checkbox' name='status[{$studentList[$i]["user_id"]}]' class='status late' value='Late'> Late</td>
                                            </tr>";
                                    }
                               }
                               
                            ?>
                            </tbody>
                            
                            </table>
                            <input type="submit">
                            </form>

                            <!-- <div class="d-flex align-items-center mb-2" id="professor">
                                <img src="images/mikmik.jpg" style="width: 40px;" class="rounded-5 m-0 me-3"></span>
                                <p class="green2 fw-semibold lh-sm m-0 p-0 fs-5 " id="student-name">Jarmen A. Cachero </p>
                            </div>                          -->
                            <!-- <div class="d-flex align-items-center mb-2" id="professor">
                                <img src="images/mikmik.jpg" style="width: 40px;" class="rounded-5 me-3"></span>
                                <p class="green2 fw-semibold lh-sm m-0 p-0 fs-5 " id="student-name">Jarmen A. Cachero </p>
                            </div>    
                            <div class="d-flex align-items-center mb-2" id="professor">
                                <img src="images/mikmik.jpg" style="width: 40px;" class="rounded-5 m-0 me-3"></span>
                                <p class="green2 fw-semibold lh-sm m-0 p-0 fs-5 " id="student-name">Jarmen A. Cachero </p>
                            </div>                         
                            <div class="d-flex align-items-center mb-2" id="professor">
                                <img src="images/mikmik.jpg" style="width: 40px;" class="rounded-5 me-3"></span>
                                <p class="green2 fw-semibold lh-sm m-0 p-0 fs-5 " id="student-name">Jarmen A. Cachero </p>
                            </div>                         -->
                        </div>
                    </div>
                </div>

                
            </div>
        </div>
    </div>
    <br><br><br>
    <br><br><br>
    
    <script src="https://eduportal-wgrc.onrender.com/socket.io/socket.io.min.js"></script>

    <script>

        function getSelectedVal(){
        var ID={};
        ID.values=[];

            $("input#checkDelete").each(function(){
                var $this = $(this);    
                // console.log("test1");
                if($this.is(":checked")){        
                    ID.values.push($this.attr("value"));        
                }
            });     

        }

        $(document).on('change', 'input[type="checkbox"]', function() {
            $('input[name="' + this.name + '"]').not(this).prop('checked', false);
            updateCheckAllStatus();
        });

        // Function to check only "Present" checkboxes and uncheck others
        $(document).on('click', '#checkAllPresent', function () {
            if (this.checked) {
                $('.status.present').prop('checked', true); // Check all "Present"
                $('.status.late, .status.absent').prop('checked', false); // Uncheck all "Late" and "Absent"
            } else {
                $('.status.present').prop('checked', false); // Uncheck all "Present"
            }
        });

        // Function to check only "Late" checkboxes and uncheck others
        $(document).on('click', '#checkAllLate', function () {
            if (this.checked) {
                $('.status.late').prop('checked', true); // Check all "Late"
                $('.status.present, .status.absent').prop('checked', false); // Uncheck all "Present" and "Absent"
            } else {
                $('.status.late').prop('checked', false); // Uncheck all "Late"
            }
        });

        // Function to check only "Absent" checkboxes and uncheck others
        $(document).on('click', '#checkAllAbsent', function () {
            if (this.checked) {
                $('.status.absent').prop('checked', true); // Check all "Absent"
                $('.status.present, .status.late').prop('checked', false); // Uncheck all "Present" and "Late"
            } else {
                $('.status.absent').prop('checked', false); // Uncheck all "Absent"
            }
        });

        function updateCheckAllStatus() {
            // Set "Check All Present" if all present checkboxes are selected
            $('#checkAllPresent').prop('checked', $('.status.present:checked').length === $('.status.present').length);
            
            // Set "Check All Late" if all late checkboxes are selected
            $('#checkAllLate').prop('checked', $('.status.late:checked').length === $('.status.late').length);
            
            // Set "Check All Absent" if all absent checkboxes are selected
            $('#checkAllAbsent').prop('checked', $('.status.absent:checked').length === $('.status.absent').length);
        }

        $(document).ready(function() { 
            const socket = io("https://eduportal-wgrc.onrender.com", {
                transports: ["websocket"] // Ensure WebSocket transport
            });
            
            socket.on('connect_error', (err) => {
                console.error("Connection error:", err);
            });
            
            socket.on('connect', () => {
                console.log('Connected to Socket.IO server');
            });

            $("#attendanceForm").submit(function (event) {
                event.preventDefault();
                console.log("clicked");
                var selectedStatuses = {};
                const urlParams = new URLSearchParams(window.location.search);
                const classCode = urlParams.get('class');

                $(".status:checked").each(function() {
                    var studentId = $(this).attr('name').match(/\[(\d+)\]/)[1];
                    var status = $(this).val();  // Get the value of the selected checkbox

                    // If the student doesn't already exist in the object, create an array for them
                    if (!selectedStatuses[studentId]) {
                        selectedStatuses[studentId] = [];
                    }

                    // Push the selected status (Present, Absent, Late) into the array for that student
                    selectedStatuses[studentId].push(status);

                    console.log(selectedStatuses);
                });

                $.ajax({
                method: "POST",
                url: "includes/attendance.php",
                data: {
                    "status" : selectedStatuses,
                    "class-code" : classCode
                },
               
                success: function(response) {
                    console.log(response);
                        $.ajax({
                            method: "GET",
                            url: "includes/view-attendance-list.php",
                            data: {
                                "temp" : "temp",
                                "class" : classCode
                            },
                        
                            success: function(response) {
                                $('#loadStudents').empty();
                                console.table(response);
                                $('#loadStudents').append("<td><label>Check All</label></td><td></td><td><input type='checkbox' id='checkAllPresent' name='checkAll' value='Present'></td><td><input type='checkbox' id='checkAllAbsent' name='checkAll' value='Absent'></td><td><input type='checkbox' name='checkAll' id='checkAllLate' value='Late'></td>");

                                for(var i = 0; i < response.length; i++){

                                    var newRow = $("<tr>");
                                    $('#loadStudents').append(newRow);
                                    $('#loadStudents').append("<td><div class='d-flex align-items-center mb-2'><img src='images/profile.png' style='width: 40px;' class='rounded-5 me-3'><p class='green2 fw-semibold lh-sm m-0 p-0 fs-5 student-name'>" + response[i]["name"] + "</p></div></td>");
                                    $('#loadStudents').append("<td>" + response[i]["status"] + "</td>");
                                    $('#loadStudents').append("<td><input type='checkbox' name='status[" + response[i]["user_id"] + "]' class='status present' value='Present'> Present</td>");
                                    $('#loadStudents').append("<td><input type='checkbox' name='status[" + response[i]["user_id"] + "]' class='status absent' value='Absent'> Absent</td>");
                                    $('#loadStudents').append("<td><input type='checkbox' name='status[" + response[i]["user_id"] + "]' class='status late' value='Late'> Late</td>");
                                }

                            },
                            error: function(xhr, status, error) {
                            console.log("Status "+ status + " An error occured" + error)
                            }
                        });
                },
                error: function(xhr, status, error) {
                  console.log("Status "+ status + " An error occured" + error)
                }
              });

            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        const navLinks = document.querySelectorAll('.nav-link');

        // Loop through each link and add click event listener
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                // Remove 'active' class from all nav links
                navLinks.forEach(link => link.classList.remove('active'));
                // Add 'active' class to the clicked link
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>
