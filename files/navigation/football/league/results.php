<div class="flex-shrink-0 mt-4 p-6" style="color: var(--neutral-light); overflow: hidden;">
    <p class="flex rounded-lg p-2 font-bold gap-2 items-center text-lg" style="background-color: var(--primary-two); color: var(--neutral-two);">
        <img class="w-6" src="<?=$league['response'][0]['country']['flag']?>">
        <span><?=$league['response'][0]['country']['name']?>:</span>
        <span style="color: var(--secondary-one);"><?=$league['response'][0]['league']['name']?></span>
    </p>
    <div class="data-table">
        <?php
        $endpoint = "fixtures?league=$league_id&last=99";
        // echo $endpoint;
        $results = json_decode($config->query($endpoint),1);
        $dates = [];
        foreach($results['response'] as $response) $dates[] = strtotime($response['fixture']['date']).'-'.$response['fixture']['id'];
        rsort($dates);
        // echo '<pre>';
        // print_r($dates);
        // echo '</pre>';
        $my_fixtures = $config->sortH2H($results['response'], $dates);
        ?>
        <section class="flex items-center flex flex-col league-container">
            <div class="data mb-4 w-full <?=$counter < 2 ? '' : 'hidden'?>">
                <?php
                foreach($my_fixtures as $data) {
                    $fixture = $data['fixture'];
                    $league = $data['league'];
                    $teams = $data['teams'];
                    $goals = $data['goals'];
                    $score = $data['score'];
                    // echo '<pre>';
                    // print_r($fixture);
                    // echo '</pre>';
                    // break;

                    $country = $league['country'];
                    $league_name = $league['name'];
                    $logo = $league['logo'];
                    $league_id = $league['id'];
                    // if(!isset($fixture['teams']) && !is_array($fixture)) $fixture = $x['fixtures'];
                    // else if(!isset($fixture['teams'])) $fixture = $fixture['fixtures'];
                    $score_home = $score['fulltime']['home'];
                    $score_away = $score['fulltime']['away'];
                    $match_status = $fixture['status']['long'];
                    $s_short = $fixture['status']['short'];
                    ?>
                    <a href="./?sec=countries&ref=fixture&id=<?=$fixture['id']?>" class="item fixture" data-id="<?=$fixture['id']?>">
                        <span class="flex items-center m-4">
                            <span class="live-match w-24 md:w-32 mr-2 flex-shrink-0 flex justify-center items-center font-semibold" style="color: var(--neutral-one);">
                                <span style="color: <?=in_array($s_short,array('1H','2H')) ? 'var(--secondary-one)' : 'var(--neutral-light)'?>; text-align: center;">
                                    <?php
                                    // $match_status
                                    // echo "$s_short";
                                    // if(in_array($s_short, ['HT', 'FT'])) {
                                    //     echo $match_status;
                                    // }
                                    // else if(in_array($s_short, ['1H', '2H'])) echo $fixture['status']['elapsed'];
                                    // else {
                                    //     echo '<span style="color: var(--secondary-one);">'.date('H:s', strtotime($fixture['date'])).'</span><br>';
                                    //     echo date('d.m.y', strtotime($fixture['date']));
                                    // }
                                    // echo '<pre>';
                                    // print_r($fixture);
                                    // echo '</pre>';
                                    // if($match_status == 'Not Started' && date('Y-m-d') == date('Y-m-d', strtotime($fixture['date']))) echo  date('H:i', strtotime($fixture['date']));
                                    // else {
                                    if($s_short == 'CANC') echo  'CANX';
                                    else if($s_short == 'PST') echo  'PP';
                                    else if($s_short == 'TBD') echo  'TBC';
                                    else if($s_short == 'FT') {
                                        // echo '<span style="color: var(--secondary-one);">'.date('H:i', strtotime($fixture['date'])).'</span><br>';
                                        echo date('d.m.y', strtotime($fixture['date']));
                                    }
                                    else echo $s_short;
                                    // }
                                    ?>
                                </span>
                                <span class="tick" style="display: <?=in_array($s_short,array('1H','2H')) ? 'block' : 'none'?>; color: var(--secondary-one);">'</span>
                            </span>
                            <span class="flex-grow flex flex-col">
                                <span class="flex items-center pb-1">
                                    <p><?=$teams['home']['name']?></p>
                                    <span class="ml-auto w-4 md:w-8 flex items-center justify-center"></span>
                                    <span class="w-4 md:w-8 flex items-center justify-center"><?=!$score_home ? '0' : $score_home?></span>
                                    <span class="w-4 md:w-8 flex items-center justify-center">
                                        <span class="w-4 md:w-8 flex items-center justify-center hidden" style="color: var(--neutral-one);">
                                            <?php
                                            $x = intval($score['halftime']['home']) > 0 ? $score['halftime']['home'] : 0;
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
                                            $x = intval($score['halftime']['away']) > 0 ? $score['halftime']['away'] : 0;
                                            echo "(".$x.")";
                                            ?>
                                        </span>
                                    </span>
                                </span>
                            </span>
                            <span class="w-10 md:w-24 flex items-center justify-center">
                                <!-- <span style="" class="w-4 md:w-8"><?=$svg['jersey']?></span> -->
                                <?=date('H:i', strtotime($fixture['date']))?>
                            </span>
                        </span>
                    </a>
                    <?php
                    // $counter++;
                }
                ?>
            </div>
        </section>
    </div>
</div>