	<div class="form-group" style="display:none;">
		<label class="col-sm-2 control-label">
		<?php if($result['description']){ ?>
			<span data-toggle="tooltip" title="<?php echo $result['description']; ?>"><?php echo $result['name']; ?></span>
		<?php } else { ?>
			<?php echo $result['name']; ?>
		<?php } ?>
		</label>
		<div class="col-sm-10">
			<label><input type="checkbox" name="custom_field[<?php echo $result['custom_fields_id']; ?>][<?php echo $language['language_id']; ?>][value]" value="1" checked ></label>
			
		</div>
	</div>