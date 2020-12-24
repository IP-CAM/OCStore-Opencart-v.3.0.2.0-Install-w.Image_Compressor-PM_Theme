	<div class="form-group">
		<label class="col-sm-2 control-label">
		<?php if($result['description']){ ?>
			<span data-toggle="tooltip" title="<?php echo $result['description']; ?>"><?php echo $result['name']; ?></span>
		<?php } else { ?>
			<?php echo $result['name']; ?>
		<?php } ?>
		</label>
		<div class="col-sm-5">
			<input readonly type="text" id="custom_field_lat_yandex-<?php echo $result['custom_fields_id']; ?>-<?php echo $language['language_id']; ?>" name="custom_field[<?php echo $result['custom_fields_id']; ?>][<?php echo $language['language_id']; ?>][lat]" value="<?php echo isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['lat'])?$data['custom_field'][$result['custom_fields_id']][$language['language_id']]['lat']:''; ?>" placeholder="<?php echo $entry_point_latitude; ?>" class="form-control" />
			
		</div>
		<div class="col-sm-5">
			<input readonly type="text" id="custom_field_lng_yandex-<?php echo $result['custom_fields_id']; ?>-<?php echo $language['language_id']; ?>" name="custom_field[<?php echo $result['custom_fields_id']; ?>][<?php echo $language['language_id']; ?>][lng]" value="<?php echo isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['lng'])?$data['custom_field'][$result['custom_fields_id']][$language['language_id']]['lng']:''; ?>" placeholder="<?php echo $entry_point_longtitude; ?>" class="form-control" />
			
		</div>
		<div class="col-sm-12">
		<?php if (isset($error_custom_fields[$result['custom_fields_id']][$language['language_id']])) { ?>
		  <div class="text-danger"><?php echo $error_custom_fields[$result['custom_fields_id']][$language['language_id']]; ?></div>
		<?php } ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-12">
			<br />
		</div>
		<label class="col-sm-2 control-label">
		</label>
		<div class="col-sm-5">
			<input id="custom_field_name_yandex-<?php echo $result['custom_fields_id']; ?>-<?php echo $language['language_id']; ?>" type="text" name="custom_field[<?php echo $result['custom_fields_id']; ?>][<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['name'])?$data['custom_field'][$result['custom_fields_id']][$language['language_id']]['name']:''; ?>" placeholder="<?php echo $entry_point_name; ?>" class="form-control" />
			
		</div>
		<div class="col-sm-5">
			<input  id="custom_field_zoom_yandex-<?php echo $result['custom_fields_id']; ?>-<?php echo $language['language_id']; ?>" type="text" name="custom_field[<?php echo $result['custom_fields_id']; ?>][<?php echo $language['language_id']; ?>][zoom]" value="<?php echo isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['zoom'])?$data['custom_field'][$result['custom_fields_id']][$language['language_id']]['zoom']:''; ?>" placeholder="<?php echo $entry_point_zoom; ?>" class="form-control" />
			
		</div>
		<div class="col-sm-12">
			<br />
		</div>
		<label class="col-sm-2 control-label">
		</label>
		<div class="col-sm-5">
			<input type="text" name="custom_field[<?php echo $result['custom_fields_id']; ?>][<?php echo $language['language_id']; ?>][width]" value="<?php echo isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['width'])?$data['custom_field'][$result['custom_fields_id']][$language['language_id']]['width']:''; ?>" placeholder="<?php echo $entry_point_width; ?>" class="form-control" />
			
		</div>
		<div class="col-sm-5">
			<input type="text" name="custom_field[<?php echo $result['custom_fields_id']; ?>][<?php echo $language['language_id']; ?>][height]" value="<?php echo isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['height'])?$data['custom_field'][$result['custom_fields_id']][$language['language_id']]['height']:''; ?>" placeholder="<?php echo $entry_point_height; ?>" class="form-control" />
			
		</div>
		<div class="col-sm-12">
			<br />
		</div>
		<label class="col-sm-2 control-label">
		</label>
		<div class="col-sm-10">
			<textarea  id="custom_field_description_yandex-<?php echo $result['custom_fields_id']; ?>-<?php echo $language['language_id']; ?>" name="custom_field[<?php echo $result['custom_fields_id']; ?>][<?php echo $language['language_id']; ?>][description]" placeholder="<?php echo $entry_point_description; ?>" class="form-control" ><?php echo isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['description'])?$data['custom_field'][$result['custom_fields_id']][$language['language_id']]['description']:''; ?></textarea>			
		</div>
		<div class="col-sm-12">
			<br />
		</div>
		<label class="col-sm-2 control-label">
		</label>
		<div class="col-sm-10 text-right">
			<button type="button" title="<?php echo $button_select_on_map; ?>" class="btn" onclick="cf_openModal_yandex($(this));" data-toggle="modal" data-target="#cf_mapModal_yandex" data-custom_fields_id="<?php echo $result['custom_fields_id']; ?>" data-language_id="<?php echo $language['language_id']; ?>"><i class="fa fa-location-arrow"></i></button>
		</div>
		
		
	</div>


