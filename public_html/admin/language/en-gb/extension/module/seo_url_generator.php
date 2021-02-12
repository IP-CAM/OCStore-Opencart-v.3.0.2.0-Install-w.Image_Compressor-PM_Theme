<?php

/**
 * @category   OpenCart
 * @package    SEO URL Generator PRO
 * @copyright  © Serge Tkach, 2018-2021, http://sergetkach.com/
 */

// Heading
$_['heading_title'] = 'SEO URL Generator PRO';

// Text
$_['text_extension'] = 'Extensions';
$_['text_success']   = 'Success: You have modified SEO URL Generator PRO module!';
$_['text_edit']      = 'Edit setting';
$_['button_save']    = 'Save';
$_['button_cancel']  = 'Cancel';

$_['text_author']         = 'Author';
$_['text_author_support'] = 'Support';

$_['entry_licence'] = 'Licence code';
$_['entry_status']  = 'Status';


// Success
$_['success']         = 'Success: You have modified SEO URL Generator PRO module!';
$_['success_licence'] = 'The licence code was saved!';


// Error
$_['error_permission'] = 'Warning: You don\'t have permission to modify module SEO URL Generator PRO';
$_['error_warning']    = 'Warning: Please check the form carefully for errors!';
$_['error_licence']           = 'The licence code is not valid!';
$_['error_licence_empty']     = 'Input the licence code!';
$_['error_licence_not_valid'] = 'The licence code is not valid!';


// Part Settings
$_['text_part_settings'] = 'Settings';

$_['fieldset_base']         = 'Base settings';
$_['entry_licence']         = 'Input the licence code';
$_['entry_limit']           = 'Limit of items per a step in time of mass generation';
$_['help_limit']            = 'If you have a powerfull server you can select a greater number';
$_['entry_debug']           = 'Debug mode (for developers only)';
$_['help_debug']            = 'If there will happen any error in time of mass generation of SEO URLs, logs will help to find place and reason of error. Logs are written to the folder ' . DIR_LOGS . '. Don\'t forget to turn off Debug mode after testing';
$_['debug_0']               = 'Turn off logs';
$_['debug_1']               = 'Error - record errors only';
$_['debug_2']               = 'Info - record all actions';
$_['debug_3']               = 'Debug - record actions and their data';
$_['debug_4']               = 'Trace - record all data';

$_['fieldset_stores']           = 'Settings for each store'; // for OC 3.x

$_['fieldset_translit']           = 'Transliteration';
$_['entry_translit_function']     = 'The transliteration rule';
$_['entry_delimiter_char']        = 'Symbol for separation of words';
$_['help_delimiter_char']         = 'This character (in computer sense) will replace other symbols that are bad for SEO URL. I mean such symbols as spaces, exclamation or question marks, commas and others.';
$_['char_underscore']             = 'Underscore &quot;_&quot;';
$_['char_hyphen']                 = 'Hyphen &quot;-&quot;';
$_['entry_change_delimiter_char'] = 'Changing of the separation symbol';
$_['help_change_delimiter_char']  = 'Actually symbols &quot;_&quot; and &quot;-&quot; both are convinient for SEO URLs. But there is an esthetic difference.';
$_['change_donot']                = 'Don\'t replace symbols &quot;-&quot; and &quot;_&quot;';
$_['change_underscore_to_hyphen'] = 'Replace &quot;_&quot; for &quot;-&quot;';
$_['change_hyphen_to_underscore'] = 'Replace &quot;-&quot; for &quot;_&quot;';
$_['entry_rewrite_on_save']       = 'Check up SEO URLs in time of editing';
$_['help_rewrite_on_save']        = 'If you will change names of product (and others essences) then their SEO URL have difference with names.<br><br>If you will turn on this option then SEO URL change according current name in time of each saving. And old SEO URL will be recorded for redirects.';
$_['title_custom_replace']        = 'Custom symbols for replacing';
$_['help_custom_replace']         = 'Fill a symbol per a line';
$_['entry_custom_replace_from']   = 'Search symbol';
$_['entry_custom_replace_to']     = 'Replace with symbol';

