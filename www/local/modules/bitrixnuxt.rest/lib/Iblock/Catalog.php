<?
namespace Bitrixnuxt\Rest\Iblock;

use Bitrixnuxt\Rest\Options\OptionManager;

class Catalog
{
    public function __construct()
    {
        $optionManager = new OptionManager();

        if ($catalogIblockOption = $optionManager->getOption('CATALOG_IBLOCK')) {
            $this->iblockID = $catalogIblockOption->getValue();
        } else {
            
        }
    }
}