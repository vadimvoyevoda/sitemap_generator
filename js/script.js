$(document).ready(function(){
	$("#link-form").on("submit", function(e){
		$(".overlay-loading").css("display","table");
		e.preventDefault();
		$depth_max = $(this).find("#depth").val();
		$sitemap = $(this).find("#website").val();
		
		sendAjax($(this).attr('action'), $sitemap, $depth_max);
	});
	
	$("#link-form2").on("submit", function(e){
		$(".overlay-loading").css("display","table");
		e.preventDefault();
		if($("#website2").prop('files').length)
		{
			$data = new FormData(this);
			$depth_max = $(this).find("#depth2").val();
			
			$.ajax({
				url:$(this).attr('action'),
				type:"POST",
				data: $data,
				cache:false,
				contentType: false,
				processData: false,
				success: function(res){
					links = res.split(",");
					$.each(links, function(index, value){
						sendAjax($("#link-form2").attr('action'), value, $depth_max);
					});
				},
				error: function(res){
					alert(res.statusText+" "+res.responseText);
					$(".overlay-loading").css("display","none");
				}		
			});
			}
	});
});

$(document).on('click', 'button.del-btn', function(){
    if(confirm("Are you sure you want to delete this sitemap?"))
	{
		$id = $(this).data("id");
		delete_sitemap($id);
	}
});

$(document).on('click', 'span.expander', function(){
	$parent = $(this).parent();
	$ul = $parent.find("ul");
	$ul.toggle();
	if(!$parent.hasClass("expanded"))
	{
		if(!$ul.length)
		{
			$id = $parent.data("id");
			$.ajax({
				url:"/app/get_links.php",
				type:"POST",
				data: { page_id : $id },
				success: function(res){
					if(res)
					{
						$parent.append(res);
					}
				},
				error: function(res){
					alert(res);
				}		
			});
		}
	}
	$parent.toggleClass("expanded");
});

$(document).on('click', 'li.more, li.less', function(){
	$("li.more, li.more ~ li").toggle("slow");
});

function sendAjax($action, $sitemap, $depth_max){
	$.ajax({
		url:$action,
		type:"POST",
		data: {website : $sitemap},
		success: function(res){
			if(res)
			{			
				createMap(res,1,$depth_max);
			} else{
				update_sitemaps();
			}
		},
		error: function(res){
			alert(res.statusText+" "+res.responseText);
			$(".overlay-loading").css("display","none");
		}		
	});
}

function createMap(sitemap, depth, depth_max)
{
	depth = parseInt(depth);
	depth_max = parseInt(depth_max);
	if(depth < depth_max)
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
					update_sitemaps();
				}
			},
			error: function(res){
				alert(res.statusText+" "+res.responseText);
				$(".overlay-loading").css("display","none");
			}		
		});
	} else {
		update_sitemaps();
	}
}

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

function update_sitemaps(){
	get_sitemaps();
	$(".overlay-loading").css("display","none");
	$('a[data-toggle="tab"][href="#existing"]').tab('show');
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