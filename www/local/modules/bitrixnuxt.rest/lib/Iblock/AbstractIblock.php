<?
namespace Bitrixnuxt\Rest\Iblock;

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use Bitrixnuxt\Rest\Options\OptionManager;
use Bitrixnuxt\Rest\Iblock\Exceptions\IblockNotFountException;
abstract class AbstractIblock
{
    protected $iblockId;
    public function __construct() {
        try {
            $this->iblockId = $this->getIblockId();
        } catch (\Throwable $th) {
            $logName = $this->getLogName();
            $logger = new Logger('registerFormLogger');
            $logger->pushHandler(new StreamHandler( \Bitrix\Main\Application::getDocumentRoot() . "/local/logs/$logName.log", Level::Error));
            $logger->error(
                'Ошибка при запросе данных из каталога', 
                [
                    'message' => $th->getMessage(),
                    'file' => $th->getFile(),
                    'line' => $th->getLine(),
                    'trace' => $th->getTraceAsString(),
                ]
            );
        }
    }

    public function getIblockId(): int
    {
        $optionManager = new OptionManager();
        if ($catalogIblockOption = $optionManager->getOption(static::MODULE_PROP_IBLOCK_CODE)) {
            if ($iblockId = $catalogIblockOption->getValue()) {
                return $iblockId;
            } else {
                throw new IblockNotFountException('Инфоблок не указан');
            }
        } else {
            throw new IblockNotFountException('Инфоблок не указан');
        }
    }
    public function getLogName(): string
    {
        $classname = get_class($this);
        if ($pos = strrpos($classname, '\\')) {
            return substr($classname, $pos + 1);
        }
        return $pos;
    }

    public function getSectionPageShowProps(): array
    {
        $listShowPropertyId = \Bitrix\Iblock\Model\PropertyFeature::getListPageShowPropertyCodes($this->iblockId);
        $response = \Bitrix\Iblock\PropertyTable::getList(array(
            'filter' => [
                'IBLOCK_ID' => $this->iblockId,
                '=ID' => $listShowPropertyId,
            ],
            'select' => ['*'],
        ))->fetchAll();
        return $response ?? [];
    }

    public function getDetailPageShowProps(): array
    {
        $detailShowPropertyId = \Bitrix\Iblock\Model\PropertyFeature::getDetailPageShowPropertyCodes($this->iblockId);
        $response = \Bitrix\Iblock\PropertyTable::getList(array(
            'filter' => [
                'IBLOCK_ID' => $this->iblockId,
                '=ID' => $detailShowPropertyId,
            ],
            'select' => ['*'],
        ))->fetchAll();
        return $response ?? [];
    }

    public function isPropertyMultiple($propObject): bool
    {
        return str_contains(get_class($propObject), 'Collection');
    }
}