<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'Contao\MemberField'       => 'system/modules/xtmembers_fieldeditor/classes/MemberField.php',
	'Contao\MemberFieldExport' => 'system/modules/xtmembers_fieldeditor/classes/MemberFieldExport.php',
	'Contao\XTMembersHelper'   => 'system/modules/xtmembers_fieldeditor/classes/XTMembersHelper.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'be_export_memberfields'             => 'system/modules/xtmembers_fieldeditor/templates/backend',
	'extension_creator_autoload'         => 'system/modules/xtmembers_fieldeditor/templates/xtmembers_fieldeditor',
	'extension_creator_config'           => 'system/modules/xtmembers_fieldeditor/templates/xtmembers_fieldeditor',
	'extension_creator_dca_member'       => 'system/modules/xtmembers_fieldeditor/templates/xtmembers_fieldeditor',
	'extension_creator_languages_member' => 'system/modules/xtmembers_fieldeditor/templates/xtmembers_fieldeditor',
));
