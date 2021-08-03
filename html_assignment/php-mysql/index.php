<?php require_once("config.php"); ?>
<html>
    <head>
      <title>
        user login
      </title>
      <link rel="stylesheet" href="login.css">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    </head>
    <body>
     <form method="post" action="login_p.php" style="max-width:500px;margin:auto">
      <h2>Login Form</h2>


      <div class="input-container">
        <i class="fa fa-envelope icon"></i>
        <input class="input-field" type="text" placeholder="Email" name="email">
      </div>

      <div class="input-container">
        <i class="fa fa-key icon"></i>
        <input class="input-field" type="password" placeholder="Password" name="psw">
      </div>

      <button type="submit" class="btn" name="login_btn">Login</button>
      <div class="container signin">
       <p> Don't have an account?</p>
       <button  style="width:auto;"><a href="register.php">Sign Up</a></button>

      </div>
    </form>
  </body>
</html>
