<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Новости");
?><?$APPLICATION->IncludeComponent(
	"dv:com", 
	".default", 
	array(
		"OBJECT_COMMENT" => "1",
		"TYPE_COMMENT" => "0",
		"COMPONENT_TEMPLATE" => ".default",
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => ""
	),
	false
);?><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>