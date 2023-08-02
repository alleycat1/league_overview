<div class="flex-shrink-0 mt-4 p-6" style="color: var(--neutral-light); overflow: hidden;">
    <p class="flex rounded-lg p-2 font-bold gap-2 items-center text-lg" style="background-color: var(--primary-two); color: var(--neutral-two);">
        <img class="w-6" src="<?=$league['response'][0]['country']['flag']?>">
        <span><?=$league['response'][0]['country']['name']?>:</span>
        <span style="color: var(--secondary-one);"><?=$league['response'][0]['league']['name']?></span>
    </p>
    <?php
    $rounds = $config->query("fixtures/rounds?league=$league_id&season=$season_yr");
    if(!is_array($rounds)) {
        $rounds = json_decode($rounds, 1);
        $responses = $rounds['response'];
        
        // Get current round
        $r = json_decode($config->query("fixtures/rounds?league=$league_id&season=$season_yr&current=true"),1);
        $curr_round = isset($r['response'][0]) ? $r['response'][0] : -1;
        // echo $curr_round;
        $pos = array_search($curr_round,$responses);
        
        for($i=$pos-1; $i <= $pos+4; $i++) {
            if(!isset($responses[$i]) || $i == $pos-1) continue;
            $round = $responses[$i];
            // if($counter >= 7) break;
            ?>
            <p class="flex rounded-lg px-2 py-1 mt-2" style="background-color: var(--primary-main); color: var(--neutral-one);">
                <span class="mr-2"><?=$round?><span>
                <span class="hidden" style="<?=$curr_round == $round ? 'color: var(--secondary-one); font-weight: bold;' : 'display: none;'?>">(Current Round)</span>
            </p>
            <div class="flex flex-col gap-1">
                <?php
                $round = preg_replace('/ /', '%20', $round);
                $endpoint = "fixtures?league=$league_id&season=$season_yr&round=$round";
                // echo $endpoint;
                $fixtures = json_decode($config->query($endpoint),1);
                $dates = [];
                foreach($fixtures['response'] as $response) $dates[] = strtotime($response['fixture']['date']).'-'.$response['fixture']['id'];
                // echo '<pre>';
                // print_r($dates);
                // echo '</pre>';
                rsort($dates); // sort dates in ascending order
                // echo '<pre>';
                // print_r($dates);
                // echo '</pre>';
                $my_fixtures = $config->sortH2H($fixtures['response'], $dates);
                foreach($my_fixtures as $response) {
                    $fixture    = $response['fixture'];
                    $league     = $response['league'];
                    $teams      = $response['teams'];
                    $goals      = $response['goals'];
                    $score      = $response['score'];
                    $score_home = $goals['home'];
                    $score_away = $goals['away'];
                    $match_status = $fixture['status']['long'];
                    $s_short = $fixture['status']['short'];
                    ?>
                    <a href="./?sec=countries&ref=fixture&id=<?=$fixture['id']?>" class="item p-2 block fixture" data-id="<?=$fixture['id']?>"  style="border-bottom: 1px solid var(--primary-two);">
                        <span class="flex items-center m-4">
                            <span class="live-match w-24 md:w-32 mr-2 flex-shrink-0 flex justify-center items-center font-semibold text-center" style="color: var(--neutral-one);">
                                <span style="color: <?=in_array($s_short,array('1H','2H')) ? 'var(--secondary-one)' : 'var(--neutral-light)'?>; text-align: center;">
                                    <?php
                                    // $match_status
                                    // if(in_array($s_short, ['HT', 'FT'])) {
                                    //     echo $match_status;
                                    // }
                                    // else if(in_array($s_short, ['1H', '2H'])) echo $fixture['status']['elapsed'];
                                    // else {
                                    //     echo '<span style="color: var(--secondary-one);">'.date('H:s', strtotime($fixture['date'])).'</span><br>';
                                    //     echo date('d.m.y', strtotime($fixture['date']));
                                    // }
                                    if($s_short == 'NS' && date('Y-m-d') == date('Y-m-d', strtotime($fixture['date']))) echo  date('H:i', strtotime($fixture['date']));
                                    else {
                                        if($s_short == 'CANC') echo  'CANX';
                                        else if($s_short == 'PST') echo  'PP';
                                        else if($s_short == 'TBD') echo  'TBC';
                                        else if($s_short == 'NS') {
                                            // echo '<span style="color: var(--secondary-one);">' . date("H:s", strtotime($fixture['date'])) . '</span> <br>';
                                            echo date('d.m.y', strtotime($fixture['date']));
                                        }
                                        else if($s_short == 'FT') {
                                            // echo '<span style="color: var(--secondary-one);">'.date('H:i', strtotime($fixture['date'])).'</span><br>';
                                            echo date('d.m.y', strtotime($fixture['date']));
                                        }
                                        else echo $s_short;
                                    }
                                    // if(in_array($s_short,['1H','2H'])) echo $fixture['status']['elapsed'];
                                    // else 
                                    // if($match_status == 'Not Started' && date('Y-m-d') == date('Y-m-d', strtotime($fixture['fixture']['date']))) echo  date('H:i', strtotime($fixture['fixture']['date']));
                                    ?>
                                </span>
                                <span class="tick" style="display: <?=in_array($s_short,array('1H','2H')) ? 'block' : 'none'?>; color: var(--secondary-one);">'</span>
                            </span>
                            <span class="flex-grow flex flex-col" style="/*border-right: 1px solid var(--primary-two);*/">
                                <span class="flex items-center pb-1">
                                    <p><?=$teams['home']['name']?></p>
                                    <span class="ml-auto w-4 md:w-8 flex items-center justify-center"></span>
                                    <span class="w-4 md:w-8 flex items-center justify-center"><?=!$score_home ? '0' : $score_home?></span>
                                    <span class="w-4 md:w-8 flex items-center justify-center">
                                        <span class="w-4 md:w-8 flex items-center justify-center hidden" style="color: var(--neutral-one);">
                                            <?php
                                            $x = $score['halftime']['home'] ? $score['halftime']['home'] : 0;
                                            echo "(".$x.")";
                                            ?>
                                        </span>
                                    </span>
                                </span>
                                <span class="flex items-center pb-1">
                                    <p><?=$teams['away']['name']?></p>
                                    <span class="ml-auto w-4 md:w-8 flex items-center justify-center"></span>
                                    <span class="w-4 md:w-8 flex items-center justify-center"><?=!$score_away ? '0' : $score_away?></span>
                                    <span class="w-4 md:w-8 flex items-center justify-center">
                                        <span class="w-4 md:w-8 flex items-center justify-center hidden" style="color: var(--neutral-one);">
                                            <?php
                                            $x = $score['halftime']['away'] ? $score['halftime']['away'] : 0;
                                            echo "(".$x.")";
                                            ?>
                                        </span>
                                    </span>
                                </span>
                            </span>
                            <span class="w-4 md:w-24 flex items-center justify-center">
                                <?=date('H:i', strtotime($fixture['date']))?>
                            </span>
                        </span>
                    </a>
                    <?php
                }
                ?>
            </div>
            <?php
        }
    }
    ?>
    
</div>