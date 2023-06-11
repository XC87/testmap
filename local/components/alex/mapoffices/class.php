<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;

class MapOffices extends CBitrixComponent
{
    public function executeComponent()
    {
        if ($this->startResultCache($this->arParams['CACHE_TIME'], $this->arParams)) {
            $this->arResult["OFFICES"] = $this->getOffices();
            $this->setCacheTag();
            $this->includeComponentTemplate();
        }
    }

    private function getOffices()
    {
        Loader::includeModule("iblock");

        $iblockId = $this->arParams["IBLOCK_ID"];
        /** @var \Bitrix\Main\ORM\Query\Query $obQuery * */
        $obQuery = \Bitrix\Iblock\Elements\ElementOfficesTable::query();
        $obResult = $obQuery->setFilter(["IBLOCK_ID" => $iblockId])
            ->setSelect(
                [
                    "ID",
                    "NAME",
                    "PHONE_" => "PHONE",
                    "EMAIL_" => "EMAIL",
                    "CITY_" => "CITY",
                    "COORDS_" => "COORDS",
                ]
            )
            ->exec();

        $arOffices = [];
        while ($arOffice = $obResult->fetch()) {
            if (!defined('BX_UTF')) {
                array_walk($arOffice, [$this, 'convertToUtf']);
            }
            $arOffices[] = [
                "name" => $arOffice["NAME"],
                "phone" => $arOffice["PHONE_VALUE"],
                "email" => $arOffice["EMAIL_VALUE"],
                "city" => $arOffice["CITY_VALUE"],
                "coords" => explode(',', $arOffice["COORDS_VALUE"]),
            ];
        }

        return $arOffices;
    }

    private function convertToUtf(&$value, $key)
    {
        $value = iconv('windows-1251', 'UTF-8', $value);
    }

    private function setCacheTag()
    {
        $obTaggedCache = \Bitrix\Main\Application::getInstance()
            ->getTaggedCache();
        $obTaggedCache->registerTag('iblock_id_' . $this->arParams["IBLOCK_ID"]);
    }

}
