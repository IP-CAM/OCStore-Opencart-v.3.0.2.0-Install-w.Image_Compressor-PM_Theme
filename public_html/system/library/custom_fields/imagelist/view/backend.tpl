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
			<table id="custom_field_images-<?php echo $result['custom_fields_id']; ?>-<?php echo $language['language_id']; ?>" class="table table-striped table-bordered table-hover">
			  <thead>
				<tr>
				  <td class="text-center"><?php echo $entry_image; ?></td>
				  <td class="text-right"><?php echo $entry_mode; ?></td>
				  <td class="text-right"><?php echo $entry_link; ?></td>
				  <td class="text-right"><?php echo $entry_new; ?></td>
				  <td class="text-center"></td>
				</tr>
			  </thead>
			  <tbody id="custom_field_images-sortable-<?php echo $language['language_id']; ?>-<?php echo $result['custom_fields_id']; ?>">
				<?php $custom_field_image_row[$result['custom_fields_id']][$language['language_id']] = 0; ?>
				<?php foreach ($custom_fields_images as $element) { ?>
				<tr id="custom_field_image-row-<?php echo $result['custom_fields_id']; ?>-<?php echo $language['language_id']; ?>-<?php echo $custom_field_image_row[$result['custom_fields_id']][$language['language_id']]; ?>">
				  <td class="text-center">
				  <a href="" id="thumb-image-<?php echo $result['custom_fields_id']; ?>-<?php echo $language['language_id']; ?>-<?php echo $custom_field_image_row[$result['custom_fields_id']][$language['language_id']]; ?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo $element['thumb']; ?>" alt="" title="" data-placeholder="<?php echo $custom_fields_placeholder; ?>" /></a>
					<input type="hidden" name="custom_field[<?php echo $result['custom_fields_id']; ?>][<?php echo $language['language_id']; ?>][imagelist][<?php echo $custom_field_image_row[$result['custom_fields_id']][$language['language_id']]; ?>][image]" value="<?php echo $element['image']; ?>" id="input-image-<?php echo $result['custom_fields_id']; ?>-<?php echo $language['language_id']; ?>-<?php echo $custom_field_image_row[$result['custom_fields_id']][$language['language_id']]; ?>" />
				  </td>
				  <td class="text-right">
				  <select name="custom_field[<?php echo $result['custom_fields_id']; ?>][<?php echo $language['language_id']; ?>][imagelist][<?php echo $custom_field_image_row[$result['custom_fields_id']][$language['language_id']]; ?>][mode]" class="form-control">
						<option value="1" <?php if(isset($element['mode']) && $element['mode']==1){ ?>selected="selected"<?php } ?>><?php echo $text_mode1; ?></option>
						<option value="2" <?php if(isset($element['mode']) && $element['mode']==2){ ?>selected="selected"<?php } ?>><?php echo $text_mode2; ?></option>
						<option value="3" <?php if(isset($element['mode']) && $element['mode']==3){ ?>selected="selected"<?php } ?>><?php echo $text_mode3; ?></option>
					</select>
				  </td>
				  <td class="text-right">
					<input type="text" name="custom_field[<?php echo $result['custom_fields_id']; ?>][<?php echo $language['language_id']; ?>][imagelist][<?php echo $custom_field_image_row[$result['custom_fields_id']][$language['language_id']]; ?>][link]" value="<?php echo isset($element['link'])?$element['link']:''; ?>" placeholder="<?php echo $entry_link; ?>" class="form-control" />
				  </td>
				  <td class="text-right">
					<select name="custom_field[<?php echo $result['custom_fields_id']; ?>][<?php echo $language['language_id']; ?>][imagelist][<?php echo $custom_field_image_row[$result['custom_fields_id']][$language['language_id']]; ?>][new]" class="form-control">
						<option value="0" <?php if(isset($element['new']) && $element['new']==0){ ?>selected="selected"<?php } ?>><?php echo $text_no; ?></option>
						<option value="1" <?php if(isset($element['new']) && $element['new']==1){ ?>selected="selected"<?php } ?>><?php echo $text_yes; ?></option>
					</select>
				  </td>
				  <td class="text-center">
				  <button type="button" onclick="$('#custom_field_image-row-<?php echo $result['custom_fields_id']; ?>-<?php echo $language['language_id']; ?>-<?php echo $custom_field_image_row[$result['custom_fields_id']][$language['language_id']]; ?>').remove();" title="<?php echo $button_image_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>
				  </td>
				</tr>
				<?php $custom_field_image_row[$result['custom_fields_id']][$language['language_id']]++; ?>
				<?php } ?>
			  </tbody>
			  <tfoot>
				<tr>
				  <td colspan="4"></td>
				  <td class="text-center"><button type="button" onclick="custom_fieldAddImage(<?php echo $result['custom_fields_id']; ?>, <?php echo $language['language_id']; ?>);"  title="<?php echo $button_image_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
				</tr>
			  </tfoot>
			</table>
			<?php if (isset($error_custom_fields[$result['custom_fields_id']][$language['language_id']])) { ?>
			  <div class="text-danger"><?php echo $error_custom_fields[$result['custom_fields_id']][$language['language_id']]; ?></div>
			<?php } ?>
		</div>
	</div>
