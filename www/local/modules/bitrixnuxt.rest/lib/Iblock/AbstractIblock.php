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
}