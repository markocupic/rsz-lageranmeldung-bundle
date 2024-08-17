<?php

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

namespace Markocupic\RszLageranmeldungBundle\EventListener\ContaoHooks;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\FrontendUser;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Symfony\Bundle\SecurityBundle\Security;

#[AsHook(self::HOOK)]
class ProcessFormDataListener
{
    public const HOOK = 'processFormData';

    public function __construct(
        private readonly Security $security,
        private readonly Connection $connection,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(array $arrPost, array $arrForm, array|null $arrFiles): void
    {
        $user = $this->security->getUser();

        if ($user instanceof FrontendUser) {
            if ('lager_1' === $arrForm['formID'] || 'lager_2' === $arrForm['formID']) {
                $arrPost['tstamp'] = time();

                // Delete old entry
                $this->connection->executeQuery(
                    'DELETE FROM tl_rsz_lageranmeldung WHERE username=? && lager=?',
                    [
                        $user->username,
                        $arrForm['formID'],
                    ]
                );

                // Insert new entry
                $this->connection->insert('tl_rsz_lageranmeldung', $arrPost);
            }
        }
    }
}
