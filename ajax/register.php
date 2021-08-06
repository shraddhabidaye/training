<!DOCTYPE html>
<html>
<head>
	<title>Insert data in MySQL database using Ajax</title>
	<link rel="stylesheet" href="login.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
<div style="margin: auto;width: 60%;">
	<div class="alert alert-success alert-dismissible" id="msg" style="display:none;">
	  <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
	</div>
	<div>
		<form id="userForm" method="post">
			<div class="container">
				<div class="container1">
					<h1>Sign Up</h1>
					<p>Please fill in this form to create an account.</p>
					<hr>
					<label for="first_name"><b>First Name:</b></label>
					<input type="text" placeholder="first name" name="name1" required>

					<label for="last_name"><b>Last Name:</b></label>
					<input type="text" placeholder="last name" name="name2" required>

					<label for="mobile"><b>Contact No.:</b></label>
					<input type="number" placeholder="contact no." name="num1" required>

					<label for="email"><b>Email</b></label>
					<input type="email" placeholder="Enter Email" name="email" required>

					<label for="psw"><b>Password</b></label>
					<input type="password" placeholder="Enter Password" name="psw" required>

					<label for="psw-repeat"><b>Repeat Password</b></label>
					<input type="password" placeholder="Repeat Password" name="psw-repeat" required>

					<div class="clearfix">
						<button type="submit" name="submit">Sign Up</button>
					</div>
				</div>
			</div>
		</form>
	</div>

<script type="text/javascript">
$(document).on('submit','#userForm',function(e){
				e.preventDefault();

				$.ajax({
				method:"POST",
				url: "save.php",
				data:$(this).serialize(),
				success: function(data){
				$('#msg').html(data);
				$('#userForm').find('input').val('')
		}});
});

</script>
</body>
</body>
</html>
