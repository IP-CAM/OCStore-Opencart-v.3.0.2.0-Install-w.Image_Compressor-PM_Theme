<?php
$oc15 = (version_compare(VERSION, "2.0", "<"))? true:false;
// Heading
// Обязательно без перевода строки! Иначе в JS будет ошибка. Opencart удаляет из названия модуля теги, но не удаляет перевод строки. В итоге получается JS код с разрывом.
$_['module_ver'] = '2.1.26';

$_['heading_title']  = '';
if(!$oc15) $_['heading_title']  = '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACYAAAAmCAMAAACf4xmcAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAYBQTFRF4eXvLUmb1dvpGzmSRF2l+fr5IT2VaHy1pbHSKkWZg5PBXnSxoazRl6XLvcbd2N7q5enxjZzHwMreboG4OVKf7vD1nKnOZHiz9ff5YXax3OHsqrbUPVWhTGOoyM/iFTOPztXmtb/ZiZnFSmGndoi80tnnGDaRWG6w6ezzxc7h/f387O7ywcrhJECWrbjWWm6vVmyt4ufwU2msvMXeucLaJkKX8fP3fIy/9/n5eIq+j57I7O/0mafMFjSQ0dfoNU+eV2uq/f78c4W6KEOX29/rUmisP1iiJ0KY/Pz78/X4nqzRUGepM02d3+TtJECVLEeZs73YkJ/Ifo/Ae42/L0mcJUGWL0qbUWir////Iz+V///+///9/v7+/v/9/v79/v/+2+DsKESY/f7+r7nYbH+3oKzN5+zxt8DXtsDZlKLJ/v//+/z7usPc//7+usTa6Ovy6Ov06u30W3CwiJjD+vv7R1+nxMvgytHly9TjNlCf/v78+fn70dfnJUKXsbvYgJDAoMq80wAAAtNJREFUeNp0lPlf0mAcxwfPHEOQQ+5jDTlGYsgAIRWJcgh5xDzYejZUpOhAy5KUIiv+9YYbOHA+P+y1PXs/n+d7I1B7iZOfyPTvbduZFXEl4COYKJ1vxDq+CsvVWqXdw8u8WlKl9vtzCqPYiCe61n7pBFRl/dtDtQbUmyjOs4xc3325FmedpBMXH6jhLGj/UZtTmNuj2q4JTBTDoL8vG3i/3njI3bQKE6G9GDmTLp5ar2cp4urOEVktACI2zfCFi77bMWZlS354ooWdbJIHo0sTPrD/SDKgC2X0CpYFhrHtX6e5FaotY02ToIrEUjZrycbGWRVPuzVJDjmG1ppHFhs+0qiQq3It/HxcAgvFMBSRU7hRXFaO2uxrGY6v1+vGfvRoXuaaeWfkGiInoseoxHCJABjH61pVltclMW7kloM7g4jorRAXUIkeWsYFtmsI5nieT3ab8q1uakVywaYzKMd2sOC/2X7PH0s7JK61dSxvX1JuCSsLzxXMLOhqmMUSzDmWCCPPZBTsJ7BLmB4bjDHeeOM30AL41BHusRAWljA/t6bCCOthFO0H3CrsCViXsO91jzjGdOwvvPMhauu2RpgUOMoseTqDorcjFyTDd8u9hbSdk97evpOxDmUZxq39t6wUsITxTPDQTud0PJ+jlXQN4yplAS+alWp1YgzDJAHAqgxTBW559yOfeTXMKcLSCVk+ZKDj8VQqPlypHaVXcXJOLiQHmB91+vm4UpSKF1cJXVrGQhh9rTURFLHBqMij5IYmMrR3r2QbYU+DuR481aK241RgqCB3Vo8rhbSo1TZ5JDbvuz6A7VkeUlce0rCq6voGXG4lD7xT1DOUdHgnZkgDLqIk8X5bNehebGLJg8TkqBEbsDAwUmh43uZNNGYKMbOJA/QTzWmpHzgB4NGtTMQpUIxp4QKK2kO18OWHj6hUbugoXoaPTEvFytt83tuc3v0vwACIJaTazt/ogwAAAABJRU5ErkJggg==">';
$_['heading_title'] .= '<img title="Сайт разработчика: sitecreator.ru" style="padding-right: 5px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAG0AAAAMCAMAAABfjsObAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAYBQTFRFYb3fQbDZ4vL5zur1S7TbxebzZb/gVbjdSrTaueLxwuXzgMrl8Pj8SLPaaMDh5fT6esjkccTiR7LaiM3nULbcmNTrpdrtzOr1ktHp7vj8sN7v0uz2hczn2vD4eMfkbsPizOn0odjsndbrfMjlPK7YcsTj2O/3rt3uyuj0X7zftuHwqNrt9Pv9tODwrNzu6PX61u73asHhis7o0Ov1st/wvuTydsbjd8fkfsnljM/oWrre/f7/3fD4jtDo1O32qdzultPq3/H4+Pz+8vr92vD37Pf7lNLp0Oz2mtXr+v3+yOj0hMvmldPqxuj0xef0XLve9/z96vb7yur0ntfsdMXjvOPyfsrloNfrjc/o6fb7bcLibcLhZ8Dg4/T64PL5ltPp////1e73TbXbl9TqY77fWLrddcbjZL7ggsvm/v7/cMPiRbLZx+fzU7fcWbremNPq4/P5bsLhV7nd/v//1u328fn8bMHh/P3/rt3vQ7HZRrLZ2e/3s+Dw+/7/0uz1a8LhOwyuPAAABAZJREFUeNpUlPtX2mgQhoPBcA0myE1DEhBRQBTCTe4CXpZWKnbRapXal4CiFVrKLrsge/nX9wt2z579fvguM5N5zjszJxTUmT4/ZnXGoZG121m9nSUH2Vjj4q2tIca6F0Ne1c0c+oXtRcdi+K/b7gCgt7+MMVw8F8YxZjNH0zGbAerCZNeuoFRjJe4LlVM29irk8w2yZpr2+Xw0Ta9uaye5XeXc9156PkiasmxOi/HRe5Q/+y306o7wQNrmq1gg75D3wrhxGpDTR6GjtMyZ+wOfLzT4yyTJVlCzFhqZi2s0qH4ETxn+MBtMonb6nZ4ayljjssEdUVJ2UVVkpfr0tXkFlP4u41hJhHeBVS5zfSwB3nUc9o+DxbrsAja+u7Z0nkItcBOoFXIPPPcLIr09IHtAtN0hXHLzB4GzaRdRg+GqnZkipli4x00zOhcJVrnebKDw2xQRxcq7ssCFNwPk3h2cYCJ3jc2SjI+9CbG4sp973Q/Ag9Pm7L2BM4dcHTWbWZ7AWbeNsHwKyjFC1cOHN23nu3VMvvgtycY2YvJKqSFdotj8OpBWm3OMFFJ1jgmkLUCQJ8hAKFJBtD3ePgm60aqY44jLbsu0Q/z7c9e9n4TRcAeBukciNG/7PXZXSSVTJA9WdqgYoVllcs8Rmpb82oRaWTjPdLhjJElzMBEmZgLasFSt60x0WkFhi56QKNi2lBOAdwOCpu0Iqyb8ycfwiS/AdJGZIJ25rCV7b0EZHTt3BZLqIBHRaIf/0RImjOR2MVvm1l5pZGm00Bpo+xkOKjjneoPPJpxxwuZ4gggH/KTRtvDBhN+/xLASLOBSo81JpxmvNpPqs3JbWsKKtKfRomQKftByJnQCntt8qVfEnSY6Iecij0QJaYrfC6Jt8uBvU5yQvYyZzYeI9j69ahNRbxGpAgRSyZZWyfrmEUTqEBSb3k+JHgWxfb8TVtsacEpoDEn+SGiZmOveq2vhje0dUspIaRDahT6CKLXlIrTblcv70yGzlLngS09onOBtYIGhbYCni64HhZs0mZLWkHzn7YKyV0c3GbmFXbaZIvJla8uwjKjCT+rjJD7KHJcYUeEBkozMjJZfmt/I2DvCNaSbzXUUuP1s5rifGsz+mDpieN/nKdK/1XAcUgXWG+WWzIfCk+at558FUkuJYq+F4oAe7diYq7I4TzI/8+sdcU4zbjkVF+dlQYhHpA7lvKsu/7qnBBOCKCYf9S1R3POXRbEjCJ3QyVyQTJHHslhctpeIX+AOYOUtwtJgKWmRzAw9F8suVZoXfWNKfWbH/d5QFw7rVb1eVRWD+r9TVY0GUDo1zBh0YdtrzFd24Xl1L7Z2T6//8SQhPdKHGZtn8qz251rE3atGlvH8I8AAMZUvZtNHvZoAAAAASUVORK5CYII=">';
$_['heading_title'] .= '<span class="head_wm_sitecreator">Image COMPRESSOR & Watermark & WebP & Lazy Load etc. by Sitecreator '.$_['module_ver'].'</span>';
$_['heading_title'] .= '<img onload="$(\'.head_wm_sitecreator:eq(1)\').closest(\'tr\').hide();" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==">';

//
// Text
//$_['text_enabled']         = 'Модули';
//$_['text_success']        = 'Настройки модуля обновлены!';

$_['text_edit'] 		= 'Настройки модуля';
$_['button_save'] = 'Сохранить';
$_['button_save_and_noclose'] = 'Сохранить и остаться';
$_['button_cancel'] = 'Отменить';

$_['text_tab_main'] 		= 'Основные настройки';

$_['text_tab_service'] 	= 'Сервис';
$_['text_tab_theme'] 		= 'Оптимизация шаблона и т.п.';
$_['text_tab_cron'] 		= 'Настройки CRON для WEBP';
$_['text_tab_webp_stat'] 		= 'Статистика для WEBP';
$_['text_tab_http_cwebp'] 		= 'Настройки для http_cwebp (cgi-скрипт)';

$_['text_tab_help'] 		= 'Документация';

