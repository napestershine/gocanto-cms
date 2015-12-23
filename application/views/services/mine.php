<?php
if (empty($wp_user) && $wp_user['id'] == '') {
    redirect(base_url().'wpanel');
    die();
    exit();
}
$ci = &get_instance();
$ci->load->library('stripe');
//getSubscription($customer_id, $subscription_id)
?>
<div class="row panel radius">
	<article>
		<h4 class="color_green">
			<?=formatString($language->line('services_web_title'))?>
			<small>
				&nbsp;
				<?=$language->line('services_web_small_text')?>
			</small>
		</h4>
		<hr>

		<div class="row">
			<div class="large-12 medium-12 small-12 columns">
				
				<table width="100%"  role="grid">
					<thead>
						<tr>
							<th><?=$language->line('services_label_services')?></th>
							<th><?=$language->line('services_label_status')?></th>
							<th><?=$language->line('services_label_plan_bought')?></th>
							<th><?=$language->line('services_label_created_at')?></th>
							<th><?=$language->line('services_label_updated_at')?></th>
							<th class="text-center"><?=$language->line('services_label_actions')?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($services as $array) {
    ?>
						<tr id="tr_<?=$array['id']?>">
							<td><?=$array['name']?></td>
							<td><span class="label radius <?=$array['sub_status'] == 'active' ? 'success' : 'alert'?>"><?=formatString($array['sub_status'])?></span></td>
							<td>
								<?php
                                    $plan = $ci->stripe->getSubscription($array['user_stripe_id'], $array['sub_stripe_id']);
    echo $plan->plan->name;
    ?>
							</td>
							<td><?=formatDate($array['sub_created_at'])?></td>
							<td><?=$array['sub_updated_at'] == '0000-00-00 00:00:00' ? $language->line('services_label_no_updates') : formatDate($array['sub_updated_at'])?></td>
							<td>
								<a href="#" class="button split tiny secondary radius right"><?=$language->line('services_label_actions_menu')?><span data-dropdown="drop"></span></a><br>
									<ul id="drop" class="f-dropdown" data-dropdown-content>
									<li><a href="javascript:void(0)" data-reveal-id="process_serv" data-reveal-ajax="<?=base_url()?>services/process/<?=$array['id']?>" ><?=$language->line('services_label_actions_review')?></a></li>
									<li><a href="<?=base_url()?>services/suspend/<?=$array['sub_id']?>"><?=$language->line('services_label_actions_suspend')?></a></li>
								</ul>
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