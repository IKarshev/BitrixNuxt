<?
include_once( \Bitrix\Main\Application::getDocumentRoot() . '/local/composer/vendor/autoload.php' );
include_once( \Bitrix\Main\Application::getDocumentRoot() . '/local/autoloader.php' );

$eventManager = \Bitrix\Main\EventManager::getInstance();
$eventManager->addEventHandler('main', 'OnBuildGlobalMenu', ['BitrixNuxt\\EventHandler\\OnBuildGlobalMenuHandler', 'init']);