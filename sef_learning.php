<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

test_dump($actual_link);

test_dump($_GET);