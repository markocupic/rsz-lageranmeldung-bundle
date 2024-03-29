<?php

/*
 * This file is part of RSZ Lageranmeldung.
 *
 * (c) Marko Cupic 2023 <m.cupic@gmx.ch>
 * @license MIT
 * @link https://github.com/markocupic/rsz-lageranmeldung-bundle
 */
declare(strict_types=1);

/*
 * This file is part of Contao RSZ Lageranmeldung Bundle.
 *
 * (c) Marko Cupic 2023 <m.cupic@gmx.ch>
 * @license GPL-3.0-or-later
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 * @link https://github.com/markocupic/rsz-lageranmeldung-bundle
 */

namespace Markocupic\RszLageranmeldungBundle\Model;

use Contao\Model;

/**
 * Class RszLageranmeldungModel.
 */
class RszLageranmeldungModel extends Model
{
    protected static $strTable = 'tl_rsz_lageranmeldung';
}
