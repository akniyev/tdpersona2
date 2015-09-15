<?
if($_GET["shmeall"] == "cathay"){
	error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
	ini_set("display_errors", 1);
}

function test_dump($v) {
	global $USER;
	if ($USER -> isAdmin()) {
		echo "<pre>";
		var_dump($v);
		echo "</pre>";
	}
}
