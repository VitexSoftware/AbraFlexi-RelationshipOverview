<?php

/**
 * AbraFlexi Custom Button Installer 
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 */

namespace AbraFlexi\Relationship;

use \Ease\TWB4\Row;
use \Ease\TWB4\WebPage;
use \Ease\TWB4\Container;
use \Ease\TWB4\Widgets\Toggle;
use \AbraFlexi\ui\TWB4\ConnectionForm;

ini_set('display_errors', 1);
error_reporting(E_ALL);
define('EASE_APPNAME', _('Relationship Overview'));

require_once dirname(__DIR__) . '/vendor/autoload.php';

$oPage = new WebPage(_('Button installer'));
$oPage->logger = new \Ease\Logger\ToMemory();

if (empty(\Ease\WebPage::getRequestValue('myurl'))) {
    $_REQUEST['myurl'] = dirname(\Ease\WebPage::phpSelf());
}

$loginForm = new ConnectionForm(['action' => 'install.php']);

$loginForm->addInput(new Toggle('browser',
                isset($_REQUEST) && array_key_exists('browser', $_REQUEST), 'automatic',
                ['data-on' => _('AbraFlexi WebView'), 'data-off' => _('System Browser')]),
        _('Open results in AbraFlexi WebView or in System default browser'));

//$loginForm->addInput( new \Ease\Html\InputUrlTag('myurl'), _('My Url'), dirname(\Ease\Page::phpSelf()), sprintf( _('Same url as you can see in browser without %s'), basename( __FILE__ ) ) );

$loginForm->fillUp($_REQUEST);

$loginForm->addItem(new \Ease\TWB4\SubmitButton(_('Install Button'), 'success btn-lg btn-block'));

$baseUrl = \Ease\WebPage::getRequestValue('myurl') . '/index.php?authSessionId=${authSessionId}&companyUrl=${companyUrl}';

if ($oPage->isPosted()) {
    $browser = isset($_REQUEST) && array_key_exists('browser', $_REQUEST) ? 'automatic' : 'desktop';

    $buttoner = new \AbraFlexi\RW(null,
            array_merge($_REQUEST, ['evidence' => 'custom-button']));

    $buttoner->logBanner(constant('EASE_APPNAME'));

    $buttoner->insertToAbraFlexi(['id' => 'code:RELATIONSHIP', 'url' => $baseUrl . '&kod=${object.kod}',
        'title' => _('Relationship Overview'), 'description' => _('Relationship Overview generator/sender'),
        'location' => 'list', 'evidence' => 'adresar', 'browser' => $browser]);
    if ($buttoner->lastResponseCode == 201) {
        $buttoner->addStatusMessage(_('Relationship Overview Button created'),
                'success');

        define('ABRAFLEXI_COMPANY', $buttoner->getCompany());
    }
} else {
    $oPage->addStatusMessage(_('My App URL') . ': ' . $baseUrl);
}



$setupRow = new Row();
$setupRow->addColumn(6, $loginForm);
$setupRow->addColumn(6, [Digestor::$logo, $oPage->getStatusMessagesBlock()]);

$oPage->addItem(new Container($setupRow));

echo $oPage;

