$(document).ready(function(){
	$("#link-for").on("submit", function(e){
		e.preventDefault();
		$.ajax({
			url:"./controllers/linkController.php",
			type:"POST",
			data: $(this).serialize(),
			success: function(res){
				alert(res);
			},
			error: function(res){
				alert(res);
			}		
		});
	});
});