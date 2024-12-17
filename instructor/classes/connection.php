<?php 

class DbConnection{
    private $db_server = "localhost";
    private $db_user = "u227551606_classroom_user";
    private $db_password = "Eduportal052898";
    private $db_name = "u227551606_classroom_db";
    protected function connect(){
        $dsn = 'mysql:host=' . $this->db_server . ';dbname='. $this->db_name;
        $pdo = new PDO($dsn, $this->db_user, $this->db_password);
        $pdo->setAttribute(PDO:: ATTR_DEFAULT_FETCH_MODE, PDO:: FETCH_ASSOC);
        $pdo->exec("SET time_zone = '+08:00'");

        return $pdo;
    }
}
