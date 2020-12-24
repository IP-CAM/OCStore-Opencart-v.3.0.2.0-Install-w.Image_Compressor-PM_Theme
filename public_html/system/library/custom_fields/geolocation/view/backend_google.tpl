	<div class="form-group">
		<label class="col-sm-2 control-label">
		<?php if($result['description']){ ?>
			<span data-toggle="tooltip" title="<?php echo $result['description']; ?>"><?php echo $result['name']; ?></span>
		<?php } else { ?>
			<?php echo $result['name']; ?>
		<?php } ?>
		</label>
		<div class="col-sm-5">
			<input readonly type="text" id="custom_field_lat-<?php echo $result['custom_fields_id']; ?>-<?php echo $language['language_id']; ?>" name="custom_field[<?php echo $result['custom_fields_id']; ?>][<?php echo $language['language_id']; ?>][lat]" value="<?php echo isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['lat'])?$data['custom_field'][$result['custom_fields_id']][$language['language_id']]['lat']:''; ?>" placeholder="<?php echo $entry_point_latitude; ?>" class="form-control" />
			
		</div>
		<div class="col-sm-5">
			<input readonly type="text" id="custom_field_lng-<?php echo $result['custom_fields_id']; ?>-<?php echo $language['language_id']; ?>" name="custom_field[<?php echo $result['custom_fields_id']; ?>][<?php echo $language['language_id']; ?>][lng]" value="<?php echo isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['lng'])?$data['custom_field'][$result['custom_fields_id']][$language['language_id']]['lng']:''; ?>" placeholder="<?php echo $entry_point_longtitude; ?>" class="form-control" />
			
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
			<input id="custom_field_name-<?php echo $result['custom_fields_id']; ?>-<?php echo $language['language_id']; ?>" type="text" name="custom_field[<?php echo $result['custom_fields_id']; ?>][<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['name'])?$data['custom_field'][$result['custom_fields_id']][$language['language_id']]['name']:''; ?>" placeholder="<?php echo $entry_point_name; ?>" class="form-control" />
			
		</div>
		<div class="col-sm-5">
			<input  id="custom_field_zoom-<?php echo $result['custom_fields_id']; ?>-<?php echo $language['language_id']; ?>" type="text" name="custom_field[<?php echo $result['custom_fields_id']; ?>][<?php echo $language['language_id']; ?>][zoom]" value="<?php echo isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['zoom'])?$data['custom_field'][$result['custom_fields_id']][$language['language_id']]['zoom']:''; ?>" placeholder="<?php echo $entry_point_zoom; ?>" class="form-control" />
			
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
			<textarea  id="custom_field_description-<?php echo $result['custom_fields_id']; ?>-<?php echo $language['language_id']; ?>" name="custom_field[<?php echo $result['custom_fields_id']; ?>][<?php echo $language['language_id']; ?>][description]" placeholder="<?php echo $entry_point_description; ?>" class="form-control" ><?php echo isset($data['custom_field'][$result['custom_fields_id']][$language['language_id']]['description'])?$data['custom_field'][$result['custom_fields_id']][$language['language_id']]['description']:''; ?></textarea>			
		</div>
		<div class="col-sm-12">
			<br />
		</div>
		<label class="col-sm-2 control-label">
		</label>
		<div class="col-sm-10 text-right">
			<button type="button" title="<?php echo $button_select_on_map; ?>" class="btn" onclick="cf_openModal($(this));" data-toggle="modal" data-target="#cf_mapModal" data-custom_fields_id="<?php echo $result['custom_fields_id']; ?>" data-language_id="<?php echo $language['language_id']; ?>"><i class="fa fa-location-arrow"></i></button>
		</div>
		
		
	</div>


<script type="text/javascript"><!--

var list = document.getElementsByTagName('script');
var i = list.length, flag = false;
while (i--) {
    if (list[i].src === 'https://maps.googleapis.com/maps/api/js?key=<?php echo $result['data']['apikey_google']; ?>&callback=initMap') {
        flag = true;
        break;
    }
}

