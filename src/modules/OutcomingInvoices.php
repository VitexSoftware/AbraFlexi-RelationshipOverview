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

use AbraFlexi\Relationship\DigestModule;
use AbraFlexi\Relationship\DigestModuleInterface;

/**
 * Description of outcomingInvoices.
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 */
class OutcomingInvoices extends DigestModule implements DigestModuleInterface
{
    /**
     * Column used to filter by date.
     */
    public string $timeColumn = 'datVyst';

    public function dig()
    {
        $digger = new AbraFlexi\FakturaVydana();
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
            $listingTable = new \Ease\TWB5\Table();
            $listingTable->addTagClass('table-sm table-hover table-dark');

            $listingTable->addRowHeaderColumns([_('Code'), _('Type'), _('Subject'),
                _('Variable symbol'), _('Date'), _('Amount'), _('Proformed'), _('Settled'),
                _('Currency')]);

            foreach ($outInvoicesData as $outInvoiceData) {
                ++$exposed;

                if ($outInvoiceData['storno'] === 'true') {
                    ++$storno;
                }

                $currency = self::getCurrency($outInvoiceData);
                $typDokl = \AbraFlexi\RO::uncode((string) $outInvoiceData['typDokl']);

                if ($currency !== 'CZK') {
                    $amount = (float) $outInvoiceData['sumCelkemMen'];
                    $proformed = (float) $outInvoiceData['sumZalohyMen'];
                    $settled = (float) $outInvoiceData['juhSumMen'];
                } else {
                    $amount = (float) $outInvoiceData['sumCelkem'];
                    $proformed = (float) $outInvoiceData['sumZalohy'];
                    $settled = (float) $outInvoiceData['juhSum'];
                }

                if (!\array_key_exists($typDokl, $typDoklTotals)) {
                    $typDoklTotals[$typDokl] = [];
                }

                if (!\array_key_exists($currency, $typDoklTotals[$typDokl])) {
                    $typDoklTotals[$typDokl][$currency] = 0;
                }

                if (\array_key_exists($typDokl, $typDoklCounts)) {
                    ++$typDoklCounts[$typDokl];
                    $typDoklTotals[$typDokl][$currency] += $amount;
                } else {
                    $typDoklCounts[$typDokl] = 1;
                    $typDoklTotals[$typDokl][$currency] = $amount;
                }

                if (\array_key_exists($currency, $invoicedRaw)) {
                    $invoicedRaw[$currency] += $amount;
                } else {
                    $invoicedRaw[$currency] = $amount;
                }

                unset($outInvoiceData['id'], $outInvoiceData['mena'], $outInvoiceData['storno'], $outInvoiceData['typDokl@ref'], $outInvoiceData['typDokl'], $outInvoiceData['mena@ref'], $outInvoiceData['mena@showAs']);

                $outInvoiceData['sumCelkem'] = $amount;
                unset($outInvoiceData['sumCelkemMen']);
                $outInvoiceData['sumZalohy'] = $proformed;
                unset($outInvoiceData['sumZalohyMen']);
                $outInvoiceData['juhSum'] = $settled;
                unset($outInvoiceData['juhSumMen']);
                $outInvoiceData['mena'] = $currency;
                $outInvoiceData['datVyst'] = $outInvoiceData['datVyst']->format('c');
                $listingTable->addRowColumns($outInvoiceData);
            }

            $this->addItem($listingTable);

            $this->addItem($this->totalsTable(
                $typDoklTotals,
                $invoicedRaw,
                $typDoklCounts,
            ));
        }

        return !empty($outInvoicesData);
    }

    public function totalsTable($typDoklTotals, $invoicedRaw, $typDoklCounts)
    {
        $tableHeader[] = _('Count');
        $tableHeader[] = _('Document type');
        $currencies = array_keys($invoicedRaw);

        foreach ($currencies as $currencyCode) {
            $tableHeader[] = _('Total').' '.\AbraFlexi\RO::uncode($currencyCode);
        }

        $outInvoicesTable = new \Ease\TWB5\Table();
        $outInvoicesTable->addTagClass('table-sm');
        $outInvoicesTable->addRowHeaderColumns($tableHeader);

        foreach ($typDoklTotals as $typDokl => $typDoklTotal) {
            $tableRow = [$typDoklCounts[$typDokl]];
            $tableRow[] = \AbraFlexi\RO::uncode($typDokl);

            foreach ($currencies as $currencyCode) {
                $tableRow[] = \array_key_exists(
                    $currencyCode,
                    $typDoklTotals[$typDokl],
                ) ? $typDoklTotals[$typDokl][$currencyCode] : '';
            }

            $outInvoicesTable->addRowColumns($tableRow);
        }

        return $outInvoicesTable;
    }

    public function heading()
    {
        return _('Outcoming Invoices');
    }

    /**
     * Default Description.
     *
     * @return string
     */
    public function description()
    {
        return _('Invoices we issued');
    }
}
