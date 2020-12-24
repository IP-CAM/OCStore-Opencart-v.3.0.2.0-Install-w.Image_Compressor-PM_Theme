<div class="custom-fields-field-<?php echo $result['custom_fields_id']; ?>">
	<div class="custom-fields-map-data_yandex" data-id="<?php echo $result['custom_fields_id']; ?>" data-lat="<?php echo $result['data'][$language_id]['lat']; ?>" data-lng="<?php echo $result['data'][$language_id]['lng']; ?>" data-zoom="<?php echo $result['data'][$language_id]['zoom']?$result['data'][$language_id]['zoom']:8; ?>" data-name="<?php echo $result['data'][$language_id]['name']; ?>" data-description="<?php echo $result['data'][$language_id]['description']; ?>"></div>
	<div id="custom-fields-map_yandex-<?php echo $result['custom_fields_id']; ?>" style="width: <?php echo $result['data'][$language_id]['width']?($result['data'][$language_id]['width'].'px'):'100%'; ?>; height: <?php echo $result['data'][$language_id]['height']?($result['data'][$language_id]['height'].'px'):'400px'; ?>"></div>
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
}

var cf_map_yandex=[];
var cf_marker_yandex=[];

if(typeof(initMapYandex)==='undefined'){
	function initMapYandex() {
		$('.custom-fields-map-data_yandex').each(function(){
			var id_yandex = $(this).attr('data-id');
			var lat_yandex = parseFloat($(this).attr('data-lat'));
			var lng_yandex = parseFloat($(this).attr('data-lng'));
			var zoom_yandex = parseInt($(this).attr('data-zoom'));
			var name_yandex = $(this).attr('data-name');
			var description_yandex = $(this).attr('data-description');
			
			cf_map_yandex[id_yandex] = new ymaps.Map('custom-fields-map_yandex-'+id_yandex, {
				center: [lat_yandex, lng_yandex], 
				zoom: zoom_yandex
			});

			cf_marker_yandex[id_yandex] = new ymaps.Placemark([lat_yandex, lng_yandex], { 
				hintContent: name_yandex,
				balloonContent: description_yandex 
			});
			
			cf_map_yandex[id_yandex].geoObjects.add(cf_marker_yandex[id_yandex]);
		});		
	}
}
//--></script>	