// if we didn't already find it on the page, add it
if (!flag) {
    var tag = document.createElement('script');
    tag.src = 'https://maps.googleapis.com/maps/api/js?key=<?php echo $result['data']['apikey_google']; ?>&callback=initMap';
    document.getElementsByTagName('body')[0].appendChild(tag);
	
	
	var cf_modal='<form class="form-horizontal">';
	cf_modal+='<div class="modal fade" id="cf_mapModal" tabindex="-1" role="dialog" aria-labelledby="cf_mapModalLabel">';
	cf_modal+='<div class="modal-dialog" role="document">';
	cf_modal+='<div class="modal-content">';
	cf_modal+='<div class="modal-header">';
	cf_modal+='<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
	cf_modal+='<h4 class="modal-title" id="cf_mapModalLabel"><?php echo $text_select_on_map; ?></h4>';
	cf_modal+='</div>';
	cf_modal+='<div class="modal-body">';
	cf_modal+='<div class="form-group">';
	cf_modal+='<label class="col-sm-2 control-label"><?php echo $text_point_address ; ?></label>';
	cf_modal+='<div class="col-sm-10">';
	cf_modal+='<input type="text" id="custom_fields_address" placeholder="<?php echo $entry_point_address_search; ?>" class="form-control" />';			
	cf_modal+='</div>';
	cf_modal+='</div>';
	cf_modal+='<div class="form-group">';
	cf_modal+='<div style="width:100%; height:400px;" id="custom_fields_map"></div>';
	cf_modal+='</div>';
	cf_modal+='</div>';
	cf_modal+='<div class="modal-footer">';
	cf_modal+='<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $text_point_close; ?></button>';
	cf_modal+='<button type="button" class="btn btn-primary" onclick="cf_applyChanges();"><?php echo $text_point_save; ?></button>';
	cf_modal+='</div>';
	cf_modal+='</div>';
	cf_modal+='</div>';
	cf_modal+='</div>';
	cf_modal+='</form>';
	$('body').append(cf_modal);




	function cf_openModal(el){
		modal_custom_fields_id = el.attr('data-custom_fields_id');
		modal_language_id = el.attr('data-language_id');
	}
	
	function cf_applyChanges(){
		$('#custom_field_lat-'+modal_custom_fields_id+'-'+modal_language_id).val(cf_lat);
		$('#custom_field_lng-'+modal_custom_fields_id+'-'+modal_language_id).val(cf_lng);
		$('#cf_mapModal').modal('toggle');
	}
	
	function codeAddress(el) {
		var address = $('#custom_fields_address').val();
		
		geocoder.geocode( { 'address': address}, function(results, status) {
		  if (status == 'OK') {
			cf_map.setCenter(results[0].geometry.location);
			cf_marker.setPosition(results[0].geometry.location);
			cf_lat = results[0].geometry.location.lat();
			cf_lng = results[0].geometry.location.lng();
		  } else {
			alert('Geocode was not successful for the following reason: ' + status);
		  }
		});
	}
	
	
	
	var modal_custom_fields_id;
	var modal_language_id;
	var cf_map;
	var cf_marker;
	var cf_infoWindow;
	var cf_lat_def=cf_lat=48.858;
	var cf_lng_def=cf_lng=2.294;
	var cf_zoom_def=cf_zoom=8;
	var cf_name_def=cf_name='<?php echo $entry_point_name; ?>';
	var cf_description_def=cf_description='<?php echo $entry_point_description; ?>';
	

	$('#custom_fields_address').on('keydown', function(event) {		
		switch(event.keyCode) {
			case 13: // escape
				event.preventDefault();
				event.stopPropagation();
				codeAddress(this);
				break;
			default:
				break;
		}
		return event;
	});
		
	$("#cf_mapModal").on("shown.bs.modal", function () {
		cf_lat=$('#custom_field_lat-'+modal_custom_fields_id+'-'+modal_language_id).val();
		if(!cf_lat)cf_lat=cf_lat_def;
		cf_lng=$('#custom_field_lng-'+modal_custom_fields_id+'-'+modal_language_id).val();
		if(!cf_lng)cf_lng=cf_lng_def;
		cf_zoom=$('#custom_field_zoom-'+modal_custom_fields_id+'-'+modal_language_id).val();
		if(!cf_zoom)cf_zoom=cf_zoom_def;
		cf_name=$('#custom_field_name-'+modal_custom_fields_id+'-'+modal_language_id).val();
		if(!cf_name)cf_name=cf_name_def;
		cf_description=$('#custom_field_description-'+modal_custom_fields_id+'-'+modal_language_id).val();
		if(!cf_description)cf_description=cf_description_def;
		
		cf_map.setZoom(parseInt(cf_zoom));
		cf_marker.setPosition({lat: parseFloat(cf_lat), lng: parseFloat(cf_lng)});
		cf_marker.setTitle(cf_name);
		cf_infoWindow.setContent(cf_description);
		google.maps.event.trigger(cf_map, "resize");
		cf_map.setCenter({lat: parseFloat(cf_lat), lng: parseFloat(cf_lng)});
	});
		
	
	function initMap() {
		
		geocoder = new google.maps.Geocoder();
		
		cf_map = new google.maps.Map(document.getElementById('custom_fields_map'), {
		  center: {lat: cf_lat, lng: cf_lng},
		  zoom: 8
		});
		
		cf_marker = new google.maps.Marker({
		  position: {lat: cf_lat, lng: cf_lng},
		  draggable: true,
		  animation: google.maps.Animation.DROP,
		  map: cf_map,
		});
		
		cf_infoWindow = new google.maps.InfoWindow();

		google.maps.event.addListener(cf_marker, 'click', function () {
			cf_infoWindow.setContent(cf_description);
			cf_infoWindow.open(cf_map, this);
		});
		
		google.maps.event.addListener(cf_marker, 'dragend', function(evt){
			cf_lat = evt.latLng.lat();
			cf_lng = evt.latLng.lng();
			cf_map.setCenter(evt.latLng);
		});
								
	}
	
}

//--></script>