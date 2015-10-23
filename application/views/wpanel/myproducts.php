<?php
    if (empty($wp_user) && $wp_user['id']=='') {
        redirect(base_url().'wpanel');
        die();
        exit();
    }
?>
<div class="row panel radius">
	<article>
		<h4 class="color_green"><?=formatString($content->title)?>
		<small>&nbsp;<?=$content->text_small?></small>
		</h4>
		<hr>
		<div class="row">
			<div class="large-12 medium-12 small-12 columns">
				My products (Under construction)!
			</div>
		</div>
	</article>
</div>