</div>	

<script type="text/javascript"><!--
if (typeof jQuery.ui === 'undefined') {
	$.getScript( "view/javascript/jquery/jquery-ui/jquery-ui.min.js", function( data, textStatus, jqxhr ) {
		$( "#custom_field_images-sortable-<?php echo $language['language_id']; ?>-<?php echo $result['custom_fields_id']; ?>" ).sortable();
		$( "#custom_field_images-sortable-<?php echo $language['language_id']; ?>-<?php echo $result['custom_fields_id']; ?>" ).disableSelection();
	});
}else{
	$( "#custom_field_images-sortable-<?php echo $language['language_id']; ?>-<?php echo $result['custom_fields_id']; ?>" ).sortable();
	$( "#custom_field_images-sortable-<?php echo $language['language_id']; ?>-<?php echo $result['custom_fields_id']; ?>" ).disableSelection();
}

//--></script>	

<script type="text/javascript"><!--
var custom_field_image_row_<?php echo $result['custom_fields_id']; ?>_<?php echo $language['language_id']; ?> = <?php echo $custom_field_image_row[$result['custom_fields_id']][$language['language_id']]; ?>;
if (typeof custom_fieldAddImage !== 'function'){
	function custom_fieldAddImage(custom_fields_id, language_id) {
		html  = '<tr id="custom_field_image-row-'+custom_fields_id+'-'+language_id+'-' + eval('custom_field_image_row'+'_'+custom_fields_id+'_'+language_id) + '">';
		html += '  <td class="text-center"><a href="" id="thumb-image-'+custom_fields_id+'-'+language_id+'-' + eval('custom_field_image_row'+'_'+custom_fields_id+'_'+language_id) + '" data-toggle="image" class="img-thumbnail"><img src="<?php echo $custom_fields_placeholder; ?>" alt="" title="" data-placeholder="<?php echo $custom_fields_placeholder; ?>" /></a><input type="hidden" name="custom_field['+custom_fields_id+']['+language_id+'][imagelist][' + eval('custom_field_image_row'+'_'+custom_fields_id+'_'+language_id) + '][image]" value="<?php echo $element['image']; ?>" id="input-image-'+custom_fields_id+'-'+language_id+'-' + eval('custom_field_image_row'+'_'+custom_fields_id+'_'+language_id) + '" /></td>';
		html += '  <td class="text-right"><select name="custom_field['+custom_fields_id+']['+language_id+'][imagelist][' + eval('custom_field_image_row'+'_'+custom_fields_id+'_'+language_id) + '][mode]" class="form-control"><option value="1"><?php echo $text_mode1; ?></option><option value="2"><?php echo $text_mode2; ?></option><option value="3"><?php echo $text_mode3; ?></option></select></td>';
		html += '  <td class="text-right"><input type="text" name="custom_field['+custom_fields_id+']['+language_id+'][imagelist][' + eval('custom_field_image_row'+'_'+custom_fields_id+'_'+language_id) + '][link]" value="" placeholder="<?php echo $entry_link; ?>" class="form-control" /></td>';
		html += '  <td class="text-right"><select name="custom_field['+custom_fields_id+']['+language_id+'][imagelist][' + eval('custom_field_image_row'+'_'+custom_fields_id+'_'+language_id) + '][new]" class="form-control"><option value="0"><?php echo $text_no; ?></option><option value="1"><?php echo $text_yes; ?></option></select></td>';
		html += '  <td class="text-center"><button type="button" onclick="$(\'#custom_field_image-row-'+custom_fields_id+'-'+language_id+'-' + eval('custom_field_image_row'+'_'+custom_fields_id+'_'+language_id)  + '\').remove();" title="<?php echo $button_image_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
		html += '</tr>';
		
		$('#custom_field_images-'+custom_fields_id+'-'+language_id+' tbody').append(html);

		eval('custom_field_image_row'+'_'+custom_fields_id+'_'+language_id+'++');
	}
}
//--></script>	