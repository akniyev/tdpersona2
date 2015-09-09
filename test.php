<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Интернет-магазин \"Сантехники +\"");
?>

<h1>Hello, world!</h1>

<?php
    $el = new CIBlockElement;
    //$el->Update("1043", Array("NAME" => "MYCHANGE"));
    $res2 = $el->Add(Array(
        "IBLOCK_ID" => 4,
        "NAME" => "ADDED FROM PHP2",
        "CODE" => "php_product" . rand(1, 10000),
        "IBLOCK_SECTION_ID" => 19,
        "DETAIL_TEXT" => "asdf",
        "DETAIL_TEXT_TYPE" => "html",
        "PROPERTY_VALUES" => Array(
            "BRAND_REF" => "1marka",
            "TB_WIDTH" => 5000,
            "TB_UTEPLITEL" => 148
        )

    ));
    echo "res:<br> ";
    var_dump($res2);
    echo "Error: ".$el->LAST_ERROR;;

    $res = CIBlockElement::GetList (
        Array(),
        Array("IBLOCK_ID"=>4),
        false,
        Array (),
        Array("ID", "NAME")
    );

    while($ob = $res->GetNextElement())
    {
        $arFields = $ob->GetFields();
        echo "<h1>" . $arFields["NAME"] . "</h1>n<br>";
        print_r($arFields);
        echo "<br>";
    }

    //$cElement = new CIBlockElement;

    //$count = CIBlockElement::GetCount();
    //echo $count + "<br>";
    //echo CIBLockElement::Add(Array("IBLOCK_ID"=>4, "NAME"=>"TEST NAME"))

    //print_r($res)
?>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
