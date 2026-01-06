<?php 
    $db_server = "localhost";
    $db_user = "u227551606_classroom_user";
    $db_password ="Eduportal052898";
    $db_name = "u227551606_classroom_db";

    try{
        $conn = mysqli_connect($db_server, $db_user, $db_password, $db_name);
    }catch(mysqli_sql_exception){
        echo "Cannot connect";
    }
?>