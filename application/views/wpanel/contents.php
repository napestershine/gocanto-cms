<?php
if (empty($wp_user) && $wp_user['id']=='') {
    redirect(base_url().'wpanel');
    die();
    exit();
}
?>
<div class="row panel radius">
	<article>

		<h4 class="color_green"><?=formatString($content->title)?>
			<small>&nbsp;<?=$content->text_small?></small>
		</h4>
		<hr>

		<button type="button" name="btnSectionsSave" class="medium-2 large-2 columns button radius tiny btnSectionsSave"><?=$language->line('general_submit')?></button>
		
		<div data-alert class="alert-box radius large-12 columns" style="display:none">
			<h6 style="color:#fff"></h6>
			<a href="#" class="close">&times;</a>
		</div>

		<div class="row">
			<div class="large-12 medium-12 small-12 columns">

				<form data-abide name="frmSections" id="frmSections" action="<?=base_url()?>content/<?=(isset($new)?'insert':'update')?>" method="POST" enctype="multipart/form-data">

					<div class="row">
						<div class="large-12 medium-12 small-12 columns">
							<label><?=$language->line('general_add_content_title_label')?>:&nbsp;<small>(<?=$language->line('general_required')?>)</small>
								<input type="text" name="txtTitulo" size="140" id="txtTitulo" value="<?=isset($info->title)?$info->title:''?>" required />
							</label>
							<small class="error radius"><?=$language->line('general_add_content_title_error')?></small>
						</div>
					</div>
					
					<div class="row">
						<div class="medium-2 large-2 columns">
							<?php if (isset($info->icon)&&file_exists($info->icon)) {  ?>
							<img src="<?=base_url().$info->icon?>" width="60"  alt="">
							<?php } ?>
						</div>
						<div class="medium-3 large-3 columns">
							<label><?=$language->line('general_add_content_icon_label')?>:&nbsp;<small>(<?=$language->line('general_required')?>)</small></label>
							<label>
								<input type="file" name="icon" id="icon" />
							</label>
							<small class="error radius"><?=$language->line('general_add_content_icon_error')?></small>
						</div>
						<div class="medium-4 large-4 columns">
							<?php if (isset($info->image)&&file_exists($info->image)) { ?>
							<img src="<?=base_url().$info->image?>" width="200"  alt="">
							<?php }?>
						</div>
						<div class="medium-3 large-3 columns">
							<label><?=$language->line('general_add_content_image_label')?>:&nbsp;<small>(<?=$language->line('general_required')?>)</small></label>
							<label>
								<input type="file" name="image" id="image" />
							</label>
							<small class="error radius"><?=$language->line('general_add_content_image_error')?>:</small>
						</div>
					</div>

					<div class="row">
						<div class="large-12 medium-12 small-12 columns">
							<label><?=$language->line('general_add_content_summary_label')?>:&nbsp;<small>(<?=$language->line('general_required')?>)</small>
								<textarea name="txtSmallText" id="txtSmallText" required><?=isset($info->text_small)?$info->text_small:''?></textarea>
							</label>
							<small class="error"><?=$language->line('general_add_content_summary_error')?></small>
						</div>
					</div>
					
					<div class="row">
						<div class="large-12 medium-12 small-12 columns">
							<label><?=$language->line('general_add_content_body_label')?>:&nbsp;<small>(<?=$language->line('general_required')?>)</label>
						</div>
					</div>
					

					<div class="row">
						<div class="large-12 medium-12 small-12 columns">
							<textarea name="body" id="body" rows="10" cols="80"><?=isset($info->body)?$info->body:''?></textarea>
						</div>
					</div>

					<div class="row">&nbsp;</div>

					<div class="row">
						<div class="large-4 columns">
							<label><?=$language->line('general_add_content_author_label')?>:&nbsp;<small>(<?=$language->line('general_required')?>)</small>
								<input type="text" name="txtAuthor" id="txtAuthor" value="<?=isset($info->author)?$info->author:$companyInfo->name?>" required >
							</label>
							<small class="error"><?=$language->line('general_add_content_author_error')?></small>
						</div>
						<div class="large-3 columns">
							<label><?=$language->line('general_add_content_type_label')?>:&nbsp;<small>(<?=$language->line('general_required')?>)</small>&nbsp;
								<select name="cboType" id="cboType" required >
									<option value="" selected>---</option>
									<?php 
										foreach ($type_list as $type) {
									    $selected='3';
									    if (isset($info->type)) {
									        $selected=$info->type;
									    }
								    ?>
									<option value="<?=$type?>" <?=$selected==$type?'selected':''?> ><?=str_replace('_', ' ', $type)?></option>
									<?php } ?>
								</select>
							</label>
							<small class="error"><?=$language->line('general_add_content_type_error')?></small>
						</div>
						<div class="large-3 columns">
							<label><?=$language->line('general_add_content_satus_label')?>:&nbsp;<small>(<?=$language->line('general_required')?>)</small>
								<select name="cboStatus" id="cboStatus" required >
									<?php
	                                $status=1;
	                                if (isset($info->id_status)) {
	                                    $status=$info->id_status;
	                                }
	                                ?>
									<option value="1" <?=$status!='2'?'selected':''?> >Activo</option>
									<option value="2" <?=$status=='2'?'selected':''?> >Inactivo</option>
								</select>
							</label>
							<small class="error"><?=$language->line('general_add_content_satus_error')?></small>
						</div>
						
					</div>
					
					<hr>

					<div class="row">
						<div class="large-12 medium-12 small-12 columns">
							<button type="button" name="btnSectionsSave" class="medium-2 large-2 columns button radius tiny btnSectionsSave"><?=$language->line('general_submit')?></button>
							<input type="hidden" name="id" id="id" value="<?=isset($info->id)?$info->id:''?>" >
							<input type="hidden" name="old_icon" id="old_icon" value="<?=isset($info->icon)?$info->icon:''?>" >
							<input type="hidden" name="old_image" id="old_image" value="<?=isset($info->image)?$info->image:''?>" >
						</div>
					</div>
				</form>

			</div>
		</div>

	</article>
</div>