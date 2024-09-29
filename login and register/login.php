<?php
    require_once("classes/connection.php");
    require_once("classes/model.User.php");
    require_once("classes/controller.Login.php");
    require_once("classes/view.User.php");
    require_once("includes/login.inc.php");
    require_once("includes/register.inc.php");
    if(session_id() === "") session_start();
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

 .content .google-login-btn {
  display: flex;
  align-items: center;
  text-decoration: none;
  font-size: 14px;
  font-weight: 500;
  color: #fff;
  width: 100%;
  overflow: hidden;
  border-radius: 5px;
  background-color: #d6523e;
  cursor: pointer;
}
.content .google-login-btn .icon {
  display: inline-flex;
  height: 100%;
  padding: 15px 20px;
  align-items: center;
  justify-content: center;
  background-color: #cf412c;
  margin-right: 15px;
}
.content .google-login-btn .icon svg {
  fill: #fff;
}
.content .google-login-btn:hover {
  background-color: #d44a36;
}
.content .google-login-btn:hover .icon {
  background-color: #c63f2a;
}

</style>
<body>

    <div class="container">
    <div class="table-responsive">
    <h3 align="center">EduPortal Login</h3>
      <div class="box">

        <form action="login.php" method="POST">
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
            <div class="form-group">
            <label for="error"><?php if(isset($_SESSION["msg"])) {
                                          echo $_SESSION["msg"];
                                          unset($_SESSION["msg"]);
             }

            ?></label>
            </div>
            <a href="google-oauth.php" class="google-login-btn">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 488 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z"/></svg>
                </span>
                Login with Google
            </a>
        </form>

    </div>
   </div>
   </div>

</body>
</html>
