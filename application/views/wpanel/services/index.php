<?php
if (empty($wp_user) && $wp_user['id'] == '') {
    redirect(base_url().'wpanel');
    die();
    exit();
}
?>
<div class="row panel radius">
	<article>
		<h4 class="color_green">
			<?=formatString($content->title)?>
			<small>
				&nbsp;
				<?=$content->text_small?>
			</small>
		</h4>
		<hr>

		<div class="row">
			<div class="large-12 medium-12 small-12 columns">
				
				<table>
					<thead>
						<tr>
							<th><?=$language->line('services_label_id')?></th>
							<th><?=$language->line('services_label_status')?></th>
							<th><?=$language->line('services_label_content')?></th>
							<th><?=$language->line('services_label_services')?></th>
							<th><?=$language->line('services_label_actions')?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($services as $array) {
    ?>
						<tr id="tr_<?=$array['id']?>">
							<td width="5%"><?=$array['id']?></td>
							<td width="10%"><?=formatString($array['status'])?></td>
							<td width="30%"><?=$array['content']?></td>
							<td width="50%"><?=formatString($array['name'])?></td>
							<td width="5%">
								<a href="javascript:void(0)" data-reveal-id="process_serv" data-reveal-ajax="<?=base_url()?>services/process/<?=$array['id']?>" >
									<img width="30%" src="<?=base_url()?>img/search.png" alt="<?=$language->line('services_label_actions_details')?>" class="cursor_pointer right">
								</a>
								<div id="process_serv" class="reveal-modal small" data-reveal>		
									&nbsp;
								</div>
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