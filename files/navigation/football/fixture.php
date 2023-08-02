<?php
// default page for the entire website in case there's a broken link
// THE HOME PAGE
session_start();
date_default_timezone_set($_SESSION['user_timezone']);

?>


<main class="flex mx-auto wd">
    <div class="left flex flex-col flex-shrink-0">
        <div><?php require './football/left-nav/countries.php'; ?></div>
    </div>
    <div class="flex-grow middle flex flex-col" style="color: var(--neutral-light);">
        <!-- <div> -->
        <div class="p-6 flex items-center font-semibold" style="border-radius: 0;">
            <div class="hidden md:flex items-center">
                <div style="fill: var(--neutral-one);" class="w-6 mr-2"><?=$svg['futbol']?></div>
                <a href="./" class="hover:underline">HOME</a>
            </div>
            <div class="mx-3 w-2 hidden md:inline" style="fill: var(--neutral-one);"><?=$svg['caret-right']?></div>
            <div class="flex items-center">
                <img src="<?=$league['flag']?>" class="w-6 mr-2" />
                <a href="<?=$_SERVER['REQUEST_URI']?>" class="hover:underline"><?=$league['country']?></a>&nbsp;:&nbsp;
                <a href="./?sec=countries&ref=league&league=<?=$league['id']?>" class="hover:underline"><?=$league['name']?></a>
            </div>
        </div>
        <div class="p-6" id="fixture" data-id="<?=$fixture_id?>" data-d="<?=$fx['status']['short']?>" data-live="<?=in_array($fx['status']['short'],['1H', '2H', 'HT']) ? 'true' : 'false'?>" style="overflow: hidden; position: sticky; top: 0; background-color: var(--primary-bg); z-index: 1000; border-radius: 0;">
            <div class="flex items-center mx-auto justify-center md:font-bold" style="/*max-width: 400px;*/">
                <a href="./?sec=countries&ref=team&id=<?=$teams['home']['id']?>" class="flex-shrink-0 w-24 text-center">
                    <span class="w-full" >
                        <img src="<?=$teams['home']['logo']?>" class="rounded-lg bg-white p-2 mb-2" style="width: 100%; aspect-ratio: 1;" alt="<?=$teams['home']['name']?>">
                        <span class="text-center w-full text-sm ms:text-base break-words"><?=$teams['home']['name']?></span>
                    </span>
                </a>
                <div class="flex-grow flex flex-col text-center justify-center items-center mx-2 md:mx-10">
                    
                    <div style="width: 130px;"><?=date('l jS M. Y - H:i', $fx['timestamp'])?></div>

                    
                    
                    
                    <div class="font-bold text-3xl md:text-5xl">
                        <?php
                        echo $goals['home'] == null ? 0 : $goals['home'];
                        echo ' - ';
                        echo $goals['away'] == null ? 0 : $goals['away'];
                        ?>
                    </div>
                    
 
                    <div style="width: 130px; color: var(--secondary-one);">
                        <?php
                      if(isset($fx['fixture'])) echo $fx['fixture']['formattedKickoff'];
                      
                        ?>
                    </div>
                    
                    <!-- <div style="width: 130px; color: var(--secondary-one);"><?=strtoupper($fx['status']['long'])?></div> -->
                    <div style="width: 130px; color: var(--secondary-one);">
                        <?php
                        $min = $fx['status']['elapsed'];
                        $txt = strtoupper($fx['status']['long']);
                        $short = strtoupper($fx['status']['short']);
                        if ($short == "HT")
                            $txt = "HALF TIME";
                        else if ($short == "FT")
                            $txt = "FULL TIME";
                        else if (intval($min) > 0)
                            $txt = $min . "'";
                        echo $txt;    
                        // $short = $fx['status']['short'];
                        // if(!in_array($short,['FT', '1H', '2H']) && $min >= 90) echo $min;
                        // else $long; 
                        ?>
                    </div>
                </div>
                <a href="./?sec=countries&ref=team&id=<?=$teams['away']['id']?>" class="flex-shrink-0 w-24 mr-2 text-center">
                    <span class="w-full">
                        <img src="<?=$teams['away']['logo']?>" class="rounded-lg bg-white p-2 mb-2" style="width: 100%; aspect-ratio: 1;" alt="<?=$teams['away']['name']?>">
                        <span class="text-center w-full text-sm ms:text-base break-words"><?=$teams['away']['name']?></span>
                    </span>
                </a>
            </div>
        </div>
        <div style="border-top: 1px solid var(--primary-two);border-bottom: 1px solid var(--primary-two);color: var(--neutral-one);border-radius: 0;padding: 0;padding-left: 10px;" class="pt-0 pl-6 pr-6 gap-6 flex font-bold">
            <a href="./?sec=countries&ref=fixture&id=<?=$fixture_id?>&ref2=match" class="py-4 text-sm" <?=$ref2 == 'match' ? 'style="border-bottom: 3px solid var(--secondary); color: var(--secondary);"' : ''?>>MATCH</a>
            <!-- <a href="#" class="py-4 text-sm">SUMMARY</a> -->
            <a href="./?sec=countries&ref=fixture&id=<?=$fixture_id?>&ref2=h2h" class="py-4 text-sm" <?=$ref2 == 'h2h' ? 'style="border-bottom: 3px solid var(--secondary); color: var(--secondary);"' : ''?>>H2H</a>
            <a href="./?sec=countries&ref=fixture&id=<?=$fixture_id?>&ref2=standings" class="py-4 text-sm" <?=$ref2 == 'standings' ? 'style="border-bottom: 3px solid var(--secondary); color: var(--secondary);"' : ''?>>STANDINGS</a>
            <a href="./?sec=countries&ref=fixture&id=<?=$fixture_id?>&ref2=predictions" class="py-4 text-sm" <?=$ref2 == 'predictions' ? 'style="border-bottom: 3px solid var(--secondary); color: var(--secondary);"' : ''?>>PREDICTIONS</a>
        </div>
        <!-- </div> -->
        <div class="flex-shrink-0 mt-4 p-6" style="padding-top: 0; color: var(--neutral-light); overflow: hidden; background: transparent;">
            <nav class="flex items-center nav2-top gap-3">
                <?php
                if($ref2 == 'match') {
                    $section = 'summary';
                    if(isset($_GET['pg2']) && in_array($_GET['pg2'],["statistics","lineups","summary"])) $section = $_GET['pg2'];
                    ?>
                    <a href="./?sec=countries&ref=fixture&id=<?=$fixture_id?>&ref2=match&pg2=summary" class="_match <?=$section == 'summary' ? 'active' : ''?>">SUMMARY</a>
                    <a href="./?sec=countries&ref=fixture&id=<?=$fixture_id?>&ref2=match&pg2=statistics" class="_match <?=$section == 'statistics' ? 'active' : ''?>">STATISTICS</a>
                    <a href="./?sec=countries&ref=fixture&id=<?=$fixture_id?>&ref2=match&pg2=lineups" class="_match <?=$section == 'lineups' ? 'active' : ''?>">LINEUPS</a>
                    <?php
                }
                ?>
            </nav>
        </div>
        <?php
        // echo $ref2;
        // print_r(glob('*'));
        if($ref2 == 'match') {
            chdir("football/fixture/");
            // print_r(glob('*'));
            $pg = isset($_GET['pg2']) && file_exists($_GET['pg2'].".php") ? $_GET['pg2'] : 'summary';
            require "$pg.php";
            chdir("../../");
        }
        else require "football/fixture/$ref2.php";
        ?>
    </div>
    <div class="right flex-shrink-0">
        <div><?php require "football/right.php"; ?></div>
    </div>
</main>