<?php
$navSelectedDate = isset($_GET['date']) ? $_GET['date'] : '';
$navPageList = 1;
$page = 1;
$displayCount = 38;
$league_name = '';
if(isset($_GET['page'])) $page = intval($_GET['page']);
foreach($fixtures['response'] as $data) {
    if($page > 1) break;
    $country = $data['country'];
    ?>
    <section class="flex items-center flex flex-col league-container">
        <?php
        foreach($data['leagues'] as $x) {
            $logo = $x['fixtures'][0]['league']['logo'];
            $league_id = $x['fixtures'][0]['league']['id'];
            if($league_name != $x['name']) {
                $league_name = $x['name'];
                ?>
                <div class="label flex w-full items-center">
                    <div class="icon hidden"><?=$svg['star-outline']?></div>
                    <img src="<?=$config->getLeagueLogo($logo)?>" class="mr-3 rounded-sm league-logo-home" />
                    <p class="title league-title-home flex-grow md:font-semibold text-sm md:text-md"><?=$country . ': ' . $league_name?></p>
                    <a href="./?sec=countries&ref=league&league=<?=$league_id?>&ref2=standings" class="underline text-sm" style="color: var(--neutral-one);">Standings</a>
                    <div class="arrow-icons relative flex items-center justify-center active flex-shrink-0">
                        <span class="absolute"><?=$svg['angle-up']?></span>
                        <span class="absolute"><?=$svg['angle-down']?></span>
                    </div>
                </div>
                <?php
            }
            ?>
            <div class="data mb-4 w-full">
                <?php
                foreach($x['fixtures'] as $key => $fixture) {
                    // $__fixtures = $fixture['fixtures'];
                    if(!isset($fixture['teams']) && !is_array($fixture)) $fixture = $x['fixtures'];
                    else if(!isset($fixture['teams'])) $fixture = $fixture['fixtures'];
                    $sc = $fixture['score'];
                    $score_home = $fixture['goals']['home'];
                    $score_away = $fixture['goals']['away'];
                    $elapsed = $fixture['fixture']['status']['elapsed'];
                    // if($score_home == 0) $score_home = $sc['fulltime']['home'];
                    // if($score_away == 0) $score_away = $sc['fulltime']['away'];
                    
                    $match_status = $fixture['fixture']['status']['long'];
                    $s_short = $fixture['fixture']['status']['short'];
                    ?>
                    <a href="./?sec=countries&ref=fixture&id=<?=$fixture['fixture']['id']?>" class="item fixture" data-id="<?=$fixture['fixture']['id']?>">
                        <span class="flex items-center m-4">
                            <span class="live-match w-16 md:w-32 flex-shrink-0 flex justify-center items-center font-semibold mr-2" style="color: var(--neutral-one); cursor: pointer;" title="<?=$match_status?>">
                                <span class="text-center">
                                    <?php
                                    if($match_status == 'Not Started' && date('Y-m-d') == date('Y-m-d', strtotime($fixture['fixture']['date']))) echo  date('H:i', strtotime($fixture['fixture']['date']));
                                    else {
                                        if($s_short == 'CANC') echo  'CANX';
                                        else if($s_short == 'PST') echo  'PP';
                                        else if($s_short == 'TBD') echo  'TBC';
                                        else if($s_short == 'NS') {
                                            echo '<span style="color: var(--secondary-one);">' . date("H:s", strtotime($fixture['fixture']['date'])) . '</span>';
                                        }
                                        else if(($elapsed < 45 || $elapsed <= 90) && $s_short != 'FT') {
                                            echo '<span style="color: var(--secondary-one);">'.$elapsed.'</span>';
                                        }
                                        else echo $s_short;
                                    }
                                    ?>
                                </span>
                                <span class="tick" style="display: none;">'</span>
                            </span>
                            <span class="flex-grow flex flex-col">
                                <span class="flex items-center pb-1" data-id="<?=$fixture['teams']['home']['id']?>">
                                    <p><?=$fixture['teams']['home']['name']?></p>
                                    <span class="ml-auto w-4 md:w-8 flex items-center justify-center"></span>
                                    <span class="w-4 md:w-8 flex items-center justify-center" style="color: var(--secondary-one)"><?=!$score_home ? '0' : $score_home?></span>
                                    <span class="w-4 md:w-8 flex items-center justify-center hidden">
                                        <span class="w-4 md:w-8 flex items-center justify-center hidden" style="color: var(--neutral-one);">
                                            <?php
                                            $x = $fixture['score']['halftime']['home'] ? $fixture['score']['halftime']['home'] : 0;
                                            echo "(". $x .")";
                                            ?>
                                        </span>
                                    </span>
                                </span>
                                <span class="flex items-center pb-1" data-id="<?=$fixture['teams']['away']['id']?>">
                                    <p><?=$fixture['teams']['away']['name']?></p>
                                    <span class="ml-auto w-4 md:w-8 flex items-center justify-center"></span>
                                    <span class="w-4 md:w-8 flex items-center justify-center" style="color: var(--secondary-one)"><?=!$score_away ? '0' : $score_away?></span>
                                    <span class="w-4 md:w-8 flex items-center justify-center hidden">
                                        <span class="w-4 md:w-8 flex items-center justify-center hidden" style="color: var(--neutral-one);">
                                            <?php
                                            $x = $fixture['score']['halftime']['away'] ? $fixture['score']['halftime']['away'] : 0;
                                            echo "(".$x.")";
                                            ?>
                                        </span>
                                    </span>
                                </span>
                            </span>
                            <span class="w-10 md:w-24 flex items-center justify-center">
                                <span style="fill: var(--secondary);" class="w-6"><?=$svg['jersey']?></span>
                            </span>
                        </span>
                    </a>
                    <?php
                }
                ?>
            </div>
            <?php
        }
        ?>
    </section>
    <?php
}
$fixtures = $config->leagues(json_encode($sorted[1]));

