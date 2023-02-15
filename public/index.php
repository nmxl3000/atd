
<?php

require_once('../config/config.inc.php');
require_once('./lib/HtmlLib.php');
require_once('./lib/SearchComponent.php');

/*
 * Countries supported:
 * England
 * Ireland
 * Germany
 * 
 * If you need to add more countries you must add entries to:
 *  - config/config.inc.php
 *  SearchComponent::getFilenameAndURLForCountry
 *  
 */
$country='ENGLAND';
if(DEBUG) echo '<br />Country url: ' .$url .'<br />';

// Using HtmlLib to put boilerplate HTML code around the app
HtmlLib::outputHead('Test - full product list from local JSON files ','css/style.css');
HtmlLib::outputBodyOpen();
SearchComponent::App($url,$country);
HtmlLib::outputBodyClose();
HtmlLib::outputHtmlClose();