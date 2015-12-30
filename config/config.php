<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @license LGPL-3.0+
 */

/**
 * Back end modules
 */

array_insert($GLOBALS['BE_MOD']['accounts'], 2, array
(
	'memberfields' => array
	(
		'tables' => array('tl_member_fields'),
		'icon' => 'system/modules/xtmembers_fieldeditor/assets/memberfields.png',
		'stylesheet' => 'system/modules/xtmembers_fieldeditor/assets/xtmembers_fieldeditor.css',
		'export' => array('MemberFieldExport','exportFields')
	),
));

/**
 * Front end modules
 */

/**
 * FRONT END FORM FIELDS
 */

/**
 * Register hook functions
 */
$GLOBALS['TL_HOOKS']['addCustomRegexp'][] = array('XTMembersHelper', 'databaseFieldRegExp');

?>