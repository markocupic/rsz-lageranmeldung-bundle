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

/**
 * Class ProcessFormDataListener
 * @package Markocupic\RszLageranmeldungBundle\EventListener\ContaoHooks
 */
class ProcessFormDataListener
{


    /**
     * @param $arrPost
     * @param $arrForm
     * @param $arrFiles
     */
    public function processFormData(array $arrPost, array $arrForm, array $arrFiles)
    {

        if (($arrForm['formID'] === 'lager_1' || $arrForm['formID'] === 'lager_2') && FE_USER_LOGGED_IN) {
            $this->import('FrontendUser', 'User');
            $arrPost['tstamp'] = time();

            // Evtl. vorhandene alte Inhalte durch neue Inhalte ersetzen
            Database::getInstance()
                ->prepare('DELETE FROM tl_rsz_lageranmeldung WHERE username=? && lager=?')
                ->execute(
                    $this->User->username,
                    $arrForm['formID']
                );

            Database::getInstance()
                ->prepare('INSERT INTO tl_rsz_lageranmeldung %s')
                ->set($arrPost)
                ->execute();
        }
    }

}
