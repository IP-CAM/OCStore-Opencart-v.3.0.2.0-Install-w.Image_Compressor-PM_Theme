	<div class="form-group">
		<label class="col-sm-2 control-label">
		<?php if($result['description']){ ?>
			<span data-toggle="tooltip" title="<?php echo $result['description']; ?>"><?php echo $result['name']; ?></span>
		<?php } else { ?>
			<?php echo $result['name']; ?>
		<?php } ?>
		</label>
		<div class="col-sm-10">
			<select name="custom_field[<?php echo $result['custom_fields_id']; ?>][<?php echo $language['language_id']; ?>][text]" class="form-control">
				<option value=""><?php echo $text_select; ?></option>
				<?php   $elements = explode(',', $result['data'][$language['language_id']]['elements']); ?>
				<?php $elements = array_map("trim", $elements); ?>
				<?php foreach($elements as $element){ ?>
					<?php if(isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['text']) && $data['custom_field'][$result['custom_fields_id']][$language['language_id']]['text']==$element){ ?>
					<option selected value="<?php echo $element; ?>"><?php echo $element; ?></option>
					<?php }else{ ?>
					<option value="<?php echo $element; ?>"><?php echo $element; ?></option>
					<?php } ?>
				<?php } ?>
            </select>
			<?php if (isset($error_custom_fields[$result['custom_fields_id']][$language['language_id']])) { ?>
			  <div class="text-danger"><?php echo $error_custom_fields[$result['custom_fields_id']][$language['language_id']]; ?></div>
			<?php } ?>
		</div>
	</div>