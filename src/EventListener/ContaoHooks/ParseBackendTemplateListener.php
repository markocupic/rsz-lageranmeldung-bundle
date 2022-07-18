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

namespace Markocupic\RszLageranmeldungBundle\EventListener\ContaoHooks;

use Haste\Util\Url;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class ParseBackendTemplateListener.
 */
class ParseBackendTemplateListener
{
    /**
     * @var RequestStack
     */
    private $requstStack;

    /**
     * ParseBackendTemplateListener constructor.
     */
    public function __construct(RequestStack $requstStack)
    {
        $this->requstStack = $requstStack;
    }

    /**
     * Add download button to the bottom.
     */
    public function addDownloadButton(string $buffer, string $template): string
    {
        $request = $this->requstStack->getCurrentRequest();

        if ('be_main' === $template && 'rsz_lageranmeldung' === $request->query->get('do')) {
            $button = sprintf(
                '<a href="/%s" class="rsz-lageranmeldung-csv-export-button tl_submit">Excel Export</a>',
                Url::addQueryString('action=csv-export')
            );

            if (null !== ($html = preg_replace('/<table class="tl_listing(.*?)<\/table>/is', '<table class="tl_listing$1</table>'.$button, $buffer))) {
                $buffer = $html;
            }
        }

        return $buffer;
    }
}
