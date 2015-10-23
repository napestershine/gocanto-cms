<?php  
	$action = stripEvents([
		'config' => [
			'email' => $email,
			'publishable_key' => $publishable_key,
			'image' => base_url().'img/logo_w_strip.png'
		],
		'quarterly' => [
			'btn_id'      => 'quarterly_btn',
            'name'        => $service->name,
            'description' => $language->line('services_name_plans_01'),
            'amount'      => str_replace('.', '', $service->quarterly),
            'plan'        => $service->id.'_3'
		],
        'semesterly' => [
        	'btn_id'      => 'semesterly_btn',
            'name'        => $service->name,
            'description' => $language->line('services_name_plans_02'),
            'amount'      => str_replace('.', '', $service->semesterly ),
            'plan'        => $service->id.'_6'
	    ],

        'yearly' => [
        	'btn_id'      => 'yearly_btn',
            'name'        => $service->name,
            'description' => $language->line('services_name_plans_03'),
            'amount'      => str_replace('.', '', $service->yearly),
            'plan'        => $service->id.'_12'
        ]                       
    ]);
?>
<div class="row panel radius">
	<article>
		<h4 class="color_green"><?=$service->name?>
		<small>&nbsp;<?=$content->text_small?></small>
		</h4>
		<?php $this->load->view('partial/toolBar.php', ['content'=>$content, 'language'=>$language, 'socialButtons'=>1]); ?>
		<hr>

		<div class="row">
			<div class="large-12 medium-12 small-12 columns">

				<p>
					<img class="content_pic large-6 medium-6 small-12" src="<?=(file_exists($content->image)?base_url().$content->image:base_url().'img/no-pic.gif')?>" alt="<?=$content->title?>">
					<?php echo $content->body; ?>
				</p>
				<div id="servDetail" class="reveal-modal medium" data-reveal>
					<a class="close-reveal-modal">&#215;</a>
					<h5 class="color_green">
						<?=formatString($service->name)?>
						<small>
							&nbsp;
							<?=$content->text_small?>
						</small>
					</h5>
					<hr>
					<p>
						<img class="content_pic large-6 medium-6 small-12" src="<?=(file_exists($content->image)?base_url().$content->image:base_url().'img/no-pic.gif')?>" alt="<?=$content->title?>">
						<?php echo $content->body; ?>
					</p>
				</div><!-- servDetail --> 
			</div>
		</div>
		
		<div class="row">&nbsp;</div>

		<div class="row">
			<div class="large-12 medium-12 small-12 columns">
				<h4 class="orange_color"><?=str_replace('[prod]', '"'.$service->name.'"', $language->line('services_what_they_offer'))?></h4>
				<p>
					<?php $this->load->view('services/partial/offerLabels', ['details' => $details]); ?>
				</p>
			</div>
		</div>

		<div class="row">&nbsp;</div>

		<div class="row">
			<div class="large-12 medium-12 small-12 columns">
				<h4 class="orange_color"><?=$language->line('services_availables_plans')?></h4>
			</div>
		</div>
		
		<form action="<?=base_url()?>services/process" method="POST" id="process_form">
			<input type="hidden" name="stripeToken" class="stripeToken">
			<input type="hidden" name="email" class="email">
			<input type="hidden" name="plan" class="plan">
		</form>

		<div class="row">
			<div class="large-4 medium-4 small-4 columns">
				<div class="panel radius text-center services_panel_plan">
					<img src="<?=base_url()?>img/plan_bronze.png" alt="" >
					<h5 style="color: #E95220"><?=$language->line('services_name_plans_01')?></h5>
					<p>$<?=$service->quarterly?></p>
					<a href="<?=!$action ? base_url().'content/body/contact-us': 'javascript:void(0)'?>" class="button radius small" id="<?=!$action?'_':''?>quarterly_btn"><?=$language->line('services_purchase_it')?></a>
				</div>
			</div>
			<div class="large-4 medium-4 small-4 columns">
				<div class="panel radius text-center services_panel_plan">
					<img src="<?=base_url()?>img/plan_silver.png" alt="" >
					<h5 style="color: #E95220"><?=$language->line('services_name_plans_02')?></h5>
					<p>$<?=$service->semesterly?></p>
					<a href="<?=!$action ? base_url().'content/body/contact-us': 'javascript:void(0)'?>" class="button radius small" id="<?=!$action?'_':''?>semesterly_btn"><?=$language->line('services_purchase_it')?></a>
				</div>	
			</div>			
			<div class="large-4 medium-4 small-4 columns">
				<div class="panel radius text-center services_panel_plan">
					<img src="<?=base_url()?>img/plan_gold.png" alt="" >
					<h5 style="color: #E95220"><?=$language->line('services_name_plans_03')?></h5>
					<p>$<?=$service->yearly?></p>
					<a href="<?=!$action ? base_url().'content/body/contact-us': 'javascript:void(0)'?>" class="button radius small" id="<?=!$action?'_':''?>yearly_btn"><?=$language->line('services_purchase_it')?></a>
				</div>
			</div>			
			
		</div>

	</article>
</div>
