<?php

declare(strict_types=1);

/*
 * This file is part of RSZ Lageranmeldung Bundle.
 *
 * (c) Marko Cupic 2023 <m.cupic@gmx.ch>
 * @license MIT
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 * @link https://github.com/markocupic/rsz-lageranmeldung-bundle
 */

use Contao\DataContainer;
use Contao\DC_Table;

$GLOBALS['TL_DCA']['tl_rsz_lageranmeldung'] = [
    'config'   => [
        'dataContainer'    => DC_Table::class,
        'doNotCopyRecords' => true,
        'enableVersioning' => true,
        'switchToEdit'     => true,
        'sql'              => [
            'keys' => [
                'id' => 'primary',
            ],
        ],
    ],
    'list'     => [
        'sorting'           => [
            'mode'        => DataContainer::MODE_SORTABLE,
            'fields'      => ['firstname DESC'],
            'flag'        => DataContainer::SORT_INITIAL_LETTER_ASC,
            'panelLayout' => 'filter;sort,search,limit',
        ],
        'label'             => [
            'fields'      => ['firstname', 'lastname', 'lager', 'tstamp'],
            'showColumns' => true,
        ],
        'global_operations' => [
            'all' => [
                'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'       => 'act=select',
                'class'      => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset();"',
            ],
        ],
        'operations'        => [
            'edit'   => [
                'label' => &$GLOBALS['TL_LANG']['tl_rsz_lageranmeldung']['edit'],
                'href'  => 'act=edit',
                'icon'  => 'edit.gif',
            ],
            'copy'   => [
                'label' => &$GLOBALS['TL_LANG']['tl_news']['copy'],
                'href'  => 'act=copy',
                'icon'  => 'copy.gif',
            ],
            'delete' => [
                'label'      => &$GLOBALS['TL_LANG']['tl_rsz_lageranmeldung']['delete'],
                'href'       => 'act=delete',
                'icon'       => 'delete.gif',
                'attributes' => 'onclick="if (!confirm(\''.($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? null).'\')) return false; Backend.getScrollOffset();"',
            ],
            'show'   => [
                'label' => &$GLOBALS['TL_LANG']['tl_rsz_lageranmeldung']['show'],
                'href'  => 'act=show',
                'icon'  => 'show.gif',
            ],
        ],
    ],
    'palettes' => [
        'default' => 'lager,take_part,username,firstname,lastname,street,postal,city,contact_person_name,contact_person_phone,medicaments,tent_size',
    ],
    'fields'   => [
        'id'                   => [
            'sql' => 'int(10) unsigned NOT NULL auto_increment',
        ],
        'tstamp'               => [
            'label'   => &$GLOBALS['TL_LANG']['tl_rsz_lageranmeldung']['tstamp'],
            'sorting' => true,
            'flag'    => DataContainer::SORT_DAY_DESC,
            'sql'     => "int(10) unsigned NOT NULL default '0'",
        ],
        'take_part'            => [
            'exclude'   => true,
            'search'    => true,
            'filter'    => true,
            'sorting'   => true,
            'inputType' => 'select',
            'options'   => ['ja', 'nein'],
            'sql'       => "varchar(8) NOT NULL default 'nein'",
        ],
        'lager'                => [
            'exclude'   => true,
            'search'    => true,
            'filter'    => true,
            'sorting'   => true,
            'inputType' => 'select',
            'options'   => ['lager_1', 'lager_2'],
            'eval'      => ['mandatory' => true, 'maxlength' => 255],
            'sql'       => "varchar(255) NOT NULL default ''",
        ],
        'username'             => [
            'exclude'   => true,
            'search'    => true,
            'sorting'   => true,
            'inputType' => 'text',
            'eval'      => ['mandatory' => true, 'unique' => true, 'nullIfEmpty' => true, 'maxlength' => 255],
            'sql'       => 'varchar(64) BINARY NULL',
        ],
        'firstname'            => [
            'exclude'   => true,
            'search'    => true,
            'sorting'   => true,
            'inputType' => 'text',
            'eval'      => ['mandatory' => true, 'maxlength' => 255],
            'sql'       => "varchar(255) NOT NULL default ''",
        ],
        'lastname'             => [
            'exclude'   => true,
            'search'    => true,
            'sorting'   => true,
            'inputType' => 'text',
            'eval'      => ['mandatory' => true, 'maxlength' => 255],
            'sql'       => "varchar(255) NOT NULL default ''",
        ],
        'street'               => [
            'exclude'   => true,
            'search'    => true,
            'sorting'   => true,
            'inputType' => 'text',
            'eval'      => ['mandatory' => true, 'maxlength' => 255],
            'sql'       => "varchar(255) NOT NULL default ''",
        ],
        'postal'               => [
            'exclude'   => true,
            'search'    => true,
            'sorting'   => true,
            'inputType' => 'text',
            'eval'      => ['mandatory' => true, 'maxlength' => 4],
            'sql'       => "varchar(4) NOT NULL default ''",
        ],
        'city'                 => [
            'exclude'   => true,
            'search'    => true,
            'sorting'   => true,
            'inputType' => 'text',
            'eval'      => ['mandatory' => true, 'maxlength' => 255],
            'sql'       => "varchar(255) NOT NULL default ''",
        ],
        'contact_person_name'  => [
            'exclude'   => true,
            'search'    => true,
            'sorting'   => true,
            'inputType' => 'text',
            'eval'      => ['mandatory' => true, 'maxlength' => 255],
            'sql'       => "varchar(255) NOT NULL default ''",
        ],
        'contact_person_phone' => [
            'exclude'   => true,
            'search'    => true,
            'sorting'   => true,
            'inputType' => 'text',
            'eval'      => ['mandatory' => true, 'maxlength' => 64, 'rgxp' => 'phone', 'decodeEntities' => true, 'tl_class' => 'w50'],
            'sql'       => "varchar(64) NOT NULL default ''",
        ],
        'medicaments'          => [
            'exclude'   => false,
            'search'    => true,
            'inputType' => 'textarea',
            'eval'      => ['mandatory' => false, 'maxlength' => 512, 'tl_class' => 'clr'],
            'sql'       => "varchar(512) NOT NULL default ''",
        ],
        'tent_size'            => [
            'exclude'   => false,
            'search'    => true,
            'inputType' => 'select',
            'options'   => range(1, 10),
            'eval'      => ['mandatory' => false, 'maxlength' => 128],
            'sql'       => "smallint(5) unsigned NOT NULL default '0'",
        ],
    ],
];
