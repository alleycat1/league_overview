<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


foreach($fixtures['response'] as $data) {
    $country = $data['country'];
    $league = $data['leagues'][0]['name'];
    $logo = $data['leagues'][0]['fixtures'][0]['league']['logo'];
    $league_id = $data['leagues'][0]['fixtures'][0]['league']['id'];
    ?>
    <section class="flex items-center flex flex-col league-container">
        <div class="label flex w-full items-center">
            <div class="icon hidden"><?=$svg['star-outline']?></div>
            <img src="<?=$logo?>" class="mr-3" />
            <p class="title flex-grow md:font-semibold text-sm md:text-md"><?=$country . ': ' . $league?></p>
            <a href="./?sec=countries&ref=league&league=<?=$league_id?>&ref2=standings" class="underline text-sm" style="color: var(--neutral-one);">Standings</a>
            <div class="arrow-icons relative flex items-center justify-center active flex-shrink-0">
                <span class="absolute"><?=$svg['angle-up']?></span>
                <span class="absolute"><?=$svg['angle-down']?></span>
            </div>
        </div>
        <div class="data mb-4 w-full">
            <?php
            foreach($data['leagues'] as $x) {
                foreach($x['fixtures'] as $key => $fixture){
                    // $__fixtures = $fixture['fixtures'];
                    if(!isset($fixture['teams']) && !is_array($fixture)) $fixture = $x['fixtures'];
                    else if(!isset($fixture['teams'])) $fixture = $fixture['fixtures'];
                    $sc = $fixture['score'];
                    $score_home = $fixture['goals']['home'];
                    $score_away = $fixture['goals']['away'];
                    // if($score_home == 0) $score_home = $sc['fulltime']['home'];
                    // if($score_away == 0) $score_away = $sc['fulltime']['away'];
                    
                    $match_status = $fixture['fixture']['status']['long'];
                    $status = $fixture['fixture']['status'];
                    $min = $status['elapsed'];
                    ?>
                    <a href="./?sec=countries&ref=fixture&id=<?=$fixture['fixture']['id']?>" class="item fixture" data-id="<?=$fixture['fixture']['id']?>">
                        <span class="flex items-center m-4">
                            <span class="live-match w-16 md:w-32 flex-shrink-0 flex justify-center items-center font-semibold mr-2" style="color: var(--neutral-one);">
                                <span style="color: var(--secondary-one);">
                                    <?php
                                    // $status['elapsed'];
                                    if ($status['short'] == "HT")
                                        $txt = "HT";
                                    else if ($status['short'] == "FT")
                                        $txt = "FT";
                                    else if (intval($min) > 0)
                                        $txt = $min;
                                    echo $txt;   
                                    ?>
                                </span>
                                <span class="tick" style="color: var(--secondary-one);">'</span>
                            </span>
                            <span class="flex-grow flex flex-col">
                                <span class="flex items-center pb-1" data-id="<?=$fixture['teams']['home']['id']?>">
                                    <p><?=$fixture['teams']['home']['name']?></p>
                                    <span class="ml-auto w-4 md:w-8 flex items-center justify-center font-bold" style="color: var(--secondary-one)"></span>
                                    <span class="w-4 md:w-8 flex items-center justify-center"><?=!$score_home ? '0' : $score_home?></span>
                                    <span class="w-4 md:w-8 flex items-center justify-center">
                                        <span class="w-4 md:w-8 flex items-center justify-center hidden" style="color: var(--neutral-one);">
                                            <?php
                                            echo "(".$fixture['score']['halftime']['home'].")";
                                            ?>
                                        </span>
                                    </span>
                                </span>
                                <span class="flex items-center pb-1" data-id="<?=$fixture['teams']['away']['id']?>">
                                    <p><?=$fixture['teams']['away']['name']?></p>
                                    <span class="ml-auto w-4 md:w-8 flex items-center justify-center font-bold" style="color: var(--secondary-one)"></span>
                                    <span class="w-4 md:w-8 flex items-center justify-center"><?=!$score_away ? '0' : $score_away?></span>
                                    <span class="w-4 md:w-8 flex items-center justify-center">
                                        <span class="w-4 md:w-8 flex items-center justify-center hidden" style="color: var(--neutral-one);">
                                            <?php
                                            echo "(".$fixture['score']['halftime']['away'].")";
                                            ?>
                                        </span>
                                    </span>
                                </span>
                            </span>
                            <span class="w-10 md:w-24 flex items-center justify-center">
                                <span style="" class="w-8"><?=$svg['shirt-solid']?></span>
                            </span>
                        </span>
                    </a>
                    <?php
                }
            }
            ?>
        </div>
    </section>
    <?php
}


