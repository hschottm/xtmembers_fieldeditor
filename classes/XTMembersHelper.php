<?php

/**
 * @copyright  Helmut Schottmüller 2009-2013
 * @author     Helmut Schottmüller <https://github.com/hschottm>
 * @package    xtmembers_fieldeditor
 * @license    LGPL
 */

namespace Contao;

/**
 * Class XTMembersHelper
 *
 * Provide helper methods for xtmembers_fieldeditor
 * @copyright  Helmut Schottmüller 2009-2013
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
