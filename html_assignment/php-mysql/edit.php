<?php require_once("config.php");
$email = $_SESSION["login_email"];
$query = "SELECT * FROM users WHERE email = '$email'";

?>
<html>
<head>
    <title> My Account</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <div class="row">

        <div class="col-sm-6">
     <form  method="post" action="edit_p.php">
       <div class="col-sm-3">
       </div>
  <div class="login_form">
    <div class="col-sm-3">
    </div>

      <button type="submit" name="up_user" style=" float: right"><span style="color:blue; float: right;margin:0px 15px;">Update</span></button>
          <p><span style="color:#33CC00"><?php echo $email; ?></span> <br>
              You can edit here
           </p>
          <table class="table">
          <tr>
              <th>First Name </th>
              <td><input type="text" placeholder="first name" name="name1"></td>

          </tr>
          <tr>
              <th>Last Name </th>
              <td><input type="text" placeholder="first name" name="name2"></td>

          </tr>
          <tr>
              <th>Contact No. </th>
              <td><input type="number" placeholder="first name" name="num1"></td>

          </tr>


          </table>
        </div>
        <div class="col-sm-3">
        </div>
    </div>
</div>
</body>
</html>