// print_r();
// $fixtures = $fixtures;
// $config->getLeagueLogo('https://media.api-sports.io/football/leagues/378.png');
$counter = 0;
foreach($fixtures['response'] as $key => $data) {
    ###### ALL LEAGUES
    // break;
    // echo $key;
    // echo '<br>';
    if($page > 1 && $key < $displayCount * ($page - 1)) continue;
    if($key == $displayCount * $page) break;
    $country = $data['country'];

    foreach($data['leagues'] as $league) {
        $league_name = $league['name'];
        $logo = $league['fixtures'][0]['league']['logo'];
        $league_id = $league['id'];
        ?>
        <section class="flex items-center flex flex-col league-container">
            <div class="label flex w-full items-center">
                <div class="icon hidden"><?=$svg['star-outline']?></div>
                <img src="<?=$config->getLeagueLogo($logo)?>" class="mr-3 rounded-sm league-logo-home" />
                <p class="title league-title-home flex-grow md:font-semibold text-sm md:text-md"><?=$country . ': ' . $league_name?></p>
                <a href="./?sec=countries&ref=league&league=<?=$league_id?>&ref2=standings" class="underline text-sm" style="color: var(--neutral-one);">Standings</a>
                <div class="arrow-icons relative flex items-center flex-shrink-0 justify-center <?=$counter < 2 ? 'active' : ''?>">
                    <span class="absolute"><?=$svg['angle-up']?></span>
                    <span class="absolute"><?=$svg['angle-down']?></span>
                </div>
            </div>
            <div class="data mb-4 w-full <?=$counter < 2 ? '' : 'hidden'?>">
                <?php
                foreach($league['fixtures'] as $key => $fixture){
                    // $__fixtures = $fixture['fixtures'];
                    if(!isset($fixture['teams']) && !is_array($fixture)) $fixture = $x['fixtures'];
                    else if(!isset($fixture['teams'])) $fixture = $fixture['fixtures'];
                    $sc = $fixture['score'];
                    $score_home = $fixture['goals']['home'];
                    $score_away = $fixture['goals']['away'];
                    // if($score_home == 0) $score_home = $sc['fulltime']['home'];
                    // if($score_away == 0) $score_away = $sc['fulltime']['away'];

                    $match_status = $fixture['fixture']['status']['long'];
                    $s_short = $fixture['fixture']['status']['short'];
                    ?>
                    <a href="./?sec=countries&ref=fixture&id=<?=$fixture['fixture']['id']?>" class="item fixture" data-id="<?=$fixture['fixture']['id']?>">
                        <span class="flex items-center m-4">
                            <span class="live-match w-16 md:w-32 flex-shrink-0 flex justify-center items-center font-semibold" style="color: var(--neutral-one);">
                                <span class="text-center">
                                    <?php
                                    // $match_status
                                    if($match_status == 'Not Started' && date('Y-m-d') == date('Y-m-d', strtotime($fixture['fixture']['date']))) echo  date('H:i', strtotime($fixture['fixture']['date']));
                                    else {
                                        if($s_short == 'CANC') echo  'CANX';
                                        else if($s_short == 'PST') echo  'PP';
                                        else if($s_short == 'TBD') echo  'TBC';
                                        else if($s_short == 'NS') {
                                            echo '<span style="color: var(--secondary-one);">' . date("H:s", strtotime($fixture['fixture']['date'])) . '</span>';
                                        }
                                        else if($s_short == 'FT') {
                                            // if(date('Y-m-d') != date('Y-m-d', strtotime($fixture['fixture']['date']))) {
                                            //     echo date('d.m.y', strtotime($fixture['fixture']['date']));
                                            //     echo '<br>';
                                            // }
                                            echo $s_short;
                                        }
                                        else if(($fixture['fixture']['status']['elapsed'] < 45 && $fixture['fixture']['status']['elapsed'] <= 90) && $s_short != 'FT') {
                                            echo '<span style="color: var(--secondary-one);">'.$fixture['fixture']['status']['elapsed'].'</span>';
                                        }
                                        else echo $s_short;
                                    }
                                    ?>
                                </span>
                                <span class="tick" style="display: none;">'</span>
                            </span>
                            <span class="flex-grow flex flex-col">
                                <span class="flex items-center pb-1" data-id="<?=$fixture['teams']['home']['id']?>">
                                    <p><?=$fixture['teams']['home']['name']?></p>
                                    <span class="ml-auto w-4 md:w-8 flex items-center justify-center"></span>
                                    <span class="w-4 md:w-8 flex items-center justify-center" style="color: var(--secondary-one)"><?=!$score_home ? '0' : $score_home?></span>
                                    <span class="w-4 md:w-8 flex items-center justify-center hidden">
                                        <span class="w-4 md:w-8 flex items-center justify-center hidden" style="color: var(--neutral-one);">
                                            <?php
                                            $x = $fixture['score']['halftime']['home'] ? $fixture['score']['halftime']['home'] : 0;
                                            echo "(".$x.")";
                                            ?>
                                        </span>
                                    </span>
                                </span>
                                <span class="flex items-center pb-1" data-id="<?=$fixture['teams']['away']['id']?>">
                                    <p><?=$fixture['teams']['away']['name']?></p>
                                    <span class="ml-auto w-4 md:w-8 flex items-center justify-center"></span>
                                    <span class="w-4 md:w-8 flex items-center justify-center" style="color: var(--secondary-one)"><?=!$score_away ? '0' : $score_away?></span>
                                    <span class="w-4 md:w-8 flex items-center justify-center hidden">
                                        <span class="w-4 md:w-8 flex items-center justify-center hidden" style="color: var(--neutral-one);">
                                            <?php
                                            $x = $fixture['score']['halftime']['away'] ? $fixture['score']['halftime']['away'] : 0;
                                            echo "(".$x.")";
                                            ?>
                                        </span>
                                    </span>
                                </span>
                            </span>
                            <span class="w-10 md:w-24 flex items-center justify-center">
                                <span style="fill: var(--secondary);" class="w-6"><?=$svg['jersey']?></span>
                            </span>
                        </span>
                    </a>
                    <?php
                }
                ?>
            </div>
        </section>
        <?php
    }
    $counter++;
}
?>
<div class="hidden flex items-center justify-center pt-3">
    <?php
    $link = "./?date=".$navSelectedDate."&";
    if($navSelectedDate == '') $link = './?';
    $a = floor(count($fixtures['response']) / $displayCount);
    if($a > 0) {
        for($i = 0; $i <= $a; $i++) {
            ?>
            <a href="<?=$link?>page=<?=$i+1?>" class="flex items-center justify-center" style="<?=$page == $i+1 ? 'background-color: #fff; color: #000;' : 'background-color: #000; color: #fff;'?> padding: 5px; width: 18px; height: 18px; border-radius: 50%; margin-right: 3px"><?=$i+1?></a>
            <?php
        }
    }
    ?>
</div>