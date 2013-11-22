<?php

/**
 * @copyright  Helmut Schottmüller 2009
 * @author     Helmut Schottmüller <typolight@aurealis.de>
 * @package    CalendarImport
 * @license    LGPL
 */

namespace Contao;

/**
 * Class MemberFieldExport
 *
 * Provide methods to handle import and export of member data.
 * @copyright  Helmut Schottmüller 2009
 * @author     Helmut Schottmüller <typolight@aurealis.de>
 * @package    Controller
 */
class MemberFieldExport extends \Backend
{
	protected $blnSave = true;
	
	protected function createExtension($extension, $extensionPath, $availableFields, $author, $copyright, $license)
	{
		$this->loadDataContainer('tl_member');
		// remove an existing folder of the same name
		if (strlen($extensionPath) && @file_exists(TL_ROOT . "/" . $extensionPath))
		{
			$folder = new Folder($extensionPath);
			$folder->delete();
		}
		
		// create paths
		$this->Files->mkdir($extensionPath);
		$this->Files->mkdir($extensionPath . "/config");
		$this->Files->mkdir($extensionPath . "/dca");
		$this->Files->mkdir($extensionPath . "/languages");
		$this->Files->mkdir($extensionPath . "/languages/" . $GLOBALS['TL_LANGUAGE']);

		$objField = $this->Database->prepare("SELECT * FROM tl_member_fields ORDER BY name")
			->execute();
		$fields = array();
		while ($objField->next()) 
		{
			$field = $objField->row();
			if (in_array($field['id'], $availableFields))
			{
				array_push($fields, new MemberField($field));
			}
		}
		// create config files
		$config = new BackendTemplate('extension_creator_config');
		$config->author = $author;
		$config->copyright = $copyright;
		$config->license = $license;
		$configFile = new File($extensionPath . "/config/config.php");
		$configFile->write($config->parse());
		$configFile->close();

		$autoloadIniFile = new File($extensionPath . "/config/autoload.ini");
		$autoloadIniFile->write(";;\n; Configure what you want the autoload creator to register\n;;\nregister_namespaces = true\nregister_classes    = true\nregister_templates  = true\n");
		$autoloadIniFile->close();

		$autoload = new BackendTemplate('extension_creator_autoload');
		$autoloadPhpFile = new File($extensionPath . "/config/autoload.php");
		$autoloadPhpFile->write($autoload->parse());
		$autoloadPhpFile->close();

		// create dca files
		$dca = new BackendTemplate('extension_creator_dca_member');
		$dca->author = $author;
		$dca->copyright = $copyright;
		$dca->license = $license;
		$dca->fields = $fields;
		$dca->extension = $extension;
		$dca->palette = $this->getPalette();
		$dcaFile = new File($extensionPath . "/dca/tl_member.php");
		$dcaFile->write($dca->parse());
		$dcaFile->close();

		// create languages files
		$lang = new BackendTemplate('extension_creator_languages_member');
		$langentries = array();
		$legends = array();
		$selectentries = array();
		foreach ($fields as $field)
		{
			array_push($langentries, $field->langentry);
			if (is_array($field->legend)) 
			{
				array_push($legends, $field->legend);
			}
			$selectentries = array_merge($selectentries, $field->selectentries);
		}
		$lang->langentries = $langentries;
		$lang->legends = $legends;
		$lang->selectentries = $selectentries;
		$lang->author = $author;
		$lang->copyright = $copyright;
		$lang->license = $license;
		$langFile = new File($extensionPath . "/languages/" . $GLOBALS['TL_LANGUAGE'] . "/tl_member.php");
		$langFile->write($lang->parse());
		$langFile->close();
	}
	
