<!-- <div class="sticky-top">
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
        <span class="toggle-btn" onclick="toggleSidebar()"><i class="bi bi-list fs-1 greenicon"></i></span>
            <a class="navbar-brand h-font me-5 ms-3 fw-bold fs-3" href="#"><img src="images/combined-fixed.png" class="logo" alt="logo"></a>
            <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="ms-auto d-flex">
                    <div class="dropdown dropstart">
                        <button class="btn green dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"  style="background-color: transparent; border: none;">
                            <i class="bi bi-person-circle fs-1 icon"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item h-font" href="#">Profile</a></li>
                            <li><a class="dropdown-item h-font" href="#">Settings</a></li>
                            <li><a class="dropdown-item h-font" href="#">Log Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    </div>


<div class="col-lg-3 sidebar shadow-sm" id="sidebar">
    <nav class="navbar navbar-expand-lg">
        <ul>
            <li class="mt-3 green"><a href="#"><i class="bi bi-house-door-fill me-2 greenicon"></i>Home</a></li>
            <li class="green"><a href="calendar.php"><i class="bi bi-calendar-week me-2 greenicon"></i>Calendar</a></li>
            
        </ul>
        <div class="line mx-3"></div>
        
        <div class="accordion accordion-flush mt-3" id="accordionFlushExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                    <span><i class="bi bi-mortarboard-fill me-2 greenicon"></i>Enrolled</span>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the first item's accordion body.</div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                    Accordion Item #2
                </button>
                </h2>
                <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the second item's accordion body. Let's imagine this being filled with some actual content.</div>
                </div>
            </div>
            
        </div>
</nav>
</div> -->
<?php
// Get the current file name
$current_page = basename($_SERVER['PHP_SELF']);
?>
<div class="container-fluid greenbg vh-100 justify-content-center align-items-center flex-column gap-3" data-mdb-animation-init data-mdb-animation-reset="true" data-mdb-animation="slide-out-down" id="mobile_directory">
    <a href="student-dashboard.php" class="fs-3 white1"><i class="bi bi-house-door-fill me-2 white1"></i>Home</a>
    <a href="calendar.php" class="fs-3 white1"><i class="bi bi-calendar-week me-2 white1"></i>Calendar</a>
    <a href="student-dashboard.php" class="fs-3 white1"><i class="bi bi-mortarboard-fill me-2 white1"></i>Enrolled</a>
    <a href="profile.php" class="fs-3 white1"><i class="me-2 bi bi-person-circle white1"></i>Profile</a>
    <a onclick="toggleSidebar()" class="fs-3 white1">Back</a>
</div>

<div class="container-fluid sticky-top d-flex align-items-center bg-white justify-content-between line p-2">

    <div class="d-flex align-items-center">
        <span class="toggle-btn" id="toggleBtn" onclick="toggleSidebar()"><i class="bi bi-list fs-1 greentoggle"></i></span>
        <a class="navbar-brand ms-3" href="student-dashboard.php"><img src="images/combined-fixed.png" class="logo" alt="logo"></a>
    </div>

    <div class="d-flex align-items-center">
        <?php 
         if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            $url = "https";
            } else {
            $url = "http";
            }
        
            $url .= "://";
            $url .= $_SERVER['HTTP_HOST'];
            $url .= $_SERVER['REQUEST_URI'];
            if($url == "https://cs-devops.com/EduPortal/student/student-dashboard.php"){
        ?>
        
        <button type="button" class="btn bg-transparent p-0 m-0" data-bs-toggle="modal" data-bs-target="#joinClassModal">
            <i class="bi bi-plus-lg icon fs-3 me-2 d-md-inline d-sm-block"></i>
            <!-- <i class="bi bi-plus-lg icon fs-1 me-2"></i> -->
        </button>

        <?php } ?>
        <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <!-- <i class="me-2 bi bi-person-circle fs-1 icon"></i> -->
            <img src="<?php if(isset($_SESSION["profile"])){ echo "../profiles/".$_SESSION["profile"]; } else{ echo "../profiles/profile.png"; }  ?>" style="width: 40px;" class="me-2 bi me-2 rounded pill" id="smolImg"></span> 
            </a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item h-font green1 fs-4" href="profile.php">Profile</a></li>
            <li><a class="dropdown-item h-font green1 fs-4" href="grades.php">Grades</a></li>
            <li><a class="dropdown-item h-font green1 fs-4" href="student backend/includes/logout.inc.php">Log Out</a></li>
        </ul>
    </div>
</div>

<!-- Join Class Modal -->

<div class="modal fade" id="joinClassModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="joinClassLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container-fluid mb-3 d-flex justify-content-between align-items-center">
                    <h1 class="modal-title fs-2 h-font ms-3 green1" id="staticBackdropLabel">Join Class</h1>
                    <button type="button" class="btn-close" id="close_code" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="includes/join-class.php" method="post" id="joinClassForm">
                    <div class="row d-flex justify-content-center">
                        <div class="col-10">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Enter Class Code..." name="classCode" id="class_code" required>
                            </div>
                        </div>
                        <div class="col-auto">
                            <button type="submit" name="joinClassBtn" class="btn btn-primary green shadow-none rounded-5 px-5" id="join_class_btn">Join</button>
                        </div>
                    </div>
                    <div class="join-class-msg"></div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="col-lg-2 shadow-sm h-100" id="sidebar-menu">
    <ul>
        <a href="student-dashboard.php" class="fs-3 h-font"><li class="mt-3 <?php echo ($current_page == 'student-dashboard.php') ? 'activesidebar' : ''; ?>"><i class="bi bi-house-door-fill ms-3 me-2 greenicon"></i>Home</li></a>
        <a href="profile.php" class="fs-3 h-font"><li class="<?php echo ($current_page == 'profile.php') ? 'activesidebar' : ''; ?>"><i class="bi bi-person-circle ms-3 me-2 greenicon"></i>Profile</li></a>
        <a href="calendar.php" class="fs-3 h-font"><li class="<?php echo ($current_page == 'calendar.php') ? 'activesidebar' : ''; ?>"><i class="bi bi-calendar-week ms-3 me-2 greenicon"></i>Calendar</li></a>
    </ul>

    <div class="line container-fluid">
    </div>

    <div class="accordion accordion-flush mt-3 scrollable-accordion" id="accordionFlushExample">
        <div class="accordion-item">
            <h2 class="accordion-header <?php echo ($current_page == 'class.php' || $current_page == 'list.php' || $current_page == 'submittedworks.php' || $current_page == 'material.php' || $current_page == 'grades.php') ? 'activesidebar' : ''; ?>">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                    <div id="folder"><i class="bi bi-mortarboard-fill me-2 greenicon h-font"></i>Enrolled</div>
            </h2>

            <div id="flush-collapseOne" class="accordion-collapse collapse p-lg-3 scrollable-collapse" data-bs-parent="#accordionFlushExample1" style="overflow-y: auto !important; max-height: 60vh;">
                <?php include("student backend/includes/side-classes.php");?>
                
                <?php 
                    for($i = 0 ; $i < count($classList); $i++){
                        echo "<div class='class'>";
                        ?>
                            <a href='class.php?class=<?php echo md5($classList[$i]['class_code']);?>' class='fs-5 py-lg-1 text-truncate d-inline-block' style='max-width: 100%;'>
                        <?php
                            echo"<i class='ms-3 bi bi-book me-2 greenicon'></i>{$classList[$i]['class_name']}
                            </a>
                        </div>";
                    }
                ?>
                   <br><br>
                
            </div>
        </div>
    </div>
</div>