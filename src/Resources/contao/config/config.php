<?php

/*
 * This file is part of RSZ Lageranmeldung.
 * 
 * (c) Marko Cupic 2020 <m.cupic@gmx.ch>
 * @license MIT
 * @link https://github.com/markocupic/rsz-lageranmeldung-bundle
 */

use Contao\Input;
use Markocupic\RszLageranmeldungBundle\Model\RszLageranmeldungModel;

/**
 * Backend modules
 */
$GLOBALS['BE_MOD']['rsz_tools']['rsz_lageranmeldung'] = [
    'tables' => ['tl_rsz_lageranmeldung'],
];

/**
 * Models
 */
$GLOBALS['TL_MODELS']['tl_rsz_lageranmeldung'] = RszLageranmeldungModel::class;

/**
 * CSS
 */
if (Input::get('do') === 'rsz_lageranmeldung') {
    $GLOBALS['TL_CSS'][] = 'bundles/markocupicrszlageranmeldung/css/be_stylesheet.css|static';
}
