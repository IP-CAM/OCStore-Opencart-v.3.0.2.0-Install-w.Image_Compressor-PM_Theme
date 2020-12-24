<?php if($result['data'][$language_id]['link'] && $result['data'][$language_id]['vid']){ ?>
<div class="custom-fields-field-<?php echo $result['custom_fields_id']; ?>">
	<iframe width="<?php echo $result['data'][$language_id]['width']; ?>" height="<?php echo $result['data'][$language_id]['height']; ?>" src="https://www.youtube.com/embed/<?php echo $result['data'][$language_id]['vid']; ?>?feature=oembed" frameborder="0"></iframe>
</div>
<?php } ?>