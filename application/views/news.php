<div class="row panel radius">
	<article>
		<h4 class="color_green"><?=formatString($content->title.' '.$language->line('general_around_the_web'))?>
		<small>&nbsp;
		<?=$content->summary?>
		</small>
		</h4>
		<?php $this->load->view('partial/toolBar.php', ['content'=>$content, 'language'=>$language, 'socialButtons'=>1]); ?>
		<hr>
		
		<div class="row">
			<div class="large-12 columns">
				<?php $this->load->view('partial/blogList.php'); ?>
			</div>
		</div>
		<?php if ($links){ ?>
		<hr>
		<div class="row">
			<div class="large-12 columns">
				<?php echo $links; ?>
			</div>
		</div>
		<?php } ?>
	</article>
</div>