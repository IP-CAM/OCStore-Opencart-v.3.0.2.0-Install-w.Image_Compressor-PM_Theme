<?php

/**
 * @category   OpenCart
 * @package    SEO URL Generator PRO
 * @copyright  © Serge Tkach, 2018-2021, http://sergetkach.com/
 */

// Heading
$_['heading_title'] = 'SEO URL Generator PRO';

// Text
$_['text_extension'] = 'Расширения';
$_['text_success']   = 'Настройки модуля SEO URL Generator PRO обновлены!';
$_['text_edit']      = 'Редактирование модуля';
$_['button_save']    = 'Сохранить';
$_['button_cancel']  = 'Отмена';

$_['text_author']         = 'Автор';
$_['text_author_support'] = 'Поддержка';

$_['entry_licence'] = 'Код лицензии';
$_['entry_status']  = 'Статус модуля';


// Success
$_['success']         = 'Настройки модуля обновлены';
$_['success_licence'] = 'Лицензия успешно сохранена!';


// Error
$_['error_permission'] = 'У вас нет прав для управления этим модулем!';
$_['error_warning']    = 'Ошибка: Настройки не сохранены. Исправьте указанные в форме ошибки и попробуйте сохранить снова!';
$_['error_licence']           = 'Ошибка: Код лицензии не действителен!';
$_['error_licence_empty']     = 'Введите код лицензии!';
$_['error_licence_not_valid'] = 'Ошибка: Код лицензии не действителен!';


// Part Settings
$_['text_part_settings'] = 'Настройки';

$_['fieldset_base']         = 'Основные настройки';
$_['entry_licence']         = 'Введите ключ лицензии';
$_['entry_limit']           = 'Кол-во записей, обрабатываемых за за 1 шаг при массовой генерации';
$_['help_limit']            = 'Чем мощнее сервер, тем больше записей он сможет обрабатывать за 1 шаг. И наоборот';
$_['entry_debug']           = 'Режим отладки (только для разработчиков)';
$_['help_debug']            = 'Если при массовой генерации есть ошибка, то логи могут понять, на каком этапе она происходит. Логи записываются в папку ' . DIR_LOGS . '. Не забудьте выключить Режим отладки после тестирования';
$_['debug_0']               = 'Выключить режим отладки';
$_['debug_1']               = 'Error - записывать ошибки при проверке данных';
$_['debug_2']               = 'Info - записывать значимые действия';
$_['debug_3']               = 'Debug - записывать данные при значимых действиях';
$_['debug_4']               = 'Trace - записывать все подряд';

$_['fieldset_stores']           = 'Настройки для каждого магазина'; // for OC 3.x

$_['fieldset_translit']           = 'Настройки транслитерации';
$_['entry_translit_function']     = 'Правило транслитерации';
$_['entry_delimiter_char']        = 'Символ для разделения слов в SEO URL';
$_['help_delimiter_char']         = 'Данный символ будет заменять некорректные символы, которые могут встречаться в названии. Так пробелы, восклицательные знаки, запятые и прочие символы будут заменены на выбранный разделитель';
$_['char_underscore']             = 'Нижнее подчеркивание &quot;_&quot;';
$_['char_hyphen']                 = 'Дефис &quot;-&quot;';
$_['entry_change_delimiter_char'] = 'Замена разделителя';
$_['help_change_delimiter_char']  = 'Обратите внимание, что символы &quot;_&quot; и &quot;-&quot; считаются одинаково корректными для SEO URL. Однако, их одновременное использование может выглядеть не эстетично с точки зрения пользователей.';
$_['change_donot']                = 'Не заменять символы &quot;-&quot; и &quot;_&quot;';
$_['change_underscore_to_hyphen'] = 'Заменять &quot;_&quot; на &quot;-&quot;';
$_['change_hyphen_to_underscore'] = 'Заменять &quot;-&quot; на &quot;_&quot;';
$_['entry_rewrite_on_save']       = 'Актуализировать ли SEO URL при редактировании';
$_['help_rewrite_on_save']        = 'При редактировании товара (и др сущностей) их названия могут меняться. В таком случае старый SEO URL будет слегка не соответствовать. <br><br>Если включить эту опцию, то при каждом редактировании сущности ее SEO URL будет актуализироваться, а старый SEO URL запишется в список редиректов со статусом 301.';
$_['title_custom_replace']        = 'Кастомные символы для замены';
$_['help_custom_replace']         = 'Введите по одному значению на строку';
$_['entry_custom_replace_from']   = 'Искомый символ';
$_['entry_custom_replace_to']     = 'Заменить на символ';

