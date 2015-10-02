<?
if($_GET["shmeall"] == "cathay"){
	error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
	ini_set("display_errors", 1);
}

define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"] . "/log.txt");

function test_dump($v) {
	global $USER;
	if ($USER -> isAdmin()) {
		echo "<pre>";
		var_dump($v);
		echo "</pre>";
	}
}
