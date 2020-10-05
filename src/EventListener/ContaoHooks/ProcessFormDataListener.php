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

use Contao\Database;
use Contao\FrontendUser;
use Contao\System;

/**
 * Class ProcessFormDataListener.
 */
class ProcessFormDataListener
{
    /**
     * @param $arrPost
     * @param $arrForm
     * @param $arrFiles
     */
    public function processFormData(array $arrPost, array $arrForm, array $arrFiles): void
    {
        if (('lager_1' === $arrForm['formID'] || 'lager_2' === $arrForm['formID']) && FE_USER_LOGGED_IN) {
            $security = System::getContainer()->get('security.helper');
            $user = $security->getUser();

            if ($user instanceof FrontendUser) {
                $arrPost['tstamp'] = time();

                // Evtl. vorhandene alte Inhalte durch neue Inhalte ersetzen
                Database::getInstance()
                    ->prepare('DELETE FROM tl_rsz_lageranmeldung WHERE username=? && lager=?')
                    ->execute(
                        $user->username,
                        $arrForm['formID']
                    )
                ;

                Database::getInstance()
                    ->prepare('INSERT INTO tl_rsz_lageranmeldung %s')
                    ->set($arrPost)
                    ->execute()
                ;
            }
        }
    }
    
}