$_['text_compress_theme'] 		= '<span data-toggle="tooltip" title="Сжать все изображения всех шаблонов (тем) движка. Исходники будут скопированы, поэтому можно повторять процедуру СЖАТИЯ с разным уровнем Q (качества) без опасений (пока не удалены копии исходников).">Оптимизировать изображения шаблонов (или др. папки)</span>';
$_['text_del_copies_of_images'] 		= '<span data-toggle="tooltip" title="НЕ РЕКОМЕНДУЕТСЯ удалять! <br>'."\n".'После оптимизации к имени файла исходного изображения добавляется __source__. Такие файлы можно удалить.  Пока они не удалены можно менять уровень качества для JPEG и заново оптимизировать. Если вы обновили шаблон (тему) магазина  вместе с изображениями, то удалите копии старых исходников.">Удалить исходные (несжатые) изображения (хранятся как копии).</span>';
$_['text_compress_theme_jpeg_quality'] 		= '<span data-toggle="tooltip" title="Только для mozjpeg. Оптимально 80. НЕ нужно нажимать \'Сохранить\', этот параметр не сохраняется в настройках, его нужно только выбирать.">Уровень качества (0...100) JPEG-mozjpeg шаблона/папки</span>';
$_['text_compress_theme_optipng_level'] 		= '<span data-toggle="tooltip" title="Уровень выше 3 может привести к медленной работе с PNG и редко приводит к дополнительному существенному сжатию файла. НЕ нужно нажимать \'Сохранить\', этот параметр не сохраняется в настройках, его нужно только выбирать. ">Уровень оптимизации OptiPNG для шаблона/папки</span>';



// ++++++++++++++++++++++++++++++

$_['text_create_secret_val_for_http_cwebp'] 		= '<span data-toggle="tooltip" title="Создает секретную ссылку в папке cgi-bin и одновременно создает файл .htaccess,
 который запрещает доступ ко всему в папке cgi-bin кроме секретного файла. <br><br>
 Это происходит сразу после нажатия данной кнопки, нажатие `сохранить` необязательно. Если получаете сообщение об ошибке,
 то проверьте возможность сохранения в этой папке.  Если у вас nginx без apache, то внесите секретное название файла как доступное в конфиг nginx.">Создать (сменить) секретное имя для файла cgi-скрипта</span>';





// ----------------------------
$_['text_show_webpimage_time'] 		= '<span data-toggle="tooltip" title="Для режима `Форсированный НА ЛЕТУ` информация будет видна в исходном коде (HTML) страницы внизу в блоке комментариев. 
Необходимо понимать, что создание любого изображения требует времени, но это происходит один раз.">Показывать  время, потраченное на создание и вывод webp.</span>';
$_['text_image_error_output'] 		= '<span data-toggle="tooltip" title="Вывод ошибок на страницу (вверху) в браузере. 
Также отображает попытки восстановления битых изображений.">Показывать  ошибки создания изображений</span>';
$_['text_debug_enable'] 		= '<span data-toggle="tooltip" title="Информацию можно увидеть в исходном коде HTML (она закомментирована). 
В принципе это не мешает отображению страницы, но поскольку создается лишняя информация на странице, то реккомендуется включать только по прямому назначению (ДЛЯ ОТЛАДКИ).<br><br>
Будет мешать нормальной работе если контент отдается в формате JSON, а не в HTML как обычно.">Вывод отладочной информации (не означает, что вывод только  ошибок)</span>';
$_['text_debug_echo_in_public'] 		= '<span style="color:#a80a00;" data-toggle="tooltip" title="Информация размещается вверху страницы. Доступна всем. HTML будет невалидный. 
<br><br><b>Ни в коем случае не включайте это постоянно!</b>">Вывод информации открыто на страницу (видна всем)</span>';

$_['text_debug_warning'] 		= 'Для корректного вывода актуальной информации ваш КЕШЕР (ускоритель) должен быть отключен.';

$_['text_dir_for_compress'] 		= '<span data-toggle="tooltip" title=" В этой папке (и ее подпапках) будут сжаты все найденные изображения">Выбрать папку для сжатия (отмены сжатия)</span>';
$_['text_compress_logo'] 		= 'Оптимизировать логотип';
$_['text_undu_compress_theme'] 		= '<span data-toggle="tooltip" title=" Вернуть исходники и удалить копии за ненадобностью.">Отменить сжатие изображений шаблонов (или др. выбранной папки).</span>';
$_['text_undu_compress_logo'] 		= '<span data-toggle="tooltip" title=" Вернуть исходник и удалить копию за ненадобностью.">Отменить сжатие логотипа.</span>';

$_['text_clear_cache'] 	= '<span data-toggle="tooltip" title="Memcached - системный кеш сайта в памяти. Единый для всех ваших сайтов. Принадлежность к конкретному сайту определенного ключа задана префиксом CACHE_PREFIX в конфиге сайта.">Очистить кеш</span>';
$_['text_clear_img_cache'] 	= 'ИЗОБРАЖЕНИЙ';
$_['text_clear_img_market_cache'] 	= 'ИЗОБР. для Я-Маркета';
$_['text_clear_img_no_mozjpeg_cache'] 	= 'ИЗОБРАЖЕНИЙ для ТЕСТА';
$_['text_clear_img_success'] 	= 'Кеш изображений очищен.';
$_['text_clear_market_img_success'] 	= 'Кеш изображений Я-МАРКЕТА очищен.';
$_['text_clear_no_mozjpeg_img_success'] 	= 'Кеш изображений для теста (_no_mozjpeg_, _no_optipng_) очищен.';
$_['text_clear_system_cache'] 	= 'СИСТЕМЫ (файлы)';
$_['text_clear_system_success'] 	= 'Системный кеш очищен.';
$_['text_clear_memcache'] 	= 'MEMCACHE(d) сайта';
$_['text_clear_memcache_success'] 	= 'MEMCACHE(d) очищен.';
$_['text_clear_all_memcache'] 	= 'MEMCACHE(d) ВЕСЬ (!!!)';
$_['text_confirm_clear_all_memcache'] 	= 'Будет очищен MEMCACHE(d) ВЕСЬ (!!!) для всех ваших сайтов. Продолжить?';
$_['text_clear_turbocache'] 	= 'TURBO (файлы)';
$_['text_clear_turbocache_success'] 	= 'TURBO кеш очищен.';

$_['text_clear_ocmod'] 	= 'Обновить кеш OCMOD';
$_['text_clear_ocmod_success'] 	= 'Кеш OCMOD обновлен.';

$_['text_clear_ocmod_error'] 	= 'Кеш OCMOD обновить не удалось.';
$_['text_info_ocmod'] 	= 'есть OCMOD для image.php?';


$_['text_lic_info'] 	= '<span data-toggle="tooltip" title="При нажатии на `Сбросить все настройки` произойдет сброс настроек модуля в состояние до установки. Лицензия будет ДЕЗАКТИВИРОВАНА.
После сброса нужно будет снова нажать `Активировать лицензию`">Лицензия и Сброс настроек</span>';
$_['text_info_os_extra'] 	= '<span data-toggle="tooltip" title="">Информация</span>';
$_['text_block_on_off_module'] 	= '<span data-toggle="tooltip" title="За счет дезактивации ocmod для модуля \'Компрессор\' и/или админ-бара он полностью отключается  в публичной части.  Т.е. файлы не участвуют в работе движка опенкарт, настройки модуля в админке при этом ни на что  НЕ влияют, хоть админка модуля \'Компрессор\' при этом работает.">Вкл/Выкл модуль/админ-бар</span>';
$_['text_on_off_module'] 	= 'Вкл/Выкл модуль';
$_['text_on_off_adminbar'] 	= 'Вкл/Выкл админ-бар';
$_['text_on_module'] 	= '<span class="my_fa_on"></span>Включить (ON) модуль';
$_['text_off_module'] 	= '<span class="my_fa_off"></span>Выключить (OFF) модуль';
$_['text_on_adminbar'] 	= '<span class="my_fa_on"></span>Включить (ON) админ-бар';
$_['text_off_adminbar'] 	= '<span class="my_fa_off"></span>Выключить (OFF) админ-бар';

$_['text_on_off_webp_output'] 	= 'Вкл/Выкл вывод WebP';
$_['text_on_webp_output'] 	= '<span class="my_fa_on"></span>Включить (ON) WebP';
$_['text_off_webp_output'] 	= '<span class="my_fa_off"></span>Выключить (OFF) WebP';


$_['text_block_on_off_ocmod_market'] = '<span data-toggle="tooltip">Вкл/Выкл ocmod для я-маркетов</span>';
$_['text_on_off_market1'] 	= 'On/Off Y.CMS 2.0';
$_['text_on_market1'] 	= '<span class="my_fa_on"></span>Включить (ON) Y.CMS 2.0';
$_['text_off_market1'] 	= '<span class="my_fa_off"></span>Выключить (OFF) Y.CMS 2.0';

$_['text_on_off_market2'] 	= 'On/Off YML by toporchillo';
$_['text_on_market2'] 	= '<span class="my_fa_on"></span>Вкл. (ON)  YML by toporchillo';
$_['text_off_market2'] 	= '<span class="my_fa_off"></span>Выкл. (OFF)  YML by toporchillo';

$_['text_ya_market_desc'] 	= '<h4>Описание (краткое) возможностей модуля Компрессор для экспорта в Я-Маркет и т.п.</h4><hr>
Поддерживаются автоматически (ocmod уже включен) модули:<br>
 1) <a href="https://github.com/yandex-money/yandex-money-cms-opencart2">Y.CMS 2.0</a><br>
 2) <a href="https://opencartforum.com/files/file/3846-yml-eksport-v-yandeksmarket-dlya-opencart-2x-3x/">YML экспорт в Яндекс.Маркет by toporchillo</a><br><br>
