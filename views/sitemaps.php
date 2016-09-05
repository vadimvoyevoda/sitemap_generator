<h3 class="title">Existing sitemaps</h3>
<table class="table table-striped">
	<thead>
		<tr>
			<th>#</th>
			<?php foreach($sitemap_keys as $key):?>
				<th><?=$key?></th>
			<?php endforeach;?>		
			<th>DELETE</th>
	  </tr>
	</thead>
	<tbody>
		<?php foreach($sitemaps as $i => $sitemap):?>	
		<tr>
			<td><?=($i+1)?></td>
			<td><a href="pages/single_sitemap.php?id=<?=$sitemap['SITEMAP_ID']?>"><?=$sitemap['DOMAIN']?></a></td>
			<td><?=$sitemap['GENERATION_DATE']?></td>
			<td><button class="btn btn-default del-btn" data-id="<?=$sitemap['SITEMAP_ID']?>">DELETE</button></td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>