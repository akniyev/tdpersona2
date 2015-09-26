<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if ($arResult == null):?>
<div id="content">
  <div class="c1">
    <div class="content-text-inner">
		<h1 style="color:red; font-weight:bold; margin-bottom: 20px; width:100%; text-align:center;">
			Извините! Данный раздел временно недоступен!
		</h1>
    </div>
  </div>
</div>
<?else:?>
<div id="content">
  <div class="c1">
    <div class="content-text-inner">
		<h2 style="margin-bottom: 20px;width:100%;text-align:right;;"><?=$arResult["PROPERTIES"]["SECTION"]["VALUE"]?></h2>
   		<h1><?=$arResult["NAME"]?></h1>

      <?=$arResult["PREVIEW_TEXT"]?>
    </div>
  </div>
</div>
<div id="sidebar">
  <ul class="side-menu">
    <?
    $cat = $prevCat = "";
    foreach($arResult["SIDEBAR"] as $sidebar):
      $cat = $sidebar["SECTION"];
      if($cat != $prevCat):
        if($prevCat != ""):?>
            </ul>
          </li>
        <?endif?>
        <li>
          <h3><?=$cat?></h3>
          <ul>
      <?endif?>
			<?/*<li><a href="<?=$sidebar["URL"]?>"><?=$sidebar["NAME"]?></a></li>*/?>
			<?if (strtoupper($sidebar["NAME"]) == "СОТРУДНИКИ"):?>
			<li><a href="/about/staff/"><?=$sidebar["NAME"]?></a></li>
			<?else:?>
			<li><a href="<?=$sidebar["URL"]?>/"><?=$sidebar["NAME"]?></a></li>
			<?endif?>
      <?$prevCat = $cat;?>
    <?endforeach;?>
  </ul>
</div>
<?endif?>