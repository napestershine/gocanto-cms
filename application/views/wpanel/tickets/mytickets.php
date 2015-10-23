<?php
if (empty($wp_user) && $wp_user['id']=='') {
    redirect(base_url().'wpanel');
    die();
    exit();
}
?>
<div class="row panel radius">
	<article>
		<h3><?=$language->line('tickets_web_title')?></h3>
		<h5><small><?=$language->line('tickets_web_sumary')?></small></h5>
		<hr>
		<div class="row">
			<div class="large-12 columns">
			<button data-dropdown="drop" aria-controls="drop", aria-expanded="false" class="<?=$can_put_ticket?'':'disabled'?> radius tiny button dropdown">
			<?=$language->line('tickets_new_ticket')?>
			</button><br>
			<?php if ($can_put_ticket) { ?>
			<ul id="drop" class="f-dropdown" data-dropdown-content>
				<?php foreach ($ticket_types as $value) {?>
				<li><a href="<?=base_url().'tickets/add/'.$value?>"><?=str_replace('_', ' ', $value)?></a></li>
				<?php } ?>
			</ul>
			<?php }else{ ?>
				<div data-alert class="alert-box secondary radius"><?=$language->line('tickets_in_process')?></div>
			<?php } ?>
			</div>
		<?php			
		$successful_message=flash_message(['successful_message']);
		if ($successful_message!='') {?>
		<div class="large-12 columns">
			<div data-alert class="alert-box success radius">
			  <?=$successful_message?>
			  <a href="#" class="close">&times;</a>
			</div>
		</div>
		 <?php } ?>
		</div>
		<div class="row">
			
			<div class="large-12 columns">
				<table width="100%">
					<thead>
						<tr>
							<th><?=$language->line('tickets_ticket_id')?></th>
							<th><?=$language->line('tickets_status')?></th>
							<th><?=$language->line('general_type')?></th>
							<th><?=$language->line('tickets_priority')?></th>
							<th><?=$language->line('tickets_subject')?></th>
							<th><?=$language->line('tickets_date')?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($tickets as $array) {?>
						<tr id="tr_<?=$array['id']?>">
							<td><a href="<?=base_url().'tickets/issues/'.$array['id']?>">#<?=$array['id']?></a></td>
							<td><?=str_replace('_', ' ', $array['status'])?></td>
							<td><?=str_replace('_', ' ', $array['type'])?></td>
							<?php
                                switch ($array['priority']) {
                                    case 'Low':
                                        $classLabel='secondary';
                                        break;
                                    case 'Normal':
                                        $classLabel='warning';
                                        break;
                                    case 'High':
                                        $classLabel='alert';
                                        break;
                                    default:
                                        $classLabel='secondary';
                                        break;
                                }?>
							<td><span class='label radius <?=$classLabel?>'><?=str_replace('_', ' ', $array['priority'])?></span></td>
							<td><small><?=formatString($array['subject'])?></small> </td>
							<td><small><?=$array['datetime']?></small></td>
						</tr>
						<?php }

                        if (count($tickets)==0) {
                            echo "<tr> <td colspan='6'><h2 >".$language->line('tickets_no_ticket_to_show')."</h2></td> </tr>";
                        }
                        ?>
					</tbody>
				</table>
			</div>
		</div>
	</article>
</div>