$_['fieldset_formulas']          = 'Formula for SEO URL generation';
$_['entry_category_formula']     = 'Formula SEO URL for categories';
$_['entry_product_formula']      = 'Formula SEO URL for products';
$_['entry_manufacturer_formula'] = 'Formula SEO URL for manufacturers';
$_['entry_information_formula']  = 'Formula SEO URL for information';
$_['text_available_vars']        = 'Available variables';
$_['help_vars']                  = '* You should use a symbol Symbol for separation of words between variables. For instance:';
$_['or']                         = 'or';

$_['button_save_settings'] = 'Save';

$_['error_formula_empty']     = 'Fill formula for generation of SEO URL!';
$_['error_formula_less_vars'] = 'There are not enough variables for generation of unique SEO URLs!';
$_['error_formula_pattern']   = 'You must use only declared <b>variables</b>. Also you should use Symbol for separation of words. You must delete such symbols as space, dot, comma, exclamation or question marks, "html" etc!';

$_['error_custom_replace_to_not_1_char'] = 'It is necessary that columns &quot;' . $_['entry_custom_replace_to'] . '&quot; and &quot;' . $_['entry_custom_replace_from'] . '&quot; contain equal number of symbols. Also it is possible use a single symbol in right column for replacing of all symbols from left column';


// Part Generate
$_['text_part_generate'] = 'Mass generation of SEO URL';

$_['error_formulas_none'] = 'Error! There are not filled formulas for SEO URL in the Settings of module! Please, fill them!';

$_['tab_category']       = 'Categories';
$_['tab_product']        = 'Products';
$_['tab_manufacturer']   = 'Manufacturers';
$_['tab_information']    = 'Information';

$_['text_answer_place']      = 'Response';
$_['text_answer_processing'] = 'Processing have started...';

$_['button_generate_seo_url_product_empty']        = 'Generate empty SEO URLs for Products';
$_['button_generate_seo_url_product_replace']      = 'Generate empty + replace old inconvenient SEO URLs';
$_['button_generate_seo_url_category_empty']       = 'Generate empty SEO URLs for Categories';
$_['button_generate_seo_url_category_replace']     = 'Generate empty + replace old inconvenient SEO URLs';
$_['button_generate_seo_url_manufacturer_empty']   = 'Generate empty SEO URLs for Manufacturers';
$_['button_generate_seo_url_manufacturer_replace'] = 'Generate empty + replace old inconvenient SEO URLs';
$_['button_generate_seo_url_information_empty']    = 'Generate empty SEO URL for Information';
$_['button_generate_seo_url_information_replace']  = 'Generate empty + replace old inconvenient SEO URLs';
$_['button_generate_seo_url_custom_empty']        = 'Generate empty SEO URLs for';
$_['button_generate_seo_url_custom_replace']      = 'Generate empty + replace old inconvenient SEO URLs';


// Part Edit
$_['text_part_edit']      = 'Edit'; // For future
// Part Redirects
$_['text_part_redirects'] = 'Redirects'; // For future


// Generation
$_['success_mass_generate_url'] = 'Success: Generation of SEO URLs for &quot;[essence]&quot; have completed';

$_['error_ajax_response'] = "Error. You can look for error description in the <a href='%s' target='_blank'>Error Logs</a>";

$_['answer_step_item_success'] = "Step <b>%1\$d</b> from <b>%2\$d</b> have completed";
$_['answer_step_item_error']   = "There is an error in step <b>%1\$d</b> from <b>%2\$d</b>: ";
$_['error_steps_no_count']     = "It is impossible to get number of Products in function countProducts()";


// Admin on Essences
$_['sug_button_generate'] = 'Generate SEO URL';
$_['sug_text_redirects'] = 'Redirects';
$_['sug_help_redirects'] = 'It is necessary to fill SEO URL of this essence without parent category or site address';
$_['sug_button_add_redirect'] = 'Add Redirect';