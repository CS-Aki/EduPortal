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
    <a href="staff-dashboard.php" class="fs-3 white1"><i class="bi bi-house-door-fill me-2 white1"></i>Home</a>
    <a href="calendar.php" class="fs-3 white1"><i class="bi bi-calendar-week me-2 white1"></i>Calendar</a>
    <a href="classes.php" class="fs-3 white1"><i class="bi bi-mortarboard-fill me-2 white1"></i>Classes</a>
    <a href="instructor_records.php" class="fs-3 white1"><i class="bi bi-card-checklist me-2 white1"></i>Records</a>
    <a href="profile.php" class="fs-3 white1"><i class="me-2 bi bi-person-circle white1"></i>Profile</a>
    <a onclick="toggleSidebar()" class="fs-3 white1">Back</a>
</div>

<div class="container-fluid sticky-top d-flex align-items-center  justify-content-between line p-2 z-3" style="background-color: white;">

        <div class="d-flex align-items-center">
            <span class="toggle-btn" id="toggleBtn" onclick="toggleSidebar()"><i class="bi bi-list fs-1 greentoggle"></i></span>
            <a class="navbar-brand ms-3" href="staff-dashboard.php"><img src="images/combined-fixed.png" class="logo" alt="logo"></a>
        </div>

        <div class="d-flex align-items-center">
        <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="me-2 bi bi-person-circle fs-1 icon"></i>
        </a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item h-font green1 fs-4" href="profile.php">Profile</a></li>
            <li><a class="dropdown-item h-font green1 fs-4" href="includes/logout.inc.php">Log Out</a></li>
        </ul>
        </div>
</div>

<!-- Join Class Modal REMOVED-->

<div class="col-lg-2 shadow-sm" id="sidebar-menu">
    <ul>
        <a href="staff-dashboard.php" class="fs-3 h-font"><li class="mt-3 <?php echo ($current_page == 'staff-dashboard.php') ? 'activesidebar' : ''; ?>"><i class="bi bi-house-door-fill ms-3 me-2 greenicon"></i>Home</li></a>
        <a href="profile.php" class="fs-3 h-font"><li class="<?php echo ($current_page == 'profile.php') ? 'activesidebar' : ''; ?>"><i class="bi bi-person-circle ms-3 me-2 greenicon"></i>Profile</li></a>
        <!-- <a href="calendar.php" class="fs-3 h-font"><li class="<?php echo ($current_page == 'calendar.php') ? 'activesidebar' : ''; ?>"><i class="bi bi-calendar-week ms-3 me-2 greenicon"></i>Calendar</li></a> -->
    </ul>

    <div class="line container-fluid"></div>
    <ul class="my-2">
    <a href="classes.php" class="fs-3 h-font"><li class="<?php echo ($current_page == 'classes.php') ? 'activesidebar' : ''; ?>"><i class="bi bi-mortarboard-fill ms-3 me-2 greenicon"></i>Classes</li></a>
    </ul>
    <div class="line container-fluid"></div>

    <ul>
        <a href="instructor_records.php" class="fs-3 h-font"><li class="mt-3 <?php echo ($current_page == 'instructor_records.php' || $current_page == 'staff_records.php' || $current_page == 'student_records.php') ? 'activesidebar' : ''; ?>"><i class="bi bi-card-checklist ms-3 me-2 greenicon"></i>Records</li></a>
    </ul>
</div>