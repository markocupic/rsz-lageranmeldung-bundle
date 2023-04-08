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
use Contao\Widget;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;

#[AsHook(self::HOOK)]
class LoadFormFieldListener
{
    public const HOOK = 'loadFormField';

    public function __construct(
        private readonly Security $security,
        private readonly Connection $connection,
        private readonly RequestStack $requestStack,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(Widget $objWidget, string $strForm, array $arrForm): Widget
    {
        $user = $this->security->getUser();
        $request = $this->requestStack->getCurrentRequest();

        if ($user instanceof FrontendUser) {
            if (('lager_1' === $arrForm['formID'] || 'lager_2' === $arrForm['formID']) && !$request->request->has('FORM_SUBMIT')) {
                if ('hidden' !== $objWidget->type) {
                    // Formularfelder mit evtl. bereits vorhandenen Inhalten aus alten Lageranmeldungen vorbelegen
                    $result = $this->connection->executeQuery(
                        'SELECT * FROM tl_rsz_lageranmeldung WHERE username=? && lager = ? LIMIT 0,1',
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
