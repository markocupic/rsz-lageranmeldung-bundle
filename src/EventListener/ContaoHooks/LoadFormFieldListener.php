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
use Contao\Widget;

/**
 * Class LoadFormFieldListener.
 */
class LoadFormFieldListener
{
    /**
     * @param $objWidget
     * @param $strForm
     * @param $arrForm
     *
     * @return mixed
     */
    public function loadFormField(Widget $objWidget, string $strForm, array $arrForm): Widget
    {
        if (('lager_1' === $arrForm['formID'] || 'lager_2' === $arrForm['formID']) && FE_USER_LOGGED_IN && !isset($_POST['FORM_SUBMIT'])) {
            if ('hidden' !== $objWidget->type) {

                $security = System::getContainer()->get('security.helper');
                $user = $security->getUser();
                if ($user instanceof FrontendUser)
                {
                    // Formularfelder mit evtl. bereits schon vorhandenen Inhalten aus alten Lageranmeldungen vorbelegen
                    $this->import('FrontendUser', 'User');
                    $objDb = Database::getInstance()
                        ->prepare('SELECT * FROM tl_rsz_lageranmeldung WHERE username=? && lager=?')
                        ->limit(1)
                        ->execute(
                            $user->username,
                            $arrForm['formID']
                        )
                    ;

                    if ($objDb->numRows) {
                        $arrRow = $objDb->row();

                        if (isset($arrRow[$objWidget->name])) {
                            if ('' !== $arrRow[$objWidget->name]) {
                                $objWidget->value = $arrRow[$objWidget->name];
                            }
                        }
                    }
                }
            }
        }

        return $objWidget;
    }
}
