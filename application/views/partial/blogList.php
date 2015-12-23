<?php  if (isset($blogBox) && $blogBox == 1) {
     ?>
<div class="row radius panel">
	
		<div clss="row">
			<h4 class="color_green">
				<?=formatString((isset($is_post) && $is_post == 1 ? $language->line('general_more_more').'&nbsp;' : '').$language->line('general_title_news').' '.$language->line('general_around_the_web'))?>&nbsp;
				<small><?=$language->line('general_blog_small_summary')?></small>
			</h4>
		</div>
		<hr>
		<?php

 }
        $i = 0;
        foreach ($blogList as $array) {
            $url_post = base_url().'content/body/'.$array['id'];
            $title_post = substr(formatString($array['title']), 0, 100);
            if ($i++ > 0) {
                echo '<div class="row">&nbsp;</div>';
            }
            ?>
			    <div class="row">
			    	<div class="large-12 columns">
						<div class="blog-list-img-box small-12 medium-6 large-3 columns"  title="Read more about >> <?=$title_post?>" onclick="redirect('<?=$url_post?>')" style="background-image: url('<?=(file_exists($array['image']) ? base_url().$array['image'] : base_url().'img/no-pic.gif')?>')">
							&nbsp;
						</div>
						<div class="small-12 medium-6 large-7 columns">
							<h5><a href="<?=$url_post?>"><?=$title_post?></a>&nbsp;
								<small><?=postLimit(strip_tags($array['body']), 80)?>...</small>
							</h5>
							
						</div>
						<div class="small-12 medium-6 large-2 columns">
							<div class="row">&nbsp;</div>
							<a href="<?=$url_post?>" class="button tiny radius medium-10 large-12 columns">
								<?=$language->line('general_more_info')?>
							</a>
						</div>
					</div>
				</div>
<?php

        }

        if (isset($blogBox) && $blogBox == 1) {
            ?>	
</div>
<?php 
        } ?>