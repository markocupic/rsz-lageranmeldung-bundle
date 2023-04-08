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

use Codefog\HasteBundle\UrlParser;
use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Symfony\Component\HttpFoundation\RequestStack;

#[AsHook(self::HOOK)]
class ParseBackendTemplateListener
{
    public const HOOK = 'parseBackendTemplate';

    public function __construct(
        private readonly RequestStack $requstStack,
        private readonly UrlParser $urlParser,
    ) {
    }

    /**
     * Add the download button to the bottom.
     */
    public function __invoke(string $buffer, string $template): string
    {
        $request = $this->requstStack->getCurrentRequest();

        if ('be_main' === $template && 'rsz_lageranmeldung' === $request->query->get('do')) {
            $button = sprintf(
                '<a href="/%s" class="rsz-lageranmeldung-csv-export-button tl_submit">Excel Export</a>',
                $this->urlParser->addQueryString('action=csv-export')
            );

            if (null !== ($html = preg_replace('/<table class="tl_listing(.*?)<\/table>/is', '<table class="tl_listing$1</table>'.$button, $buffer))) {
                $buffer = $html;
            }
        }

        return $buffer;
    }
}
