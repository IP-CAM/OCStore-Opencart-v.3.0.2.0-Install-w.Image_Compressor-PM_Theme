<div class="form-group">
	<label class="col-sm-2 control-label"><?php echo $entry_point_type; ?></label>
	<div class="col-sm-2">
	  <select name="custom_field[type]" class="form-control">
		<option value="google" <?php if(isset($result['type']) && $result['type']=='google'){ ?>selected<?php } ?>>Google</option>
		<option value="yandex" <?php if(isset($result['type']) && $result['type']=='yandex'){ ?>selected<?php } ?>>Yandex</option>
	  </select>
	</div>
	<div class="col-sm-4">
	  <input type="text" name="custom_field[apikey_google]" placeholder="<?php echo $entry_point_apikey_google; ?>" class="form-control" value="<?php echo isset($result['apikey_google'])?$result['apikey_google']:''; ?>" />
	</div>
	<div class="col-sm-4">
	  <input type="hidden" name="custom_field[apikey_yandex]" placeholder="<?php echo $entry_point_apikey_yandex; ?>" class="form-control" value="<?php echo isset($result['apikey_yandex'])?$result['apikey_yandex']:''; ?>" />
	</div>
</div>