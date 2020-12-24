<fieldset>
	<legend><?php echo $entry_sizes; ?></legend>
	<div class="form-group required">
	  <label class="col-sm-2 control-label"><?php echo $entry_preview; ?></label>
	  <div class="col-sm-10">
		<div class="row">
		  <div class="col-sm-6">
			<input type="text" name="custom_field[preview_width]" value="<?php echo isset($result['preview_width'])?$result['preview_width']:''; ?>" placeholder="<?php echo $text_width; ?>" class="form-control">
		  </div>
		  <div class="col-sm-6">
			<input type="text" name="custom_field[preview_height]" value="<?php echo isset($result['preview_height'])?$result['preview_height']:''; ?>" placeholder="<?php echo $text_height; ?>" class="form-control">
		  </div>
		</div>
	  </div>
	</div>
	<div class="form-group required">
	  <label class="col-sm-2 control-label"><?php echo $entry_popup; ?></label>
	  <div class="col-sm-10">
		<div class="row">
		  <div class="col-sm-6">
			<input type="text" name="custom_field[popup_width]" value="<?php echo isset($result['popup_width'])?$result['popup_width']:''; ?>" placeholder="<?php echo $text_width; ?>" class="form-control">
		  </div>
		  <div class="col-sm-6">
			<input type="text" name="custom_field[popup_height]" value="<?php echo isset($result['popup_height'])?$result['popup_height']:''; ?>" placeholder="<?php echo $text_height; ?>" class="form-control">
		  </div>
		</div>
	  </div>
	</div>
</fieldset>