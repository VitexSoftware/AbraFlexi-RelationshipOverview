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
 * AbraFlexi Digest Mailer.
 *
 * @author     Vítězslav Dvořák <info@vitexsofware.cz>
 * @copyright  (G) 2017 Vitex Software
 */
class Mailer extends \Ease\HtmlMailer
{
    /**
     * @param mixed  $sendTo
     * @param string $subject
     */
    public function __construct($sendTo, $subject)
    {
        $shared = \Ease\Shared::instanced();
        $this->fromEmailAddress = $shared->getConfigValue('DIGEST_FROM') ?? 'default@example.com'; // Provide a default email address
        parent::__construct($sendTo, $subject);

        $this->htmlDocument = new \Ease\Html\HtmlTag(new \Ease\Html\SimpleHeadTag([
            new \Ease\Html\TitleTag($this->emailSubject),
            '<style>'.file_get_contents('css/bootstrap.min.css').
            Digestor::getCustomCss().
            Digestor::getWebPageInlineCSS().
            '</style>']));
        $this->htmlBody = $this->htmlDocument->addItem(new \Ease\Html\BodyTag());
    }

    /**
     * Přidá položku do těla mailu.
     *
     * @param mixed      $item         EaseObjekt nebo cokoliv s metodou draw();
     * @param null|mixed $pageItemName
     *
     * @return null|Ease\pointer ukazatel na vložený obsah
     */
    public function &addItem($item, $pageItemName = null)
    {
        $mailBody = '';

        if (\is_object($item)) {
            if (\is_object($this->htmlDocument)) {
                if (null === $this->htmlBody) {
                    $this->htmlBody = new \Ease\Html\BodyTag();
                }

                $mailBody = $this->htmlBody->addItem($item, $pageItemName);
            } else {
                $mailBody = $this->htmlDocument;
            }
        } else {
            $this->textBody .= \is_array($item) ? implode("\n", $item) : $item;
            $this->mimer->setTXTBody($this->textBody);
        }

        return $mailBody;
    }

    public function getCss(): void
    {
    }
}
