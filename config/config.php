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
$GLOBALS['TL_HOOKS']['postDownload'][] = array('MemberFieldExport', 'postDownload');

?>