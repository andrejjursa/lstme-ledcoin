<!doctype html>
<html>
<head>
		<meta charset="utf-8">
		<title>notes</title>
	
		<link rel="stylesheet" href="/assets/style.css">
</head>
<body>
<div id = "container">
	<?php
		$q= $this->db->get('den');
		$den=$q->result();
		echo validation_errors();
		
		echo form_open('notes/add');
		echo form_input('date');
		echo form_input('action_name');
		echo form_input('time');
		echo '<br>';
		echo form_textarea('text');
		echo form_submit('submit', 'pridaj');
		echo form_close();
		
		
		echo validation_errors();
		
		echo form_open('notes/del');
		echo form_input('date');
		echo form_submit('submit', 'odober');
		echo form_close();
		
		echo form_open('notes/zmen');
		echo form_input('id');
		echo form_submit('submit', 'vyber den');
		echo form_close();
		
	
	?>
		


	<ul>
	<?php 
	//if ($notes->is_empty()){}
	//else{
		foreach ($notes as $obj) : 
			foreach ($den as $object) :
			
					
		if (($obj->date==$object->id) || ($object->id==0)){?>
		<li>
		<?=$obj->date ?>
		<small>
		<?=$obj->time ?>
		</small>
		<strong>
		<?=$obj->action_name ?>
		</strong>

		<br>
		<?= $obj->text ?>
		</li>
		<?php 
		} 
		endforeach;
		endforeach;
	//}
	?>
	</ul>
</div>

</body>
</html>