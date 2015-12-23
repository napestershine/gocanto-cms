<div class="row panel radius">
	<article>
		<h4 class="color_green">
			<?=$language->line('support_title_view')?>&nbsp;
			<small><?=$content->text_small?></small>
		</h4>
		<hr>

		<div class="row">
			<div class="large-12 columns">
				<div class="large-12 columns contact-map" id="map"></div>
			</div>
		</div>

		<div class="row">&nbsp;</div>
		
		<div class="row">
			<div class="large-12 columns" id="out">
				<h4 class="color_green">
					<?=$language->line('support_title_form')?>&nbsp;
					<small style = "display:none">
						<?=$language->line('support_message_form')?>&nbsp;
						<?=$language->line('support_right_by').' <strong>'.$companyInfo->address.'.&nbsp;'.$companyInfo->city.'.&nbsp;'.$companyInfo->state.',&nbsp;'.$companyInfo->zip_code.'</strong>'?>
					</small>
				</h4>
				<hr>
			</div>
		</div>
		
		<div class="row">
			<form data-abide name="frmContact" id="frmContact" action="<?=base_url()?>contact/sent" method="POST">
				<div class="large-7 columns">
					<div class="row">
						<div class="large-12 columns">
							<label><?=$language->line('support_request')?>:
								<select name="cboContactReason" id="cboContactReason">
									<?php foreach ($reasons as $value) {
    ?>
									<option value="<?=$value['id']?>" <?php if (isset($op) && $op == $value['id']) {
    echo 'selected';
}
    ?>  ><?=formatString($value['name'], 2)?></option>
									<?php

} ?>
								</select>
							</label>
						</div>
					</div>

					<div class="row">
						<div class="large-12 columns">
							<label><?=$language->line('support_name')?>&nbsp;<small>(<?=$language->line('general_required')?>)</small>
								<input type="text" name="txtContactName" id="txtContactName" placeholder="Your <?=$language->line('support_name')?>" required />
							</label>
							<small class="error radius"><?=$language->line('support_name_lblerror')?>.</small>
						</div>
					</div>

					<div class="row">
						<div class="large-7 columns">
							<label><?=$language->line('support_email')?>&nbsp;<small>(<?=$language->line('general_required')?>)</small>
								<input type="email" name="txtContactEmail" id="txtContactEmail" pattern="email" placeholder="Your <?=$language->line('support_email')?>" required />
							</label>
							<small class="error"><?=$language->line('support_email_lblerror')?>.</small>
						</div>
					</div>

					<div class="row">
						<div class="large-7 columns">
							<label><?=$language->line('support_phone_number')?>
								<input type="text" name="txtContactTlf" id="txtContactTlf" placeholder="Your <?=$language->line('support_phone_number')?>" />
							</label>
							<small class="error"><?=$language->line('support_phone_number_lblerror')?>.</small>
						</div>
					</div>

					<div class="row">
						<div class="large-12 columns">
							<label><?=$language->line('support_message')?>&nbsp;<small>(<?=$language->line('general_required')?>)</small>
								<textarea name="txtContactMsg" id="txtContactMsg" style = "height: 150px" placeholder="Your <?=$language->line('support_message')?>" required><?=(isset($plan) && $plan != '' ? 'I would like to get a #'.$plan.' plan and ...' : '')?></textarea>
							</label>
							<small class="error"><?=$language->line('support_message_lblerror')?>.</small>
						</div>
					</div>
					<div class="row">&nbsp;</div>
					<div class="row">
						<div class="large-8 columns">
							<button type="reset" id="btnContactReset" name="btnContactReset" class="button radius tiny" value="Reset">&nbsp;&nbsp;&nbsp;&nbsp;<?=$language->line('general_reset')?>&nbsp;&nbsp;&nbsp;&nbsp;</button>
							<button type="button" id="btnContactSave" name="btnContactSave" class="button radius tiny">&nbsp;&nbsp;&nbsp;&nbsp;<?=$language->line('general_send')?>&nbsp;&nbsp;&nbsp;&nbsp;</button>
						</div>
						<div class="large-2 columns">
							<div id="contact-reveal" class="reveal-modal small" data-reveal>
								<h2></h2>
								<h5></h5>
								<a class="close-reveal-modal">&#215;</a>
							</div>
						</div>
					</div>
				</div>
			</form>
			<div class="large-5 columns">
				&nbsp;
			</div>
		</div>
	</article>
</div>

<!-- News -->

<div class="row">
	&nbsp;
</div>

<?php $this->load->view('partial/blogList.php'); ?>