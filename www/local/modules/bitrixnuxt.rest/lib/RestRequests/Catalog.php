<?
namespace Bitrixnuxt\Rest\RestRequests;

use Bitrixnuxt\Rest\Iblock\Iblocks\Catalog as CatalogIblock;

class Catalog
{
    public static function getSections()
    {
        return (new CatalogIblock())->getSections();
    }

    public static function getElements($query, $nav, \CRestServer $server)
    {        
        return (new CatalogIblock())->getElementList($query['section_code']);
    }
    
    public static function getElementDetail($query, $nav, \CRestServer $server)
    {
        return (new CatalogIblock())->getElementDetail($query['section_code'], $query['element_code']);
    }
}