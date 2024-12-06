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

    <?php require('inc/links.php');  //include("student backend/includes/view-profile.php"); ?>
</head>
<body>
    <?php require('inc/header.php'); ?>

    <div class="container-fluid p-0 m-0" id="main-content">
        <div class="row">
            <div class="col-lg-10 col-sm-12 ms-auto ">
                <div class="container px-lg-5 px-sm-2 d-flex align-items-center justify-content-center">
                    <div class="rounded-5 bg-body-tertiary w-100 mt-5 px-4 py-4">
                        <div class="p-3 d-flex align-content-center">
                            <div>
                                 <!-- <i class='me-2 bi bi-person-circle fs-1 icon' style="font-size: 3rem;"></i> -->
                                <img src="<?php if(isset($_SESSION["profile"])){ echo "../profiles/".$_SESSION["profile"]; } else{ echo "../profiles/profile.png"; }  ?>" id="imageProfile" style="width: 160px;" class="rounded-pill">
                            </div>
                            <div class="ms-4">
                                <h2 class="h-font green1 me-2 title mb-0 pb-0"><?php if(isset($_SESSION["name"])) echo $_SESSION["name"];?></h2>
                                <p class="lh-base fw-semibold black3 fs-5 pt-0 mt-0 mb-2">
                                    Professor
                                </p>
                                <form enctype="multipart/form-data" id="changeProfileForm">
                                    <input type="file" id="file" style="display: none;" name="file">
                                    <button type="submit" name="changeBtn" id="changeProfileBtn" class="btn green shadow-none me-lg-2 me-3 rounded-5 px-4 fs-5 fw-light mt-0">
                                        <i class="bi bi-pencil-square white2 me-2"></i>Change Profile
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div>
                            <div class="row">
                                <div class="col-lg-8 mt-2">
                                    <label class="form-label black2 mb-0 ps-2">Name:</label>
                                    <input type="text" class="form-control black3 fs-5 shadow-elevation-dark-1 rounded-5 py-2 px-3" placeholder="<?php if(isset($_SESSION["name"])) echo $_SESSION["name"];?>" name="first_name" id="first_name_inp" readonly>
                                </div>
                                <div class="col-lg-2 mt-2">
                                    <label class="form-label black2 mb-0 ps-2">Date of Birth:</label>
                                    <input type="text" class="form-control black3 fs-5 shadow-elevation-dark-1 rounded-5 py-2 px-3" placeholder="08-24-04" name="first_name" id="first_name_inp" readonly>
                                </div>
                                <div class="col-lg-2 mt-2">
                                    <label class="form-label black2 mb-0 ps-2">Sex:</label>
                                    <input type="text" class="form-control black3 fs-5 shadow-elevation-dark-1 rounded-5 py-2 px-3" placeholder="Female" name="first_name" id="first_name_inp" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mt-2">
                                    <label class="form-label black2 mb-0 ps-2">Email:</label>
                                    <input type="text" class="form-control black3 fs-5 shadow-elevation-dark-1 rounded-5 py-2 px-3" placeholder="<?php if(isset($_SESSION["email"])) echo $_SESSION["email"];?>" name="first_name" id="first_name_inp" readonly>
                                </div>
                                <div class="col-lg-6 mt-2">
                                    <label class="form-label black2 mb-0 ps-2">Instructor Code:</label>
                                    <input type="text" class="form-control black3 fs-5 shadow-elevation-dark-1 rounded-5 py-2 px-3" rows="3" placeholder="********" name="first_name" id="first_name_inp" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mt-2">
                                    <label class="form-label black2 mb-0 ps-2">Address:</label>
                                    <textarea class="form-control py-3 black3 5 rounded-4 container-fluid shadow-elevation-dark-1" resize: none; rows="2" aria-label="With textarea" placeholder="<?php if(isset($_SESSION["address"])) echo $_SESSION["address"]; else echo "test";?>"></textarea>
                                </div>
                            </div>
                            <div class="mt-3 text-end">
                                <button class="btn green shadow-none me-lg-2 me-3 rounded-5 px-5 fs-5 fw-bold mt-0">Save</button>
                            </div>
                        </div>
                    </div>
                </div>

                
            </div>
        </div>
    </div>
    <br><br><br>
    <br><br><br>

    <script src="scripts/change-profile.js">      

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
