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
            $coach_id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : 10339;
            $league_id = isset($_GET['league']) && is_numeric($_GET['league']) ? $_GET['league'] : 39;
            $season_yr = date('Y');
            $data = json_decode($config->query("coachs?id=$coach_id"), 1);
            $coach = $data['response'][0];
            $coach_name = $coach['firstname'] . ' ' . $coach['lastname'];
            $dob = $coach['birth']['date'];
            $place = $coach['birth']['place'];
            $country_name = $coach['nationality'];
            $league = $config->query("leagues?id=$league_id");
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
                    <img src="./files/assets/img/empty-face-man-share.gif">
                </div>
                <div class="flex flex-col items-center">
                    <p class="py-2 font-bold text-2xl"><?=$coach_name?></p>
                    <p class="font-semibold w-full"><?=$place?></p>
                    <p class="font-semibold w-full">Age: (<?=date('Y')-date('Y', strtotime($dob))?>) - <?=$dob?></p>
                </div>
            </div>
        </div>
        <div style="color: var(--neutral-light); overflow: hidden;" class="my-2">
            <p class="text-2xl font-bold pb-2">Career</p>
            <div style="background-color: var(--primary-two); color: var(--neutral-light);" class="py-2 px-1 rounded-lg flex items-center gap-3 font-bold mt-4 max-w-full">
                <div class="w-16 md:w-24 flex-shrink-0">START</div>
                <div class="w-16 md:w-24 flex-shrink-0">END</div>
                <div class="w-32 text-left flex-grow">TEAM</div>
            </div>
            <?php
            $career_length = count($coach['career']);
            // for($x = $career_length-1; $x >= 0; $x--) {
            for($x = 0; $x < $career_length; $x++) {
                $start = $coach['career'][$x]['start'];
                $end = $coach['career'][$x]['end'];
                ?>
                <div style="background-color: transparent; color: var(--neutral-light);" class="py-2 px-1 rounded-lg flex items-center gap-3 font-bold mt-4 max-w-full">
                    <div class="w-16 md:w-24 flex-shrink-0"><?=$start?></div>
                    <div class="w-16 md:w-24 flex-shrink-0"><?=$end != null ? $end : 'Current'?></div>
                    <div class="w-32 text-left flex-grow flex items-center">
                        <img class="w-8 mr-6" src="<?=$coach['career'][$x]['team']['logo']?>" alt="<?=$coach['career'][$x]['team']['name']?>">
                        <a class="hover:underline font-bold" href="./?sec=countries&ref=team&id=<?=$coach['career'][$x]['team']['id']?>">
                            <?=$coach['career'][$x]['team']['name']?>
                        </a>
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