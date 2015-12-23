<?php
if (empty($wp_user) && $wp_user['id'] == '') {
    redirect(base_url().'wpanel');
    die();
    exit();
}
$successful_message = flash_message(['successful_message']);
if ($successful_message != '') {
    ?>
<div class="row">
	<div data-alert class="alert-box success radius">
	  <?=$successful_message?>
	  <a href="#" class="close">&times;</a>
	</div>
</div>
<?php 
} ?>
<div class="row">
 <?php if (!$is_closet && isset($id_dad)) {
    ?>
<button class="radius tiny right alert" data-reveal-id = "closeTicketModal" >
	<?=$language->line('tickets_close')?>
</button>
<div id="closeTicketModal" class="reveal-modal small" data-reveal>
	<h5><?=$language->line('tickets_close_confirm')?></h5>
	<a class="button radius tiny right alert" href="<?=base_url()?>tickets/close/<?=$id_dad?>" >
	<?=$language->line('tickets_close')?>
	</a>
	<a class="close-reveal-modal">&#215;</a>
</div>
<?php 
} elseif ($can_put_ticket && isset($id_dad)) {
    ?>
<div class="row">
	<a class="button radius tiny right secondary" id="reopenTicket" href="<?=base_url()?>tickets/reopen/<?=$id_dad?>" >
		<?=$language->line('tickets_reopen')?>
	</a>
</div>
<?php 
} ?>
<?php if (($can_put_ticket && !$is_closet) || $was_reopen) {
    ?>
<button class="radius tiny" 
		id="showDivForm"
		onclick="$(this).hide(); $('#divForm').show();" 
		style="<?=isset($id_dad) && validation_errors() == '' ? '' : 'display:none;'?>">
	<?=$language->line('tickets_add_response')?>
</button>
<?php 
} ?>
</div>
<?php if (($can_put_ticket && !$is_closet) || $was_reopen) {
    ?>
<div class="row panel radius" id="divForm" style="<?=isset($id_dad) && validation_errors() == '' ? 'display:none;' : ''?>">
	<?php
        if (!isset($id_dad)) {
            ?>
		<h3><?=$language->line('tickets_new_ticket')?></h3>
		<h5><small><?=$language->line('tickets_web_sumary')?>.</small></h5>
		<hr>
	<?php

        }
    ?>
		<div data-alert class="alert-box alert radius" style="<?=validation_errors() != '' ? '' : 'display:none;'?>">
		  <?=validation_errors()?>
		  <a href="#" class="close">&times;</a>
		</div>

			<div class="large-12 columns" >
			<?=form_open('tickets/insert', ['data-abide' => ''])?>
				<div class="row">
				<?php
            if (!isset($id_dad)) {
                if (isset($type) && $type != '') {
                    ?>
					<div class="large-3 medium-4 columns">
						<label><?=$language->line('general_type')?>:
							<select name="cboType" id="cboType" required>
								<?php foreach ($ticket_types as $value) {
    ?>
								<option value="<?=$value?>" <?=$type == $value ? 'selected' : ''?>><?=str_replace('_', ' ', $value)?></option>
								<?php 
}
                    ?>
							</select>
						</label>
					</div>
					<?php 
                }
                ?>
					<div class="large-3 medium-4 columns">
						<label><?=$language->line('tickets_priority')?>:
							<select name="cboPriority" id="cboPriority" required>
								<option value=""></option>
								<?php foreach ($ticket_priorities as $value) {
    ?>
								<option value="<?=$value?>" <?=set_value('cboPriority') == $value ? 'selected' : ''?>><?=str_replace('_', ' ', $value)?></option>
								<?php 
}
                ?>
							</select>
						</label>
						<small class="error radius"><?=$language->line('tickets_priority_required')?></small>
					</div>
					<div class="large-12 columns">
						<label><?=$language->line('tickets_subject')?>:
							<input type="text" name="txtSubject" id="txtSubject" placeholder="" value="<?=set_value('txtSubject')?>" required />
						</label>
						<small class="error radius"><?=$language->line('tickets_subject_required')?></small>
					</div>
			<?php 
            } else {
                ?>
					<input type="hidden" name="id_dad" id="id_dad" value="<?=$id_dad?>">
			<?php 
            }
    ?>
					<div class="large-12 columns">
						<label><?=$language->line('tickets_message')?>:
							<textarea name="txtMessage" id="txtMessage" cols="30" rows="10" required><?=set_value('txtMessage')?></textarea>
						</label>
						<small class="error radius"><?=$language->line('tickets_message_required')?></small>
					</div>
					<div class="large-12 columns">
						<button type="submit" class="radius <?=isset($id_dad) ? 'tiny' : 'small'?>"><?=$language->line(isset($id_dad) ? 'tickets_add_response' : 'tickets_send_ticket')?></button>
					</div>
				</div>
			</form>
		</div>
</div>
<div class="row">&nbsp;</div>
<?php 
} elseif (!$is_closet) {
    ?>
<div class="row">
	<div data-alert class="alert-box secondary radius">
	  <?=$language->line('tickets_in_process')?>
	</div>
</div>	
<?php 
} else {
    ?>
<div class="row">
	<div data-alert class="alert-box secondary radius">
	  <?=$language->line('tickets_closet_message')?>
	</div>
</div>	
<?php 
}
    if ($was_reopen) {
        ?>
<div class="row">	
	<div data-alert class="alert-box warning radius">
	  <?=$language->line('tickets_was_reopen')?>
	</div>
</div>	
<?php 
    } ?>	