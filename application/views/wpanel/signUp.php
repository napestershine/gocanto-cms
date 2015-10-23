<div class="row radius panel">
	<div class="large-12 medium-12 small-12 columns">
		<article>
			<h4 class="color_green">
				<?=formatString(str_replace('[company]', $companyInfo->name, $content->title))?>
				<small>&nbsp;<?=$content->text_small?></small>
			</h4>
			<hr>
			<div class="row">
				<div class="large-12 medium-12 small-12 columns">

					<form name="frmSignUp" id="frmSignUp" action="<?=base_url()?>wpanel/processSignUp" method="POST">
						<div class="row">
							<div class="large-4 medium-5 small-5 columns">
								<label><?=$language->line('signup_frm_name')?>&nbsp;<small>(<?=$language->line('general_required')?>)</small>
									<input type="text" name="txtName" id="txtName"/>
								</label>
							</div>
							<div class="large-4 medium-5 small-5 columns">
								<label><?=$language->line('signup_frm_lastname')?>&nbsp;<small>(<?=$language->line('general_required')?>)</small>
									<input type="text" name="txtLastName" id="txtLastName"/>
								</label>
							</div>
							<div class="large-4 medium-2 small-2 columns">
								&nbsp;
							</div>
						</div>

						<div class="row">
							<div class="large-4 medium-5 small-7 columns">
								<label><?=$language->line('signup_frm_email')?>&nbsp;<small>(<?=$language->line('general_required')?>)</small>
									<input type="email" name="txtEmail" id="txtEmail"/>
								</label>
							</div>
							<div class="large-8 medium-7 small-5 columns">
								&nbsp;
							</div>
						</div>

						<div class="row">
							<div class="large-4 medium-5 small-7 columns">
								<label><?=$language->line('signup_frm_phone')?>:
									<input type="text" name="txtPhone" id="txtPhone"/>
								</label>
							</div>
							<div class="large-8 medium-7 small-5 columns">
								&nbsp;
							</div>
						</div>

						<div class="row">
							<div class="large-4 medium-5 small-7 columns">
								<label><?=$language->line('signup_frm_password_01')?>:&nbsp;<small>(<?=$language->line('general_required')?>)</small>
									<input type="password" name="txtPass01" id="txtPass01"/>
								</label>
							</div>
							<div class="large-8 medium-7 small-5 columns">
								&nbsp;
							</div>
						</div>
							
						<div class="row">
							<div class="large-4 medium-5 small-7 columns">
								<label><?=$language->line('signup_frm_password_02')?>:&nbsp;<small>(<?=$language->line('general_required')?>)</small>
									<input type="password" name="txtPass02" id="txtPass02"/>
								</label>
							</div>
							<div class="large-8 medium-7 small-5 columns">&nbsp;</div>
						</div>
							
						<div class="row">
							<div class="large-8 medium-8 small-8 columns">
								<a href="<?=$config['not_click']?>" class="button small radius" id="btnSignUp"><?=$language->line('signup_frm_signup')?></a>
							</div>

							<div class="large-4 medium-4 small-4 columns">
								<div id="reveal-signup" class="reveal-modal small" data-reveal>
								<h2></h2>
								<h5></h5>
								<a class="close-reveal-modal" id="close_message">&#215;</a>
								</div>
								<div id="reveal-signup-error" class="reveal-modal small" data-reveal>
								<h3><?=$language->line('signup_no_mach_pass_title')?></h3>
								<h5><?=$language->line('signup_no_mach_pass_msg')?></h5>
								<a class="close-reveal-modal">&#215;</a>
								</div>
							</div>
						</div>
					</form>

				</div>
			</div>
		</article>
	</div>
</div>

<div class="row">
	&nbsp;
</div>

<?php $this->load->view('partial/blogList.php'); ?>