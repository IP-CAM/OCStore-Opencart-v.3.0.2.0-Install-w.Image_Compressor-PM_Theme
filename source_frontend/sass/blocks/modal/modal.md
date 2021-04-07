# Модальное окно
Обертка модального окна создается в js:

```html
<template id="modal">
  <div class="modal">
    <div class="modal__inner" role="dialog" aria-modal="true">
      <!-- сюда вставлять содержимое -->
      <button class="button button--modal-close modal__close-button" data-modal-close type="button">
        <span class="visually-hidden">Закрыть</span>
        <svg class="button__close-icon" viewBox="0 0 24 24" width="48" height="48" fill="none" stroke-linecap="round" aria-hidden="true"><path vector-effect="non-scaling-stroke" d="M7 7l10 10M7 17L17 7"/></svg>
      </button>
    </div>
  </div>
</template>
```


## Режимы работы

### 1. Содержимое модального окна заранее определено. На любых вьюпортах отображается только в модальном окне.
В этом случае разметка содержимого прячется перед закрытием body.

Содержимое модальдого окна:
```html
<secton id="modal-city" hidden>
  здесь содержимое окна
</secton>
```

*Триггер*
должен иметь ссылку на id модального окна
```html
<button data-modal="#modal-city">Показать окно</button>
```

*Параметры окна*
Задаются data атрибутами на триггере



### 2. Содержимое модального окна заранее определено, но в отличие от п1, на определенных вьюпортах отображается в осномном контенте страницы, на других вьюпортах (моб устр-ва) скрывается (display: none), после чего его можно открыть в модальном окне по нажатию на триггер.
*Триггер вызова и параметры аналогично п.1*



### 3. Содержимое модального окна определяется динамически (например: ответ сервера).
*Вызов*
modal.open({...params})
params = {
  header - заголовок, string
  content - HTML содержимое, конвертируется в DOM элемент
  *или*
  contentElement - DOM элемент
  modalPosition - 'center' - default, 'left'
  modalSize - 'small', 'big', 'auto'
  callbackOnClose
  triggerElement (используется только для установки фокуса после закрытия окна)
  focusOnOpen (true - default, false) - поместить фокус на элемент модального окна при открытии
}



## Data атрибуты окна

### data атрибут, указывающий на позицию окна и тип анимации появления-закрытия
1. data-modal-position="left"
Окно появляется слева и прилипает к левому краю. Кнопка закрытия при этом снаружи-справа.
Максимальная ширина окна = ширина окна + кнопки
upd: окно должно прилипать к верхней части вьюпорта.
2. data-modal-position="center" (по умолчанию)
Кнопка закрытия справа от окна на tablet и выше окна на mobile
В зависимости от установленного атрибута, добавляется соответствующий класс:
modal--center (по умолчанию)
modal--left


### Нестандартная ширина окна
data-modal-size="small"
data-modal-size="big"
Добавляется модификатор ширины
