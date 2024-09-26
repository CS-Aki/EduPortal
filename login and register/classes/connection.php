<?php 
    // $db_server = "localhost";
    // $db_user = "root";
    // $db_password = "";
    // $db_name = "classroom_db";

    // try{
    //     $conn = mysqli_connect($db_server, $db_user, $db_password, $db_name);
    // }catch(mysqli_sql_exception){
    //     echo "Cannot connect";
    // }

class DbConnection{
    private $db_server = "localhost";
    private $db_user = "root";
    private $db_password = "";
    private $db_name = "classroom_db";

    protected function connect(){
        $dsn = 'mysql:host=' . $this->db_server . ';dbname='. $this->db_name;
        $pdo = new PDO($dsn, $this->db_user, $this->db_password);
        $pdo->setAttribute(PDO:: ATTR_DEFAULT_FETCH_MODE, PDO:: FETCH_ASSOC);
        return $pdo;
    }
}
