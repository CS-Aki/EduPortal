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

// echo "This is the " . $_SESSION["access_token"]["access_token"];
// phpinfo();
if(isset($_GET["code"])){
    include("includes/upload-file.php");
}else{
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
    <?php if(isset($_GET["class"])){ include("includes/view-class.php"); $_SESSION["code"] = $classCode; } ?>
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
                    <div class="container-fluid sticky-top" >
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse green1" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link active" href="class.php?class=<?php echo md5($details[0]["class_code"]); ?>" >Class Name</a>
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

                                <div id="postContainer">
                                    <label>Content Type</label>
                                    <select id="contetType">
                                        <option value="material">Material</option>
                                        <option value="quiz">Quiz</option>
                                        <option value="activity">Activity</option>
                                    </select>
                                    
                                    <form action="includes/create-post.php" method="post" id="postForm" enctype="multipart/form-data">
                                        <label>Title</label>
                                        <input type="text" id="title" placeholder="Enter Title" required><br>
                                        <label>Description</label>
                                        <input type="text" id="description" placeholder="Enter Description" required><br>
                                         <div id="dateContainer" hidden>
                                            <label for="startingDate">Starting Date:</label>
                                            <input id="startingDate" type="date" name="startingDate" value="12:00"><br>
                                            <label for="deadlineDate">Deadline Date:</label>
                                            <input type="date" id="deadlineDate" name="deadlineDate">
                                        </div>  <br>

                                        <div id="timeContainer" hidden>
                                            <label for="startingTime">Starting Time:</label>
                                            <input id="startingTime" type="time" name="startingTime" value="12:00"><br>
                                            <label for="deadlineTime">Deadline Time:</label>
                                            <input id="deadlineTime" type="time" name="deadlineTime" value="12:00">
                                        </div>

                                        <div class="col-lg-2">
                                            <button class="container-fluid btn green shadow-none mt-2 fw-medium fs-5">Create Post</button>
                                        </div>
                                    </form>

                                    <div class="form-group" id="uploadContainer">
                                    <form method="post" action="includes/upload-file.php" class="form" enctype="multipart/form-data" id="fileForm">
                                        <label>File</label>
                                        <input type="file" name="files[]" class="form-control" id="fileInput" multiple>
                                        <input type="submit" hidden>
                                        <input type="text" name="classCode" value="<?php echo md5($details[0]["class_code"]); ?>" hidden>
                                        <input type="text" id="token" value="<?php if(isset($_SESSION["access_token"])) echo $_SESSION["access_token"]["access_token"]; ?>" hidden>
                                    </form>
                                    </div>

                                    <p class="form-message"></p>

                                </div>
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