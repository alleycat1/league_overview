<div class="data-table mt-2">
    <p class="text-2xl font-bold pb-2">Latest scores</p>
    <?php
    $endpoint = "fixtures?team=$team_id&last=99";
    $data = $config->query($endpoint);
    // echo $data;
    $fixtures = $config->leagues($data);
    // $fixtures = ['response' => []];
    foreach($fixtures['response'] as $data) {
        // break;
        $country = $data['country'];
        $league = $data['leagues'][0]['name'];
        $logo = $data['leagues'][0]['fixtures'][0]['league']['logo'];
        $league_id = $data['leagues'][0]['fixtures'][0]['league']['id'];
        // echo '<pre>';
        // print_r($data['leagues'][0]['fixtures'][0]['league']);
        // echo '</pre>';
        // break;
        // $fixture = $data['fixture'];
        // $teams = $data['teams'];
        // $goals = $data['goals'];
        // $score = $data['score'];
        ?>
        <section class="flex items-center flex flex-col">
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
                        // if(!isset($fixture['teams'])) {
                            // echo '<pre>';
                            // print_r($fixture);
                            // echo '</pre>';
                        //     echo '<pre>';
                        //     print_r($x['fixtures'][$key-1]);
                        //     echo '</pre>';
                        //     break;
                        // }
                        // else continue;
                        // break;
                        $score_home = $fixture['score']['fulltime']['home'];
                        $score_away = $fixture['score']['fulltime']['away'];
                        $match_status = $fixture['fixture']['status']['long'];
                        $s_short = $fixture['fixture']['status']['short'];
                        ?>
                        <a href="./?sec=countries&ref=fixture&id=<?=$fixture['fixture']['id']?>" class="item">
                            <span class="flex items-center m-4">
                                <span class="w-16 md:w-32 flex-shrink-0 text-center mr-2 font-semibold" style="color: var(--neutral-one);">
                                    <!-- <?=date('Y-m-d H:i', $fixture['fixture']['timestamp'])?><br> -->
                                    <span>
                                    <?php
                                    if($match_status == 'Not Started' && date('Y-m-d') == date('Y-m-d', strtotime($fixture['fixture']['date']))) echo  date('H:i', strtotime($fixture['fixture']['date']));
                                    else {
                                        if($s_short == 'CANC') echo  'CANX';
                                        else if($s_short == 'PST') echo  'PP';
                                        else if($s_short == 'TBD') echo  'TBC';
                                        else if($s_short == 'FT' ) {
                                            echo date('d.m.y', strtotime($fixture['fixture']['date']));
                                            echo '<br><span style="color: var(--secondary-one);">FT</span>';
                                        }
                                        else echo $s_short;
                                    }
                                    ?>
                                    </span>
                                </span>
                                <span class="flex-grow flex flex-col">
                                    <span class="flex items-center pb-1">
                                        <p><?=$fixture['teams']['home']['name']?></p>
                                        <span class="ml-auto w-4 md:w-8 flex items-center justify-center"><?=!$score_home ? '0' : $score_home?></span>
                                        <span class="w-4 md:w-8 flex items-center justify-center"></span>
                                        <span class="w-4 md:w-8 flex items-center justify-center"></span>
                                    </span>
                                    <span class="flex items-center pb-1">
                                        <p><?=$fixture['teams']['away']['name']?></p>
                                        <span class="ml-auto w-4 md:w-8 flex items-center justify-center"><?=!$score_away ? '0' : $score_away?></span>
                                        <span class="w-4 md:w-8 flex items-center justify-center"></span>
                                        <span class="w-4 md:w-8 flex items-center justify-center"></span>
                                    </span>
                                </span>
                                <span class="w-4 flex items-center justify-center">
                                    <span style="" class="w-8 hidden"><?=$svg['shirt-solid']?></span>
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
    ?>
</div>
<div class="data-table mt-2">
    <p class="text-2xl font-bold pb-2">Scheduled</p>
    <?php
    $endpoint = "fixtures?team=$team_id&next=35";
    $data = $config->query($endpoint);
    // echo $data;
    $fixtures = $config->leagues($data);
    // $fixtures = ['response' => []];
    foreach($fixtures['response'] as $data) {
        // break;
        $country = $data['country'];
        $league = $data['leagues'][0]['name'];
        $logo = $data['leagues'][0]['fixtures'][0]['league']['logo'];
        // $fixture = $data['fixture'];
        // $teams = $data['teams'];
        // $goals = $data['goals'];
        // $score = $data['score'];
        $league_id = $data['leagues'][0]['fixtures'][0]['league']['id'];
        ?>
        <section class="flex items-center flex flex-col">
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
                        // if(!isset($fixture['teams'])) {
                            // echo '<pre>';
                            // print_r($fixture);
                            // echo '</pre>';
                        //     echo '<pre>';
                        //     print_r($x['fixtures'][$key-1]);
                        //     echo '</pre>';
                        //     break;
                        // }
                        // else continue;
                        // break;
                        $score_home = $fixture['score']['fulltime']['home'];
                        $score_away = $fixture['score']['fulltime']['away'];
                        $match_status = $fixture['fixture']['status']['long'];
                        $s_short = $fixture['fixture']['status']['short'];
                        ?>
                        <a href="./?sec=countries&ref=fixture&id=<?=$fixture['fixture']['id']?>" class="item">
                            <span class="flex items-center m-4">
                                <span class="w-16 md:w-32 flex-shrink-0 mr-2 text-center font-semibold" style="color: var(--neutral-one);">
                                    <!-- <?=date('Y-m-d H:i', $fixture['fixture']['timestamp'])?><br> -->
                                    <span style="color: #f00;">
                                        <?php
                                        if($s_short == 'NS' && date('Y-m-d') == date('Y-m-d', strtotime($fixture['fixture']['date']))) echo  date('H:i', strtotime($fixture['fixture']['date']));
                                        else {
                                            if($s_short == 'CANC') echo  'CANX';
                                            else if($s_short == 'PST') echo  'PP';
                                            else if($s_short == 'TBD') echo  'TBC';
                                            else if($s_short == 'FT' ) {
                                                echo date('d.m.y', strtotime($fixture['fixture']['date']));
                                                echo '<br><span style="color: var(--secondary-one);">FT</span>';
                                            }
                                            else echo $s_short;
                                        }
                                        ?>
                                    </span>
                                </span>
                                <span class="flex-grow flex flex-col">
                                    <span class="flex items-center pb-1">
                                        <p><?=$fixture['teams']['home']['name']?></p>
                                        <span class="ml-auto w-4 md:w-8 flex items-center justify-center"><?=!$score_home ? '-' : $score_home?></span>
                                        <span class="w-4 md:w-8 flex items-center justify-center"></span>
                                        <span class="w-4 md:w-8 flex items-center justify-center"></span>
                                    </span>
                                    <span class="flex items-center pb-1">
                                        <p><?=$fixture['teams']['away']['name']?></p>
                                        <span class="ml-auto w-4 md:w-8 flex items-center justify-center"><?=!$score_away ? '-' : $score_away?></span>
                                        <span class="w-4 md:w-8 flex items-center justify-center"></span>
                                        <span class="w-4 md:w-8 flex items-center justify-center"></span>
                                    </span>
                                </span>
                                <span class="w-4 flex items-center justify-center">
                                    <span style="" class="w-8 hidden"><?=$svg['shirt-solid']?></span>
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
    ?>
</div>

<div class="data-table mt-2">
    <p class="text-2xl font-bold pb-2">Transfers</p>
    <div style="background-color: var(--primary-two);" class="rounded-lg py-1 px-2 flex items-center">
        <div style="width: 20%;" class="flex-shrink-0">DATE</div>
        <div style="width: 30%;" class="flex-shrink-0">PLAYER</div>
        <div style="width: 20%;" class="flex-shrink-0">TYPE</div>
        <div style="width: 30%;" class="flex-shrink-0">FROM/TO</div>
    </div>
    <?php
    $data = json_decode($config->query("transfers?team=$team_id"), 1);
    // foreach($data['response'] as $) {}
    // $max = count($data['response'])-;
    for($x = 25; $x >= 0; $x--) {
        // break;
        // $data['response'];
        $row = $data['response'][$x];
        $transfers = $row['transfers'];
        foreach($transfers as $tr) {
            if($team_name == $tr['teams']['in']['name']) {
                $dst = $tr['teams']['out'];
                $icon = 'right';
            }
            else {
                $dst = $tr['teams']['in'];
                $icon = 'left';
            }
            ?>
            <div style="background-color: transparent;" class="rounded-lg py-1 px-2 my-1 flex items-center font-bold">
                <div style="width: 20%;" class="flex-shrink-0"><?=date('d.m.y', strtotime($tr['date']))?></div>
                <a href="./?sec=countries&ref=team&id=<?=$row['player']['id']?>" style="width: 30%;" class="flex-shrink-0 hover:underline"><?=$row['player']['name']?></a>
                <div style="width: 18%;" class="flex-shrink-0 flex items-center">
                    <span class="w-6 mr-2 h-6 rounded-full hidden md:block" style="fill: var(--neutral-light); padding: 5px; background-color: <?=$icon != 'left' ? '#961b1b' : '#045718'?>;"><?=$svg["arrow-$icon"]?></span>
                    <span><?=$tr['type']?></span>
                </div>
                <div style="width: 30%;" class="flex-shrink-0 flex items-center">
                    <img class="w-6 mr-2 hidden md:inline" src="<?=$dst['logo']?>">
                    <a href="./?sec=countries&ref=team&id=<?=$dst['id']?>" class="hover:underline"><?=$dst['name']?></a>
                </div>
            </div>
            <?php
        }
    }
    ?>
</div>