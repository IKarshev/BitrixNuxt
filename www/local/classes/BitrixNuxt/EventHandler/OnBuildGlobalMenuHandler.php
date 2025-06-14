<?
namespace BitrixNuxt\EventHandler;

class OnBuildGlobalMenuHandler
{
    public static function init(&$arGlobalMenu, &$arModuleMenu)
    {
        global $USER;
        if (!$USER->IsAdmin()) {
            return;
        }

        $arGlobalMenu["global_menu_BitrixNuxt"] = [
            'menu_id' => 'bitrixNuxt',
            'text' => 'bitrixNuxt',
            'title' => 'bitrixNuxt',
            'url' => 'settingss.php?lang=ru',
            'sort' => 1000,
            'items_id' => 'global_menu_BitrixNuxt',
            'help_section' => 'custom',
            'items' => [
                [
                    'parent_menu' => 'global_menu_BitrixNuxt',
                    'sort' => 10,
                    'url' => '/local/rest/',
                    'text' => 'Вебхуки',
                    'title' => 'Вебхуки',
                    'icon' => 'fav_menu_icon',
                    'page_icon' => 'fav_menu_icon',
                    'items_id' => 'menu_custom',
                ],
            ],
        ];
    }
}