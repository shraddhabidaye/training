<!DOCTYPE html>
<html>
<head>
	<title>Insert data in MySQL database using Ajax</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
<div style="margin: auto;width: 60%;">
	<div class="alert alert-success alert-dismissible" id="success" style="display:none;">
	  <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
	</div>
	<form id="fupForm" name="form1" method="post">
		<div class="form-group">
			<label for="name">Name:</label>
			<input type="text" class="form-control" id="fname" placeholder="Name" name="name1">
		</div>
    <div class="form-group">
			<label for="name"> L Name:</label>
			<input type="text" class="form-control" id="lname" placeholder="Name" name="name2">
		</div>
		<div class="form-group">
			<label for="email">Email:</label>
			<input type="email" class="form-control" id="email" placeholder="Email" name="email">
		</div>
		<div class="form-group">
			<label for="contact">Phone:</label>
			<input type="text" class="form-control" id="contact" placeholder="Phone" name="contact">
		</div>
		<div class="form-group" >
			<label for="pwd">password:</label>
      <input type="password" class="form-control" id="pass1" placeholder="Phone" name="pass1">
		</div>
    <div class="form-group" >
			<label for="pwd">password again:</label>
      <input type="password" class="form-control" id="pass2" placeholder="Phone" name="pass2">
		</div>
		<input type="button" name="save" class="btn btn-primary" value="Save to database" id="butsave">
	</form>
</div>

<script>
$(document).ready(function() {
	$('#butsave').on('click', function() {
		$("#butsave").attr("disabled", "disabled");
		var fname = $('#name1').val();
    	var lname = $('#name2').val();
      	var contact = $('#contact').val();
        	var pass1 = $('#pass1').val();
		var email = $('#email').val();

		if(fname!="" && lname!="" && contact!="" && pass1!="" && email!=""){
			$.ajax({
				url: "save.php",
				type: "POST",
				data: {
					fname: fname,
          lname: lname,
          contact: contact,
          pass1: pass1,
					email: email,
				},
        async: true,
        contentType: false,
        processData: false,
				cache: false,
				success: function(returndata){
          alert(returndata);
				}
			});
		}
		else{
			alert('Please fill all the field !');
		}
	});
});
</script>
</body>
</html>
