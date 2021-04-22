# CircularProgress


## Назначение
Меняет внутреннюю разметку элемента на круговой индикатор загрузки
Аргументы при создании объекта:
* селектор (один или несколько через запятую) элемента, внутри которого размещается разметка CircularProgress
* опционально - объект с
width и height элемента (24px by default),
color - цвет индикатора (currentColor by default)


## Методы:
* on
* off


## Использование:
const loadingIndicator = new CircularProgress(this.submitButtonSelector);
loadingIndicator.on();
** запрос **
loadingIndicator.off();
