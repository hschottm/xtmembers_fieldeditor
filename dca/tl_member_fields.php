<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @license LGPL-3.0+
 */

/**
 * Table tl_survey
 */
$GLOBALS['TL_DCA']['tl_member_fields'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ctable'                      => array(),
		'switchToEdit'                => false,
		'enableVersioning'            => true,
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary'
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 2,
			'fields'                  => array('title'),
			'flag'                    => 1,
			'panelLayout'             => 'filter;sort,search,limit'
		),
		'label' => array
		(
			'fields'                  => array('title'),
		),
		'global_operations' => array
		(
			'export' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_member_fields']['export'],
				'href'                => 'key=export',
				'class'               => 'header_export',
				'attributes'          => 'onclick="Backend.getScrollOffset();"'
			),
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset();"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_member_fields']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_member_fields']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_member_fields']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_member_fields']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array('fieldtype', 'select_include_blank'),
		'default'                     => '{title_legend},title,name,description;{field_legend},fieldtype',
		'text'                        => '{title_legend},title,name,description;{field_legend},fieldtype,mandatory,default_value,minlength,maxlength,rgxp,wrap,nospace,preserveTags,decodeEntities,spaceToUnderscore,isunique,encrypt,allowHtml,showdatepicker,style,tl_class;{categorization_legend},fegroup,feeditable,feviewable;{positioning_legend},position_after,new_legend,new_legend_title',
		'select'                      => '{title_legend},title,name,description;{field_legend},fieldtype,mandatory,default_value,fieldoptions,select_include_blank,foreignKey,style,tl_class;{categorization_legend},fegroup,feeditable,feviewable;{positioning_legend},position_after,new_legend,new_legend_title',
		'textarea'                    => '{title_legend},title,name,description;{field_legend},fieldtype,mandatory,default_value,minlength,maxlength,size,rgxp,wrap,nospace,preserveTags,decodeEntities,spaceToUnderscore,isunique,encrypt,allowHtml,rte,style,tl_class;{categorization_legend},fegroup,feeditable,feviewable;{positioning_legend},position_after,new_legend,new_legend_title',
		'checkbox'                    => '{title_legend},title,name,description;{field_legend},fieldtype,mandatory,default_value,fieldoptions,multiple,foreignKey,style,tl_class;{categorization_legend},fegroup,feeditable,feviewable;{positioning_legend},position_after,new_legend,new_legend_title',
		'radio'                       => '{title_legend},title,name,description;{field_legend},fieldtype,mandatory,default_value,fieldoptions,foreignKey,style,tl_class;{categorization_legend},fegroup,feeditable,feviewable;{positioning_legend},position_after,new_legend,new_legend_title',
	),

	// Subpalettes
	'subpalettes' => array
	(
		'select_include_blank'        => 'blankOptionLabel'
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'sorting' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_member_fields']['title'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'name' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_member_fields']['name'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>10, 'rgxp' => 'mysql', 'tl_class'=>'w50'),
			'sql'                     => "varchar(30) NOT NULL default ''"
		),
		'description' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_member_fields']['description'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50'),
			'sql'                     => "text NULL"
		),
		'fieldtype' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_member_fields']['fieldtype'],
			'exclude'                 => true,
			'default'                 => 'text',
			'inputType'               => 'select',
			'options_callback'        => array('tl_member_fields', 'getFieldTypes'),
			'eval'                    => array('mandatory'=>true, 'submitOnChange'=>true, 'tl_class'=>'w50'),
			'sql'                     => "varchar(30) NOT NULL default 'text'"
		),
		'wrap' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_member_fields']['wrap'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'options'                 => $GLOBALS['TL_LANG']['tl_member_fields']['wrapping'],
			'eval'                    => array('mandatory'=>false, 'includeBlankOption' => true, 'tl_class'=>'w50'),
			'sql'                     => "varchar(10) NOT NULL default ''"
		),
		'style' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_member_fields']['style'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength' => 255, 'tl_class'=>'w50 clr'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'default_value' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_member_fields']['default_value'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'minlength' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_member_fields']['minlength'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>6, 'rgxp' => 'digit', 'tl_class'=>'w50'),
			'sql'                     => "varchar(30) NOT NULL default ''"
		),
		'rgxp' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_member_fields']['rgxp'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'tl_class'=>'w50'),
			'sql'                     => "varchar(10) NOT NULL default ''"
		),
		'maxlength' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_member_fields']['maxlength'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>6, 'rgxp' => 'digit', 'tl_class'=>'w50'),
			'sql'                     => "varchar(30) NOT NULL default ''"

		),
		'tl_class' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_member_fields']['tl_class'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'tl_class'=>'w50'),
			'sql'                     => "varchar(50) NOT NULL default ''"
		),
		'fieldoptions' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_member_fields']['fieldoptions'],
			'exclude'                 => true,
			'inputType'               => 'multitextWizard',
			'eval'                    => array('tl_class' => 'clr', 'style' => 'width: 100%;', 'doNotSaveEmpty'=>true, 'columns' => 2, 'labels' => array(&$GLOBALS['TL_LANG']['tl_member_fields']['select_value'], &$GLOBALS['TL_LANG']['tl_member_fields']['select_text'])),
			'sql'                     => "blob NULL"
		),
		'size' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_member_fields']['size'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'multiple'=>true, 'size'=>2, 'rgxp'=>'digit', 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'select_include_blank' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_member_fields']['select_include_blank'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true, 'tl_class' => 'w50 m12'),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'blankOptionLabel' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_member_fields']['blankOptionLabel'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'tl_class'=>'w50 clr'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'foreignKey' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_member_fields']['foreignKey'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'allowHtml' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_member_fields']['allowHtml'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class' => 'w50 m12'),
			'sql'                     => "char(1) NOT NULL default '0'"
		),
		'multiple' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_member_fields']['multiple'],
			'default'                 => '1',
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class' => 'w50 m12'),
			'sql'                     => "char(1) NOT NULL default '0'"
		),
		'rte' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_member_fields']['rte'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'options'                 => $GLOBALS['TL_LANG']['tl_member_fields']['rtefiles'],
			'eval'                    => array('mandatory'=>false, 'includeBlankOption' => true, 'tl_class'=>'w50'),
			'sql'                     => "varchar(20) NOT NULL default ''"
		),
		'nospace' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_member_fields']['nospace'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class' => 'w50 m12'),
			'sql'                     => "char(1) NOT NULL default '0'"
		),
		'preserveTags' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_member_fields']['preserveTags'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class' => 'w50 m12'),
			'sql'                     => "char(1) NOT NULL default '0'"
		),
		'decodeEntities' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_member_fields']['decodeEntities'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class' => 'w50 m12'),
			'sql'                     => "char(1) NOT NULL default '0'"
		),
		'spaceToUnderscore' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_member_fields']['spaceToUnderscore'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class' => 'w50 m12'),
			'sql'                     => "char(1) NOT NULL default '0'"
		),
		'isunique' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_member_fields']['isunique'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class' => 'w50 m12'),
			'sql'                     => "char(1) NOT NULL default '0'"
		),
		'showdatepicker' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_member_fields']['showdatepicker'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class' => 'w50 m12'),
			'sql'                     => "char(1) NOT NULL default '0'"
		),
		'encrypt' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_member_fields']['encrypt'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class' => 'w50 m12'),
			'sql'                     => "char(1) NOT NULL default '0'"
		),
		'mandatory' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_member_fields']['mandatory'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class' => 'w50 m12'),
			'sql'                     => "char(1) NOT NULL default '0'"
		),
		'fegroup' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_member_fields']['fegroup'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'options_callback'        => array('tl_member_fields', 'getAvailablefeGroups'),
			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50 clr'),
			'sql'                     => "varchar(40) NOT NULL default ''"
		),
		'feeditable' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_member_fields']['feeditable'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class' => 'w50 m12'),
			'sql'                     => "char(1) NOT NULL default '1'"
		),
		'feviewable' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_member_fields']['feviewable'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class' => 'w50 m12'),
			'sql'                     => "char(1) NOT NULL default '1'"
		),
		'position_after' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_member_fields']['position_after'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'options_callback'        => array('tl_member_fields', 'getAvailableMemberFields'),
			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50'),
			'sql'                     => "varchar(150) NOT NULL default ''"
		),
		'new_legend' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_member_fields']['new_legend'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'tl_class'=>'w50', 'rgxp' => 'mysql'),
			'sql'                     => "varchar(50) NOT NULL default ''"
		),
		'new_legend_title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_member_fields']['new_legend_title'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
	)
);


