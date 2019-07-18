<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace FlexiPeeHP\Relationship\ui;

use \Ease\TWB4\LinkButton;
use \Ease\TWB4\FormGroup;
use \Ease\TWB4\SubmitButton;
use \Ease\TWB4\Widgets\Toggle;

/**
 * Description of OptionsForm
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 */
class OptionsForm extends \Ease\TWB4\Form
{

    public function __construct(\FlexiPeeHP\Adresar $customer,
                                $tagProperties = array())
    {
        $from = \Ease\WebPage::getRequestValue('from');
        $to   = \Ease\WebPage::getRequestValue('to');

        $start = new \DateTime();
        if (empty($from)) {
            $start->modify('-1 month');
            $from = $start->format('Y-m-d');
        } else {
            list($year, $month, $day) = explode('-', $from);
            $start->setDate($year, $month, $day);
        }

        $end = new \DateTime();
        if (empty($to)) {
            $to = date('Y-m-d');
        } else {
            list($year, $month, $day) = explode('-', $to);
            $end->setDate($year, $month, $day);
        }

        parent::__construct('fromto', 'index.php', 'POST', null, $tagProperties);

        $this->addTagClass('form-horizontal');

        //new \Ease\Html\H1Tag(new \Ease\Html\ATag($myCompany->getApiURL(),$myCompanyName).' '._('FlexiBee digest'))

        $container = new \Ease\TWB4\Container();

        $formColumns = new \Ease\TWB4\Row();
        $modulesCol  = $formColumns->addColumn(6,
            new \Ease\Html\H2Tag(_('Modules')));

        $candidates[_('Common modules')] = \FlexiPeeHP\Relationship\Digestor::getModules(constant('MODULE_PATH'));

        foreach ($candidates as $heading => $modules) {
            $modulesCol->addItem(new \Ease\Html\H3Tag($heading));
            asort($modules);
            foreach ($modules as $className => $classFile) {
                include_once $classFile;
                $module = new $className(null);
                $modulesCol->addItem([new Toggle('modules['.$className.']',
                        true, $classFile), '&nbsp;'.$module->heading().'<br>']);
            }
        }

        $optionsCol = $formColumns->addColumn(6,
            new \Ease\Html\H2Tag(_('Options')));


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
                new \Ease\Html\InputDateTag('from', $from)));

        $optionsCol->addItem(new FormGroup(_('To'),
                new \Ease\Html\InputDateTag('to', $to)));

        $optionsCol->addItem(new FormGroup(_('Send by mail to'),
                new \Ease\Html\InputEmailTag('recipient',
                    $customer->getNotificationEmailAddress())));

        $this->addItem(new \Ease\Html\InputHiddenTag('kod', $customer->getDataValue('kod')));

        $this->addItem($formColumns);
        $this->addItem(new SubmitButton(sprintf(_('Generate digest for %s '),
                    $customer->getDataValue('kod').': '.$customer->getDataValue('nazev')),
                'success btn-lg btn-block',
                ['onClick' => "window.scrollTo(0, 0); $('#Preloader').css('visibility', 'visible');",
                'style' => 'height: 90%']));
    }
}
