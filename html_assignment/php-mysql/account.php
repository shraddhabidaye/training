<?php require_once("config.php");

  $email = $_SESSION["login_email"];
  $query = "SELECT * FROM users WHERE email = '$email'";

  $findresult =  $conn->query($query);
    $numRows = mysqli_num_rows($findresult);


    if($res = mysqli_fetch_array($findresult))
     {
      $fname = $res['first_name'];

      $lname = $res['last_name'];
      $contact = $res['mobile_no'];
      $email = $res['email'];
      $password = $res['password'];
    }
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
        <div class="col-sm-3">
        </div>
        <div class="col-sm-6">
     <form action="login_process.php" method="POST">
  <div class="login_form">

     <p><a href="logout.php"><span style="color:red; float: right;">Logout</span> </a></p>
      <p><a href="edit.php"><span style="color:blue; float: right;margin:0px 15px;">Edit</span> </a></p>
          <p> Welcome! <span style="color:#33CC00"><?php echo $email; ?></span> </p>
          <table class="table">
          <tr>
              <th>First Name </th>
              <td><?php echo $fname; ?></td>
          </tr>
          <tr>
              <th>Last Name </th>
              <td><?php echo $lname; ?></td>
          </tr>
          <tr>
              <th>Contact no. </th>
              <td><?php echo $contact; ?></td>
          </tr>
           <tr>
              <th>Email </th>
              <td><?php echo $email; ?></td>
          </tr>
          <tr>
             <th>Password </th>
             <td><?php echo $password; ?></td>
         </tr>
          </table>
        </div>
        <div class="col-sm-3">
        </div>
    </div>
</div>
</body>
</html>
