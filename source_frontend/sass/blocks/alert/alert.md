# модуль для динамической встройки сообщений (чаще от сервера) в разметку


## принцип работы
Модуль импортируется в js скрипт. При необходимости показать alert, последний инициализируется с необходимыми параметрами.
По умолчанию имеет кнопку закрытия.


## синтаксис
new Alert({targetSelector, position, html, type = 'info', isDissmisible = true, scrollIntoView = false});


### параметры

`targetSelector` (string)
Селектор элемента, относительно которого будет определяться позиция вставки alert

`position` (string)
Определяет позицию добавляемого элемента относительно элемента selector
варианты:
* append – добавляет узлы или строки в конец node,
* prepend – вставляет узлы или строки в начало node,
* before - вставляет узлы или строки до node,
* after - вставляет узлы или строки после node

`html` (string)
Строка, которая будет проанализирована как HTML или XML и вставлена в DOM дерево документа.

`type` (string)
Определяет стиль alert (css класс). Варианты:
* 'info' - default
* 'success'
* 'warning'
* 'simpleWarning',
* 'danger'

`extraCssClass` (string)
Дополнительные CSS классы для alert через пробел

`isDissmisible` (boolean)
* true - имеет кнопку закрытия (default)
* false

`deletePrevious` (boolean)
* true - default
* false
удалять ли предыдущий alert, если найдется (на этой же позиции)
