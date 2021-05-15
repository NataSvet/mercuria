<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

/** @global CIntranetToolbar $INTRANET_TOOLBAR */
global $INTRANET_TOOLBAR;
use Bitrix\Main\Context,
	Bitrix\Main\Type\DateTime,
	Bitrix\Main\Loader,
	Bitrix\Iblock;

CPageOption::SetOptionString("main", "nav_page_in_session", "N");


if (!CModule::IncludeModule('iblock')) {
    return;
}
$arParams["IBLOCK_TYPE"] = 'comments';
$arParams["IBLOCK_ID"] = 2;
$arParams["OBJECT_COMMENT"]=$arParams["OBJECT_COMMENT"];
$arParams["SORT_BY1"] = "ACTIVE_FROM";

$selectFielCode = array(
    'NAME',
    'DETAIL_TEXT',
    'ACTIVE_FROM'
);

$arParams["SET_TITLE"] = $arParams["SET_TITLE"]!="N";
$arParams["ACTIVE_DATE_FORMAT"] = $DB->DateFormatToPHP(CSite::GetDateFormat("SHORT"));


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
    'PROPERTY_IDENTIFICATOR'=>$arParams["OBJECT_COMMENT"]
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
function getMass($arComm)
{ $keyed = array();
    foreach ( $arComm as $item){
        $item['CHILD']=array();
        $keyed [$item["ID"]]=$item;
    }
    foreach ( $keyed as &$item){
        if($item["PROPERTIES"]["id_parent_coomment"]["VALUE"]!=0){
            $keyed [$item["PROPERTIES"]["id_parent_coomment"]["VALUE"]]['CHILD'][]=&$item;
        }
    }
    unset($item);
    foreach ( $keyed as $k=>$item){
        if($item["PROPERTIES"]["id_parent_coomment"]["VALUE"]!=0){
            unset($keyed[$k]);
        }
    }
    return $keyed;
}
$arResult=getMass($arResult["ITEMS"]);
$this->IncludeComponentTemplate();