<script type="text/javascript"><!--



var list = document.getElementsByTagName('script');
var i = list.length, flag = false;
while (i--) {
    if (list[i].src === 'https://api-maps.yandex.ru/2.1/?load=package.standard&lang=ru-RU&onload=initMapYandex') {
        flag = true;
        break;
    }
}

// if we didn't already find it on the page, add it
if (!flag) { 
	var tag = document.createElement('script');
    tag.src = 'https://api-maps.yandex.ru/2.1/?load=package.standard&lang=ru-RU&onload=initMapYandex';
    document.getElementsByTagName('body')[0].appendChild(tag);
	
	
	var cf_modal_yandex='<form class="form-horizontal">';
	cf_modal_yandex+='<div class="modal fade" id="cf_mapModal_yandex" tabindex="-1" role="dialog" aria-labelledby="cf_mapModalLabel_yandex">';
	cf_modal_yandex+='<div class="modal-dialog" role="document">';
	cf_modal_yandex+='<div class="modal-content">';
	cf_modal_yandex+='<div class="modal-header">';
	cf_modal_yandex+='<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
	cf_modal_yandex+='<h4 class="modal-title" id="cf_mapModalLabel_yandex"><?php echo $text_select_on_map; ?></h4>';
	cf_modal_yandex+='</div>';
	cf_modal_yandex+='<div class="modal-body">';
	cf_modal_yandex+='<div class="form-group">';
	cf_modal_yandex+='<label class="col-sm-2 control-label"><?php echo $text_point_address ; ?></label>';
	cf_modal_yandex+='<div class="col-sm-10">';
	cf_modal_yandex+='<input type="text" id="custom_fields_address_yandex" placeholder="<?php echo $entry_point_address_search; ?>" class="form-control" />';			
	cf_modal_yandex+='</div>';
	cf_modal_yandex+='</div>';
	cf_modal_yandex+='<div class="form-group">';
	cf_modal_yandex+='<div style="width:100%; height:400px;" id="custom_fields_map_yandex"></div>';
	cf_modal_yandex+='</div>';
	cf_modal_yandex+='</div>';
	cf_modal_yandex+='<div class="modal-footer">';
	cf_modal_yandex+='<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $text_point_close; ?></button>';
	cf_modal_yandex+='<button type="button" class="btn btn-primary" onclick="cf_applyChanges_yandex();"><?php echo $text_point_save; ?></button>';
	cf_modal_yandex+='</div>';
	cf_modal_yandex+='</div>';
	cf_modal_yandex+='</div>';
	cf_modal_yandex+='</div>';
	cf_modal_yandex+='</form>';
	$('body').append(cf_modal_yandex);




	function cf_openModal_yandex(el){
		modal_custom_fields_id_yandex = el.attr('data-custom_fields_id');
		modal_language_id_yandex = el.attr('data-language_id');
	}
	
	function cf_applyChanges_yandex(){
		$('#custom_field_lat_yandex-'+modal_custom_fields_id_yandex+'-'+modal_language_id_yandex).val(cf_lat_yandex);
		$('#custom_field_lng_yandex-'+modal_custom_fields_id_yandex+'-'+modal_language_id_yandex).val(cf_lng_yandex);
		$('#cf_mapModal_yandex').modal('toggle');
	}
	
	function codeAddress_yandex() {
		var address = $('#custom_fields_address_yandex').val();
		
		var myGeocoder = ymaps.geocode(address);
		myGeocoder.then(
			function (res) {
				var coords = res.geoObjects.get(0).geometry.getCoordinates();
				cf_map_yandex.setCenter(coords);
				cf_marker_yandex.geometry.setCoordinates(coords);
				cf_lat_yandex = coords[0];
				cf_lng_yandex = coords[1];
			},
			function (err) {
				alert('Geocode was not successful for the following reason: ' + err);
			}
		);
		/*
		geocoder.geocode( { 'address': address}, function(results, status) {
		  if (status == 'OK') {
			cf_map_yandex.setCenter(results[0].geometry.location);
			cf_marker_yandex.setPosition(results[0].geometry.location);
			cf_lat_yandex = results[0].geometry.location.lat();
			cf_lng_yandex = results[0].geometry.location.lng();
		  } else {
			alert('Geocode was not successful for the following reason: ' + status);
		  }
		});
		*/
	}
	
	
	
	var modal_custom_fields_id_yandex;
	var modal_language_id_yandex;
	var cf_map_yandex;
	var cf_marker_yandex;
	var cf_infoWindow_yandex;
	var cf_lat_yandex_def=cf_lat_yandex=48.858;
	var cf_lng_yandex_def=cf_lng_yandex=2.294;
	var cf_zoom_yandex_def=cf_zoom_yandex=8;
	var cf_name_yandex_def=cf_yandex_name='<?php echo $entry_point_name; ?>';
	var cf_description_yandex_def=cf_description_yandex='<?php echo $entry_point_description; ?>';
	
	
	

	$('#custom_fields_address_yandex').on('keydown', function(event) {		
		switch(event.keyCode) {
			case 13: // escape
				event.preventDefault();
				event.stopPropagation();
				codeAddress_yandex();
				break;
			default:
				break;
		}
		return event;
	});
		
	$("#cf_mapModal_yandex").on("shown.bs.modal", function () {
		
		cf_lat_yandex=$('#custom_field_lat_yandex-'+modal_custom_fields_id_yandex+'-'+modal_language_id_yandex).val();
		if(!cf_lat_yandex)cf_lat_yandex=cf_lat_yandex_def;
		cf_lng_yandex=$('#custom_field_lng_yandex-'+modal_custom_fields_id_yandex+'-'+modal_language_id_yandex).val();
		if(!cf_lng_yandex)cf_lng_yandex=cf_lng_yandex_def;
		cf_zoom_yandex=$('#custom_field_zoom_yandex-'+modal_custom_fields_id_yandex+'-'+modal_language_id_yandex).val();
		if(!cf_zoom_yandex)cf_zoom_yandex=cf_zoom_yandex_def;
		cf_name_yandex=$('#custom_field_name_yandex-'+modal_custom_fields_id_yandex+'-'+modal_language_id_yandex).val();
		if(!cf_name_yandex)cf_name_yandex=cf_name_yandex_def;
		cf_description_yandex=$('#custom_field_description_yandex-'+modal_custom_fields_id_yandex+'-'+modal_language_id_yandex).val();
		if(!cf_description_yandex)cf_description_yandex=cf_description_yandex_def;
		
		
		cf_marker_yandex.geometry.setCoordinates([parseFloat(cf_lat_yandex), parseFloat(cf_lng_yandex)]);
		cf_marker_yandex.properties.set('hintContent', cf_name_yandex);
		cf_marker_yandex.properties.set('balloonContent', cf_description_yandex);
		

		cf_map_yandex.setCenter([parseFloat(cf_lat_yandex), parseFloat(cf_lng_yandex)], parseInt(cf_zoom_yandex));
		
	});
		
	
	function initMapYandex() {
	
		
		
		cf_map_yandex = new ymaps.Map('custom_fields_map_yandex', {
			controls: ['zoomControl','typeSelector'],
            center: [cf_lat_yandex, cf_lng_yandex], 
            zoom: cf_zoom_yandex
        });
		
		
		cf_marker_yandex = new ymaps.Placemark([cf_lat_yandex, cf_lng_yandex], { 
			hintContent: cf_name_yandex_def,
			balloonContent: cf_description_yandex_def 
		}, {
            draggable: true
        });
		
		cf_marker_yandex.events.add([
			'dragend'
		], function (evt) {
			var coords = cf_marker_yandex.geometry.getCoordinates();
			cf_lat_yandex = coords[0];
			cf_lng_yandex = coords[1];
			cf_map_yandex.setCenter(coords);
		});
		
		cf_map_yandex.geoObjects.add(cf_marker_yandex);
										
	}
	
}

//--></script>