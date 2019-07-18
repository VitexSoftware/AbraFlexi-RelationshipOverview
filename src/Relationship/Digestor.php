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
    static $purecss = '/*!
Pure v1.0.0
Copyright 2013 Yahoo!
Licensed under the BSD License.
https://github.com/yahoo/pure/blob/master/LICENSE.md
normalize.css v^3.0 | MIT License | git.io/normalize
Copyright (c) Nicolas Gallagher and Jonathan Neal
normalize.css v3.0.3 | MIT License | github.com/necolas/normalize.css */.pure-button:focus,a:active,a:hover{outline:0}.pure-table,table{border-collapse:collapse;border-spacing:0}html{font-family:sans-serif;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}body{margin:0}article,aside,details,figcaption,figure,footer,header,hgroup,main,menu,nav,section,summary{display:block}audio,canvas,progress,video{display:inline-block;vertical-align:baseline}audio:not([controls]){display:none;height:0}[hidden],template{display:none}a{background-color:transparent}abbr[title]{border-bottom:1px dotted}b,optgroup,strong{font-weight:700}dfn{font-style:italic}h1{font-size:2em;margin:.67em 0}mark{background:#ff0;color:#000}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sup{top:-.5em}sub{bottom:-.25em}img{border:0}svg:not(:root){overflow:hidden}figure{margin:1em 40px}hr{box-sizing:content-box;height:0}pre,textarea{overflow:auto}code,kbd,pre,samp{font-family:monospace,monospace;font-size:1em}button,input,optgroup,select,textarea{color:inherit;font:inherit;margin:0}.pure-button,input{line-height:normal}button{overflow:visible}button,select{text-transform:none}button,html input[type=button],input[type=reset],input[type=submit]{-webkit-appearance:button;cursor:pointer}button[disabled],html input[disabled]{cursor:default}button::-moz-focus-inner,input::-moz-focus-inner{border:0;padding:0}input[type=checkbox],input[type=radio]{box-sizing:border-box;padding:0}input[type=number]::-webkit-inner-spin-button,input[type=number]::-webkit-outer-spin-button{height:auto}input[type=search]{-webkit-appearance:textfield;box-sizing:content-box}.pure-button,.pure-form input:not([type]),.pure-menu{box-sizing:border-box}input[type=search]::-webkit-search-cancel-button,input[type=search]::-webkit-search-decoration{-webkit-appearance:none}fieldset{border:1px solid silver;margin:0 2px;padding:.35em .625em .75em}legend,td,th{padding:0}legend{border:0}.hidden,[hidden]{display:none!important}.pure-img{max-width:100%;height:auto;display:block}.pure-g{letter-spacing:-.31em;text-rendering:optimizespeed;font-family:FreeSans,Arimo,"Droid Sans",Helvetica,Arial,sans-serif;display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-flex-flow:row wrap;-ms-flex-flow:row wrap;flex-flow:row wrap;-webkit-align-content:flex-start;-ms-flex-line-pack:start;align-content:flex-start}@media all and (-ms-high-contrast:none),(-ms-high-contrast:active){table .pure-g{display:block}}.opera-only :-o-prefocus,.pure-g{word-spacing:-.43em}.pure-u,.pure-u-1,.pure-u-1-1,.pure-u-1-12,.pure-u-1-2,.pure-u-1-24,.pure-u-1-3,.pure-u-1-4,.pure-u-1-5,.pure-u-1-6,.pure-u-1-8,.pure-u-10-24,.pure-u-11-12,.pure-u-11-24,.pure-u-12-24,.pure-u-13-24,.pure-u-14-24,.pure-u-15-24,.pure-u-16-24,.pure-u-17-24,.pure-u-18-24,.pure-u-19-24,.pure-u-2-24,.pure-u-2-3,.pure-u-2-5,.pure-u-20-24,.pure-u-21-24,.pure-u-22-24,.pure-u-23-24,.pure-u-24-24,.pure-u-3-24,.pure-u-3-4,.pure-u-3-5,.pure-u-3-8,.pure-u-4-24,.pure-u-4-5,.pure-u-5-12,.pure-u-5-24,.pure-u-5-5,.pure-u-5-6,.pure-u-5-8,.pure-u-6-24,.pure-u-7-12,.pure-u-7-24,.pure-u-7-8,.pure-u-8-24,.pure-u-9-24{letter-spacing:normal;word-spacing:normal;vertical-align:top;text-rendering:auto;display:inline-block;zoom:1}.pure-g [class*=pure-u]{font-family:sans-serif}.pure-u-1-24{width:4.1667%}.pure-u-1-12,.pure-u-2-24{width:8.3333%}.pure-u-1-8,.pure-u-3-24{width:12.5%}.pure-u-1-6,.pure-u-4-24{width:16.6667%}.pure-u-1-5{width:20%}.pure-u-5-24{width:20.8333%}.pure-u-1-4,.pure-u-6-24{width:25%}.pure-u-7-24{width:29.1667%}.pure-u-1-3,.pure-u-8-24{width:33.3333%}.pure-u-3-8,.pure-u-9-24{width:37.5%}.pure-u-2-5{width:40%}.pure-u-10-24,.pure-u-5-12{width:41.6667%}.pure-u-11-24{width:45.8333%}.pure-u-1-2,.pure-u-12-24{width:50%}.pure-u-13-24{width:54.1667%}.pure-u-14-24,.pure-u-7-12{width:58.3333%}.pure-u-3-5{width:60%}.pure-u-15-24,.pure-u-5-8{width:62.5%}.pure-u-16-24,.pure-u-2-3{width:66.6667%}.pure-u-17-24{width:70.8333%}.pure-u-18-24,.pure-u-3-4{width:75%}.pure-u-19-24{width:79.1667%}.pure-u-4-5{width:80%}.pure-u-20-24,.pure-u-5-6{width:83.3333%}.pure-u-21-24,.pure-u-7-8{width:87.5%}.pure-u-11-12,.pure-u-22-24{width:91.6667%}.pure-u-23-24{width:95.8333%}.pure-u-1,.pure-u-1-1,.pure-u-24-24,.pure-u-5-5{width:100%}.pure-button{display:inline-block;zoom:1;white-space:nowrap;vertical-align:middle;text-align:center;cursor:pointer;-webkit-user-drag:none;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}.pure-button::-moz-focus-inner{padding:0;border:0}.pure-button-group{letter-spacing:-.31em;text-rendering:optimizespeed}.opera-only :-o-prefocus,.pure-button-group{word-spacing:-.43em}.pure-button{font-family:inherit;font-size:100%;padding:.5em 1em;color:#444;color:rgba(0,0,0,.8);border:1px solid #999;border:transparent;background-color:#E6E6E6;text-decoration:none;border-radius:2px}.pure-button-hover,.pure-button:focus,.pure-button:hover{filter:alpha(opacity=90);background-image:-webkit-linear-gradient(transparent,rgba(0,0,0,.05) 40%,rgba(0,0,0,.1));background-image:linear-gradient(transparent,rgba(0,0,0,.05) 40%,rgba(0,0,0,.1))}.pure-button-active,.pure-button:active{box-shadow:0 0 0 1px rgba(0,0,0,.15) inset,0 0 6px rgba(0,0,0,.2) inset;border-color:#000\9}.pure-button-disabled,.pure-button-disabled:active,.pure-button-disabled:focus,.pure-button-disabled:hover,.pure-button[disabled]{border:none;background-image:none;filter:alpha(opacity=40);opacity:.4;cursor:not-allowed;box-shadow:none;pointer-events:none}.pure-button-hidden{display:none}.pure-button-primary,.pure-button-selected,a.pure-button-primary,a.pure-button-selected{background-color:#0078e7;color:#fff}.pure-button-group .pure-button{letter-spacing:normal;word-spacing:normal;vertical-align:top;text-rendering:auto;margin:0;border-radius:0;border-right:1px solid #111;border-right:1px solid rgba(0,0,0,.2)}.pure-button-group .pure-button:first-child{border-top-left-radius:2px;border-bottom-left-radius:2px}.pure-button-group .pure-button:last-child{border-top-right-radius:2px;border-bottom-right-radius:2px;border-right:none}.pure-form input[type=password],.pure-form input[type=email],.pure-form input[type=url],.pure-form input[type=date],.pure-form input[type=month],.pure-form input[type=time],.pure-form input[type=datetime],.pure-form input[type=datetime-local],.pure-form input[type=week],.pure-form input[type=tel],.pure-form input[type=color],.pure-form input[type=number],.pure-form input[type=search],.pure-form input[type=text],.pure-form select,.pure-form textarea{padding:.5em .6em;display:inline-block;border:1px solid #ccc;box-shadow:inset 0 1px 3px #ddd;border-radius:4px;vertical-align:middle;box-sizing:border-box}.pure-form input:not([type]){padding:.5em .6em;display:inline-block;border:1px solid #ccc;box-shadow:inset 0 1px 3px #ddd;border-radius:4px}.pure-form input[type=color]{padding:.2em .5em}.pure-form input:not([type]):focus,.pure-form input[type=password]:focus,.pure-form input[type=email]:focus,.pure-form input[type=url]:focus,.pure-form input[type=date]:focus,.pure-form input[type=month]:focus,.pure-form input[type=time]:focus,.pure-form input[type=datetime]:focus,.pure-form input[type=datetime-local]:focus,.pure-form input[type=week]:focus,.pure-form input[type=tel]:focus,.pure-form input[type=color]:focus,.pure-form input[type=number]:focus,.pure-form input[type=search]:focus,.pure-form input[type=text]:focus,.pure-form select:focus,.pure-form textarea:focus{outline:0;border-color:#129FEA}.pure-form input[type=file]:focus,.pure-form input[type=checkbox]:focus,.pure-form input[type=radio]:focus{outline:#129FEA auto 1px}.pure-form .pure-checkbox,.pure-form .pure-radio{margin:.5em 0;display:block}.pure-form input:not([type])[disabled],.pure-form input[type=password][disabled],.pure-form input[type=email][disabled],.pure-form input[type=url][disabled],.pure-form input[type=date][disabled],.pure-form input[type=month][disabled],.pure-form input[type=time][disabled],.pure-form input[type=datetime][disabled],.pure-form input[type=datetime-local][disabled],.pure-form input[type=week][disabled],.pure-form input[type=tel][disabled],.pure-form input[type=color][disabled],.pure-form input[type=number][disabled],.pure-form input[type=search][disabled],.pure-form input[type=text][disabled],.pure-form select[disabled],.pure-form textarea[disabled]{cursor:not-allowed;background-color:#eaeded;color:#cad2d3}.pure-form input[readonly],.pure-form select[readonly],.pure-form textarea[readonly]{background-color:#eee;color:#777;border-color:#ccc}.pure-form input:focus:invalid,.pure-form select:focus:invalid,.pure-form textarea:focus:invalid{color:#b94a48;border-color:#e9322d}.pure-form input[type=file]:focus:invalid:focus,.pure-form input[type=checkbox]:focus:invalid:focus,.pure-form input[type=radio]:focus:invalid:focus{outline-color:#e9322d}.pure-form select{height:2.25em;border:1px solid #ccc;background-color:#fff}.pure-form select[multiple]{height:auto}.pure-form label{margin:.5em 0 .2em}.pure-form fieldset{margin:0;padding:.35em 0 .75em;border:0}.pure-form legend{display:block;width:100%;padding:.3em 0;margin-bottom:.3em;color:#333;border-bottom:1px solid #e5e5e5}.pure-form-stacked input:not([type]),.pure-form-stacked input[type=password],.pure-form-stacked input[type=email],.pure-form-stacked input[type=url],.pure-form-stacked input[type=date],.pure-form-stacked input[type=month],.pure-form-stacked input[type=time],.pure-form-stacked input[type=datetime],.pure-form-stacked input[type=datetime-local],.pure-form-stacked input[type=week],.pure-form-stacked input[type=tel],.pure-form-stacked input[type=color],.pure-form-stacked input[type=file],.pure-form-stacked input[type=number],.pure-form-stacked input[type=search],.pure-form-stacked input[type=text],.pure-form-stacked label,.pure-form-stacked select,.pure-form-stacked textarea{display:block;margin:.25em 0}.pure-form-aligned .pure-help-inline,.pure-form-aligned input,.pure-form-aligned select,.pure-form-aligned textarea,.pure-form-message-inline{display:inline-block;vertical-align:middle}.pure-form-aligned textarea{vertical-align:top}.pure-form-aligned .pure-control-group{margin-bottom:.5em}.pure-form-aligned .pure-control-group label{text-align:right;display:inline-block;vertical-align:middle;width:10em;margin:0 1em 0 0}.pure-form-aligned .pure-controls{margin:1.5em 0 0 11em}.pure-form .pure-input-rounded,.pure-form input.pure-input-rounded{border-radius:2em;padding:.5em 1em}.pure-form .pure-group fieldset{margin-bottom:10px}.pure-form .pure-group input,.pure-form .pure-group textarea{display:block;padding:10px;margin:0 0 -1px;border-radius:0;position:relative;top:-1px}.pure-form .pure-group input:focus,.pure-form .pure-group textarea:focus{z-index:3}.pure-form .pure-group input:first-child,.pure-form .pure-group textarea:first-child{top:1px;border-radius:4px 4px 0 0;margin:0}.pure-form .pure-group input:first-child:last-child,.pure-form .pure-group textarea:first-child:last-child{top:1px;border-radius:4px;margin:0}.pure-form .pure-group input:last-child,.pure-form .pure-group textarea:last-child{top:-2px;border-radius:0 0 4px 4px;margin:0}.pure-form .pure-group button{margin:.35em 0}.pure-form .pure-input-1{width:100%}.pure-form .pure-input-3-4{width:75%}.pure-form .pure-input-2-3{width:66%}.pure-form .pure-input-1-2{width:50%}.pure-form .pure-input-1-3{width:33%}.pure-form .pure-input-1-4{width:25%}.pure-form .pure-help-inline,.pure-form-message-inline{display:inline-block;padding-left:.3em;color:#666;vertical-align:middle;font-size:.875em}.pure-form-message{display:block;color:#666;font-size:.875em}@media only screen and (max-width :480px){.pure-form button[type=submit]{margin:.7em 0 0}.pure-form input:not([type]),.pure-form input[type=password],.pure-form input[type=email],.pure-form input[type=url],.pure-form input[type=date],.pure-form input[type=month],.pure-form input[type=time],.pure-form input[type=datetime],.pure-form input[type=datetime-local],.pure-form input[type=week],.pure-form input[type=tel],.pure-form input[type=color],.pure-form input[type=number],.pure-form input[type=search],.pure-form input[type=text],.pure-form label{margin-bottom:.3em;display:block}.pure-group input:not([type]),.pure-group input[type=password],.pure-group input[type=email],.pure-group input[type=url],.pure-group input[type=date],.pure-group input[type=month],.pure-group input[type=time],.pure-group input[type=datetime],.pure-group input[type=datetime-local],.pure-group input[type=week],.pure-group input[type=tel],.pure-group input[type=color],.pure-group input[type=number],.pure-group input[type=search],.pure-group input[type=text]{margin-bottom:0}.pure-form-aligned .pure-control-group label{margin-bottom:.3em;text-align:left;display:block;width:100%}.pure-form-aligned .pure-controls{margin:1.5em 0 0}.pure-form .pure-help-inline,.pure-form-message,.pure-form-message-inline{display:block;font-size:.75em;padding:.2em 0 .8em}}.pure-menu-fixed{position:fixed;left:0;top:0;z-index:3}.pure-menu-item,.pure-menu-list{position:relative}.pure-menu-list{list-style:none;margin:0;padding:0}.pure-menu-item{padding:0;margin:0;height:100%}.pure-menu-heading,.pure-menu-link{display:block;text-decoration:none;white-space:nowrap}.pure-menu-horizontal{width:100%;white-space:nowrap}.pure-menu-horizontal .pure-menu-list{display:inline-block}.pure-menu-horizontal .pure-menu-heading,.pure-menu-horizontal .pure-menu-item,.pure-menu-horizontal .pure-menu-separator{display:inline-block;zoom:1;vertical-align:middle}.pure-menu-item .pure-menu-item{display:block}.pure-menu-children{display:none;position:absolute;left:100%;top:0;margin:0;padding:0;z-index:3}.pure-menu-horizontal .pure-menu-children{left:0;top:auto;width:inherit}.pure-menu-active>.pure-menu-children,.pure-menu-allow-hover:hover>.pure-menu-children{display:block;position:absolute}.pure-menu-has-children>.pure-menu-link:after{padding-left:.5em;content:"\25B8";font-size:small}.pure-menu-horizontal .pure-menu-has-children>.pure-menu-link:after{content:"\25BE"}.pure-menu-scrollable{overflow-y:scroll;overflow-x:hidden}.pure-menu-scrollable .pure-menu-list{display:block}.pure-menu-horizontal.pure-menu-scrollable .pure-menu-list{display:inline-block}.pure-menu-horizontal.pure-menu-scrollable{white-space:nowrap;overflow-y:hidden;overflow-x:auto;-ms-overflow-style:none;-webkit-overflow-scrolling:touch;padding:.5em 0}.pure-menu-horizontal.pure-menu-scrollable::-webkit-scrollbar{display:none}.pure-menu-horizontal .pure-menu-children .pure-menu-separator,.pure-menu-separator{background-color:#ccc;height:1px;margin:.3em 0}.pure-menu-horizontal .pure-menu-separator{width:1px;height:1.3em;margin:0 .3em}.pure-menu-horizontal .pure-menu-children .pure-menu-separator{display:block;width:auto}.pure-menu-heading{text-transform:uppercase;color:#565d64}.pure-menu-link{color:#777}.pure-menu-children{background-color:#fff}.pure-menu-disabled,.pure-menu-heading,.pure-menu-link{padding:.5em 1em}.pure-menu-disabled{opacity:.5}.pure-menu-disabled .pure-menu-link:hover{background-color:transparent}.pure-menu-active>.pure-menu-link,.pure-menu-link:focus,.pure-menu-link:hover{background-color:#eee}.pure-menu-selected .pure-menu-link,.pure-menu-selected .pure-menu-link:visited{color:#000}.pure-table{empty-cells:show;border:1px solid #cbcbcb}.pure-table caption{color:#000;font:italic 85%/1 arial,sans-serif;padding:1em 0;text-align:center}.pure-table td,.pure-table th{border-left:1px solid #cbcbcb;border-width:0 0 0 1px;font-size:inherit;margin:0;overflow:visible;padding:.5em 1em}.pure-table td:first-child,.pure-table th:first-child{border-left-width:0}.pure-table thead{background-color:#e0e0e0;color:#000;text-align:left;vertical-align:bottom}.pure-table td{background-color:transparent}.pure-table-odd td,.pure-table-striped tr:nth-child(2n-1) td{background-color:#f2f2f2}.pure-table-bordered td{border-bottom:1px solid #cbcbcb}.pure-table-bordered tbody>tr:last-child>td{border-bottom-width:0}.pure-table-horizontal td,.pure-table-horizontal th{border-width:0 0 1px;border-bottom:1px solid #cbcbcb}.pure-table-horizontal tbody>tr:last-child>td{border-bottom-width:0}';

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

        $this->addItem(new \Ease\Html\DivTag($index,
                ['class' => 'pure-menu', 'css' => 'display: inline-block;']));
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
                '<style>'.Digestor::$purecss.Digestor::getCustomCss().Digestor::getWebPageInlineCSS().'</style>']));
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
