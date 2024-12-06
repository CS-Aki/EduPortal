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
        case 3: header("Location: ../instructor/instructor-dashboard.php"); exit(); break;
        // case 4: header("Location: student/student-dashboard.php"); break;
    }
}else{
    header("Location: ../");
    exit();
}

if (isset($_GET["code"])) {
    include("student backend/includes/auth.php");
} else {
    unset($_SESSION["classCode"]);
    unset($_SESSION["storedFile"]);
}

if(isset($_GET["error"])){
    header("location: http://localhost/EduPortal/student/material.php?class=" . $_SESSION["storeCode"] . "&post="  . $_SESSION["postId"]);
}

$_SESSION["postId"] = $_GET["post"];
$_SESSION["storeCode"] =  $_GET["class"];
// echo $_SESSION["postId"];

// echo $_SESSION['access_token'];

// echo $_SESSION["storedId"];
// if(!isset($_SESSION['access_token'])){
//     include("includes/auth.php");
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.19.0/js/md5.min.js"></script>
    <?php if(session_id() === "") session_start(); require('inc/links.php'); include("student backend/includes/view-post.php"); 
    //   echo var_dump($postDetails);
    ?>
</head>
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
                                <a class="nav-link" href="class.php?class=<?php echo md5($postDetails[0]["class_code"]); ?>">Class Name</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active"href="submittedworks.php?class=<?php echo md5($postDetails[0]["class_code"]); ?>">Submitted Works</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="list.php?class=<?php echo md5($postDetails[0]["class_code"]); ?>">List of Students</a>
                            </li>
                        </ul>
                        </div>
                    </div>
                </nav>
                <?php 
                    if($postDetails[0]["content_type"] == "Material"){
                ?>
                <div class="container mt-4 px-lg-5 px-sm-2">
                    <p id="post-id" hidden><?php echo $postDetails[0]["post_id"]; ?></p>
                    <div class="mt-2">
                        <div class="d-flex">
                            <div>
                                <i class="bi bi-bookmark-fill green1 fs-1 p-0 m-0 me-3"></i>
                            </div>
                            <div class="w-100">
                                <div>
                                    <h1 class="h-font green1 me-2 sub-title mb-0" id="material-title"><?php echo $postDetails[0]["title"]; ?></h1>
                                    <p class="fw-light green2 fs-6 d-flex m-0" id="material-date"><?php echo $month . " ". $day . ", " . $year ?></p>   
                                </div>
                                <div class="mt-3" id="material-description">
                                    <p class="black3 fs-6 lh-sm">
                                    <?php echo $postDetails[0]["content"]; ?>
                                    </p>                         
                                </div>
                                <div class="d-flex" id="material-download">
                                <?php 
                                        if($files != null){
                                            for($i = 0 ; $i < count($files); $i++){
                                                echo '<a href="https://drive.google.com/file/d/'.$files[$i]["google_drive_file_id"].'/view" target="_blank" class="btn bg-body-tertiary shadow-elevation-dark-1 rounded-4 me-2 pe-5">
                                                        <div class="d-flex">
                                                            <div class="me-2">
                                                                <i class="bi bi-file-earmark-text-fill green1 fs-2 p-0 m-0"></i>
                                                            </div>
                                                            <div>
                                                                 <span class="green2 fw-bold mb-0">' . htmlspecialchars($files[$i]['file_name'], ENT_QUOTES, 'UTF-8') . '</span>
                                                                <span class="fw-light green2 fs-6 d-flex mt-0" id="material-size">'. $files[$i]["file_size"] .'</span>
                                                            </div>
                                                        </div>
                                                    </a>';
                                            }
                                        }
                                    ?>
                                </div>
                                <div class="line2 mt-5"></div>
                                <div class="w-75 mt-4" id="material-comment-container">
                                    <div class="input-group mt-lg-2">
                                        <span class="input-group-text rounded-start-5 bg-white ps-3"><img src="<?php if(isset($_SESSION["profile"])){ echo "../profiles/".$_SESSION["profile"]; } else{ echo "../profiles/profile.png"; }  ?>" style="width: 35px;" class="rounded-5"></span>
                                        <textarea class="form-control py-3 black3 5 border-start-0 border-end-0 fs-6" id="commentArea" style="resize: none;" rows="1" aria-label="With textarea" placeholder="Leave a comment..."></textarea>
                                        <span class="input-group-text rounded-end-5 bg-white">                                        
                                            <a href="" class="align-items-end green1 fs-3 pe-2 comment-btn"><i class="bi bi-send-fill"></i></a>
                                        </span>
                                    </div>
                                </div>
                                <div class="ms-lg-3 mt-4">
                                        <?php 
                                        //    echo $comments[0]["name"];
                                        // if(isset($comments[0]["name"])){
                                        //     for($i = 0 ; $i < count($comments); $i++){
                                        //         $year = $comments[$i]["month"][0] . "" . $comments[$i]["month"][1] . $comments[$i]["month"][2] . "" . $comments[$i]["month"][3];
                                        //         $month = $months[$comments[$i]["month"][5] . "" . $comments[$i]["month"][6] - 1];
                                        //         $month = $month[0] . "" . $month[1] . "" . $month[2] ;
                                        //         $day = $comments[$i]["month"][8] . "" . $comments[$i]["month"][9];
                                                
                                        //         echo "<div class='d-flex align-items-start mb-3' id='comment-container'>
                                        //                 <div class='me-lg-3 d-flex align-items-center justify-content-center'>
                                        //                     <img src='{$comments[$i]['image']}' style='width: 35px;' class='rounded-5'></span>
                                        //                 </div>
    
                                        //                 <div class=''>
                                        //                 <div class='d-flex'>
                                        //                     <p class='green2 fw-semibold lh-sm m-0 p-0 ' id='comment-name'>{$comments[$i]["name"]}</p>
                                        //                     <p class='black3 fw-semibold lh-sm ms-2 m-0 p-0 fs-6' id='comment-date'>{$month} {$day}</p>                                              
                                        //                 </div>
    
                                        //                 <div class='m-0 p-'>
                                        //                     <p class='black2 m-0 p-0' id='comment'>{$comments[$i]["comment"]}</p>
                                        //                 </div>
                                        //                 </div>
                                        //             </div>";
                                        //     }
                                        // }   
                                        // ?>
                                        <div id="comments"></div>
                                </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <?php } else if($postDetails[0]["content_type"] == "Quiz"){ ?>
                    <div class="container-fluid mt-4 px-lg-5 px-sm-4">
                    <p id="post-id" hidden><?php echo $postDetails[0]["post_id"]; ?></p>
                    <div class="mt-2">
                        <div class="d-flex px-3">
                            <div id="icon-material">
                                <i class="bi bi-question-circle-fill green1 fs-1 p-0 m-0 me-3"></i>
                            </div>
                            <div class="w-100">
                                <div>
                                    <h1 class="h-font green1 me-2 sub-title mb-0" id="material-title"><?php echo $postDetails[0]["title"]; ?></h1>
                                    <p class="fw-light green2 fs-6 d-flex m-0" id="material-date"><?php echo $month . " ". $day . ", " . $year ?></p>   
                                </div>
                                <div class="mt-3" id="material-description">
                                    <p class="black3 fs-6 lh-sm">
                                    <?php echo $postDetails[0]["content"]; ?>
                                    </p>                         
                                </div>
                                
                                <div class="container-fluid p-0">
                                    <h1 class="h-font green2 me-2 sub-title mb-0" id="material-title">Your Work</h1>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-12">
                                            <a href='quiz-form.php?class=<?php echo md5($postDetails[0]["class_code"]); ?>&post=<?php echo md5($postDetails[0]['post_id']); ?>'>
                                                <div class="container-fluid green shadow-elevation-dark-1 rounded-3">
                                                    <div class="d-flex justify-content-center align-items-center p-2 py-3">
                                                        <span class="white2 fw-semibold mb-0">Take Quiz</span>
                                                    </div> 
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="container-fluid mt-2 m-0 p-0 table-responsive" id="table-container">
                                    <table id="classTable" class="table table-bordered text-center align-middle teble-responsive">
                                        <thead>
                                            <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Quiz</th>
                                            <th scope="col">Points</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">View</th>
                                        
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Quiz: Quiz 1 <br> Quiz: Sorting Algorithm</td>
                                                <td>Correct Answers: 49 <br> Total Points: 80 <br> Result: <span class="badge rounded-pill text-bg-success">Passed</span></td>
                                                <td><span class="badge rounded-pill text-bg-success">Finished</span></td>
                                                <td><a href="#" class="green2">View</a></td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Quiz: Quiz 1 <br> Quiz: Sorting Algorithm</td>
                                                <td>Correct Answers: 49 <br> Total Points: 80 <br> Result: <span class="badge rounded-pill text-bg-danger">Failed</span></td>
                                                <td><span class="badge rounded-pill text-bg-success">Finished</span></td>
                                                <td><a href="#" class="green2">View</a></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5">No record</td>
                                            </tr>
                                        </tbody>
                                    </table> 
                                </div>
                                <div class="line2 mt-5"></div>
                                <div class="w-75 mt-4" id="material-comment-container">
                                    <div class="input-group mt-lg-2">
                                        <span class="input-group-text rounded-start-5 bg-white ps-3"><img src="<?php if(isset($_SESSION["profile"])){ echo "../profiles/".$_SESSION["profile"]; } else{ echo "../profiles/profile.png"; }  ?>" style="width: 35px;" class="rounded-5"></span>
                                        <textarea class="form-control py-3 black3 5 border-start-0 border-end-0 fs-6" id="commentArea" style="resize: none;" rows="1" aria-label="With textarea" placeholder="Leave a comment..."></textarea>
                                        <span class="input-group-text rounded-end-5 bg-white">                                        
                                            <a href="" class="align-items-end green1 fs-3 pe-2 comment-btn"><i class="bi bi-send-fill"></i></a>
                                        </span>
                                    </div>
                                </div>
                                <div class="ms-lg-3 mt-4">

                                        <div id="comments"></div>
                                </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                    <?php }            
     
                    else {?>
                    <p id="post-id" hidden><?php echo $postDetails[0]["post_id"]; ?></p>

                <div class="container mt-4 px-lg-5 px-sm-2">
                    <div class="mt-2">
                        <div class="d-flex">
                            <div>
                                <i class="bi bi-bookmark-fill green1 fs-1 p-0 m-0 me-3"></i>
                            </div>
                            <div class="w-100">
                                <div class="row">
                                    <div class="col-lg-9">
                                        <div>
                                            <h1 class="h-font green1 me-2 sub-title mb-0" id="material-title"><?php echo $postDetails[0]["title"]; ?></h1>
                                            <p class="fw-light green2 fs-6 d-flex m-0" id="material-date"><?php echo $month . " ". $day . ", " . $year ?></p>   
                                        </div>
                                        <div class="mt-3" id="material-description">
                                            <p class="black3 fs-6 lh-sm">
                                            <?php echo $postDetails[0]["content"]; ?>
                                            </p>                         
                                        </div>
                                        <div class="d-flex">
                                        <?php 
                                        if($files != null){
                                                for($i = 0 ; $i < count($files); $i++){
                                                    echo '<a href="https://drive.google.com/file/d/'.$files[$i]["google_drive_file_id"].'/view" target="_blank" class="btn bg-body-tertiary shadow-elevation-dark-1 rounded-4 me-2 pe-5">
                                                            <div class="d-flex">
                                                                <div class="me-2">
                                                                    <i class="bi bi-file-earmark-text-fill green1 fs-2 p-0 m-0"></i>
                                                                </div>
                                                                <div>
                                                                    <span class="green2 fw-bold mb-0">' . htmlspecialchars($files[$i]['file_name'], ENT_QUOTES, 'UTF-8') . '</span>
                                                                    <span class="fw-light green2 fs-6 d-flex mt-0" id="material-size">'. $files[$i]["file_size"] .'</span>
                                                                </div>
                                                            </div>
                                                        </a>';
                                                }
                                            }
                                        ?>
                                        </div>
                                    </div>
                                    <?php if(isset($_SESSION["authorized"])) {?>
                                         
                                    <div class="col-lg-3 container-fluid bg-body-tertiary rounded-4 py-lg-3 px-lg-3">
                                        <form class="h-100" id="uploadForm">
                                            <div class="d-flex justify-content-between flex-column h-100">
                                                <div>
                                                    <p class="fw-semibold green2 fs-4 lh-sm">Your work<br>
                                                    <div id="fileContainer">
                                                        <?php if($submissions != null){ for($i = 0; $i < count($submissions); $i++){?>
                                                            <?php 
                                                            echo "<div class='fileCont'>
                                                              <a href='https://drive.google.com/file/d/{$submissions[$i]['google_drive_file_id']}/view' target='_blank'>
                                                                <div id='{$submissions[$i]['file_id']}'></div>
                                                                <div class='container-fluid bg-white white-btn rounded-3 p-1 shadow-elevation-dark-1 mb-2'>
                                                                    <div class='d-flex justify-content-start'>
                                                                        <div class='me-2 ms-2'>
                                                                            <i class='bi bi-file-earmark-text-fill green1 fs-2 p-0 m-0'></i>
                                                                        </div>
                                                                        <div>
                                                                            <span class='green2 fw-bold mb-0'>{$submissions[$i]["file_name"]}</span>
                                                                            <span class='fw-light green2 fs-6 d-flex mt-0' id='material-size'>{$submissions[$i]["file_size"]}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a></div>";
                                                            ?>
                                                        <?php } } ?>
                                                   </div>
                                                   <div class="new-file"></div>
                                                    <!-- <a href="#">
                                                        <div class="container-fluid bg-white white-btn rounded-3 p-1 shadow-elevation-dark-1 mb-2" id="file">
                                                            <div class="d-flex justify-content-start">
                                                                <div class="me-2 ms-2">
                                                                    <i class="bi bi-file-earmark-text-fill green1 fs-2 p-0 m-0"></i>
                                                                </div>
                                                                <div>
                                                                    <span class="green2 fw-bold mb-0">File1.jpeg</span>
                                                                    <span class="fw-light green2 fs-6 d-flex mt-0" id="material-size">253kb</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a> -->
                                                    <a href="" id="uploadLink">
                                                    <div class="container-fluid bg-white white-btn shadow-elevation-dark-1 rounded-3">
                                                        <div class="d-flex justify-content-start align-items-center text-center">
                                                            <div class="me-2">
                                                                <i class="bi bi-plus green1 fs-2 p-0 m-0"></i>
                                                            </div>
                                                            <div>
                                                                <span class="green2 fw-bold mb-0">Add or create</span>
                                                            </div>  
                                                        </div> 
                                                    </div>
                                                    </a>
                                                    <input type="file" id="fileInput" name="files[]" style="display: none;" multiple>

                                                </div>
                                                <div>
                                                    <a href="#" id="formSubmit">
                                                    <div class="container-fluid green shadow-elevation-dark-1 rounded-3">
                                                        <div class="d-flex justify-content-center align-items-center p-2">
                                                            <span class="white2 fw-semibold mb-0">Submit</span>
                                                        </div> 
                                                    </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <?php }else{ ?>       
                                    <div class="col-lg-3 container-fluid bg-body-tertiary rounded-4 py-lg-3 px-lg-3">
                                            <div class="d-flex justify-content-between flex-column h-100">
                                                <div>
                                                    <p class="fw-semibold green2 fs-4 lh-sm">Your work<br>
                                                    <div class="container-fluid btn shadow-elevation-dark-1 rounded-3">
                                                        <div class='alert alert-error' role='alert'>
                                                            <span>LOGIN TO GDRIVE TO UPLOAD FILES</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                 <a href="student backend/includes/auth.php">
                                                <div>
                                                    <div class="container-fluid green shadow-elevation-dark-1 rounded-3">
                                                        <div class="d-flex justify-content-center align-items-center p-2">
                                                            <span class="white2 fw-semibold mb-0">Login Google Drive</span>
                                                        </div> 
                                                    </div>
                                             
                                                </div>
                                                </a>
                                            </div>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="line2 mt-lg-3"></div>
                                <div class="w-75 mt-4" id="material-comment-container">

                                    <!-- FOR COMMENT -->
                                    <div class="input-group mt-lg-2">
                                        <span class="input-group-text rounded-start-5 bg-white ps-3"><img src="<?php if(isset($_SESSION["profile"])){ echo "../profiles/".$_SESSION["profile"]; } else{ echo "../profiles/profile.png"; }  ?>" style="width: 35px;" class="rounded-5"></span>
                                        <textarea class="form-control py-3 black3 5 border-start-0 border-end-0 fs-6" id="commentArea" style="resize: none;" rows="1" aria-label="With textarea" placeholder="Leave a comment..."></textarea>
                                        <span class="input-group-text rounded-end-5 bg-white">                                        
                                            <a href="" class="align-items-end green1 fs-3 pe-2 comment-btn"><i class="bi bi-send-fill"></i></a>
                                        </span>
                                    </div>
    

                                    <!-- DISPLAY COMMENTS -->
                                    <div class="ms-lg-3 mt-4">
                                 
                                        <div id="comments"></div>

                                    </div>
                                </div>
                                <div class="form-message"></div>

                            </div>
                        </div>
                       
                    </div>
                </div>
                <?php } ?>
            </div>

        </div>
    </div>
    <br><br><br>
    <br><br><br>
    <script src="https://eduportal-wgrc.onrender.com/socket.io/socket.io.min.js"></script>
    <script src="scripts/comment.js"></script>
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