$_['fieldset_formulas']          = 'Формулы для генерации SEO URL';
$_['entry_category_formula']     = 'Формула SEO URL Категорий';
$_['entry_product_formula']      = 'Формула SEO URL Товаров';
$_['entry_manufacturer_formula'] = 'Формула SEO URL Производителей';
$_['entry_information_formula']  = 'Формула SEO URL Информационных страниц (в разделе Каталог -> Статьи)';
$_['text_available_vars']        = 'Доступные переменные';
$_['help_vars']                  = '* Между переменными следует использовать символ разделителя слов. К примеру:';
$_['or']                         = 'или';

$_['button_save_settings'] = 'Сохранить';

$_['error_formula_empty']     = 'Заполните формулу для генерации SEO URL!';
$_['error_formula_less_vars'] = 'Недостаточно переменных для генерации уникальных SEO URL!';
$_['error_formula_pattern']   = 'В формуле допускается использование только заявленных <b>переменных</b>. В качестве разделителя используется <b>знак черточки "-" и нижнего подчеркивания "_"</b>. Удалите лишние символы такие как пробел, точку, вопросительный и восклицательный знаки, набор букв "html" и тп)!';

$_['error_custom_replace_to_not_1_char'] = 'В столбце &quot;' . $_['entry_custom_replace_to'] . '&quot; должно быть такое же количество строк, как и в столбце &quot;' . $_['entry_custom_replace_from'] . '&quot;. Либо Вы можете использовать всего 1 общий символ в правом столбце для замены всех символов из левого столбца';


// Part Generate
$_['text_part_generate'] = 'Массовая генерация SEO URL';

$_['error_formulas_none'] = 'Ошибка: Не заполнены формулы для генерации SEO URL! Исправьте ошибку в настройках модуля';

$_['tab_category']       = 'Категории';
$_['tab_product']        = 'Товары';
$_['tab_manufacturer']   = 'Производители';
$_['tab_information']    = 'Информационные страницы (Статьи)';

$_['text_answer_place']      = 'Тут появится ответ сервера';
$_['text_answer_processing'] = 'Обработка данных началась...';

$_['button_generate_seo_url_product_empty']        = 'Сгенерировать незаполненные SEO URL Товаров';
$_['button_generate_seo_url_product_replace']      = 'Сгенерировать незаполненные + заменить существующие';
$_['button_generate_seo_url_category_empty']       = 'Сгенерировать незаполненные SEO URL Категорий';
$_['button_generate_seo_url_category_replace']     = 'Сгенерировать незаполненные + заменить существующие';
$_['button_generate_seo_url_manufacturer_empty']   = 'Сгенерировать незаполненные SEO URL Производителей';
$_['button_generate_seo_url_manufacturer_replace'] = 'Сгенерировать незаполненные + заменить существующие';
$_['button_generate_seo_url_information_empty']    = 'Сгенерировать незаполненные SEO URL "Статей"';
$_['button_generate_seo_url_information_replace']  = 'Сгенерировать незаполненные + заменить существующие';
$_['button_generate_seo_url_custom_empty']        = 'Сгенерировать незаполненные SEO URL для';
$_['button_generate_seo_url_custom_replace']      = 'Сгенерировать незаполненные + заменить существующие для';


// Part Edit
$_['text_part_edit']      = 'Редактировать'; // На будущее
// Part Redirects
$_['text_part_redirects'] = 'Редиректы'; // На будущее


// Generation
$_['success_mass_generate_url'] = 'Генерация SEO URL для &quot;[essence]&quot; успешно завершена';

$_['error_ajax_response'] = "Во время массовой генерации произошла ошибка. Описание ошибки смотрите в <a href='%s' target='_blank'>Журнале ошибок</a>";

$_['answer_step_item_success'] = "Шаг <b>%1\$d</b> из <b>%2\$d</b> выполнен успешно";
$_['answer_step_item_error']   = "Ошибка на шаге <b>%1\$d</b> из <b>%2\$d</b>: ";
$_['error_steps_no_count']     = "Не удалось получить кол-во товаров в функции countProducts()";


// Admin on Essences
$_['sug_button_generate'] = 'Сгенерировать SEO URL';
$_['sug_text_redirects'] = 'Редиректы';
$_['sug_help_redirects'] = 'Необходимо вписывать SEO URL данной сущности без родительской категории';
$_['sug_button_add_redirect'] = 'Добавить редирект';