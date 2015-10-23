<div class="row radius panel" id="login">
	<div clss="large-9 columns">
		<article>
			<h4 class="color_green"><?=formatString($content->title)?>
				<small>
					&nbsp;
					<?php  
						$smallText = '';	
						
						if (isset($user->name) && $user->name!='')
						{
							$smallText  = $language->line('general_dear_word').'&nbsp;<strong>'.$user->name.'</strong>,&nbsp;'.$language->line('passAss_reset_txt_small').'&nbsp;';
						}

						echo $smallText.$content->text_small;
					?>
				</small>
			</h4>
			<hr>
			<div class="row">
				<div class="large-12 columns">

					<?php if (is_array($user) && isset($user['error_title'])){ ?>
					
					<div data-alert class="alert-box warning radius">
						<h5 class = "alert-box-title"><?=$user['error_title']?></h5>
						<?=$user['error_msg']?>
					</div>	

					<?php 

						}else{ 

						echo form_open(base_url().'wpanel/updatePass', [
							'class' => 'email', 
							'id' => 'fromResetPass', 
							'name' => 'fromResetPass'
						]);

					?>	
					<div class="row">
						<div class="large-4 medium-4 columns">
							<label><?=$language->line('passAss_reset_new_pass_label_01')?>:&nbsp;<small>(<?=$language->line('general_required')?>)</small>
							<?php 
								echo form_input([
									'name' => 'txtPass1',
									'id' => 'txtPass1',
									'type' => 'password'
      							]); 
							?>
							</label>
						</div>
					</div>
					
					<div class="row">
						<div class="large-4 medium-4 columns">
							<label><?=$language->line('passAss_reset_new_pass_label_02')?>:&nbsp;<small>(<?=$language->line('general_required')?>)</small>
							<?php 
								echo form_input([
									'name' => 'txtPass2',
									'id' => 'txtPass2',
									'type' => 'password'
      							]); 
							?>
							</label>
						</div>
					</div>

					<div class="row">
						<div class="large-6 medium-6 small-6 columns">
							<?php 
								echo form_input([
									'name' => 'btnResetPassSend',
									'id' => 'btnResetPassSend',
									'type' => 'button',
									'class' => 'button radius small',
									'value' => $language->line('general_submit')
      							]);
							?>
						</div>
						<div class="large-6 medium-6 small-6 columns">
							&nbsp;
						</div>
					</div>
					<?php 
						echo form_hidden('token', $user->token);
						echo form_close(); 
					}//else	
					?>
					<div id="resetPass-error-reveal" class="reveal-modal small" data-reveal>
					<h3><?=$language->line('passAss_reset_no_mach_pass_title')?></h3>
					<h5><?=$language->line('passAss_reset_no_mach_pass_msg')?></h5>
					<a class="close-reveal-modal">&#215;</a>
					</div>
					<div id="resetPass-success-reveal" class="reveal-modal small" data-reveal>
					<h3><?=$language->line('passAss_reset_no_mach_pass_title')?></h3>
					<h5><?=$language->line('passAss_reset_no_mach_pass_msg')?></h5>
					<a class="close-reveal-modal">&#215;</a>
					</div>
				</div>
			</div>
		</article>
	</div>
</div>

<div class="row">
	&nbsp;
</div>

<?php $this->load->view('partial/blogList.php'); ?>