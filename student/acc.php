<?php 
if (session_id() === "") session_start();
session_regenerate_id(true);
// echo "Session " . session_id();
$email = "";
$name = "";
$ses = "";
$userId = "";
$google_loggedin = $_SESSION['google_loggedin'];
$google_email = $_SESSION['google_email'];
$google_name = $_SESSION['google_name'];
$id = $_SESSION["user_id"];

if(!isset($_SESSION["test"])){
    $_SESSION["test"] = session_id();
    $_SESSION["email"] = $google_email;
    $_SESSION["name"] = $google_name;
    $_SESSION["id"] = $id;
}

if($email == ""){
    $userId = $_SESSION["id"];
    $ses = session_id();
    $name =  $_SESSION["name"];
    $email = $_SESSION["email"];
}else{
    session_destroy();
    session_name("student_session");
    session_start();
}

// session_write_close();
// session_name("test");

// echo "This is the email ".  $name . " <br>";

// echo "This is the name ". $email . " <br>";

// echo "This is the user id ". $userId . " <br>";

// // echo  $_SESSION['user_id'];
// echo $google_email . "<br>" .  $google_name . "<br>";
// echo $_SESSION['user_id'];
