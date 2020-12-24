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
				  <td class="text-center"><?php echo $entry_image; ?></td>
				  <td class="text-right"><?php echo $entry_mode; ?></td>
				  <td class="text-right"><?php echo $entry_link; ?></td>
				  <td class="text-right"><?php echo $entry_new; ?></td>
				</tr>
			  </thead>
			  <tbody>
				<tr>
				  <td class="text-center">
				  <a href="" id="thumb-image-<?php echo $result['custom_fields_id']; ?>-<?php echo $language['language_id']; ?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo $custom_fields_thumb; ?>" alt="" title="" data-placeholder="<?php echo $custom_fields_placeholder; ?>" /></a>
					<input type="hidden" name="custom_field[<?php echo $result['custom_fields_id']; ?>][<?php echo $language['language_id']; ?>][image]" value="<?php echo $custom_fields_image; ?>" id="input-image-<?php echo $result['custom_fields_id']; ?>-<?php echo $language['language_id']; ?>" />
				  </td>
				  <td class="text-right">
				  <select name="custom_field[<?php echo $result['custom_fields_id']; ?>][<?php echo $language['language_id']; ?>][mode]" class="form-control">
					<option value="1" <?php if(isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['mode']) && $data['custom_field'][$result['custom_fields_id']][$language['language_id']]['mode']==1){ ?>selected="selected"<?php } ?>><?php echo $text_mode1; ?></option>
					<option value="2" <?php if(isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['mode']) && $data['custom_field'][$result['custom_fields_id']][$language['language_id']]['mode']==2){ ?>selected="selected"<?php } ?>><?php echo $text_mode2; ?></option>
					<option value="3" <?php if(isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['mode']) && $data['custom_field'][$result['custom_fields_id']][$language['language_id']]['mode']==3){ ?>selected="selected"<?php } ?>><?php echo $text_mode3; ?></option>
				</select>
				  </td>
				  <td class="text-right">
					<input type="text" name="custom_field[<?php echo $result['custom_fields_id']; ?>][<?php echo $language['language_id']; ?>][link]" value="<?php echo isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['link'])?$data['custom_field'][$result['custom_fields_id']][$language['language_id']]['link']:''; ?>" placeholder="<?php echo $entry_link; ?>" class="form-control" />
				  </td>
				  <td class="text-right">
					<select name="custom_field[<?php echo $result['custom_fields_id']; ?>][<?php echo $language['language_id']; ?>][new]" class="form-control">
						<option value="0" <?php if(isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['new']) && $data['custom_field'][$result['custom_fields_id']][$language['language_id']]['new']==0){ ?>selected="selected"<?php } ?>><?php echo $text_no; ?></option>
						<option value="1" <?php if(isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['new']) && $data['custom_field'][$result['custom_fields_id']][$language['language_id']]['new']==1){ ?>selected="selected"<?php } ?>><?php echo $text_yes; ?></option>
					</select>
				  </td>
				  
				</tr>
			  </tbody>
			  <tfoot>
				<tr>
				  <td colspan="4"></td>
				</tr>
			  </tfoot>
			</table>
			<?php if (isset($error_custom_fields[$result['custom_fields_id']][$language['language_id']])) { ?>
			  <div class="text-danger"><?php echo $error_custom_fields[$result['custom_fields_id']][$language['language_id']]; ?></div>
			<?php } ?>
		</div>
	</div>
</div>	