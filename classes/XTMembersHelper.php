<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @license LGPL-3.0+
 */

namespace Contao;

/**
 * Class XTMembersHelper
 *
 * Provide helper methods for xtmembers_fieldeditor
 * @copyright  Helmut Schottmüller 2009-2015
 * @author     Helmut Schottmüller <https://github.com/hschottm>
 * @package    Controller
 */
class XTMembersHelper extends \Backend
{
	public function databaseFieldRegExp($strRegexp, $varValue, Widget $objWidget)
	{
		if ($strRegexp == 'mysql')
		{
			if (!preg_match("/^[a-z_]+$/", $varValue))
			{
				$objWidget->addError(sprintf($GLOBALS['TL_LANG']['tl_member_fields']['error_mysql'], $objWidget->label));
			}
			return true;
		}
		return false;
	}
}
