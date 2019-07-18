<?php
/**
 * FlexiBee Digest Engine
 *
 * @author     Vítězslav Dvořák <info@vitexsofware.cz>
 * @copyright  (G) 2018 Vitex Software
 */

namespace FlexiPeeHP\Relationship;

/**
 * Description of Digestor
 *
 * @author vitex
 */
class Digestor extends \Ease\Html\DivTag
{
    /**
     * Subject
     * @var string 
     */
    private $subject;

    /**
     * Index of included modules
     * @var array 
     */
    private $index = [];

    /**
     * Default Style
     * @var string 
     */
    static $mailcss = null;

    /**
     * App Logo
     * @var string 
     */
    static $logo = '<?xml version="1.0" encoding="UTF-8"?>
<svg width="48" height="48" version="1.1" viewBox="0 0 12.7 12.7" xmlns="http://www.w3.org/2000/svg" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#">
<metadata>
<rdf:RDF>
<cc:Work rdf:about="">
<dc:format>image/svg+xml</dc:format>
<dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage"/>
<dc:title/>
</cc:Work>
</rdf:RDF>
</metadata>
<g transform="translate(0,-284.3)">
<g transform="matrix(.015609 0 0 -.015609 -18.251 294.31)" clip-rule="evenodd" image-rendering="optimizeQuality" shape-rendering="geometricPrecision">
<path d="m1708.7 0 133.8 231.62 133.7-231.62z" fill="#f9ae2d"/>
<path d="m1708.7 0-133.75 231.62h267.53z" fill="#d28b25"/>
<path d="m1574.9 231.62 133.75 231.68 133.78-231.68z" fill="#936327"/>
<path d="m1708.7 463.3h-267.5l-267.6-463.3h267.56l267.47 463.3" fill="#767a7c"/>
</g>
</g>
<g transform="matrix(.013211 0 0 .013665 .73199 -8.5858)" fill="#ffd5d5">
<path d="m420.4 977.53-117.67 19.792-25.827 29.551-106.21 0.8334c-7.423 52.439-15.63 105.59-2.746 158.99l74.463-1.4047 11.752 0.1389-12.585 19.711c-1.252 7.0968 1.4009 9.4682 3.1505 12.933l30.878 14.992c14.883 8.3388 33.742 8.4899 51.777 10.336 2.2067 4.6161 4.2276 9.2234 8.3675 13.93l25.618-1.0485c5.094 11.214 12.29 15.436 18.466 23.054l52.538-5.7957 4.8557-7.2913c6.396 2.5767 14.315 1.6784 20.877 0.7342l-1.5771 0.023c14.57-0.162 23.132-9.6334 33.357-16.527 12.471 2.9662 11.884-1.2194 25.562-17.246l4.7982-5.1829c2.9661 0.8919 50.839-9.6359 50.839-9.6359l27.853-32.528 93.1-0.5763c11.922-46.281 7.16-95.522-2.4914-150.82l-94.79 0.7962-34.807-29.29c-33.835-4.4499-66.912-8.64-106.31-19.519l-12.06 8.8067-5.8441 2.3927-15.675-19.854"/>
<g transform="matrix(.99889 .047082 -.047082 .99889 -609.17 587.99)" stroke="#004582" stroke-linecap="round" stroke-linejoin="round">
<path d="m1158.3 586.18c3.0048 0.75117 50.329-12.019 50.329-12.019l26.291-33.803 92.97-4.959c9.7295-46.791 2.6547-95.753-9.5894-150.53l-94.648 5.2582-36.148-27.619c-34.007-2.8519-67.244-5.4801-107.11-14.492l-18.02 12.944m14.796 267.29c6.5102 2.2727 13.02 2.0032 19.53 0.75118m-166.37-55.96-16.53 27.79m151.74-33.052-33.427 48.826-33.427 5.6338m20.282-68.357-48.826 56.714m129.58-28.92c-8.0379 19.492-16.226 38.76-27.042 54.084l-52.207 8.2629c-6.5269-7.3196-13.914-11.197-19.53-22.16l-25.54 2.2535c-4.3569-4.507-6.5925-9.0141-9.0141-13.521-18.102-0.99539-36.947-0.25844-52.207-7.8873l-31.549-13.521c-1.9108-3.3782-4.6724-5.6221-3.7559-12.77l11.643-20.282m220.47-89.39 45.822 51.831 7.8873 57.84m-85.258-67.23c0.7512 1.8779 49.202 52.207 49.202 52.207l0.3756 48.451-0.3756-0.37559m-81.859-268.83-116.61 25.311-24.407 30.734-110.84 6.0588c-4.9458 52.731-9.043 106.14 6.3408 158.87l115.81-7.333 12.42 16.22c3.7567 4.542 8.4166 5.471 13.158 6.0736l51.215-41.743c10.945 4.6332 16.718 13.579 23.991 20.048 9.5735-8.3948 18.39-14.956 26.963-18.347 12.779 6.6352 16.586 12.373 22.754 18.347l-2.7118 12.655 11.593-6.1132 21.853 17.865-1.8079 48.814c14.546-0.84777 22.653-10.712 32.542-18.079 12.597 2.3758 22.346-16.793 35.254-33.446 13.543-9.3409 18.921-18.682 28.023-28.023l-0.904-70.508-80.98-63.5c-11.068 6.7097-21.863 18.439-33.822 19.804-4.4228 9.4905-6.8283 18.084-20.791 24.712-9.0247 8.6655-25.178 12.794-45.198 14.463l-24.407-20.791 36.158-34.35 8.1356-32.542 32.542-25.791-16.593-19.094" stroke-width="10.132"/>
<path d="m1039.2 434.45c-5.247 7.6032-9.6385 12.64-13.897 17.277-10.642 0.35483-21.283 2.1068-31.925-2.2535v0.37559m178.84 46.607c-5.1329 6.139-11.07 11.742-18.325 16.466m-6.905 32.932c-4.9302 6.3945-10.297 11.042-15.935 14.607m-31.073 21.246c4.4869 2.1404 29.005-20.149 26.824-21.512m-183.78 19.122c4.7784 6.7291 10.979 12.747 18.591 18.059m30.807-8.233c6.0101 6.4215 10.655 12.956 21.512 19.653m19.122 10.358c1.328 1.3279 14.076 11.951 14.076 11.951m25.23-54.709c-3.6917 4.7804-6.5657 9.5609-7.4363 14.341 4.3656 5.1953 9.4497 9.672 15.935 12.748m-39.04-52.85c-3.0462-0.24799-18.188 15.487-14.607 15.935 3.689 6.5994 9.3665 9.8848 15.138 13.013m-51.522-32.932c-6.1106 5.1346-12.984 10.269-14.341 15.404 3.6724 5.7572 9.069 8.066 14.076 11.154" stroke-width="5.7895"/>
</g>
</g>
</svg>';

