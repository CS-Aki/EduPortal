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

<div class="container-fluid sticky-top d-flex align-items-center  justify-content-between line p-2 z-3" style="background-color: white;">

        <div class="d-flex align-items-center">
            <span class="toggle-btn" onclick="toggleSidebar()"><i class="bi bi-list fs-1 greentoggle"></i></span>
            <a class="navbar-brand ms-3" href="admin-dashboard.php"><img src="images/combined-fixed.png" class="logo" alt="logo"></a>
        </div>

        <div class="d-flex align-items-center">
        <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="me-2 bi bi-person-circle fs-1 icon"></i>
        </a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item h-font green1 fs-4" href="profile.php">Profile</a></li>
            <li><a class="dropdown-item h-font green1 fs-4" href="#">Settings</a></li>
            <li><a class="dropdown-item h-font green1 fs-4" href="includes/logout.inc.php">Log Out</a></li>
        </ul>
        </div>
</div>

<!-- Join Class Modal REMOVED-->

<div class="col-lg-2 shadow-sm" id="sidebar-menu">
    <ul>
        <a href="admin-dashboard.php" class="fs-3 h-font"><li class="mt-3"><i class="bi bi-house-door-fill ms-3 me-2 greenicon"></i>Home</li></a>
        <a href="calendar.php" class="fs-3 h-font"><li class=""><i class="bi bi-calendar-week ms-3 me-2 greenicon"></i>Calendar</li></a>
    </ul>

    <div class="line container-fluid"></div>
    <ul class="my-2">
    <a href="classes.php" class="fs-3 h-font"><li class=""><i class="bi bi-mortarboard-fill ms-3 me-2 greenicon"></i>Classes</li></a>
    </ul>
    <div class="line container-fluid"></div>

    <ul>
        <a href="instructor_records.php" class="fs-3 h-font"><li class="mt-3"><i class="bi bi-card-checklist ms-3 me-2 greenicon"></i>Records</li></a>
        <a href="calendar.php" class="fs-3 h-font"><li class=""><i class="bi bi-gear-fill ms-3 me-2 greenicon"></i>Settings</li></a>
    </ul>
</div>
