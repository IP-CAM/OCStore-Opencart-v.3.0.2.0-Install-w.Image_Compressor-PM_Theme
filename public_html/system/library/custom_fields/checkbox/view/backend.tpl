	<div class="form-group">
		<label class="col-sm-2 control-label">
		<?php if($result['description']){ ?>
			<span data-toggle="tooltip" title="<?php echo $result['description']; ?>"><?php echo $result['name']; ?></span>
		<?php } else { ?>
			<?php echo $result['name']; ?>
		<?php } ?>
		</label>
		<div class="col-sm-10">
			<label><input type="checkbox" name="custom_field[<?php echo $result['custom_fields_id']; ?>][<?php echo $language['language_id']; ?>][value]" value="1" <?php if(isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['value']) && $data['custom_field'][$result['custom_fields_id']][$language['language_id']]['value']){ ?>checked<?php } ?>></label>
			
		</div>
	</div>