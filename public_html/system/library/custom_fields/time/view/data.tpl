<div class="form-group">
	<label class="col-sm-2 control-label"><?php echo $entry_format; ?></label>
	<div class="col-sm-10">
	  <input type="text" name="custom_field[dateformat]" value="<?php echo isset($result['dateformat'])?$result['dateformat']:'HH:mm'; ?>" placeholder="HH:mm" class="form-control" />
	</div>				
</div>