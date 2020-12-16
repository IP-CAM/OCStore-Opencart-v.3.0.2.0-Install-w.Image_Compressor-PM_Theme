# Усовершенствованное модальное окно

Существует блок, который на больших экранах отображается как обычно - в контенте или спрятан перед закрытием body.
На определенном разрешении блок скрывается (display: none), после чего его можно открыть по нажатию на триггер.
При этом блок получает:
1. position: fixed
2. кнопку закрытия (как у модального окна)
3. анимацию открытия
4. оверлэй
5. функционал модального окна
6. Для реализации необходимо:
      склонировать содержимое из текста,
      вставить внутрь шаблона модального окна
      отриcовать перед закрытием body


Модальное окно представлено элементом template в HTML,
<template id="modal">
  <div class="modal">
    <div class="modal__inner modal__inner--center" role="dialog" aria-modal="true">
      <!-- сюда будем вставлять содержимое -->

      <button class="button button--modal-close modal__close-button" type="button">
        <svg class="button__close-icon" width="48" height="48">
          <use href="img/svg/_sprite.svg#icon-close"></use>
        </svg>
      </button>
    </div>
  </div>
</template>


# Содержимое модальдого окна спрятанного перед закрытием body
<secton class="modal__content modal__content--closed" aria-hidden="true" id="modalFilter">
  здесь содержимое окна
</secton>
* - атрибут aria-hidden="true", не указывается, если блок используется внутри страницы,
если блок спрятан перед закрытием body - указывается
** - при открытии окна через js, сбросить display: none
*** классы modal__content и modal__content--closed используются, когда окно спрятано перед закрытием body
**** класс modal__content задает отступы. Если модальное окно используется в контенте, отступы задаются своими классами


# Триггер должен иметь ссылку на id модального окна
<button data-modal="#modalCity">Кнопка вызова</button>

## Параметры окна.
Задаются data атрибутами на триггере

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