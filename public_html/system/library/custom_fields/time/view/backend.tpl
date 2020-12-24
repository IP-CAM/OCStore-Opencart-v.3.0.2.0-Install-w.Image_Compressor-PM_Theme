	<div class="form-group">
        <label class="col-sm-2 control-label">
		<?php if($result['description']){ ?>
			<span data-toggle="tooltip" title="<?php echo $result['description']; ?>"><?php echo $result['name']; ?></span>
		<?php } else { ?>
			<?php echo $result['name']; ?>
		<?php } ?>
		</label>
		<div class="col-sm-3">
		  <div class="input-group time">
			<input type="text" name="custom_field[<?php echo $result['custom_fields_id']; ?>][<?php echo $language['language_id']; ?>][text]" value="<?php echo isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']])?$data['custom_field'][$result['custom_fields_id']][$language['language_id']]['text']:''; ?>" placeholder="<?php echo $result['name']; ?>" data-date-format="<?php echo $result['data']['dateformat']; ?>" class="form-control" />
			<span class="input-group-btn">
			<button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
			</span>
		  </div>
		  <?php if (isset($error_custom_fields[$result['custom_fields_id']][$language['language_id']])) { ?>
			  <div class="text-danger"><?php echo $error_custom_fields[$result['custom_fields_id']][$language['language_id']]; ?></div>
			<?php } ?>
		</div>
	</div>
<script type="text/javascript"><!--
$('.time').datetimepicker({
	pickDate: false
});
//--></script>