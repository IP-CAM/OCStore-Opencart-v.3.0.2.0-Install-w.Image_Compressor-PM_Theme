<div id="custom-fields-field-<?php echo $result['custom_fields_id']; ?>" class="custom-fields-images">
	<ul class="thumbnails">
	<?php foreach($custom_fields_images as $element){ ?>
		<?php if($element['image']){ ?>
			<li class="image-additional">
			<?php if($element['mode']==1){ ?>
				<a class="thumbnail" href="<?php echo $element['image']; ?>">
					<img class="custom-fields-image" src="<?php echo $element['thumb']; ?>" alt="" />
				</a>
			<?php } else if($element['mode']==2){ ?>
				<a class="thumbnail notmagnific" href="<?php echo $element['link']; ?>" <?php if($element['new']){ ?>target="_blank"<?php } ?>>
					<img class="custom-fields-image" src="<?php echo $element['thumb']; ?>" alt="" />
				</a>
			<?php } else{ ?>
				<a class="thumbnail notmagnific">
					<img class="custom-fields-image" src="<?php echo $element['thumb']; ?>" alt="" />
				</a>	
			<?php } ?>
			</li>
		<?php } ?>
	<?php } ?>
	</ul>
</div>

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
