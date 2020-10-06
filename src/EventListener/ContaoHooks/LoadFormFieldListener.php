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
use Contao\Widget;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;

/**
 * Class LoadFormFieldListener.
 */
class LoadFormFieldListener
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
     * @var RequestStack
     */
    private $requestStack;

    /**
     * LoadFormFieldListener constructor.
     */
    public function __construct(Security $security, Connection $connection, RequestStack $requestStack)
    {
        $this->security = $security;
        $this->connection = $connection;
        $this->requestStack = $requestStack;
    }

    /**
     * @throws Exception
     */
    public function loadFormField(Widget $objWidget, string $strForm, array $arrForm): Widget
    {
        $user = $this->security->getUser();
        $request = $this->requestStack->getCurrentRequest();

        if ($user instanceof FrontendUser) {
            
        if (('lager_1' === $arrForm['formID'] || 'lager_2' === $arrForm['formID']) && !$request->request->has('FORM_SUBMIT')) {
            if ('hidden' !== $objWidget->type) {

                    // Formularfelder mit evtl. bereits schon vorhandenen Inhalten aus alten Lageranmeldungen vorbelegen
                    $result = $this->connection->executeQuery(
                            'SELECT * FROM tl_rsz_lageranmeldung WHERE username=? && lager=? LIMIT 0,1',
                            [$user->username, $arrForm['formID']]
                        );

                    if ($result->rowCount()) {
                        $arrRow = $result->fetch();

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
