<?php

declare(strict_types=1);

/*
 * This file is part of RSZ Lageranmeldung Bundle.
 *
 * (c) Marko Cupic 2022 <m.cupic@gmx.ch>
 * @license MIT
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 * @link https://github.com/markocupic/rsz-lageranmeldung-bundle
 */

use Contao\Input;
use Markocupic\RszLageranmeldungBundle\Model\RszLageranmeldungModel;

/*
 * Backend modules
 */
$GLOBALS['BE_MOD']['rsz_tools']['rsz_lageranmeldung'] = [
    'tables' => ['tl_rsz_lageranmeldung'],
];

/*
 * Models
 */
$GLOBALS['TL_MODELS']['tl_rsz_lageranmeldung'] = RszLageranmeldungModel::class;

/*
 * CSS
 */
if ('rsz_lageranmeldung' === Input::get('do')) {
    $GLOBALS['TL_CSS'][] = 'bundles/markocupicrszlageranmeldung/css/be_stylesheet.css|static';
}
