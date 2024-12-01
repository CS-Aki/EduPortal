<?php   
    require_once("../classes/connection.php");
    require_once("../classes/model.User.php");
    require_once("../classes/controller.Login.php");

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(isset($_POST["loginBtn"])){
        $email = $_POST["email"];
        $password = $_POST["password"];

    //  echo "<div class='alert alert-danger' role='alert'>";
    //  echo "<span>{$email}, {$password}</span>";
    //  echo "</div>";

      $loginController = new LoginController($email, $password);
      $loginController->loginUser();
      $_SESSION['unset'] = "test";
      session_regenerate_id();
      $session = session_id();
      $_SESSION["temp"] = $session;
    //   $loginController->sendSession($email, $session);
    }
}
    
?>