OCMOD для этих модулей можно включить/отключить на вкладке "Сервис". Возможно по заказу автору Компрессора добавление возможности подключения др. модулей для Я-Маркета (и т.п.). 
Вы также можете самостоятельно добавить необходимые изменения в существующие ДРУГИЕ модули. Необходимо код: <br><br>
<b>$this->model_tool_image->resize($image, $this->image_width, $this->image_height);</b><br>
заменить на:<br>
<b>$this->model_tool_image->resize($image, $this->image_width, $this->image_height, \'\', \'market\');</b><br><br>
Эта модификация кода позволит вам управлять изображениями для я-маркета кроме возможности работы со стикерами. Для стикеров нужен более сложный код 
(для указанных выше модулей он реализован и ничего делать не нужно). Для каждого товара может быть свой набор стикеров. Стикеры могут выглядеть так 
(параметры настраиваются: цвет, размер, шрифт): <br><img style="border: 1px solid #ededed;" src="view/image/sitecreator/ya_stickers.png">';





$_['text_info_os'] 	= 'Операционная система';
$_['text_info_memcache'] 	= 'Memcache(d) info & ключи';

$_['text_extra_soft'] 	= '<span data-toggle="tooltip" title="Информация / удаление сим. ссылок на (mozjpeg, optipng, webp). Инфо о константах MOZJPEG, OPTIPNG (пути к исп. файлам с подключаемыми библиотеками) в config.php. 
Для обычного пользователя это бесполезная инфа.">Info о сим. ссылках и путях.</span>';

$_['text_extra_soft_install'] 	= '<span data-toggle="tooltip" title="Установка / удаление софта для суперсжатия (mozjpeg, optipng, webp) в соответствующую директорию">Установка / удаление серверного софта.</span>';


$_['text_cwebp_soft'] 	= '<span data-toggle="tooltip" title="Если не знаете, что выбрать, то выбирайте `cWebP soft for Linux core 2.6+`. На верхней строчке (3.10+) самый производительный. На нижней (2.6+) - самый универсальный. Для Windows не имеет значения.">Установка CWEBP</span>';


$_['text_image_manager'] 		= 'Менеджер изображений';
$_['text_watermark_img'] = '<span data-toggle="tooltip" title="Можете загрузить тестовую картинку (\'SITECREATOR\') для Watermark. <br>Не используйте анимированный GIF.">Файл-исходник водяного знака:</span>';
$_['text_watermark_posx'] = '<span data-toggle="tooltip" title="0--слева, 50--посередине, 100--справа">Позиция по оси X (0...100)</span>';
$_['text_watermark_posy'] = '<span data-toggle="tooltip" title="0--сверху, 50--посередине, 100--снизу:">Позиция по оси Y (0...100)</span>';
$_['text_watermark_degree'] = '<span data-toggle="tooltip" title="Против часовой. Линейный размер может меняться чтобы вписаться в ограничения по ширине/высоте.">Угол поворота град. (0...360)</span>';
$_['text_watermark_width'] = 'Размер не более по ШИРИНЕ (0...100)%:';
$_['text_watermark_height'] = 'Размер не более по ВЫСОТЕ (0...100)%:';
$_['text_watermark_opacity'] = '<span data-toggle="tooltip" title="0 - Watermark не виден (полная НЕпрозрачность)">Прозрачность watermark (0...100)%:</span>';
$_['text_watermark_test'] = '<span data-toggle="tooltip" title="Картинка кликабельна для увеличения.<br>  Если нет картинки, то проверьте ПРАВА группе пользователей для: module/watermark_by_sitecreator<br> и/text_watermark_testили ОБНОВИТЕ МОДИФИКАТОРЫ!<br><br> Если видите \'!\', то вы удалили изображение /image/sitecreator/watermark_by_sitecreator_test.jpg">Тест-Preview (без сохранения настроек):</span>';
$_['text_watermark_test_error'] = '<br>Если вместо изображения вы видите это сообщение, то сделайте:<br> 1) Обновите кеш модификаторов<br> 2) Выставите права доступа для группы пользователей (в админке) для  module/watermark_by_sitecreator<br> 3) Проверьте права (Linux) на файлы и папку image, image/cache<br> 4) очистите кеш<br>  image/cache/sitecreator<br>
5) устанавливайте модуль через установщик OCMOD движка, а не через FTP';


$_['text_test_compressing'] = '<span data-toggle="tooltip" title="Будут созданы две картинки с почти одинаковым названием, но 2-я (\'ДО\') отличается добавкой к названию _no_mozjpeg_ (_no_optipng_ для PNG). <br>ВНИМАНИЕ: только для короткого теста, иначе кеш будет ДВОЙНОГО размера. ">Сравнение размеров файлов ДО и ПОСЛЕ Суперсжатия.</span>';
$_['text_webp_enable_jpeg'] = '<span data-toggle="tooltip" title="Кроме JPEG создать его сжатую копию в WebP. Браузеры, не поддерживающие WebP, загрузят JPEG.<br>В кеше будут два файла с одинаковым названием, но с расширениями .jpeg и .webp соответственно.
<br><br>Если опция не выбрана, то вывода WEBP не будет даже при наличии самого файла.">WebP создать для JPEG (WebP + JPEG)</span>';

$_['text_webp_on_the_fly'] = '<span data-toggle="tooltip" title="Если есть ускорители (кешеровщики), то необходимо очистить их кеш чтобы могли создаваться WebP.  Кеш изображений (JPEG, PNG) очищать при этом НЕ обязательно и не рекомендуется чтобы не создавать всплеска ненужной нагрузки. Используется щадящий для ресурсов режим.
<br><br>Данный режим не рекомендуется на слабом хостинге. Вместо него используйте создание `по расписанию`.">WebP создавать НА ЛЕТУ (щадящий режим)</span>';
$_['text_img_output_google_compatibility'] = '<span data-toggle="tooltip" title="Даем понять Гуглу, что нужно индексировать как Webp, так и парное изображение JPEG/PNG. 
При отключенной галочке Гугл может проиндексировать только WebP. Но такой режим максимально совместим с шаблонами (темами) оформления.<br><br>
Галочку рекомендуется включать при отсутствии визуальных проблем.">
Улучшение индексации поисковиками Webp+JPEG/PNG</span>';

$_['text_if_universal_cache'] = '<span data-toggle="tooltip" title="Без надобности не включать! Экспериментально - как есть. БЕЗ 100% ГАРАНТИИ СОВМЕСТИМОСТИ для любого случая.<br>
Обеспечивает корректный вывод WEBP и, соответственно, JPG, PNG в браузеры с поддержкой WEBP и без нее. Для создания WEBP необходима очистка кеша ускорителя. Рекомендуется только ФОРСИРОВАННЫЙ режим создания WEBP.<br>
Если модуль Компрессор поддерживает ускоритель на 100%, т.е. для такого ускорителя модуль СПЕЦИАЛЬНО уже адаптирован (или не требуется адаптация), то включать эту опцию не надо, 
т.к. несколько снижается возможность использования webp для всех изображений.<br>
Опция служит для неподдерживаемых или неизвестных кеширующих ускорителей. Отключите в ускорителе оптимизацию (минификацию) для кода Javascript на странице HTML.
"><b style="color:#037c18;">Включить СОВМЕСТИМОСТЬ с  кеширующим страницы (HTML) УСКОРИТЕЛЕМ!</b> <br><b style="color:red;">Не включать при использовании JetCache, Turbo!</b>
<br>Требуется исключительное <b style="color:red;">ВНИМАНИЕ!</b> <br>Требуется осознанный выбор других опций (нельзя включать все, что попало методом `тыка`!)</span>';

$_['text_if_js_optimized'] = '<span data-toggle="tooltip" title="Использовать только как крайнюю меру. НЕ РЕКОМЕНДУЕТСЯ! 100% совместимость везде не гарантирована. Включите эту опцию если в ускорителе используется оптимизация JS и вы включили опцию СОВМЕСТИМОСТИ с любым кеширующим ускорителем.
 В других случаях нет надобности включать эту опцию чтобы не снижать производительность. Может возникнуть неравномерность отображения изображений из-за особенностей ускорения JS ускорителем.">
 <b style="color:red;">Повышенное ВНИМАНИЕ!</b> Если в ускорителе включена оптимизация JS</span>';

$_['text_webp_for_tag_a'] = '<span data-toggle="tooltip" title="ОТМЕНА замены в теге *A* атрибутов href, data-***, которые содержат ссылки на изображения.<br>
В редких случаях JavaScript не желает признавать ссылку на WEBP как ссылку на изображение. Это ошибка некоторых скриптов.<br>
Не рекомендуется делать отмену."><b style="color:#a80a00;">ОТМЕНИТЬ</b> для <b style="color:#a80a00;">ТЕГА &lt;A&gt;</b> вывод WEBP</span>';

$_['text_webp_for_data_attr'] = '<span data-toggle="tooltip" title="ОТМЕНА замены для тегов *IMG*, *A* в атрибуте data-***  ссылки на изображения.<br>
Как правило такая замена JPEG, PNG на WEBP происходит удачно. Если вас это не устраивает, то вы можете ОТМЕНИТЬ такое действие, тогда будут выводиться как обычно JPEG, PNG. <br>
Не рекомендуется делать отмену."><b style="color:#a80a00;">ОТМЕНИТЬ</b> для атрибута <b style="color:#a80a00;">data-***</b> вывод WEBP.</span>';

$_['text_webp_for_js'] = '<span  data-toggle="tooltip" title="Использовать с ОСТОРОЖНОСТЬЮ!!!<br>'."\r\n".'
В редких случаях бывает полезно. Некоторые неудачно написанные скрипты JS берут информацию о файле изображения не из тегов HTML, а прописывают ее в код JS, тогда включение данной опции может быть оправдано. <br>
Если сомневаетесь, то не включайте!<br><br>
Из соображений надежности в JS на странице заменяются только полные абсолютные пути до изображения, включающие HTTP(S). ">Замена JPEG, PNG на WEBP в коде <b style="color:#a80a00;">JavaScript (ОСТОРОЖНО!)</b></span>';

$_['text_webp_additional'] = '<span data-toggle="tooltip" title="Благодаря этому на смартфоны не загружаются огромные изображения, предназначенные для больших экранов. 
В результате выполняется рекомендация гугла `Настройте подходящий размер изображений`.">
Создавать дополнительные WEBP для экранов малой ширины.<br>
Работает только совместно с функцией Lazy Load (JavaScript).</span>';

$_['text_webp_recreate_input_file'] = '<span data-toggle="tooltip" title="Работает только в момент создания изображения WEBP в папке кеша к существующим JPEG и PNG в кеше. 
 Если файл JPEG или PNG окажется битый, то он будет удален и повторно создан.
 Если есть ускоритель, который кеширует HTML, то на время желательно его отключить или переиодически очищать кеш ускорителя.">
Пытаться восстановить битые изображения JPEG, PNG в кеше изображений.</span>';

