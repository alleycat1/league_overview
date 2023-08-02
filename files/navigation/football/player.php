<?php
// default page for the entire website in case there's a broken link
// THE HOME PAGE
?>
<main class="flex mx-auto wd">
    <div class="left flex flex-col flex-shrink-0">
        <div><?php require './football/left-nav/countries.php'; ?></div>
    </div>
    <div class="flex-grow middle flex flex-col">
        <div style="padding: 0; color: var(--neutral-light); overflow: hidden;">
            <?php
            $player_id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : 10339;
            $league_id = isset($_GET['league']) && is_numeric($_GET['league']) ? $_GET['league'] : 39;
            $season_yr = date('Y')-1;
            $endpoint = "players?id=$player_id&season=$season_yr";
            // echo $endpoint;
            $data = json_decode($config->query($endpoint), 1);
            $player = $data['response'][0]['player'];
            $player_name = $player['firstname'] . ' ' . $player['lastname'];
            $dob = $player['birth']['date'];
            $place = $player['birth']['place'];
            $country_name = $player['nationality'];
            $photo = $player['photo'];
            $league = $config->query("leagues?id=$league_id");
            if(!is_array($league)) {
                $league = json_decode($league, 1);
                $season_yr = $league['response'][0]['seasons'][count($league['response'][0]['seasons'])-1]['year'];
                ////////////country//////////
                $ct = json_decode($config->query("countries?name=$country_name"), 1);
                $country_code = $ct['response'][0]['code'];
                $country_flag = $ct['response'][0]['flag'];
                /////////////////////////////
                // echo '<pre>';
                // print_r($league);
                // echo '</pre>';
                ?>
                <div class="p-6 flex items-center font-semibold">
                    <div class="hidden md:flex items-center">
                        <div style="fill: var(--neutral-one);" class="w-6 mr-2"><?=$svg['futbol']?></div>
                        <a href="./" class="hover:underline">HOME</a>
                    </div>
                    <div class="mx-3 w-2 hidden md:inline" style="fill: var(--neutral-one);"><?=$svg['caret-right']?></div>
                    <div class="flex items-center">
                        <img src="<?=$country_flag?>" class="w-6 mr-2" />
                        <a href="<?=$_SERVER['REQUEST_URI']?>" class="hover:underline"><?=strtoupper($country_name)?></a>
                    </div>
                </div>
                <div class="p-6 flex">
                    <div class="w-24 h-24 overflow-hidden bg-white rounded-lg mr-4 flex justify-center items-center">
                        <img src="<?=$photo?>">
                    </div>
                    <div class="flex flex-col items-center">
                        <p class="py-2 font-bold text-2xl"><?=$player_name?></p>
                        <p class="font-semibold w-full"><?=$place?></p>
                        <p class="font-semibold w-full">Age: (<?=date('Y')-date('Y', strtotime($dob))?>) - <?=$dob?></p>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <div style="color: var(--neutral-light); overflow: hidden; padding: 0; background-color: transparent;" class="my-2 flex flex-col text-sm md:text-base font-regular md:font-bold">
            <div style="margin: 0 auto; width: 100%;">
                <div style="background-color: var(--primary-two); color: var(--neutral-light);" class="py-2 px-1 rounded-lg flex items-center gap-2 mt-4 text-center max-w-full">
                    <div class="w-8 md:w-24 flex-shrink-0 truncate opacity-0 md:opacity-100">SEASON</div>
                    <div class="w-16 md:w-32 text-left flex-shrink-0 truncate opacity-0 md:opacity-100">TEAM</div>
                    <div class="flex-grow text-left truncate">COMPETITION</div>
                    <div class="w-4 md:w-6 flex-shrink-0 relative" style="fill: var(--neutral-light);" title="Games Played"><?=$svg['shirt-solid']?></div>
                    <div class="w-4 md:w-6 flex items-center justify-center flex-shrink-0 relative" style="fill: var(--neutral-light);" title="Goals Scored"><img src="./files/assets/img/goals_scored.png"></div>
                    <div class="w-4 md:w-6 flex items-center justify-center flex-shrink-0 relative text-lg" title="Assists">A</div>
                    <div class="w-4 md:w-6 flex items-center justify-center flex-shrink-0 relative" style="fill: #ff0;" title="Yellow Cards"><img src="./files/assets/img/yellow_card.png"></div>
                    <div class="w-4 md:w-6 flex items-center justify-center flex-shrink-0 relative" style="fill: #f00;" title="Red Cards"><img src="./files/assets/img/red_card.png"></div>
                </div>
                <?php
                // $data = json_decode($config->query("players?id=$player_id&season=$season_yr"), 1);
                for($x = date('Y'); $x >= date('Y') - 4; $x--) {
                    // break;
                    $season_yr = $x;
                    // echo "$season_yr<br>";
                    $data = json_decode($config->query("players?id=$player_id&season=$season_yr"), 1);
                    foreach($data['response'][0]['statistics'] as $array) {
                        ?>
                        <div style="background-color: transparent; color: var(--neutral-light);" class="py-2 px-1 rounded-lg flex items-center gap-2 text-center max-w-full">
                            <div class="w-8 md:w-24 flex-shrink-0"><?=$season_yr?></div>
                            <a href="./?sec=countries&ref=team&id=<?=$array['team']['id']?>" class="w-16 md:w-32 hover:underline text-left flex-shrink-0 truncate"><?=$array['team']['name']?></a>
                            <a href="./?sec=countries&ref=league&league=<?=$array['league']['id']?>" class="flex-grow hover:underline text-left"><?=$array['league']['name']?></a>
                            <div class="w-4 md:w-6 flex-shrink-0" style="fill: var(--neutral-light); width: 15px;"><?=$array['games']['appearences']?></div>
                            <div class="w-4 md:w-6 flex items-center justify-center flex-shrink-0" style="fill: var(--neutral-light); width: 15px;"><?=$array['goals']['total']?></div>
                            <div class="w-4 md:w-6 flex items-center justify-center flex-shrink-0 text-lg"><?=$array['goals']['assists']?></div>
                            <div class="w-4 md:w-6 flex items-center justify-center flex-shrink-0" style="fill: #ff0;"><?=$array['cards']['yellow']?></div>
                            <div class="w-4 md:w-6 flex items-center justify-center flex-shrink-0" style="fill: #f00;"><?=$array['cards']['red']?></div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
        <div style="color: var(--neutral-light); overflow: hidden; padding: 0;" class="my-2 text-sm md:text-base px-2">
            <p class="text-2xl font-bold pb-2">Transfers</p>
            <div style="background-color: var(--primary-two);" class="rounded-lg py-1 flex items-center px-2">
                <div class="w-2/12 flex-shrink-0">DATE</div>
                <div class="w-3/12 flex-shrink-0">FROM</div>
                <div class="px-2">TYPE</div>
                <div class="w-3/12 flex-shrink-0">TO</div>
            </div>
            <?php
            $data = json_decode($config->query("transfers?player=$player_id"), 1);
            // foreach($data['response'] as $) {}
            // $max = count($data['response'])-;
            // $data['response'];
            $transfers = $data['response'][0]['transfers'];
            foreach($transfers as $tr) {
                // if($team_name == $tr['teams']['in']['name']) {
                //     $dst = $tr['teams']['out'];
                //     $icon = 'right';
                // }
                // else {
                //     $dst = $tr['teams']['in'];
                //     $icon = 'left';
                // }
                ?>
                <div style="background-color: transparent;" class="rounded-lg py-1 my-1 flex items-center md:font-bold px-2">
                    <div class="w-2/12 flex-shrink-0 truncate"><?=date('d.m.y',strtotime($tr['date']))?></div>
                    <div class="w-3/12 flex-shrink-0 flex items-center">
                        <img class="w-6 mr-2" src="<?=$tr['teams']['out']['logo']?>">
                        <a href="./?sec=countries&ref=team&id=<?=$tr['teams']['out']['id']?>" class="hover:underline truncate"><?=$tr['teams']['out']['name']?></a>
                    </div>
                    <div class=" flex items-center truncate px-2">
                        <?=$tr['type']?>
                    </div>
                    <div class="w-3/12 flex-shrink-0 flex items-center">
                        <img class="w-6 mr-2" src="<?=$tr['teams']['in']['logo']?>">
                        <a href="./?sec=countries&ref=team&id=<?=$tr['teams']['in']['id']?>" class="hover:underline truncate"><?=$tr['teams']['in']['name']?></a>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <div class="right flex-shrink-0">
        <div><?php require "football/right.php"; ?></div>
    </div>
</main>