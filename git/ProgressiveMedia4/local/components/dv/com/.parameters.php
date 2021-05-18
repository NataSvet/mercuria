<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arCurrentValues */

if(!CModule::IncludeModule("iblock"))
	return;

//$arTypesEx = CIBlockParameters::GetIBlockTypes(array("-"=>" "));

/*$arIBlocks=array();
$db_iblock = CIBlock::GetList(array("SORT"=>"ASC"), array("SITE_ID"=>$_REQUEST["site"], "TYPE" => ($arCurrentValues["IBLOCK_TYPE"]!="-"?$arCurrentValues["IBLOCK_TYPE"]:"")));
while($arRes = $db_iblock->Fetch())
	$arIBlocks[$arRes["ID"]] = "[".$arRes["ID"]."] ".$arRes["NAME"];*/


$arSorts = array("DESC"=>GetMessage("T_IBLOCK_DESC_DESC"));
$arSortFields = array(
		"ACTIVE_FROM"=>GetMessage("T_IBLOCK_DESC_FACT")
	);

/*$arProperty_LNS = array();
$rsProp = CIBlockProperty::GetList(array("sort"=>"asc", "name"=>"asc"), array("ACTIVE"=>"Y", "IBLOCK_ID"=>(isset($arCurrentValues["IBLOCK_ID"])?$arCurrentValues["IBLOCK_ID"]:$arCurrentValues["ID"])));
while ($arr=$rsProp->Fetch())
{
	$arProperty[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
	if (in_array($arr["PROPERTY_TYPE"], array("L", "N", "S")))
	{
		$arProperty_LNS[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
	}
}*/
$typeCom=array("инфоблок", "странница");
$arComponentParameters["PARAMETERS"]=array();
$arComponentParameters = array(
	"GROUPS" => array(
	),
	"PARAMETERS" => array(
        "TYPE_COMMENT" => Array(
            "PARENT" => "BASE",
            "NAME" => "Тип объекта комментирования",
            "TYPE" => "LIST",
            "VALUES" => $typeCom,
            "DEFAULT" => "Инфоблок",
            //"REFRESH" => "Y",
        ),
        "OBJECT_COMMENT" => array(
            "PARENT" => "BASE",
            "NAME" => "Объект комментирования",
            "TYPE" => "TEXT",
        ),
	),
);