    /**
     * Top menu 
     * @var \Ease\Html\DivTag 
     */
    public $topMenu;

    /**
     *
     * @var array 
     */
    public $defaultModuleConditions;

    /**
     * Digest Engine
     * 
     * @param string $subject
     */
    public function __construct($subject, \FlexiPeeHP\Adresar $customer)
    {
        parent::__construct();
        $this->defaultModuleConditions['firma']  = $customer->getRecordCode();
        $this->defaultModuleConditions['storno'] = false;
        $this->subject                           = $subject;
        $this->addHeading($subject);
        $this->shared                            = \Ease\Shared::instanced();
    }

    /**
     * Digest page Heading
     */
    public function addHeading($subject)
    {
        $this->addItem(new \Ease\Html\ATag('', '', ['name' => 'index']));
        $this->addItem(new \FlexiPeeHP\ui\CompanyLogo(['align' => 'right', 'id' => 'companylogo',
                'height' => '50', 'title' => _('Company logo')]));
        $this->addItem(new \Ease\Html\H1Tag($subject));
        $prober  = new \FlexiPeeHP\Company();
        $prober->logBanner(' FlexiBee Relationship Overview '.self::getAppVersion().' '.$_SERVER['SCRIPT_FILENAME']);
        $infoRaw = $prober->getFlexiData();
        if (count($infoRaw) && !array_key_exists('success', $infoRaw)) {
            $info      = self::reindexArrayBy($infoRaw, 'dbNazev');
            $myCompany = $prober->getCompany();
            if (array_key_exists($myCompany, $info)) {
                $return = new \Ease\Html\ATag($prober->url.'/c/'.$myCompany,
                    $info[$myCompany]['nazev']);
            } else {
                $return = new \Ease\Html\ATag($prober->getApiURL(),
                    _('Connection Problem'));
            }
        }

        $this->addItem(new \Ease\Html\StrongTag($return,
                ['class' => 'companylink']));
        $this->topMenu = $this->addItem(new \Ease\Html\NavTag(null,
                ['class' => 'nav']));
    }