/**
 * Class tl_member_fields
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Helmut Schottmüller 2009
 * @author     Helmut Schottmüller <typolight@aurealis.de>
 * @package    Controller
 */
class tl_member_fields extends Backend
{
	public function getFieldTypes()
	{
		return array(
			'text'     => $GLOBALS['TL_LANG']['tl_member_fields']['field_text'], 
			'textarea' => $GLOBALS['TL_LANG']['tl_member_fields']['field_textarea'], 
			'select'   => $GLOBALS['TL_LANG']['tl_member_fields']['field_select'], 
			'checkbox' => $GLOBALS['TL_LANG']['tl_member_fields']['field_checkbox'],
			'radio'    => $GLOBALS['TL_LANG']['tl_member_fields']['field_radio']
		);
	}
	
	public function getAvailableMemberFields()
	{
		$this->loadDataContainer('tl_member');
		$this->loadLanguageFile('tl_member');
		$palette = $GLOBALS['TL_DCA']['tl_member']['palettes']['default'];
		$objNewField = $this->Database->prepare("SELECT name, title, new_legend, new_legend_title, position_after FROM tl_member_fields")
			->execute();
		$newfields = array();
		while ($objNewField->next()) 
		{
			$row = $objNewField->row();
			if (strlen($row["name"]))
			{
				$newfields['xt_'.$row["name"]] = array("legend" => $row["new_legend"], "legend_title" => $row["new_legend_title"], "position" => $row["position_after"], "title" => $row["title"]);
			}
		}
		$inserts = array();
		$stack = $newfields;
		$stackcount = count($stack);
		$stackinc = 0;
		while (count($stack))
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
					}
					else
					{
						$palette .= $insert;
					}
					unset($stack[$field]);
				}
			}
			if (count($stack) == $stackcount)
			{
				$stackinc++;
			}
			else
			{
				$stackinc = 0;
			}
			$stackcount = count($stack);
			if ($stackinc > 5) break;
		}
		// remove this field and legend from the combo
		$objThisField = $this->Database->prepare("SELECT name, new_legend FROM tl_member_fields WHERE id = ?")
			->execute(\Input::get('id'));
		$thisfield = $objThisField->row();
		if (strlen($thisfield["name"]))
		{
			$remove = "";
			if (strlen($thisfield["new_legend"]))
			{
				$remove = ";{" . $thisfield["new_legend"] . "}," . $thisfield["name"];
			}
			else
			{
				$remove = "," . $thisfield["name"];
			}
			$palette = str_replace($remove, "", $palette);
		}
		
		$fields = preg_split("/[,;]/", $palette);
		$translatedfields = array();
		foreach ($fields as $key => $value)
		{
			if (preg_match("/\\{(\\w+)(:hide){0,1}\\}/", $value, $matches))
			{
				if (strlen($GLOBALS['TL_LANG']['tl_member'][$matches[1]]))
				{
					$translatedfields[$value] = "{".$GLOBALS['TL_LANG']['tl_member'][$matches[1]]."}";
				}
				else
				{
					foreach ($newfields as $field => $fielddata)
					{
						if (strcmp($fielddata["legend"], $matches[1]) == 0)
						{
							$translatedfields[$value] = "{".$fielddata["legend_title"]."}";
						}
					}
				}
			}
			else
			{
				if (strlen($GLOBALS['TL_LANG']['tl_member'][$value][0]))
				{
					$translatedfields[$value] = $GLOBALS['TL_LANG']['tl_member'][$value][0];
				}
				else
				{
					$translatedfields[$value] = $newfields[$value]["title"];
				}
			}
		}

		return $translatedfields;
	}
	
	public function getAvailablefeGroups()
	{
		$feGroup = array();
		$this->loadDataContainer('tl_member');
		foreach ($GLOBALS['TL_DCA']['tl_member']['fields'] as $field)
		{
			if (array_key_exists('eval', $field) && array_key_exists('feGroup', $field['eval'])) 
			{
				$feGroup[$field['eval']['feGroup']] = $field['eval']['feGroup'];
			}
		}
		return $feGroup;
	}
	
}

