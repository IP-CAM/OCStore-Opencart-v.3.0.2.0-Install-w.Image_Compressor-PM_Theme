<?php

$_['heading_title'] = "Произвольные поля";
// Text

$_['tab_frontend']   = 'Frontend';

$_['text_extension']   = 'Модули';
$_['text_success']     = 'Настройки модуля обновлены!';
$_['text_edit']        = 'Редактирование модуля';


$_['text_fields_success']          	= 'Список полей обновлен!';
$_['text_fields_list']          	= 'Список полей';
$_['text_fields_add']          		= 'Добавление поля';
$_['text_fields_edit']          	= 'Редактирование поля';


$_['text_modes_normal']          	= 'Нормальный';
$_['text_modes_advanced']          	= 'Продвинутый';
$_['text_modes_expert']          	= 'Эксперт';

$_['text_dummy']          					= '{#custom_field#}';

$_['text_modes_normal_description']          	= '<p>В этом режиме поля выводятся автоматически в блоках с классами по-умолчанию</p>';
$_['text_modes_advanced_description']          	= '<p>В этом режиме вы можете настроить блок, в котором будет выводиться значение поля</p><p>Используйте HTML, внутри которого разместите вставку <b>%s</b></p>';
$_['text_modes_expert_description']          	= '<p>Если выбран экспертный режим отображения для поля - вы можете самостоятельно отобразить значения данного поля, отредактировав соответствующий темплейт(category.tpl, information.tpl, manufacturer_info.tpl или product.tpl). Значение поля будет доступно в темплейте в переменной <b>$custom_field_{{ID}}</b> Например $custom_field_1, где 1- идентификатор данного поля</p><p>Эта переменная являет собой массив, содержащий все необходимые данные.</p>';

// Column
$_['column_title']          	= 'Название';
$_['column_entity']          	= 'Сущность';
$_['column_sort_order']         = 'Порядок сортировки';
$_['column_action']          	= 'Действие';
$_['column_status']         = 'Статус';

// Entry
$_['entry_status']     = 'Статус';

$_['entry_fields_title']          	= 'Название поля:';
$_['entry_fields_description']      = 'Подсказка:';
$_['entry_fields_entity']          	= 'Сущность:';
$_['entry_fields_type']          	= 'Тип:';
$_['entry_fields_status']          	= 'Статус:';
$_['entry_fields_sort_order']       = 'Порядок сортировки:';
$_['entry_fields_tab']       = "Название вкладки:";
$_['entry_fields_required']       = "Обязательное:";
$_['entry_fields_error']       = "Текст ошибки:";
$_['entry_fields_mode']       = "Режим отображения:";
$_['entry_fields_showeditor']       = "Использовать визуальный редактор:";
$_['entry_fields_showeditor_help']  = "Сохраните изменения для применеия настройки";
$_['entry_fields_place']  = "Селектор, куда выводить значение поля:";
$_['entry_fields_place_help']  = "Имеет смысл для режимов 'Нормальный' и 'Продвинутый'";
$_['entry_fields_placenum']  = "Порядковый номер селектора:";
$_['entry_fields_placenum_help']  = "Используйте -1 для последнего";

// Error
$_['error_warning']          	= 'Внимательно проверьте форму на ошибки!';
$_['error_name']          		= 'Название должно быть от 3 до 255 символов!';
$_['error_tab']          		= 'Название вкладки должно быть от 3 до 255 символов!';
$_['error_place']          		= 'Селектор должен быть от 1 до 64 символов!';
$_['error_permission'] = 'У вас нет прав для управления этим модулем!';
?>