	public function exportFields(DataContainer $dc)
	{
		if (\Input::get('key') != 'export')
		{
			return '';
		}

		$this->loadLanguageFile("tl_member_fields");
		$this->Template = new BackendTemplate('be_export_memberfields');

		$this->Template->extensionName = $this->getExtensionNameWidget();
		$this->Template->deliverAsZip = $this->getDeliverAsZipWidget($this->Session->get('memberfieldexport_deliverAsZip'));
		$this->Template->availableFields = $this->getAvailableFieldsWidget($this->Session->get('memberfieldexport_availableFields'));
		$this->Template->author = $this->getAuthorWidget($this->Session->get('memberfieldexport_author'));
		$this->Template->copyright = $this->getCopyrightWidget($this->Session->get('memberfieldexport_copyright'));
		$this->Template->license = $this->getLicenseWidget($this->Session->get('memberfieldexport_license'));

		$this->Template->hrefBack = ampersand(str_replace('&key=export', '', \Environment::get('request')));
		$this->Template->goBack = $GLOBALS['TL_LANG']['MSC']['goBack'];
		$this->Template->headline = $GLOBALS['TL_LANG']['tl_member_fields']['export'];
		$this->Template->request = ampersand(\Environment::get('request'), ENCODE_AMPERSANDS);
		$this->Template->submit = specialchars($GLOBALS['TL_LANG']['tl_member_fields']['exportCmd']);

		// Create import form
		if (\Input::post('FORM_SUBMIT') == 'tl_export_memberfields' && $this->blnSave)
		{
			$extensionName = $this->Template->extensionName->value;
			$deliverAsZip = $this->Template->deliverAsZip->value;
			if (@file_exists(TL_ROOT . '/system/modules/' . $extensionName)) 
			{
				$this->Template->extensionName->addError(sprintf($GLOBALS['TL_LANG']['tl_member_fields']['error_extension_exists'], $extensionName));
			}
			else
			{
				$this->Session->set('memberfieldexport_availableFields', $this->Template->availableFields->value);
				$this->Session->set('memberfieldexport_deliverAsZip', $deliverAsZip);
				$this->Session->set('memberfieldexport_author', $this->Template->author->value);
				$this->Session->set('memberfieldexport_copyright', $this->Template->copyright->value);
				$this->Session->set('memberfieldexport_license', $this->Template->license->value);
				$this->import('Files');
				$this->createExtension($extensionName, 'system/tmp/' . $extensionName, $this->Template->availableFields->value, $this->Template->author->value . "\n", $this->Template->copyright->value . "\n", $this->Template->license->value . "\n");
				if ($deliverAsZip)
				{
					$this->Files->delete('system/tmp/' . $extensionName . '.zip');
					$objBackup = new ZipWriter('system/tmp/' . $extensionName . '.zip');
					$files = array();
					$this->deepScan('system/tmp/' . $extensionName, $files);
					foreach ($files as $strFile)
					{
						try
						{
							$objBackup->addFile($strFile, str_replace('system/tmp/', '', $strFile));
						}
						catch (Exception $e)
						{
						}
					}
					$objBackup->close();
					// delete the folder
					$folder = new Folder('system/tmp/' . $extensionName);
					$folder->delete();
					// send the zip file
					$save = $GLOBALS['TL_CONFIG']['uploadPath'];
					$GLOBALS['TL_CONFIG']['uploadPath'] = 'system/tmp';
					$this->Session->set('memberfieldexport_exportfile', 'system/tmp/' . $extensionName . '.zip');
					$this->sendFileToBrowser('system/tmp/' . $extensionName . '.zip');
					$GLOBALS['TL_CONFIG']['uploadPath'] = $save;
				}
				else
				{
					$this->Files->rename('system/tmp/' . $extensionName, 'system/modules/' . $extensionName);
				}
				$this->redirect(str_replace('&key=export', '', \Environment::get('request')));
			}
		}
		return $this->Template->parse();
	}

	public function postDownload($strFile)
	{
		if (strcmp($this->Session->get('memberfieldexport_exportfile'), $strFile) == 0)
		{
			$this->import('Files');
			$this->Files->delete($strFile);
		}
	}
	
	/**
	 * Recursively delete folder
	 * @param string
	 */
	protected function deepScan($strFolder, &$arrFiles)
	{
		$content = scan(TL_ROOT . '/' . $strFolder);
		foreach ($content as $strFile)
		{
			if (is_dir(TL_ROOT . '/' . $strFolder . '/' . $strFile))
			{
				$this->deepScan($strFolder . '/' . $strFile, $arrFiles);
			} else {
				array_push($arrFiles, $strFolder . '/' . $strFile);
			}
		}
	}

