class CityManager {
  constructor() {
    this.urlModule = window.location.origin + '/index.php?route=extension/module/progroman/citymanager';
    this.urlSaveFias = this.urlModule + '/save&fias_id=';
    this.urlSearch = this.urlModule + '/search';
    this.containerSelector = '[data-city-manager]';
    this.cityChooseButtonSelector = '[data-city-choose-button]';
    this.citySelectElementSelector = '[data-city-select]';
    this.applyButtonSelector = '[data-apply-button]';
    this.selectedCityId = undefined;

    // Инициализация
    const containerElement = document.querySelector(this.containerSelector);
    containerElement.addEventListener('click', this._onContainerClick.bind(this));

    this._initAutocomplete();
  }

  _onContainerClick(evt) {

    const cityChooseButtonElement = evt.target.closest(this.cityChooseButtonSelector);
    if (cityChooseButtonElement) {
      this._setFias(cityChooseButtonElement.dataset.id);
      return;
    }

    const applyButtonElement = evt.target.closest(this.applyButtonSelector);
    if (applyButtonElement) {
      // debugger;
      if (this.selectedCityId) {
        this._setFias(this.selectedCityId);
      }
    }
  }

  _setFias(fiasId) {
    fetch(this.urlSaveFias + fiasId)
      .then((response) => {
        if (!response.ok) {
          throw new Error(`Код ответа: ${response.status}, сообщение: ${response.statusText}`);
        }
        return response.json();
      })
      .then(() => window.location.reload())
      // .then(json => {
      // при выборе текущего города возвращается success: 0
      //   if (json.success) window.location.reload();
      // })
      .catch(console.error);
  }

  _initAutocomplete() {
    const selectElement = document.querySelector(this.citySelectElementSelector);

    selectElement.setExternalSource({
      url: this.urlSearch + '&term=',
      fieldMap: {
        titleFieldName: 'name',
        descriptionFieldName: 'label',
        dataIdFieldName: 'value',
      }
    });

    selectElement.addEventListener('customSelectChoice', (evt) => {
      this.selectedCityId = evt.detail.choiceId;
    });

  }

}


export default function initCityManager() {
  return new CityManager;
}
