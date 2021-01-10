<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use AbraFlexi\FakturaPrijata;
use AbraFlexi\Relationship\DigestModule;
use AbraFlexi\Relationship\DigestModuleInterface;
use AbraFlexi\RO;
use Ease\TWB4\Table;

/**
 * Description of incomingInvoices
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 */
class IncomingInvoices extends DigestModule implements DigestModuleInterface {

    /**
     * Column used to filter by date
     * @var string 
     */
    public $timeColumn = 'datVyst';

    public function dig() {
        $digger = new FakturaPrijata();
        $outInvoicesData = $digger->getColumnsFromAbraFlexi([
            'kod', 'typDokl',
            'popis',
            'varSym',
            'datVyst',
            'sumCelkem',
            'sumCelkemMen',
            'sumZalohy', 'sumZalohyMen', 'uhrazeno', 'storno', 'mena', 'juhSum',
            'juhSumMen'], $this->condition);
        $exposed = 0;
        $invoicedRaw = [];
        $paid = [];
        $storno = 0;

        $typDoklCounts = [];
        $typDoklTotals = [];

        if (empty($outInvoicesData)) {
            $this->addItem(_('none'));
        } else {

            $listingTable = new Table();
            $listingTable->addTagClass('table-sm table-hover table-dark');

            $listingTable->addRowHeaderColumns([_('Code'), _('Type'), _('Subject'),
                _('Variable symbol'), _('Date'), _('Amount'), _('Proformed'), _('Settled'),
                _('Currency')]);

            foreach ($outInvoicesData as $outInvoiceData) {


                $exposed++;
                if ($outInvoiceData['storno'] == 'true') {
                    $storno++;
                }
                $currency = self::getCurrency($outInvoiceData);
                $typDokl = $outInvoiceData['typDokl'];

                if ($currency != 'CZK') {
                    $amount = floatval($outInvoiceData['sumCelkemMen']);
                    $proformed = floatval($outInvoiceData['sumZalohyMen']);
                    $settled = floatval($outInvoiceData['juhSumMen']);
                } else {
                    $amount = floatval($outInvoiceData['sumCelkem']);
                    $proformed = floatval($outInvoiceData['sumZalohy']);
                    $settled = floatval($outInvoiceData['juhSum']);
                }



                if (!array_key_exists($typDokl, $typDoklTotals)) {
                    $typDoklTotals[$typDokl] = [];
                }

                if (!array_key_exists($currency, $typDoklTotals[$typDokl])) {
                    $typDoklTotals[$typDokl][$currency] = 0;
                }

                if (array_key_exists($typDokl, $typDoklCounts)) {
                    $typDoklCounts[$typDokl]++;
                    $typDoklTotals[$typDokl][$currency] += $amount;
                } else {
                    $typDoklCounts[$typDokl] = 1;
                    $typDoklTotals[$typDokl][$currency] = $amount;
                }

                if (array_key_exists($currency, $invoicedRaw)) {
                    $invoicedRaw[$currency] += $amount;
                } else {
                    $invoicedRaw[$currency] = $amount;
                }

                unset($outInvoiceData['id']);
                unset($outInvoiceData['mena']);
                unset($outInvoiceData['storno']);
                unset($outInvoiceData['typDokl@ref']);
                unset($outInvoiceData['typDokl']);
                unset($outInvoiceData['mena@ref']);
                unset($outInvoiceData['mena@showAs']);

                $outInvoiceData['sumCelkem'] = $amount;
                unset($outInvoiceData['sumCelkemMen']);
                $outInvoiceData['sumZalohy'] = $proformed;
                unset($outInvoiceData['sumZalohyMen']);
                $outInvoiceData['juhSum'] = $settled;
                unset($outInvoiceData['juhSumMen']);
                $outInvoiceData['mena'] = $currency;

                $listingTable->addRowColumns($outInvoiceData);
            }


            $this->addItem($listingTable);

            $this->addItem($this->totalsTable($typDoklTotals, $invoicedRaw,
                            $typDoklCounts));
        }
        return !empty($outInvoicesData);
    }

    public function totalsTable($typDoklTotals, $invoicedRaw, $typDoklCounts) {
        $tableHeader[] = _('Count');
        $tableHeader[] = _('Document type');
        $currencies = array_keys($invoicedRaw);
        foreach ($currencies as $currencyCode) {
            $tableHeader[] = _('Total') . ' ' . RO::uncode($currencyCode);
        }

        $outInvoicesTable = new Table();
        $outInvoicesTable->addTagClass('table-sm');
        $outInvoicesTable->addRowHeaderColumns($tableHeader);

        foreach ($typDoklTotals as $typDokl => $typDoklTotal) {
            $tableRow = [$typDoklCounts[$typDokl]];
            $tableRow[] = RO::uncode($typDokl);

            foreach ($currencies as $currencyCode) {
                $tableRow[] = array_key_exists($currencyCode,
                                $typDoklTotals[$typDokl]) ? $typDoklTotals[$typDokl][$currencyCode] : '';
            }
            $outInvoicesTable->addRowColumns($tableRow);
        }
        return $outInvoicesTable;
    }

    public function heading() {
        return _('Incoming Invoices');
    }

    /**
     * Default Description
     * 
     * @return string
     */
    public function description() {
        return _('Invoices we recieved');
    }

    //put your code here
}
