<?php

declare(strict_types=1);

/*
 * This file is part of RSZ Lageranmeldung Bundle.
 *
 * (c) Marko Cupic 2022 <m.cupic@gmx.ch>
 * @license MIT
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 * @link https://github.com/markocupic/rsz-lageranmeldung-bundle
 */

namespace Markocupic\RszLageranmeldungBundle\DataContainer;

use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\CoreBundle\ServiceAnnotation\Callback;
use Markocupic\ExportTable\Config\Config;
use Markocupic\ExportTable\Export\ExportTable;
use Markocupic\ExportTable\Writer\ByteSequence;
use Symfony\Component\HttpFoundation\RequestStack;

class RszLageranmeldung
{
    private ContaoFramework $framework;
    private RequestStack $requestStack;
    private ExportTable $exportTable;

    public function __construct(ContaoFramework $framework, RequestStack $requestStack, ExportTable $exportTable)
    {
        $this->framework = $framework;
        $this->requestStack = $requestStack;
        $this->exportTable = $exportTable;
    }

    /**
     * @Callback(table="tl_rsz_lageranmeldung", target="config.onload")
     */
    public function downloadEventMembersAsCsv(): void
    {
        $request = $this->requestStack->getCurrentRequest();

        if ('rsz_lageranmeldung' === $request->query->get('do') && 'csv-export' === $request->query->get('action')) {
            $config = new Config('tl_rsz_lageranmeldung');
            $config->setOutputBom(ByteSequence::BOM['UTF-8']);
            $this->exportTable->run($config);
        }
    }
}
