<?php $this->lang->load('emails', $language); ?>
<table cellpadding="0" cellspacing="0" style="margin-top: 20px; font-family: 'Lato', sans-serif; font-style: normal; font-weight: normal; width: 100%; background-color: #E9EAED;height: 100%;border-radius: 3px;">
	<tr>
		<td width="200" style="background-color: #2B7FE9; height: 60px; padding-left: 20px; border-top-left-radius:3px;">
			<img src="<?=$config['domain']?>/img/logo_w.png" style="width: 200px;" alt="w-simple">
		</td>
		<td style="background-color: #2B7FE9; border-top-right-radius:3px; padding: 10px 0 0 10px; color: #FFF;">
			<?=$title?>
		</td>
	</tr>
	<tr>
		<td colspan="2" style=" vertical-align: top; padding: 20px; height: 400px">
			<table align="center" style="width: 90%; background-color: #FFF; border-radius: 3px;">
				<?php if (isset($name) && trim($name) != '') {
    ?>
				<tr>
					<td style="padding:10px;"><?=$this->lang->line('email_dear')?>&nbsp;<strong><?=$name?></strong>,</td>
				</tr>
				<?php 
} ?>
				<tr>
					<td style="padding:10px;"><?=$content?></td>
				</tr>
				<tr>
					<td style="padding:10px; font-size: 12px; color: #E95220"><?=$this->lang->line('email_thanks')?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<div align="center"  style="font-family: 'Lato', sans-serif; font-style: normal; font-weight: normal; width: 100%; font-size: 12px; height: 30px; color: #999999; padding-top: 10px;">
	<div style="float: left">
		<a href="<?=base_url()?>content/body/about-us"><?=$this->lang->line('email_footer_about')?></a>&nbsp;/&nbsp;  
		<a href="<?=base_url()?>content/body/services"><?=$this->lang->line('email_footer_services')?></a>&nbsp;/&nbsp;  
		<a href="<?=base_url()?>content/body/22"><?=$this->lang->line('email_footer_antvel')?></a>&nbsp;/&nbsp;  
		<a href="<?=base_url()?>content/body/23"><?=$this->lang->line('email_footer_attendance')?></a>&nbsp;/&nbsp;  
		<a href="<?=base_url()?>content/body/24"><?=$this->lang->line('email_footer_cms')?></a>&nbsp;/&nbsp;  
		<a href="<?=base_url()?>content/body/contact-us"><?=$this->lang->line('email_footer_contact')?></a>
	</div>
	<div style="float: right">
		<?=$this->lang->line('email_footer_powered')?>&nbsp;<a href="<?=$config['domain']?>"><?=$this->lang->line('email_footer_brand')?></a>
	</div>
</div>