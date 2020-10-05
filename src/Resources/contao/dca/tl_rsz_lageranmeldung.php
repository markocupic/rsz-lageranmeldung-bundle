<?php

/*
 * This file is part of RSZ Lageranmeldung.
 *
 * (c) Marko Cupic 2020 <m.cupic@gmx.ch>
 * @license MIT
 * @link https://github.com/markocupic/rsz-lageranmeldung-bundle
 */

use Contao\Backend;
use Contao\Input;
use Markocupic\ExportTable\ExportTable;

$GLOBALS['TL_DCA']['tl_rsz_lageranmeldung'] = array(
	'config'   => array(
		'dataContainer'    => 'Table',
		'doNotCopyRecords' => true,
		'enableVersioning' => true,
		'switchToEdit'     => true,
		'sql'              => array(
			'keys' => array(
				'id' => 'primary',
			),
		),
		'onload_callback'  => array(
			array('tl_rsz_lageranmeldung', 'downloadEventMembersAsCsv'),
		),
	),
	'list'     => array(
		'sorting'           => array(
			'mode'        => 2,
			'fields'      => array('firstname DESC'),
			'flag'        => 1,
			'panelLayout' => 'filter;sort,search,limit',
		),
		'label'             => array(
			'fields'      => array('firstname', 'lastname', 'lager', 'tstamp'),
			'showColumns' => true,
		),
		'global_operations' => array(
			'all' => array(
				'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'       => 'act=select',
				'class'      => 'header_edit_all',
				'attributes' => 'onclick="Backend.getScrollOffset();"',
			),
		),
		'operations'        => array(
			'edit'   => array(
				'label' => &$GLOBALS['TL_LANG']['tl_rsz_lageranmeldung']['edit'],
				'href'  => 'act=edit',
				'icon'  => 'edit.gif',
			),
			'copy'   => array(
				'label' => &$GLOBALS['TL_LANG']['tl_news']['copy'],
				'href'  => 'act=copy',
				'icon'  => 'copy.gif',
			),
			'delete' => array(
				'label'      => &$GLOBALS['TL_LANG']['tl_rsz_lageranmeldung']['delete'],
				'href'       => 'act=delete',
				'icon'       => 'delete.gif',
				'attributes' => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"',
			),
			'show'   => array(
				'label' => &$GLOBALS['TL_LANG']['tl_rsz_lageranmeldung']['show'],
				'href'  => 'act=show',
				'icon'  => 'show.gif',
			),
		),
	),
	'palettes' => array(
		'default' => 'lager,take_part,username,firstname,lastname,street,postal,city,contact_person_name,contact_person_phone,medicaments,tent_size',
	),
	'fields'   => array(
		'id'                   => array(
			'sql' => "int(10) unsigned NOT NULL auto_increment",
		),
		'tstamp'               => array(
			'label'   => &$GLOBALS['TL_LANG']['tl_rsz_lageranmeldung']['tstamp'],
			'sorting' => true,
			'flag'    => 6,
			'sql'     => "int(10) unsigned NOT NULL default '0'",
		),
		'take_part'            => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_rsz_lageranmeldung']['take_part'],
			'exclude'   => true,
			'search'    => true,
			'filter'    => true,
			'sorting'   => true,
			'inputType' => 'select',
			'options'   => array('ja', 'nein'),
			'sql'       => "varchar(8) NOT NULL default 'nein'",
		),
		'lager'                => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_rsz_lageranmeldung']['lager'],
			'exclude'   => true,
			'search'    => true,
			'filter'    => true,
			'sorting'   => true,
			'inputType' => 'select',
			'options'   => array('lager_1', 'lager_2'),
			'eval'      => array('mandatory' => true, 'maxlength' => 255),
			'sql'       => "varchar(255) NOT NULL default ''",
		),
		'username'             => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_rsz_lageranmeldung']['username'],
			'exclude'   => true,
			'search'    => true,
			'sorting'   => true,
			'inputType' => 'text',
			'eval'      => array('mandatory' => true, 'unique' => true, 'nullIfEmpty' => true, 'maxlength' => 255),
			'sql'       => "varchar(64) COLLATE utf8_bin NULL",
		),
		'firstname'            => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_rsz_lageranmeldung']['firstname'],
			'exclude'   => true,
			'search'    => true,
			'sorting'   => true,
			'inputType' => 'text',
			'eval'      => array('mandatory' => true, 'maxlength' => 255),
			'sql'       => "varchar(255) NOT NULL default ''",
		),
		'lastname'             => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_rsz_lageranmeldung']['lastname'],
			'exclude'   => true,
			'search'    => true,
			'sorting'   => true,
			'inputType' => 'text',
			'eval'      => array('mandatory' => true, 'maxlength' => 255),
			'sql'       => "varchar(255) NOT NULL default ''",
		),
		'street'               => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_rsz_lageranmeldung']['street'],
			'exclude'   => true,
			'search'    => true,
			'sorting'   => true,
			'inputType' => 'text',
			'eval'      => array('mandatory' => true, 'maxlength' => 255),
			'sql'       => "varchar(255) NOT NULL default ''",
		),
		'postal'               => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_rsz_lageranmeldung']['postal'],
			'exclude'   => true,
			'search'    => true,
			'sorting'   => true,
			'inputType' => 'text',
			'eval'      => array('mandatory' => true, 'maxlength' => 4),
			'sql'       => "varchar(4) NOT NULL default ''",
		),
		'city'                 => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_rsz_lageranmeldung']['city'],
			'exclude'   => true,
			'search'    => true,
			'sorting'   => true,
			'inputType' => 'text',
			'eval'      => array('mandatory' => true, 'maxlength' => 255),
			'sql'       => "varchar(255) NOT NULL default ''",
		),
		'contact_person_name'  => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_rsz_lageranmeldung']['contact_person_name'],
			'exclude'   => true,
			'search'    => true,
			'sorting'   => true,
			'inputType' => 'text',
			'eval'      => array('mandatory' => true, 'maxlength' => 255),
			'sql'       => "varchar(255) NOT NULL default ''",
		),
		'contact_person_phone' => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_rsz_lageranmeldung']['contact_person_phone'],
			'exclude'   => true,
			'search'    => true,
			'sorting'   => true,
			'inputType' => 'text',
			'eval'      => array('mandatory' => true, 'maxlength' => 64, 'rgxp' => 'phone', 'decodeEntities' => true, 'tl_class' => 'w50'),
			'sql'       => "varchar(64) NOT NULL default ''",
		),
		'medicaments'          => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_rsz_lageranmeldung']['medicaments'],
			'exclude'   => false,
			'search'    => true,
			'inputType' => 'textarea',
			'eval'      => array('mandatory' => false, 'maxlength' => 512, 'tl_class' => 'clr'),
			'sql'       => "varchar(512) NOT NULL default ''",
		),
		'tent_size'            => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_rsz_lageranmeldung']['tent_size'],
			'exclude'   => false,
			'search'    => true,
			'inputType' => 'select',
			'options'   => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
			'eval'      => array('mandatory' => false, 'maxlength' => 128),
			'sql'       => "smallint(5) unsigned NOT NULL default '0'",
		),
	),
);

/**
 * Class tl_rsz_lageranmeldung
 */
class tl_rsz_lageranmeldung extends Backend
{
	/**
	 * Export event members as csv spreadsheet after clicking the export button
	 */
	public function downloadEventMembersAsCsv()
	{
		if (Input::get('do') === 'rsz_lageranmeldung' && Input::get('action') === 'csv-export')
		{
			ExportTable::exportTable('tl_rsz_lageranmeldung');
		}
	}

	public function labelCallback($row, $label)
	{
		return $label;
	}
}
