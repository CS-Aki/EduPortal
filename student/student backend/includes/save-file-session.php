<?php

if (session_id() === "") session_start();

$_SESSION["storedFile"] = $_FILES['files'];
$_SESSION["deadline"] = $_POST["deadline"];
echo var_dump($_SESSION["storedFile"]);