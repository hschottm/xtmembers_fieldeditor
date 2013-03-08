<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight webCMS
 * Copyright (C) 2005 Leo Feyer
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at http://www.gnu.org/licenses/.
 *
 * PHP version 5
 * @copyright  Helmut Schottmüller 2008
 * @author     Helmut Schottmüller <helmut.schottmueller@aurealis.de>
 * @package    memberextensions
 * @license    LGPL
 * @filesource
 */


/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_member_fields']['title']      = array('Title', 'Title of the member field.');
$GLOBALS['TL_LANG']['tl_member_fields']['author']      = array('Author', 'Please enter the author\'s name and an optional e-mail address (e.g. <em>Name &lt;e-mail@address.com&gt;</em>).');
$GLOBALS['TL_LANG']['tl_member_fields']['copyright']      = array('Copyright', 'Please enter the copyright notice (e.g. <em>Name 2009</em>).');
$GLOBALS['TL_LANG']['tl_member_fields']['license']      = array('License', 'Please enter the license type (e.g. <em>GNU/LGPL</em>).');
$GLOBALS['TL_LANG']['tl_member_fields']['name']      = array('Database field name', 'Please enter the name of the field in the database (characters only). The field automatically gets an additional \'xt_\' prefix.');
$GLOBALS['TL_LANG']['tl_member_fields']['description']      = array('Description', 'Description of the member field.');
$GLOBALS['TL_LANG']['tl_member_fields']['mandatory']      = array('Mandatory', 'Please check if the field cannot be empty.');
$GLOBALS['TL_LANG']['tl_member_fields']['fieldtype']      = array('Field type', 'Please select the type of member field you wish to add.');
$GLOBALS['TL_LANG']['tl_member_fields']['default_value']      = array('Default value', 'Please enter a default value for the field that is given when a new dataset will be created.');
$GLOBALS['TL_LANG']['tl_member_fields']['maxlength']      = array('Maximum length', 'Please enter the maximum number of characters that is allowed in the field.');
$GLOBALS['TL_LANG']['tl_member_fields']['minlength']      = array('Minimum length', 'Please enter the minimum number of characters that is allowed in the field.');
$GLOBALS['TL_LANG']['tl_member_fields']['rgxp']      = array('Regular expression', 'Please enter a regular expression to validate the content of the field.');
$GLOBALS['TL_LANG']['tl_member_fields']['tl_class']      = array('CSS class', 'Please enter a CSS class name to arrange the input field in the backend form.');
$GLOBALS['TL_LANG']['tl_member_fields']['position_after']      = array('Position field', 'Please select a field after which the active field should be positioned in the backend member form.');
$GLOBALS['TL_LANG']['tl_member_fields']['new_legend']      = array('Create new legend', 'Please enter a language variable to create a new legend for the active field.');
$GLOBALS['TL_LANG']['tl_member_fields']['new_legend_title']      = array('Legend title', 'Please enter a title of the new legend for the active field.');
$GLOBALS['TL_LANG']['tl_member_fields']['fieldoptions']      = array('Field options', 'Please enter the available options for the select field. The options represent language variables which have to be translated in the field extension module.');
$GLOBALS['TL_LANG']['tl_member_fields']['fegroup']      = array('Frontend group', 'Please select the group of the field that should be used for categorizations in front end form.');
$GLOBALS['TL_LANG']['tl_member_fields']['feeditable']      = array('Editable', 'Please check if the field can be edited in the frontend.');
$GLOBALS['TL_LANG']['tl_member_fields']['feviewable']      = array('Viewable', 'Please check if the field is viewable in the member listing module.');
$GLOBALS['TL_LANG']['tl_member_fields']['select_include_blank']      = array('Include blank option', 'Please check if a blank option should be included at the top of the select field.');
$GLOBALS['TL_LANG']['tl_member_fields']['field_text']      = 'Text field';
$GLOBALS['TL_LANG']['tl_member_fields']['field_select']      = 'Select field';
$GLOBALS['TL_LANG']['tl_member_fields']['field_textarea'] = "Textarea";
$GLOBALS['TL_LANG']['tl_member_fields']['field_checkbox'] = "Checkbox";
$GLOBALS['TL_LANG']['tl_member_fields']['field_radio'] = "Radiobutton";
$GLOBALS['TL_LANG']['tl_member_fields']['new']    = array('New member field', 'Create a new member field');
$GLOBALS['TL_LANG']['tl_member_fields']['show']   = array('Member field details', 'Show the details of member field ID %s');
$GLOBALS['TL_LANG']['tl_member_fields']['edit']   = array('Edit member field', 'Edit member field ID %s');
$GLOBALS['TL_LANG']['tl_member_fields']['copy']   = array('Duplicate member field', 'Duplicate member field ID %s');
$GLOBALS['TL_LANG']['tl_member_fields']['delete'] = array('Delete member field', 'Delete member field ID %s');
$GLOBALS['TL_LANG']['tl_member_fields']['export']      = 'Export fields as TYPOlight extension';
$GLOBALS['TL_LANG']['tl_member_fields']['exportCmd']      = 'Export';
$GLOBALS['TL_LANG']['tl_member_fields']['select_value']      = 'Value';
$GLOBALS['TL_LANG']['tl_member_fields']['select_text']      = 'Description';
$GLOBALS['TL_LANG']['tl_member_fields']['extensionName']      = array('Name of the TYPOlight extension', 'Please enter the name of the TYPOlight extension that should contain the new member fields. Please make sure that you do not use an existing extension name.');
$GLOBALS['TL_LANG']['tl_member_fields']['deliverAsZip'] = array('Deliver as ZIP file', 'Check here if you want to deliver the extension compressed in a ZIP file.');
$GLOBALS['TL_LANG']['tl_member_fields']['availableFields'] = array('Available member fields', 'Select the member fields that you want to integrate in your extension.');
$GLOBALS['TL_LANG']['tl_member_fields']['size']           = array('Rows and columns', 'The number of rows and columns of the textarea.');
$GLOBALS['TL_LANG']['tl_member_fields']['wrap']           = array('Word wrapping', 'Defines the type of word wrapping for the field content.');
$GLOBALS['TL_LANG']['tl_member_fields']['wrapping']['off']      = 'disable word wrapping';
$GLOBALS['TL_LANG']['tl_member_fields']['wrapping']['soft']      = 'soft word wrapping';
$GLOBALS['TL_LANG']['tl_member_fields']['wrapping']['hard']      = 'hard word wrapping';
$GLOBALS['TL_LANG']['tl_member_fields']['style']           = array('Style attributes', 'Style attributes (e.g. border:2px)');
$GLOBALS['TL_LANG']['tl_member_fields']['allowHtml']           = array('Allow HTML', 'If true the current field will accept HTML input.');
$GLOBALS['TL_LANG']['tl_member_fields']['rte']           = array('Rich text editor file', 'Uses a rich text editor to edit this textarea.');
$GLOBALS['TL_LANG']['tl_member_fields']['rtefiles']['tinyMCE']      = 'use file config/tinyMCE.php';
$GLOBALS['TL_LANG']['tl_member_fields']['rtefiles']['tinyFlash']      = 'use file config/tinyFlash.php';
$GLOBALS['TL_LANG']['tl_member_fields']['nospace']           = array('No whitespace characters', 'If true whitespace characters will not be allowed.');
$GLOBALS['TL_LANG']['tl_member_fields']['showdatepicker']           = array('Date picker', 'Add a date picker to the text field to select a date.');
$GLOBALS['TL_LANG']['tl_member_fields']['preserveTags']           = array('Preserve HTML tags', 'If true no HTML tags will be removed at all.');
$GLOBALS['TL_LANG']['tl_member_fields']['decodeEntities']           = array('Decode HTML entities', 'If true HTML entities will be decoded. Note that HTML entities are always decoded if allowHtml is true.');
$GLOBALS['TL_LANG']['tl_member_fields']['spaceToUnderscore']           = array('Convert space to underscore', 'If true any whitespace character will be replaced by an underscore.');
$GLOBALS['TL_LANG']['tl_member_fields']['isunique']           = array('Only unique', 'If true the field value cannot be saved if it exists already.');
$GLOBALS['TL_LANG']['tl_member_fields']['encrypt']           = array('Encrypt value', 'If true the field value will be stored encrypted.');
$GLOBALS['TL_LANG']['tl_member_fields']['blankOptionLabel']           = array('Blank option label', 'Label for the blank option (defaults to -).');
$GLOBALS['TL_LANG']['tl_member_fields']['multiple']           = array('Multiple selection', 'Make the input field multiple.');
$GLOBALS['TL_LANG']['tl_member_fields']['foreignKey']           = array('Foreign Key', 'Get options from a database table. Returns ID as key and the field you specify as value.');

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_member_fields']['title_legend']      = 'Title';
$GLOBALS['TL_LANG']['tl_member_fields']['field_legend']      = 'Field data';
$GLOBALS['TL_LANG']['tl_member_fields']['positioning_legend']      = 'Field positioning';
$GLOBALS['TL_LANG']['tl_member_fields']['categorization_legend']      = 'Field categorization';
$GLOBALS['TL_LANG']['tl_member_fields']['license_legend']      = 'License information';

/**
 * Errors
 */
$GLOBALS['TL_LANG']['tl_member_fields']['error_mysql']      = 'Field %s should only contain lowercase character from a to z and _';
$GLOBALS['TL_LANG']['tl_member_fields']['error_extension_exists'] = 'The extension %s already exists in the TL_ROOT/system/modules directory. Please delete the extension or choose another extension name.';

?>