<?php
if (session_id() === "") session_start();

if (!isset($_SESSION["user_category"])) {
    header("Location: ../index.php");
}

if (isset($_SESSION["user_category"])) {
    $category = $_SESSION["user_category"];
    switch ($category) {
        case 1:
            header("Location: ../admin/admin-dashboard.php");
            exit();
            break;
        case 2:
            break;
            // case 3: header("Location: instructor/instructor-dashboard.php"); break;
        case 4:
            header("Location: ../student/student-dashboard.php");
            exit();
            break;
    }
} else {
    header("Location: ../");
    exit();
}

// echo "This is the " . $_SESSION["access_token"]["access_token"];
// phpinfo();
if (isset($_GET["code"])) {
    include("includes/upload-file.php");
} else {
    unset($_SESSION["classCode"]);
    unset($_SESSION["storedFile"]);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professor Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.19.0/js/md5.min.js"></script>

    <!-- <script src="scripts/view-class.js"></script> -->
    <!-- <script src="scripts/class-content.js"></script> -->
    <!-- <script src="scripts/view-post.js"></script> -->
    <?php if (isset($_GET["class"])) {
        include("includes/view-class.php");
        $_SESSION["code"] = $classCode;
    } ?>
    <?php require('inc/links.php');
    if (isset($_GET['state']) && isset($_GET['code'])) {
        $stateData = json_decode($_GET['state'], true); // Decode JSON
        $class = $stateData['class'] ?? null;

        // $codeData = json_decode($_GET['code'], true);
        $code = $_GET['code'] ?? null;
        if ($class) {
            header("Location: http://localhost/EduPortal/instructor/post-form.php?class=$class&code=$code");
            exit;
        }
    }
    ?>

</head>

<body>
    <?php require('inc/header.php'); ?>

    <div class="container-fluid p-0 m-0" id="main-content">
        <div class="row">
            <div class="col-lg-10 col-sm-12 ms-auto">
                <nav class="navbar navbar-expand-lg sticky-top line fs-5 z-2" style="background-color: white">
                    <div class="container-fluid sticky-top">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse green1" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link active" href="class.php?class=<?php echo md5($details[0]["class_code"]); ?>">Class Name</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="submittedworks.php?class=<?php echo md5($details[0]["class_code"]); ?>">Submitted Works</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="list.php?class=<?php echo md5($details[0]["class_code"]); ?>">List of Students</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                <?php $toCreate = "Material" ?> <!-- ausin pa para ma save ung clicked sa prev dropdown as variable para ma show, or if may easier paraan ka -->

                <h1 style="margin: 15px 0px 0px 15px;" class="h-font green1 me-2 sub-title">Create <?php echo $toCreate; ?></h1>
                <div style="padding: 1% 2%; position: relative;" id="postContainer">
                    <!-- <label class="labelText" >Content Type:</label> -->
                    <select style="position: absolute; z-index: 20;" id="contentType">
                        <option class="green2" value="material">Material</option>
                        <option class="green2" value="activity">Activity</option>
                        <option class="green2" value="quiz">Quiz</option>
                    </select><span> <br>
                    </span>

                    <form action="includes/create-post.php" method="post" id="postForm" enctype="multipart/form-data">
                        <!-- <input type="text" id="title" placeholder="Enter Title" required> -->
                        <span style="font-size: large;" class="form-label" id="inputGroup-sizing-default">Title: </span>
                        <div class="form-floating">
                            <textarea class="form-control rounded-2" placeholder="Leave a comment here" id="title" required></textarea>
                            <label for="floatingTextarea2" style="color: var(--black3);">Enter Title</label>
                        </div>

                        <!-- <div class="input-group"></div> -->
                        <span style="font-size: large;" class="form-label" id="inputGroup-sizing-default">Description:</span>
                        <div class="form-floating">
                            <textarea class="form-control rounded-2" placeholder="Leave a comment here" id="description" required></textarea>
                            <label for="floatingTextarea2" style="height: 7rem; color: var(--black3);">Enter Description</label>
                        </div>
                        <!-- <input type="text" id="description" placeholder="Enter Description" required> -->

                        <br>
                        <div class="row">
                            <div class="col-3" id="dateContainer" hidden>
                                <!-- <label for="deadlineDate">Deadline Date:</label> -->
                                <span style="font-size: large;" class="form-label" id="inputGroup-sizing-default">Deadline Date: </span>
                                <!-- <input type="date" id="deadlineDate" name="deadlineDate"> -->
                                <input type="date" id="deadlineDate" name="deadlineDate"  >

                            </div>
                            <div class="col-3" id="timeContainer" hidden>
                                <!-- <label for="deadlineTime">Deadline Time:</label> -->
                                <span style="font-size: large;" class="form-label" id="inputGroup-sizing-default">Deadline Time: </span>
                                <input id="deadlineTime" type="time" name="deadlineTime" value="12:00" >
                            </div>
                        </div>
                        <div class="col-lg-2">
                             <button class="container-fluid btn green shadow-none mt-2 fw-medium fs-5">Create Post</button>
                         </div>
                    </form>

                    <div class="form-group">
                        <form method="post" action="includes/upload-file.php" class="form" enctype="multipart/form-data" id="fileForm">
                            <!-- <label>File</label> -->
                            <!-- <div style="border: 2px solid var(--green2); width: 65px; height: 65px; display: flex; justify-content: center; align-items: center;" class="rounded-2"><i class="greenicon bi bi-upload" ></i></div> -->
                            <label for="fileInput" class="btn btn-success mt-2 ms-2 fw-semibold" title="Upload File"><i style="font-size: 24px;" class="whiteicon bi bi-upload me-2"></i>Upload File</label>
                            <input type="file" id="fileInput" name="files[]" style="display: none;" multiple>
                            <p id="fileCount">No files selected</p>
                            <!-- <span style="font-size: large;" class="form-label" id="inputGroup-sizing-default">Upload</span> -->
                            <!-- <input type="file" name="files[]" class="form-control" id="fileInput" multiple> -->
                            <input type="submit" hidden>
                            <input type="text" name="classCode" value="<?php echo md5($details[0]["class_code"]); ?>" hidden>
                            <input type="text" id="token" value="<?php if (isset($_SESSION["access_token"])) echo $_SESSION["access_token"]["access_token"]; ?>" hidden>
                        </form>
                    </div>

                    <!-- Handles the messaging -->
                    <div class="form-message"></div>
                    <hr>

                </div>
            </div>
            <br><br><br>
            <br><br><br>
            <script src="https://eduportal-wgrc.onrender.com/socket.io/socket.io.min.js"></script>
            <script src="scripts/post.js"></script>

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