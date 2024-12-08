<?php 
if (session_id() === "") session_start();
// echo "test " . $_SESSION["address"];
if(isset($_SESSION["user_category"])){
    $category = $_SESSION["user_category"];
    switch($category){
        // case 1: header("Location: ../admin/admin-dashboard.php"); exit(); break;
        // case 2: header("Location: ../instructor/instructor-dashboard.php"); break;
        case 3: header("Location: ../instructor/instructor-dashboard.php"); exit(); break;
        case 4: header("Location: student/student-dashboard.php"); break;
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
    <?php require('inc/header.php'); ?>

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
                 
                    <table id="myTable" class="table table-bordered text-center align-middle">
                        <thead>
                            <tr>
                                <th scope="col">Code</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Middle Name</th>
                                <th scope="col">Departent</th>
                                <th scope="col">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>56wdi4</td>
                                <td>Lipa</td>
                                <td>Dua</td>
                                <td>Margareth</td>
                                <td>CSD</td>
                                <td class="d-flex align-items-center justify-content-center">
                                    <a href="" data-bs-toggle="modal" data-bs-target="#editStaffModal"><i class="bi bi-pencil-square green1 me-2 fs-6"></i></a>
                            </tr>
                            <tr>
                                <td>56wdi4</td>
                                <td>Lipa</td>
                                <td>Dua</td>
                                <td>Margareth</td>
                                <td>CSD</td>
                                <td class="d-flex align-items-center justify-content-center">
                                    <a href="" data-bs-toggle="modal" data-bs-target="#editStaffModal"><i class="bi bi-pencil-square green1 me-2 fs-6"></i></a>
                            </tr>
                            <tr>
                                <td>56wdi4</td>
                                <td>Lipa</td>
                                <td>Dua</td>
                                <td>Margareth</td>
                                <td>CSD</td>
                                <td class="d-flex align-items-center justify-content-center">
                                    <a href="" data-bs-toggle="modal" data-bs-target="#editStaffModal"><i class="bi bi-pencil-square green1 me-2 fs-6"></i></a>
                            </tr>
                            <tr>
                                <td>56wdi4</td>
                                <td>Lipa</td>
                                <td>Dua</td>
                                <td>Margareth</td>
                                <td>CSD</td>
                                <td class="d-flex align-items-center justify-content-center">
                                    <a href="" data-bs-toggle="modal" data-bs-target="#editStaffModal"><i class="bi bi-pencil-square green1 me-2 fs-6"></i></a>
                            </tr>
                            <tr>
                                <td>56wdi4</td>
                                <td>Lipa</td>
                                <td>Dua</td>
                                <td>Margareth</td>
                                <td>CSD</td>
                                <td class="d-flex align-items-center justify-content-center">
                                    <a href="" data-bs-toggle="modal" data-bs-target="#editStaffModal"><i class="bi bi-pencil-square green1 me-2 fs-6"></i></a>
                            </tr><tr>
                                <td>56wdi4</td>
                                <td>Lipa</td>
                                <td>Dua</td>
                                <td>Margareth</td>
                                <td>CSD</td>
                                <td class="d-flex align-items-center justify-content-center">
                                    <a href="" data-bs-toggle="modal" data-bs-target="#editStaffModal"><i class="bi bi-pencil-square green1 me-2 fs-6"></i></a>
                            </tr>
                            <tr>
                                <td>56wdi4</td>
                                <td>Lipa</td>
                                <td>Dua</td>
                                <td>Margareth</td>
                                <td>CSD</td>
                                <td class="d-flex align-items-center justify-content-center">
                                    <a href="" data-bs-toggle="modal" data-bs-target="#editStaffModal"><i class="bi bi-pencil-square green1 me-2 fs-6"></i></a>
                            </tr>
                            
                            
                            
                       
                        </tbody>
                    </table>
                </div>

                <!-- EDIT STAFF MODAL -->
                <div class="modal fade" id="editStaffModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editStaffLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl">                       
                            <div class="modal-content rounded-4 px-2">
                                <div class="modal-body">
                                    <form action="">
                                        <div class="container-fluid d-flex justify-content-between align-items-center">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div>
                                                    <img src="images/testimage.jpg" class="rounded-pill" style="width: 6rem;"alt="">
                                                </div>
                                                <div class="lh-sm">
                                                    <h1 class="title fs-1 h-font ms-3 m-0 p-0 green1" id="className">Dua Lipa</h1>
                                                    <p class="black3 fs-6 ms-3 m-0 p-0">Staff</p>
                                                </div>
                                            </div>
                                            <button clas="d-flex align-items-start" type="button" class="btn-close" id="close_code" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="container-fluid">
                                            <div class="row mb-2">
                                                <div class="col-lg-6">
                                                    <label class="form-label black3 mb-0">Name</label>
                                                    <input type="text" class="form-control black3 shadow-elevation-light-3 container-fluid" value="Jarmen Cachero" name="studentName" id="student_name" required>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="form-label black3 mb-0">Date of Birth</label>
                                                    <input type="text" class="form-control black3 shadow-elevation-light-3" value="08-08-08" name="dateOfBirth" id="date_of_birth" readonly>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="form-label black3 mb-0">Status</label>
                                                    <div class="input-group">
                                                        <select class="form-select shadow-elevation-light-3 black3" id="statusInputGroup">
                                                            <option value="1">Active</option>
                                                            <option value="2">Inactive</option>
                                                            <option value="3">Archived</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-lg-6">
                                                    <label class="form-label black3 mb-0">Email</label>
                                                    <input type="text" class="form-control black3 shadow-elevation-light-3 container-fluid" value="jarmencachero@ucc.edu.ph" name="studentEmail" id="student_email" required>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="form-label black3 mb-0">Department</label>
                                                    <input type="text" class="form-control black3 shadow-elevation-light-3" value="Computer Studies" name="studentCode" id="studentCode" required>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="form-label black3 mb-0">Gender</label>
                                                    <input type="text" class="form-control black3 shadow-elevation-light-3" value="Male" name="studentGender" id="studentGender" required>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-lg-12">
                                                    <label class="form-label black3 mb-0">Address</label>
                                                    <input type="text" class="form-control black3 shadow-elevation-light-3 container-fluid" value="Blk 33 Lot 28 Bangayngay St. Dagat-dagatan Caloocan City" name="studentAddress" id="student_address" required>
                                                </div>
                                            </div>
                                           
                                            
                                        </div>
                                    </form>
                                    <!-- <form action="includes/join-class.php" method="post" id="joinClassForm">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-10">
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" value="Enter Class Code..." name="classCode" id="class_code" required>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <button type="submit" name="joinClassBtn" class="btn btn-primary green shadow-none rounded-5 px-5" id="join_class_btn">Join</button>
                                            </div>
                                        </div>
                                        <div class="join-class-msg"></div>
                                    </form> -->
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
</body>
</html>
