<?php
namespace Bitrixnuxt\Rest\Options;

use Bitrix\Main\Localization\Loc;

class OptionList
{
    // text, checkbox, selectbox, multiselectbox, textarea, statictext
    public static function getOptionList(): array
    {
        return [
            [
                "DIV" => "main settings",
                "TAB"=> Loc::getMessage("TAB_MAIN_SETTINGS"),
                "TITLE" => Loc::getMessage("TAB_MAIN_SETTINGS"),
                "OPTIONS" => [
                    Loc::getMessage("TITLE_IBLOCKS"),
                    array(
                        "CATALOG_IBLOCK",
                        Loc::getMessage("CATALOG_IBLOCK"),
                        "",
                        array("selectbox"),
                    ),
                ]
            ],
        ];
    }
}