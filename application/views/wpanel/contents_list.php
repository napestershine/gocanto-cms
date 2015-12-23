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

		<div class="panel radius" style="background-color: #F5F5F5;">
			<div class="row">
				<div class="large-12 medium-12 small-12 columns">
					<label>
						<strong>
							<?=$language->line('general_content_type_label')?>:
						</strong>	
						&nbsp;
					</label>
				</div>
			</div>

			<div class="row">
				&nbsp;
			</div>

			<div class="row">
				<div class="large-6 medium-6 small-6 columns">
					<select name="cboListContentFilter" class="large-10 columns" id="cboListContentFilter" domain = "<?=base_url()?>" >
						<?php 
                            foreach ($type_list as $value) {
                                $selected = '';
                                if (isset($type)) {
                                    $selected = $value == $type ? 'selected' : '';
                                } elseif ($value == 'Blog') {
                                    $selected = 'selected';
                                }
                                ?>
								<option value="<?=$value?>" <?=$selected?>><?=str_replace('_', ' ', $value)?></option>
						<?php 
                            } ?>
					</select>
				</div>
				<div class="large-6 medium-6 small-6 columns">
					&nbsp;
				</div>
			</div>	
		
			<div class="row">
				<div class="large-4 medium-4 small-4 columns">
					<button type="button" id="btnListContentAdd" name="btnListContentAdd" class="button radius tiny"  onclick="redirect('<?=base_url()?>content/add');" ><?=$language->line('general_content_add_new_content')?></button>
				</div>
				<div class="large-8 medium-8 small-8 columns">
					&nbsp;
				</div>
			</div>
		</div>

		<div class="row">
			&nbsp;
		</div>

		<div class="row">
			<div class="large-12 columns" id="out_ajax">
				<?php $this->load->view('wpanel/ajax/contents_list'); ?>
			</div>
		</div>

		<div class="row">
			<div class="large-12 columns">
				<div id="confirm-reveal" class="reveal-modal tiny" data-reveal>
					<h2><?=$language->line('general_delete_content')?></h2>
					<h5> <?=$language->line('general_delete_content_confirmation')?>  </h5>
					<p>&nbsp;</p>
					<p>
						<a href="<?=$config['not_click']?>" id="delete" class="button radius small alert"><?=$language->line('general_delete')?></a>
					</p>
					<a class="close-reveal-modal">&#215;</a>
				</div>
			</div>
		</div>

	</article>
</div>