    /**
     * Include all classes in modules directory
     * 
     * @param \DateInterval $interval
     */
    public function dig($interval, $moduleDir)
    {
        $this->processModules(self::getModules($moduleDir), $interval);

        $this->addIndex();
        $this->addFoot();

        $shared  = \Ease\Shared::instanced();
        $emailto = $shared->getConfigValue('EASE_MAILTO');
        if ($emailto) {
            $this->sendByMail($emailto);
        }
        $saveto = $shared->getConfigValue('SAVETO');
        if ($saveto) {
            $this->saveToHtml($saveto);
        }
    }

    /**
     * Process All modules in specified Dir
     * 
     * @param array $modules [classname=>filepath]
     * @param \DateTime|\DatePeriod $interval
     */
    public function processModules($modules, $interval)
    {
        foreach ($modules as $class => $classFile) {
            include_once $classFile;
            $module = new $class($interval, $this->defaultModuleConditions);
            $saveto = $this->shared->getConfigValue('SAVETO');
            if ($module->process()) {
                $this->addItem(new \Ease\Html\HrTag());
                $this->addToIndex($this->addItem($module));
                if ($saveto) {
                    $module->saveToHtml($saveto);
                }
            } else {
                $this->addStatusMessage(sprintf(_('Module %s do not found results'),
                        $class));
                if ($saveto) {
                    $module->fileCleanUP($saveto);
                }
            }
        }
    }

    /**
     * Process All modules in specified Dir
     * 
     * @param string $moduleDir path
     */
    public static function getModules($moduleDir)
    {
        $modules = [];
        if (is_array($moduleDir)) {
            foreach ($moduleDir as $module) {
                $modules = array_merge($modules, self::getModules($module));
            }
        } else {
            if (is_dir($moduleDir)) {
                $d     = dir($moduleDir);
                while (false !== ($entry = $d->read())) {
                    if (is_file($moduleDir.'/'.$entry)) {
                        $class           = pathinfo($entry, PATHINFO_FILENAME);
                        $modules[$class] = realpath($moduleDir.'/'.$entry);
                    }
                }
                $d->close();
            } else {
                if (is_file($moduleDir)) {
                    $class           = pathinfo($moduleDir, PATHINFO_FILENAME);
                    $modules[$class] = realpath($moduleDir);
                } else {
                    \Ease\Shared::instanced()->addStatusMessage(sprintf(_('Module dir %s is wrong'),
                            $moduleDir), 'error');
                }
            }
        }
        return $modules;
    }

    /**
     * Add Element to Index
     * 
     * @param DigestModule $element
     */
    public function addToIndex($element)
    {
        $this->index[get_class($element)] = $element->heading();
    }

