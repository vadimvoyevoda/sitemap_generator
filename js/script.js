$(document).ready(function(){
	$("#link-form").on("submit", function(e){
		$(".overlay-loading").css("display","table");
		e.preventDefault();
		$depth_max = $(this).find("#depth").val();
		$sitemap = $(this).find("#website").val();
		
		$.ajax({
			url:"./app/build_map.php",
			type:"POST",
			data: {website : $sitemap},
			success: function(res){
				if(res)
				{
					createMap(res,1,$depth_max);
				}
			},
			error: function(res){
				alert(res.statusText+" "+res.responseText);
			}		
		});
	});
});

function createMap(sitemap, depth, depth_max)
{
	$.ajax({
		url:"./app/build_map.php",
		type:"POST",
		data: {sitemap : sitemap, depth : depth, depth_max : depth_max},
		success: function(res){
			if(res)
			{
				createMap(sitemap, res, depth_max);
			} else {
				get_sitemaps();
				$(".overlay-loading").css("display","none");
				$('a[data-toggle="tab"][href="#existing"]').tab('show');
			}
		},
		error: function(res){
			alert(res.statusText+" "+res.responseText);
		}		
	});
}

$(document).on('click', 'button.del-btn', function(){
    if(confirm("Are you sure you want to delete this sitemap?"))
	{
		$id = $(this).data("id");
		delete_sitemap($id);
	}
});

function get_sitemaps()
{
	$.ajax({
		url:"./app/get_maps.php",
		type:"POST",
		success: function(res){
			if(res)
			{
				$("#existing").html(res);
			} else {
				$("#existing").html("<h3>There are no sitemaps</h3>");
			}						
		},
		error: function(res){
			alert(res);
		}		
	});
}

function delete_sitemap(id)
{
	$.ajax({
		url:"./app/delete_map.php",
		type:"POST",
		data: { id : id },
		success: function(res){
			if(res)
			{
				get_sitemaps();
			}
		},
		error: function(res){
			alert(res);
		}		
	});
}