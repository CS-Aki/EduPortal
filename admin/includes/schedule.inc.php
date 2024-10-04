<?php
if(session_id() === "") session_start();

if(isset($_POST['increaseBtn'])) {
   $_SESSION['timer'] += 5;
   if($_SESSION['timer'] >= 60) $_SESSION['timer'] = 60;
}

if(isset($_POST['decreaseBtn'])) {
   $_SESSION['timer'] -= 5;
   if($_SESSION['timer'] <= 0) $_SESSION['timer'] = 0;
}

if(isset($_POST['resetBtn'])) {
   $_SESSION['timer'] = 0;
}
