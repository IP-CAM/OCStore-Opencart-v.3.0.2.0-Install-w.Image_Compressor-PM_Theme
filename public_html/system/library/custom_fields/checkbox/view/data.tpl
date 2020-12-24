<ul class="nav nav-tabs" id="language-custom-field-checkbox">
	<?php foreach ($languages as $language) { ?>
	<li><a href="#language-custom-field-checkbox<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
	<?php } ?>
</ul>
<div class="tab-content">
	<?php foreach ($languages as $language) { ?>
	<div class="tab-pane" id="language-custom-field-checkbox<?php echo $language['language_id']; ?>">
		<div class="form-group">
			<label class="col-sm-2 control-label"><?php echo $entry_checked; ?></label>
			<div class="col-sm-10">
			  <textarea rows="3" id="custom_field_checked<?php echo $language['language_id']; ?>" name="custom_field[<?php echo $language['language_id']; ?>][checked]" placeholder="<?php echo $entry_checked; ?>" class="form-control summernote"><?php echo isset($result[$language['language_id']]['checked'])?$result[$language['language_id']]['checked']:''; ?></textarea>
			</div>				
		</div>
	</div>
	<?php } ?>
</div>
<script type="text/javascript"><!--
$('#language-custom-field-checkbox a:first').tab('show');
//--></script>
<script type="text/javascript"><!--
<?php if ($ckeditor) { ?>
	<?php foreach ($languages as $language) { ?>
		ckeditorInit('custom_field_checked<?php echo $language['language_id']; ?>', getURLVar('token'));
	<?php } ?>
<?php } ?>
//--></script>