<ul class="small-block-grid-1 medium-block-grid-3 large-block-grid-3" data-equalizer="text_small">
	<?php foreach ($services as $array) { ?>
	<li itemscope itemtype ="<?=base_url().'services/show/'.$array['id']?>">
		<img itemprop="image" src="<?=base_url()?>img/web_plan<?=$array['id']?>.png" onclick="redirect('<?=base_url().'services/show/'.$array['id']?>')" width="100%"  alt="" class="gallery-customers-img cursor_pointer">
		<div class="panel home_plans_panel">
			<div class="row">
				<h6 class="color_black cursor_pointer" onclick="redirect('<?=base_url().'services/show/'.$array['id']?>')">
					<strong class="color_green">#</strong><span itemprop="name"><?=formatString($array['name'])?></span> 
				</h6>
				<h4 class="price_web_plan color_green" itemprop="priceCurrency" content="USD" >$&nbsp;<span itemprop="price"><?=$array['month']?></span><small>/<?=$language->line('general_month')?></small></h4>
				<h4 class="color_green" data-equalizer-watch="text_small"><small itemprop="description"><?=$array['text_small']?></small></h4>
			</div>
			<div class="row text-center">
				<a class="button small radius" href="<?=base_url().'services/show/'.$array['id']?>"><?=$language->line('general_more_info')?></a>
			</div>
		</div>
	</li>
	<?php } ?>
</ul>