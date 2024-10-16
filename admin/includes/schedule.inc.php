<?php
if (session_id() === "") session_start();

if (isset($_POST['increaseBtn'])) {
   $_SESSION['seconds'] += 5;

   if ($_SESSION['seconds'] < 10) {
      $_SESSION['seconds'] = $_SESSION['seconds'];
   }

   if ($_SESSION['seconds'] >= 60) {
      $_SESSION['seconds'] = 0;
   }
}

if (isset($_POST['decreaseBtn'])) {
   $_SESSION['seconds'] -= 5;
   if ($_SESSION['seconds'] <= 0) $_SESSION['seconds'] = 0;
}

if (isset($_POST['resetBtn'])) {
   $_SESSION['seconds'] = 0;
}
