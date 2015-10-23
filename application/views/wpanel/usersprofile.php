<?php
    if (empty($wp_user) && $wp_user['id']=='') {
        redirect(base_url().'wpanel');
        die();
        exit();
    }
?>
<div class="row panel radius">
	<article>
		<h3><img src="<?=base_url().$content->icon?>" alt="<?=$content->title?>">&nbsp;<?=formatString($content->title)?></h3>
		<h5><small><?=$content->text_small?>.</small></h5>
		<hr>
			<div class="row">
				<form data-abide name="frmSignUp" id="frmSignUp" action="<?=base_url()?>customers/update" method="POST">
					<div class="large-12 columns">
						<div class="row">
							<div class="large-12 columns">
								<h3>
									<img src="<?=base_url().'img/user2.png'?>" alt="lock">
									<small class="color_green"><strong>Contact Information</strong></small>
								</h3>
							</div>
						</div>
						<div class="row">
							<div class="large-3 columns">
								<label><?=$language->line('login_signup_frm_name')?>&nbsp;<small>(<?=$language->line('general_required')?>)</small>
									<input type="text" name="txtContactName" id="txtContactName" pattern="alpha_numeric" placeholder="" value="<?=$user->name?>" required />
								</label>
								<small class="error radius"><?=$language->line('login_signup_frm_name_error')?>.</small>
							</div>
							<div class="large-3 columns">
								<label><?=$language->line('login_signup_frm_lastname')?>&nbsp;<small>(<?=$language->line('general_required')?>)</small>
									<input type="text" name="txtContactLastName" id="txtContactLastName" pattern="alpha_numeric" placeholder="" value="<?=$user->last_name?>" required />
								</label>
								<small class="error"><?=$language->line('login_signup_frm_lastname_error')?>.</small>
							</div>
							<div class="large-3 columns">
								<label><?=$language->line('login_signup_frm_phone')?>&nbsp;<small>(<?=$language->line('general_required')?>)</small>
									<input type="text" name="txtContactTlf" id="txtContactTlf" placeholder="" value="<?=$user->phone?>" required />
								</label>
								<small class="error"><?=$language->line('login_signup_frm_phone_error')?>.</small>
							</div>
							<div class="large-3 columns">&nbsp;</div>
						</div>
						<div class="row">&nbsp;</div>
<!-- 						<div class="row">
							<div class="large-12 columns">
								<h3>
									<img src="<?=base_url().'img/location.png'?>" alt="lock">
									<small class="color_green"><strong>Address Information</strong></small>
								</h3>
							</div>
						</div>
						<div class="row">
							<div class="large-12 columns">
								<label><?=$language->line('login_signup_frm_address')?>&nbsp;<small>(<?=$language->line('general_required')?>)</small>
									<textarea name="txtContactAddress" id="txtContactAddress" placeholder="" required><?=$user->address?></textarea>
								</label>
								<small class="error radius"><?=$language->line('login_signup_frm_address_error')?>.</small>
							</div>
						</div>
						<div class="row">
							<div class="large-3 columns">
								<label><?=$language->line('login_signup_frm_country')?>&nbsp;<small>(<?=$language->line('general_required')?>)</small>
									<input type="text" name="txtContactCountry" id="txtContactCountry" pattern="" placeholder="" value="<?=$user->country?>" required />
								</label>
								<small class="error radius"><?=$language->line('login_signup_frm_country_error')?>.</small>
							</div>
							<div class="large-3 columns">
								<label><?=$language->line('login_signup_frm_state')?>&nbsp;<small>(<?=$language->line('general_required')?>)</small>
									<input type="text" name="txtContactState" id="txtContactState" pattern="" placeholder="" value="<?=$user->state?>" required />
								</label>
								<small class="error"><?=$language->line('login_signup_frm_state_error')?>.</small>
							</div>
							<div class="large-3 columns">
								<label><?=$language->line('login_signup_frm_city')?>&nbsp;<small>(<?=$language->line('general_required')?>)</small>
									<input type="text" name="txtContactCity" id="txtContactCity" pattern="" placeholder="" value="<?=$user->city?>" required />
								</label>
								<small class="error"><?=$language->line('login_signup_frm_city_error')?>.</small>
							</div>
							<div class="large-3 columns">
								<label><?=$language->line('login_signup_frm_zip')?>&nbsp;<small>(<?=$language->line('general_required')?>)</small>
									<input type="text" name="txtContactZip" id="txtContactZip" placeholder="" value="<?=$user->zip?>" required />
								</label>
								<small class="error"><?=$language->line('login_signup_frm_zip_error')?>.</small>
							</div>
						</div> -->
						<div class="row">&nbsp;</div>
						<div class="row">
							<div class="large-12 columns">
								<h3>
									<img src="<?=base_url().'img/lock.png'?>" alt="lock">
									<small class="color_green"><strong>Access Information</strong></small>
								</h3>
							</div>
						</div>
						<div class="row">
							<div class="large-3 columns">
								<label><?=$language->line('login_signup_frm_email')?>&nbsp;<small>(<?=$language->line('general_required')?>)</small>
									<input type="email" name="txtContactEmail" id="txtContactEmail" pattern="email" placeholder="" value="<?=$user->email?>" required />
								</label>
								<small class="error"><?=$language->line('login_signup_frm_email_error')?>.</small>
							</div>
							<div class="large-3 columns">
								<label><?=$language->line('login_signup_frm_password')?>&nbsp;<small>(<?=$language->line('general_required')?>)</small>
									<input type="text" name="txtContactPass" id="txtContactPass" pattern="" placeholder="" value="<?=$user->password?>" required />
								</label>
								<small class="error"><?=$language->line('login_signup_frm_pass_error')?>.</small>
							</div>
							<div class="large-3 columns">&nbsp;</div>
							<div class="large-3 columns">&nbsp;</div>
						</div>
						
						<hr>

						<div class="row">
							<div class="large-8 columns">
								<ul class="button-group radius">
									<li><a href="<?=$config['not_click']?>" class="small button tiny" id="btnContactSignUp"><?='Update'?></a></li>
									<li><a href="<?=$config['not_click']?>" onclick="redirect('<?=base_url()?>content/body/support');" class="small button secondary tiny" id="btnContactQuestion"><?=$language->line('login_signup_frm_menubu_02')?></a></li>
	  							</ul>
							</div>
							<div class="large-2 columns">
								&nbsp;
							</div>
							<div class="large-2 columns">
								<div id="contact-reveal-signup" class="reveal-modal small" data-reveal>
									<h2></h2>
									<h5></h5>
									<a class="close-reveal-modal" id="close_message">&#215;</a>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
	</article>
</div>