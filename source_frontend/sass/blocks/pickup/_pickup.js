'use strict';

const MAIN_SELECTOR = '.pickup';
const COORDS_ELEMENT_SELECTOR = '.radiocheck__input';
const COORDS_DATA_ATTR_NAME = 'pickupCoords';
const COORDS_DEVIDER = ',';
const MAP_SRC = 'https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=43f5c4bd-e478-41db-b3c6-29fbb56b4380';
const MAP_ID = 'map';
const MAP_CLASS = 'pickup__map';
const PIN_COLOR =  '#01768b';


class Pickup {
  constructor(element) {
    this.element = element;
    this.mapElement = undefined;
    this.map = undefined;

    this.coords = this._readCoords(); // прочитаем координаты из разметки и запишем в массив

    this._loadMap(() => {
      this._createMapElement();
      let activeIndex = this.element.querySelector(':checked').dataset.id;
      let startingCenterCoords = this.coords[activeIndex];
      this._initMap(startingCenterCoords);
      this._addPlacemarks(this.coords);
    });

    this.element.addEventListener('change', (evt) => {
      let newCoord = this.coords[evt.target.dataset.id];
      this.map.panTo(newCoord, {flying: 1});
    });

  }


  _loadMap(initCallback) {
    let script = document.createElement('script');
    script.src = MAP_SRC;
    document.body.append(script);
    script.onload = () => {
      window.ymaps.ready(initCallback);
    };
  }


  _createMapElement() {
    this.mapElement = document.createElement('div');
    this.mapElement.id = MAP_ID;
    this.mapElement.classList.add(MAP_CLASS);
    this.element.append(this.mapElement);
  }


  _initMap(centerCoords) {
    this.map = new window.ymaps.Map(MAP_ID,
      {
        center: centerCoords,
        zoom: 14,
        controls: ['zoomControl', 'fullscreenControl']
        // controls: ['smallMapDefaultSet']
      }
    );
  }


  _readCoords() {
    let coords = [];
    let coordElements = this.element.querySelectorAll(COORDS_ELEMENT_SELECTOR);
    for (let i = 0; i < coordElements.length; i++) {
      // получение координат и преобразование в массив массивов
      let textCoords = coordElements[i].dataset[COORDS_DATA_ATTR_NAME];
      let deviderPosition = textCoords.indexOf(COORDS_DEVIDER);
      let coordX = +textCoords.slice(0, deviderPosition);
      let coordY = +textCoords.slice(deviderPosition + 1);
      coords.push([coordX, coordY]);
      coordElements[i].setAttribute('data-id', i);
    }
    return coords;
  }


  _addPlacemarks(coords) {
    let placemark;
    coords.forEach((coord) => {
      placemark = new window.ymaps.Placemark(coord, {}, {
        preset: 'islands#dotIcon',
        iconColor: PIN_COLOR
      });
      this.map.geoObjects.add(placemark);
    });
  }

}




function initPickup() {
  let pickupElement = document.querySelector(MAIN_SELECTOR);
  if (pickupElement) {
    return new Pickup(pickupElement);
  }
}

export default initPickup;
