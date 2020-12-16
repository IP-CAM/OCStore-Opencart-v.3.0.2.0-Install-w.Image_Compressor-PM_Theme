SHOWMORE
Модуль скрывает лишний контент, добавляет снизу кнопку его показа.
Целевой элемент идентифицируется по наличию атрибута data-showmore

Дополнительные атрибуты
data-showmore-action (string, default value: "hideNodes"): режим работы, возможно 2: "hideNodes" или "hideHeight"
data-showmore-nodes (number, default value: 2): количество видимых узлов,
data-showmore-height (number, default value: 226) высота элемента (px) в свернутом состоянии,
data-showmore-showText (string, default value: "Показать больше"): текст кнопки в свернутом состоянии,
data-showmore-hideText (string, default value: "Скрыть"): текст кнопки в развернутом состоянии,
data-showmore-button-class (string): дополнительные классы (через пробел)



Возможны два режима работы:

1. Ограничение по количеству узлов.

Пример начальной разметки:
<ul data-showmore data-showmore-action="hideNodes" data-showmore-nodes="2" data-showmore-showtext="Показать все варианты" data-showmore-hideText="Скрыть лишние варианты" data-showmore-button-class="link showmore__additional-button">
  <li>Элемент 1</li>
  <li>Элемент 2</li>
  <li>Элемент 3</li>
  <li>Элемент 4</li>
</ul>

Разметка после работы скрипта:
<ul data-showmore data-showmore-action="hideNodes" data-showmore-nodes="2" data-showmore-showtext="Показать все варианты" data-showmore-hideText="Скрыть лишние варианты">
  <li>Элемент 1</li>
  <li>Элемент 2</li>
  <li hidden>Элемент 3</li>
  <li hidden>Элемент 4</li>
</ul>
<button class="" aria-expanded="false" type="button">Readmore</button>
Необходимо показать первых два элемента списка, остальные скрыть. Добавить кнопку показа.



2. Ограничение по высоте.
Пример:
<ul data-showmore data-showmore-action="hideHeight" data-showmore-height="226">
  <li>Элемент 1</li>
  <li>Элемент 2</li>
  <li>Элемент 3</li>
  <li>Элемент 4</li>
</ul>

Разметка после работы скрипта:
<ul data-showmore data-showmore-action="hideHeight" data-showmore-height="226" style="height: 226px;">
  <li>Элемент 1</li>
  <li>Элемент 2</li>
  <li>Элемент 3</li>
  <li>Элемент 4</li>
</ul>
<button class="" aria-expanded="false" type="button">Readmore</button>