$_['text_webp_recreate_input_file_force'] = '<span data-toggle="tooltip" title="Работает проверка файла JPEG или PNG (в кеше) в момент ВЫВОДА  WEBP. Битый файл будет удален и создан заново.
Галочка выше `Пытаться восстановить битые изображения...` должна быть включена. Не надо включать на постоянной основе! Это средство ЛЕЧЕНИЯ. 
<br><br>Включать только с целью сканирования JPEG и PNG на предмет повреждения и исправления.">
<b style="color:#a80a00;">Форсированный режим восстановления битых изображений в кеше. <br>
Нагружает сервер! Может замедлиться отдача страницы.</b></span>';


$_['text_webp_fly_mode'] = '<span data-toggle="tooltip" title="`Форсированный НА ЛЕТУ` позволяет создавать WebP без очистки кеша ускорителя (если такой ускоритель модуль Компрессор поддерживает на 100%)  и сразу при открытии страницы, но потребляет больше ресурсов. 
Страница может существенно тормозить при первом ее открытии.<br><br>
`Щадящий НА ЛЕТУ` потребляет мало ресурсов, WebP создается не сразу, требуется очистка (иногда дважды) кеша ускорителя.">Режим создания WebP</span>';

$_['text_no_check_htaccess'] = '<span data-toggle="tooltip" title="
Если WEBP отдает в браузер веб-сервер apache, то необходимо задать правильный тип (`image/webp`) и кеширование для этих файлов.
Если не отключать, то автоматически проверяется наличие файла .htaccess, в случае его отсутствия он автоматически создается.
<br>Создается из файла `/system/library/sitecreator/htaccess_for_webp.txt`.
<br><br>Рекомендуется содержимое этого файла добавить в .htaccess, находящийся в корне сайта.">Не проверять наличие .htaccess (для WEBP) в папке image/cache и не создавать.</span>';

$_['text_webp_exception'] = '<div style="color:#d06404">Правила ИСКЛЮЧЕНИЯ страниц для выдачи WEBP и JS Lazy Load</div>';
$_['text_webp_for_only_full_html5'] = '<span data-toggle="tooltip" title="На неполных страницах HTML, не содержащих <!DOCTYPE html>, WEBP выводиться не будет.
 Если у вас динамически подгружается страница с изображениями, то webp в этой части страницы не будет. 
 Данную опцию имеет смысл включать если возникает какой-то конфликт.">Выводить WEBP только на полных страницах HTML5</span>';


$_['text_lazy_load_pro'] = '<span style="font-weight:normal;" data-toggle="tooltip" title="Данный файл должен находиться здесь: /catalog/view/javascript/sitecreator/lazyload_start_alt.js
<br>Сделайте этот файл как копию lazyload_start.js и правьте.  НУЖНЫ знания JavaScript и понимание верстки!!!">Некоторые шаблоны и баннеры требуют особого внимания! <br>Может потребоваться <b>создание</b> и правка файла <b>lazyload_start_alt.js</b>. 
Обычно это связано с необходимостью корректного отображения сложных анимационных баннеров и слайдеров.<br>
Необходимо <b style="color:#a80a00;">отключить сторонний</b> (или встроенный в шаблон) функционал <b style="color:#a80a00;">Lazy Load</b><br>
Стороннний JavaScript lazy load может также влиять на корректный вывод webp.</span>';

$_['text_webp_warning'] = '<span style="font-weight:normal;" data-toggle="tooltip" title="">Рекомендуется отключить сторонний (или встроенный в шаблон) функционал Lazy Load.
Стороннний JavaScript lazy load может  влиять в определенных случаях на корректный вывод webp.</span>';


$_['text_lazy_load'] = '<span data-toggle="tooltip" title="`Ленивая загрузка` - подгружаем изображения по мере  необходимости их отображения. 
НЕОБХОДИМО отключить подобный функционал в движке (если есть) от стороннего разработчика. 
Работает только при включенной функции вывода WEBP. 
Сама же `Ленивая загрузка` работает как для webp, так и для jpeg, png в браузерах, которые не поддерживают webp."><b style="color: green;">LAZY LOAD</b> для webp, jpg, png. <br>
(Вывод webp должен быть включен)</span>';

$_['text_lazy_load_alt_js'] = '<span data-toggle="tooltip" title="Использовать  lazyload_start_alt.js вместо стандартного lazyload_start.js. 
Можете создать пустой lazyload_start_alt.js и скопировать в него содержимое lazyload_start.js. Далее редактируйте lazyload_start_alt.js.
Последующие обновления модуля не будут затирать эти изменения.">Использовать альтернативный JS lazyload_start_alt.js</span>';

$_['text_owl2_not_optimize'] = '<span data-toggle="tooltip" title="Если вы используете `Owl Carousel 2` совместно с Lazy Load за счет средств  `Owl Carousel 2`, 
то модуль автоматически применит для нее собственный Lazy Load (JavaScript) с созданием дополнительных изображений для смартфонов (если включена такая опция).
Если по какой-то причине вас это не устраивает, то вы можете отключить такой функционал.">НЕ оптимизировать "Owl Carousel 2"</span>';


$_['text_lazy_wait_img'] = '<span data-toggle="tooltip" title="ВНИМАНИЕ! <br><br>Приводит к небольшому снижению производительности. Хоть это выглядит привлекательно, 
но для браузера это лишняя операция, загружающая процессор. Гугл может не одобрить и снизить оценку в `pagespeed` на несколько баллов.">Выводить знак <img width="16" height="16" src="view/image/sitecreator/lazyl_wait32.gif"> `ожидание загрузки` пока изображение не загрузилось.<br>
Рекомендуется <b style="color:#a80a00;">только для тестов.</b>.</span>
';

$_['text_config_compression_warning'] = '<span style="color:red;">Установите <b>`Уровень GZIP сжатия`</b> в НОЛЬ!!! Это в `настроки магазина`->`сервер`. <br>
Движок Opencart не должен сжимать HTML, это УЖЕ делает ЛЮБОЙ сервер САМ. Иначе возникают ошибки и впустую расходуются ресурсы.<br>
Если вы это не исправите, то будут проблемы с выводом WEBP.<br><br>
Сейчас параметр отличен от НУЛЯ и равен: </span>';



$_['text_lazyload_type'] = '<span data-toggle="tooltip" title="
loading=`lazy` + decoding=`async` - этот нативный (встроен в браузер) способ практически безконфликтный с другим JavaScript, положительно оценивается в google.com/speed/pagespeed/insights/. 
Способ `JavaScript` эффективен в любом браузере, но требует визуальной проверки на отсутствие конфликтов с другим JavaScript."><b style="color:green;">Способ Lazy Load</b></span>';

$_['text_lazyload_wait_img_type'] = '<span data-toggle="tooltip" title="
Поскольку `lazy Load` - это отложенная загрузка изображения, 
то до отображения основного изображения надо выбрать тип замещающего (временного) его изображения, который позволить сделать максимально быстрый и корректный рендеринг страницы."> Тип временного изображения (атрибут src), отображаемое  до загрузки основного.</span>';


$_['text_webp_enable_png'] = '<span data-toggle="tooltip" title="Кроме PNG создать его сжатую копию в WebP. Браузеры, не поддерживающие WebP, загрузят PNG.<br>В кеше будут два файла с одинаковым названием, но с расширениями .png и .webp соответственно.<br>
<b>Если у вас выбран движок GD для создания WEBP</b>, то WebP будет создан без альфа-канала (прозрачности), но с белым фоном вместо него. GD (в большинстве случаев) не умеет создавать альфа-канал для WebP.
<br><br>Если опция не выбрана, то вывода WEBP не будет даже при наличии самого файла.">WebP создать для  PNG (WebP + PNG)</span>';
$_['text_webp_png_lossless'] = '<span data-toggle="tooltip" title="Если не выбрано, то уровень качества PNG >> WebP такой же как для JPEG >> WebP">WebP из PNG без потерь (lossless)</span>';
$_['text_webp_webp_white_png_gd'] = '<span data-toggle="tooltip" title="GD некоторых версий не умеют работать с альфа-каналом, а потому создают черный фон в файле WEBP. 
Установите эту опцию чтобы исправить данную проблему.  Прозрачный фон будет заменен на белый!">Если движок GD, то использовать БЕЛЫЙ фон для PNG с альфа-каналом</span>';

$_['text_webp_create_only'] =
  '<span style="color:red;" data-toggle="tooltip" title="Предполагается, что вывод будет происходить альтернативным способом, например, за счет соответствующей конфигурации nginx или apache (файл .htaccess). 
  При этом в коде HTML не будут присутствовать webp, но это не помеха для загрузки webp и отображения их браузером. Это может быть использовано при наличии кеширующего ускорителя.">Только создавать webp, но НЕ ВЫВОДИТЬ средствами модуля.</span>';



