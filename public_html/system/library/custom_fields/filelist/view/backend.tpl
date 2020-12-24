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
			<table id="custom_field_files-<?php echo $result['custom_fields_id']; ?>-<?php echo $language['language_id']; ?>" class="table table-striped table-bordered table-hover">
			  <thead>
				<tr>
				  <td class="text-center"><?php echo $entry_name; ?></td>
				  <td class="text-right"><?php echo $entry_file; ?></td>
				  <td class="text-right"></td>
				</tr>
			  </thead>
			  <tbody id="custom_field_files-sortable-<?php echo $result['custom_fields_id']; ?>-<?php echo $language['language_id']; ?>">
				<?php $custom_field_file_row[ $result['custom_fields_id']][$language['language_id']] = 0; ?>
				<?php foreach ($custom_fields_files as $element) { ?>
				<tr id="custom_field_file-row-<?php echo $result['custom_fields_id']; ?>-<?php echo $language['language_id']; ?>-<?php echo $custom_field_file_row[ $result['custom_fields_id']][$language['language_id']]; ?>">
				
				  <td>
					<input type="text" name="custom_field[<?php echo $result['custom_fields_id']; ?>][<?php echo $language['language_id']; ?>][filelist][<?php echo $custom_field_file_row[ $result['custom_fields_id']][$language['language_id']]; ?>][name]" value="<?php echo $element['name']; ?>" class="form-control" id="input-file-text-<?php echo $result['custom_fields_id']; ?>-<?php echo $language['language_id']; ?>-<?php echo $custom_field_file_row[ $result['custom_fields_id']][$language['language_id']]; ?>"  />
				  </td>
				  <td class="text-left">
				  
				    <a id="select-file-<?php echo $result['custom_fields_id']; ?>-<?php echo $language['language_id']; ?>-<?php echo $custom_field_file_row[ $result['custom_fields_id']][$language['language_id']]; ?>" type="button" onclick="" data-toggle="file" data-placeholder="<?php echo $text_select_file; ?>" class="btn btn-primary"><?php echo $element['file']; ?></a>
				  
					<input onchange="$('#input-file-text-<?php echo $result['custom_fields_id']; ?>-<?php echo $language['language_id']; ?>-<?php echo $custom_field_file_row[ $result['custom_fields_id']][$language['language_id']]; ?>').val($(this).val());" type="hidden" name="custom_field[<?php echo $result['custom_fields_id']; ?>][<?php echo $language['language_id']; ?>][filelist][<?php echo $custom_field_file_row[ $result['custom_fields_id']][$language['language_id']]; ?>][file]" value="<?php echo $element['file']; ?>" id="input-file-<?php echo $result['custom_fields_id']; ?>-<?php echo $language['language_id']; ?>-<?php echo $custom_field_file_row[ $result['custom_fields_id']][$language['language_id']]; ?>" />
				  </td>
				
				 
				  <td class="text-center">
				  <button type="button" onclick="$('#custom_field_file-row-<?php echo $result['custom_fields_id']; ?>-<?php echo $language['language_id']; ?>-<?php echo $custom_field_file_row[ $result['custom_fields_id']][$language['language_id']]; ?>').remove();" title="<?php echo $button_file_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>
				  </td>
				</tr>
				<?php $custom_field_file_row[ $result['custom_fields_id']][$language['language_id']]++; ?>
				<?php } ?>
			  </tbody>
			  <tfoot>
				<tr>
				  <td colspan="2"></td>
				  <td class="text-center"><button type="button" onclick="custom_fieldAddFile(<?php echo $result['custom_fields_id']; ?>, <?php echo $language['language_id']; ?>);"  title="<?php echo $button_file_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
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
$(document).ready(function() {
	if (typeof jQuery.ui === 'undefined') {
		$.getScript( "view/javascript/jquery/jquery-ui/jquery-ui.min.js", function( data, textStatus, jqxhr ) {
			$( "#custom_field_files-sortable-<?php echo $result['custom_fields_id']; ?>-<?php echo $language['language_id']; ?>" ).sortable();
			$( "#custom_field_files-sortable-<?php echo $result['custom_fields_id']; ?>-<?php echo $language['language_id']; ?>" ).disableSelection();
		});
	}else{
		$( "#custom_field_files-sortable-<?php echo $result['custom_fields_id']; ?>-<?php echo $language['language_id']; ?>" ).sortable();
		$( "#custom_field_files-sortable-<?php echo $result['custom_fields_id']; ?>-<?php echo $language['language_id']; ?>" ).disableSelection();
	}
});
//--></script>	

<script type="text/javascript"><!--
var custom_field_file_row_<?php echo $result['custom_fields_id']; ?>_<?php echo $language['language_id']; ?> = <?php echo $custom_field_file_row[$result['custom_fields_id']][$language['language_id']]; ?>;
if (typeof custom_fieldAddFile !== 'function'){
	function custom_fieldAddFile(custom_fields_id, language_id) {
		html  = '<tr id="custom_field_file-row-'+custom_fields_id+'-'+language_id+'-'+eval('custom_field_file_row'+'_'+custom_fields_id+'_'+language_id)+'">';
		html += '<td>';
		html += '<input type="text" name="custom_field['+custom_fields_id+']['+language_id+'][filelist]['+eval('custom_field_file_row'+'_'+custom_fields_id+'_'+language_id)+'][name]" value="" class="form-control" id="input-file-text-'+custom_fields_id+'-'+language_id+'-'+eval('custom_field_file_row'+'_'+custom_fields_id+'_'+language_id)+'" />';
		html += '</td>';
		html += '<td class="text-left">';
		html += '<a id="select-file-'+custom_fields_id+'-'+language_id+'-'+eval('custom_field_file_row'+'_'+custom_fields_id+'_'+language_id)+'" type="button" onclick="" data-toggle="file" data-placeholder="<?php echo $text_select_file; ?>" class="btn btn-primary"><?php echo $text_select_file; ?></a>';
		html += '<input onchange="$(\'#input-file-text-'+custom_fields_id+'-'+language_id+'-'+eval('custom_field_file_row'+'_'+custom_fields_id+'_'+language_id)+'\').val($(this).val());" type="hidden" name="custom_field['+custom_fields_id+']['+language_id+'][filelist]['+eval('custom_field_file_row'+'_'+custom_fields_id+'_'+language_id)+'][file]" value="" id="input-file-'+custom_fields_id+'-'+language_id+'-'+eval('custom_field_file_row'+'_'+custom_fields_id+'_'+language_id)+'" />';
		html += '</td>';
		html += '<td class="text-center">';
		html += '<button type="button" onclick="$(\'#custom_field_file-row-'+custom_fields_id+'-'+language_id+'-'+eval('custom_field_file_row'+'_'+custom_fields_id+'_'+language_id)+'\').remove();" data-toggle="tooltip" title="<?php echo $button_file_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>';
		html += '</td>';
		html += '</tr>';
		
		$('#custom_field_files-'+custom_fields_id+'-'+language_id+' tbody').append(html);

		eval('custom_field_file_row'+'_'+custom_fields_id+'_'+language_id+'++');
	}
}
//--></script>	