<?php
for($x = 0; $x < count($statistics[0]['statistics']); $x++) {
    // foreach($statistics[0] as $key => $value) {
    $home = $statistics[0]['statistics'];
    $away = $statistics[1]['statistics'];
    $home_value = intval(preg_replace('/[^0-9]/', '',$home[$x]['value']));
    $away_value = intval(preg_replace('/[^0-9]/', '',$away[$x]['value']));
    $total = $home_value + $away_value;
    $title = $home[$x]['type'];
    $home_pct = $home_value > 0 ? ($home_value / $total) * 100 : 0;
    $away_pct = $away_value > 0 ? ($away_value / $total) * 100 : 0;
    if($title == 'expected_goals') continue;
    ?>
    <div class="flex flex-col font-bold py-2 px-1 text-white">
        <div class="flex justify-between">
            <span><?=$home_value?></span>
            <span><?=$title?></span>
            <span><?=$away_value?></span>
        </div>
        <div style="background-color: var(--primary-main); border-radius: 4px; height: 10px;" class="justify-center flex mt-2 max-w-full">
            <div style="width: 50%;" class="flex justify-end">
                <div style="border-right: 1px solid var(--primary-main);background-color: var(--neutral-light);width: <?=$home_pct?>%;height: 100%;border-top-left-radius: 4px;border-bottom-left-radius: 4px;"></div>
            </div>
            <div style="width: 50%;" class="flex justify-start">
                <div style="border-left: 1px solid var(--primary-main); background-color: var(--secondary); width: <?=$away_pct?>%; height: 100%; border-top-right-radius: 4px;border-bottom-right-radius: 4px;"></div>
            </div>
        </div>
    </div>
    <?php
}
$str_id = $config->str_ord($_SERVER['QUERY_STRING']);
?>
<input type="hidden" id="reload_page" data-element="<?=$str_id?>">
<div id="reload<?=$str_id?>"></div>