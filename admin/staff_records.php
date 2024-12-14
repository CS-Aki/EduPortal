<?php 
if (session_id() === "") session_start();
// echo "test " . $_SESSION["address"];
if(isset($_SESSION["user_category"])){
    $category = $_SESSION["user_category"];
    switch($category){
        // case 1: header("Location: ../admin/admin-dashboard.php"); exit(); break;
        // case 2: header("Location: ../instructor/instructor-dashboard.php"); break;
        case 3: header("Location: ../instructor/instructor-dashboard.php"); exit(); break;
        case 4: header("Location: staff/staff-dashboard.php"); break;
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
        #editStaffModal .dataTables_scroll {
        width: 100% !important;
        }
        #editStaffModal .dataTables_scrollHeadInner,
        #editStaffModal table.dataTable {
            width: 100% !important;
        }
    </style>
    <?php require('inc/links.php'); ?>
    
</head>
<body>
    <?php require('inc/header.php'); require_once("includes/staff-list.php"); ?>

    <div class="container-fluid p-0 m-0" id="main-content">
        <div class="row">
            <div class="col-lg-10 col-sm-12 ms-auto">
                <nav class="navbar navbar-expand-lg sticky-top line fs-5 z-1 greennav py-1" id="records_directory">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse green1" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="instructor_records.php">Instructors</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="student_records.php">Students</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active linewhite h-100" href="staff_records.php">Staff</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                <div class="container mt-2" style="width: 80%;">
                    <div class="d-flex justify-content-end mb-3"> 
                        <button type="button" class="btn fs-5 green shadow-none white2 d-flex align-items-center justify-content-center py-0 px-4 rounded-5" data-bs-toggle="modal" data-bs-target="#signUpModal">
                            <i class="bi bi-plus-lg white2 me-1 fs-2"></i>Register New Staff Account
                        </button>
                    </div>
                    <table id="myTable" class="table table-bordered text-center align-middle">
                        <thead>
                            <tr>
                                <th scope="col">Code</th>
                                <th scope="col">Staff Code</th>
                                <th scope="col">Full Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Status</th>
                                <th scope="col">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php displayAllStaff(); ?>
                        </tbody>
                    </table>
                </div>

                <!-- EDIT STAFF MODAL -->
                <div class="modal fade" id="editStaffModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editStaffLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl">                       
                            <div class="modal-content rounded-4 px-2">
                                <div class="modal-body">
                                    <form action="includes/edit-staff.php" method="post" id="editStaffForm">
                                        <div class="container-fluid d-flex justify-content-between align-items-center">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div>
                                                    <img src="" class="rounded-pill" style="width: 6rem;"alt="" id="staff_image">
                                                </div>
                                                <div class="lh-sm">
                                                    <h1 class="title fs-1 h-font ms-3 m-0 p-0 green1" id="title_staff">Dua Lipa</h1>
                                                    <p class="black3 fs-6 ms-3 m-0 p-0">Staff</p>
                                                </div>
                                            </div>
                                            <button clas="d-flex align-items-start" type="button" class="btn-close" id="close_code" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="container-fluid">
                                            <div class="row mb-2">
                                                <div class="col-lg-6">
                                                    <label class="form-label black3 mb-0">Name</label>
                                                    <input type="text" class="form-control black3 shadow-elevation-light-3 container-fluid" value="Jarmen Cachero" name="staffName" id="staff_name" required>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="form-label black3 mb-0">Date of Birth</label>
                                                    <input type="date" class="form-control black3 shadow-elevation-light-3" name="dateOfBirth" id="date_of_birth1" readonly>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="form-label black3 mb-0">Status</label>
                                                    <div class="input-group">
                                                        <select class="form-select shadow-elevation-light-3 black3" id="staff_status">
                                                            <option value="Active">Active</option>
                                                            <option value="Archived">Archived</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-lg-6">
                                                    <label class="form-label black3 mb-0">Email</label>
                                                    <input type="text" class="form-control black3 shadow-elevation-light-3 container-fluid" value="jarmencachero@ucc.edu.ph" name="staffEmail" id="staff_email" required>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="form-label black3 mb-0">Staff Code</label>
                                                    <input type="text" class="form-control black3 shadow-elevation-light-3" value="20220141-S" name="staffCode" id="staffCode" readonly hidden>
                                                    <input type="text" class="form-control black3 shadow-elevation-light-3" name="staffCode" id="staffCodeText" readonly>
                                                </div>
                                                <!-- <div class="col-lg-3">
                                                    <label class="form-label black3 mb-0">Department</label>
                                                    <input type="text" class="form-control black3 shadow-elevation-light-3" value="Computer Studies" name="staffCode" id="staffCode" required>
                                                </div> -->
                                                <div class="col-lg-3">
                                                    <label class="form-label black3 mb-0">Gender</label>
                                                    <select class="form-select shadow-elevation-light-3 black3" id="staffGender">
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-lg-12">
                                                    <label class="form-label black3 mb-0">Address</label>
                                                    <input type="text" class="form-control black3 shadow-elevation-light-3 container-fluid" value="Blk 33 Lot 28 Bangayngay St. Dagat-dagatan Caloocan City" name="staffAddress" id="staff_address" required>
                                                </div>
                                            </div>
                                            
                                            <div class="d-flex justify-content-end gap-1 mt-2">
                                                <button type="submit" name="saveClassBtn" class="btn green shadow-none border-none rounded-5 px-4 py-2" id="save_staff_btn">Save</button>
                                                <button class="btn bordergreen green1 rounded-5 px-4 py-2" type="button" class="btn-close" id="close" data-bs-dismiss="modal" aria-label="Close">Back</button>
                                            </div>

                                        </div>
                                    </form>

                                </div>
                                <div id="staffModalMsg"></div>
                            </div>                
                    </div>
                </div>

                
            </div>
        </div>
    </div>
    <br><br>
                <!-- Sign Up Modal -->
                <div class="modal fade" id="signUpModal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg w-70">
                            <div class="modal-content rounded p-2">
                                <div class="modal-body">
                                    <div class="container-fluid mb-3 d-flex justify-content-between align-items-center">
                                        <h1 class="modal-title fs-1 h-font" id="staticBackdropLabel">Register Staff</h1>
                                        <button type="button" id="close_btn" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="includes/register-staff.php" class="row g-3 needs-validation" novalidate method="post" id="signUpForm">
                                        <div class="container-fluid">
                                            <div class="row mb-1">
                                                <div class="col-lg-4">
                                                    <label class="form-label black2 mb-0">First Name</label>
                                                    <input type="text" class="form-control black2 shadow-sm" placeholder="Enter First Name" name="firstName" id="first_name" required >
                                                </div>
                                                <div class="col-lg-4">
                                                    <label class="form-label black2 mb-0">Last Name</label>
                                                    <input type="text" class="form-control black2 shadow-sm" placeholder="Enter Last Name" name="lastName" id="last_name" required >
                                                </div>
                                                <div class="col-lg-4">
                                                    <label class="form-label black2 mb-0">Middle Name (optional)</label>
                                                    <input type="text" class="form-control black2 shadow-sm" placeholder="Enter Middle Name" name="middleName" id="middle_name">
                                                </div>
                                            </div>
                                            <div class="row mb-1">
                                                <div class="col-lg-6">
                                                    <label class="form-label black2 mb-0">Email</label>
                                                    <input type="email" class="form-control black2 shadow-sm" placeholder="Enter Email" name="email" id="email" required >
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="form-label black2 mb-0">Date of Birth</label>
                                                    <input type="date" class="form-control black2 shadow-sm" value="" name="birthdate" id="date_of_birth" max="<?= date('Y-m-d'); ?>" required>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="form-label black2 mb-0">Gender</label>
                                                    <select class="form-select shadow-elevation-light-3 black2" id="gender" name="gender" required>
                                                        <option value="blank"></option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                        <option value="Rather not say">Rather not say</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-1">
                                                <div class="col-12 mb-1">
                                                    <label class="form-label black2 mb-0">Address</label>
                                                    <textarea class="form-control black2 container-fluid shadow-sm" rows="2" placeholder="Enter Address" id="address" name="address" required></textarea>
                                                </div>
                                            </div>
                                            <div class="row mb-1">
                                                <div class="col-lg-6 mb-1">
                                                    <label class="form-label black2 mb-0">Password</label>
                                                    <input type="password" class="form-control black2 shadow-sm" placeholder="Enter Password" name="password" id="password" required>
                                                </div>
                                                <div class="col-lg-6 mb-1">
                                                    <label class="form-label black2 mb-0">Confirm Password</label>
                                                    <input type="password" class="form-control black2 shadow-sm" placeholder="Re-Enter Password" name="repeatPass" id="repeat_pass" required>
                                                </div>
                                            </div>
                                            
                                            <div class="justify-content-center">
                                                <button type="submit" name="registerBtn" id="register_btn" class="w-100 btn green shadow-none rounded-5 px-5 py-2">Register</button>
                                            </div>
                                            <br>
                                            <div id="registerModalMsg"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

    <?php require('inc/footer.php'); ?>   
    <script src="scripts/register-staff.js"></script>
    <script src="scripts/view-profile.js"></script>
    <script src="scripts/edit-profile.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </script>
    <script>
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#myTable')) {
                $('#myTable').DataTable().destroy();
            }

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
                ],
                columnDefs: [
                { 
                    targets: 0, // First column (Instructor Code)
                    visible: false, // Hide the column
                }
                ]
            });
        });
        $(document).ready(function () {
            $('#staffTable').DataTable({
                paging: false,          // Disable pagination
                searching: false,       // Disable search
                ordering: true,         // Allow column sorting
                info: false,            // Disable "Showing X of Y entries" text
                scrollY: "200px",       // Limit table body height (approx. 8 rows)
                scrollCollapse: true, 
                autoWidth: true,  
                fixedHeader: true,      // Enable fixed headers
                language: {
                    emptyTable: "No staffs available",
                },
            });
        });
    </script>
</body>
</html>
