<?php

/**
 * @category   OpenCart
 * @package    SEO URL Generator PRO
 * @copyright  © Serge Tkach, 2018-2021, http://sergetkach.com/
 */

// Heading
$_['heading_title'] = 'SEO URL Generator PRO';

// Text
$_['text_extension'] = 'Розширення';
$_['text_success']   = 'Налаштування модуля SEO URL Generator PRO оновлені!';
$_['text_edit']      = 'Редагування модуля';
$_['button_save']    = 'Зберегти';
$_['button_cancel']  = 'Відміна';

$_['text_author']         = 'Автор';
$_['text_author_support'] = 'Підтримка';

$_['entry_licence'] = 'Код ліцензії';
$_['entry_status']  = 'Статус модуля';


// Success
$_['success']         = 'Налаштування модуля SEO URL Generator PRO оновлені';
$_['success_licence'] = 'Ліцензія успішно збережена!';


// Error
$_['error_permission'] = 'У вас немає прав для управління цим модулем!';
$_['error_warning']    = 'Помилка: Налаштування не збережені. Виправте зазначені в формі помилки і спробуйте зберегти знову!';
$_['error_licence']           = 'Помилка: Код ліцензії не дійсний!';
$_['error_licence_empty']     = 'Введіть код ліцензії!';
$_['error_licence_not_valid'] = 'Помилка: Код ліцензії не дійсний!';


// Part Settings
$_['text_part_settings'] = 'Налаштування';

$_['fieldset_base']         = 'Основні налаштування';
$_['entry_licence']         = 'Введіть ключ ліцензії';
$_['entry_limit']           = 'Кількість записів, які обробляються за за 1 крок при масової генерації';
$_['help_limit']            = 'Чим потужніший сервер, тим більше записів він зможе обробляти за 1 крок. І навпаки';
$_['entry_debug']           = 'Режим налагодження (тільки для розробників)';
$_['help_debug']            = 'Якщо при масової генерації є помилка, то логи можуть зрозуміти, на якому етапі вона відбувається. Логі записуються в папку ' . DIR_LOGS . '. Не забудьте вимкнути Режим налагодження після тестування';
$_['debug_0']               = 'Нe вести лог';
$_['debug_1']               = 'Error - записувати помилки при перевірці даних';
$_['debug_2']               = 'Info - записувати значущи дії';
$_['debug_3']               = 'Debug - записувати дані при значущих діях';
$_['debug_4']               = 'Trace - записувати все підряд';

$_['fieldset_stores']           = 'Налаштування для кожного магазину'; // for OC 3.x

$_['fieldset_translit']           = 'Транслітерація';
$_['entry_translit_function']     = 'Правило транслітерації';
$_['entry_delimiter_char']        = 'Символ для поділу слів в SEO URL';
$_['help_delimiter_char']         = 'Даний символ буде замінювати некоректні символи, які можуть зустрічатися в назві. Так пропуск, знаки оклику та питання, кома та інші символи будуть замінені на обраний Символ для поділу слів';
$_['char_underscore']             = 'Знак підкреслення &quot;_&quot;';
$_['char_hyphen']                 = 'Дефіс &quot;-&quot;';
$_['entry_change_delimiter_char'] = 'Заміна Символу для поділу слів';
$_['help_change_delimiter_char']  = 'Зверніть увагу, що символи &quot;_&quot; и &quot;-&quot; вважаються однаково коректними для SEO UR. Однак, їх одночасне використання може виглядати не естетично з точки зору користувачів.';
$_['change_donot']                = 'Не замінювати символи &quot;-&quot; та &quot;_&quot;';
$_['change_underscore_to_hyphen'] = 'Замінювати &quot;_&quot; на &quot;-&quot;';
$_['change_hyphen_to_underscore'] = 'Замінювати &quot;-&quot; на &quot;_&quot;';
$_['entry_rewrite_on_save']       = 'Актуалізувати SEO URL при редагуванні';
$_['help_rewrite_on_save']        = 'При редагуванні товару (та ін сутностей) їх назви можуть змінюватися. В такому випадку старий SEO UR буде злегка не відповідати. <br><br>Якщо ввімкнути цю опцію, то при кожному редагуванні суті її SEO URL буде актуалізуватися, а старий SEO URL запишеться в список редиректів зі статусом 301.';
$_['title_custom_replace']        = 'Кастомні символи для заміни';
$_['help_custom_replace']         = 'Введіть по одному значенню на рядок';
$_['entry_custom_replace_from']   = 'Символ, який шукаємо';
$_['entry_custom_replace_to']     = 'Замінити на символ';

