<?php if ($content->type == 'Blog') {
    ?>
<div class="row panel radius show-for-medium-up">
	<script type='text/javascript' src='//eclkmpbn.com/adServe/banners?tid=47696_72120_0'></script>
</div>
<div class="row panel radius show-for-small-only">
	<script type='text/javascript' src='//eclkmpbn.com/adServe/banners?tid=47696_72120_3'></script>
</div>
<?php 
}?>
<div class="row panel radius">

	<article itemscope itemtype="<?=base_url().'content/body/'.$content->id?>">
		
		<h4 class="color_green" itemprop="headline">
			<?=formatString($content->title)?>
			<small itemprop="description">&nbsp;<?=$content->text_small?></small>
			<meta itemprop="datePublished" content="<?=$content->dateiso?>"/>
		</h4>

		<?php $this->load->view('partial/toolBar.php', ['content' => $content, 'language' => $language, 'socialButtons' => 1]); ?>
		
		<hr>
		
		<div class="row">
			<div class="large-12 columns justify">
				<p itemprop="articleBody">
					<?php if (file_exists($content->image)) {
    ?>
					<img itemprop="image" class="content_pic large-6 medium-6 small-12" src="<?=base_url().$content->image?>" alt="<?=$content->title?>">
					<?php 
} echo $content->body; ?>
				</p>
			</div>
		</div>

		<div class="row">
			&nbsp;
		</div>

		<?php if ($content->type == 'Blog') {
    ?>
    		<hr>
			<div class="row">
				<div class="large-12 columns">
					<h4 class="color_green">
						<?=$language->line('general_blog_leave_replay')?>
					</h4>
				</div>
			</div>
		
			<div class="row">
				<div class="large-12 columns">
					<div class="large-12 columns"><?=comments($config['disqus_id'])?></div>
				</div>
			</div>
		<?php 
} ?>

	</article>
</div>


<!-- News -->

<div class="row">
	&nbsp;
</div>

<?php $this->load->view('partial/blogList.php', ['is_post' => $is_post]); ?>