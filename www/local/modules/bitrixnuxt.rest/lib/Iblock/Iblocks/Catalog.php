<?
namespace Bitrixnuxt\Rest\Iblock\Iblocks;

use Bitrixnuxt\Rest\Iblock\{AbstractIblock, IblockInterface};
use Bitrixnuxt\Rest\Iblock\Exceptions\IblockNotFountException;
use Bitrixnuxt\Rest\Options\OptionManager;

\Bitrix\Main\Loader::includeModule('iblock');

class Catalog extends AbstractIblock implements IblockInterface
{
    protected const MODULE_PROP_IBLOCK_CODE = 'CATALOG_IBLOCK';

    public function __construct()
    {
        parent::__construct();
    }

    public function getSections()
    {
        try {
            $entity = \Bitrix\Iblock\Model\Section::compileEntityByIblock($this->getIblockId());
            $sections = $entity::getList([
                "filter" => [
                    "ACTIVE" => "Y",
                ],
                "select" => ["ID", "NAME", "CODE", "PICTURE", 'SECTION_PAGE_URL_RAW' => 'IBLOCK.SECTION_PAGE_URL'],
            ])->fetchAll();

            foreach ($sections as &$section) {
                $section['PICTURE'] = [
                    'ID' => $section['ID'],  
                    'SRC' => \CFile::GetPath($section['ID']),  
                ];
                $section['SECTION_PAGE_URL'] = \CIBlock::ReplaceDetailUrl($section['SECTION_PAGE_URL_RAW'], $section, true, 'S');
            }

            return $sections;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}