<ul class="nav nav-tabs" id="language-custom-field-dummy">
	<?php foreach ($languages as $language) { ?>
	<li><a href="#language-custom-field-dummy<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
	<?php } ?>
</ul>
<div class="tab-content">
	<?php foreach ($languages as $language) { ?>
	<div class="tab-pane" id="language-custom-field-dummy<?php echo $language['language_id']; ?>">
		<div class="form-group">
			<label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $entry_text_help; ?>"><?php echo $entry_text; ?></span></label>
			<div class="col-sm-10">
			  <textarea rows="3" id="custom_field_dummy<?php echo $language['language_id']; ?>" name="custom_field[<?php echo $language['language_id']; ?>][text]" placeholder="<?php echo $entry_text; ?>" class="form-control summernote"><?php echo isset($result[$language['language_id']]['text'])?$result[$language['language_id']]['text']:''; ?></textarea>
			</div>				
		</div>
	</div>
	<?php } ?>
</div>
<script type="text/javascript"><!--
$('#language-custom-field-dummy a:first').tab('show');
//--></script>
<script type="text/javascript"><!--
<?php if ($ckeditor) { ?>
	<?php foreach ($languages as $language) { ?>
		ckeditorInit('custom_field_dummy<?php echo $language['language_id']; ?>', getURLVar('token'));
	<?php } ?>
<?php } ?>
//--></script>