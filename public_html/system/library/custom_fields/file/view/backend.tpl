<div class="form-group">
	<label class="col-sm-2 control-label">
	<?php if($result['description']){ ?>
		<span data-toggle="tooltip" title="<?php echo $result['description']; ?>"><?php echo $result['name']; ?></span>
	<?php } else { ?>
		<?php echo $result['name']; ?>
	<?php } ?>:
	</label>
	<div class="col-sm-10">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
			  <thead>
				<tr>
				  <td class="text-center"><?php echo $entry_name; ?></td>
				  <td class="text-right"><?php echo $entry_file; ?></td>
				</tr>
			  </thead>
			  <tbody>
				<tr>
				  <td>
					<input type="text" name="custom_field[<?php echo $result['custom_fields_id']; ?>][<?php echo $language['language_id']; ?>][name]" id="input-file-text-<?php echo $result['custom_fields_id']; ?>-<?php echo $language['language_id']; ?>" value="<?php echo isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['name'])?$data['custom_field'][$result['custom_fields_id']][$language['language_id']]['name']:''; ?>" placeholder="<?php echo $entry_name; ?>" class="form-control" />
				  </td>
				  <td class="text-left">
				  
				  <a id="select-file-<?php echo $result['custom_fields_id']; ?>-<?php echo $language['language_id']; ?>" type="button" onclick="" data-toggle="file" data-placeholder="<?php echo $text_select_file; ?>" class="btn btn-primary"><?php echo $custom_fields_file?$custom_fields_file:$text_select_file; ?></a>
				  
					<input type="hidden" name="custom_field[<?php echo $result['custom_fields_id']; ?>][<?php echo $language['language_id']; ?>][file]" value="<?php echo $custom_fields_file; ?>" id="input-file-<?php echo $result['custom_fields_id']; ?>-<?php echo $language['language_id']; ?>" />
				  </td>
				</tr>
			  </tbody>
			  <tfoot>
				<tr>
				  <td colspan="2"></td>
				</tr>
			  </tfoot>
			</table>
			<?php if (isset($error_custom_fields[$result['custom_fields_id']][$language['language_id']])) { ?>
			  <div class="text-danger"><?php echo $error_custom_fields[$result['custom_fields_id']][$language['language_id']]; ?></div>
			<?php } ?>
		</div>
	</div>
</div>
<script>
$('#input-file-<?php echo $result['custom_fields_id']; ?>-<?php echo $language['language_id']; ?>').change(function(){
	$('#input-file-text-<?php echo $result['custom_fields_id']; ?>-<?php echo $language['language_id']; ?>').val($(this).parent().find('#select-file-<?php echo $result['custom_fields_id']; ?>-<?php echo $language['language_id']; ?>').html());
});
</script>