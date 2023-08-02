<?php
// default page for the entire website in case there's a broken link
// THE HOME PAGE
$f = isset($_GET['h']) ? $_GET['h'] : 'all';
?>
<main class="flex mx-auto wd">
    <div class="def"></div>
    <div class="left flex flex-col flex-shrink-0">
        <div><?php require './football/left-nav/countries.php'; ?></div>
    </div>
    <div class="flex-grow middle">
        <div>
            <div class="top-nav flex items-center mb-6 flex-wrap">
                <nav class="flex items-center nav2-top flex-grow md:justify-start">
                    <a href="./" class="home-nav <?=$f == 'all' ? 'active' : ''?>">ALL</a>
                    <a href="./?h=live" class="home-nav <?=$f == 'live' ? 'active' : ''?> ml-2">LIVE</a>
                    <a href="./blog" target= "_blank" class="hidden md:flex home-nav def <?=$f == 'blog' ? 'active' : ''?> ml-3">BLOG</a>
                </nav>
                <div class="calendar-navigator md:ml-auto mt-2 md:mt-0 mx-auto md:mx-0 flex relative <?=$f != 'all' ? 'hidden' : ''?>">
                    <div class="icon flex-shrink-0 items-center flex"><img src="files/assets/icons/angle-left.png" class="w-full" /></div>
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
                                <a href="./?date=<?=$date_string?>" class="<?=$date == $curr_date ? 'active' : ''?>" data-date="<?=$date_string?>" data-str="<?=date('Y-m-d', $date_string)?>"><?=$date?></a>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="icon flex-shrink-0 items-center flex"><img src="files/assets/icons/angle-right.png" /></div>
                </div>
            </div>
            <div class="data-table">
                <?php
                $endpoint = 'fixtures?date='.date('Y-m-d', $fixture_date);
                if($f == 'live') $endpoint = 'fixtures?live=all';
                // echo $endpoint;
                $data = $config->query($endpoint);
                if(!is_array($data)) {
                    $sorted = $config->sort_leagues($data);
                    // echo '<pre>';
                    // print_r($sorted);
                    // echo '</pre>';
                    $fixtures = $config->leagues(json_encode($sorted[0]));
                   //  $fixtures = $fixtures;
                   //  print_r(glob('*'));
                    // print_r($fixtures);
                    require "./football/home/$f.php";
                }
                ?>
            </div>
        </div>
    </div>
    <div class="right flex-shrink-0"><div><?php require "football/right.php"; ?></div></div>
</main>



</body>
</html>



