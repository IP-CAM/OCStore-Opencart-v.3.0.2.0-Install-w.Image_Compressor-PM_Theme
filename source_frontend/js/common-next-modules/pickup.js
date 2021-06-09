import { initCustomSelect } from '../../sass/blocks/custom-select/_custom-select';

const PICKUP_OPEN_BUTTON_SELECTOR = '[data-pickup-open-button]';
const PICKUP_CHOOSE_BUTTON_ATTR = 'data-pickup-choose-button';
const MAIN_ELEMENT_CLASS = 'pickup';
const pickupsJsonPath = '/_evropochta/post_offices.json';


class PickupSelect {
  constructor(pickups) {
    const parentElement = document.createElement('div');
    parentElement.innerHTML = this._getCustomSelectHtml(pickups);

    const selector = '[data-pickup-select]';
    this.element = parentElement.querySelector(selector);
    this.customSelect = initCustomSelect(this.element);
  }

  _getCustomSelectHtml(pickups) {
    const html = `<div class="textfield custom-select pickup__custom-select" aria-owns="pickup-list" data-pickup-select>
                    <label class="textfield__input-container">
                      <input class="textfield__input" type="text" name="pickup" value="" aria-describedby="pickup-describe" aria-controls="pickup-list" autocomplete="off" spellcheck="false">
                      <span class="textfield__trailing-icon textfield__trailing-icon--dropdown custom-select__dropdown-icon"></span>
                      <span class="textfield__label textfield__label--top">Пункт самовывоза</span>
                    </label>
                    <ul class="custom-select__list" id="pickup-list" hidden>${this._getCustomSelectListItems(pickups)}</ul>
                    <div class="textfield__help" id="pickup-describe">Быстрый поиск пункта самовывоза</div>
                  </div>`;
    return html;
  }

  _getCustomSelectListItems(pickups) {
    const pickupListItems = pickups.map(pickup => {
      return `<li class="custom-select__item" role="option" tabindex="-1" data-id="${pickup.WarehouseId}">
                <strong class="custom-select__item-title">${pickup.WarehouseName}</strong>
                <span class="custom-select__item-description">${pickup.Info1}</span>
              </li>`;
    });
    return pickupListItems.join('');
  }

  setValue(value) {
    this.customSelect.setValue(value);
  }

}


class PickupInfo {
  constructor() {
    const infoClass = 'pickup__info';
    this.element = document.createElement('p');
    this.element.classList.add(infoClass);
  }

  updateInfo(selectedPickup) {
    if (!selectedPickup) return;

    const pickupName = selectedPickup.WarehouseName;
    const pickupInfo = selectedPickup.Info1;
    this.element.innerHTML = `<b>Выбранный пункт самовывоза:</b><br>${pickupName}<br>${pickupInfo}`;
  }

}


class PickupChooseButton {
  constructor() {
    this.element = document.createElement('button');
    this.element.classList.add('button', 'button--action-primary', 'pickup__choose-button');
    this.element.setAttribute('type', 'button');
    this.element.setAttribute('data-modal-close', '');
    this.element.setAttribute(PICKUP_CHOOSE_BUTTON_ATTR, '');
    this.element.textContent = 'Выбрать';

    document.addEventListener('click', (evt) => {
      const targetElement = evt.target.closest(`[${PICKUP_CHOOSE_BUTTON_ATTR}]`);
      if (!targetElement) return;

      // 1. Записать инфо в local storage
      // 2. Обновить панель
    });
  }

  setPickupId(choiceId) {
    this.element.setAttribute(PICKUP_CHOOSE_BUTTON_ATTR, choiceId);
  }

}


class PickupMap {
  constructor(pickups) {
    this.mapSrc = 'https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=43f5c4bd-e478-41db-b3c6-29fbb56b4380';
    this.mapId = 'map';
    this.mapClass = 'pickup__map';
    this.pinColor =  '#01768b';

    this.element = document.createElement('div');
    this.element.id = this.mapId;
    this.element.classList.add(this.mapClass);

    this.pickups = this._convertData(pickups);

    this._loadScript()
      .then(() => {
        window.ymaps.ready(this._initMap.bind(this));
      });
  }


  _loadScript() {
    return new Promise((resolve, reject) => {
      const loadedScript = document.head.querySelector(`script[src="${this.mapSrc}"]`);

      if (loadedScript) {
        resolve(loadedScript);
      } else {
        const script = document.createElement('script');
        script.src = this.mapSrc;

        script.onload = () => resolve(script);
        script.onerror = () => reject(new Error(`Ошибка загрузки скрипта Yandex Maps ${this.mapSrc}`));

        document.head.append(script);
      }
    });
  }