$_['text_mozjpeg_readme'] = '<span data-toggle="tooltip" title="После согласия вы получите разблокированные опции. <br> * ВНИМАТЕЛЬНО ознакомьтесь! *<br> Для четения важного текста откройте его кнопкой<br> `Показать/скрыть Предупреждение!`">Я прочитал "предупреждение"<br> ("ОБЯЗАТЕЛЬНО К ПРОЧТЕНИЮ!") о работе mozjpeg, optipng  <br><b style="color:#a80a00;">и осознаю свои действия</b>.</span>';
$_['text_mozjpeg_enable'] = '<span data-toggle="tooltip" title="Сжать JPEG максимально. Этот способ суперсжатия доступен  при наличии соответствующего софта"><b style="color:green">MOZJPEG</b> для JPEG "на лету" (!)</span>';
$_['text_mozjpeg_warning_before'] = '<b style="color:#a80a00; font-size: 14px;">ОБЯЗАТЕЛЬНО К ПРОЧТЕНИЮ!</b><br>
<b>Рекомендуется использовать WEBP</b> в качестве сжатого формата (для JPEG, PNG). 
WEBP создается быстро, не требует очистки кеша изображений, т.е. не создает лишней нагрузки во время создания.  
MOZJPEG требует для создания сжатого JPEG очистки кеша изображений,  работает примерно в 3 раза медленнее при создании чем WEBP, что вызывает временно (только в момент создания)
повышенную нагрузку на сервер.  ';
$_['text_mozjpeg_warning'] = '<span data-toggle="tooltip" title="">
Если вы не обладаете достаточной мощностью сервера, то используйте только создание WEBP, это обеспечит минимальную нагрузку на сервер во время создания сжатых изображений.
<br>OPTIPNG работает на порядок дольше при создании сжатого PNG чем  WEBP, а по эффективности в плане веса сильно уступает WEBP. Включайте осознанно этот режим.
<br> <span style="color:#a80a00; font-size: 16px;">Если у вас есть сомнения и вы не хотите создавать (хоть и временные) тормоза сайта, то <b>используйте только WEBP</b></span>.
<br><br> 
<b>ВНИМАНИЕ!</b> Повышенное потребление ресурсов сервера происходит только в момент создания изображения, как только изображения созданы, то потребление ресурсов приходит в обычную норму.
Если работает режим "на лету", то это значит, что изображения создаются при перовм или втором открытии страницы, именно в этот момент страница открывается дольше привычного.
Далее страница открывается как обычно с привычной скоростью.<br><br>
С целью экономии ресурсов сервера <b>не рекомендуется включать одновременно создание MOZJPEG, OPTIPNG и WEBP</b>. 
Всегда включайте создание WEBP позже, этот формат может быть создан в любой момент.  Если решили использовать MOZJPEG, OPTIPNG,  
то пусть сперва отработают эти алгоритмы и будет создан кеш сжатых JPEG, PNG.  Как только нагрузка по созданию нового сжатого кеша упадет, то тогда можно включать режим создания WEBP.
<br>
Если у вас мощности сервера достаточно, то тогда допускается одновременное включение MOZJPEG и создание WEBP. 
Если видите, что сервер тяжело справляется, то отключите тяжелые режимы. 
<br>
Выбор правильной стратегии сжатия и верных настроек обеспечит комфортный режим работы вашего сайта. 
Наоборот, бездумное выставление всех галочек может привести к временным "тормозам" вашего сайта.
<br>
Включение режима "Сравнение размеров" на постоянной основе недопустимо!  Это приводит к повышенной нагрузке и бесполезной трате дискового пространства!
<br><br>
Если изображения созданы (находятся в кеше), то далее модуль Компрессор практически никак уже не влияет на скорость открытия страницы.
<br>
<b>Кеш изображений создается только один раз.</b> На это требуется некоторое время.
<br><br>Замедление открытия страницы во время создания изображений "на лету" - это нормально. Чудес не бывает, работа с графикой - не мгновенная операция, а потому процессору требуется время чтобы создать и сжать новые изображения.
Это (замедление) происходит лишь единожды  во время первого (второго) открытия страницы.
<br><br>
<b>Режим создания изображений "по расписанию" вообще не приводит к тормозам страницы</b>, т.к. вся нагрузка по такому созданию распределяется равномерно.
</span>';

$_['text_optipng_enable'] = '<span data-toggle="tooltip" title="Сжать PNG максимально. Этот способ суперсжатия доступен  при наличии соответствующего софта. <br> Может работать медленно если много файлов PNG."><b style="color:green">OptiPNG</b> для PNG "на лету" (!)<br><b style="color: #a80a00;">Работает ДОЛГО</b> (особенно актуально для общего хостинга)</span>';
$_['text_optipng_level'] = '<span data-toggle="tooltip" title="Уровень выше 3 может привести к медленной работе с PNG и редко приводит к дополнительному существенному сжатию файла.">Уровень оптимизации OptiPNG</span>';
$_['text_imagick_disable'] = '<span data-toggle="tooltip" title="Будет использована GD-библиотека. Для случая старой версии ImageMagick или ImageMagick с проблемами. <br><b>Не рекомендуется отключать</b> во всех остальных случаях, т. к. падает производительность.">Не использовать imagick / ImageMagick</span>';

$_['text_crop'] = '<span data-toggle="tooltip" title="Обеспечивает создание изображений (по возможности) без белых полей.<br>none - нет,<br>w - уместить по ширине (обрезать по высоте),<br>h - уместить по высоте (обрезать по ширине),<br>auto - автоматически,<br>no border - ВСЕГДА без полей и картинка целиком без обрезки (высота рассчитывается автоматически при фиксированной ширине)">Адаптивный "resize"/ Адаптивная обрезка <br>(действует для ВСЕХ изображений):</span>';

$_['text_img_custom_background_color'] = '<span data-toggle="tooltip" title="Допустимый формат: шестнадцатеричный без знака #. Только 6 цифр и/или букв abcdef ABCDEF.<br>
 Пример для белого: FFFFFF<br>Можно выбрать также на палитре цветов.">Цвет полей, добавляемых к изображению. БЕЛЫЙ - стандартно</span>';


$_['text_for_popup_img_noborder'] = '<span data-toggle="tooltip" title="Всплывающее изображение определяется по его размеру, заданному в шаблоне. Данное правило будет применено ко всем изображениям такого же размера.">НЕ создавать белые ПОЛЯ :</span>';
$_['text_for_popup_img_fit_to_width_nocrop'] = '<span data-toggle="tooltip" title="Всплывающее изображение определяется по его размеру, заданному в шаблоне. Данное правило будет применено ко всем изображениям такого же размера. Адаптивная обрезка ОТМЕНЯЕТСЯ. Поля не создаются.">Уместить по ширине, высота не ограничена:</span>';
$_['text_for_popup_img_no_max_fit'] = '<span data-toggle="tooltip" title="Всплывающее изображение определяется по его размеру, заданному в шаблоне. Данное правило будет применено ко всем изображениям такого же размера. <br> Позволяет избежать размытости.">НЕ увеличивать сверх размеров (геометр.) исходника:</span>';
$_['text_for_popup_img_white_back'] = '<span data-toggle="tooltip" title="Всплывающее изображение определяется по его размеру, заданному в шаблоне. Данное правило будет применено ко всем изображениям такого же размера. <br> Прозрачные участки будут заменены белым фоном.">Для PNG с альфа-каналом использовать БЕЛЫЙ фон:</span>';


$_['text_for_thumb_img_noborder'] = '<span data-toggle="tooltip" title="Thumbnail (основное на стр. \'Товар\') изображение определяется по его размеру, заданному в шаблоне. Данное правило будет применено ко всем изображениям такого же размера.">НЕ создавать белые ПОЛЯ :</span>';
$_['text_for_thumb_img_fit_to_width_nocrop'] = '<span data-toggle="tooltip" title="Thumbnail (основное на стр. \'Товар\') изображение определяется по его размеру, заданному в шаблоне. Данное правило будет применено ко всем изображениям такого же размера. Адаптивная обрезка ОТМЕНЯЕТСЯ. Поля не создаются.">Уместить по ширине, высота не ограничена:</span>';
$_['text_for_thumb_img_no_max_fit'] = '<span data-toggle="tooltip" title="Thumbnail (основное на стр. \'Товар\') изображение определяется по его размеру, заданному в шаблоне. Данное правило будет применено ко всем изображениям такого же размера. <br> Позволяет избежать размытости.">НЕ увеличивать сверх размеров (геометр.) исходника:</span>';
$_['text_for_thumb_img_white_back'] = '<span data-toggle="tooltip" title="Thumbnail (основное на стр. \'Товар\') изображение определяется по его размеру, заданному в шаблоне. Данное правило будет применено ко всем изображениям такого же размера. <br> Прозрачные участки будут заменены белым фоном.">Для PNG с альфа-каналом использовать БЕЛЫЙ фон:</span>';

$_['text_warning_for_product_img'] = '<span style="color:#a80a00;" >ОСТОРОЖНО! Установка этих опций может привести к поломке верстки! 
Удаление белых полей позволяет получить существенный выигрыш в весе файла, но обычно <b>требуется коррекция верстки!</b></span><span> 
<br>Это связано с тем, что в Opencart изначально белые поля являются  частью концепции верстки, которая на сегодняшний день является устаревшей и неудачной, в том числе из-за ненужного увеличения веса файлов.
 Благодаря правильной верстке вы можете снизить общий вес файлов еще на 20%-30% в среднем.</span>';
$_['text_for_product_img_noborder'] = '<span style="color:#a80a00;" data-toggle="tooltip" title="Изображение в СПИСКЕ ТОВАРОВ определяется по его размеру, заданному в шаблоне. Данное правило будет применено ко всем изображениям такого же размера.
<br><br>Удаление белых полей часто нужно компенсировать правильной ВЕРСТКОЙ! НЕ включайте если не понимаете как это сделать, иначе <br><br><b>можете сломать ВЕРСТКУ!</b>">НЕ создавать белые ПОЛЯ<br>
ВНИМАТЕЛЬНО читайте примечание чтобы не поломать верстку!!!</span>';
$_['text_for_product_img_fit_to_width_nocrop'] = '<span style="color:#a80a00;"  data-toggle="tooltip" title="Изображение в СПИСКЕ ТОВАРОВ определяется по его размеру, заданному в шаблоне. Данное правило будет применено ко всем изображениям такого же размера. Адаптивная обрезка ОТМЕНЯЕТСЯ. Поля не создаются.
<br><br>Изменение геометрии часто нужно компенсировать правильной ВЕРСТКОЙ! НЕ включайте если не понимаете как это сделать, <br><br><b>иначе можете сломать ВЕРСТКУ!</b>">Уместить по ширине, высота не ограничена:</span>';
$_['text_for_product_img_no_max_fit'] = '<span data-toggle="tooltip" title="Изображение в СПИСКЕ ТОВАРОВ определяется по его размеру, заданному в шаблоне. Данное правило будет применено ко всем изображениям такого же размера. <br> Позволяет избежать размытости.">НЕ увеличивать сверх размеров (геометр.) исходника:</span>';
$_['text_for_product_img_white_back'] = '<span data-toggle="tooltip" title="Изображение в СПИСКЕ ТОВАРОВ определяется по его размеру, заданному в шаблоне. Данное правило будет применено ко всем изображениям такого же размера. <br> Прозрачные участки будут заменены белым фоном.">Для PNG с альфа-каналом использовать БЕЛЫЙ фон:</span>';




$_['text_fuzz'] = '<span data-toggle="tooltip" title="Параметр, определяющий насколько близко два разных цвета могут считаться одинаковыми в фоне. От 0 до 65535 (обычно 0...1500).
  Определяется опытным путем. Справедливо для полноцветных (RGB: 8 бит/канал ) изображений.">fuzz - Диапазон одинаковости (равномерности) цвета</span>';
$_['text_enable_trim'] = '<span data-toggle="tooltip" title="Обрезать фон в соответствии с fuzz. Чем выше fuzz, то тем более разные цвета считаются в фоне одинаковыми.">ОБРЕЗАТЬ фон</span>';
$_['text_trim_cache'] = '<span data-toggle="tooltip" title="Ускоряет создание изображений разных размеров из одного исходника. Не рекомендуется выключать. Очищается вместе с обычным кешем изображений.">Кешировать результат обрезки источника</span>';

