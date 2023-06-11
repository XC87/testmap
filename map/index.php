<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetTitle("Карта");

/**
 * Bitrix vars
 *
 * @global CMain $APPLICATION
 */
?>
<?$APPLICATION->IncludeComponent(
    "alex:mapoffices",
    ".default",
    array(
        "IBLOCK_ID" => "15",
        "MAP_API_KEY" => "ac686d8a-dc87-4c58-bebd-33c1796bb5c2",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "86400"
    ),
    false
);?>
<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
?>