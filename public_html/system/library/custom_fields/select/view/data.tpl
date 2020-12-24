<ul class="nav nav-tabs" id="language-custom-field-select">
	<?php foreach ($languages as $language) { ?>
	<li><a href="#language-custom-field-select<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
	<?php } ?>
</ul>
<div class="tab-content">
	<?php foreach ($languages as $language) { ?>
	<div class="tab-pane" id="language-custom-field-select<?php echo $language['language_id']; ?>">
		<div class="form-group">
			<label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $entry_elements_help; ?>"><?php echo $entry_elements; ?></span></label>
			  <textarea rows="3" name="custom_field[<?php echo $language['language_id']; ?>][elements]" placeholder="<?php echo $entry_elements; ?>" class="form-control summernote"><?php echo isset($result[$language['language_id']]['elements'])?$result[$language['language_id']]['elements']:''; ?></textarea>			
		</div>
	</div>
	<?php } ?>
</div>
<script type="text/javascript"><!--
$('#language-custom-field-select a:first').tab('show');
//--></script>

