<?php
// default page for the entire website in case there's a broken link
// THE HOME PAGE
?>
<main class="flex mx-auto wd">
    <div class="left flex flex-col flex-shrink-0">
        <div><?php require './football/left-nav/countries.php'; ?></div>
    </div>
    <div class="flex-grow middle">
        <div>
            <div class="top-nav flex items-center mb-6">
                <nav class="flex items-center nav2-top">
                    <a href="./" class="active">ALL</a>
                </nav>
                <div class="calendar-navigator ml-auto flex relative">
                    <div class="icon flex-shrink-0 flex items-center"><?=$svg['angle-left']?></div>
                    <div class="flex-grow flex items-center dropdown-dates">
                        <div class="icon" style="padding: 5px;"><?=$svg['calendar-alt']?></div>
                        <div>
                            <?php
                            $first_day = date('Y-m-d', strtotime('-7days'));
                            $curr_date = strtoupper(date('d/m D'));
                            $fixture_date = strtotime(date('Y-m-d'));
                            if(isset($_GET['date']) && is_numeric($_GET['date'])) {
                                $fixture_date = $_GET['date'];
                                $curr_date = strtoupper(date('d/m D', $fixture_date));
                            }
                            ?>
                            <span class="font-semibold"><?=$curr_date?></span>
                        </div>
                        <div class="menu flex flex-col">
                            <?php
                            $first_day = date('Y-m-d', strtotime('-7days'));
                            for($x = 0; $x <= 15; $x++) {
                                $date_string = strtotime($first_day . " + $x days");
                                $date = strtoupper(date('d/m D', $date_string));
                                // $dates[] = ;
                                ?>
                                <a href="./?date=<?=$date_string?>" class="<?=$date == $curr_date ? 'active' : ''?>" data-date="<?=$date_string?>"><?=$date?></a>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="icon flex-shrink-0 flex items-center"><?=$svg['angle-right']?></div>
                </div>
            </div>
            <div class="data-table">
                <?php
                $endpoint = 'fixtures?date='.date('Y-m-d', $fixture_date);
                // echo $endpoint;
                $data = $config->query($endpoint);
                if(!is_array($data)) {
                    $sorted = $config->sort_leagues($data);
                    // echo '<pre>';
                    // print_r($sorted[0]);
                    // echo '</pre>';
                    $fixtures = $config->leagues(json_encode($sorted[0]));
                    // $fixtures = $fixtures;
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
                                <p class="title flex-grow font-semibold text-lg"><?=$country . ': ' . $league?></p>
                                <a href="./?sec=countries&ref=league&league=<?=$league_id?>&ref2=standings" class="underline font-semibold" style="color: var(--neutral-one);">Standings</a>
                                <div class="arrow-icons relative flex items-center justify-center active">
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
                                        $score_home = intval($sc['halftime']['home'] + $sc['extratime']['home'] + $sc['penalty']['home']);
                                        $score_away = $sc['halftime']['away'] + $sc['extratime']['away'] + $sc['penalty']['away'];
                                        if($score_home == 0) $score_home = $sc['fulltime']['home'];
                                        if($score_away == 0) $score_away = $sc['fulltime']['away'];

                                        $match_status = $fixture['fixture']['status']['long'];
                                        ?>
                                        <a href="./?sec=countries&ref=fixture&id=<?=$fixture['fixture']['id']?>" class="item">
                                            <span class="flex items-center m-4">
                                                <span class="w-32 flex-shrink-0 flex justify-center items-center font-semibold" style="color: var(--neutral-one);"><?=$match_status?></span>
                                                <span class="flex-grow flex flex-col">
                                                    <span class="flex items-center pb-1">
                                                        <p><?=$fixture['teams']['home']['name']?></p>
                                                        <span class="ml-auto w-8 flex items-center justify-center"><?=!$score_home ? '0' : $score_home?></span>
                                                        <span class="w-8 flex items-center justify-center"></span>
                                                        <span class="w-8 flex items-center justify-center"></span>
                                                    </span>
                                                    <span class="flex items-center pb-1">
                                                        <p><?=$fixture['teams']['away']['name']?></p>
                                                        <span class="ml-auto w-8 flex items-center justify-center"><?=!$score_away ? '0' : $score_away?></span>
                                                        <span class="w-8 flex items-center justify-center"></span>
                                                        <span class="w-8 flex items-center justify-center"></span>
                                                    </span>
                                                </span>
                                                <span class="w-24 flex items-center justify-center">
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
                    // $fixtures = $fixtures;
                    $counter = 0;
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
                                <p class="title flex-grow font-semibold text-lg"><?=$country . ': ' . $league?></p>
                                <a href="./?sec=countries&ref=league&league=<?=$league_id?>&ref2=standings" class="underline font-semibold" style="color: var(--neutral-one);">Standings</a>
                                <div class="arrow-icons relative flex items-center justify-center <?=$counter < 2 ? 'active' : ''?>">
                                    <span class="absolute"><?=$svg['angle-up']?></span>
                                    <span class="absolute"><?=$svg['angle-down']?></span>
                                </div>
                            </div>
                            <div class="data mb-4 w-full <?=$counter < 2 ? '' : 'hidden'?>">
                                <?php
                                foreach($data['leagues'] as $x) {
                                    foreach($x['fixtures'] as $key => $fixture){
                                        // $__fixtures = $fixture['fixtures'];
                                        if(!isset($fixture['teams']) && !is_array($fixture)) $fixture = $x['fixtures'];
                                        else if(!isset($fixture['teams'])) $fixture = $fixture['fixtures'];
                                        $sc = $fixture['score'];
                                        $score_home = intval($sc['halftime']['home'] + $sc['extratime']['home'] + $sc['penalty']['home']);
                                        $score_away = $sc['halftime']['away'] + $sc['extratime']['away'] + $sc['penalty']['away'];
                                        if($score_home == 0) $score_home = $sc['fulltime']['home'];
                                        if($score_away == 0) $score_away = $sc['fulltime']['away'];
                                        
                                        $match_status = $fixture['fixture']['status']['long'];
                                        ?>
                                        <a href="./?sec=countries&ref=fixture&id=<?=$fixture['fixture']['id']?>" class="item">
                                            <span class="flex items-center m-4">
                                                <span class="w-32 flex-shrink-0 flex justify-center items-center font-semibold" style="color: var(--neutral-one);"><?=$match_status?></span>
                                                <span class="flex-grow flex flex-col">
                                                    <span class="flex items-center pb-1">
                                                        <p><?=$fixture['teams']['home']['name']?></p>
                                                        <span class="ml-auto w-8 flex items-center justify-center"><?=!$score_home ? '0' : $score_home?></span>
                                                        <span class="w-8 flex items-center justify-center"></span>
                                                        <span class="w-8 flex items-center justify-center"></span>
                                                    </span>
                                                    <span class="flex items-center pb-1">
                                                        <p><?=$fixture['teams']['away']['name']?></p>
                                                        <span class="ml-auto w-8 flex items-center justify-center"><?=!$score_away ? '0' : $score_away?></span>
                                                        <span class="w-8 flex items-center justify-center"></span>
                                                        <span class="w-8 flex items-center justify-center"></span>
                                                    </span>
                                                </span>
                                                <span class="w-24 flex items-center justify-center">
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
                        $counter++;
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <div class="right flex-shrink-0"><div><?php require "football/right.php"; ?></div></div>
</main>