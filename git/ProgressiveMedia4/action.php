<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php"); ?>
<?php

/** @global CUser $USER */
$arr=explode ("-",  $_POST["hide_id"]);
CModule::IncludeModule('iblock');
$el = new CIBlockElement;
$PROP = array();
if($USER->GetID()>0){
    $PROP['ID_USER'] = $USER->GetID();
}else{
    $PROP['ID_USER'] = 0;
}

$PROP['IDENTIFICATOR'] =$_POST['idendificator'];
$PROP['id_parent_coomment'] =$_POST['id_parent_coomment'];


$arLoadProductArray = Array(
    "ACTIVE_FROM" =>  date('d.m.Y H:i:s'),
    //"MODIFIED_BY" => $USER->GetID(),
    "IBLOCK_SECTION_ID" => false,
    "IBLOCK_ID" => 2,
    "NAME" => $_POST["name_user"],
    "ACTIVE" => "Y",
    "DETAIL_TEXT" =>  $_POST["message_txt"],
    "PROPERTY_VALUES"=> $PROP,
);
$info=array();
if($newElement = $el->Add($arLoadProductArray)){

    print_r($newElement);
}else{
    print_r("Error: ".$el->LAST_ERROR);
}

/*else
    */
?>
