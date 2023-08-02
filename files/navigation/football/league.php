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
                    <img src="<?=$league['response'][0]['country']['flag']?>" class="w-6 mr-2" />
                    <a href="#" class="hover:underline"><?=strtoupper($league['response'][0]['country']['name'])?></a>
                </div>
            </div>
            <div class="p-6 flex">
                <div class="w-24 h-24 overflow-hidden bg-white rounded-lg mr-4 flex justify-center items-center">
                    <img src="<?=$league['response'][0]['league']['logo']?>">
                </div>
                <div class="flex flex-col items-center">
                    <p class="py-2 font-bold text-2xl"><?=$league['response'][0]['league']['name']?></p>
                    <p class="font-semibold w-full">
                        <?php
                        $seasons = $league['response'][0]['seasons'];
                        echo date('Y', strtotime($seasons[count($seasons)-1]['start'])).'/'.date('Y', strtotime($seasons[count($seasons)-1]['end']));
                        ?>
                    </p>
                </div>
            </div>
            <div style="border-top: 1px solid var(--primary-two); color: var(--neutral-one);" class="pt-0 pl-6 pr-6 gap-6 flex font-bold">
                <a href="./?sec=countries&ref=league&league=<?=$league_id?>&ref2=fixtures" class="py-4 text-sm" <?=$ref2 == 'fixtures' ? 'style="border-bottom: 3px solid var(--secondary); color: var(--secondary);"' : ''?>>FIXTURES</a>
                <a href="./?sec=countries&ref=league&league=<?=$league_id?>&ref2=results" class="py-4 text-sm" <?=$ref2 == 'results' ? 'style="border-bottom: 3px solid var(--secondary); color: var(--secondary);"' : ''?>>RESULTS</a>
                <a href="./?sec=countries&ref=league&league=<?=$league_id?>&ref2=standings" class="py-4 text-sm" <?=$ref2 == 'standings' ? 'style="border-bottom: 3px solid var(--secondary); color: var(--secondary);"' : ''?>>STANDINGS</a>
            </div>
        </div>
        <?php
        // print_r(glob('*'));
        require "football/league/$ref2.php";
        ?>
    </div>
    <div class="right flex-shrink-0">
        <div><?php require "football/right.php"; ?></div>
    </div>
</main>