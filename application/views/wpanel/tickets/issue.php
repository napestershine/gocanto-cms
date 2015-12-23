<?php
if (empty($wp_user) && $wp_user['id'] == '') {
    redirect(base_url().'wpanel');
    die();
    exit();
}
?>
<div class="row panel radius">
	<article>
		<h3><?=$language->line('tickets_web_title_issues')?> #<?=$id_dad?></h3>
		<h5><small><?=$language->line('tickets_web_sumary_issues')?></small></h5>
		<hr>
		<div class="large-12 columns">
		<?php $this->load->view('wpanel/tickets/add.php'); ?>
		</div>
		<div class="row">			
			<div class="large-12 columns">
				<table width="100%">
					<tbody>
						<?php foreach ($tickets as $array) {
    ?>
						<tr id="tr_<?=$array['id']?>">
							<td><h6><span class="label radius <?=isset($array['id_user']) ? 'secondary' : 'success'?>">#<?=isset($array['id_user']) ? $array['author'] : $language->line('tickets_support')?></span></h6> 
								<?=formatString($array['message'])?>
								<br>
								<small class="right"><?=$array['datetime']?></small>
							</td>
						</tr>
						<?php 
} ?>
					</tbody>
				</table>
			</div>
		</div>
	</article>
</div>