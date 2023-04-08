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

namespace Markocupic\RszLageranmeldungBundle\DataContainer;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\CoreBundle\Framework\ContaoFramework;
use Markocupic\ExportTable\Config\Config;
use Markocupic\ExportTable\Export\ExportTable;
use Markocupic\ExportTable\Writer\ByteSequence;
use Symfony\Component\HttpFoundation\RequestStack;

class RszLageranmeldung
{
    public function __construct(
        private readonly ContaoFramework $framework,
        private readonly RequestStack $requestStack,
        private readonly ExportTable $exportTable,
    ) {
    }

    #[AsCallback(table: 'tl_rsz_lageranmeldung', target: 'config.onload', priority: 100)]
    public function downloadEventMembersAsCsv(): void
    {
        $request = $this->requestStack->getCurrentRequest();

        if ('rsz_lageranmeldung' === $request->query->get('do') && 'csv-export' === $request->query->get('action')) {
            $config = new Config('tl_rsz_lageranmeldung');
            $config->setOutputBom(ByteSequence::BOM['UTF-8']);
            $this->exportTable->run($config);
        }
    }

    #[AsCallback(table: 'tl_rsz_lageranmeldung', target: 'config.onload', priority: 100)]
    public function addBackendAssets(): void
    {
        $GLOBALS['TL_CSS'][] = 'bundles/markocupicrszlageranmeldung/css/be_stylesheet.css|static';
    }
}