$_['text_enable_multitrim'] = '<span data-toggle="tooltip" title="Полезно в случае сложного фона с резкими переходами. Например, белые поля + серый фон. Если у картинки однородный (простой) фон,
то нет нужды включать 2-х проходный способ.  2-й проход усложняет расчет и отрисовку бордера. По сути сначала отрезается 1-й (внешний) фон, потом 2-й (внутренний).  <BR>НАГРУЗКА НА ПРОЦЕССОР ВЫШЕ чем при одинарном проходе.">Обрезать в два прохода <br><b style="color: #a80a00;">(Потребляет БОЛЬШЕ ресурсов)</b></span>';
$_['text_trim_border'] = '<span data-toggle="tooltip" title="Не обрезать фон полностью, а оставить вокруг бордер, размером в % от итогового размера после обрезки \'под корень\'.  
Бордер не рисуется кистью или цветом, и не накладывается никакое дополнительное изображение на бордер, бордер - это часть исходного изображения. И если в исходном изображении нет места для бордера нужной ширины, 
то и в конечном изображении бордер будет той максимально возможной ширины, которую может обеспечить исходное изображение, т. е. без выхода за пределы исходного. 
">Оставить вокруг border (рамку) [берется из всего исходного изображения], шириной максимум в % <br>(читайте примечание-справку!)</span>';
$_['text_border_after_trim1'] = '<span data-toggle="tooltip" title="Полезно в том случае если есть сложный исходный фон с контрастными 2-мя цветами и резким переходом, например, белый (наружный фон) + серый (внутренний фон) с резкими границами. 
В данном случае бордер будет браться только из серого фона, т.е. из внутреннего фона. Цвета фонов приведены для примера, они могут быть любыми.">Бордер берется из фона, оставшегося после 1-го прохода</span>';
$_['text_enable_color_for_fill'] = '<span data-toggle="tooltip" title="При 2-х проходном методе всегда берется цвет внутреннего фона, т. к. внешний отрезается.">Использовать цвет фона из ИСХОДНИКА вместо белого для заливки полей стандартным способом движка.</span>';
$_['text_enable_border_fill'] = '<span data-toggle="tooltip" title="Цвет заливки бордера определяется автоматически по цвету фона.">Делать бордер заливкой цветом фона если бордер нельзя взять из исходника целиком.</span>';


$_['text_trim_maxi_w_and_h'] = '<span data-toggle="tooltip" title="Подразумевается ЗАДАННАЯ ширина или высота конечного изображения. Выполнены должны быть оба условия (по ширине и высоте).">НЕ обрабатывать фон если по ширине или высоте (БОЛЬШЕ или равно):</span>';

$_['text_trim_mini_w_and_h'] = '<span data-toggle="tooltip" title="Подразумевается ЗАДАННАЯ ширина или высота конечного изображения. Выполнены должны быть оба условия (по ширине и высоте).">НЕ обрабатывать фон если по ширине или высоте (МЕНЬШЕ или равно):</span>';


$_['text_no_image'] = '<span data-toggle="tooltip" title="По умолчанию так сделано в ocstore 2.*, в оригинальном opencart (и в сборке *.pro) этого нет.  Нет изображения - это означает, что по указанному пути не найден исходник.">Если изображения нет, то подставить no_image для вывода</span>';
$_['text_crop_by_theme'] = '<span data-toggle="tooltip" title="Адаптивный resize может производиться лишь на определенных страницах по инициативе движка.  Параметр адаптивного ресайза (обрезки),
который передает движок, имеет более высокий приоритет чем аналогичный заданный параметр в модуле.">Разрешить движку (шаблону) инициировать адаптивный resize.</span>';
$_['text_secretpath'] = '<span data-toggle="tooltip" title="Защита файла исходного изображения от скачивания. В кеше находится переименованный (зашифрованное название) файл.">Секретный путь к исходнику.</span>';
$_['text_remove_trash_disable'] = '<span data-toggle="tooltip" title="Если вы неоднократно включали/выключали режим <<Секретный путь к исходнику>>, то возможно накопление файлов-дубликатов с разными именами (обычными и секретными). Обычно это касается только WEBP. По-умолчанию производится проверка дубликатов и их удаление. Это незначительно, но забирает ресурсы.">НЕ удалять мусор после секретных изменений.</span>';

$_['text_delduplicate'] = '<span data-toggle="tooltip" title="Если ранее был создан в кеше файл с обычным (для Opencart) названием вместо зашифрованного, то его можно удалить за ненадобностью.">Удалить из кеша файл-копию с несекретным названием.</span>';

$_['text_enable_market'] = '<span data-toggle="tooltip" 
title="Для ВСЕХ изображений указанного размера не применять водяной знак и не использовать сжатие.  Полезно для изображений, подготовленных для Яндекс-маркета и т. п."
>НЕ наклыдывать watermark и НЕ сжимать.</span>';
$_['text_market_w_and_h'] = '<span data-toggle="tooltip" 
title="Для ВСЕХ изображений указанного размера не применять водяной знак и не использовать сжатие если есть соответствующая галочка.  Полезно для изображений, подготовленных для Яндекс-маркета и т. п."
>При точном совпадении размеров с указанными НЕ накладывать и НЕ сжимать.</span>';


$_['text_img_quality'] = '<span data-toggle="tooltip" title="оптимально около 80 для imagick">Качество JPEG (0...100):</span>';
$_['text_webp_quality'] = '<span data-toggle="tooltip" title="Параметр для преобразования JPEG >> WebP и PNG >> WebP.<br> оптимально около 80...85">Качество WebP (0...100):</span>';

$_['text_img_mini_quality'] = '<span data-toggle="tooltip" title="оптимально около 70...80 для imagick">Качество JPEG (0...100) для изображений, ограниченных СВЕРХУ:</span>';
$_['text_img_mini_w_and_h'] = '<span data-toggle="tooltip" title="Условие выполняется если меньше или равно хотя бы по одной стороне. В противном случае действует параметр КАЧЕСТВО, заданный для ВСЕХ изображений">по ширине и высоте (меньше или равно):</span>';
$_['text_img_mini_if_and'] = '<span data-toggle="tooltip" title="Параметр Качество для маленьких изображений будет применен только если ОБА условия по размерам одновременно выполнены.">условие "И" (ширина <= w && высота <= h):</span>';


$_['text_img_maxi_quality'] = '<span data-toggle="tooltip" title="оптимально около 70...80 для imagick">Качество JPEG (0...100) для изображений, ограниченных СНИЗУ:</span>';
$_['text_img_maxi_w_and_h'] = '<span data-toggle="tooltip" title="Условие выполняется если больше или равно хотя бы по одной стороне. В противном случае действует параметр КАЧЕСТВО, заданный для ВСЕХ изображений">по ширине и высоте (больше или равно):</span>';
$_['text_img_maxi_if_and'] = '<span data-toggle="tooltip" title="Параметр Качество для больших изображений будет применен только если ОБА условия по размерам одновременно выполнены.">условие "И" (ширина >= w && высота >= h):</span>';
$_['text_img_maxi_no_compress'] = '<span data-toggle="tooltip" title="Если условия по размерам выполнены, то сжатие отключено для таких изображений.">НЕ сжимать (игнорировать параметры сжатия):</span>';

$_['text_webp_mode'] = '<span data-toggle="tooltip" title="Прежде чем выбрать движок необходимо на вкладке `Сервис` посмотреть результаты теста для движков WebP. 
Выбирайте один из успешно прошедших тест. Если вы выберете нерабочий движок, то WebP создаваться не будет, но это может замедлить открытие страницы сайта.
Обычно не прошедшие тест движки Webp автоматически скрываются от выбора в этом списке.<br><br>!!!<br>
Осторожно! GD может некорректно создавать webp.  Все зависит от версии GD. Проверяйте визуально!<br><br>
Рекомендуется по возможности выбирать  CWEBP или HTTP_CWEBP.">
Движок для создания WebP (ПРЕДПОЧТИТЕЛЬНО cwebp)</span>';

$_['text_webp_m_level'] = '<span data-toggle="tooltip" title="Действует только при выборе движка для WEBP: cwebp или http_cwebp. 
6-й уровень позволяет получить самый маленький файл, но работает долго. 0-й - это самый быстрый, но размер файла получается относительно большой. 
На вкладке `Сервис` вы можете произвести предварительно тест движка с разным уровнем оптимизации.<br>
Для создания WEBP из PNG действует постоянный уровень 4.">Уровень оптимизации создания WEBP из JPEG<br>Влияет на вес  файла и на скорость его создания</span>';


$_['text_webp_start_max'] = '<span data-toggle="tooltip" title="Позволяет контролировать нагрузку на ресурсы сервера. 
Если на странице много изображений, то создание WEBP для них можно делать не за один раз, а равномерно распределить.
<br><br>Относится к режимам `на лету`. 100 подходит для большинства случаев.">Ограничить создание WEBP `на лету` за один проход (за одну страницу) количеством:</span>';


$_['text_webp_start_max_cron'] = '<span data-toggle="tooltip" title="За один запуск задания CRON можно создать максимум WEBP файлов (шт).<br>
Если задание запускается каждую минуту, то это ограничение можно считать как количество файлов WEBP в минуту.<br><br>
Не нужно опасаться, что будет запущено новое задание когда еще не завершилось предыдущее, такая ситуация исключена - новое не начнет работу пока не завершится прежнее.">Ограничить создание WEBP `по расписанию` (CRON) за один проход (условно за одну минуту) количеством:</span>';


$_['text_webp_mode_test'] = '<span data-toggle="tooltip" title="Эти данные НЕ записываются в настройки, но служат исключительно для проведения ТЕСТА.  
На основе результатов теста вы можете выбрать нужный движок WebP на вкладке `Основные настройки`. 
В окне результатов теста отображаются данные для теста одного движка WebP если он успешно пройден. 
Тестируются сразу все движки WebP одновременно, но подробный результат показан для одного из успешных.">
Данные для ТЕСТА *движка* WebP</span>';

// Параметры для яндекс-маркета +++++++++++++++++++++++++++++++++ START

