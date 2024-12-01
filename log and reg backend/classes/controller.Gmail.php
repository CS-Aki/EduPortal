<?php
require_once("connection.php");
require_once("model.User.php");

class GmailController extends User{
    private $email;
    private $name;
    function __construct($email, $name){
      $this->name = $this->rearrangedName($name);
      $this->email = $email;
    }

    public function isRegistered(){
       $_SESSION['google_name'] = $this->name;
       return $this->isUserRegistered($this->name, $this->email);
    }

    public function getDetails(){
      return $this->email;
    }

    public function getAddress(){
        return $this->fetchAddress($this->name, $this->email);
    }

    private function rearrangedName($name){
       $newName = "";
       for($i = 0; $i < strlen($name); $i++){
         if($i == 0){
           $newName .= $name[$i];
           continue;
         }
         if (ctype_upper($name[$i])) {
            $newName .= " {$name[$i]}";
         } else {
            $newName .= $name[$i];
         }
       }
       return $newName;
    }

    public function getId(){
       $id = $this->getUserId($_SESSION['google_email'] ,$_SESSION['google_name']);
       return $id;
    }

    public function getCategory(){
        $category = $this->getUserCategory($_SESSION['google_email'] ,$_SESSION['google_name']);
        return $category;
    }

    

    // public function sendSession($email, $session){
    //   $this->insertSession($email, $session);
    // }
    
}
