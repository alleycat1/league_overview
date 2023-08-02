<?php
$section = 'all';
if(isset($_GET['pg2']) && in_array($_GET['pg2'],["home","away"])) $section = $_GET['pg2'];
?>
<div class="mt-4 rounded-sm" style="background-color: var(--primary-main);">
    <div class="p-4">
        <nav class="nav2-top flex items-center gap-2">
            <a href="./?sec=countries&ref=league&league=<?=$league_id?>&ref2=standings&pg=standings" style="<?=$section == 'all' ? 'background-color: var(--item-bg2);' : 'background-color: var(--primary-main);'?>">OVERALL</a>
            <a href="./?sec=countries&ref=league&league=<?=$league_id?>&ref2=standings&pg=standings&pg2=home" style="<?=$section == 'home' ? 'background-color: var(--item-bg2);' : 'background-color: var(--primary-main);'?>">HOME</a>
            <a href="./?sec=countries&ref=league&league=<?=$league_id?>&ref2=standings&pg=standings&pg2=away" style="<?=$section == 'away' ? 'background-color: var(--item-bg2);' : 'background-color: var(--primary-main);'?>">AWAY</a>
        </nav>
    </div>
</div>
<div class="table-wrapper">
    <div>
        <div class="px-4 py-2 flex items-center text-center" style="border-top: 1px solid var(--table-bg);">
            <div class="team-rank z-10" style="background-color: var(--table-bg);">No.</div>
            <div class="team-name z-10" style="background-color: var(--table-bg);">TEAM</div>
            <div class="w-6 md:w-10">MP</div>
            <div class="w-6 md:w-10">W</div>
            <div class="w-6 md:w-10">D</div>
            <div class="w-6 md:w-10">L</div>
            <div class="w-16">G</div>
            <div class="w-12 text-center">PTS</div>
            <div class="w-32 gap-1 flex" style="text-align: center;">FORM</div>
        </div>
        <?php
        $endpoint = "standings?season=$season_yr&league=$league_id";
        // echo $endpoint;
        $data = json_decode($config->query($endpoint),1);
        if(count($data['response']) > 0) {
            $league = $data['response'][0]['league'];
            foreach($league['standings'] as $standings) {
                // $standings = $league['standings'][0];
                ?>
                <div class="text-lg pb-2 flex" style="border-top: 1px solid var(--table-bg);border-bottom: 1px solid var(--table-bg);width: 100%;margin-left: 12px;font-weight: bold;">
                    <p style="left: 12px; position: sticky;"><?=$standings[0]['group']?></p>
                </div>
                <?php
                /*
                $st_array = [];
                foreach ($standings as $key => $st) {
                $sort_field = $st['points']; // sort by points
                $st_array[$sort_field."-".$key] = $st;
                }
                krsort($st_array); // sort in descending order
                foreach ($st_array as $st) {
                 */
                     foreach($standings as $st) {
                    // echo '<pre>';
                    // print_r($st);
                    // echo '</pre>'; 
                 
                    ?>
            
                    <div class="px-4 py-2 flex items-center text-center" style="background-color: var(--primary-bg); border-bottom: 1px solid var(--item-bg);">
                        <div class="flex items-center team-rank">
                            <span class="flex items-center justify-center font-bold rounded-md text-sm w-6 md:w-8 h-6 md:h-8" style="background-color: var(--item-bg2);"><?=$st['rank']?>.</span>
                        </div>
                        <a href="./?sec=countries&ref=team&id=<?=$st['team']['id']?>" class="team-name flex items-center hover:underline">
                            <img class="w-6 mr-3" src="<?=$st['team']['logo']?>">
                            <?=$st['team']['name']?>
                        </a>
                        <div class="w-6 md:w-10"><?=$st[$section]['played']?></div>
                        <div class="w-6 md:w-10"><?=$st[$section]['win']?></div>
                        <div class="w-6 md:w-10"><?=$st[$section]['draw']?></div>
                        <div class="w-6 md:w-10"><?=$st[$section]['lose']?></div>
                        <div class="w-16"><?=$st[$section]['goals']['for'].':'.$st[$section]['goals']['against']?></div>
                        <div class="w-12 text-center"><?=$st['points']?></div>
                        <div class="w-32 gap-1 flex" style="text-align: center;" class="flex items-center gap-1">
                            <?php
                            $forms = str_split($st['form']);
                            $forms = array_reverse($forms);
                            foreach($forms as $char) {
                                $color = '#f00';
                                $title = 'Lose';
                                if($char == 'W') {
                                    $color = '#00a83f';
                                    $title = 'Win';
                                }
                                if($char == 'D') {
                                    $color = '#f3a000';
                                    $title = 'Draw';
                                }
                                ?>
                                <span class="flex items-center justify-center font-bold rounded-md flex-shrink-0" style="font-size: 11px; height: 16px; width: 18px; cursor: default; background-color: <?=$color?>;" title="<?=$title?>"><?=$char?></span>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                }
            }
        }
        else {
            ?>
            <p class="text-3xl text-center h-24 flex justify-center items-center font-bold" style="color: var(--secondary-light);">No records</p>
            <?php
        }
        ?>
    </div>
</div>