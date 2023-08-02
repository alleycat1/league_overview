<?php
$t_home = $teams['home']['id'];
$t_away = $teams['away']['id'];
// echo '<pre>';
// print_r($_SERVER);
// echo '</pre>';
$str_id = $config->str_ord($_SERVER['QUERY_STRING']);
?>
<!-- PAGE RELOAD -->
<input type="hidden" id="reload_page" data-element="<?=$str_id?>">
<div id="reload<?=$str_id?>"></div>
<div style="background-color: var(--primary-main); color: var(--neutral-light);" class="rounded-lg my-2 relative justify-between font-bold items-center px-2 py-1 flex">
    <span><?=$lineups[0]['formation']?></span>
    <span>FORMATION</span>
    <span><?=$lineups[1]['formation']?></span>
</div>
<div style="background-color: var(--primary-main);" class="rounded-lg mt-4 relative mylineup">
    <div id="pitch-y"><?=$svg['pitch-y']?></div>
    <div id="pitch-x"><?=$svg['pitch-x']?></div>
    <div class="inset-0 absolute flex players-position">
        <div id="pitch-side-1">
            <div class="line">
                <!-- <a href="./?sec=countries&ref=player&id=<?=$lineups[0]['startXI'][0]['player']['id']?>" title="<?=$lineups[0]['startXI'][0]['player']['name']?>" class="mx-auto flex flex-col text center items-center def" style="width: 90%; max-width: 75px;"> -->
                <a href="./?sec=countries&ref=fixture&id=<?=$fixture_id?>&ref2=match&pg2=lineups&player_stats=<?=$lineups[0]['startXI'][0]['player']['id']?>" title="<?=$lineups[0]['startXI'][0]['player']['name']?>" class="mx-auto flex flex-col text center items-center" style="width: 90%; max-width: 75px;">
                    <span class="relative flex justify-center items-center w-full">
                        <span class="w-full lineup-shirt" style="fill: #0067c3; max-width: 40px;">
                            <span class="others flex items-center">
                                <?php
                                foreach($config->getEventForPlayer($events, $lineups[0]['startXI'][0]['player']['id']) as $data) {
                                    ?>
                                    <span class="<?=$data['class']?>" title="<?=$data['title']?>"><?=$svg[$data['icon']]?></span>
                                    <?php
                                }
                                ?>
                            </span>
                            <?=$svg['jersey']?>
                        </span>
                        <span class="absolute text-black font-bold bg-white rounded-full flex justify-center items-center" style="width: 18px;font-size: 10px; height: 18px;color: #000;"><?=$lineups[0]['startXI'][0]['player']['number']?></span>
                    </span>
                    <span class="hover:underline text-ellipsis w-full player-name truncate" style="background-color: var(--item-bg2);color: #fff;border-radius: 4px;text-align: center; padding: 1px 2px;"><?=$config->getSurName($lineups[0]['startXI'][0]['player']['name'])?></span>
                </a>
            </div>
            <?php
            $lineup_home = $lineups[0];
            $counter = 1;
            foreach(explode('-',$lineup_home['formation']) as $num) {
                ?>
                <div class="line">
                    <?php
                    for($x = 0; $x < intval($num); $x++) {
                        $player_id = $lineup_home['startXI'][$counter]['player']['id'];
                        if(!isset($lineup_home['startXI'][$counter])) continue;
                        ?>
                        <a href="./?sec=countries&ref=fixture&id=<?=$fixture_id?>&ref2=match&pg2=lineups&player_stats=<?=$player_id?>" title="<?=$lineups[0]['startXI'][$counter]['player']['name'];?>" class="mx-auto flex flex-col text center items-center" style="width: 90%; max-width: 75px;">
                            <span class="relative flex justify-center items-center w-full">
                                <span class="w-full lineup-shirt" style="fill: var(--neutral-light); max-width: 40px;">
                                    <span class="others flex items-center">
                                        <?php
                                        foreach($config->getEventForPlayer($events, $player_id) as $data) {
                                            ?>
                                            <span class="<?=$data['class']?>" title="<?=$data['title']?>"><?=$svg[$data['icon']]?></span>
                                            <?php
                                        }
                                        ?>
                                    </span>
                                    <?=$svg['jersey']?>
                                </span>
                                <span class="absolute text-black font-bold bg-white rounded-full flex justify-center items-center" style="width: 18px;font-size: 10px;height: 18px;color: #000;"><?=$lineup_home['startXI'][$counter]['player']['number']?></span>
                            </span>
                            <span class="hover:underline text-ellipsis w-full player-name truncate" style="background-color: var(--item-bg2);color: #fff;border-radius: 4px;text-align: center; padding: 1px 2px;"><?=$config->getSurName($lineups[0]['startXI'][$counter]['player']['name'])?></span>
                        </a>
                        <?php
                        $counter++;
                    }
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="flex-row-reverse" id="pitch-side-2">
            <div class="line">
                <a href="./?sec=countries&ref=fixture&id=<?=$fixture_id?>&ref2=match&pg2=lineups&player_stats=<?=$lineups[1]['startXI'][0]['player']['id']?>" title="<?=$lineups[1]['startXI'][0]['player']['name']?>" class="mx-auto flex flex-col text center items-center" style="width: 90%; max-width: 75px;">
                    <span class="relative flex justify-center items-center w-full">
                        <span class="w-full lineup-shirt" style="fill: #0067c3; max-width: 40px;">
                            <span class="others flex items-center">
                                <?php
                                foreach($config->getEventForPlayer($events, $lineups[1]['startXI'][0]['player']['id']) as $data) {
                                    ?>
                                    <span class="<?=$data['class']?>" title="<?=$data['title']?>"><?=$svg[$data['icon']]?></span>
                                    <?php
                                }
                                ?>
                            </span>
                            <?=$svg['jersey']?>
                        </span>
                        <span class="absolute text-black font-bold bg-white rounded-full flex justify-center items-center" style="width: 18px;font-size: 10px; height: 18px;color: #000;"><?=$lineups[1]['startXI'][0]['player']['number']?></span>
                    </span>
                    <span class="hover:underline text-ellipsis w-full player-name truncate" style="background-color: var(--item-bg2);color: #fff;border-radius: 4px;text-align: center; padding: 1px 2px;"><?=$config->getSurName($lineups[1]['startXI'][0]['player']['name'])?></span>
                </a>
            </div>
            <?php
            $lineup_away = $lineups[1];
            $counter = 1;
            // echo '<span>';
            // print_r($lineup_away);
            // echo '</span>';
            foreach(explode('-',$lineup_away['formation']) as $num) {
                // break;
                ?>
                <div class="line">
                    <?php
                    for($x = 0; $x < intval($num); $x++) {
                        $player_id = $lineup_away['startXI'][$counter]['player']['id'];
                        if(!isset($lineup_away['startXI'][$counter])) continue;
                        ?>
                        <a href="./?sec=countries&ref=fixture&id=<?=$fixture_id?>&ref2=match&pg2=lineups&player_stats=<?=$player_id?>" title="<?=$lineup_away['startXI'][$counter]['player']['name']?>" class="mx-auto flex flex-col text center items-center" style="width: 90%; max-width: 75px;">
                            <span class="relative flex justify-center items-center w-full">
                                <span class="w-full lineup-shirt" style="fill: var(--secondary); max-width: 40px;">
                                    <span class="others flex items-center">
                                        <?php
                                        foreach($config->getEventForPlayer($events, $player_id) as $data) {
                                            ?>
                                            <span class="<?=$data['class']?>" title="<?=$data['title']?>"><?=$svg[$data['icon']]?></span>
                                            <?php
                                        }
                                        ?>
                                    </span>
                                    <?=$svg['jersey']?>
                                </span>
                                <span class="absolute text-black font-bold bg-white rounded-full flex justify-center items-center" style="width: 18px;font-size: 10px; height: 18px;color: #000;"><?=$lineup_away['startXI'][$counter]['player']['number']?></span>
                            </span>
                            <span class="hover:underline text-ellipsis w-full player-name truncate" style="background-color: var(--item-bg2);color: #fff;border-radius: 4px;text-align: center; padding: 1px 2px;"><?=$config->getSurName($lineup_away['startXI'][$counter]['player']['name'])?></span>
                        </a>
                        <?php
                        $counter++;
                    }
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>
<div style="background-color: var(--primary-main); color: var(--neutral-light); padding: 5px;" class="rounded-lg my-2 relative text-center font-bold">
    STARTING LINEUPS
</div>
<?php
for($x = 0; $x < count($lineups[0]['startXI']); $x++) {
    ?>
    <div class="p-2 flex items-center gap-2 text-white font-bold" style="background-color: <?=$x%2 == 0 ? 'transparent' : 'var(--primary-main);'?>">
        <div class="flex-col md:flex-row flex items-start md:items-center md:w-1/2">
            <div class="flex items-center">
                <span class="w-4 md:w-12 hidden"><?=$lineups[0]['startXI'][$x]['player']['number']?></span>
                <img src="<?=$teams['home']['logo']?>" style="width: 20px;" class="mr-2">
                <a href="./?sec=countries&ref=fixture&id=<?=$fixture_id?>&ref2=match&pg2=lineups&player_stats=<?=$lineups[0]['startXI'][$x]['player']['id']?>" class="hover:underline text-xs md:text-base"><?=$lineups[0]['startXI'][$x]['player']['name']?></a>
            </div>
            <div>
                <div class="lineup-shirt">
                    <div class="others flex items-center" style="fill: var(--neutral-light);">
                        <?php
                        foreach($config->getEventForPlayer($events, $lineups[0]['startXI'][$x]['player']['id']) as $data) {
                            ?>
                            <span class="<?=$data['class']?>" title="<?=$data['title']?>"><?=$svg[$data['icon']]?></span>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex-col md:flex-row-reverse flex items-start md:items-center md:w-1/2 ml-auto">
            <div class="flex items-center">
                <a href="./?sec=countries&ref=fixture&id=<?=$fixture_id?>&ref2=match&pg2=lineups&player_stats=<?=$lineups[1]['startXI'][$x]['player']['id']?>" class="ml-auto hover:underline text-xs md:text-base"><?=$lineups[1]['startXI'][$x]['player']['name']?></a>
                <img src="<?=$teams['away']['logo']?>" style="width: 20px;" class="ml-2">
                <span class="w-4 md:w-12 text-right hidden"><?=$lineups[1]['startXI'][$x]['player']['number']?></span>
            </div>
            <div>
                <div class="lineup-shirt">
                    <div class="others flex items-center" style="fill: var(--neutral-light);">
                        <?php
                        foreach($config->getEventForPlayer($events, $lineups[1]['startXI'][$x]['player']['id']) as $data) {
                            ?>
                            <span class="<?=$data['class']?>" title="<?=$data['title']?>"><?=$svg[$data['icon']]?></span>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
<div style="background-color: var(--primary-main); color: var(--neutral-light); padding: 5px;" class="rounded-lg my-2 mt-4 relative text-center font-bold">
    SUBSTITUTES
</div>
<?php
// echo $endpoint;
$st = $lineups[0]['substitutes'] > $lineups[1]['substitutes'] ? $lineups[0]['substitutes'] : $lineups[1]['substitutes'];
for($x = 0; $x < count($st); $x++) {
    ?>
    <div class="p-2 flex items-center gap-2 text-white font-bold" style="background-color: <?=$x%2 == 0 ? 'transparent' : 'var(--primary-main);'?>">
        <?php
        if(isset($lineups[0]['substitutes'][$x])) {
            ?>
            <div class="flex-col md:flex-row flex items-start md:items-center md:w-1/2">
                <div class="flex items-center">
                    <span class="w-4 md:w-12 hidden"><?=$lineups[0]['substitutes'][$x]['player']['number']?></span>
                    <img src="<?=$teams['home']['logo']?>" style="width: 20px;" class="mr-2">
                    <a href="./?sec=countries&ref=fixture&id=<?=$fixture_id?>&ref2=match&pg2=lineups&player_stats=<?=$lineups[0]['substitutes'][$x]['player']['id']?>" class="hover:underline text-xs md:text-base"><?=$lineups[0]['substitutes'][$x]['player']['name']?></a>
                </div>
                <div>
                    <div class="lineup-shirt">
                        <div class="others flex items-center" style="fill: var(--neutral-light);">
                            <?php
                            foreach($config->getEventForPlayer($events, $lineups[0]['substitutes'][$x]['player']['id']) as $data) {
                                ?>
                                <span class="<?=$data['class']?>" title="<?=$data['title']?>"><?=$svg[$data['icon']]?></span>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        if(isset($lineups[1]['substitutes'][$x])) {
            ?>
            <div class="flex-col md:flex-row-reverse flex items-start md:items-center md:w-1/2 ml-auto">
                <div class="flex items-center">
                    <a href="./?sec=countries&ref=fixture&id=<?=$fixture_id?>&ref2=match&pg2=lineups&player_stats=<?=$lineups[1]['substitutes'][$x]['player']['id']?>" class="ml-auto hover:underline text-xs md:text-base"><?=$lineups[1]['substitutes'][$x]['player']['name']?></a>
                    <img src="<?=$teams['away']['logo']?>" style="width: 20px;" class="ml-2">
                    <span class="w-4 md:w-12 text-right hidden"><?=$lineups[1]['substitutes'][$x]['player']['number']?></span>
                </div>
                <div>
                    <div class="lineup-shirt">
                        <div class="others flex items-center" style="fill: var(--neutral-light);">
                            <?php
                            foreach($config->getEventForPlayer($events, $lineups[1]['substitutes'][$x]['player']['id']) as $data) {
                                ?>
                                <span class="<?=$data['class']?>" title="<?=$data['title']?>"><?=$svg[$data['icon']]?></span>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
}
?>
<div style="background-color: var(--primary-main); color: var(--neutral-light); padding: 5px;" class="rounded-lg my-2 mt-4 relative text-center font-bold">
    MISSING PLAYERS
</div>
<!-- <p class="text-3xl text-center py-4">Missing players</p> -->
<?php
// players missing due to injury
$endpoint = "injuries?league=$league_id&season=$season_yr&fixture=$fixture_id";
// echo $endpoint;
$data = json_decode($config->query($endpoint),1);
// print_r($data);
$ij = array('home' => array(), 'away' => array());
foreach($data['response'] as $key => $injury) {
    if($t_home == $injury['team']['id']) $ij['home'][] = $injury;
    if($t_away == $injury['team']['id']) $ij['away'][] = $injury;
}
$count = count($ij['home']) > count($ij['away']) ? count($ij['home']) : count($ij['away']);
// foreach($ij as $key => $injury) {
for($i = 0; $i < $count; $i++) {
    // echo $key."-$t_home == ".$injury['team']['id'] ."<br>";
    ?>
    <div class="p-2 flex items-center gap-2 text-white font-bold" style="background-color: <?=$i%2 == 0 ? 'transparent' : 'var(--primary-main);'?>">
        <?php
        if(isset($ij['home'][$i])) {
            ?>
            <div class="flex-col md:flex-row flex items-start md:items-center md:w-1/2">
                <div class="flex items-center">
                    <img src="<?=$ij['home'][$i]['team']['logo']?>" style="width: 20px;" class="mr-2">
                    <a href="./?sec=countries&ref=fixture&id=<?=$fixture_id?>&ref2=match&pg2=lineups&player_stats=<?=$ij['home'][$i]['player']['id']?>" class="hover:underline text-xs md:text-base flex flex-col">
                        <span><?=$ij['home'][$i]['player']['name']?></span>
                        <span class="text-left font-normal text-md" style="color: var(--neutral-one);"><?=$ij['home'][$i]['player']['reason']?></span>
                    </a>
                </div>
            </div>
            <?php
        }
        if(isset($ij['away'][$i])) {
            ?>
            <div class="flex-col md:flex-row-reverse flex items-start md:items-center md:w-1/2 ml-auto">
                <div class="flex items-center">
                    <a href="./?sec=countries&ref=fixture&id=<?=$fixture_id?>&ref2=match&pg2=lineups&player_stats=<?=$ij['away'][$i]['player']['id']?>" class="ml-auto hover:underline text-xs md:text-base flex flex-col">
                        <span class="text-right"><?=$ij['away'][$i]['player']['name']?></span>
                        <span class="text-right font-normal text-md" style="color: var(--neutral-one);"><?=$ij['away'][$i]['player']['reason']?></span>
                    </a>
                    <img src="<?=$ij['away'][$i]['team']['logo']?>" style="width: 20px;" class="ml-2">
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
}
?>
<div style="background-color: var(--primary-main); color: var(--neutral-light); padding: 5px;" class="rounded-lg my-2 mt-4 relative text-center font-bold">
    COACHES
</div>
<div class="p-2 flex items-center gap-2 text-white font-bold" style="background-color: transparent;">
    <img src="<?=$lineups[0]['coach']['photo']?>" class="w-6">
    <a href="./?sec=countries&ref=coach&id=<?=$lineups[0]['coach']['id']?>" class="hover:underline text-xs md:text-base"><?=$lineups[0]['coach']['name']?></a>
    <a href="./?sec=countries&ref=coach&id=<?=$lineups[1]['coach']['id']?>" class="ml-auto hover:underline text-xs md:text-base"><?=$lineups[1]['coach']['name']?></a>
    <img src="<?=$lineups[1]['coach']['photo']?>" class="w-6">
</div>

<?php
if(isset($_GET['player_stats']) && intval($_GET['player_stats']) > 0) {
    $player_id = intval($_GET['player_stats']);
    $endpoint = "players?id=$player_id&season=$season_yr";
    // echo $endpoint;
    $data = json_decode($config->query($endpoint), 1);
    $player = $data['response'][0]['player'];
    $player_name = $player['firstname'] . ' ' . $player['lastname'];
    $dob = $player['birth']['date'];
    $place = $player['birth']['place'];
    $country_name = $player['nationality'];
    $photo = $player['photo'];
    // print_r($player);
    $statistics = $data['response'][0]['statistics'];
    $team_id = $statistics[0]['team']['id'];
    ?>
    <div style="position: fixed; inset: 0; background: rgba(0, 0, 0, 0.9); z-index: 9999;" id="player_popup">
        <div style="" class="p-4 w-full h-full">
            <div class="mx-auto overflow-hidden flex flex-col rounded-lg" style="max-width: 500px; height: 100%; background-color: var(--primary-bg);box-shadow: 0 0 17px #737373;border: 1px solid #5d5d5d;">
                <div style="flex-grow: 0; background-color: var(--item-bg-dark); position: relative;">
                    <span style="background-color: #ffd7d7; fill: #f00; width: 25px; height: 25px; border: 1px solid #f00; position: absolute; padding: 7px; right: 7px; top: 7px; cursor: pointer;" class="flex items-center justify-center rounded-full" onclick="$('#player_popup')[0].style.display = 'none'; document.body.style.overflow = 'auto';"><img src="files/assets/icons/times.png" /></span>
                    <div class="p-4 flex" style="border-bottom: 1px solid #000;">
                        <div class="w-24 h-24 overflow-hidden bg-white rounded-lg mr-4 flex justify-center items-center">
                            <img src="<?=$photo?>">
                        </div>
                        <div class="flex flex-col items-center">
                            <a href="./?sec=countries&ref=player&id=<?=$player_id?>" class="py-2 font-bold text-2xl underline"><?=$player_name?></a>
                            <p class="font-semibold w-full"><?=$place?></p>
                            <p class="font-semibold w-full">Age: (<?=date('Y')-date('Y', strtotime($dob))?>) - <?=$dob?></p>
                        </div>
                    </div>
                </div>
                <div style="flex-grow: 1; padding: 20px; padding-top: 10px; padding-right: 10px; overflow-y: auto; overflow-x: hidden; height: 100%;" class="flex">
                    <div style="padding-right: 15px; flex-grow: 1;">
                        <p class="text-2xl py-4">Player stats for this match</p>
                        <?php
                        $goal_home = 0;
                        $goal_away = 0;
                        $half = 0;
                        foreach($events as $event) {
                            $team_id = $event['team']['id'];
                            if($event['assist']['id'] != $player_id && $event['player']['id'] != $player_id) continue;
                            if($half == 0 && $event['time']['elapsed'] <= 45) {
                                $fx_score = $config->countGoals(1, $events, $goal_home, $goal_away, $t_home, $t_away);
                                ?>
                                <p style="background-color: var(--primary-two); color: var(--neutral-light);" class="px-3 py-2 rounded-lg flex items-center font-bold my-4">
                                    <span class="mr-2">1ST HALF</span>
                                    <span class="ml-auto"><?=$fx_score[0] . ' - ' . $fx_score[1]?></span>
                                </p>
                                <?php
                                $half = 1;
                            }
                            else if($half == 1 && $event['time']['elapsed'] > 45) {
                                $fx_score = $config->countGoals(2, $events, $fx_score[0], $fx_score[1], $t_home, $t_away);
                                ?>
                                <p style="background-color: var(--primary-two); color: var(--neutral-light);" class="px-3 py-2 rounded-lg flex items-center font-bold my-4">
                                    <span class="mr-2">2ND HALF</span>
                                    <span class="ml-auto"><?=$fx_score[0] . ' - ' . $fx_score[1]?></span>
                                </p>
                                <?php
                                $half = 2;
                            }
                            if(preg_match('/Penalty/i', $event['detail'])) continue;
                            $type = $event['type'];
                            $class = '';
                            $title = '';
                            if($type == 'subst') {
                                $_event = 'Substitution';
                                $icon = 'substitution';
                                $title = $event['time']['elapsed']."' ".$event['player']['name'];
                            }
                            if($type == 'Goal') {
                                $_event = 'Goal';
                                $icon = 'futbol';
                                $title = $event['time']['elapsed']."' ".$event['player']['name'];
                                // $class = 'goal';
                            }
                            if($event['detail'] == 'Yellow Card') {
                                $_event = 'Yellow Card';
                                $icon = 'card';
                                $class = 'card-yellow';
                                $title = $event['time']['elapsed']."' ".$event['player']['name'];
                            }
                            // echo  $event['type'];
                            if($event['type'] == 'Var') {
                                $_event = $event['detail'];
                                $icon = 'var';
                                // $class = 'card-yellow';
                                $title = $event['time']['elapsed']."' ".$event['player']['name'];
                            }
                            if($event['detail'] == 'Red Card') {
                                $_event = 'Red Card';
                                $icon = 'card';
                                $class = 'card-red';
                                $title = $event['time']['elapsed']."' ".$event['player']['name'];
                            }
                            $title .= " ". $event['assist']['name'] != "null" ? " (".$event['assist']['name'].")" : '';
                            $assist = $event['assist']['name'];
                            $time = $event['time']['elapsed'];
                            $time .= $event['time']['extra'] != null ? "+".$event['time']['extra'] : '';
                            ?>
                            <div style="background-color: transparent; fill: var(--neutral-light);" class="flex items-center soccer-icons font-bold">
                                <span class="mr-2" style="width: 35px;"><?=$time?>'</span>
                                <div style="border: 1px solid var(--primary-three); background-color: var(--primary-one); padding: 5px; <?=$type != 'Goal' ? 'display: none;' : ''?>" class="rounded-lg cursor-pointer mx-2 flex items-center gap-2 <?=$class?>" title="<?=$title?>">
                                    <span style="width: 15px; display: none;"><?=$svg[$icon]?></span>
                                    <?php
                                    if($type == 'Goal') {
                                        if($event['team']['id'] == $t_home){
                                            $goal_home++;
                                        }
                                        if($event['team']['id'] == $t_away){
                                            $goal_away++;
                                        }
                                        echo "$goal_home - $goal_away";
                                    }
                                    ?>
                                </div>
                                <span class="mx-1">
                                    <!-- <?=$event['detail']?> -->
                                    <?php
                                    $detail = $event['detail'];
                                    if($event['type'] == 'subst') $detail = 'Substitution';
                                    if($event['type'] == 'Goal') $detail = 'Goal';
                                    ?>
                                    <span style="color: var(--neutral-one); font-100"><?=$detail?></span>
                                </span>
                                <span class="mx-1">
                                    <?php
                                    if($event['assist']['name'] != null) {
                                        if($event['assist']['id'] != $player_id) echo ' - Assist: ('.$event['assist']['name'].')';
                                        else echo ' (Assist)';
                                    }
                                    ?>
                                </span>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="rounded-lg mt-6 mb-2 py-2">
                            <?php
                            $endpoint = "fixtures/players?fixture=$fixture_id";
                            $data = json_decode($config->query($endpoint), 1);
                            // $
                            foreach($data['response'] as $d) {
                                if($team_id == $d['team']['id']) {
                                    $players = $d['players'];
                                    foreach($players as $key => $pl) {
                                        if($player_id == $pl['player']['id']) {
                                            $p_stat = $pl['statistics'][0];
                                            ?>
                                            <table style="border: 1px solid #000; border-bottom: none; border-right: none; width: 100%; background-color: var(--item-bg-dark); margin-bottom: 10px;" cellspacing="0" cellpadding="15">
                                                <tr>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px; width: 80px;">MINUTES</td>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$p_stat['games']['minutes']?></td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px; width: 80px;">NUMBER</td>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$p_stat['games']['number']?></td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px; width: 80px;">POSITION</td>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$p_stat['games']['position']?></td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px; width: 80px;">RATING</td>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$p_stat['games']['rating']?></td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px; width: 80px;">OFFSIDES</td>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$p_stat['offsides']?></td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px; width: 80px;">SHOTS</td>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$p_stat['shots']['total']?></td>
                                                </tr>
                                                <tr>
                                                    <th colspan="2" style="background-color: var(--primary-bg); border: 1px solid #000; border-top: none; border-left: none; padding: 7px;">GOALS</th>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px; width: 80px;">TOTAL</td>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$p_stat['goals']['total']?></td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px; width: 80px;">CONCEDED</td>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$p_stat['goals']['conceded']?></td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px; width: 80px;">ASSISTS</td>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$p_stat['goals']['saves']?></td>
                                                </tr>
                                                <tr>
                                                    <th colspan="2" style="background-color: var(--primary-bg); border: 1px solid #000; border-top: none; border-left: none; padding: 7px;">PASSES</th>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px; width: 80px;">TOTAL</td>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$p_stat['passes']['total']?></td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px; width: 80px;">ACCURACY</td>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$p_stat['passes']['accuracy']?></td>
                                                </tr>
                                                <tr>
                                                    <th colspan="2" style="background-color: var(--primary-bg); border: 1px solid #000; border-top: none; border-left: none; padding: 7px;">CARDS</th>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px; width: 80px;">YELLOW</td>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$p_stat['cards']['yellow']?></td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px; width: 80px;">RED</td>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$p_stat['cards']['red']?></td>
                                                </tr>
                                                <tr>
                                                    <th colspan="2" style="background-color: var(--primary-bg); border: 1px solid #000; border-top: none; border-left: none; padding: 7px;">TACKLES</th>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px; width: 80px;">TOTAL</td>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$p_stat['tackles']['total']?></td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px; width: 80px;">BLOCKS</td>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$p_stat['tackles']['blocks']?></td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px; width: 80px;">INTERCEPTIONS</td>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$p_stat['tackles']['interceptions']?></td>
                                                </tr>
                                                <tr>
                                                    <th colspan="2" style="background-color: var(--primary-bg); border: 1px solid #000; border-top: none; border-left: none; padding: 7px;">FOULS</th>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px; width: 80px;">DRAWN</td>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$p_stat['fouls']['drawn']?></td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px; width: 80px;">COMMITTED</td>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$p_stat['fouls']['committed']?></td>
                                                </tr>
                                                <tr>
                                                    <th colspan="2" style="background-color: var(--primary-bg); border: 1px solid #000; border-top: none; border-left: none; padding: 7px;">PENALTY</th>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px; width: 80px;">WON</td>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$p_stat['penalty']['won']?></td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px; width: 80px;">COMMITED</td>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$p_stat['penalty']['commited']?></td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px; width: 80px;">SCORED</td>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$p_stat['penalty']['scored']?></td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px; width: 80px;">MISSED</td>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$p_stat['penalty']['missed']?></td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px; width: 80px;">SAVED</td>
                                                    <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$p_stat['penalty']['saved']?></td>
                                                </tr>
                                            </table>
                                            <?php
                                        }
                                    }
                                }
                            }
                            // print_r($data);
                            ?>
                        </div>
                        <div class="rounded-lg mt-6 mb-2 py-2 hidden">
                            <p style="color: var(--secondary-one);" class="text-2xl py-4">Player stats for <b><u><?=$league['name']?></u></b></p>
                            <p style="/*border-bottom: 1px dashed var(--primary-two);*/" class="text-lg font-bold pb-2"><?=$teams['home']['name'] . ' - (season '.$league['season'].')'?></p>
                            <?php
                            $endpoint = "players?id=$player_id&team=$team_id&league=".$league['id']."&season=$season_yr";
                            $data = json_decode($config->query($endpoint), 1);
                            if(count($data['response']) > 0 && count($data['response'][0]['statistics']) > 0) {
                                $statistics = $data['response'][0]['statistics'][0];
                                // echo $endpoint;
                                // echo '<pre>';
                                // print_r($statistics);
                                // echo '</pre>';
                                ?>
                                <!-- <table style="border: 1px solid #000; border-bottom: none; border-right: none; width: 100%; background-color: var(--item-bg-dark); margin-bottom: 10px;" cellspacing="0" cellpadding="5">
                                    <tr>
                                        <th colspan="0" style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;">POSITION: Defender</th>
                                    </tr>
                                </table> -->
                                <table style="border: 1px solid #000; border-bottom: none; border-right: none; width: 100%; background-color: var(--item-bg-dark); margin-bottom: 10px;" cellspacing="0" cellpadding="15">
                                    <tr>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px; width: 80px;">RATING</td>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$statistics['games']['rating']?></td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;">APPEARENCES</td>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$statistics['games']['appearences']?></td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;">MINUTES</td>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$statistics['games']['minutes']?></td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;">SHOTS</td>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$statistics['shots']['total']?></td>
                                    </tr>
                                    <tr>
                                        <th colspan="2" style="background-color: var(--primary-bg); border: 1px solid #000; border-top: none; border-left: none; padding: 7px;">SUBSTITUTES</th>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;">IN</td>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$statistics['substitutes']['in']?></td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;">OUT</td>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$statistics['substitutes']['out']?></td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;">BENCH</td>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$statistics['substitutes']['bench']?></td>
                                    </tr>
                                    <tr>
                                        <th colspan="2" style="background-color: var(--primary-bg); border: 1px solid #000; border-top: none; border-left: none; padding: 7px;">GOALS</th>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;">TOTAL</td>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$statistics['goals']['total']?></td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;">CONCEDED</td>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$statistics['goals']['conceded']?></td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;">ASSISTS</td>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$statistics['goals']['assists']?></td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;">SAVES</td>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$statistics['goals']['saves']?></td>
                                    </tr>
                                    <tr>
                                        <th colspan="2" style="background-color: var(--primary-bg); border: 1px solid #000; border-top: none; border-left: none; padding: 7px;">PASSES</th>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;">TOTAL</td>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$statistics['passes']['total']?></td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;">ACCURACY</td>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$statistics['passes']['accuracy']?></td>
                                    </tr>
                                    <tr>
                                        <th colspan="2" style="background-color: var(--primary-bg); border: 1px solid #000; border-top: none; border-left: none; padding: 7px;">CARDS</th>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;">YELLOW</td>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$statistics['cards']['yellow']?></td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;">YELLOWRED</td>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$statistics['cards']['yellowred']?></td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;">RED</td>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$statistics['cards']['red']?></td>
                                    </tr>
                                    <tr>
                                        <th colspan="2" style="background-color: var(--primary-bg); border: 1px solid #000; border-top: none; border-left: none; padding: 7px;">PENALTY</th>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;">WON</td>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$statistics['penalty']['won']?></td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;">COMMITED</td>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$statistics['penalty']['commited']?></td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;">SCORED</td>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$statistics['penalty']['scored']?></td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;">MISSED</td>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$statistics['penalty']['missed']?></td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;">SAVED</td>
                                        <td style="border: 1px solid #000; border-top: none; border-left: none; padding: 7px;"><?=$statistics['penalty']['saved']?></td>
                                    </tr>
                                </table>
                                <?php
                            }
                            else {
                                ?>
                                <p class="rounded-lg flex items-center justify-center text-3xl" style="background-color: var(--item-bg-dark); color: var(--neutral-one); height: 150px;">Stats not found</p>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="hidden md:flex flex-shrink-0 flex-wrap md:flex-nowrap h-full" style="width: 140px;">
                        <div class="px-2 flex-shrink-0 w-full sm:w-1/2">
                            <img src="<?=$teams['home']['logo']?>" />
                            <p class="text-lg pb-2 font-bold"><?=$teams['home']['name']?></p>
                            <?php
                            $players = [];
                            foreach($events as $event) {
                                if($event['team']['id'] != $t_home) continue;
                                if(in_array($event['player']['id'], $players)) continue;
                                $players[] = $event['player']['id'];
                                ?>
                                <a href="./?sec=countries&ref=fixture&id=<?=$fixture_id?>&ref2=match&pg2=lineups&player_stats=<?=$event['player']['id']?>" class="flex flex-col">
                                    <span style="width: 33px; aspect-ratio: 1; overflow: hidden; border-radius: 50%;" class="flex items-center justify-center mx-auto my-2">
                                        <img src="<?=$config->getPlayerPicture($event['player']['id'], $league['season'])?>" style="min-height: 100%; min-width: 120%; width: 100%;" />
                                    </span>
                                    <span class="text-center text-xs" style="color: var(--neutral-one);"><?=$event['player']['name']?></span>
                                </a>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="px-2 w-full sm:w-1/2 flex-shrink-0">
                            <img src="<?=$teams['away']['logo']?>" />
                            <p class="text-lg pb-2 font-bold"><?=$teams['away']['name']?></p>
                            <?php
                            $players = [];
                            foreach($events as $event) {
                                if($event['team']['id'] != $t_away) continue;
                                if(in_array($event['player']['id'], $players)) continue;
                                $players[] = $event['player']['id'];
                                ?>
                                <a href="./?sec=countries&ref=fixture&id=<?=$fixture_id?>&ref2=match&pg2=lineups&player_stats=<?=$event['player']['id']?>" class="flex flex-col">
                                    <span style="width: 33px; aspect-ratio: 1; overflow: hidden; border-radius: 50%;" class="flex items-center justify-center mx-auto my-2">
                                        <img src="<?=$config->getPlayerPicture($event['player']['id'], $league['season'])?>" style="min-height: 100%; min-width: 120%; width: 100%;" />
                                    </span>
                                    <span class="text-center text-xs" style="color: var(--neutral-one);"><?=$event['player']['name']?></span>
                                </a>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
