<?
/**
 * Функция автолоадера
 * Проверяет директорию:
 * - /local/classes/{Path|raw}/{*|raw}.php
 * - /local/classes/{Path|ucfirst}/{*|ucfirst}.php
 * В порядке приоритетов на наличие подключаемых файлов
 */
spl_autoload_register('__autoloadClasses');
function __autoloadClasses($sClassName) {

    $sClassFile = __DIR__.'/classes';

    // Проверка /local/classes/{Path|raw}/{*|raw}.php
    if ( file_exists($sClassFile.'/'.str_replace('\\', '/', $sClassName).'.php') ) {
        require_once($sClassFile.'/'.str_replace('\\', '/', $sClassName).'.php');
    }

    // Проверка /local/classes/{Path|ucfirst}/{*|ucfirst}.php
    $arClass = explode('\\', strtolower($sClassName));
    foreach($arClass as $sPath ) {
        $sClassFile .= '/'.ucfirst($sPath);
    }
    $sClassFile .= '.php';
    if (file_exists($sClassFile)) {
        require_once($sClassFile);
    }
}
?>