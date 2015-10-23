<div class="row radius panel">
	<div clss="large-12 medium-12 small-12 columns">
		<article>
			<h4 class="color_green"><?=formatString($content->title)?>
			<small>&nbsp;<?=$content->text_small?></small>
			</h4>
			<hr>
			<div class="row">
				<div class="large-12 medium-12 small-12 columns">
					
					<form name="frmWpLogin" id="frmWpLogin" action="<?=base_url()?>wpanel/login" method="POST">
						<div class="row">
							<div class="large-4 medium-4 columns">
								<label><?=$language->line('login_frm_email')?>:&nbsp;<small>(<?=$language->line('general_required')?>)</small>
									<input type="text" name="txtLogin" id="txtLogin"/>
								</label>
							</div>
						</div>
						
						<div class="row">
							<div class="large-4 medium-4 columns">
								<label><?=$language->line('login_pass_label')?>:&nbsp;<small>(<?=$language->line('general_required')?>)</small>
									<input type="password" name="txtPass" id="txtPass"/>
								</label>
							</div>
						</div>

						<div class="row">
							<div class="large-6 medium-6 small-6 columns">
								<small>
									<a href="<?=base_url()?>wpanel/signUp"><?=$language->line('login_new_account')?></a>
									&nbsp;|&nbsp;
									<a href="javascript:void(0);" data-reveal-id = "forgotPass"><?=$language->line('login_forgot_password')?></a>
								</small>
							</div>
							<div class="large-6 medium-6 small-6 columns">
								&nbsp;
							</div>
						</div>
						
						<div class="row">&nbsp;</div>	
						<div class="row">&nbsp;</div>	

						<div class="row">
							<div class="large-6 medium-6 small-6 columns">
								<a href="javascript:void(0);" id="btnWpLogin" name="btnWpLogin" class="button radius small"><?=$language->line('login_button_label')?></a>
							</div>
							<div class="large-6 medium-6 small-6 columns">
								<a href="<?=$facebook_login_url?>" class="button radius tiny"> <img src="<?=base_url()?>img/Facebook-24.png" width="24" >  <?=$language->line('login_button_facebook')?></a>
							</div>
						</div>

						<div id="login-reveal" class="reveal-modal small" data-reveal>
						<h3></h3>
						<h5></h5>
						<a class="close-reveal-modal">&#215;</a>
						</div>
					</form>

					<div id = "forgotPass" class="reveal-modal small" data-reveal>
						<div class="row">
							<div class="large-12 medium-12 small-12 columns">
								<h4 class="color_green">
									<?=$language->line('login_forgot_title')?>
									<small>
										&nbsp;
										<?=$language->line('login_forgot_small_text')?>
									</small>
								</h4>
								<hr>
							</div>
						</div>
						<div class="row">
							<div class="large-12 medium-12 small-12 columns">
								<div data-alert class="alert-box radius" id="forgotAlerts" style="display:none" >
									<h6></h6>
									<div></div>
									<a href="#" class="close">&times;</a>
								</div>
							</div>
						</div>
						<div class="row">
							<form data-abide id="formForgot" name ="formForgot" action="<?=base_url()?>wpanel/forgotPass" method = "POST">
								<div class="large-12 medium-12 small-12 columns">
									<label><?=$language->line('login_frm_email')?>:&nbsp;<small>(<?=$language->line('general_required')?>)</small>
										<input type="text" name="mailForgot" id="mailForgot" pattern="email" required />
									</label>
									<small class="error radius"><?=$language->line('login_frm_email_error')?>.</small>
								</div>
								<div class="large-12 medium-12 small-12 columns">
									<button type="submit" class="button radius tiny large-4 medium-4 small-4 columns"><?=$language->line('login_forgot_continue')?></button>
									<div class="large-4 medium-4 small-4 columns">&nbsp;</div>
									<div class="large-4 medium-4 small-4 columns">&nbsp;</div>
								</div>
							</form>
						</div>
						<a class="close-reveal-modal">&#215;</a>
					</div> <!-- end forgot pass -->
				</div>
			</div>
		</article>
	</div>
</div>

<div class="row">
	&nbsp;
</div>

<?php $this->load->view('partial/blogList.php'); ?>