	/**
	 * Return the extension name widget as object
	 * @param mixed
	 * @return object
	 */
	protected function getExtensionNameWidget($value=null)
	{
		$widget = new TextField();

		$widget->id = 'extensionName';
		$widget->name = 'extensionName';
		$widget->mandatory = true;
		$widget->maxlength = 40;
		$widget->rgxp = 'mysql';
		$widget->nospace = true;
		$widget->value = $value;
		$widget->required = true;

		$widget->label = $GLOBALS['TL_LANG']['tl_member_fields']['extensionName'][0];

		if ($GLOBALS['TL_CONFIG']['showHelp'] && strlen($GLOBALS['TL_LANG']['tl_member_fields']['extensionName'][1]))
		{
			$widget->help = $GLOBALS['TL_LANG']['tl_member_fields']['extensionName'][1];
		}

		// Valiate input
		if (\Input::post('FORM_SUBMIT') == 'tl_export_memberfields')
		{
			$widget->validate();

			if ($widget->hasErrors())
			{
				$this->blnSave = false;
			}
		}

		return $widget;
	}

	/**
	 * Return the author widget as object
	 * @param mixed
	 * @return object
	 */
	protected function getAuthorWidget($value=null)
	{
		$widget = new TextField();

		$widget->id = 'author';
		$widget->name = 'author';
		$widget->mandatory = true;
		$widget->maxlength = 80;
		$widget->value = $value;
		$widget->required = true;

		$widget->label = $GLOBALS['TL_LANG']['tl_member_fields']['author'][0];

		if ($GLOBALS['TL_CONFIG']['showHelp'] && strlen($GLOBALS['TL_LANG']['tl_member_fields']['author'][1]))
		{
			$widget->help = $GLOBALS['TL_LANG']['tl_member_fields']['author'][1];
		}

		// Valiate input
		if (\Input::post('FORM_SUBMIT') == 'tl_export_memberfields')
		{
			$widget->validate();

			if ($widget->hasErrors())
			{
				$this->blnSave = false;
			}
		}

		return $widget;
	}

	/**
	 * Return the copyright widget as object
	 * @param mixed
	 * @return object
	 */
	protected function getCopyrightWidget($value=null)
	{
		$widget = new TextField();

		$widget->id = 'copyright';
		$widget->name = 'copyright';
		$widget->mandatory = true;
		$widget->maxlength = 80;
		$widget->value = $value;
		$widget->required = true;

		$widget->label = $GLOBALS['TL_LANG']['tl_member_fields']['copyright'][0];

		if ($GLOBALS['TL_CONFIG']['showHelp'] && strlen($GLOBALS['TL_LANG']['tl_member_fields']['copyright'][1]))
		{
			$widget->help = $GLOBALS['TL_LANG']['tl_member_fields']['copyright'][1];
		}

		// Valiate input
		if (\Input::post('FORM_SUBMIT') == 'tl_export_memberfields')
		{
			$widget->validate();

			if ($widget->hasErrors())
			{
				$this->blnSave = false;
			}
		}

		return $widget;
	}

	/**
	 * Return the license widget as object
	 * @param mixed
	 * @return object
	 */
	protected function getLicenseWidget($value=null)
	{
		$widget = new TextField();

		$widget->id = 'license';
		$widget->name = 'license';
		$widget->mandatory = true;
		$widget->maxlength = 80;
		$widget->value = $value;
		$widget->required = true;

		$widget->label = $GLOBALS['TL_LANG']['tl_member_fields']['license'][0];

		if ($GLOBALS['TL_CONFIG']['showHelp'] && strlen($GLOBALS['TL_LANG']['tl_member_fields']['license'][1]))
		{
			$widget->help = $GLOBALS['TL_LANG']['tl_member_fields']['license'][1];
		}

		// Valiate input
		if (\Input::post('FORM_SUBMIT') == 'tl_export_memberfields')
		{
			$widget->validate();

			if ($widget->hasErrors())
			{
				$this->blnSave = false;
			}
		}

		return $widget;
	}

	/**
	 * Return the deliver as zip widget as object
	 * @param mixed
	 * @return object
	 */
	protected function getDeliverAsZipWidget($value=null)
	{
		$widget = new CheckBox();

		$widget->id = 'deliverAsZip';
		$widget->name = 'deliverAsZip';
		$widget->value = $value;
		$widget->options = array(array('value' => 1, 'label' => $GLOBALS['TL_LANG']['tl_member_fields']['deliverAsZip'][0]));

		$widget->label = '';

		if ($GLOBALS['TL_CONFIG']['showHelp'] && strlen($GLOBALS['TL_LANG']['tl_member_fields']['deliverAsZip'][1]))
		{
			$widget->help = $GLOBALS['TL_LANG']['tl_member_fields']['deliverAsZip'][1];
		}

		// Valiate input
		if (\Input::post('FORM_SUBMIT') == 'tl_export_memberfields')
		{
			$widget->validate();

			if ($widget->hasErrors())
			{
				$this->blnSave = false;
			}
		}

		return $widget;
	}

