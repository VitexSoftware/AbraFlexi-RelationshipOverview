<?php
/**
 * Faktura Přijatá do závazků
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright (c) 2019, Vitex Software
 */

namespace FlexiPeeHP\Relationship;

require_once './init.php';

$shared = \Ease\Shared::instanced();

$kod = \Ease\WebPage::getRequestValue('kod');

if (empty($kod)) {
    die(_('Bad call'));
} else {
    $addresser = new \FlexiPeeHP\Adresar(\FlexiPeeHP\FlexiBeeRO::code($kod));

    if ($oPage->isPosted()) {
        $from  = \Ease\WebPage::getRequestValue('from');
        $to    = \Ease\WebPage::getRequestValue('to');
        $start = new \DateTime();
        list($year, $month, $day) = explode('-', $from);
        $start->setDate($year, $month, $day);

        $end = new \DateTime();
        list($year, $month, $day) = explode('-', $to);
        $end->setDate($year, $month, $day);


        $period = new \DatePeriod($start, new \DateInterval('P1D'), $end);

        $subject = sprintf(
            _('FlexiBee Relationship overview with %s digest from %s to %s'),
            $addresser->getDataValue('nazev'),
            \strftime('%x', $period->getStartDate()->getTimestamp()),
            \strftime('%x', $period->getEndDate()->getTimestamp())
        );

        $digestor = new Digestor($subject, $addresser);

        $shared->setConfigValue('EASE_MAILTO',
            $oPage->getRequestValue('recipient'));


        $digestor->dig($period, $oPage->getRequestValue('modules'));

        $digestor->addItem(new \Ease\Html\ATag('index.php?kod='.$addresser->getDataValue('kod'),
                _('Change Options')));

        $oPage->setPageTitle($subject);
        $oPage->body = $digestor;
        $oPage->draw();
        exit();
    } else {




//    $outInvoice         = new \FlexiPeeHP\FakturaVydana();
//    $outInvoiceOverview = $outInvoice->getSumFromFlexibee(['firma' => \FlexiPeeHP\FlexiBeeRO::code($kod)]);
//
//    $inInvoice         = new \FlexiPeeHP\FakturaPrijata();
//    $inInvoiceOverview = $inInvoice->getSumFromFlexibee(['firma' => \FlexiPeeHP\FlexiBeeRO::code($kod)]);
//
//    $oPage->addItem('<h1>Vydane</h1>');
//    $oPage->addItem('<pre>'.print_r($outInvoiceOverview, true).'</pre>');
//    $oPage->addItem('<h1>Prijate</h1>');
//    $oPage->addItem('<pre>'.print_r($inInvoiceOverview, true).'</pre>');




        $oPage->addItem(new \Ease\TWB4\Container(new ui\OptionsForm($addresser)));
    }
}

$oPage->addItem($oPage->getStatusMessagesAsHtml());

echo $oPage;
