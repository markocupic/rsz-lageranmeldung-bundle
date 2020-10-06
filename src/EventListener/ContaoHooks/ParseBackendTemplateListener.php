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

use Contao\Input;
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
     * @param RequestStack $requstStack
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