  _initMap() {
    this.map = new window.ymaps.Map(this.mapId, {
      center: [53.902287, 27.561824],
      zoom: 11,
      controls: ['zoomControl', 'fullscreenControl']
    }, {
      searchControlProvider: 'yandex#search'
    });

    this.objectManager = new window.ymaps.ObjectManager({
      // Чтобы метки начали кластеризоваться, выставляем опцию.
      clusterize: true,
      clusterHasBalloon: false,
    });

    // Чтобы задать опции одиночным объектам и кластерам,
    // обратимся к дочерним коллекциям ObjectManager.
    this.objectManager.objects.options.set('iconColor', this.pinColor);
    this.objectManager.clusters.options.set('clusterIconColor', this.pinColor);
    this.objectManager.add(this.pickups);
    this.objectManager.objects.events.add('click', (evt) => {
      const choosedId = evt.get('objectId');
      const event = new CustomEvent('pinClick', {
        detail: { choosedId: choosedId }
      });
      this.element.dispatchEvent(event);
    });

    this.map.geoObjects.add(this.objectManager);
  }

  _convertData(pickupsIn) {
    // Address1Id: "887111"
    // Address7Id: "79"
    // Address7Name: "МИНСКАЯ ОБЛАСТЬ"
    // Info1: "Режим работы: 10:00-19:00 Обед: 14:00-15:00 Выходные: вс,пн"
    // Latitude: "54.0949"
    // Longitude: "26.513"
    // Note: ""
    // WarehouseId: "70530010"
    // WarehouseName: "Отделение № 117, г. Воложин, ул. Советская 95"
    // isNew: "1"

    const result = pickupsIn.map(elem => {
      return {
        type: 'Feature',
        id: elem.WarehouseId,
        geometry: {
          type: 'Point',
          coordinates: [elem.Latitude, elem.Longitude]
        },
        properties: {
          hintContent: `<div class="pickup__map-content pickup__map-hint"><b>${elem.WarehouseName}</b><br>${elem.Info1}</div>`,
          balloonContent: `<div class="pickup__map-content pickup__map-baloon">
                             <b>${elem.WarehouseName}</b><br>
                             ${elem.Info1}<br><br>
                             <button class="button button--action-primary pickup__map-baloon-button" type="button" ${PICKUP_CHOOSE_BUTTON_ATTR}="${elem.WarehouseId}">Выбрать</button>
                           </div>`
        }
      };
    });

    return result;
  }

  setPickup(coords) {
    this.map.setCenter(coords, 18, {
      flying: 1,
      checkZoomRange: true
    });
  }

}


// панель для отображения текущего выбора. Также содержит кнопку открытия окна
class PickupPanel {
  constructor() {
    this.triggerButtonElement = document.querySelector(PICKUP_OPEN_BUTTON_SELECTOR);
    this.triggerButtonElement.addEventListener('click', () => {
      if (typeof this.callback === 'function') {
        this.callback();
      }
    });
  }

  setCallbackOnButtonClick(callback) {
    this.callback = callback;
  }
}


class Pickup {
  constructor() {
    this.pickups = undefined;
    this.mainElement = undefined;
    this.customSelect = undefined;
    this.info = undefined;
    this.button = undefined;
    this.map = undefined;
    this.selectedPickup = undefined;

    this.pickupPanel = new PickupPanel();
    this.pickupPanel.setCallbackOnButtonClick(() => {
      this._loadPickupsInfo()
        .then(pickups => this._initChoosePickupModal(pickups))
        .then(() => this._showPickupChooseModal());
    });

    // this.triggerButtonElement = document.querySelector(PICKUP_OPEN_BUTTON_SELECTOR);
    // this.triggerButtonElement.addEventListener('click', () => {
    //   this._loadPickupsInfo()
    //     .then(pickups => this._initChoosePickupModal(pickups))
    //     .then(() => this._showPickupChooseModal());
    // });

  }


  _loadPickupsInfo() {
    if (!this.pickups) {
      return fetch(pickupsJsonPath)
        .then(response => {
          if (!response.ok) {
            throw new Error(`Код ответа: ${response.status}, сообщение: ${response.statusText}`);
          }
          return response.json();
        })
        .then(response => {
          this.pickups = response.Table;
          return this.pickups;
        });
    } else {
      return Promise.resolve(this.pickups);
    }
  }

