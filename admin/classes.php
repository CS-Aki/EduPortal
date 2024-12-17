<?php 
if (session_id() === "") session_start();
// echo "test " . $_SESSION["address"];
if(isset($_SESSION["user_category"])){
    $category = $_SESSION["user_category"];
    switch($category){
        // case 1: header("Location: ../admin/admin-dashboard.php"); exit(); break;
        case 2: header("Location: ../staff/staff-dashboard.php"); break;
        case 3: header("Location: ../instructor/instructor-dashboard.php"); exit(); break;
        case 4: header("Location: ../student/student-dashboard.php"); break;
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
    <title>Admin Dashboard</title>
    <style>
        .table thead th{
            background-color: #219E53 !important; 
            color: #FCFCFC !important; 
            border: #219E53;
        }
        .table td {
            font-weight: semibold;
            color: #6B656B;
        }
        
        .dataTables_info {
            color: #989598 !important; /* Change color */
        }
        .active >.page-link {
            background-color: #219E53 !important;
            color: #FCFCFC !important;
            border-color: #219E53 !important;
        }
        .page-link {
            color: #219E53 !important;
        }
        #myTable_filter input {
            border: 2px solid #4CAF50; /* Green border */
            padding: 5px 1em;
            color: #333;               /* Text color inside the input */
            border-radius: 50px;
        }
        #myTable_filter label {
            color: #56B37B; /* Change this color to whatever you prefer */
        }
        #editClassModal .dataTables_scroll {
        width: 100% !important;
        }
        #editClassModal .dataTables_scrollHeadInner,
        #editClassModal table.dataTable {
            width: 100% !important;
        }
        .changed {
            border: 2px solid red;
        }
    </style>
    <?php require('inc/links.php'); ?>