$_['fieldset_formulas']          = 'Формули для генерації SEO URL';
$_['entry_category_formula']     = 'Формула SEO URL Категорій';
$_['entry_product_formula']      = 'Формула SEO URL Товарів';
$_['entry_manufacturer_formula'] = 'Формула SEO URL Виробників';
$_['entry_information_formula']  = 'Формула SEO URL Інформаційних сторінок (в розділі Каталог -> Статті)';
$_['text_available_vars']        = 'Доступні змінні';
	$_['help_vars']                  = '* Між змінними слід використовувати символ роздільник слів. Наприклад:';
$_['or']                         = 'або';

$_['button_save_settings'] = 'Зберегти';

$_['error_formula_empty']     = 'Заповніть формулу для генерації SEO URL!';
$_['error_formula_less_vars'] = 'Недостатньо змінних для генерації унікальних SEO URL!';
$_['error_formula_pattern']   = 'У формулі допускається використання тільки заявлених <b>змінних </b>. Як роздільник використовується <b>Дефіс "-" або Знак підкреслення "_"</b>. Видаліть зайві символи такі як пробіл, крапка, кома, знаки оклику та питання, набір літер "html" та інше)!';

$_['error_custom_replace_to_not_1_char'] = 'У стовпці &quot;' . $_['entry_custom_replace_to'] . '&quot; має бути така ж кількість рядків, як і в стовпці &quot;' . $_['entry_custom_replace_from'] . '&quot;. Або Ви можете використати всього 1 загальний символ у правому стовпці для заміни символів з лівого стовпця.';


// Part Generate
$_['text_part_generate'] = 'Масова генерація SEO URL';

$_['error_formulas_none'] = 'Помилка: Не заповнені формули для генерації SEO URL! Виправте помилку в налаштуваннях модуля';

$_['tab_category']       = 'Категорії';
$_['tab_product']        = 'Товари';
$_['tab_manufacturer']   = 'Виробники';
$_['tab_information']    = 'Інформаційні сторінки (Статті)';

$_['text_answer_place']      = 'Тут з\'явиться відповідь від сервера';
$_['text_answer_processing'] = 'Обробка даних почалася...';

$_['button_generate_seo_url_product_empty']        = 'Згенерувати незаповнені SEO URL для Товарів';
$_['button_generate_seo_url_product_replace']      = 'Згенерувати незаповнені + замінити існуючі';
$_['button_generate_seo_url_category_empty']       = 'Згенерувати незаповнені SEO URL для Rатегорій';
$_['button_generate_seo_url_category_replace']     = 'Згенерувати незаповнені + замінити існуючі';
$_['button_generate_seo_url_manufacturer_empty']   = 'Згенерувати незаповнені SEO URL для Виробників';
$_['button_generate_seo_url_manufacturer_replace'] = 'Згенерувати незаповнені + замінити існуючі';
$_['button_generate_seo_url_information_empty']    = 'Згенерувати незаповнені SEO URL для "Статей"';
$_['button_generate_seo_url_information_replace']  = 'Згенерувати незаповнені + замінити існуючі';
$_['button_generate_seo_url_custom_empty']        = 'Згенерувати незаповнені SEO URL для';
$_['button_generate_seo_url_custom_replace']      = 'Згенерувати незаповнені + замінити існуючі для';


// Part Edit
$_['text_part_edit']      = 'Редагувати'; // На майбутнє
// Part Redirects
$_['text_part_redirects'] = 'Редіректи'; // На майбутнє


// Generation
$_['success_mass_generate_url'] = 'Генерування SEO URL для &quot;[essence]&quot; успішно завершено';

$_['error_ajax_response'] = "Під час масового генерування сталася помилка. Опис помилки дивіться в <a href='%s' target='_blank'>Журналі помилок</a>";

$_['answer_step_item_success'] = "Крок <b>%1\$d</b> з <b>%2\$d</b> виконаний успішно";
$_['answer_step_item_error']   = "Помилка на кроці <b>%1\$d</b> з <b>%2\$d</b>: ";
$_['error_steps_no_count']     = "Не вдалося визначити кількість товарів в функції countProducts()";


// Admin on Essences
$_['sug_button_generate'] = 'Згенерувати SEO URL';
$_['sug_text_redirects'] = 'Редіректи';
$_['sug_help_redirects'] = 'Необхідно вписувати SEO URL даної сутності без батьківської категорії';
$_['sug_button_add_redirect'] = 'Додати редирект';