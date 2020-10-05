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
 * Class ProcessFormDataListener
 * @package Markocupic\RszLageranmeldungBundle\EventListener\ContaoHooks
 */
class ProcessFormDataListener
{


    public function addDownloadButton(string $buffer, string $template): string
    {

        if ('be_main' === $template) {

            preg_replace('/\<table class=\"tl_listing\"(.*?)\<\/table\>','<h1>hallo</h1>', $buffer);
        }

        return $buffer;
    }

}
