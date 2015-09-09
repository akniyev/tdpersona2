<?
$arUrlRewrite = array(
	array(
		"CONDITION" => "#^/bitrix/services/ymarket/#",
		"RULE" => "",
		"ID" => "",
		"PATH" => "/bitrix/services/ymarket/index.php",
	),
	array(
		"CONDITION" => "#^={SITE_DIR.\"about/\"}#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => "/about/index.php",
	),
	array(
		"CONDITION" => "#^={SITE_DIR.\"staff/\"}#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => "/staff.php",
	),
	array(
		"CONDITION" => "#^/brands/([0-9]+)/#",
		"RULE" => "brand_id=\$1",
		"ID" => "",
		"PATH" => "/brands/detail.php",
	),
	array(
		"CONDITION" => "#^/personal/order/#",
		"RULE" => "",
		"ID" => "bitrix:sale.personal.order",
		"PATH" => "/personal/order/index.php",
	),
	array(
		"CONDITION" => "#^/guaranty/#",
		"RULE" => "",
		"ID" => "",
		"PATH" => "/adults/index.php",
	),
	array(
		"CONDITION" => "#^/delivery/#",
		"RULE" => "",
		"ID" => "",
		"PATH" => "/adults/index.php",
	),
	array(
		"CONDITION" => "#^/catalog/#",
		"RULE" => "",
		"ID" => "bitrix:catalog",
		"PATH" => "/catalog/index.php",
	),
	array(
		"CONDITION" => "#^/kredit/#",
		"RULE" => "",
		"ID" => "",
		"PATH" => "/adults/index.php",
	),
	array(
		"CONDITION" => "#^/oplata/#",
		"RULE" => "",
		"ID" => "",
		"PATH" => "/adults/index.php",
	),
	array(
		"CONDITION" => "#^/store/#",
		"RULE" => "",
		"ID" => "bitrix:catalog.store",
		"PATH" => "/store/index.php",
	),
	array(
		"CONDITION" => "#^/staff/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => "/staff/index.php",
	),
	array(
		"CONDITION" => "#^/news/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => "/news/index.php",
	),
	array(
		"CONDITION" => "#^/blog/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => "/blog/index.php",
	),
);

?>