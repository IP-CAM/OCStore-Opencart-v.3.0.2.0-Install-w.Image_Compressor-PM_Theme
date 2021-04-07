
Данные для списка могут передаваться разными способами:
1. Готовая HTML разметка с сервера.
2. Массив объектов с данными передается js динамически.


## 1 вариант
```html
{% set unique_list_id = 'custom-select-' ~ random() %}
{% set unique_describe_id = 'custom-select-' ~ random() %}
<div class="textfield custom-select" aria-owns="{{ unique_list_id }}">
  <label class="textfield__input-container">
    <input class="textfield__input" type="text" aria-describedby="{{ unique_describe_id }}" aria-controls="{{ unique_list_id }}" autocomplete="off">
    <span class="textfield__trailing-icon textfield__trailing-icon--dropdown custom-select__dropdown-icon"></span>
    <span class="textfield__label textfield__label--top">Ваш город</span>
  </label>
  <ul class="custom-select__list" id="{{unique_list_id}}" hidden>
    <li class="custom-select__item" role="option" tabindex="-1" data-id="1">
      <strong class="custom-select__item-title">Минск</strong>
      <span class="custom-select__item-description">Столица Республики Беларусь</span>
    </li>
    <li class="custom-select__item" role="option" tabindex="-1" data-id="2">
      <strong class="custom-select__item-title">Гродно</strong>
      <span class="custom-select__item-description">город в Белоруссии, административный центр Гродненской области, а также Гродненского района</span>
    </li>
  </ul>
  <div class="textfield__help" id="{{ unique_describe_id }}">Быстрый поиск населенного пункта</div>
</div>
```


## 2 вариант (тоже самое, за исключением элементов списка - их нет)
```html
{% set unique_list_id = 'custom-select-' ~ random() %}
{% set unique_describe_id = 'custom-select-' ~ random() %}
<div class="textfield custom-select" aria-owns="{{ unique_list_id }}" data-city-select>
  <label class="textfield__input-container">
    <input class="textfield__input" type="text" aria-describedby="{{ unique_describe_id }}" aria-controls="{{ unique_list_id }}" autocomplete="off">
    <span class="textfield__trailing-icon textfield__trailing-icon--dropdown custom-select__dropdown-icon"></span>
    <span class="textfield__label textfield__label--top">Ваш город</span>
  </label>
  <ul class="custom-select__list" id="{{unique_list_id}}" hidden></ul>
  <div class="textfield__help" id="{{ unique_describe_id }}">Быстрый поиск населенного пункта</div>
</div>
```


## Работа с динамически передаваемыми данными

1. Элемент может сам посылать GET запрос на сервер, получать данные (json) и генерировать из них разметку списка.
setExternalSource - метод для этого.

```javascript
selectElement.setExternalSource({
  url: url,                           // url-адрес, куда будет отправлен запрос, к запросу будет конкатерировано текущее значение input. Ожидаемые данные: массив объектов [{},{},...]
  requestValueLength: 2,              // (default 2) количество символов, после набора которого будет отправлен запрос, если текущее количество сиволов меньше заданного, список будет очищен
  fieldMap: {                         // карта соответствия имен полей данных
    titleFieldName: 'name',           // 'title' by default
    descriptionFieldName: 'label',    // 'description' by default
    dataIdFieldName: 'value',         // 'dataId' by default
  }
});
```

2. Данные можно загрузить напрямую через метод setSource
```javascript
selectElement.setSource(
  data                                // массив объектов [{},{},...]
  fieldMap: {                         // карта соответствия имен полей данных
    titleFieldName: 'name',           // 'title' by default
    descriptionFieldName: 'label',    // 'description' by default
    dataIdFieldName: 'value',         // 'dataId' by default
  }
);
```


## Генерируемые события:
customSelectInput
customSelectChoice
