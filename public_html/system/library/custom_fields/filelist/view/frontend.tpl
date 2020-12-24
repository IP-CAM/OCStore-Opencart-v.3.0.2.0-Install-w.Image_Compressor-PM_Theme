<div id="custom-fields-field-<?php echo $result['custom_fields_id']; ?>" class="custom-fields-field-<?php echo $result['custom_fields_id']; ?>">
	
	<?php foreach($custom_fields_files as $element){ ?>
		<?php if($element['file']){ ?>
			<a href="<?php echo $element['file']; ?>"><?php echo $element['name']; ?></a><br />
		<?php } ?>
	<?php } ?>

</div>