  _initChoosePickupModal(pickups) {
    this.customSelect = new PickupSelect(pickups);
    this.info = new PickupInfo();
    this.button = new PickupChooseButton();
    this.map = new PickupMap(pickups);

    this.customSelect.element.addEventListener('customSelectChoice', (evt) => {
      const choiceId = evt.detail.choiceId;
      this.selectedPickup = this._getChoiceData(choiceId);
      this.info.updateInfo(this.selectedPickup);
      this.button.setPickupId(choiceId);
      this.map.setPickup([+this.selectedPickup.Latitude, +this.selectedPickup.Longitude]);
    });

    this.map.element.addEventListener('pinClick', (evt) => {
      // 1. Выбрать пункт в custom-select
      // 2. Обновить info
      // 3. Обновить атрибут на button
      this.selectedPickup = this._getChoiceData(evt.detail.choosedId);
      this.customSelect.setValue(this.selectedPickup.WarehouseName);
      this.info.updateInfo(this.selectedPickup);
      this.button.setPickupId(evt.detail.choosedId);
    });
  }

  _showPickupChooseModal() {
    const mainElement = document.createElement('div');
    mainElement.classList.add(MAIN_ELEMENT_CLASS);
    mainElement.append(this.customSelect.element);
    mainElement.append(this.info.element);
    mainElement.append(this.button.element);
    mainElement.append(this.map.element);

    window.yulms.modal.open({contentElement: mainElement, modalSize: 'extrabig', header: 'Выбор пункта самовывоза'});

    this.mainElement = mainElement;
  }

  _getChoiceData(choiceId) {
    // возвращает информацию (объект) по выбранному пункту
    return this.pickups.find(item => item.WarehouseId === choiceId);
  }

}



// class Pickup {
//   constructor() {
//     this.pickups = undefined;
//     this.mainElement = undefined;
//     this.customSelect = undefined;
//     this.info = undefined;
//     this.button = undefined;
//     this.map = undefined;
//     this.selectedPickup = undefined;

//     this.triggerButtonElement = document.querySelector(PICKUP_OPEN_BUTTON_SELECTOR);
//     this.triggerButtonElement.addEventListener('click', this._initChoosePickupModal.bind(this));

//   }


//   _initChoosePickupModal() {
//     this._loadPickupsInfo()
//       .then(pickups => {
//         this.customSelect = new PickupSelect(pickups);
//         this.info = new PickupInfo();
//         this.button = new PickupChooseButton();
//         this.map = new PickupMap(pickups);
//         this._showPickupChooseModal();

//         this.customSelect.element.addEventListener('customSelectChoice', (evt) => {
//           const choiceId = evt.detail.choiceId;
//           this.selectedPickup = this._getChoiceData(choiceId);
//           this.info.updateInfo(this.selectedPickup);
//           // навести на карте
//           this.map.setPickup([+this.selectedPickup.Latitude, +this.selectedPickup.Longitude]);
//         });

//         this.map.element.addEventListener('pinClick', (evt) => {
//           // 1. Выбрать пункт в custom-select
//           // 2. Обновить info
//           this.selectedPickup = this._getChoiceData(evt.detail.choosedId);
//           this.customSelect.setValue(this.selectedPickup.WarehouseName);
//           this.info.updateInfo(this.selectedPickup);
//         });
//       });
//   }

//   _loadPickupsInfo() {
//     return fetch(pickupsJsonPath)
//       .then(response => {
//         if (!response.ok) {
//           throw new Error(`Код ответа: ${response.status}, сообщение: ${response.statusText}`);
//         }
//         return response.json();
//       })
//       .then(response => {
//         this.pickups = response.Table;
//         return this.pickups;
//       });
//   }

//   _showPickupChooseModal() {
//     const mainElement = document.createElement('div');
//     mainElement.classList.add(MAIN_ELEMENT_CLASS);
//     mainElement.append(this.customSelect.element);
//     mainElement.append(this.info.element);
//     mainElement.append(this.button.element);
//     mainElement.append(this.map.element);

//     window.yulms.modal.open({contentElement: mainElement, modalSize: 'extrabig', header: 'Выбор пункта самовывоза'});

//     this.mainElement = mainElement;
//   }

//   _getChoiceData(choiceId) {
//     // возвращает информацию (объект) по выбранному пункту
//     return this.pickups.find(item => item.WarehouseId === choiceId);
//   }

// }


export default function initPickup() {
  return new Pickup();
}
