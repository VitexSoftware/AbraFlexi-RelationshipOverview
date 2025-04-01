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

/**
 * Description of DigestMod.
 *
 * @author vitex
 */
class DigestModule extends \Ease\Html\DivTag implements DigestModuleInterface
{
    /**
     * Which records we want to see ?
     *
     * @param array $condition
     */
    public $condition = [];

    /**
     * AbraFlexi Evidence Column(s) used to filter by date.
     */
    public string $timeColumn = '';

    /**
     * Initial date to process.
     */
    public ?\DatePeriod $timeInterval = null; // Updated to use DatePeriod

    /**
     * Prepare condition, add header with anchors.
     *
     * @param \DatePeriod $interval
     * @param array       $conditons Default conditions
     */
    public function __construct($interval, $conditons = [])
    {
        if (!empty($interval) && $this->timeColumn) {
            if (\is_array($this->timeColumn)) {
                $condParts = [];

                foreach ($this->timeColumn as $timeColumn) {
                    $condParts[$timeColumn] = $interval;
                }

                $this->condition = array_merge($conditons, [\AbraFlexi\Functions::flexiUrl(
                    $condParts,
                    ' or ',
                )]);
            } else {
                $this->condition = array_merge($conditons, [$this->timeColumn => $interval]);
            }
        }

        $this->timeInterval = $interval; // Assign DatePeriod
        parent::__construct();
        $this->setTagID(\get_class($this));
    }

    /**
     * Proccess data digging.
     *
     * @return bool
     */
    public function process()
    {
        $this->addItem(new \Ease\Html\H2Tag(new \Ease\Html\ATag(
            '#index',
            $this->heading(),
            ['name' => \get_class($this)],
        )));
        $this->addStatusMessage($this->heading());
        $this->addItem(new \Ease\Html\SmallTag($this->description()));

        return $this->dig();
    }

    /**
     * Obtaining informations.
     */
    public function dig()
    {
        $this->addItem(new \Ease\Html\ATag(
            'https://www.vitexsoftware.cz/cenik.php',
            _('Please contact Vitex Software to make this module working.'),
        ));

        return true;
    }

    /**
     * Default Heading.
     *
     * @return string
     */
    public function heading()
    {
        return _('No heading set');
    }

    /**
     * Default Description.
     *
     * @return string
     */
    public function description()
    {
        return _('Not described');
    }

    /**
     * Get Currency name.
     *
     * @param array $data
     *
     * @return string
     */
    public static function getCurrency($data)
    {
        return \array_key_exists('mena', $data) ? current(explode(
            ':',
            $data['mena']->showAs,
        )) : (string) ($data['mena']);
    }

    /**
     * Format Czech Currency.
     *
     * @param float $price
     *
     * @return string
     */
    public static function formatCurrency($price)
    {
        return number_format($price, 2, ',', ' ');
    }

    /**
     * @return float
     */
    public static function getPrice(array $record)
    {
        return self::formatCurrency(self::getAmount($record)).' '.self::getCurrency($record);
    }

    /**
     * @return string
     */
    public static function getAmount(array $record)
    {
        if (self::getCurrency($record) === 'CZK') {
            $amount = (float) $record['sumCelkem'];
        } else {
            $amount = (float) $record['sumCelkemMen'];
        }

        return $amount;
    }

    /**
     * AbraFlexi date in human readable form.
     *
     * @param string $flexiDate
     *
     * @return string
     */
    public static function humanDate($flexiDate)
    {
        return \AbraFlexi\RW::flexiDateToDateTime($flexiDate)->format('d. m. Y');
    }

    /**
     * Is Date between dates.
     *
     * @param DateTime $date      Date that is to be checked if it falls between $startDate and $endDate
     * @param DateTime $startDate Date should be after this date to return true
     * @param DateTime $endDate   Date should be before this date to return true
     *
     * return bool
     */
    public static function isDateBetweenDates(
        \DateTime $date,
        \DateTime $startDate,
        \DateTime $endDate,
    ) {
        return $date > $startDate && $date < $endDate;
    }

    /**
     * Is date within date interval.
     *
     * @return bool
     */
    public static function isDateWithinInterval(\DateTime $date, \DatePeriod $interval)
    {
        return $date >= $interval->getStartDate() && $date <= $interval->getEndDate();
    }

    /**
     * Is date subject of digest?
     *
     * @return bool
     */
    public function isMyDate(\DateTime $date)
    {
        if ($this->timeInterval instanceof \DatePeriod) {
            return self::isDateWithinInterval($date, $this->timeInterval);
        }

        return false;
    }

    /**
     * Return Totals for serveral currencies.
     *
     * @param array $totals [currency=>amount,currency2=>amount2]
     *
     * @return \Ease\Html\DivTag
     */
    public static function getTotalsDiv(array $totals)
    {
        $total = new \Ease\Html\DivTag();

        foreach ($totals as $currency => $amount) {
            $total->addItem(new \Ease\Html\DivTag(self::formatCurrency($amount).'&nbsp;'.\AbraFlexi\RO::uncode($currency)));
        }

        return $total;
    }

    /**
     * Save HTML digest fragment.
     *
     * @param string $saveTo directory
     */
    public function saveToHtml($saveTo): void
    {
        $filename = $saveTo.$this->getReportFilename();
        $this->addStatusMessage(
            sprintf(
                _('Module output Saved to %s'),
                $filename,
            ),
            file_put_contents($filename, $this->getRendered()) ? 'success' : 'error',
        );
    }

    /**
     * Remove reportfile.
     *
     * @param string $saveTo
     */
    public function fileCleanUP($saveTo): void
    {
        $filename = $saveTo.$this->getReportFilename();

        if (file_exists($filename)) {
            $this->addStatusMessage(sprintf(
                _('Module output %s wiped out'),
                $filename,
            ), unlink($filename) ? 'success' : 'error');
        }
    }

    public function getReportFilename()
    {
        return pathinfo($_SERVER['SCRIPT_FILENAME'], \PATHINFO_FILENAME).'_'.pathinfo(
            \get_class($this),
            \PATHINFO_FILENAME,
        ).'.html';
    }

    /**
     * Print progress log.
     */
    public function finalize(): void
    {
        $this->addStatusMessage($this->heading(), 'debug');
        parent::finalize();
    }
}
