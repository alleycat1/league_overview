<div style="background-color: var(--primary-main); color: var(--neutral-light);" class="rounded-lg my-2 relative justify-between font-bold items-center px-2 py-1 flex">
    LAST MATCHES
</div>
<?php
$endpoint = 'fixtures/headtohead?h2h='.$teams['home']['id'].'-'.$teams['away']['id'];
// echo $endpoint;
$data = json_decode($config->query($endpoint), 1);
$response = $data['response'];

$dates = [];
foreach($response as $r) {
    $dates[] = strtotime($r['fixture']['date']) . '-' . $r['fixture']['id'];
}
asort($dates);
$response = $config->sortH2H($response, $dates);
// echo '<pre>';
// print_r($response);
// echo '</pre>';

$hm = '';
for($x = count($response)-1; $x >= 0; $x--) {
    $d = $response[$x];
    $_fixture = $d['fixture'];
    if($hm == '') $hm = $d['teams']['home']['id'];
    ?>
    <a href="./?sec=countries&ref=fixture&id=<?=$_fixture['id']?>" style="background-color: transparent; border-bottom: 1px solid var(--primary-two); border-radius: 0;" class="py-3 px-2 flex items-center">
        <span class="mr-2 text-center" style="width: 45px;"><?=date('d.m.y', strtotime($_fixture['date']))?></span>
        <span class="flex items-center flex-shrink-0 w-16" style="/*width: 85px;*/">
            <img src="<?=$d['league']['logo']?>" class="w-6 mr-2">
            <?=$config->getLeagueInitials($d['league']['name'])?>
        </span>
        <span class="flex-grow flex flex-col">
            <span class="flex items-center">
                <span style="<?=$hm == $d['teams']['home']['id'] ? 'background-color: #003461;' : ''?>; padding: 1px 3px; border-radius: 4px; display: inline-block;"><?=$d['teams']['home']['name']?></span>
                <span class="ml-auto w-4"><?=$d['goals']['home']?></span>
            </span>
            <span class="flex items-center">
                <span style="<?=$hm == $d['teams']['away']['id'] ? 'background-color: #003461;' : ''?>; padding: 1px 3px; border-radius: 4px; display: inline-block;"><?=$d['teams']['away']['name']?></span>
                <span class="ml-auto w-4"><?=$d['goals']['away']?></span>
            </span>
        </span>
        <span style="width: 60px;" class="flex justify-center items-center">
            <?php
            $letter = '';
            $color = 'transparent';
            if($_fixture['status']['short'] == 'FT') {
                if($hm == $d['teams']['home']['id']) {
                    if($d['goals']['home'] < $d['goals']['away']) {
                        $color = '#f00';
                        $title = 'Lose';
                        $letter = 'L';
                    }
                    else if($d['goals']['home'] == $d['goals']['away']) {
                        $color = '#f3a000';
                        $title = 'Draw';
                        $letter = 'D';
                    }
                    else if($d['goals']['home'] > $d['goals']['away']) {
                        $color = '#00a83f';
                        $title = 'Win';
                        $letter = 'W';
                    }
                }
                else {
                    if($d['goals']['away'] < $d['goals']['home']) {
                        $color = '#f00';
                        $title = 'Lose';
                        $letter = 'L';
                    }
                    else if($d['goals']['away'] == $d['goals']['home']) {
                        $color = '#f3a000';
                        $title = 'Draw';
                        $letter = 'D';
                    }
                    else if($d['goals']['away'] > $d['goals']['home']) {
                        $color = '#00a83f';
                        $title = 'Win';
                        $letter = 'W';
                    }
                }
            }
            ?>
            <span class="flex items-center justify-center font-bold rounded-md flex-shrink-0" style="font-size: 11px; height: 16px; width: 18px; cursor: default; background-color: <?=$color?>;" title="<?=$title?>"><?=$letter?></span>
        </span>
    </a>
    <?php
}
