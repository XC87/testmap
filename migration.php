<?php

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;
use Bitrix\Iblock\PropertyTable;

Loader::includeModule('iblock');

$iblockCode = 'offices';
$iblockName = 'Офисы';
$iblockType = 'content';
$iblockTypeName = 'Контент';

// TODO? проверка на существование чтоб повторно не добавилось
$arType = array(
    'ID' => $iblockType,
    'SECTIONS' => 'N',
    'IN_RSS' => 'N',
    'SORT' => 100,
    'LANG' => array(
        'ru' => array(
            'NAME' => $iblockTypeName,
            'SECTION_NAME' => 'Разделы',
            'ELEMENT_NAME' => 'Элементы',
        ),
        'en' => array(
            'NAME' => 'Content',
            'SECTION_NAME' => 'Sections',
            'ELEMENT_NAME' => 'Elements',
        ),
    ),
);

$obIBlock = new CIBlock;
$iblockId = $obIBlock->add([
    'CODE' => $iblockCode,
    'IBLOCK_TYPE_ID' => $iblockType,
    'NAME' => $iblockName,
    'API_CODE' => $iblockCode,
    'SITE_ID' => ['s1'],
]);

if ($iblockId) {
    CIBlock::SetPermission($iblockId, Array("1"=>"X", "2"=>"R"));
    $arProperty = [
        [
            'NAME' => 'Телефон',
            'CODE' => 'PHONE',
            'PROPERTY_TYPE' => PropertyTable::TYPE_STRING,
            'IBLOCK_ID' => $iblockId,
        ],
        [
            'NAME' => 'Email',
            'CODE' => 'EMAIL',
            'PROPERTY_TYPE' => PropertyTable::TYPE_STRING,
            'IBLOCK_ID' => $iblockId,
        ],
        [
            'NAME' => 'Координаты',
            'CODE' => 'COORDS',
            'PROPERTY_TYPE' => PropertyTable::TYPE_STRING,
            'IBLOCK_ID' => $iblockId,
        ],
        [
            'NAME' => 'Город',
            'CODE' => 'CITY',
            'PROPERTY_TYPE' => PropertyTable::TYPE_STRING,
            'IBLOCK_ID' => $iblockId,
        ],
    ];

    foreach ($arProperty as $property) {
        $result = PropertyTable::add($property);
    }

    $arElement = [
        [
            'NAME' => 'Офис в Москве',
            'PHONE' => '+7 (495) 123-45-67',
            'EMAIL' => 'moscow@company.ru',
            'COORDS' => '55.755814, 37.617635',
            'CITY' => 'Москва',
        ],
        [
            'NAME' => 'Офис в Санкт-Петербурге',
            'PHONE' => '+7 (812) 123-45-67',
            'EMAIL' => 'spb@company.ru',
            'COORDS' => '59.939095, 30.315868',
            'CITY' => 'Санкт-Петербург',
        ],
        [
            'NAME' => 'Офис в Новосибирске',
            'PHONE' => '+7 (123) 123-45-67',
            'EMAIL' => 'novosibirsk@company.ru',
            'COORDS' => '55.008352, 82.935732',
            'CITY' => 'Новосибирск',
        ],
        [
            'NAME' => 'Офис в Екатеринбурге',
            'PHONE' => '+7 (123) 123-45-67',
            'EMAIL' => 'ekaterinburg@company.ru',
            'COORDS' => '56.838002, 60.597295',
            'CITY' => 'Екатеринбург',
        ],
        [
            'NAME' => 'Офис в Краснодаре',
            'PHONE' => '+7 (123) 123-45-67',
            'EMAIL' => 'krasnodar@company.ru',
            'COORDS' => '45.035470, 38.975313',
            'CITY' => 'Краснодар',
        ],
    ];

    $obElement = new CIBlockElement();
    foreach ($arElement as $element) {
        $result = $obElement->add([
            'IBLOCK_ID' => $iblockId,
            'NAME' => $element['NAME'],
            'PROPERTY_VALUES' => [
                'PHONE' => $element['PHONE'],
                'EMAIL' => $element['EMAIL'],
                'COORDS' => $element['COORDS'],
                'CITY' => $element['CITY'],
            ],
        ]);
    }

    echo('ID инфоблока '.$iblockId);
    echo('<br>');
    $indexData = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/map/index.php');
    $indexData = str_replace('#IBLOCK_ID#', $iblockId, $indexData);
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/map/index.php', $indexData);

    echo('в map/index.php прописали');
    echo('<br>');
    echo('Миграция выполнена');
}
?>