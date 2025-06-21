<?
namespace Bitrixnuxt\Rest\Iblock;

\Bitrix\Main\Loader::includeModule('iblock');

use Exception;

/**
 * @class Хелпер для запросов в инфоблок на d7
 * @author Karshev Ivan — https://github.com/IKarshev
 */
class IBlockQueryHelper
{
    protected $iblockId;
    private $IblockClass;

    public function __construct(int $iblockId)
    {
        try {
            $this->iblockId = $iblockId;
            if (($IblockClass = \Bitrix\Iblock\Iblock::wakeUp($iblockId)->getEntityDataClass()) !== null) {
                $this->IblockClass = $IblockClass;
            } else {
                throw new Exception("Поле 'Символьный код API' у инфоблока не заполнен", 101);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * @param array $data - Массив с входными параметрами, как при запросе CIBlock getlist.
     *  Свойства идут в формате PROPERTY_<PROPERTY_CODE>, где <PROPERTY_CODE> это код свойства
     *  Фильтрация происходит в формате D7. Например так ['filter' => ['ID' => 1, '=CML2_ARTICLE.VALUE' => $article]]
     */
    public function getList(array $data): array
    {
        if (isset($data['select']) && !empty($data['select'])) {

            // Выборка полей.
            $selectFields = array_filter($data['select'], function ($item) {
                return !str_contains($item, 'PROPERTY_');
            });

            // Выборка свойства.
            $properties = array_filter($data['select'], function ($item) {
                return str_contains($item, 'PROPERTY_');
            });

            // Очищаем select т.к. дальше $data нам ещё понадобится.
            if (isset($data['select'])) {
                unset($data['select']);
            }

            // Подготоваливаем свойства для запроса
            if (isset($properties) && !empty($properties)) {
                foreach ($properties as &$propName) {
                    $propName = str_replace('PROPERTY_', '', $propName);
                }

                $PropertySettings = \Bitrix\Iblock\PropertyTable::getList([
                    'filter' => [
                        'IBLOCK_ID' => $this->iblockId,
                        'CODE' => $properties,
                    ],
                    'select' => ['*'],
                ])->fetchAll();

                // Подготавливаем запрос для свойств
                if (isset($PropertySettings) && !empty($PropertySettings)) {
                    foreach ($PropertySettings as $prop) {
                        switch ($prop['PROPERTY_TYPE']) {
                            case \Bitrix\Iblock\PropertyTable::TYPE_LIST:
                                $selectProperties[] = $prop['CODE'] . '.ITEM';
                                break;

                            case \Bitrix\Iblock\PropertyTable::TYPE_ELEMENT:
                                $selectProperties[] = $prop['CODE'] . '.ELEMENT';
                                break;

                            case \Bitrix\Iblock\PropertyTable::TYPE_SECTION:
                                $selectProperties[] = $prop['CODE'] . '.SECTION';
                                break;

                            case \Bitrix\Iblock\PropertyTable::TYPE_FILE:
                                $selectProperties[] = $prop['CODE'] . '.FILE';
                                break;

                            default:
                                $selectProperties[] = $prop['CODE'];
                                break;
                        }
                    }
                }
            }

            // Делаем запрос
            $queryResult = $this->IblockClass::getList(
                array_merge(
                    $data,
                    [
                        'select' => array_merge(
                            $selectFields,
                            $selectProperties ?? []
                        )
                    ],
                )
            )->fetchCollection();

            foreach ($queryResult as $queryResultItem) {
                // Получаем поля
                foreach ($selectFields as $FieldName) {
                    $result[$queryResultItem->get('ID')][$FieldName] = $queryResultItem->get($FieldName);
                }

                // Получаем значения полей
                if (isset($selectProperties) && !empty($selectProperties)) {
                    foreach ($PropertySettings as $prop) {
                        $propsResult = $prop;

                        $propObject = $queryResultItem->get($prop['CODE']);
                        if ($propObject === null) {
                            continue;
                        }

                        switch ($prop['PROPERTY_TYPE']) {
                            case \Bitrix\Iblock\PropertyTable::TYPE_LIST:
                                if ($this->isPropertyMultiple($propObject)) {
                                    foreach ($propObject->getAll() as $propItem) {
                                        $propsResult['VALUE'][] = [
                                            'ID' => $propItem->getItem()->getId(),
                                            'XML_ID' => $propItem->getItem()->getXmlId(),
                                            'VALUE' => $propItem->getItem()->getValue(),
                                        ];
                                    }
                                } else {
                                    $propsResult['VALUE'] = $propObject->getValue();
                                }
                                break;

                            case \Bitrix\Iblock\PropertyTable::TYPE_ELEMENT:
                                if ($this->isPropertyMultiple($propObject)) {
                                    foreach ($propObject->getAll() as $propItem) {
                                        $propsResult['VALUE'][] = [
                                            'ID' => $propItem->getElement()->getId(),
                                            'NAME' => $propItem->getElement()->getName(),
                                        ];
                                    }
                                } else {
                                    $propsResult['VALUE'] = [
                                        'ID' => $propObject->getElement()->getId(),
                                        'NAME' => $propObject->getElement()->getName(),
                                    ];
                                }
                                break;

                            case \Bitrix\Iblock\PropertyTable::TYPE_SECTION:
                                if ($this->isPropertyMultiple($propObject)) {
                                    foreach ($propObject->getAll() as $propItem) {
                                        $propsResult['VALUE'][] = [
                                            'ID' => $propItem->getSection()->getId(),
                                            'NAME' => $propItem->getSection()->getName(),
                                        ];
                                    }
                                } else {
                                    $propsResult['VALUE'] = [
                                        'ID' => $propObject->getSection()->getId(),
                                        'NAME' => $propObject->getSection()->getName(),
                                    ];
                                }
                                break;

                            case \Bitrix\Iblock\PropertyTable::TYPE_FILE:
                                if ($this->isPropertyMultiple($propObject)) {
                                    foreach ($propObject->getAll() as $propItem) {
                                        $propsResult['VALUE'][] = [
                                            'ID' => $propItem->getFile()->getID(),
                                            'PATH' => \CFile::GetPath($propItem->getFile()->getID()),
                                        ];
                                    }
                                } else {
                                    $propsResult['VALUE'] = [
                                        'ID' => $propObject->getFile()->getID(),
                                        'PATH' => \CFile::GetPath($propObject->getFile()->getID()),
                                    ];
                                }
                                break;

                            default:
                                if ($this->isPropertyMultiple($propObject)) {
                                    foreach ($propObject->getAll() as $propItem) {
                                        $propsResult['VALUE'][] = $propItem->getValue();
                                    }
                                } else {
                                    $propsResult['VALUE'] = $propObject->getValue();
                                }
                                break;
                        }

                        if (!isset($propsResult['VALUE'])) {
                            $propsResult['VALUE'] = null;
                        }

                        $result[$queryResultItem->get('ID')]['PROPERTYS'][$prop['CODE']] = $propsResult;
                    }
                }
            }

            return $result ?? [];
        } else {
            throw new Exception("Не передан select для выборки", 100);
        }
    }

    /**
     * @param $propObject - объект свойства
     * @return bool - является ли свойство множественным
     */
    public function isPropertyMultiple($propObject): bool
    {
        return str_contains(get_class($propObject), 'Collection');
    }
}