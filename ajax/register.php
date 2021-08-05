
<html>
  <head>
    <title>register</title>
    <link rel="stylesheet" href="login.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  </head>
  <body>

	<div class="alert alert-success alert-dismissible" id="success" style="display:none;">
	  <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
	</div>
    <div>
      <form method="post" id="form">
        <div class="container">
          <div class="container1">
            <h1>Sign Up</h1>
            <p>Please fill in this form to create an account.</p>
            <hr>
            <label for="first_name"><b>First Name:</b></label>
            <input type="text" placeholder="first name" id="name1" required>

            <label for="last_name"><b>Last Name:</b></label>
            <input type="text" placeholder="last name" id="name2" required>

            <label for="mobile"><b>Contact No.:</b></label>
            <input type="number" placeholder="contact no." id="num1" required>

            <label for="email"><b>Email</b></label>
            <input type="email" placeholder="Enter Email" id="email" required>

            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" id="psw" required>

            <label for="psw-repeat"><b>Repeat Password</b></label>
            <input type="password" placeholder="Repeat Password" id="psw-repeat" required>

            <div class="clearfix">
              <button type="submit" class="signupbtn" id="reg_user">Sign Up</button>
            </div>
          </div>
        </div>
      </form>
    </div>

    <script>
      $(document).ready(function() {
      	$('#reg_user').on('click', function() {
        		$("#reg_user").attr("disabled", "disabled");
        		var fname = $('#name1').val();
          	var lname = $('#name2').val();
            var contact = $('#num1').val();
        		var email = $('#email').val();
        		var pass1 = $('#psw').val();
            var pass2 = $('#psw-repeat').val();
        		if(fname!="" && lname!="" && contact!="" && email!="" && pass1!="" && pass2!="")
            {
        			$.ajax({
        				url: "save.php",
        				type: "POST",
        				data: {
        					fname: fname,
                  lname: lname,
                  contact: contact,
        					email: email,
        					pass1: pass1,
                  pass2: pass2
        				},
        				cache: false,
        				success: function(dataResult)
                {
        					var dataResult = JSON.parse(dataResult);
        					if(dataResult.statusCode==200)
                  {
        						$("#reg_user").removeAttr("disabled");
        						$('#form').find('input:text').val('');
        						$("#success").show();
        						$('#success').html('Data added successfully !');
        					}
        					else if(dataResult.statusCode==201)
                  {
        					   alert("Error occured !");
        					}

        				}
        			});
        		}
        		else
            {
        			alert('Please fill all the field !');
        		}
        });
  });

    </script>
  </body>
</html>
