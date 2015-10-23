<table>
	<thead>
		<tr>
			<th><?=$language->line('general_title')?></th>
			<th><?=$language->line('general_intro')?></th>
			<th><?=$language->line('general_update')?></th>
			<th><?=$language->line('general_actions')?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($contents_list as $array) {
    ?>
		<tr id="tr_<?=$array['id']?>">
			<td width="50%"><?=formatString($array['title'])?></td>
			<td width="30%"><small><?=substr($array['text_small'], 0, 100)?>&nbsp;...</small> </td>
			<td width="10%"><small><?=formatDate($array['date'])?></small></td>
			<td width="10%">
				<img width="30%" src="<?=base_url()?>img/edit.png" alt="edit" class="cursor_pointer" onclick="redirect('<?=base_url()?>content/manage/<?=$array['id']?>');">
				<img width="30%" src="<?=base_url()?>img/trash.png" alt="trash" class="cursor_pointer" onclick="deleteRecord(<?=$array['id']?>,'<?=formatString($array['title'])?>')">
				<img width="30%" src="<?=base_url().'img/'.($array['id_status']==1?'Checked.png':'Unchecked.png')?>" alt="Status" class="cursor_pointer img_<?=$array['id']?>" onclick="status_change('<?=base_url()?>content/status/',<?=$array['id']?>)">
			    <input type="hidden" name="status_<?=$array['id']?>" id="status_<?=$array['id']?>" value="<?=$array['id_status']?>">
			</td>
		</tr>
		<?php

} ?>
	</tbody>
</table>