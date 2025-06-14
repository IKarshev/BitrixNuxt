<?
namespace Bitrixnuxt\Rest\RestRequests;

use Bitrixnuxt\Rest\Iblock\Iblocks\Catalog as CatalogIblock;

class Catalog
{
    public static function getSections()
    {
        return (new CatalogIblock())->getSections();
    }
}