</head>
<body style="overflow-x: hidden;">
    <?php require('inc/header.php'); ?>

    <div class="container-fluid p-0 m-0" id="main-content">
        <div class="row">
            <div class="col-lg-10 col-sm-12 ms-auto mt-4">
                <div class="container" style="width: 80%;">
                <div class="container-fluid d-flex justify-content-between align-items-center mb-2">
                    <h1 class="h-font green1 me-2 sub-title mb-0" id="material-title">Classes</h1>
                    <button type="button" class="btn fs-5 green shadow-none white2 d-flex align-items-center justify-content-center py-0 px-4 rounded-5" data-bs-toggle="modal" data-bs-target="#createClassModal">
                        <i class="bi bi-plus-lg white2 me-1 fs-2"></i>Create
                    </button>
                </div>
                    <table id="myTable" class="table table-bordered text-center align-middle">
                        <thead>
                            <tr>
                            <th scope="col">Code</th>
                            <th scope="col">Subject Name</th>
                            <th scope="col">Professor</th>
                            <th scope="col">Time</th>
                            <th scope="col">Status</th>
                            <th scope="col">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php require_once("includes/class-list.php"); require_once("includes/add-class.php"); displayClassList(); ?>
                            <!-- <tr>
                                <td class='class_code'>9e35fd</td>
                                <td class='class_name'>Algorithm and Complexity</td>
                                <td class='class_teacher'>Efren Victoria</td>
                                <td class='class_schedule'>6:00PM-9:00PM</td>
                                <td class='class_status'>Active</td>
                                <td class="d-flex align-items-center justify-content-center">
                                <a href="" data-bs-toggle="modal" data-bs-target="#editClassModal"><i class="bi bi-pencil-square green1 me-2 fs-6"></i></a>
                                <a href=""><i class="bi bi-eye green1 fs-6"></i></td></a>
                            </tr> -->
                        </tbody>
                    </table>
                </div>
                <!-- <script> var table = $("#myTable tbody"); table.append(""); </script> -->

                <!-- EDIT CLASS MODAL -->
                <div class="modal fade" id="editClassModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editClassLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">                       
                            <div class="modal-content rounded-4">
                                <div class="modal-body">
                                    <form action="includes/edit-class.php" method="post" id="editClassForm">
                                        <div class="container-fluid mb-3 d-flex justify-content-between align-items-center">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div>
                                                    <i class='bi bi-bookmark-fill fs-1 green1 title p-0 m-0'></i>
                                                </div>
                                                <div class="lh-sm">
                                                    <h1 class="title fs-1 h-font ms-3 m-0 p-0 green1" id="title_class_name">Algorithm and Complexity</h1>
                                                    <!-- <p class="black3 fs-6 ms-3 m-0 p-0">Class</p> -->
                                                </div>
                                            </div>
                                            <button clas="d-flex align-items-start" type="button" class="btn-close" id="close_edit" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="container-fluid">
                                            <div class="row mb-3">
                                            <input type="text" class="form-control black3 shadow-elevation-light-3 container-fluid" name="teacherId" id="teacher-id" hidden>
                                                <div class="col-lg-8">
                                                    <label class="form-label black3 mb-0">Class Name</label>
                                                    <input type="text" class="form-control black3 shadow-elevation-light-3 container-fluid" value="Algorithm and Complexity" name="className" id="class_name" required>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="form-label black3 mb-0">Class Code</label>
                                                    <input type="text" class="form-control black3 shadow-elevation-light-3" value="9easf23" name="classCode" id="class_code" readonly>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="form-label black3 mb-0">Status</label>
                                                    <div class="input-group">
                                                        <select class="form-select shadow-elevation-light-3 black3" id="class_status">
                                                            <option value="Active">Active</option>
                                                            <option value="Archived">Archived</option>
                                                            <!-- <option value="3">Archived</option> -->
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-lg-12">
                                                    <label class="form-label black3 mb-0">Instructor</label>
                                                    <!-- <input type="text" class="form-control black3 shadow-elevation-light-3 container-fluid" name="classInstructor" id="class_instructor" required> -->
                                                    <select class="form-select shadow-elevation-light-3 black3" id="class_instructor" required>
                                                        <?php displayInstructorSelection(); ?>
                                                                <!-- Value should be user id -->
                                                    </select>  
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="form-label black3 mb-0">Schedule</label>
                                                <div class="row mb-3 mt-2 align-items-center">
                                                        <div class="col-lg-1">
                                                            <label class="black3 mb-0">Day</label>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <select class="form-select shadow-elevation-light-3 black3" name="daySched" id="daySched">
                                                                <option value="Monday">Monday</option>
                                                                <option value="Tuesday">Tuesday</option>
                                                                <option value="Wednesday">Wednesday</option>
                                                                <option value="Thursday">Thursday</option>
                                                                <option value="Friday">Friday</option>
                                                                <option value="Saturday">Saturday</option>
                                                                <option value="Sunday">Sunday</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-1">
                                                            <label class="black3 mb-0">From</label>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <select class="form-select shadow-elevation-light-3 black3" name="startingHourSched" id="startingHourSched">
                                                                <option value="blank"></option>
                                                                <option value="01">1</option>
                                                                <option value="02">2</option>
                                                                <option value="03">3</option>
                                                                <option value="04">4</option>
                                                                <option value="05">5</option>
                                                                <option value="06">6</option>
                                                                <option value="07">7</option>
                                                                <option value="08">8</option>
                                                                <option value="09">9</option>
                                                                <option value="10">10</option>
                                                                <option value="11">11</option>
                                                                <option value="12">12</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <select class="form-select shadow-elevation-light-3 black3" name="startingMinuteSched" id="startingMinuteSched">
                                                                <option value="blank"></option>
                                                                <option value="00">00</option>
                                                                <option value="10">10</option>
                                                                <option value="20">20</option>
                                                                <option value="30">30</option>
                                                                <option value="40">40</option>
                                                                <option value="50">50</option>                           
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <select class="form-select shadow-elevation-light-3 black3" name="startingPeriodSched" id="startingPeriodSched">
                                                                <option value="blank"></option>
                                                                <option value="AM">AM</option>
                                                                <option value="PM">PM</option>
                                                            </select>
                                                        </div>
                                                </div>
                                                <div class="row mb-3 align-items-center">
                                                    <div class="col-lg-5"></div>
                                                    <div class="col-lg-1">
                                                        <label class="black3 mb-0">To</label>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <select class="form-select shadow-elevation-light-3 black3" name="endingHourSched" id="endingHourSched">
                                                            <option value="blank"></option>
                                                            <option value="01">1</option>
                                                            <option value="02">2</option>
                                                            <option value="03">3</option>
                                                            <option value="04">4</option>
                                                            <option value="05">5</option>
                                                            <option value="06">6</option>
                                                            <option value="07">7</option>
                                                            <option value="08">8</option>
                                                            <option value="09">9</option>
                                                            <option value="10">10</option>
                                                            <option value="11">11</option>
                                                            <option value="12">12</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <select class="form-select shadow-elevation-light-3 black3" name="endingMinuteSched" id="endingMinuteSched">
                                                            <option value="blank"></option>
                                                            <option value="00">00</option>
                                                            <option value="10">10</option>
                                                            <option value="20">20</option>
                                                            <option value="30">30</option>
                                                            <option value="40">40</option>
                                                            <option value="50">50</option>

                                                        </select>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <select class="form-select shadow-elevation-light-3 black3" name="endingPeriodSched" id="endingPeriodSched">
                                                            <option value="blank"></option>
                                                            <option value="AM">AM</option>
                                                            <option value="PM">PM</option>
                                                        </select>
                                                    </div>
                                                </div>
                                               
                                            </div>
                                            </div>
                                                <table id="studentTable" class="table table-bordered text-center align-middle" width="100%">
                                                    <thead>
                                                        <tr>
                                                        <th scope="col">Student Number</th>
                                                        <th scope="col">Full Name</th>
                                                        <th scope="col">Email</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="studentList">

                                                        <!-- <tr>
                                                            <td>20220141-S</td>
                                                            <td>Cachero</td>
                                                            <td>Jarmen</td>
                                                            <td>Almario</td>
                                                        </tr> -->
                                                    </tbody>
                                                </table>
                                                <div class="d-flex justify-content-end gap-1 mt-2">
                                                    <button type="submit" name="saveClassBtn" class="btn green shadow-none border-none rounded-5 px-4 py-2" id="save_class_btn">Save</button>
                                                    <button class="btn bordergreen green1 rounded-5 px-4 py-2" type="button" class="btn-close" id="back_modal" data-bs-dismiss="modal" aria-label="Close">Back</button>
                                               
                                                </div>
                                                <br>
                                                <div id="message"></div>
                                            </div>
                                            
                                        </div>
                                    </form>
                                </div>
                            </div>                
                    </div>
                </div>

                <!-- CREATE CLASS MODAL -->
                <div class="modal fade" id="createClassModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createClassLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">                       
                            <div class="modal-content rounded-4">
                            <form action="includes/add-class.php" method="post" id="createForm">
                                <div class="modal-body">
                                        <div class="container-fluid mb-3 d-flex justify-content-between align-items-center">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div>
                                                    <i class='bi bi-plus-circle-fill fs-1 green1 title p-0 m-0'></i>
                                                </div>
                                                <div class="lh-sm">
                                                    <h1 class="title fs-1 h-font ms-3 m-0 p-0 green1" id="className">Create Class</h1>
                                                </div>
                                            </div>
                                            <button clas="d-flex align-items-start" type="button" class="btn-close" id="close_code" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="container-fluid">
                                            <div class="row mb-3">
                                                <div class="col-lg-6">
                                                    <label class="form-label black3 mb-0">Class Code</label>
                                                    <input type="text" class="form-control black3 shadow-elevation-light-3 container-fluid" value="<?php echo generateClassCode(); ?>" name="classCode" id="create_code" readonly>
                                                </div>
                                           
                                                <div class="col-lg-6">
                                                    <label class="form-label black3 mb-0">Status</label>
                                                    <div class="input-group">
                                                        <select class="form-select shadow-elevation-light-3 black3" id="create_status">
                                                            <option value="Active">Active</option>
                                                            <option value="Archived">Archived</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-lg-12">
                                                    <label class="form-label black3 mb-0">Class Name</label>
                                                    <input type="text" class="form-control black3 shadow-elevation-light-3 container-fluid" value="" name="className" id="create_name" required>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-lg-12">
                                                        <label class="form-label black3 mb-0">Class Instructor</label>
                                                        <select class="form-select shadow-elevation-light-3 black3" id="create_instructor" required>
                                                                <option value=""></option>
                                                                <?php displayInstructorSelection(); ?>
                                                                <!-- Value should be user id -->

                                                        </select>                         
                                                    </div>
                                                 </div>
                                            <div class="row mb-3 mt-2 align-items-center">
                                                <label class="form-label black3 mb-0">Schedule</label>
                                                    <div class="col-lg-1">
                                                        <label class="black3 mb-0">Day</label>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <select class="form-select shadow-elevation-light-3 black3" name="daySched" id="createDay" required>
                                                            <option value="Monday">Monday</option>
                                                            <option value="Tuesday">Tuesday</option>
                                                            <option value="Wednesday">Wednesday</option>
                                                            <option value="Thursday">Thursday</option>
                                                            <option value="Friday">Friday</option>
                                                            <option value="Saturday">Saturday</option>
                                                            <option value="Sunday">Sunday</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <label class="black3 mb-0">From</label>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <select class="form-select shadow-elevation-light-3 black3" name="startingHourSched" id="createStartingHourSched" required>
                                                            <option value=""></option>
                                                            <option value="01">1</option>
                                                            <option value="02">2</option>
                                                            <option value="03">3</option>
                                                            <option value="04">4</option>
                                                            <option value="05">5</option>
                                                            <option value="06">6</option>
                                                            <option value="07">7</option>
                                                            <option value="08">8</option>
                                                            <option value="09">9</option>
                                                            <option value="10">10</option>
                                                            <option value="11">11</option>
                                                            <option value="12">12</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <select class="form-select shadow-elevation-light-3 black3" name="startingMinuteSched" id="createStartingMinuteSched" required>
                                                            <option value=""></option>
                                                            <option value="01">00</option>
                                                            <option value="02">10</option>
                                                            <option value="03">20</option>
                                                            <option value="04">30</option>
                                                            <option value="05">40</option>
                                                            <option value="05">50</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <select class="form-select shadow-elevation-light-3 black3" name="startingPeriodSched" id="createStartingPeriodSched" required>
                                                            <option value=""></option>
                                                            <option value="AM">AM</option>
                                                            <option value="PM">PM</option>
                                                        </select>
                                                    </div>
                                            </div>
                                            <div class="row mb-3 align-items-center">
                                                <div class="col-lg-5"></div>
                                                <div class="col-lg-1">
                                                    <label class="black3 mb-0">To</label>
                                                </div>
                                                <div class="col-lg-2">
                                                    <select class="form-select shadow-elevation-light-3 black3" name="endingHourSched" id="createEndingHourSched" required>
                                                        <option value=""></option>
                                                        <option value="01">1</option>
                                                        <option value="02">2</option>
                                                        <option value="03">3</option>
                                                        <option value="04">4</option>
                                                        <option value="05">5</option>
                                                        <option value="06">6</option>
                                                        <option value="07">7</option>
                                                        <option value="08">8</option>
                                                        <option value="09">9</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-2">
                                                    <select class="form-select shadow-elevation-light-3 black3" name="endingMinuteSched" id="createEndingMinuteSched" required>
                                                        <option value=""></option>
                                                        <option value="01">00</option>
                                                        <option value="02">10</option>
                                                        <option value="03">20</option>
                                                        <option value="04">30</option>
                                                        <option value="05">40</option>
                                                        <option value="05">50</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-2">
                                                    <select class="form-select shadow-elevation-light-3 black3" name="endingPeriodSched" id="createEndingPeriodSched" required>
                                                        <option value=""></option>
                                                        <option value="AM">AM</option>
                                                        <option value="PM">PM</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-center align-items-center gap-1 my-2">
                                                <button type="submit" name="createClassBtn" class="btn green shadow-none border-none rounded-5 px-4 py-2" id="create_class_btn">Create</button>
                                                <button class="btn bordergreen green1 rounded-5 px-4 py-2" type="button" class="btn-close" id="close_code" data-bs-dismiss="modal" aria-label="Close">Back</button>
                                            </div>
                                            <div id="create_message"></div>
                                        </div>
                                    </div> 
                                    </form>
                                </div>
                            </div>                
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br>
    <?php require('inc/footer.php'); ?>   

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: true,
                pageLength: 10,
                language: {
                    search: "Filter records:",
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'csv',
                        className: 'btn btn-success',
                        text: 'Export CSV'
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-info',
                        text: 'Print'
                    }
                ]
            });
        });
        $(document).ready(function () {
            $('#studentTable').DataTable({
                paging: false,          // Disable pagination
                searching: false,       // Disable search
                ordering: true,         // Allow column sorting
                info: false,            // Disable "Showing X of Y entries" text
                scrollY: "200px",       // Limit table body height (approx. 8 rows)
                scrollCollapse: true, 
                autoWidth: true,  
                fixedHeader: true,      // Enable fixed headers
                language: {
                    emptyTable: "No students available",
                },
            });
        });
    </script>
     <script src="scripts/edit-class.js"></script>
     <script src="scripts/add-class.js"></script>
     <script src="scripts/view-class.js"></script>

</body>
</html>
