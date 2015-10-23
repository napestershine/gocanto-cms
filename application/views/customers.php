<div class="row panel radius">
	<article>
		<h4 class="color_green"><?=formatString($content->title)?>
		<small>
			<?=$content->summary?>
		</small>
		</h4>
		
		<?php $this->load->view('partial/toolBar.php', ['content'=>$content, 'language'=>$language]); ?>
	
		<hr>
		<div class="row">
				<div class="small-12 columns">
					<ul class="small-block-grid-2 medium-block-grid-3 large-block-grid-3">
						<?php foreach ($gallery as $array) {
    ?>
							<li>
								<a href="<?=$array['url']?>" title="go to: <?=formatString($array['name'])?>" target="_blank">
									<img src="<?=base_url().$array['pic']?>" alt="" class="gallery-customers-img">
								</a>
								<div class="panel gallery-customers-box">
									<h6>
									<a href="<?=$array['url']?>" title="go to: <?=formatString($array['name'])?>" target="_blank">
										<span class="color_green">#</span><?=formatString($array['name'])?></h6>
									</a>
									<ul class="circle">
										<li><small><?=formatString($array['type_name'])?></small></li>
										<li><small><?=formatDate($array['date'])?></small></li>
										<li><small>Language:&nbsp;<?=$array['language']?></small></li>
									</ul>
								</div>
							</li>
						<?php

}  ?>
					</ul>
				</div>
		</div>
	</article>
</div>

<!-- News -->

<div class="row">
	&nbsp;
</div>

<?php $this->load->view('partial/blogList.php'); ?>