$_['text_market_img_quality'] = '<span data-toggle="tooltip" title="Оптимально около 80...90 (Для четкого текста лучше 90) <br>НИКОГДА НЕ СЖИМАЮТСЯ">Качество JPEG для Я-Маркета (0...100):</span>';
$_['text_market_watermark_enable'] = '<span data-toggle="tooltip" title="Дейстует только для изображений, помещаемых в отдельную папку кеша для Маркета. 
Наложение происходит с параметрами, заданными в блоке \'WATERMARK: настройки\'.  
Если в указанном блоке  не разрешено наложение watermark, то данная опция ни на что не влияет.">Накладывать watermark:</span>';
$_['text_market_stickers_enable'] = '<span data-toggle="tooltip" title="Дейстует только для изображений, помещаемых в отдельную папку кеша для Маркета">Накладывать индивидуальные СТИКЕРЫ:<br>
(<b class=\'my_warning\'>Нужен \'php imagick\'</b>)</span>';
$_['text_market_stickers_source_text'] = '<span data-toggle="tooltip" title="Используйте одно из полей при заполнении товара в качестве текста для стикеров. 
Стикеров может быть несколько (введены все в ОДНО поле). В качестве разделителя текста стикеров применяйте \'|\'">Источник текста для стикеров:</span>';

$_['text_market_override_image_size'] = '<span data-toggle="tooltip" title="Игнорировать размеры изображений, заданные в модуле выгрузки для Я-Маркета. Значения будут браться из настроек модуля \'Компрессор\'">Переопределить размеры изображений</span>';
$_['text_market_set_image_size'] = '<span data-toggle="tooltip" title="Действуют при включенной опции \'Переопределить размеры изображений\'">Размер изображения для Я-маркета</span>';
$_['text_market_image_generate_disable'] = '<span data-toggle="tooltip" title="Опция НЕДОСТУПНА, т.к. не реализована пока, зарезервировано для будущих версий. <br><br>Обычно XML генерируется с одновременным созданием изображений для выгрузки в я-маркет.  
Это вызывает долгое формирование XML и всплеск продолжительной высокой нагрузки. Алтернативой создания \'НА ЛЕТУ\' является формирование изображений в фоновом режиме по cron-у (по расписанию).">НЕ создавать изображения на лету одновременно с XML. (Снижает нагрузку благодаря запуску по расписанию). <br>НЕДОСТУПНО в этой версии</span>';
// Параметры для яндекс-маркета --------------------------------- END

$_['text_disable_admin_bar'] = '<span data-toggle="tooltip" title="Если разрешено показывать и ocmod для админ-бара действует (можно вкл/выкл на вкладке Сервис), то в front-end отображаются элементы управления администратора. Можно очищать кеш изображений для конкретной страницы.">Admin bar (доступно ТОЛЬКО АДМИНу) НЕ показывать</span>';

$_['text_white_back'] = '<span data-toggle="tooltip" title="Прозрачные участки будут заменены белым. Альфа-канала (прозрачности) не будет<br>Если нет imagick, но есть GD с поддержкой WebP, то это способ корректно преобразовать PNG >> WebP. ">Для PNG с альфа-каналом использовать БЕЛЫЙ фон <br>(применить ко ВСЕМ изображениям):</span>';

$_['text_img_info'] = '<span data-toggle="tooltip" title="Watermark может работать при наличии разных возможностей сервера и софта. Отсутствие какого-либо софта заставляет работать модуль менее эффективно в плане сжатия, но не хуже дефолтного (используется GD). Красный цвет лишь для информации. <br>Исходя из установленных возможностей вы можете ниже выбрать нужные опция сжатия. Модуль автоматически обнаружит нужный софт и будет его использовать.">Информация об установленном софте и возможностях:</span>';

$_['text_img_min_width_nowatermark'] = '<span data-toggle="tooltip" title="Если изображение МЕНЬШЕ хотя бы по одной стороне, то watermark не накладывается.">Watermark действует при МИНИМАЛЬНОМ размере стороны и ВЫШЕ</span>';
$_['text_img_max_width_nowatermark'] = '<span data-toggle="tooltip" title="Если изображение БОЛЬШЕ хотя бы по одной стороне, то watermark не накладывается.<br>Параметр MAX не должен быть меньше параметра MIN.">Watermark действует при МАКСИМАЛЬНОМ размере стороны и НИЖЕ</span>';

$_['text_module_copyright'] = '<p class="module_copyright"><a href="https://sitecreator.ru/">SiteCreator.ru &copy; 2017-2020</a>&nbsp;&nbsp;&nbsp; e-mail: <a href="mailto:opencart@sitecreator.ru">opencart@sitecreator.ru</a></p><h4>Image COMPRESSOR & Watermark & WebP & Lazy Load etc. by Sitecreator &copy; 2017-2020</h4>';

$_['text_watermark_dirs'] = '<span data-toggle="tooltip" title="Каждая папка без кавычек с НОВОЙ строки.  Правило действует и для вложенных папок. пути указывать относительно папки image">Для этих папок/файлов Watermark НЕ действует (рекурсивно):<br><br><span class="no_bold">каждая папка/файл без кавычек с НОВОЙ строки. Путь указывать относительно папки image. Например:<br><br>
catalog/avatars<br>catalog/demo<br>placeholder.png</span></span>';

$_['text_watermark_dirs_error'] = '<span data-toggle="tooltip" title="Формально это не ошибка, а напоминание.  Несуществующие папки (файлы) не влияют на работу.">Указанные папки/файлы не найдены!<br>Проверьте правильность введенных выше данных!</span>';

$_['text_warning'] = '<h4 style="color: #fff; background: #b7b8b9; padding: 10px 15px;">Если вы устанавливали/изменяли дополнительный софт (mozjpeg, optipng и т.п.) на сервере, то нажмите "сохранить и ОСТАТЬСЯ" в данном модуле.</h4><br>
<div style="color: #fff; background: #12b975; padding: 10px 15px;">Для генерирования WebP не надо очищать кеш изображений. Но может потребоваться отчистка системного кеша и кеша вашего ускорителя (кешеровщика)</div><br>';

$_['text_dirs_noTrim'] = '<span data-toggle="tooltip" title="Каждая папка без кавычек с НОВОЙ строки.  Правило действует и для вложенных папок. пути указывать относительно папки image">Для этих папок/файлов ОБРЕЗКА ФОНА ИСХОДНИКА НЕ действует (рекурсивно):<br><br><span class="no_bold">каждая папка/файл без кавычек с НОВОЙ строки. Путь указывать относительно папки image. Например:<br><br>
catalog/avatars<br>catalog/demo<br>placeholder.png</span></span>';
$_['text_dirs_error_noTrim'] = '<span data-toggle="tooltip" title="Формально это не ошибка, а напоминание.  Несуществующие папки (файлы) не влияют на работу.">Указанные папки/файлы не найдены!<br>Проверьте правильность введенных выше данных!</span>';

$_['text_cron_test_on_off'] = '<span data-toggle="tooltip" title="
Действует для <b>ТЕСТОВОГО и РАБОЧЕГО режима</b></b>.
<br><br>Не надо нажимать`Сохранить`. 
Состояние этого переключателя запоминается сразу после его изменения и не связано с другими настройками модуля.
<br>Если включено, то повторяться будет с периодом, который вы задали в настройках задания CRON (рекомендуется каждую минуту).<br><br>
ВНИМАНИЕ! Модуль не может за вас создать само задание CRON (и его расписание), его обязаны сделать вы сами.
 Задание будет выполнять свою функцию если оно ОДНОВРЕМЕННО включено в модуле и у хостера.
"><b>Активировать задание CRON для WEBP.</b><br>
Само задание должно быть создано в панели управления (аккаунте) хостера.</span>';

$_['text_cron_test_input_img'] = '<b>Входные изображения для теста создания WEBP с использованием CRON (Планировщика).</b><br>';

$_['text_cron_test_output_img'] = '<br><br><b style="color:#ffa117; font-size: 16px;">Выходные изображения (результат работы cron test-а по созданию WEBP).</b><br><br>
Ниже вы должны увидеть результат в виде WEB изображений, аналогичных входным изображениям. 
Результат должен появиться не позже чем через минуту с начала старта задания CRON если задание для CRON создано с интервалом выполнения в 1 минуту.  
Результат <b>выводится автоматически</b> каждую минуту.
Также чтобы увидеть вы можете нажать на кнопку `cron WEBP test`.
Если не видите, то нажмите спустя минуту еще раз или дождитесь автоматического вывода результата.  Счетчик показывает когда (через сколько секунд) произойдет автоматический вывод информации.
 <br><br>Задание CRON выполнятеся по заданному вами расписанию, это расписание не может быть задано здесь, вы его задаете в `Планировщике`. Изучайте, что такое CRON для Linux.<br><br>
<b>ВНИМАНИЕ!</b> Модуль не создает  задание CRON, не управляет его периодичностью.  Здесь лишь <b>выводятся результаты</b> работы вашего задания CRON. ';

$_['text_webp_png_lossless'] = '<span data-toggle="tooltip" title="Данный параметр действует при использовании cwebp в качестве движка для создания WebP. 
Размер выходного файла может быть существенно больше чем в случае преобразования с потерями.  Не рекомендуется включать эту опцию в большинстве случаев.">lossless (без потерь) для WebP из PNG</span>';

$_['text_cron_test_secret_key'] = '<span data-toggle="tooltip" title="Можете после появления ключа нажать `Сохранить` чтобы его значение было запомнено. 
Секретный ключ необходимо вводить как необходимый аргумент для запуска скрипта.  Смотрите ниже описание (пример) команды для запуска скрипта.">Нажмите `Create secret key` чтобы создать секретный ключ, необходимый для запуска скрипта для теста cron WEBP.</span>';

$_['text_cron_test_command'] = '<span data-toggle="tooltip" title=""><b>Пример задания для CRON. Сама команда.</b><br>
Выглядит  так (на рабочем примере Linux Centos 7), жирным выделено то, что будет неизменно для любого сайта, кавычки обязательны.<br>
Первым в кавычках будет путь до вашего php (cli).  Обязательно используйте как минимум версию php 5.6 с ioncube loader 10+, а лучше используйте php 7.1, т.к. для него версия ioncube loader всегда будет 10+.
Версия php (cli) никак не связана с вашим php, на котором работает ваш сайт и она может отличаться, главное чтобы она была от 5.6 до 7.3 включительно.  <br><br>
Вторым в кавычках идет путь до скрипта. Подставляется в команду автоматически.<br>

Третьим в кавычках идет секретный ключ, который  вы создали. Подставляется в команду автоматически.<br><br>
<div class="shell_cmd" style="font-size: 13px;">
<b style="color:red;">"/opt/php71/bin/php"</b> "/var/www/user_alpha/data/www/site.com/<b>cli-php/sitecreator/cron_test_webp.php</b>" "d4fa91153ffa7183" <b>>/dev/null 2>&1</b></div><br><br>
<b>Команда для данного сайта</b><br><br>

В команде (для cron) вам необходимо задать путь до php, который будет соответствовать пути именно для вашего php (<b style="color:red;">CLI</b>) у вашего хостера. Это самое первое значение, заключенное в кавычки.
<br>Вот оно по умолчанию: <b style="color:red;">"php71"</b><br>
Очень часто достаточно вместо полного пути (до интерпретатора php) указать <b style="color:red;">"php71"</b> (можно без кавычек). Пробуйте сперва так. Уточняйте у хостера этот путь.
Этот параметр невозможно определить автоматически из модуля.<br>
Также просьба обратить внимание, что некоторые панели управления сами добавляют в конец <b style="color:red;">>/dev/null 2>&1</b>.  Тогда вам не надо это добавлять.
<br>
Созданную команду для CRON вам необходимо скопировать и вставить в соответствующее поле ("Команда для cron" или пободное) через панель управления (ваш аккаунт) хостера.
<br><br>
Проверить вашу версию интерпретатора php (cli) вы можете через shell (SSH). Например, для Linux Centos 7: <br><br>
<div class="shell_cmd">"/opt/php71/bin/php" -v</div>
<br><br>
Вы получите подобный вывод:
<br><br>
<div class="shell_cmd">PHP 7.1.22 (cli) (built: Sep 25 2018 11:35:44) ( NTS )
Copyright (c) 1997-2018 The PHP Group
Zend Engine v3.1.0, Copyright (c) 1998-2018 Zend Technologies
    with the ionCube PHP Loader (enabled) + Intrusion Protection from ioncube24.com (unconfigured) v10.2.0, Copyright (c) 2002-2018, by ionCube Ltd.
</div>
<br><br>
Для создания WEBP по расписанию (cron) необходимо чтобы у вас был уже установлен софт CWEBP. Его установка присзводится на вкладке "Сервис". 
Там же вы можете протестировать CWEBP по созданию CWEBP, но с условием, что у вас не отключена функция <b>proc_open</b>. 
Если же функция <b>proc_open</b> у вас отключена, то вы не сможете сделать тест на вкладке "Сервис", 
но это не означает, что данный софт у вас не будет работать через планировщик (cron). Убедиться в работоспособности CWEBP (cron) можно на этой вкладке.
Если вы не знаете какую версию CWEBP устанавливать, то устанавливайте <b>"WebP soft for Linux core 2.6+"</b>.
<br><br>
</span>';

$_['text_cron_test_2'] = '<b>Задайте период выполнения задания CRON "каждую минуту".</b> Это делается в панели управления (аккаунте) хостера.';


$_['text_php_cli_path'] = '<span data-toggle="tooltip" title="Вводите путь по возможности до интерпретатора php 7.1 или, в случае минимальных требований, до php 5.6 с ioncube loader 10+. 
<br><br>Не надо вводить просто `php`, т.к. в этом случае вы, скорее всего, будете обращаться к интерпретатору php старой версии, например php 5.4.">Введите путь до PHP (CLI) интерпретатора без кавычек.
<b style="color:red;">Не надо вводить просто "php"</b>.
</span>';

$_['text_cron_webp_mode'] = '<span data-toggle="tooltip" title="Прежде чем выставлять рабочий режим убедитесь, что тестовый работает без проблем, т.е. создаются тестовые WEBP изображения.">Режим работы создания WEBP по расписанию (cron)</span>';


$_['text_btn_cron_webp_test_clear_imgs_help'] = 'Полезно бывает удалить ранее созданные изображения чтобы убедиться, что тест пройден именно сейчас, а не ранее.';

$_['text_tab_cron_head'] = '<h3>Настройки создания WEBP по расписанию (через задание CRON)</h3>
<h2 style="color:#107e1f; font-size: 16px; font-weight: bold;">Работает даже в случае отсутствия proc_open (EXEC) в PHP, на котором работает ваш сайт.</h2><br>';

$_['text_tab_webp_stat_head'] = '<h3>Статистика создания WEBP при работе по расписанию (CRON)</h3>';

$_['text_webplogo'] = '';
$webplogo_file = DIR_IMAGE. 'sitecreator/webplogo.png';
if(is_file($webplogo_file)) {
  $webplogo = file_get_contents($webplogo_file);
  if($webplogo !== false) {
    $webplogo = base64_encode($webplogo);
    $_['text_webplogo'] = '<img src="data:image/jpeg;base64,'.$webplogo.'">';
  }
}

$_['text_cron_test_command_for_site'] = '<span data-toggle="tooltip" title="Обязательно прочитайте весь текст выше на этой вкладке. 
Путь до php (cli) уточняйте у вашего хостера.">Данную команду вам необходимо внести в поле для задания CRON в вашей панели управления (в аккаунте) хостинга.</span>';

$_['text_php_cli_test'] = '<h2>Тест PHP CLI</h2><br>
Внимание! Этот тест служит подсказкой для нахождения правильного пути к интерпретатору PHP CLI. 
Пользоваться им имеет смысл только в случае если на вкладке "Сервис" этого модуля вы видите<br><br> 
<div class="shell_cmd"><b style="color:green;">OK:</b> function php <b>proc_open</b> exists</div><br> 
Если же видитее "<b style="color:red;">BAD: (missing) function php proc_open</b>", то делайте тест PHP CLI только через SSH (англ. Secure Shell — «безопасная оболочка»).<br>
В любом случае данный тест следует рассматривать как подсказку, а не как замену SSH. Из соображений безопасности можно выполнить только жестко заданные команды для Linux.<br>
Всегда предпочтительно пользоваться SSH. Вы должны хотя бы на базовом уровне разбираться в командах Linux, в противном случае данная информация будет бесполезной.<br><br>
У вас также есть возможность  запуска для теста скрипта php, предназначенного для задания cron через интерпретатор php(cli) по умолчанию<br>
Также можете выполнить команду <b>whereis php</b> для поиска пути к нужному php (cli).
<br><br>';

$_['text_php_cli_cmd'] = '<span data-toggle="tooltip" title="Безопасность: Вы не сможете выполнить и/или передать произвольную команду.  
В принципе никакие команды в текстовом виде никуда не передаются. Есть лишь ограниченный жесткий список команд.
<br><br>Для выполнения произвольных команд перейдите в SSH.">Команда Linux</span>';


$_['text_php_cli_cmd_out_placeholder'] = "Пример УСПЕШНОГО вывода команды: \n$ php -v\n\n" . 'PHP 7.0.32 (cli) (built: Sep 12 2018 16:05:45) ( ZTS )
Copyright (c) 1997-2017 The PHP Group
Zend Engine v3.0.0, Copyright (c) 1998-2017 Zend Technologies
    with the ionCube PHP Loader v10.3.2, Copyright (c) 2002-2018, by ionCube Ltd.';

$_['text_watermark_infoplus'] = '<h3>Справка</h3><br>'.$_['text_warning'].'
<a style="font-size: 20px; text-decoration:underline;" href="https://forum.opencart.expert/threads/image-compressor-watermark-webp-lazy-load-etc-by-sitecreator-bystryj-start-ustanovka.9/" target="blank">Подробная документация по установке модуля и настройке</a><br><br><br>
<b>Читайте также подсказки к каждому параметру настроек модуля!</b><br> 
По вопросам (в том числе по лицензии) обращаться на <b>opencart@sitecreator.ru</b> или в личку (sitecreator) на форумах. Просьба указывать в теме обращения название домена.<br><br>';

$_['text_nitro'] = "Установлен кеширующий ускоритель <b>Nitro</b> (но не обязательно активен), определяется по присутствию кода Nitro.<br\n>";
$_['text_nitroModSitecreatorON'] = "Необходимая модификация для совместимости с Компрессором <b style='color:green;'>внесена</b> в <b>Nitro</b>";
$_['text_nitroModSitecreatorOFF'] = "Необходимая модификация для совместимости с Компрессором <b style='color:red;'>отсутствует</b> в <b>Nitro</b>.\n
Если Nitro будет в состоянии `включен`, то Модуль 'Компрессор' автоматически <b>неявно</b> перейдет в режим совместимости с любым кеширующим ускорителем.";


$_['text_watermark_lic_error_header'] = '<h3>++++ Нет лицензии ++++</h3>';
$_['text_watermark_lic_error_file'] = '<br>Нет файла лицензии. Должен быть в <b>КОРНЕ</b> сайта';
$_['text_watermark_lic_error_domen'] = '<br>Невозможно корректно определить домен. Как следствие невозможно использовать лицензионный ключ.';
$_['text_watermark_lic_error_key'] = '<br>Неверный ключ.';

$_['text_module']         = 'Модули';
$_['text_success']        = 'Настройки модуля обновлены!';
$_['text_content_top']    = 'Верх страницы';
$_['text_content_bottom'] = 'Низ страницы';
$_['text_column_left']    = 'Левая колонка';
$_['text_column_right']   = 'Правая колонка';

// Entry
$_['entry_layout']        = 'Схема:';
$_['entry_position']      = 'Расположение:';
$_['entry_status']        = '<span data-toggle="tooltip" title="Настройка действует только на включение Watermark.  На СУПЕРсжатие не распростаняется, оно работает независимо от настроек Watermark.  ">Накладывать watermark:</span>';
$_['entry_sort_order']    = 'Порядок сортировки:';

// Error
$_['error_permission']    = 'У Вас нет прав для управления этим модулем!';

$_['text_compare_imgs_size'] = '<h4>Сравнение веса файлов ДО и ПОСЛЕ</h4>';

$file = DIR_LANGUAGE. "russian/module/wm_test_by_sitecreator.php";
if(file_exists($file)) {
  require $file;
}

$_['all_texts'] = [];
foreach ($_ as $name => $text) $_['all_texts'][$name] = $text;
?>