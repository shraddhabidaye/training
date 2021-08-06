$(document).on('submit','#userForm',function(e){
				e.preventDefault();

				$.ajax({
				method:"POST",
				url: "save.php",
				data:$(this).serialize(),
				success: function(data){
					console.log(data);
            $('#b1').show();
            	$('#login').show();
					$("#msg").show();
						$('#msg').html(data);
				$('#userForm').find('input').val('')
		}});
});
