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
            <div class="p-6 flex items-center font-semibold">
                <div class="hidden md:flex items-center">
                    <div style="fill: var(--neutral-one);" class="w-6 mr-2"><?=$svg['futbol']?></div>
                    <a href="./" class="hover:underline">HOME</a>
                </div>
                <div class="mx-3 w-2 hidden md:inline" style="fill: var(--neutral-one);"><?=$svg['caret-right']?></div>
                <div class="flex items-center">
                    <img src="<?=$country_flag?>" class="w-6 mr-2" />
                    <a href="<?=$_SERVER['REQUEST_URI']?>" class="hover:underline"><?=$country_name?></a>
                </div>
            </div>
            <div class="p-6">
                <div class="flex items-center font-bold">
                    <img src="<?=$team['logo']?>" class="rounded-lg bg-white p-2 mb-2" style="width: 90px;" alt="<?=$team['name']?> team logo">
                    <span class="ml-4 text-3xl"><?=$team['name']?></span>
                </div>
            </div>
            <div style="border-top: 1px solid var(--primary-two); border-bottom: 1px solid var(--primary-two); color: var(--neutral-one);" class="pt-0 pl-6 pr-6 gap-6 flex font-bold hidden">
                <a href="./?sec=countries&ref=team&id=<?=$team_id?>&ref2=summary" class="py-4 text-sm" <?=$ref2 == 'summary' ? 'style="border-bottom: 3px solid var(--secondary); color: var(--secondary);"' : ''?>>SUMMARY</a>
                <a href="./?sec=countries&ref=team&id=<?=$team_id?>&ref2=results" class="py-4 text-sm hidden" <?=$ref2 == 'results' ? 'style="border-bottom: 3px solid var(--secondary); color: var(--secondary);"' : ''?>>RESULTS</a>
                <a href="./?sec=countries&ref=team&id=<?=$team_id?>&ref2=fixtures" class="py-4 text-sm hidden" <?=$ref2 == 'fixtures' ? 'style="border-bottom: 3px solid var(--secondary); color: var(--secondary);"' : ''?>>FIXTURES</a>
                <a href="./?sec=countries&ref=team&id=<?=$team_id?>&ref2=standings" class="py-4 text-sm" <?=$ref2 == 'standings' ? 'style="border-bottom: 3px solid var(--secondary); color: var(--secondary);"' : ''?>>STANDINGS</a>
            </div>
        </div>
        <?php
        // print_r(glob('*'));
        require "football/team/$ref2.php";
        ?>
    </div>
    <div class="right flex-shrink-0">
        <div><?php require "football/right.php"; ?></div>
    </div>
</main>