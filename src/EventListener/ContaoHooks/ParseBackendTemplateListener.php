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

/**
 * Class ParseBackendTemplateListener
 * @package Markocupic\RszLageranmeldungBundle\EventListener\ContaoHooks
 */
class ParseBackendTemplateListener
{


    public function addDownloadButton(string $buffer, string $template): string
    {
        die('d');

        if ('be_main' === $template) {
            die('d');
            // Modify $buffer
        }

        return $buffer;
    }

}
