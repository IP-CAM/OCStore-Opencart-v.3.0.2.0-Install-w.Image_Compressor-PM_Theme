<div id="custom-fields-field-<?php echo $result['custom_fields_id']; ?>" class="custom-fields-images">
	<ul class="thumbnails">
	<?php if($custom_fields_image){ ?>
		<li>
		<?php if($result['data'][$language_id]['mode']==1){ ?>
			<a class="thumbnail" href="<?php echo $custom_fields_image; ?>">
				<img class="custom-fields-image" src="<?php echo $custom_fields_thumb; ?>" alt="" />
			</a>
		<?php } else if($result['data'][$language_id]['mode']==2){ ?>
			<a class="thumbnail notmagnific" href="<?php echo $result['data'][$language_id]['link']; ?>" <?php if($result['data'][$language_id]['new']){ ?>target="_blank"<?php } ?>>
				<img class="custom-fields-image" src="<?php echo $custom_fields_thumb; ?>" alt="" />
			</a>
		<?php } else{ ?>
			<a class="thumbnail notmagnific">
				<img class="custom-fields-image" src="<?php echo $custom_fields_thumb; ?>" alt="" />
			</a>	
		<?php } ?>
		</li>
	<?php } ?>
	</ul>
</div>
<?php if($result['data'][$language_id]['mode']==1){ ?>
<script type="text/javascript"><!--
if (typeof magnificPopup === 'undefined') {
	$.getScript( "catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js", function( data, textStatus, jqxhr ) {
		$('head').append( $('<link rel="stylesheet" type="text/css" />').attr('href', 'catalog/view/javascript/jquery/magnific/magnific-popup.css') );
		
		$('.custom-fields-images .thumbnails').magnificPopup({
			type:'image',
			delegate: 'a:not(.notmagnific)',
			gallery: {
				enabled:false
			}
		});
	});
}else{
	$('.custom-fields-images .thumbnails').magnificPopup({
		type:'image',
		delegate: 'a:not(.notmagnific)',
		gallery: {
			enabled:false
		}
	});
}

//--></script>
<?php } ?>