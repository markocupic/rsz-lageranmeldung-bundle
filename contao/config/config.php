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
