<?php include("views/header.html"); ?>
	<div class="container">
		<div class="col-md-12">
			<ul class="nav nav-tabs">
			  <li class="active"><a data-toggle="tab" href="#create">CREATE SITEMAP</a></li>
			  <li><a data-toggle="tab" href="#existing">SHOW EXISTING</a></li>
			</ul>

			<div class="tab-content">
				<div id="create" class="tab-pane fade in active">
					<?php include("views/start.html"); ?>
				</div>
				<div id="existing" class="tab-pane fade">
					<?php include("app/get_maps.php"); ?>					
				</div>
			</div>
		</div>
	</div>
	
<?php include("views/footer.html"); ?>