<?php

namespace Bitrixnuxt\Rest\Controller;

use Bitrix\Main\Engine\Controller;

class Base extends Controller
{
	public static function onRestServiceBuildDescription()
    {
        return array(
            '_global' => [
                'getCatalogSectionList' => [
                    'callback' => ['Bitrixnuxt\\Rest\\RestRequests\\Catalog', 'getSections'],
                    'options' => array(),
                ],
                'getElements' => [
                    'callback' => ['Bitrixnuxt\\Rest\\RestRequests\\Catalog', 'getElements'],
                    'options' => array(),
                ],
                'getElementDetail' => [
                    'callback' => ['Bitrixnuxt\\Rest\\RestRequests\\Catalog', 'getElementDetail'],
                    'options' => array(),
                ],
            ],
            // 'bitrixnuxt.rest' => [
            //     'bitrixnuxt.rest.getCatalogSectionList' => [
            //         'callback' => ['Bitrixnuxt\\Rest\\RestRequests\\Test', 'getTest'],
            //         'options' => array(),
            //     ],
            // ]
        );
    }
}