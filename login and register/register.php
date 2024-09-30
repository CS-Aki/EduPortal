<?php

  require_once("classes/connection.php");
  require_once("classes/model.User.php");
  require_once("classes/controller.Register.php");
  require_once("classes/view.User.php");
  require_once("includes/register.inc.php");
  if(session_id() === "")session_start();
?>

<html>
<head>
    <title>Login Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
</head>

<style>
* {
  box-sizing: border-box;
  font-family: system-ui, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
  font-size: 16px;
}
body {
  background-color: #ca6454;
  margin: 0;
}
 .box
 {
  width:100%;
  max-width:400px;
  background-color:#f9f9f9;
  border:1px solid #ccc;
  border-radius:5px;
  padding:16px;
  margin:0 auto;
 }

</style>
<body>

    <div class="container">
    <div class="table-responsive">
    <h3 align="center">EduPortal Registration</h3>
      <div class="box">
        <?php
           if(isset($_SESSION['passwordOnly'])){
             
        ?>
        <form action="register.php" method="POST">
        <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="<?php $name = $_SESSION['google_name']; echo $name; ?>" class="form-control" readonly="readonly"/>
        </div>
        <div class="form-group">
        <label for="email">Email</label>
        <input type="text" name="email" id="email" value="<?php $email = $_SESSION['google_email']; echo $email; ?>" class="form-control" readonly="readonly"/>
        </div>
        <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="pwd" placeholder="Enter Password" class="form-control"/>
        </div>
        <div class="form-group">
        <label for="repeat_password">Repeat Password</label>
        <input type="password" name="repeatPass" id="repeatPass" placeholder="Repeat Password" class="form-control"/>
        </div>
        <div class="form-group">
        <input type="submit"  name="regBtn" value="Submit Registration" class="btn btn-success form-control"/><br>
        <div class="form-group">
          <label for="msg">
            <?php if(isset($_SESSION["msg"])) {
                                          echo $_SESSION["msg"];
                                          unset($_SESSION["msg"]);
            }
            ?>
          </label>
        </div>
        <input type="submit"  name="backBtn" value="Back to Login" class="btn btn-success form-control"/> <br><br>
        <hr>
      </form>
       <?php
            }
        else{

       ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" placeholder="Enter Full Name" class="form-control" />
            </div>
            <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" placeholder="Enter Email" class="form-control" />
            </div>
            <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="pwd" placeholder="Enter Password" class="form-control"/>
            </div>
            <div class="form-group">
            <label for="repeat_password">Repeat Password</label>
            <input type="password" name="repeatPass" id="repeatPass" placeholder="Repeat Password" class="form-control"/>
            </div>
            <div class="form-group">
            <input type="submit"  name="regBtn" value="Submit Registration" class="btn btn-success form-control"/> <br><br>
            <input type="submit"  name="backBtn" value="Back to Login" class="btn btn-success form-control"/> <br><br>
            <hr>
            </div>
            <div class="form-group">
              <label for="msg">
                <?php if(isset($_SESSION["msg"])) {
                                              echo $_SESSION["msg"];
                                              unset($_SESSION["msg"]);
                }
                ?>
              </label>
            </div>
        </form>
      <?php } ?>
    </div>
   </div>
   </div>

</body>
</html>
