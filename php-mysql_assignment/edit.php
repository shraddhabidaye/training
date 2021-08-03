<?php
  require_once("config.php");
  $email = $_SESSION["login_email"];
  $query = "SELECT * FROM users WHERE email = '$email'";
  $findresult =  $conn->query($query);
  $numRows = mysqli_num_rows($findresult);

  if($res = mysqli_fetch_array($findresult))
     {
        $fname = $res['first_name'];
        $lname = $res['last_name'];
        $contact = $res['mobile_no'];

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
        <form  method="post" action="edit_backend.php">
          <div style="margin-top:+30%;width:+200%">
            <button type="submit" name="up_user" style=" float: right">
              <span style="color:blue; float: right;margin:0px 15px;">Update</span>
            </button>
            <button type="button" style=" float: right">
              <span style="color:red; float: right;margin:0px 15px;">
                <a href="account.php" style="color:red">Back</a>
              </span>
            </button>
            <p>
              <span style="color:#33CC00">
                <?php echo $email; ?>
              </span>
              <br>
              You can edit here
            </p>
            <table class="table">
              <tr>
                <th>First Name </th>
                <td><input type="text" name="name1" value="<?php echo $fname; ?>"></td>
              </tr>
              <tr>
                <th>Last Name </th>
                <td><input type="text" name="name2" value="<?php echo $lname; ?>"></td>
              </tr>
              <tr>
                <th>Contact No. </th>
                <td><input type="number" name="num1" value="<?php echo $contact; ?>"></td>
              </tr>
            </table>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>
