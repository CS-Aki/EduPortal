<?php
    require_once("classes/connection.php");
    require_once("classes/model.User.php");
    require_once("classes/controller.Register.php");
    require_once("classes/view.User.php");
    require_once("includes/login.inc.php");
    require_once("includes/register.inc.php");
?>

<html>
<head>
    <title>Login Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
</head>

<style>

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
    <h3 align="center">EduPortal Login</h3>
      <div class="box">

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" placeholder="Enter Email" class="form-control" />
            </div>
            <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Enter Password" class="form-control"/>
            </div>
            <div class="form-group">
            <input type="submit"  name="loginBtn" value="Login" class="btn btn-success form-control"/> <br><br>
            <input type="submit" name="registerBtn" value="Register" class="btn btn-success form-control"/>
            <hr>
            </div>
        </form>

    </div>
   </div>
   </div>

</body>
</html>
