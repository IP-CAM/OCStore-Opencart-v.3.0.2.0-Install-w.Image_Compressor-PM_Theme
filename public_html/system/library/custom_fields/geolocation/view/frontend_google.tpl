<div class="custom-fields-field-<?php echo $result['custom_fields_id']; ?>">
	<div class="custom-fields-map-data" data-id="<?php echo $result['custom_fields_id']; ?>" data-lat="<?php echo $result['data'][$language_id]['lat']; ?>" data-lng="<?php echo $result['data'][$language_id]['lng']; ?>" data-zoom="<?php echo $result['data'][$language_id]['zoom']?$result['data'][$language_id]['zoom']:8; ?>" data-name="<?php echo $result['data'][$language_id]['name']; ?>" data-description="<?php echo $result['data'][$language_id]['description']; ?>"></div>
	<div id="custom-fields-map-<?php echo $result['custom_fields_id']; ?>" style="width: <?php echo $result['data'][$language_id]['width']?($result['data'][$language_id]['width'].'px'):'100%'; ?>; height: <?php echo $result['data'][$language_id]['height']?($result['data'][$language_id]['height'].'px'):'400px'; ?>"></div>
</div>

<script type="text/javascript"><!--

var list = document.getElementsByTagName('script');
var i = list.length, flag = false;
while (i--) {
    if (list[i].src === 'https://maps.googleapis.com/maps/api/js?key=<?php echo $result['settings_data']['apikey_google']; ?>&callback=initMap') {
        flag = true;
        break;
    }
}

// if we didn't already find it on the page, add it
if (!flag) {
    var tag = document.createElement('script');
    tag.src = 'https://maps.googleapis.com/maps/api/js?key=<?php echo $result['settings_data']['apikey_google']; ?>&callback=initMap';
    document.getElementsByTagName('body')[0].appendChild(tag);
}

var cf_map=[];
var cf_marker=[];
var cf_infoWindow=[];

if(typeof(initMap)==='undefined'){
	function initMap() {
		$('.custom-fields-map-data').each(function(){
			var id = $(this).attr('data-id');
			var lat = parseFloat($(this).attr('data-lat'));
			var lng = parseFloat($(this).attr('data-lng'));
			var zoom = parseInt($(this).attr('data-zoom'));
			var name = $(this).attr('data-name');
			var description = $(this).attr('data-description');
			
			cf_map[id] = new google.maps.Map(document.getElementById('custom-fields-map-'+id), {
			  center: {lat: lat, lng: lng},
			  zoom: zoom
			});
			cf_marker[id] = new google.maps.Marker({
			  position: {lat: lat, lng: lng},
			  draggable: false,
			  animation: google.maps.Animation.DROP,
			  map: cf_map[id],
			  title: name,
			});
			
			cf_infoWindow[id] = new google.maps.InfoWindow();
			google.maps.event.addListener(cf_marker[id], 'click', function () {
				cf_infoWindow[id].setContent(description);
				cf_infoWindow[id].open(cf_map[id], this);
			});
		});		
	}
}
//--></script>	