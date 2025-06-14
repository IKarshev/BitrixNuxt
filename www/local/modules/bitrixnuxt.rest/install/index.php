<?
use Bitrix\Main\{Application, EventManager, Loader};
use Bitrix\Main\IO\Directory;

Loader::includeModule('sale');

IncludeModuleLangFile(__FILE__);

/**
 * @author Karshev Ivan — https://github.com/IKarshev
 */
class Bitrixnuxt_Rest extends CModule
{
    var $MODULE_ID = "bitrixnuxt.rest";
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $errors;
    function __construct()
    {
        $this->MODULE_VERSION = "0.0.1";
        $this->MODULE_VERSION_DATE = "13.06.2025";
        $this->MODULE_NAME = "BitrixNuxt";
        $this->MODULE_DESCRIPTION = "BitrixNuxt Rest API";
    }

    function DoInstall()
    {
        global $APPLICATION;

        RegisterModule($this->MODULE_ID);

        $this->InstallDB();
        $this->InstallEvents();
        $this->InstallFiles();
        $APPLICATION->includeAdminFile(
            "Установочное сообщение",
            __DIR__ . '/instalInfo.php'
        );
        return true;
    }

    function DoUninstall()
    {
        global $APPLICATION;
        $this->UnInstallDB();
        $this->UnInstallEvents();
        $this->UnInstallFiles();

        UnRegisterModule($this->MODULE_ID);

        $APPLICATION->includeAdminFile(
            "Сообщение деинсталяции",
            __DIR__ . '/deInstalInfo.php'
        );
        return true;
    }

    function InstallDB()
    {
        return true;
    }

    function UnInstallDB()
    {
        return true;
    }

    function InstallEvents()
    {
        EventManager::getInstance()->registerEventHandler(
            'rest',
            'OnRestServiceBuildDescription',
            $this->MODULE_ID,
            'Bitrixnuxt\\Rest\\Controller\\Base',
            'onRestServiceBuildDescription'
        );
        return true;
    }

    function UnInstallEvents()
    {
        // EventManager::getInstance()->unRegisterEventHandler(
        //     'rest',
        //     'OnRestServiceBuildDescription',
        //     $this->MODULE_ID,
        //     'Bitrixnuxt\\Rest\\Controller\\Base',
        //     'onRestServiceBuildDescription'
        // );
        return true;
    }

    function InstallFiles()
    {
        return true;
    }

    function UnInstallFiles()
    {
        return true;
    }
}