<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$arComponentParameters = [
    "PARAMETERS" => [
        "IBLOCK_ID" => [
            "PARENT" => "BASE",
            "NAME" => "ID инфоблока",
            "TYPE" => "STRING",
            "DEFAULT" => "",
        ],
        "MAP_API_KEY" => [
            "PARENT" => "BASE",
            "NAME" => "API-ключ Яндекс.Карт",
            "TYPE" => "STRING",
            "DEFAULT" => "",
        ],
        "CACHE_TIME" => ["DEFAULT" => 36000000],
    ],
];