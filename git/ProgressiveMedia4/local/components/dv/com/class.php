<?
use Bitrix\Main\Context,
    Bitrix\Main\Type\DateTime,
    Bitrix\Main\Loader,
    Bitrix\Iblock;
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
class Comments extends CBitrixComponent
{
    private function _checkModules(){
        if (!CModule::IncludeModule('iblock')) {
            return;
        }
    }


    private function _getElements($arParams){
        $arSelect = array(
            'ID',
            'IBLOCK_ID',
            'NAME',
            'DETAIL_TEXT',
            "DATE_ACTIVE_FROM",
            'UF_*'

        );
        $arFilter = array(
            'IBLOCK_ID' => $arParams["IBLOCK_ID"],
            'PROPERTY_IDENTIFICATOR' => $arParams["OBJECT_COMMENT"]
        );
        $arSort = array(
            'date_active_from' => 'asc'
        );
        $rsElements = CIBlockElement::GetList(
            $arSort,
            $arFilter,
            false,
            false,
            $arSelect
        );
        $rsElements->SetUrlTemplates($arParams['ELEMENT_URL'], $arParams['SECTION_URL']);
        while ($arItem = $rsElements->GetNextElement()) {
            $arResultP = $arItem->GetFields();
            $arResultP['PROPERTIES'] = $arItem->GetProperties();
            $arResult['ITEMS'][] = $arResultP;
        }
        return $arResult;
    }

    private function  _commentMass($arComm)
    {
        $keyed = array();
        foreach ($arComm as $item) {
            $item['CHILD'] = array();
            $keyed [$item["ID"]] = $item;
        }
        foreach ($keyed as &$item) {
            if ($item["PROPERTIES"]["id_parent_coomment"]["VALUE"] != 0) {
                $keyed [$item["PROPERTIES"]["id_parent_coomment"]["VALUE"]]['CHILD'][] =& $item;
            }
        }
        unset($item);
        foreach ($keyed as $k => $item) {
            if ($item["PROPERTIES"]["id_parent_coomment"]["VALUE"] != 0) {
                unset($keyed[$k]);
            }
        }
        return $keyed;
    }
    /**
     * Метод из наследуемого класса CBitrixComponent - Обработка параметров компонента
     *
     * @param $arParams
     * @return array|void
     */
    public function onPrepareComponentParams($arParams)
    {
        //var_dump($arParams);
        global $DB;
        $result = array(
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_TIME" => isset($arParams["CACHE_TIME"]) ?$arParams["CACHE_TIME"]: 3600,
        );
        $result["IBLOCK_TYPE"] = 'comments';
        $result["IBLOCK_ID"] = 2;
            $result ["OBJECT_COMMENT"] = $arParams["OBJECT_COMMENT"];
                $result ["SORT_BY1"] = "ACTIVE_FROM";
        $result["SET_TITLE"] = $arParams["SET_TITLE"] != "N";
        $result["ACTIVE_DATE_FORMAT"] =$DB->DateFormatToPHP(CSite::GetDateFormat("SHORT") );
        return $result;
    }

    public function executeComponent() {
        $CaheId = array(
            'IBLOCK_ID' => $this->arParams["IBLOCK_ID"],
            'PROPERTY_IDENTIFICATOR' => $this->arParams["OBJECT_COMMENT"]
        );
        if ($this->StartResultCache(false, $CaheId)) {
            if ($CaheId['IBLOCK_ID'] !=$this->arParams["IBLOCK_ID"]||$CaheId['IBLOCK_ID'] !=$this->arParams["PROPERTY_IDENTIFICATOR"]){
                $this->AbortResultCache();
            }
            $this->_checkModules();
            $this->arResult=$this->_getElements($this->arParams);

            $this->arResult=$this->_commentMass($this->arResult["ITEMS"]);
            $this->IncludeComponentTemplate();
            $this->endResultCache();
        }
    }

}



