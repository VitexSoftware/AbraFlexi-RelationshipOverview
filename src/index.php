<?php

declare(strict_types=1);

/**
 * This file is part of the MultiFlexi package
 *
 * https://github.com/VitexSoftware/AbraFlexi-RelationshipOverview
 *
 * (c) Vítězslav Dvořák <http://vitexsoftware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AbraFlexi\Relationship;

use AbraFlexi\Adresar;
use AbraFlexi\Relationship\ui\OptionsForm;
use AbraFlexi\RO;
use Ease\Html\ATag;
use Ease\Shared;
use Ease\TWB5\Container;
use Ease\WebPage;

require './init.php';

$shared = Shared::instanced();

$kod = WebPage::getRequestValue('kod');

if (empty($kod)) {
    $oPage->addStatusMessage(_('Bad call'), 'warning');
    $oPage->addItem(new ATag('install.php', _('Please setup your AbraFlexi connection')));
} else {
    $addresser = new Adresar(RO::code($kod));

    if ($oPage->isPosted()) {
        $from = WebPage::getRequestValue('from');
        $to = WebPage::getRequestValue('to');
        $start = new \DateTime();
        [$year, $month, $day] = explode('-', $from);
        $start->setDate((int) $year, (int) $month, (int) $day);

        $end = new \DateTime();
        [$year, $month, $day] = explode('-', $to);
        $end->setDate((int) $year, (int) $month, (int) $day);

        $period = new \DatePeriod($start, new \DateInterval('P1D'), $end);

        $formatter = new \IntlDateFormatter(
            \Locale::getDefault(), // Use the default locale
            \IntlDateFormatter::SHORT, // Short date format
            \IntlDateFormatter::NONE,  // No time format
        );

        $subject = sprintf(
            _('AbraFlexi Relationship overview with %s digest from %s to %s'),
            $addresser->getDataValue('nazev'),
            $formatter->format($period->getStartDate()->getTimestamp()),
            $formatter->format($period->getEndDate()->getTimestamp()),
        );

        $digestor = new Digestor($subject, $addresser);

        $shared->setConfigValue(
            'EASE_MAILTO',
            $oPage->getRequestValue('recipient'),
        );

        $digestor->dig($period, $oPage->getRequestValue('modules'));

        $digestor->addItem(new ATag(
            'index.php?kod='.$addresser->getDataValue('kod'),
            _('Change Options'),
        ));

        $oPage->setPageTitle($subject);
        $oPage->body->addItem($digestor);
        $oPage->draw();

        exit;
    }

    //    $outInvoice         = new \AbraFlexi\FakturaVydana();
    //    $outInvoiceOverview = $outInvoice->getSumFromAbraFlexi(['firma' => \AbraFlexi\RO::code($kod)]);
    //
    //    $inInvoice         = new \AbraFlexi\FakturaPrijata();
    //    $inInvoiceOverview = $inInvoice->getSumFromAbraFlexi(['firma' => \AbraFlexi\RO::code($kod)]);
    //
    //    $oPage->addItem('<h1>Vydane</h1>');
    //    $oPage->addItem('<pre>'.print_r($outInvoiceOverview, true).'</pre>');
    //    $oPage->addItem('<h1>Prijate</h1>');
    //    $oPage->addItem('<pre>'.print_r($inInvoiceOverview, true).'</pre>');

    $oPage->addItem(new Container(new OptionsForm($addresser)));
}

$oPage->addItem($oPage->getStatusMessagesBlock());

echo $oPage;
