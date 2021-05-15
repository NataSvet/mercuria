<?

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
/** @global CUser $USER */
/** @var array $arParams */
$result = [
'isSuccess' => true,
'text' => "user was typing: {$_POST['name_user']}",
];

header("Content-type: application/json; charset=utf-8");
echo json_encode($result);
CModule::IncludeModule('iblock');  // это подключит нужный класс для работы с инфоблоком
$el = new CIBlockElement; // обязательно указываем класс
$PROP = array();       // здесь у нас будут храниться свойства
$PROP['ID_USER'] = $USER->GetID(); // свойству с id 1 задаём значение
$PROP['IDENTIFICATOR'] = $arParams["OBJECT_COMMENT"];
$PROP['id_parent_coomment'] = 0;
$arLoadProductArray = Array(
    "ACTIVE_FROM" => date('d.m.Y H:i:s'),
    "MODIFIED_BY" => $USER->GetID(),
    "IBLOCK_SECTION_ID" => false,
    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
    "NAME" => $_POST["user_name"],
    "ACTIVE" => "Y",
    "DETAIL_TEXT" =>  $_POST["MESSAGE"],
    "PROPERTY_VALUES"=> $PROP,
);
if($newElement = $el->Add($arLoadProductArray))
    return $newElement;
else
    return "Error: ".$el->LAST_ERROR;
?>