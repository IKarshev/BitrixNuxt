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
        // $navData = static::getNavData($nav, true);

        ob_start();
        print_r($query);
        echo "\n=========================\n";
        print_r($nav);
        $debug = ob_get_contents();
        ob_end_clean();
        $fp = fopen($_SERVER['DOCUMENT_ROOT'].'/lk-params.log', 'w+');
        fwrite($fp, $debug);
        fclose($fp); 

        return (new CatalogIblock())->getElementList($query['section_code']);
    }
}