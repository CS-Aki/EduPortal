<?php

if (session_id() === "") session_start();

unset($_SESSION["givenName"]);
unset($_SESSION["familyName"]);
unset($_SESSION["google_email"]);
unset($_SESSION["google_name"]);
unset($_SESSION['google_loggedin']);
unset($_SESSION['google_picture']);
