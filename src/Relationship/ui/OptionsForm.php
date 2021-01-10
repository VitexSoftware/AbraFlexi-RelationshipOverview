<?php

/**
 * AbraFlexi Relationship
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright (c) 2019, Vitex Software
 */

namespace AbraFlexi\Relationship\ui;

use AbraFlexi\Adresar;
use AbraFlexi\Relationship\Digestor;
use DateTime;
use Ease\Html\H2Tag;
use Ease\Html\H3Tag;
use Ease\Html\InputDateTag;
use Ease\Html\InputEmailTag;
use Ease\Html\InputHiddenTag;
use Ease\TWB4\Container;
use Ease\TWB4\Form;
use Ease\TWB4\FormGroup;
use Ease\TWB4\LinkButton;
use Ease\TWB4\Row;
use Ease\TWB4\SubmitButton;
use Ease\TWB4\Widgets\Toggle;
use Ease\WebPage;

/**
 * Description of OptionsForm
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 */
class OptionsForm extends Form {

    public function __construct(Adresar $customer,
            $tagProperties = array()) {
        $from = WebPage::getRequestValue('from');
        $to = WebPage::getRequestValue('to');

        $start = new DateTime();
        if (empty($from)) {
            $start->modify('-1 month');
            $from = $start->format('Y-m-d');
        } else {
            list($year, $month, $day) = explode('-', $from);
            $start->setDate($year, $month, $day);
        }

        $end = new DateTime();
        if (empty($to)) {
            $to = date('Y-m-d');
        } else {
            list($year, $month, $day) = explode('-', $to);
            $end->setDate($year, $month, $day);
        }

        parent::__construct( [ 'name'=>'fromto'], $tagProperties);

        $this->addTagClass('form-horizontal');

        //new \Ease\Html\H1Tag(new \Ease\Html\ATag($myCompany->getApiURL(),$myCompanyName).' '._('AbraFlexi digest'))

        $container = new Container();

        $formColumns = new Row();
        $modulesCol = $formColumns->addColumn(6,
                new H2Tag(_('Modules')));

        $candidates[_('Common modules')] = Digestor::getModules(constant('MODULE_PATH'));

        foreach ($candidates as $heading => $modules) {
            $modulesCol->addItem(new H3Tag($heading));
            asort($modules);
            foreach ($modules as $className => $classFile) {
                include_once $classFile;
                $module = new $className(null);
                $modulesCol->addItem([new Toggle('modules[' . $className . ']',
                            true, $classFile), '&nbsp;' . $module->heading() . '<br>']);
            }
        }

        $optionsCol = $formColumns->addColumn(6,
                new H2Tag(_('Options')));

        $this->addJavaScript('
    
var od = $( "input[name=\'from\']" );

$( "#yesterday" ).click(function() {
    var today = new Date();
    today.setDate(today.getDate() - 1);
    od.val( today.toISOString().split(\'T\')[0] );
});

$( "#lastweek" ).click(function() {
    var today = new Date();
    today.setDate(today.getDate() - 7);
    od.val( today.toISOString().split(\'T\')[0] );
});

$( "#lastmonth" ).click(function() {
    var today = new Date();
    today.setMonth(today.getMonth() - 1);
    od.val( today.toISOString().split(\'T\')[0] );
});

$( "#lastyear" ).click(function() {
    var today = new Date();
    today.setFullYear(today.getFullYear() - 1);
    od.val( today.toISOString().split(\'T\')[0] );
});

');

        $optionsCol->addItem(new LinkButton('#', _('Yesterday'), 'inverse',
                        ['id' => 'yesterday']));
        $optionsCol->addItem(new LinkButton('#', _('Week'), 'inverse',
                        ['id' => 'lastweek']));
        $optionsCol->addItem(new LinkButton('#', _('Month'), 'inverse',
                        ['id' => 'lastmonth']));
        $optionsCol->addItem(new LinkButton('#', _('Year'), 'inverse',
                        ['id' => 'lastyear']));

        $optionsCol->addItem(new FormGroup(_('From'),
                        new InputDateTag('from', $from)));

        $optionsCol->addItem(new FormGroup(_('To'),
                        new InputDateTag('to', $to)));

        $optionsCol->addItem(new FormGroup(_('Send by mail to'),
                        new InputEmailTag('recipient',
                                $customer->getNotificationEmailAddress())));

        $this->addItem(new InputHiddenTag('kod', $customer->getDataValue('kod')));

        $this->addItem($formColumns);
        $this->addItem(new SubmitButton(sprintf(_('Generate digest for %s '),
                                $customer->getDataValue('kod') . ': ' . $customer->getDataValue('nazev')),
                        'success btn-lg btn-block',
                        ['onClick' => "window.scrollTo(0, 0); $('#Preloader').css('visibility', 'visible');",
                    'style' => 'height: 90%']));
    }

}
