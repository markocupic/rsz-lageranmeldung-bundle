<?php

declare(strict_types=1);

/*
 * This file is part of RSZ Lageranmeldung.
 *
 * (c) Marko Cupic 2020 <m.cupic@gmx.ch>
 * @license MIT
 * @link https://github.com/markocupic/rsz-lageranmeldung-bundle
 */

namespace Markocupic\RszJahresprogrammBundle\EventListener\ContaoHooks;

use Contao\Database;
use Contao\Widget;

/**
 * Class LoadFormFieldListener
 * @package Markocupic\RszLageranmeldungBundle\EventListener\ContaoHooks
 */
class LoadFormFieldListener
{


    /**
     * @param $objWidget
     * @param $strForm
     * @param $arrForm
     * @return mixed
     */
    public function loadFormField(Widget $objWidget, string $strForm, array $arrForm): Widget
    {
        if (($arrForm['formID'] == 'lager_1' || $arrForm['formID'] == 'lager_2') && FE_USER_LOGGED_IN && !isset($_POST['FORM_SUBMIT'])) {
            if ($objWidget->type != 'hidden') {
                // Formularfelder mit evtl. bereits schon vorhandenen Inhalten aus alten Lageranmeldungen vorbelegen
                $this->import('FrontendUser', 'User');
                $objDb = Database::getInstance()
                    ->prepare('SELECT * FROM tl_rsz_lageranmeldung WHERE username=? && lager=?')
                    ->limit(1)
                    ->execute(
                        $this->User->username,
                        $arrForm['formID']
                    );
                if ($objDb->numRows) {
                    $arrRow = $objDb->row();
                    if (isset($arrRow[$objWidget->name])) {
                        if ($arrRow[$objWidget->name] != '') {
                            $objWidget->value = $arrRow[$objWidget->name];
                        }
                    }
                }
            }
        }

        return $objWidget;
    }


}
