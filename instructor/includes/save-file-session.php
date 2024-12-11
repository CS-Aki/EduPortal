<?php

if (session_id() === "") session_start();

$_SESSION["storedFile"] = $_FILES['files'];
// echo "\n\nINSIDE\n\n";
echo var_dump($_SESSION["storedFile"]);