<?php

if (session_id() === "") session_start();

$_SESSION["storedFile"] = $_FILES['files'];
echo var_dump($_SESSION["storedFile"]);