    /**
     * Add Index to digest
     */
    public function addIndex()
    {
        $this->addItem(new \Ease\Html\H1Tag(new \Ease\Html\ATag('', _('Index'),
                    ['name' => 'index2'])));
        $this->addItem(new \Ease\Html\HrTag());

        $index = new \Ease\Html\UlTag(null, ['class' => 'nav']);

        foreach ($this->index as $class => $heading) {
            $index->addItemSmart(new \Ease\Html\ATag('#'.$class, $heading,
                    ['class' => 'nav-link']),
                ['class' => 'nav-item']);

            $this->topMenu->addItem(new \Ease\Html\ATag('#'.$class, $heading,
                    ['class' => 'nav-link']));
        }

        $this->addItem(new \Ease\Html\UlTag($index,
                ['class' => 'nav']));
    }
//    /**
//     * Include next element into current page (if not closed).
//     *
//     * @param mixed  $pageItem     value or EaseClass with draw() method
//     * @param string $pageItemName Custom 'storing' name
//     *
//     * @return mixed Pointer to included object
//     */
//    public function addItem($pageItem, $pageItemName = null)
//    {
//        return parent::addItem($pageItem, $pageItemName);
//    }

    /**
     * Sent digest by mail 
     * 
     * @param string $mailto
     */
    public function sendByMail($mailto)
    {
        $postman = new Mailer($mailto, $this->subject);
        $postman->addItem($this);
        $postman->send();
    }

    /**
     * Save HTML digest
     * 
     * @param string $saveTo directory
     */
    public function saveToHtml($saveTo)
    {
        $filename = $saveTo.pathinfo($_SERVER['SCRIPT_FILENAME'],
                PATHINFO_FILENAME).'.html';
        $webPage  = new \Ease\Html\HtmlTag(new \Ease\Html\SimpleHeadTag([
                new \Ease\Html\TitleTag($this->subject),
                '<style>'.Digestor::$mailcss.Digestor::getCustomCss().Digestor::getWebPageInlineCSS().'</style>']));
        $webPage->addItem(new \Ease\Html\BodyTag($this));
        $this->addStatusMessage(sprintf(_('Saved to %s'), $filename),
            file_put_contents($filename, $webPage->getRendered()) ? 'success' : 'error');
    }

    static public function getWebPageInlineCSS()
    {
//        $easeShared = \Ease\Shared::webPage();
//        if (isset($easeShared->cascadeStyles) && count($easeShared->cascadeStyles)) {
//            $cascadeStyles = [];
//            foreach ($easeShared->cascadeStyles as $StyleRes => $Style) {
//                if ($StyleRes != $Style) {
//                    $cascadeStyles[] = $Style;
//                }
//            }
//        }
//        return implode('', $cascadeStyles);
//        return VerticalChart::$chartCss;
    }

    /**
     * Obtain Custom CSS - THEME in digest.json
     * 
     * @return string
     */
    public static function getCustomCss()
    {

//        $theme   = \Ease\Shared::instanced()->getConfigValue('THEME');
//        $cssfile = constant('STYLE_DIR').'/'.$theme.'.css';
//        return file_exists($cssfile) ? file_get_contents($cssfile) : '';
    }

    /**
     * Obtain Version of application
     * 
     * @return string
     */
    static public function getAppVersion()
    {
        $composerInfo = json_decode(file_get_contents('../composer.json'), true);
        return array_key_exists('version', $composerInfo) ? $composerInfo['version']
                : 'dev-master';
    }

    /**
     * Page Bottom
     */
    public function addFoot()
    {
        $this->addItem(new \Ease\Html\HrTag());
        $this->addItem(new \Ease\Html\ImgTag('data:image/svg+xml;base64,'.base64_encode(self::$logo),
                'Logo', ['align' => 'right', 'width' => '50']));
        $this->addItem(new \Ease\Html\SmallTag(new \Ease\Html\DivTag([_('Generated by'),
                    '&nbsp;', new \Ease\Html\ATag('https://github.com/VitexSoftware/FlexiBee-RelationshipOverview',
                        _('FlexiBee Relationship Overview').' '._('version').' '.self::getAppVersion())])));

        $this->addItem(new \Ease\Html\SmallTag(new \Ease\Html\DivTag([_('(G) 2019'),
                    '&nbsp;', new \Ease\Html\ATag('https://www.vitexsoftware.cz/',
                        'Vitex Software')])));
    }
}
