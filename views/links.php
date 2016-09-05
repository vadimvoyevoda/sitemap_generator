<?php if(!empty($sitemap_url)):?>
<div class="container">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<a href="/" class="back">Back</a>
				<h3 class="title">SITEMAP <?=$sitemap_url?></h3>				
			</div>
			<div class="panel-body">
				<div class="expanded sitemap">
					<span class="expander"></span>
					<?=$sitemap_url?>
				
<?php endif;?>
				<ul>
				<?php for($i=0; $i<$max; $i++){?>
					<li data-id="<?=$links[$i]['LINK_ID']?>">
						<span <?= $links[$i]['HAS_CHILD_LINKS'] ? 'class="expander"': ''; ?> ></span>
						<?=$links[$i]['LINK']?>
					</li>
				<?php }
					if($max < $all_links_count)
					{
				?>
					<li class="more">show more</li>
				<?php for($i=$max; $i<$all_links_count; $i++){?>
					<li data-id="<?=$links[$i]['LINK_ID']?>">
						<span <?= $links[$i]['HAS_CHILD_LINKS'] ? 'class="expander"': ''; ?> ></span>
						<?=$links[$i]['LINK']?>
					</li>
				<?php }?>
					<li class="more">show less</li>
				<?php }?>
				</ul>
<?php if(!empty($sitemap_url)):?>
				</div>
			</div>
		</div>			
	</div>
</div>
<?php endif;?>