$fixtures = $config->leagues(json_encode($sorted[1]));

//$fixtures = $fixtures;

$counter = 0;
foreach($fixtures['response'] as $data) {
    $country = $data['country'];
    foreach($data['leagues'] as $league) {
        $league_name = $league['name'];
        $logo = $league['fixtures'][0]['league']['logo'];
        $league_id = $league['fixtures'][0]['league']['id'];
        ?>
        <section class="flex items-center flex flex-col league-container">
            <div class="label flex w-full items-center">
                <div class="icon hidden"><?=$svg['star-outline']?></div>
                <img src="<?=$logo?>" class="mr-3" />
                <p class="title flex-grow md:font-semibold text-sm md:text-md"><?=$country . ': ' . $league_name?></p>
                <a href="./?sec=countries&ref=league&league=<?=$league_id?>&ref2=standings" class="underline text-sm" style="color: var(--neutral-one);">Standings</a>
                <div class="arrow-icons relative flex items-center flex-shrink-0 justify-center <?=$counter < 2 ? 'active' : ''?>">
                    <span class="absolute"><?=$svg['angle-up']?></span>
                    <span class="absolute"><?=$svg['angle-down']?></span>
                </div>
            </div>
            <div class="data mb-4 w-full <?=$counter < 100 ? '' : 'hidden'?>">
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
                    $status = $fixture['fixture']['status'];
                    $min = $status['elapsed'];
                    ?>
                    <a href="./?sec=countries&ref=fixture&id=<?=$fixture['fixture']['id']?>" class="item fixture" data-id="<?=$fixture['fixture']['id']?>">
                        <span class="flex items-center m-4">
                            <span class="live-match w-16 md:w-32 flex-shrink-0 flex justify-center items-center font-semibold" style="color: var(--neutral-one);">
                                <span style="color: var(--secondary-one);">
                                <?php
                                // $status['elapsed'];
                                if ($status['short'] == "HT")
                                    $txt = "HT";
                                else if ($status['short'] == "FT")
                                    $txt = "FT";
                                else if (intval($min) > 0)
                                    $txt = $min;
                                echo $txt;   
                                ?>
                                </span>
                                <span class="tick" style="color: var(--secondary-one);">'</span>
                            </span>
                            <span class="flex-grow flex flex-col">
                                <span class="flex items-center pb-1" data-id="<?=$fixture['teams']['home']['id']?>">
                                    <p><?=$fixture['teams']['home']['name']?></p>
                                    <span class="ml-auto w-4 md:w-8 flex items-center justify-center font-bold" style="color: var(--secondary-one)"></span>
                                    <span class="w-4 md:w-8 flex items-center justify-center"><?=!$score_home ? '0' : $score_home?></span>
                                    <span class="w-4 md:w-8 flex items-center justify-center hidden" style="color: var(--neutral-one);">
                                        <?php
                                        echo "(".$fixture['score']['halftime']['home'].")";
                                        ?>
                                    </span>
                                </span>
                                <span class="flex items-center pb-1" data-id="<?=$fixture['teams']['away']['id']?>">
                                    <p><?=$fixture['teams']['away']['name']?></p>
                                    <span class="ml-auto w-4 md:w-8 flex items-center justify-center font-bold" style="color: var(--secondary-one)"></span>
                                    <span class="w-4 md:w-8 flex items-center justify-center"><?=!$score_away ? '0' : $score_away?></span>
                                    <span class="w-4 md:w-8 flex items-center justify-center hidden" style="color: var(--neutral-one);">
                                        <?php
                                        echo "(".$fixture['score']['halftime']['away'].")";
                                        ?>
                                    </span>
                                </span>
                            </span>
                            <span class="w-10 md:w-24 flex items-center justify-center">
                                <span style="" class="w-4 md:w-8"><?=$svg['shirt-solid']?></span>
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