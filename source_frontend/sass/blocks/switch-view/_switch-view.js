'use strict';

const TargetView = {
  GRID: 'grid',
  LIST: 'list'
};

const LOCAL_STORAGE_PROPERTY_NAME = 'display';


class SwitchView {
  constructor(overrides) {
    const defaults = {
      gridTriggerSelector: '.switch-view__input--grid',
      listTriggerSelector: '.switch-view__input--list',
      listElementSelector: '.minicard-list__list',
      listElementGridClass: 'minicard-list__list--grid',
      listElementListClass: 'minicard-list__list--list',
      minicardSelector: '.minicard',
      minicardGridClass: 'minicard--grid',
      minicardListClass: 'minicard--list'
    };

    Object.assign(this, defaults, overrides);


    this.gridTriggerElement = document.querySelector(this.gridTriggerSelector);
    this.listTriggerElement = document.querySelector(this.listTriggerSelector);
    if (!this.gridTriggerElement || !this.listTriggerElement) return;

    this.gridTriggerElement.targetView = TargetView.GRID;
    this.listTriggerElement.targetView = TargetView.LIST;


    const savedConfig = this._loadConfigFromLocalStorage();
    if (savedConfig) {
      const triggerIsUpdated =  this._updateTriggersAccordingToConfig({targetView: savedConfig});
      // если отображается не тот конфиг, переключить вид
      if (triggerIsUpdated) {
        this._toggleView({targetView: savedConfig});
      }
    }

    this._addChangeViewHandlers();
  }


  _addChangeViewHandlers() {
    this.gridTriggerElement.addEventListener('change', () => {
      this._toggleView({targetView: this.gridTriggerElement.targetView});
      this._saveConfigToLocalStorage({targetView: this.gridTriggerElement.targetView});
    });

    this.listTriggerElement.addEventListener('change', () => {
      this._toggleView({targetView: this.listTriggerElement.targetView});
      this._saveConfigToLocalStorage({targetView: this.listTriggerElement.targetView});
    });
  }


  _toggleView({targetView}) {
    const listElement = document.querySelector(this.listElementSelector);
    const minicards = listElement.querySelectorAll(this.minicardSelector);

    const enableGridView = () => {
      listElement.classList.remove(this.listElementListClass);
      listElement.classList.add(this.listElementGridClass);

      minicards.forEach(element => {
        element.classList.remove(this.minicardListClass);
        element.classList.add(this.minicardGridClass);
      });
    };

    const enableListView = () => {
      listElement.classList.remove(this.listElementGridClass);
      listElement.classList.add(this.listElementListClass);

      minicards.forEach(element => {
        element.classList.remove(this.minicardGridClass);
        element.classList.add(this.minicardListClass);
      });
    };

    (targetView === TargetView.GRID) ? enableGridView() : enableListView();
  }


  _updateTriggersAccordingToConfig({targetView}) {
    let triggerIsUpdated = false;
    let targetElement;

    if (this.gridTriggerElement.targetView === targetView) {
      targetElement = this.gridTriggerElement;
    } else {
      targetElement = this.listTriggerElement;
    }

    if (!targetElement.checked) {
      targetElement.checked = true;
      triggerIsUpdated = true;
    }

    return triggerIsUpdated;
  }


  _saveConfigToLocalStorage({targetView}) {
    localStorage.setItem(LOCAL_STORAGE_PROPERTY_NAME, targetView);
  }


  _loadConfigFromLocalStorage() {
    return localStorage.getItem(LOCAL_STORAGE_PROPERTY_NAME);
  }

}


function initSwitchView() {
  return new SwitchView;
}

export default initSwitchView;
