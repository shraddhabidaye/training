$(document).on('submit','#editForm',function(e){
        e.preventDefault();
           var name1= $("input[name='name1']").val();
           var name2= $("input[name='name2']").val();
           var num1= $("input[name='num1']").val();
          $.ajax({
          method:"POST",
          url: "save1.php",
          data:{
            name1:name1,
            name2:name2,
            num1:num1
          },
          success: function(data){

         $('#row').load('edit.php');
          $('#msg').html(data);

        }
      });
});
