<?php

/**
 * Faktura Přijatá do závazků
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright (c) 2019, Vitex Software
 */

namespace AbraFlexi\Relationship;

use AbraFlexi\Adresar;
use AbraFlexi\Relationship\ui\OptionsForm;
use AbraFlexi\RO;
use DateInterval;
use DatePeriod;
use DateTime;
use Ease\Html\ATag;
use Ease\Shared;
use Ease\TWB4\Container;
use Ease\WebPage;

require_once './init.php';

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
        $start = new DateTime();
        list($year, $month, $day) = explode('-', $from);
        $start->setDate($year, $month, $day);

        $end = new DateTime();
        list($year, $month, $day) = explode('-', $to);
        $end->setDate($year, $month, $day);

        $period = new DatePeriod($start, new DateInterval('P1D'), $end);

        $subject = sprintf(
                _('AbraFlexi Relationship overview with %s digest from %s to %s'),
                $addresser->getDataValue('nazev'),
                \strftime('%x', $period->getStartDate()->getTimestamp()),
                \strftime('%x', $period->getEndDate()->getTimestamp())
        );

        $digestor = new Digestor($subject, $addresser);

        $shared->setConfigValue('EASE_MAILTO',
                $oPage->getRequestValue('recipient'));

        $digestor->dig($period, $oPage->getRequestValue('modules'));

        $digestor->addItem(new ATag('index.php?kod=' . $addresser->getDataValue('kod'),
                        _('Change Options')));

        $oPage->setPageTitle($subject);
        $oPage->body->addItem($digestor);
        $oPage->draw();
        exit();
    } else {




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
}

$oPage->addItem($oPage->getStatusMessagesBlock());

echo $oPage;
