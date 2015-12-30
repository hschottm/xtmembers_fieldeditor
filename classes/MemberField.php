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
 * Class MemberField
 *
 * Provide methods to handle an additional member field
 * @copyright  Helmut Schottmüller 2009-2015
 * @author     Helmut Schottmüller <https://github.com/hschottm>
 * @package    Controller
 */
class MemberField
{
	protected $dataset;
	
	/**
	 * Create a member field from a tl_member_fields dataset
	 * @param object
	 * @throws Expcetion
	 */
	public function __construct($dataset)
	{
		$this->dataset = $dataset;
	}


	/**
	 * Clean up
	 * @throws Exception
	 */
	public function __destruct()
	{
	}


	/**
	 * Return an object property
	 * @param string
	 * @return mixed
	 */
	public function __get($strKey)
	{
		switch ($strKey)
		{
			case 'dbFieldName':
				return "xt_" . $this->dataset['name'];
			case 'dbFieldType':
				switch ($this->dataset['fieldtype']) 
				{
					case 'textarea':
						$res = 'blob NULL';
						return $res;
						break;
					case 'radio':
						$res = 'varchar(64) NOT NULL';
						if (strlen($this->dataset['default_value'])) 
						{
							$res .= " default '" . $this->dataset['default_value'] . "'";
						}
						else
						{
							$res .= " default ''";
						}
						return $res;
						break;
					case 'checkbox':
						if (count($this->fieldoptions) > 1 || strlen($this->dataset['foreignKey']))
						{
							$res = 'blob NULL';
						}
						else
						{
							$res = 'char(1) NOT NULL';
							if (strlen($this->dataset['default_value'])) 
							{
								$res .= " default '" . $this->dataset['default_value'] . "'";
							}
							else
							{
								$res .= " default ''";
							}
						}
						return $res;
						break;
					case 'text':
					case 'select':
						if (strlen($this->dataset['maxlength']) && ($this->dataset['maxlength'] < 256))
						{
							$res = "varchar(" . $this->dataset['maxlength'] . ") NOT NULL default '";
							if (strlen($this->dataset['default_value'])) {
								$res .= $this->dataset['default_value'];
							}
							$res .= "'";
							return $res;
						}
						else
						{
							$res = 'text ';
							if (strlen($this->dataset['default_value']))
							{
								$res = 'varchar(255) ';
							}
							if (strlen($this->dataset['default_value'])) 
							{
								$res .= "NOT NULL default '" . $this->dataset['default_value'] . "'";
							}
							else
							{
								$res .= "NULL";
							}
							return $res;
						}
						break;
				}
			case 'inputType':
				return $this->dataset['fieldtype'];
			case 'isSelect':
				return (strcmp($this->dataset['fieldtype'], 'select') == 0) ? true : false;
			case 'hasOptions':
				return (count($this->fieldoptions)) ? true : false;
			case 'fieldoptions':
				$options = deserialize($this->dataset['fieldoptions'], true);
				$optarray = array();
				foreach ($options as $idx => $option)
				{
					if (strlen($option[0]) && strlen($option[1]))
					{
						$optarray[$option[0]] = $option[1];
					}
				}
				return $optarray;
				break;
			case 'options':
				$optstr = "array(";
				$options = $this->fieldoptions;
				$optarray = array();
				$counter = 0;
				foreach ($options as $idx => $option)
				{
					$optarray[$counter] = "'" . $idx . "' => &\$GLOBALS['TL_LANG']['tl_member']['" . $this->dbFieldName . "_select']['" . $idx . "']";
					$counter++;
				}
				$optstr .= join($optarray, ',');
				$optstr .= ")";
				return $optstr;
				break;
			case 'copyright':
				return $this->dataset['copyright'] . "\n";
			case 'license':
				return $this->dataset['license'] . "\n";
			case 'mandatory':
				return ($this->dataset['mandatory']) ? true : false;
			case 'author':
				return $this->dataset['author'] . "\n";
			case 'foreignKey':
				return $this->dataset['foreignKey'];
			case 'default':
				return $this->dataset['default_value'];
				break;
			case 'rgxp':
				return $this->dataset['rgxp'];
				break;
			case 'tl_class':
				return $this->dataset['tl_class'];
				break;
			case 'eval':
				$eval = array();
				array_push($eval, "'feEditable' => " . (($this->dataset['feeditable']) ? 'true' : 'false'));
				array_push($eval, "'feViewable' => " . (($this->dataset['feviewable']) ? 'true' : 'false'));
				if (strlen($this->dataset['fegroup'])) array_push($eval, "'feGroup' => '" . $this->dataset['fegroup'] . "'");
				if (strlen($this->dataset['tl_class']))
				{
					array_push($eval, "'tl_class' => " . "'" . $this->dataset['tl_class'] . (($this->dataset['showdatepicker']) ? ' wizard' : '') . "'");
				}
				else
				{
					switch ($this->dataset['fieldtype'])
					{
						case 'textarea':
							array_push($eval, "'tl_class' => " . "'" . 'clr long' . "'");
							break;
						case 'checkbox':
							if (!(count($this->fieldoptions) > 1 || strlen($this->dataset['foreignKey'])))
							{
								array_push($eval, "'tl_class' => " . "'" . 'w50 m12' . "'");
							}
							break;
						case 'radio':
							break;
						default:
							array_push($eval, "'tl_class' => " . "'" . 'w50' . (($this->dataset['showdatepicker']) ? ' wizard' : '') . "'");
							break;
					}
				}
				if (strlen($this->dataset['mandatory'])) array_push($eval, "'mandatory' => " . 'true');
				if (strlen($this->dataset['minlength'])) array_push($eval, "'minlength' => " . $this->dataset['minlength']);
				if (strlen($this->dataset['maxlength'])) array_push($eval, "'maxlength' => " . $this->dataset['maxlength']);
				if (strlen($this->dataset['style'])) array_push($eval, "'style' => '" . $this->dataset['style'] . "'");
				if ($this->dataset['nospace']) array_push($eval, "'nospace' => true");
				if ($this->dataset['allowHtml']) array_push($eval, "'allowHtml' => true");
				if (strcmp($this->dataset['fieldtype'], 'checkbox') == 0)
				{
					if ($this->dataset['multiple']) array_push($eval, "'multiple' => true");
				} 
				if ($this->dataset['showdatepicker'])
				{
					array_push($eval, "'datepicker' => true");
					array_push($eval, "'rgxp'=>'date'");
				} 
				if ($this->dataset['preserveTags']) array_push($eval, "'preserveTags' => true");
				if ($this->dataset['decodeEntities']) array_push($eval, "'decodeEntities' => true");
				if ($this->dataset['doNotSaveEmpty']) array_push($eval, "'doNotSaveEmpty' => true");
				if ($this->dataset['spaceToUnderscore']) array_push($eval, "'spaceToUnderscore' => true");
				if ($this->dataset['isunique']) array_push($eval, "'unique' => true");
				if ($this->dataset['encrypt']) array_push($eval, "'encrypt' => true");
				if ($this->dataset['trailingSlash']) array_push($eval, "'trailingSlash' => true");
				if (strlen($this->dataset['size']))
				{
					$rowscols = deserialize($this->dataset['size'], true);
					array_push($eval, "'rows' => '" . $rowscols[0] . "'");
					array_push($eval, "'cols' => '" . $rowscols[1] . "'");
				}
				if (strlen($this->dataset['wrap'])) 
				{
					switch ($this->dataset['wrap'])
					{
						case 'off':
						case 'soft':
						case 'hard':
							array_push($eval, "'wrap' => '" . $this->dataset['wrap'] . "'");
							break;
					}
				}
				if (strlen($this->dataset['rte'])) 
				{
					switch ($this->dataset['rte'])
					{
						case 'tinyMCE':
						case 'tinyFlash':
							array_push($eval, "'rte' => '" . $this->dataset['rte'] . "'");
							break;
					}
				}
				if (strlen($this->dataset['rgxp'])) array_push($eval, "'rgxp' => '" . $this->dataset['rgxp'] . "'");
				if ($this->dataset['select_include_blank'])
				{
					array_push($eval, "'includeBlankOption' => true");
					if (strlen($this->dataset['blankOptionLabel']))
					{
						array_push($eval, "'blankOptionLabel' => " . "\$GLOBALS['TL_LANG']['tl_member']['blankOptionLabel_" . $this->dbFieldName . "']");
					}
				}
				return join($eval, ',');
				break;
			case 'selectentries':
				$options = $this->fieldoptions;
				$optarray = array();
				foreach ($options as $idx => $option)
				{
					array_push($optarray, "\$GLOBALS['TL_LANG']['tl_member']['" . $this->dbFieldName . "_select']['" . $idx . "'] = '" . $option . "';\n");
				}
				if ($this->dataset['select_include_blank'])
				{
					if (strlen($this->dataset['blankOptionLabel']))
					{
						array_push($optarray, "\$GLOBALS['TL_LANG']['tl_member']['blankOptionLabel_" . $this->dbFieldName . "'] = '" . $this->dataset['blankOptionLabel'] . "';\n");
					}
				}
				return $optarray;
				break;
			case 'langentry':
				return array('name' => $this->dbFieldName, 'title' => $this->dataset['title'], 'description' => $this->dataset['description']);
				break;
			case 'legend':
				if (strlen($this->dataset['new_legend']))
				{
					return array('name' => $this->dataset['new_legend'], 'title' => $this->dataset['new_legend_title']);
				}
				else
				{
					return null;
				}
				break;
			default:
				return null;
				break;
		}
	}
}
