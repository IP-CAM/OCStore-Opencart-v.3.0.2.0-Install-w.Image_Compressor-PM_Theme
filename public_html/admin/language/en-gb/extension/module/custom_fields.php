<?php

$_['heading_title'] = "Custom Fields";
// Text

$_['tab_frontend']   = 'Frontend';

$_['text_extension']   = 'Extensions';
$_['text_success']     = 'Success: You have modified Custom Fields module!';
$_['text_edit']        = 'Edit Custom Fields Module';


$_['text_fields_success']          	= 'Fields list saved!';
$_['text_fields_list']          	= 'Fields list';
$_['text_fields_add']          		= 'Add field';
$_['text_fields_edit']          	= 'Edit field';


$_['text_modes_normal']          	= 'Normal';
$_['text_modes_advanced']          	= 'Advanced';
$_['text_modes_expert']          	= 'Expert';

$_['text_dummy']          					= '{#custom_field#}';

$_['text_modes_normal_description']          	= '<p>In this mode the fields are showing authomatically wrapped with divs with default classes</p>';
$_['text_modes_advanced_description']          	= '<p>In this mode you can write your own HTML. You must place <b>%s</b> in your HTML to show the field content in this place.</p>';
$_['text_modes_expert_description']          	= '<p>If you select this mode - you can show the field content by yourself. To do this you must edit the corresponding template(category.tpl, information.tpl, manufacturer_info.tpl or product.tpl). The field content will be accessible in the variable <b>$custom_field_{{ID}}</b> For example $custom_field_1, where 1- the ID of the custom field</p><p>This variable is an Array of the elements wich includes all the needed data.</p>';

// Column
$_['column_title']          	= 'Name';
$_['column_entity']          	= 'Entity';
$_['column_sort_order']         = 'Sort Order';
$_['column_action']          	= 'Action';
$_['column_status']         = 'Status';

// Entry
$_['entry_status']     = 'Status';

$_['entry_fields_title']          	= 'Field name:';
$_['entry_fields_description']      = 'Hint:';
$_['entry_fields_entity']          	= 'Entity:';
$_['entry_fields_type']          	= 'Type:';
$_['entry_fields_status']          	= 'Status:';
$_['entry_fields_sort_order']       = 'Sort Order:';
$_['entry_fields_tab']       = "Tab name:";
$_['entry_fields_required']       = "Recquired:";
$_['entry_fields_error']       = "Error text:";
$_['entry_fields_mode']       = "Show mode:";
$_['entry_fields_showeditor']       = "Use visual editor:";
$_['entry_fields_showeditor_help']  = "You need to save changes before this setting takes effect";
$_['entry_fields_place']  = "Selector to show field content:";
$_['entry_fields_place_help']  = "Is actual for 'Normal' and 'Advanced' modes";
$_['entry_fields_placenum']  = "Sequence number of the selector:";
$_['entry_fields_placenum_help']  = "Use -1 for the last one";

// Error
$_['error_warning']          	= 'Check form for errors!';
$_['error_name']          		= 'Name must be between 3 and 255 characters!';
$_['error_tab']          		= 'Tab name must be between 3 and 255 characters!';
$_['error_place']          		= 'Selector must be between 1 and 64 characters!';
$_['error_permission'] = 'Warning: You do not have permission to modify Custom Fields module!';
?>