<?php

declare(strict_types=1);

/*
 * This file is part of RSZ Lageranmeldung.
 *
 * (c) Marko Cupic 2020 <m.cupic@gmx.ch>
 * @license MIT
 * @link https://github.com/markocupic/rsz-lageranmeldung-bundle
 */

namespace Markocupic\RszLageranmeldungBundle\EventListener\ContaoHooks;

use Contao\FrontendUser;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Symfony\Component\Security\Core\Security;

/**
 * Class ProcessFormDataListener.
 */
class ProcessFormDataListener
{
    /**
     * @var Security
     */
    private $security;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * ProcessFormDataListener constructor.
     */
    public function __construct(Security $security, Connection $connection)
    {
        $this->security = $security;
        $this->connection = $connection;
    }

    /**
     * @param array $arrPost
     * @param array $arrForm
     * @param array|null $arrFiles
     * @throws Exception
     */
    public function processFormData(array $arrPost, array $arrForm, ?array $arrFiles): void
    {
        if (('lager_1' === $arrForm['formID'] || 'lager_2' === $arrForm['formID']) && FE_USER_LOGGED_IN) {
            $user = $this->security->getUser();

            if ($user instanceof FrontendUser) {
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
