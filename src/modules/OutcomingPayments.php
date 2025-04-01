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
 * Description of outcomingPayments.
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 */
class OutcomingPayments extends DigestModule implements DigestModuleInterface
{
    /**
     * Column used to filter by date.
     */
    public string $timeColumn = 'datVyst';

    public function dig()
    {
        $digger = new AbraFlexi\Banka();
        $this->condition['typPohybuK'] = 'typPohybu.vydej';
        $outInvoicesData = $digger->getColumnsFromAbraFlexi([
            'kod',
            'banka',
            'popis',
            'varSym',
            'datVyst',
            'sumCelkem',
            'sumCelkemMen',
            'mena',
            'juhSumMen'], $this->condition);
        $exposed = 0;
        $invoicedRaw = [];
        $paid = [];
        $storno = 0;

        $bankaCounts = [];
        $bankaTotals = [];

        if (empty($outInvoicesData)) {
            $this->addItem(_('none'));
        } else {
            $listingTable = new \Ease\TWB5\Table();
            $listingTable->addTagClass('table-sm table-hover table-dark');

            $listingTable->addRowHeaderColumns([_('Code'), _('Bank'), _('Subject'),
                _('Variable symbol'), _('Date'), _('Amount'), _('Currency')]);

            foreach ($outInvoicesData as $incomingPaymentData) {
                ++$exposed;
                $currency = self::getCurrency($incomingPaymentData);
                $banka = \AbraFlexi\RO::uncode($incomingPaymentData['banka']);

                if ($currency !== 'CZK') {
                    $amount = (float) $incomingPaymentData['sumCelkemMen'];
                } else {
                    $amount = (float) $incomingPaymentData['sumCelkem'];
                }

                if (!\array_key_exists($banka, $bankaTotals)) {
                    $bankaTotals[$banka] = [];
                }

                if (!\array_key_exists($currency, $bankaTotals[$banka])) {
                    $bankaTotals[$banka][$currency] = 0;
                }

                if (\array_key_exists($banka, $bankaCounts)) {
                    ++$bankaCounts[$banka];
                    $bankaTotals[$banka][$currency] += $amount;
                } else {
                    $bankaCounts[$banka] = 1;
                    $bankaTotals[$banka][$currency] = $amount;
                }

                if (\array_key_exists($currency, $invoicedRaw)) {
                    $invoicedRaw[$currency] += $amount;
                } else {
                    $invoicedRaw[$currency] = $amount;
                }

                unset($incomingPaymentData['id'], $incomingPaymentData['mena'], $incomingPaymentData['storno'], $incomingPaymentData['banka']);

                $incomingPaymentData['sumCelkem'] = $amount;
                unset($incomingPaymentData['sumCelkemMen']);
                $incomingPaymentData['mena'] = $currency;
                $incomingPaymentData['datVyst'] = $incomingPaymentData['datVyst']->format('c');

                $listingTable->addRowColumns($incomingPaymentData);
            }

            $this->addItem($listingTable);

            $this->addItem($this->totalsTable(
                $bankaTotals,
                $invoicedRaw,
                $bankaCounts,
            ));
        }

        return !empty($outInvoicesData);
    }

    /**
     * @param type $bankaTotals
     * @param type $incomeRaw
     * @param type $bankaCounts
     *
     * @return \Ease\TWB5\Table
     */
    public function totalsTable($bankaTotals, $incomeRaw, $bankaCounts)
    {
        $tableHeader[] = _('Count');
        $tableHeader[] = _('Bank');
        $currencies = array_keys($incomeRaw);

        foreach ($currencies as $currencyCode) {
            $tableHeader[] = _('Total').' '.\AbraFlexi\RO::uncode($currencyCode);
        }

        $outInvoicesTable = new \Ease\TWB5\Table();
        $outInvoicesTable->addTagClass('table-sm');
        $outInvoicesTable->addRowHeaderColumns($tableHeader);

        foreach ($bankaTotals as $typDokl => $typDoklTotal) {
            $tableRow = [$bankaCounts[$typDokl]];
            $tableRow[] = \AbraFlexi\RO::uncode($typDokl);

            foreach ($currencies as $currencyCode) {
                $tableRow[] = \array_key_exists(
                    $currencyCode,
                    $bankaTotals[$typDokl],
                ) ? $bankaTotals[$typDokl][$currencyCode] : '';
            }

            $outInvoicesTable->addRowColumns($tableRow);
        }

        return $outInvoicesTable;
    }

    public function heading()
    {
        return _('Outcoming payments');
    }

    /**
     * Default Description.
     *
     * @return string
     */
    public function description()
    {
        return _('Payments we sent');
    }
}
