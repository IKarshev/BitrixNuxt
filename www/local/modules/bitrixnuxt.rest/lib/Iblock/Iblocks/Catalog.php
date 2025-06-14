<?
namespace Bitrixnuxt\Rest\Iblock\Iblocks;

use Bitrixnuxt\Rest\Iblock\{AbstractIblock, IblockInterface};

\Bitrix\Main\Loader::includeModule('iblock');

class Catalog extends AbstractIblock implements IblockInterface
{
    protected const MODULE_PROP_IBLOCK_CODE = 'CATALOG_IBLOCK';

    public function __construct()
    {
        parent::__construct();
    }

    public function getSections(array $filter = [], int $limit = 0): ?array
    {
        try {
            $entity = \Bitrix\Iblock\Model\Section::compileEntityByIblock($this->getIblockId());

            $queryParams = [
                "filter" => array_merge($filter, [
                    "ACTIVE" => "Y",
                ]),
                "select" => ["ID", "NAME", "CODE", 'DEPTH_LEVEL', "PICTURE", 'SECTION_PAGE_URL_RAW' => 'IBLOCK.SECTION_PAGE_URL'],
            ];

            if ($limit > 0) {
                $queryParams['limit'] = $limit;
            }

            $sections = $entity::getList($queryParams)->fetchAll();

            foreach ($sections as &$section) {
                $section['PICTURE'] = [
                    'ID' => $section['ID'],  
                    'SRC' => \CFile::GetPath($section['ID']),  
                ];
                $section['SECTION_PAGE_URL'] = \CIBlock::ReplaceDetailUrl($section['SECTION_PAGE_URL_RAW'], $section, true, 'S');
            }

            return (is_array($sections) && !empty($sections)) ? $sections : null;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getElementList(string $sectionCode, int $page = 1, $itemPerPage = 20): ?array
    {
        if ($section = $this->getSections(['CODE' => $sectionCode], 1)) {
            $sectionId = array_shift($section)['ID'];

            $IblockClass = \Bitrix\Iblock\Iblock::wakeUp($this->getIblockId())->getEntityDataClass();
            $elementList = $IblockClass::getList([
                'select' => ['ID', 'CODE', 'PREVIEW_TEXT', 'PREVIEW_PICTURE', 'NAME', 'IBLOCK_SECTION_ID', 'DETAIL_PAGE_URL' => 'IBLOCK.DETAIL_PAGE_URL'],
                'filter' => [
                    'IBLOCK_SECTION_ID' => $sectionId,
                ],
            ])->fetchAll();

            foreach ($elementList as &$arItem) {
                $arItem['PREVIEW_PICTURE'] = [
                    'ID' => $arItem['PREVIEW_PICTURE'],  
                    'SRC' => \CFile::GetPath($arItem['PREVIEW_PICTURE']),  
                ];
                $arItem['DETAIL_PAGE_URL'] = \CIBlock::ReplaceDetailUrl($arItem['DETAIL_PAGE_URL'], $arItem, false, 'E');
            }

        }

        return $elementList ?? null;
    }
}