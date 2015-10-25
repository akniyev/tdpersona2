<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Галерея");
?><div class="wrapper">
	<div class="container">
		<div class="container-hold">
			<h1>Галерея работ</h1>
			 <?$APPLICATION->IncludeComponent(
	"bitrix:photogallery",
	"",
	Array(
		"ADDITIONAL_SIGHTS" => array(""),
		"ALBUM_PHOTO_SIZE" => "120",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"COMPONENT_TEMPLATE" => ".default",
		"DATE_TIME_FORMAT_DETAIL" => "d.m.Y",
		"DATE_TIME_FORMAT_SECTION" => "d.m.Y",
		"DRAG_SORT" => "Y",
		"ELEMENTS_PAGE_ELEMENTS" => "50",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_ORDER" => "desc",
		"IBLOCK_ID" => "14",
		"IBLOCK_TYPE" => "news",
		"JPEG_QUALITY" => "100",
		"JPEG_QUALITY1" => "100",
		"ORIGINAL_SIZE" => "1280",
		"PAGE_NAVIGATION_TEMPLATE" => "",
		"PATH_TO_FONT" => "default.ttf",
		"PATH_TO_USER" => "",
		"PHOTO_LIST_MODE" => "Y",
		"SECTION_PAGE_ELEMENTS" => "15",
		"SECTION_SORT_BY" => "UF_DATE",
		"SECTION_SORT_ORD" => "DESC",
		"SEF_FOLDER" => "/about/gallery/",
		"SEF_MODE" => "Y",
		"SEF_URL_TEMPLATES" => Array("detail"=>"#SECTION_ID#/#ELEMENT_ID#/","detail_edit"=>"#SECTION_ID#/#ELEMENT_ID#/action/#ACTION#/","detail_list"=>"list/","index"=>"index.php","search"=>"search/","section"=>"#SECTION_ID#/","section_edit"=>"#SECTION_ID#/action/#ACTION#/","section_edit_icon"=>"#SECTION_ID#/icon/action/#ACTION#/","upload"=>"#SECTION_ID#/action/upload/"),
		"SET_TITLE" => "Y",
		"SHOWN_ITEMS_COUNT" => "6",
		"SHOW_LINK_ON_MAIN_PAGE" => array("id","shows","rating","comments"),
		"SHOW_NAVIGATION" => "N",
		"SHOW_TAGS" => "N",
		"THUMBNAIL_SIZE" => "100",
		"UPLOAD_MAX_FILE_SIZE" => "64",
		"USE_COMMENTS" => "N",
		"USE_LIGHT_VIEW" => "Y",
		"USE_RATING" => "N",
		"USE_WATERMARK" => "Y",
		"WATERMARK_MIN_PICTURE_SIZE" => "800",
		"WATERMARK_RULES" => "USER"
	)
);?>
		</div>
	</div>
</div>
 <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>