	/**
	 * Return the available fields widget as object
	 * @param mixed
	 * @return object
	 */
	protected function getAvailableFieldsWidget($value=null)
	{
		$widget = new CheckBox();

		$widget->id = 'availableFields';
		$widget->name = 'availableFields';
		$widget->value = $value;
		
		$arrFields = $this->Database->prepare("SELECT id, title FROM tl_member_fields ORDER BY title")
			->executeUncached()->fetchAllAssoc();
		$arrOptions = array();
		foreach ($arrFields as $field)
		{
			array_push($arrOptions, array('value' => $field['id'], 'label' => $field['title']));
		}
		$widget->options = $arrOptions;
		$widget->mandatory = true;
		$widget->multiple = true;

		$widget->label = $GLOBALS['TL_LANG']['tl_member_fields']['availableFields'][0];
		if ($GLOBALS['TL_CONFIG']['showHelp'] && strlen($GLOBALS['TL_LANG']['tl_member_fields']['availableFields'][1]))
		{
			$widget->help = $GLOBALS['TL_LANG']['tl_member_fields']['availableFields'][1];
		}

		// Valiate input
		if (\Input::post('FORM_SUBMIT') == 'tl_export_memberfields')
		{
			$widget->validate();

			if ($widget->hasErrors())
			{
				$this->blnSave = false;
			}
		}

		return $widget;
	}

	public function getPalette()
	{
		$this->loadDataContainer('tl_member');
		$this->loadLanguageFile('tl_member');
		$palette = $GLOBALS['TL_DCA']['tl_member']['palettes']['default'];
		$result = "";
		$objNewField = $this->Database->prepare("SELECT name, title, new_legend, new_legend_title, position_after FROM tl_member_fields")
			->execute();
		$newfields = array();
		while ($objNewField->next()) 
		{
			$row = $objNewField->row();
			$newfields['xt_'.$row["name"]] = array("legend" => $row["new_legend"], "legend_title" => $row["new_legend_title"], "position" => $row["position_after"], "title" => $row["title"]);
		}
		$inserts = array();
		$stack = $newfields;
		$stacksize = count($stack);
		$laststacksize = count($stack);
		$stacknotchanged = 0;
		while (count($stack) && $stacknotchanged < 10)
		{
			foreach ($stack as $field => $fielddata)
			{
				$insert = "," . $field;
				if (strlen($fielddata["legend"])) $insert = ";{" . $fielddata["legend"] . "}," . $field;

				if (preg_match("/" . $fielddata["position"] . "([,;\$])/", $palette, $matches))
				{
					if (strlen($matches[1]))
					{
						$palette = str_replace($fielddata["position"] . $matches[1], $fielddata["position"] . $insert . $matches[1], $palette);
						$result .= "if (strpos(\$GLOBALS['TL_DCA']['tl_member']['palettes']['default'], '" . $fielddata["position"] . $matches[1] . "') === false) {\n";
						$result .= "	" . "\$GLOBALS['TL_DCA']['tl_member']['palettes']['default'] .= '" . $insert . "';\n";
						$result .= "} else {\n";
						$result .= "	\$GLOBALS['TL_DCA']['tl_member']['palettes']['default'] = str_replace('" . $fielddata["position"] . $matches[1] . "','" . $fielddata["position"] . $insert . $matches[1] . "', \$GLOBALS['TL_DCA']['tl_member']['palettes']['default']);\n";
						$result .= "}\n";
					}
					else
					{
						$palette .= $insert;
						$result .= "\$GLOBALS['TL_DCA']['tl_member']['palettes']['default'] .= '" . $insert . "';\n";
					}
					unset($stack[$field]);
				}
			}
			$stacksize = count($stack);
			if ($stacksize == $laststacksize)
			{
				$stacknotchanged++;
			}
			else
			{
				$stacknotchanged = 0;
				$laststacksize = $stacksize;
			}
		}
		foreach ($stack as $field => $fielddata)
		{
			$insert = "," . $field;
			if (strlen($fielddata["legend"])) $insert = ";{" . $fielddata["legend"] . "}," . $field;
			$result .= "\$GLOBALS['TL_DCA']['tl_member']['palettes']['default'] .= '" . $insert . "';\n";
		}

		return $result;
	}

}