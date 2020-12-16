Слайдер состоит из двух главных компонентов -
1. Главная контентная часть (<div class="slider__list-container"></div>)
  <div class="slider__list-container">
    <ul class="slider__list">
      <li class="slider__item" id="slider__item-1" data-index="0">
        <div class="slider__image-container">
          <img class="slider__image" src="img/raster/product-1.jpg" alt="Изображение 1" width="360">
        </div>
      </li>
    </ul>

    <button class="button slider__toggle slider__toggle--left" type="button">
      <span class="visually-hidden">Назад</span>
      <svg class="slider__toggle-icon" width="24" height="24">
        <use href="img/svg/_sprite.svg#icon-arrow"></use>
      </svg>
    </button>

    <button class="button slider__toggle slider__toggle--right" type="button">
      <span class="visually-hidden">Вперед</span>
      <svg class="slider__toggle-icon" width="24" height="24">
        <use href="img/svg/_sprite.svg#icon-arrow"></use>
      </svg>
    </button>
  </div>
Динамически через js добавляются:
button, data-index="#"
id="slider__item-1" необходимо добавлять сервером в случае наличия навигационной панели для доступа без js



2. Навигационные ссылки в виде точек или миниизображений.
Эта часть не обязательная. Если присутствует, разметка следующая:
<div class="slider__nav">
  <ul class="slider__nav-list">
    <li class="slider__nav-item"  data-index="0">
      <a class="slider__nav-link" href="#slider__item-1">
        <img class="slider__nav-image" src="img/raster/product-1_thumb.jpg" alt="Перейти к изображению 1" width="56">
      </a>
    </li>
  </ul>
  <button>Назад (разметка выше)</button>
  <button>Вперед (разметка выше)</button>
</div>
Если присутствует, количество li должно соответствовать количеству li в главной части.
При этом видимость ссылок на разных устройствах - иконок и точек определяется в CSS.
Динамически через js добавляются:
button, data-index="#"





<!-- Добавлено -->
1. Сделать добавление кнопок через js +
Параметр: { createToggtleButtons: true } +
Добавить разметку кнопок в первую часть и вторую (если есть) +
2. В случае, если изображение одно удалять навигационную часть
3. Сделать добавление индекса
