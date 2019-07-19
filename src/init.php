<?php
/**
 * FlexiBee Button installer page
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright (c) 2019, Vitex Software
 */

namespace FlexiPeeHP\Relationship;

use \Ease\TWB4\WebPage;

require_once dirname(__DIR__).'/vendor/autoload.php';

define('EASE_LOGGER', 'memory');
define('MODULE_PATH', './modules');

session_start();

\Ease\Shared::locale(new \Ease\Locale(null, '../i18n', 'flexibee-relationship'));

$oPage         = new WebPage();
$oPage->logger = new \Ease\Logger\ToMemory();

$authSessionId = $oPage->getRequestValue('authSessionId');
$companyUrl    = $oPage->getRequestValue('companyUrl');



if ($authSessionId && $companyUrl) {
    $_SESSION['connection']                  = \FlexiPeeHP\FlexiBeeRO::companyUrlToOptions($companyUrl);
    $_SESSION['connection']['authSessionId'] = $authSessionId;
}

if (array_key_exists('connection', $_SESSION)) {
    define('FLEXIBEE_URL', $_SESSION['connection']['url']);
    define('FLEXIBEE_AUTHSESSID', $_SESSION['connection']['authSessionId']);
    define('FLEXIBEE_COMPANY', $_SESSION['connection']['company']);
} else {
    $localCfg = '../testing/client.json';
    if (file_exists($localCfg)) {
        $shared = \Ease\Shared::instanced();
        $shared->loadConfig($localCfg, true);
    } else {
        if (\Ease\WebPage::getRequestValue('kod')) {
            $oPage->addItem(new \Ease\TWB4\LinkButton('JavaScript:self.close()',
                    _('Session Expired'), 'danger'));
        } else {
            $oPage->redirect('install.php');
        }
        echo $oPage->draw();
        exit();
    }
}

