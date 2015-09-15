<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");



function clear_section ($iblock_id, $section_id) {
    $items_raw = CIBlockElement::GetList(
        Array("SORT" => "ASC"),
        Array("SECTION_ID" => $section_id)
    );
    while ($el = $items_raw->GetNext()) {
        $id = $el["ID"];
        //test_dump($el);
        //echo $id . "<br>";
        CIBlockElement::Delete($id);
    }
}

function add_element ($iblock_id, $section_id, $NAME, $PRICE_EUR, $P) {
    $el = new CIBlockElement;

    //test_dump($P);

    $arFields = array(
        "IBLOCK_ID" => $iblock_id,
        "NAME" => $NAME,
        "CODE" => $P["ARTNUMBER"],
        "ACTIVE" => "Y",
        "IBLOCK_SECTION_ID" => $section_id,
        "DETAIL_TEXT" => "",
        "DETAIL_TEXT_TYPE" => "html",
        "PROPERTY_VALUES" => $P
    );

    if ($last_el_id = $el->Add($arFields))
    {
        echo 'New ID: ' . $last_el_id . '<br>';

        $arFields = array(
            "ID" => $last_el_id,
            "VAT_INCLUDED" => "Y"
        );

        if (CCatalogProduct::Add($arFields))
        {
            echo "Добавили параметры товара к элементу каталога " . $last_el_id . "<br>";

            $arFields = Array(
                "PRODUCT_ID" => $last_el_id,
                "CATALOG_GROUP_ID" => 1,
                "PRICE" => $PRICE_EUR,
                "CURRENCY" => "EUR"
            );

            CPrice::Add($arFields);
        }
        else
            echo "Ошибка добавления параметров товаров";
    }
    else
        echo "Error: " . $el->LAST_ERROR . "<br>";
}

function emptyOrValue($str, $value) {
    if ($str == "")
        return "";
    else
        return $value;
}

function scan_Dir($dir) {
    $arrfiles = array();
    if (is_dir($dir)) {
        if ($handle = opendir($dir)) {
            chdir($dir);
            while (false !== ($r_file = readdir($handle))) {
                if ($r_file != "." && $r_file != "..") {
                    if (is_dir($r_file)) {
                        $arr = scan_Dir($r_file);
                        foreach ($arr as $value) {
                            $arrfiles[] = $dir."/".$value;
                        }
                    } else {
                        $arrfiles[] = $dir."/".$r_file;
                    }
                }
            }
            chdir("../");
        }
        closedir($handle);
    }
    return $arrfiles;
}

