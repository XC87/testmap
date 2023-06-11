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
        /** @var \Bitrix\Main\ORM\Query\Query $query * */
        $query = \Bitrix\Iblock\Elements\ElementOfficesTable::query();
        $res = $query->setFilter(["IBLOCK_ID" => $iblockId])
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

        $offices = [];
        while ($office = $res->fetch()) {
            if (!defined('BX_UTF')) {
                array_walk($office, [$this, 'convertToUtf']);
            }
            $offices[] = [
                "name" => $office["NAME"],
                "phone" => $office["PHONE_VALUE"],
                "email" => $office["EMAIL_VALUE"],
                "city" => $office["CITY_VALUE"],
                "coords" => explode(',', $office["COORDS_VALUE"]),
            ];
        }

        return $offices;
    }

    private function convertToUtf(&$value, $key)
    {
        $value = iconv('windows-1251', 'UTF-8', $value);
    }

    private function setCacheTag()
    {
        $taggedCache = \Bitrix\Main\Application::getInstance()
            ->getTaggedCache();
        $taggedCache->registerTag('iblock_id_' . $this->arParams["IBLOCK_ID"]);
    }

}
