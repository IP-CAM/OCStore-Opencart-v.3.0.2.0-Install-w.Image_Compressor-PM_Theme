	<div class="form-group">
		<label class="col-sm-2 control-label">
		<?php if($result['description']){ ?>
			<span data-toggle="tooltip" title="<?php echo $result['description']; ?>"><?php echo $result['name']; ?></span>
		<?php } else { ?>
			<?php echo $result['name']; ?>
		<?php } ?>
		</label>
		<div class="col-sm-10">
			<textarea id="custom_field-<?php echo $result['custom_fields_id']; ?>-<?php echo $language['language_id']; ?>" rows="10" name="custom_field[<?php echo $result['custom_fields_id']; ?>][<?php echo $language['language_id']; ?>][text]" placeholder="<?php echo $result['name']; ?>" class="form-control summernote"><?php echo isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['text'])?$data['custom_field'][$result['custom_fields_id']][$language['language_id']]['text']:''; ?></textarea>
			<?php if (isset($error_custom_fields[$result['custom_fields_id']][$language['language_id']])) { ?>
			  <div class="text-danger"><?php echo $error_custom_fields[$result['custom_fields_id']][$language['language_id']]; ?></div>
			<?php } ?>
		</div>
	</div>
<script type="text/javascript"><!--
	<?php if ($ckeditor) { ?>
		ckeditorInit('custom_field-<?php echo $result['custom_fields_id']; ?>-<?php echo $language['language_id']; ?>', getURLVar('token'));
	<?php } ?>
//--></script>