function add_elements_from_file($filename, $iblock_id, $section_id, $series_name, $series_title_prefix) {
    $image_files = scan_Dir("images/tb-images");
    chdir("..");
    test_dump($image_files);

    //Получить мощность и IP
    $power_file = file("power_and_ip.csv");
    $power_and_ip = array_map(function ($row1) {
        return explode(';', $row1);
    }, $power_file);
    test_dump($power_file);

    $file = file($filename);
    $e1 = array_map(function ($row2) {
        return explode(';', $row2);
    }, $file);

    $el_count = count($e1);
    test_dump($el_count);

    for ($i = 1; $i < $el_count; $i++) {
        test_dump($i);
        $row = $e1[$i];
        for ($j = 5; $j <= 15; $j++) {
            if ($row[$j] != "") {
                $row[$j] = "Y";
            }
        } //вместо цен ставим "Есть" или "Нет" как бы
        $row[0] = "НЕ НУЖНО";
        $row[3] = "НЕ НУЖНО";
        $row[16] = "НЕ НУЖНО";
        $row[17] = "НЕ НУЖНО";



        unset($row[19]);
        unset($row[20]);
        unset($row[21]);
        unset($row[22]);

        $BRAND_REF="";
        if ($row[1] == "Риттал")
            $BRAND_REF="rittal";
        elseif ($row[1] == "ВЭ")
            $BRAND_REF="ve";

        $TB_SERIES = "";
        if ($series_name == "TL")
            $TB_SERIES = 123;
        elseif ($series_name == "T") {
            $TB_SERIES = 124;
        } elseif ($series_name == "VT") {
            $TB_SERIES = 125;
        }

        $r = explode("+", $row[2]);

        $option = "NONE";
        if (count($r) == 2) {
            $option = $r[1];
            $TB_PANELS="128";
            if (substr_count($option, "оков") > 0) {
                $TB_OPTION="150";
            } elseif (substr_count($option, "лухая") > 0) {
                $TB_OPTION="151";
            } elseif (substr_count($option, "анель") > 0) {
                $TB_OPTION="152";
            }
        }

        $size = explode("x", $r[0]);

        if (count($size) == 3) {
            echo "<p>($size[0], $size[1], $size[2]) + $option <br /></p>";
            $TB_WIDTH=$size[0];
            $TB_HEIGHT=$size[1];
            $TB_DEPTH=$size[2];
        } else
            echo "WRONG SIZE!";

        $PRICE_EUR = str_replace(" ", "", (str_replace("€", "", $row[18])));
        echo  "Цена ($PRICE_EUR) евро<br />\n";

        $w = intval($TB_WIDTH);
        $h = intval($TB_HEIGHT);
        $d = intval($TB_DEPTH);

        $power_ip_count = count($power_and_ip);
        $count = 0;
        $p_row_id = -1;
        for ($k = 0; $k < $power_ip_count; $k++) {
            $p_row = $power_and_ip[$k];
            if ($p_row[1] == $w && $p_row[2] == $h && $p_row[3] == $d) {
                $count++;
                $p_row_id = $k;
            }
        }

        $TP_HEAT_POWER="";
        $TP_IP_CLASS="";

        $series_from_list = explode("-", $power_and_ip[$p_row_id][0])[0];
        test_dump($series_from_list);
        echo "Series: " . $series_name . " = " . $series_from_list . "<br>";

        if ($count == 1 && $series_name == $series_from_list) {
            $TP_HEAT_POWER = $power_and_ip[$p_row_id][4];
            $TP_IP_CLASS = $power_and_ip[$p_row_id][6];
        }

        if ($count == 1)
            echo "count: " . $count . "<br>";
        else
            echo "<h1>count: " . $count . "</h1><br>";

        $NAME = $series_name . "-" . $w / 10 . $h / 10 . $d;

        //$image_prefix = $w . "-" . $h . "-" . $d . " " . $series_name . " ";
        $image_prefix = $w . "-" . $h . "-" . $d . " ";

        $image_count = count($image_files);
        $MORE_PHOTO = Array();
        $MORE_PHOTO_2D = Array();

        for ($k = 0; $k < $image_count; $k++) {
            $image_path = $image_files[$k];
            $image_name = basename($image_path);

            //echo "Image name " . $image_name . "<br>";
            if (0 === strpos($image_name, $image_prefix) && 0 != strpos($image_path, " " . $series_name . " ")) {
                echo "FOUND IMAGE! " . $image_path . "<br>";
                if (strpos($image_name, "3D") != false) {
                    $MORE_PHOTO[] = CFile::MakeFileArray($image_path);
                } else {
                    $MORE_PHOTO_2D[] = CFile::MakeFileArray($image_path);
                }
            }
        }

        foreach ($MORE_PHOTO_2D as $PHOTO) {
            $MORE_PHOTO[] = $PHOTO;
        }


        //test_dump($MORE_PHOTO);

        if ($TP_HEAT_POWER != "") {
            $NAME = $NAME . "-" . $TP_HEAT_POWER;
        }

        echo $NAME . "<br>";

        $P = Array(
            "ARTNUMBER" => $NAME . "(" . rand(1, 10000) . ")",
            "BRAND_REF"=> $BRAND_REF,
            "TB_SERIES"=>$TB_SERIES,
            "TB_WIDTH"=>$TB_WIDTH,
            "TB_HEIGHT"=>$TB_HEIGHT,
            "TB_DEPTH"=>$TB_DEPTH,
            "TB_PANELS"=>$TB_PANELS,
            "TB_DBK_COOL"=>emptyOrValue($row[5], 130),
            "TB_DBK_HEAT"=>emptyOrValue($row[6], 132),
            "TB_RESH"=>emptyOrValue($row[8], 134),
            "TB_FAN"=>emptyOrValue($row[9], 136),
            "TB_FAN_RESH"=>emptyOrValue($row[10], 138),
            "TB_DIN_ROZ"=>emptyOrValue($row[11], 140),
            "TB_DIN_AUTO"=>emptyOrValue($row[12], 1142),
            "TB_KLEMM"=>emptyOrValue($row[13], 144),
            "TB_DIN_METIZ"=>emptyOrValue($row[14], 146),
            "TB_UTEPLITEL"=>emptyOrValue($row[15], 148),
            "TB_OPTION"=>$TB_OPTION,
            "TP_IP_CLASS" => $TP_IP_CLASS,
            "TP_HEAT_POWER" => $TP_HEAT_POWER,
            "MORE_PHOTO" => $MORE_PHOTO
        );

        if ($w * $w + $h * $h + $d * $d != 0) {
            add_element($iblock_id, $section_id, $NAME, $PRICE_EUR, $P);
        } else {
            echo "Не добавлен!<br>";
            echo $w . " " . $h . " " . $d . "<br>";
        }


    }

}

clear_section(4, 17); //Удалить все элементы из серии T
//clear_section(4, 18); //Удалить все элементы из серии VT
//clear_section(4, 19); //Удалить все элементы из серии TL

echo "Очищены разделы каталога T, TL, VT<br>";

add_elements_from_file("seriesT.csv", 4, 17, "T", "Термобокс ");
//add_elements_from_file("seriesTL.csv", 4, 19, "TL", "Термобокс ");
////add_elements_from_file("seriesVT.csv", 4, 18, "VT", "Термобокс ");